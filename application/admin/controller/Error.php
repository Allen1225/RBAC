<?php

namespace app\admin\controller;
use think\Request;

class Error extends AdminController
{
    /**空控制器
     * @param Request $request
     * @return string
     */
    public function _empty(Request $request)
    {
        //根据当前控制器名来判断要执行那个城市的操作
        $cityName = $request->controller();
        return '你访问的页面不存在';
    }

}
