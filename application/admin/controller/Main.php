<?php

namespace app\admin\controller;

<<<<<<< HEAD
use think\Db;
use think\Request;
use think\Session;
use think\Controller;

class Main extends controller
{


    public function logindo(Request $request)
    {


        $p = $request->post();
        $username = $p['username'];
        $userpass = $p['userpass'];
        //验证
        $data = Db::name('user')->where('username',$username)->find();

        if(empty($data))
        {
            return $this->error('用户名不存在', url('admin/index/index'));
            exit;

        }

        if($data['userpass'] != md5($userpass))
        {
            return $this->error('密码不正确', url('admin/index/index'));
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
        // var_dump($nodelist);
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

        return $this->success('登录成功', url('admin/main/index'));


    }




    public function logout()
    {
        Session::delete('userData');
=======
use think\Controller;

class Main extends Controller
{
    /**
     * 后台登录处理
     * @return \think\response\View
     */
    public function logindo()
    {
        return $this->fetch('admin@Main/index');
    }
    /**
     * 后台登出处理
     * @return \think\response\View
     */
    public function logout()
    {
>>>>>>> 8aa8129c464630872995f1daeb3f6430c7bedb79
        return $this->redirect('admin/index/index');
    }

    /**
     * 后台主页
     * @return \think\response\View
     */
    public function index()
    {
        return view('admin@main/index');
    }

}
