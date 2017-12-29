<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Session;


class AdminController extends Controller
{
    /**空方法
     * @param Request $request
     * @return string
     */
    public function _empty(Request $request)
    {
        $a = $request->action();
        return ' 您当前访问的页面不存在';
    }


    public function _initialize()
    {
        //判断session是否存在
        // $data = Session::get('userData');
        // var_dump($data);die;
        if(empty(Session::get('userData')))
        {
            // var_dump(111);die;
            $this->redirect("Publics/login");
        }
        // $request = Request::instance();
        // var_dump(Session::get('userData.nodelist'));
        // die;

        $data = request();
        $mname = $data->controller();
        $aname = $data->action();
        $nodelist = Session::get('userData.nodelist');
        // var_dump($nodelist);
        // var_dump($mname);
        // var_dump($aname);
        //
        // die;
        $username = Session::get('userData.username');
        // var_dump($nodelist);
        // die;
        if($username != 'admin'){
            //验证操作权限

            if(empty($nodelist[$mname]) ||  !in_array($aname,$nodelist[$mname])){

                return $this->error("抱歉！没有操作权限！");
                exit;
            }
        }

    }

}
