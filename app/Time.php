<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    //
    protected $table = 'time';
    //更新無効
    public $timestamps = true;

    //変更可能項目
    protected $guarded = ['time_id','created_at','updated_at'];

    /**
     * @return void
     */
    public function staff()
    {
        //where dept_id
        return $this->belongsTo('App\Staff');
    }

    /**
     * 時：分の形式で取得する アクセサ機能を使用し取得時に自動実行
     * @param $value
     * @return String
     */
    public function getStartTimeAttribute($value){
        return date('H:i', strtotime($value));
    }

    /**
     * 時：分の形式で取得する アクセサ機能を使用し取得時に自動実行
     * @param $value
     * @return String
     */
    public function getEndTimeAttribute($value){
        return date('H:i', strtotime($value));
    }
}
