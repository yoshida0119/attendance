<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time', function (Blueprint $table) {
            $table->increments('time_id');
            //社員番号
            $table->integer('staff_id')->unsigned();
            //勤務日
            $table->date('work_dt');
            //勤務開始時間
            $table->time('start_time');
            //勤務終了時間
            $table->time('end_time');
            //休憩時間
            $table->time('break_time')->nullable();
            //欠勤フラグ
            $table->integer('absence_flg')->nullable();
            //削除フラグ
            $table->integer('del_flg')->nullable();
            $table->timestamps();
            //外部参照キー
            //staff.idとsaff_idを外部キーとして設定
            //テーブル名_idでプライマリーキーが自動で認識される
            $table->foreign('staff_id')->references('id')->on('staff');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time');
    }
}
