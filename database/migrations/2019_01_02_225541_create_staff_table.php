<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            //社員no
            $table->increments('id');
            //社員名
            $table->string('staff_name');
            //部署コード
            $table->integer('dept_id')->unsigned();
            //削除フラグ
            $table->integer('del_flg')->nullable();
            $table->timestamps();

            //外部参照キー
            //dept.idとdept_idを外部キーとして設定
            //テーブル名_idでプライマリーキーが自動で認識される
            $table->foreign('dept_id')->references('id')->on('dept');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff');
    }
}
