<?php
namespace App\Services;

use App\Services\DateService;
use App\Staff;
use App\Time;
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
        //今日の日付取得
        $today = $this->dateService->getToday();

        $timeModel = new Time;
        $todayStaff = $timeModel->with('staff')->where('work_dt',$today)->get();
        return $todayStaff;
    }

    /**
     * 月の出勤スタッフ情報を取得
     * @return void
     */
    public function getMonthlyWorkSchdule(String $targetYear, String $targetMonth){
        $staff = Time::where('work_dt', 'like', '%' . $targetYear . '-' . $targetMonth . '%')->get();
        return $staff;
    }

    /**
     * 指定日から一週間分のスケジュールを取得
     * @return Class 指定日から一週間分の出勤情報
     */
    public function selectScheduleForOneWeek($targetDay){
        //最終日
        $startDay = $targetDay;
        $targetDay = strtotime($targetDay);
        //一週間後の日付
        $endDay = date('Y-m-d', strtotime('+7 days', $targetDay));

        return Time::whereBetween('work_dt',array($startDay, $endDay));
    }

    /**
     * 対象スタッフの一週間分の勤務スケジュール取得
     * @param String $id スタッフID
     * @param Class $request
     * @return Array $time
     */
    public function selectStaffSchedule($id, $request){
        //スタッフ情報取得
        $staff = Staff::where('id',$id)->first();
        //勤務情報取得
        $tmpTime  = Time::where('staff_id',$id);

        //一週間分の勤務情報を格納してviewへ渡す
        $time = array();
        for ($i = 0; $i <= 6; $i++){
            //クラスを直接触ると値が変わるためクローン作成
            $timeClass = clone $tmpTime;
            //今日から順に+1した日付を取得
            $time[$i]['work_dt'] = date("Y-m-d" , strtotime('+' . $i . ' day'));
            if($timeClass->where('work_dt',$time[$i]['work_dt'])->count() > 0){
                //対象の日付が出勤日の場合
                $timeClass = $timeClass->where('work_dt',$time[$i]['work_dt'])->first();
                $time[$i]['start_time'] = $timeClass->start_time;
                $time[$i]['end_time'] = $timeClass->end_time;
            }else{
                //出勤日でない場合
                $time[$i]['start_time'] = "";
                $time[$i]['end_time']   = "";
            }
        }
        return $time;
    }

    /**
     * 複数ユーザーの一週間分スケジュールisert
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
