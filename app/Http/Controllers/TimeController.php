<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Staff;
use App\Dept;
use App\Time;
use App\Services\TimeService;
use App\Services\DateService;
use App\Http\Requests\TimeRequest;

class TimeController extends Controller
{
    protected $dept;
    protected $staff;
    protected $time;
    protected $timeService;
    protected $dateService;

     /**
      * 初期処理
      * @param DateService $dateService
      */
    public function __construct(TimeService $timeService,Staff $staff, Dept $dept, Time $time, DateService $dateService){
        $this->dept        = $dept;
        $this->staff       = $staff;
        $this->time        = $time;
        $this->timeService = $timeService;
        $this->dateService = $dateService;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     * description : 本日の出勤状況
     */
    public function index()
    {
        //本日出勤者取得
        $todayStaff = $this->timeService->getTodayStaff();
        return view('time.index',compact('todayStaff'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $staff = Staff::all();
        return view('time.create',compact('staff'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //一週間分のスケジュールを登録
        $insData = $request->all();
        $this->timeService->insertScheduleForOneWeek($insData);
        return redirect()->route('time.index');
    }

    /**
     * @param $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        //一週間分の勤務情報を格納してviewへ渡す
        $time = $this->timeService->selectStaffSchedule($id, $request);
        //スタッフ情報取得
        $staff = $this->staff->where('id',$id)->first();
        return view('time.edit',compact('staff','time'));
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(TimeRequest $request, $id)
    {
        $this->timeService->insertScheduleForOneWeek($request->all());
        return redirect()->route('time.edit' , ['id' => $id]);
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function showMonth(){

        //月取得
        $year = date("Y");
        //日取得
        $month = date("m");
        $currentMonth = $month;
        //カレンダー情報取得
        $dates = $this->dateService->getCalendarDates($year, $month);
        //指定月スタッフ情報取得
        $staffs = $this->timeService->getMonthlyWorkSchdule($year, $month);
        return view('time.show-month',compact('dates','currentMonth', 'staffs'));
    }
}
