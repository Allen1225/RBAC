<?php

namespace app\admin\controller;

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
