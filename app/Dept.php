<?php

namespace App;
use App\Staff;

use Illuminate\Database\Eloquent\Model;

class Dept extends Model
{
    protected $table = 'dept';
    //更新無効
    public $timestamps = true;
    //プライマリー
    // protected $primaryKey = "id";
    //フォーマット
    // protected $dateFormat = 'Y-m-d';

    //変更可能項目
    protected $fillable = ['dept_name','del_flg'];

    public function staff()
    {
        //where dept_id
        return $this->belongsTo('App\Staff');
    }

}
