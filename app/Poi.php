<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/9
 * Time: 15:31
 * 兴趣点模型，对应数据库里用户兴趣点内容
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Poi extends Model
{
    protected $table = "poi";
    public $primaryKey = 'id';
    public $timestamps =  false;

}