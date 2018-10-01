<?php

/**
 * 用户模型，对应数据库内用户内容
 * 看看同步了没有
 */

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = "user";
    public $primaryKey = 'uid';
    public $timestamps =  false;
    protected $casts=[
        'uid' =>'string',
    ];
    protected  function getDateTime($val)
    {
        return time();
    }
    protected function asDateTime($value)
    {
        return $value;
    }
}
