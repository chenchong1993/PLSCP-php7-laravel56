<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/20
 * Time: 10:42
 * 用户群组模型，对应的数据库里用户群组内容
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
class Group extends Model
{
    protected $table = "group";
    public $primaryKey = 'gid';
    public $timestamps =  false;
}