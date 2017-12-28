<?php

namespace app\admin\controller;


use think\Session;
use app\admin\controller\AdminController;


class Index extends AdminController
{
    public function index()
    {
        if(!empty(Session::get('userData')))
        {
            return view('Index/index');
        }else{
            Session::delete();
            return view('Index/index');
        }
    }

    /**
     * 后台登录页面
     * @return \think\response\View
     */
    // public function index()
    // {
    //     return view('admin@index/login');
    // }
}
