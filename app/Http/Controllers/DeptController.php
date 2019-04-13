<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DeptRequest;
use App\Dept;
use App\Staff;
use DB;

class DeptController extends Controller
{
    /**
     * Display a listing of the resource.
     * 初期値
     * @return \Illuminate\Http\Response
     */
    public function index(Dept $dept)
    {
        $deptArray = $dept::all();
        return view('dept.index',compact('deptArray'));
    }

    /**
     * Show the form for creating a new resource.
     * 入力画面
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('dept.create');
    }

    /**
     * 登録処理
     * @param DeptRequest $request
     * @param Dept $dept
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DeptRequest $request, Dept $dept)
    {
        //
        DB::beginTransaction();

        try {
            $dept::create(["dept_name" => $request->dept_name]);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        return redirect()->route('dept.index');
    }

    /**
     * Display the specified resource.
     * 詳細画面
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return view('dept.show');
    }

    /**
     * 編集画面
     * @param Dept $dept
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Dept $dept)
    {
        // $this->authorize('edit',$dept);
        return view('dept.edit',compact('dept'));
    }

    /**
     * 更新処理
     * @param DeptRequest $request
     * @param Dept $dept
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(DeptRequest $request, Dept $dept)
    {
        //認証処理確認
        // $this->authorize('edit',$dept);
        DB::beginTransaction();
        try {
            $dept->update(["dept_name" => $request->dept_name]);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        // $dept->dept_name = $request->dept_name;
        // $dept->save();
        return redirect()->route('dept.index');
    }

    /**
     * 削除処理
     * @param Dept $dept
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id, Request $request)
    {
        if(Staff::where('dept_id',$id)->count() > 0){
            $message = "使用されている部署名は削除できません。";
            //使用されている部署コードは削除できない
            return redirect()->route('dept.index')->with(compact('message'));
        }
        DB::beginTransaction();
        try {
            $deptModel = new Dept;
            $dept = $deptModel::find($id);
            //削除処理
            $dept->delete();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        $message = "削除が完了しました。";
        return redirect()->route('dept.index')->with(compact('message'));
    }
}
