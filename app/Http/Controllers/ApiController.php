<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/23
 * Time: 10:42
 */

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ApiController extends Controller
{
    /**
     * 用户注册接口
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function apiUserAdd(Request $request)
    {

        //控制器验证，如果通过继续往下执行，如果没通过抛出异常返回当前视图。
        if ($request->isMethod('POST')){
            $this->validate($request,[
                'username'=>'required',
                'password'=>'required',
                'email'   =>'required',
                'sex'     =>'required',
                'mobile'     =>'required',
            ],[
                'required'=>':attribute 为必填项'
            ],[
                'username'=>'用户名',
                'password'=>'密码',
                'email'   =>'email',
                'sex'     =>'性别',
                'mobile'     =>'手机号',
            ]);
        }
//从表单视图传过来的输入信息
        $username = $request->input('username');
        $password = $request->input('password');
        $email    = $request->input('email');
        $sex      = $request->input('sex');
        $mobile      = $request->input('mobile');
        if ($sex==10) {
            $sex="保密";
        }
        elseif ($sex==20) {
            $sex="男";
        }
        else{
            $sex="女";
        }

//获取uid的过程如下。

//如果接口返回的数据为json，这里需要先定义数据类型为json
        $url = "http://121.28.103.199:5583/service/user/v1/signup?appid=10";
        $data = array('username'=>$username,'password'=>$password,'admin'=>false);
//调用封装的json请求方法
        $response = $this->apiPostJson($url,$data);
//将返回的字符串进行分析
        //1. 验证用户名是否重复
        //2. 截取出uid存入用户数据库
//两种返回结果
        //1. { "result": true, "error": "", "data": 30152179566247939 }
        //2. { "result": false, "error": "用户名已被占用", "data": null }
//判断是否注册成功
        if(strpos($response,"true")==false){
//            return redirect('PLSCP/USERcreate')->with('error','添加失败');
            if (strpos($response,"用户名已被占用")==false){
                return redirect('PLSCP/USER/add')->with('error','未知错误');
            }else{
                return redirect('PLSCP/USER/add')->with('error','用户名已被占用');
            }

        }else{
            $uid = substr($response, -19, 17);
            $users = new User();
            $users->uid = $uid;
            $users->username = $username;
            $users->password = $password;
            $users->sex = $sex;
            $users->email = $email;
            $users->tel_number = $mobile;
            if ($users->save()){
                return redirect('userList')->with('success','添加成功');
            }else{
                return redirect('userAdd')->with('error','数据库存储错误');
            }

        }

    }

    /**
     * 删除用户接口
     */
    public function apiUserDelete($uid)
    {
        echo $uid;
        $users = User::find($uid);
        if ($users->delete()){
            return redirect('userList')->with('success','删除成功-'.$uid);
        }else{
            return redirect('userList')->with('error','删除失败-'.$uid);
        }

    }

    /**
     * 查询结果接口
     */
    public function apiSearchResult(Request $request)
    {
        if ($request->isMethod('POST')){
            $this->validate($request,[
                'content'=>'required',
                'type'=>'required',
            ],[
                'required'=>':attribute 为必填项'
            ],[
                'content'=>'查询内容',
                'type'=>'查询类型',
            ]);
        }

        $content = $request->input('content');
        $type = $request->input('type');
        if ($type==10) {
            $type="username";
        }
        elseif ($type==20) {
            $type="address";
        }
        else{
            $type="物名";
        }

        $user = User::where($type ,'like', '%'.$content.'%')->get();
        if ($user->isEmpty()){
            return redirect('nameSearch')->with('error','查询结果不存在');
        }
        else{
            return view('search.Result',['users' => $user]);
        }

    }

    /**
     * 封装json格式的POST请求
     */
    public function apiPostJson($url,$data)
    {
        header("Content-type:application/json;charset=utf-8");
        //这里需要注意的是这里php会自动对json进行编码，而一些java接口不自动解码情况（中文）
        $json_data = json_encode($data,JSON_UNESCAPED_UNICODE);
//$json_data = json_encode($data);
//curl方式发送请求
        $ch = curl_init();
//设置请求为post
        curl_setopt($ch, CURLOPT_POST, 1);
//请求地址
        curl_setopt($ch, CURLOPT_URL, $url);
//json的数据
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//显示请求头
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
//请求头定义为json数据
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type:application/json;charset=utf-8',
                'Content-Length: '.strlen($json_data)
            )
        );
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    /**
     * 封装get请求
     */
    public function apiGetJson($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        //如果$data不为空,则为POST请求
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($error){
            throw new Exception('请求发生错误：' . $error);
        }
        $resultArr = json_decode($output, true);//将json转为数组格式数据
        return $resultArr;
    }

    /**
     * 修改用户资料接口 没用上
     */
    public function apiUserUpdate(Request $request,$uid)
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
}