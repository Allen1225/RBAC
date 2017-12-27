<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Session;

class AdminController extends Controller
{

    public function _initialize()
    {


        if(empty(Session::get('userData')))
        {
            $this->redirect("index/index");
        }
        // $request = Request::instance();
        // var_dump(Session::get('userData.nodelist'));
        // die;
        $data = request();
        $mname = $data->controller();
        $aname = $data->action();
        $nodelist = Session::get('userData.nodelist');
        // var_dump(Session::get('userData'));
        // die;
        $username = Session::get('userData.username');
        if($username != 'admin'){
            //验证操作权限
            // dump($nodelist[$mname]);
            // die;
            if(empty($nodelist[$mname]) ||  !in_array($aname,$nodelist[$mname])){

                $this->error("抱歉！没有操作权限！");
                exit;
            }

        }


    }

}
