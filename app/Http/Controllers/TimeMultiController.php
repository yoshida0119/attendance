<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DateService;
use App\Services\TimeService;
use test\Mockery\MockingProtectedMethodsTest;



class TimeMultiController extends Controller
{
    protected $dateService;
    protected $timeService;

    public function __construct(DateService $dateService, TimeService $timeService){
        $this->dateService = $dateService;
        $this->timeService = $timeService;
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     */
    public function show($targetDay)
    {
        //指定期間の勤務情報を取得する
        $staff = $this->timeService->selectScheduleForOneWeek($targetDay);
        ///指定の日付から一週間先までの情報を取得
        $weekArray = $this->dateService->getDateForOneWeek($targetDay);

        return view('time-multi.show',compact('targetDay', 'staff', 'weekArray'));
    }

    /**
     * @param $targetDay 日付
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($targetDay)
    {
        //指定期間の勤務情報を取得する
        $staff = $this->timeService->selectScheduleForOneWeek($targetDay);
        ///指定の日付から一週間先までの情報を取得
        $weekArray = $this->dateService->getDateForOneWeek($targetDay);

        return view('time-multi.edit',compact('targetDay', 'staff', 'weekArray'));
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     *          viewから取得する値
     *          staff_id[スタッフの数分]
     *          start_time[スタッフID][週のindex]
     *          end_time[スタッフID][週のindex]
     *          work_dt[スタッフID][週のindex]
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        //取得した値をすべて登録する
        $this->timeService->insertMultiStaffScheduleForWeek($request->all());
        /** @param $id 日付 */
        return redirect()->route('time-multi.edit',['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     */
    public function destroy($id)
    {
        //
    }
}
