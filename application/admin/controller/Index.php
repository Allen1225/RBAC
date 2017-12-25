<?php

namespace app\admin\controller;

class Index
{
    /**
     * 后台登录页面
     * @return \think\response\View
     */
    public function index()
    {
        return view('admin@index/login');
    }

}
