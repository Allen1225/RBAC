<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use think\Controller\redirect;
class Publics extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function login()
    {

        return view('publics/login');
    }
    //执行登录
    public function dologin(Request $request)
    {
        $data = $request->post();

        if(!captcha_check($data['yzm'])){
            // echo '123';die;
            return  $this->error('验证码不正确',url('admin/publics/login'));
        }

        $p = $request->post();
        $username = $p['username'];
        $userpass = $p['userpass'];
        //验证
        $data = Db::name('user')->where('username',$username)->find();

        if(empty($data))
        {
            return $this->error('用户名不存在', url('admin/publics/login'));
            exit;

        }

        if($data['userpass'] != md5($userpass))
        {
            return $this->error('密码不正确', url('admin/publics/login'));
            exit;
        }

        //保存在session 中
        Session::set('userData',$data);

        $list = Db::name('node')->field('mname,aname')
            ->where('id in'.Db::name('role_node')->field('nid')
                    ->where("rid in ".Db::name('user_role')->field('rid')
                    ->where(array('uid'=>array('eq',$data['id'])))
                    ->buildSql())
                    ->buildSql())
                    ->select();

        foreach ($list as $key => $val) {
            $list[$key]['mname'] = ucfirst($val['mname']);
        }

        $nodelist = array();
        $nodelist['Index'] = array('index');
        // var_dump($nodelist);die;
        // var_dump($list);
        // die;var_dump($nodelist);
        // var_dump($list);
        // die;

        foreach ($list as $v)
        {
            $nodelist[$v['mname']][] = $v['aname'];

            if($v['aname']=="edit"){
                $nodelist[$v['mname']][]="update";
            }
            if($v['aname']=="add"){
                $nodelist[$v['mname']][]="save";
            }
        }

        Session::set('userData.nodelist',$nodelist);
        // var_dump(Session::get('userData'));
        // die;

        // return $this->success('登录成功', url('admin/Main/Index'));

        $this->redirect('Index/index');
    }

    /**
     * 登出系统
     */
    public function logout()
    {
        Session::delete('userData');
        return view('Publics/login');
    }

    /**
     * 后台主页
     * @return \think\response\View
     */
    public function index()
    {
        return view('admin@Index/Index');
    }

}
