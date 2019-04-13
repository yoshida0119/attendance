<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Dept;

class Staff extends Model
{
    //
    protected $table = 'staff';
    //更新無効
    public $timestamps = true;

    //変更可能項目
    protected $fillable = ['staff_name','del_flg','dept_id'];

    public function dept()
    {
        //where dept_id
        return $this->belongsTo('App\Dept');
    }
}
