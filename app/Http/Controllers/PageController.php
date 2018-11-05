<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/23
 * Time: 10:42
 */

namespace App\Http\Controllers;


use App\Coo;
use App\Group;
use App\Poi;
use App\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * 测试
     */
    public function test1()
    {
        return view('test.test1');
    }

    /**
     * 首页
     */
    public function index()
    {
        return view('common.index');
    }
    /**
     * 用户列表，分页10
     */
    public function userList()
    {
        $user = User::paginate(10);
        return view('user.list',['users' => $user]);
    }
    /**
     *用户在线列表
     */
    public function  userOnlineList()
    {
        $user = User::where('status' ,'=', '1')->get();
        if ($user->isEmpty()){
            return redirect('userOnlineList')->with('error','查询结果不存在');
        }
        else{
            return view('user.online',['users' => $user]);
        }
    }
    /**
     * 添加用户
     */
    public function userAdd()
    {
        return view('user.add');
    }

    /**
     * 显示用户详细资料
     */
    public function userDetail($uid)
    {
        $users = User::find($uid);
        return view('user.detail',[
            'users'=>$users
        ]);

    }

    /**
     * 更新用户资料
     */
    public function userUpdate(Request $request,$uid)
    {
        $users = User::find($uid);
        //控制器验证，如果通过继续往下执行，如果没通过抛出异常返回当前视图。
        if ($request->isMethod('POST')){
            $this->validate($request,[
                'username'=>'required',
                'password'=>'required',
                'email'   =>'required',
                'sex'     =>'required',
                'mobile'  =>'required',
            ],[
                'required'=>':attribute 为必填项'
            ],[
                'username'=>'用户名',
                'password'=>'密码',
                'email'   =>'email',
                'sex'     =>'性别',
                'mobile'  =>'手机号',
            ]);
        }
        if ($request->isMethod('POST')){
            $username = $request->input('username');
            $password = $request->input('password');
            $email    = $request->input('email');
            $sex      = $request->input('sex');
            $group_id = $request->input('group_id');
            $tel_number = $request->input('mobile');
            $address = $request->input('address');

            $users->username = $username;
            $users->password = $password;
            $users->sex = $sex;
            $users->email = $email;
            $users->group_id = $group_id;
            $users->tel_number = $tel_number;
            $users->address = $address;
            if ($users->save()){
                return redirect('userList')->with('success','修改成功-'.$uid);
            }
        }

        return view('user.update',[
            'users'=>$users
        ]);

    }


    /**
     * 兴趣点图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function poiMap()
    {
        $pois = Poi::all();
        return view('map.poimap',['pois' => $pois]);
    }

    /**
     * 普通图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function normalMap()
    {
        return view('map.normalmap');
//        return view('test.normalmap');
    }

    /**
     * 路网图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function routeMap()
    {
        return view('map.routemap');
    }
    /**
     * 热力图
     */
    public function heatMap()
    {
        return view('map.heatmap');
    }

    /**
     * wifi信号强度热力图
     */
    public function wifiSignalHeatMap()
    {
        return view('heatmap.wifiSignalHeatMap');
    }
    /**
     * 蓝牙信号强度热力图
     */
    public function bluSignalHeatMap()
    {
        return view('heatmap.bluSignalHeatMap');
    }
    /**
     * GDOP热力图
     */
    public function gdopHeatMap(){
        return view('heatmap.gdopHeatMap');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * hdop
     */
    public function hdopHeatMap(){
        return view('heatmap.hdopHeatMap');
    }
    public function pdopHeatMap(){
        return view('heatmap.pdopHeatMap');
    }
    public function vdopHeatMap(){
        return view('heatmap.vdopHeatMap');
    }
    public function rssHeatMap(){
        return view('heatmap.rssHeatMap');
    }
    /**
     * 历史轨迹图
     */
    public function userTrail()
    {

        $uid = rq('uid');
        $startTime = rq('startTime');//"2018-10-22 11:36:07";//rq('startTime');
        $endTime = rq('endTime');//"2018-10-22 11:38:19";//rq('endTime');
        if ($startTime== '' or $endTime == ''){
            return '输入时间段为空';
        }
        $userPositionList = Coo::where('uid' ,'=', $uid)->where('created_at', '>=', $startTime)->where('created_at', '<=', $endTime)->get();
        if ($userPositionList->isEmpty()){
            return '输入有误或该时间段内没有数据';
        }
        return view('map.userTrail',['userPositionLists' => $userPositionList]);
    }

    /**
     * 测试轨迹
     */
    public function userTrail1()
    {
        return view('test.userTrail1');
    }

    /**
     * 名称查询
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function nameSearch()
    {
        return view('search.nameSearch');
    }

    /**
     * 扩展查询
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function extentSearch()
    {
        return view('search.extentSearch');
    }

    /**
     * 云推送私信
     */
    public function pushToOne()
    {
//        $user = User::where('status' ,'=', '1')->paginate(5);
        $user = User::paginate(5);
        if ($user->isEmpty()){
            return redirect('pushToOne')->with('error','当前无用户在线');
        }
        else{
            return view('push.one2one',['users' => $user]);
        }
    }

    /**
     *云推送群发
     */
    public function pushToMore()
    {
        $group = Group::all();
        return view('push.one2more',['groups' => $group]);

    }

}