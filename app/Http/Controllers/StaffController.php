<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StaffRequest;
use App\Staff;
use App\Dept;
use App\Time;
use DB;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     * 初期値
     * @return \Illuminate\Http\Response
     */
    public function index(Staff $staff)
    {
        $staff = $staff::all();
        return view('staff.index',compact('staff'));
    }

    /**
     * Show the form for creating a new resource.
     * 入力画面
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dept = Dept::all();
        return view('staff.create',compact('dept'));
    }

    /**
     * 登録処理
     * @param StaffRequest $request
     * @param Staff $staff
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StaffRequest $request, Staff $staff)
    {
        DB::beginTransaction();
        try {
            $staff::create([
                "staff_name" => $request->staff_name,
                "dept_id"    => $request->dept_id
            ]);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        return redirect()->route('staff.index');
    }

    /**
     * Display the specified resource.
     * 詳細画面
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('staff.show');
    }

    /**
     * 編集画面
     * @param Staff $staff
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Staff $staff)
    {
        // $this->authorize('edit',$staff);
        $dept = Dept::all();
        return view('staff.edit',compact('staff','dept'));
    }

    /**
     * 更新処理
     * @param StaffRequest $request
     * @param Staff $staff
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StaffRequest $request, Staff $staff)
    {
        //認証処理確認
        // $this->authorize('edit',$staff);
        DB::beginTransaction();
        try {
            $staff->update(["staff_name" => $request->staff_name, "id" => $request->id]);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        return redirect()->route('staff.index');
    }

    /**
     * 削除処理
     * @param Staff $staff
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id,Request $request)
    {
        if(Time::where('staff_id',$id)->count() > 0){
            $message = "使用されているスタッフは削除できません。";
            return redirect()->route('staff.index')->with(compact('message'));
        }

        DB::beginTransaction();
        try {
            $staff = Staff::find($id);
            //削除処理
            $staff->delete();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        $message = "削除が完了しました。";
        return redirect()->route('staff.index')->with(compact('message'));
    }
}
