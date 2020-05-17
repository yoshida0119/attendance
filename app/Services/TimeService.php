<?php
namespace App\Services;

use App\Services\DateService;
use App\Staff;
use App\Time;
use Carbon\Carbon;
use DB;
use App\Facades\Date;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * @param App\Services\TimeService
 */
class TimeService {

    public function __construct(DateService $dateService)
    {
        $this->dateService = $dateService;
    }

    /**
     * 本日の出勤者情報取得
     * @return Time[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTodayStaff()
    {
        return Time::with('staff')->where(
            'work_dt',$this->dateService->getToday())->get();
    }

    /**
     * 月の出勤スタッフ情報を取得
     * @return void
     */
    public function getMonthlyWorkSchdule(String $targetYear, String $targetMonth){
        return Time::where('work_dt', 'like', '%' . $targetYear . '-' . $targetMonth . '%')->get();
    }

    /**
     * 指定日から一週間分のスケジュールを取得
     * @return Class 指定日から一週間分の出勤情報
     */
    public function selectScheduleForOneWeek($targetDay){
        $endDay = date('Y-m-d', strtotime('+7 days', strtotime($targetDay)));
        return Time::whereBetween('work_dt',array(strtotime($targetDay), $endDay));
    }

    /**
     * 対象スタッフの今日から一週間分の勤務スケジュール取得
     * @param String $id スタッフID
     * @param Class $request
     * @return Array $time
     */
    public function selectStaffSchedule($id, $request){
        $toDay = Carbon::today()->format('Y/m/d');
        $endDay = Carbon::today()->addDay(7)->format('Y/m/d');
        return Time::select(['work_dt', 'start_time', 'end_time'])
            ->where('staff_id',$id)->whereBetween('work_dt', [$toDay, $endDay])->get();
    }

    /**
     * 複数ユーザーの一週間分スケジュールinsert
     * @return void
     */
    public function insertMultiStaffScheduleForWeek($request){
        //$insData[スタッフID]
        $insData = array();
        foreach ($request['staff_id'] as $key => $staffValue) {
            $insData['staff_id'] = $staffValue;
            //一週間分のデータを配列に格納
            for ($i=0; $i < 6; $i++) {
                $insData['work_dt'][$i]    = $request['work_dt'][$staffValue][$i];
                $insData['start_time'][$i] = $request['start_time'][$staffValue][$i];
                $insData['end_time'][$i]   = $request['end_time'][$staffValue][$i];
            }
            $this->insertScheduleForOneWeek($insData);
        }
    }

    /**
     * 一週間分のスケジュールを登録処理
     * @param array $insData
     *      [
     *      staff_id,
     *      work_dt[一週間分のindexキー],
     *      start_time[一週間分のindexキー],
     *      end_time[一週間分のindexキー],
     *      ]
     * @return bool
     */
    public function insertScheduleForOneWeek(Array $insData)
    {
        //count
        $insDataCount = count($insData['work_dt']);

        if($insDataCount == 0){
            return false;
        }

        $staffId = $insData['staff_id'];

        DB::beginTransaction();
            for ($i=0; $i < $insDataCount; $i++) {
                $timeModel = new Time;
                if(
                    (!empty($insData['work_dt'][$i]) && strlen($insData['work_dt'][$i]) > 0)
                    && (
                        (!empty($insData['start_time'][$i]) && strlen($insData['start_time'][$i]) > 0)
                        || (!empty($insData['end_time'][$i]) && strlen($insData['end_time'][$i]) > 0)
                    )
                ){
                    $dataArray = [
                        "staff_id"    => $staffId,
                        "work_dt"     => $insData['work_dt'][$i],
                        "start_time"  => $insData['start_time'][$i],
                        "end_time"    => $insData['end_time'][$i],
                        "break_time"  => 0,
                        "absence_flg" => 0,
                        "del_flg"     => 0,
                    ];
                    //既に登録されている場合はupdate
                    $exsistData = $timeModel
                                    ->where('work_dt',$insData['work_dt'][$i])
                                    ->where('staff_id',$staffId);
                    if(count($exsistData->get()) > 0){
                        //update
                        $exsistData->update($dataArray);
                    }else{
                        //isnert
                        $timeModel::create($dataArray);
                    }
                }//endif
            }
        try {
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
