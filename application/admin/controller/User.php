<?php

namespace app\admin\controller;

use think\Paginator;
use think\paginator\driver\Bootstrap;
use think\Request;
use think\Db;
use think\Session;
use think\Controller\redirect;

class User extends AdminController
{

    public function index()
    {
        $list = Db::name('user')->field('id,username,name')->paginate(3);
        // $data = Db::name('user')->field('id,username,name')->paginate(1);
        // var_dump($data);die;
        foreach($list as $v){
            $role_ids = Db::name('user_role')->field('rid')
                ->where(array('uid'=>array('eq',$v['id'])))
                ->select();
            $roles = array();
            foreach ($role_ids as $value) {
                $roles[] = Db::name('role')
                    ->where(array('id'=>array('eq',$value['rid'])))
                    ->value('name');
            }
            $v['role'] = $roles;
            $arr[] = $v;
        }

        return view('user/index',[
            'list'=> $arr,
            'data'=> $list
        ]);
    }


    public function add()
    {
        return view('user/add');
    }

    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save (Request $request)
    {

        $p = $request->post();

        //处理数据
        $data = [
            'username' => $p['username'],
            'name' => $p['name'],
            'userpass' => md5($p['userpass']),
            'userpass2' => md5($p['userpass2'])
        ];
        if ($data['userpass'] != $data['userpass2'])
        {
            echo "<script>alert('密码不一致');window.history.back(-1);</script>";
        }else{
            $result = Db::name('user')->data($data)->insert();
            if ($result) {
                // echo '<script>alert</script>';
                return $this->success('添加成功', url('admin/user/Index'));
            }else{
                return $this->error('添加失败', url('admin/user/add'));

            }
        }

    }

    public function delete($id)
    {
        $uid = Db::name('user_role')->where('uid','=',$id)->select();

        foreach($uid as $v)
        {
            $uids = $v['uid'];
        }

        if(!(empty($uids))){
            Db::name('user_role')->where('uid','=',$uids)->delete();

            $result = Db::name('user')->delete($id);

            if ($result > 0) {
                $info['status'] = true;
                $info['id'] = $id;
                $info['info'] = 'ID为: ' . $id . '的用户删除成功!';
            } else {
                $info['status'] = false;
                $info['id'] = $id;
                $info['info'] = 'ID为: ' . $id . '的用户删除失败,请重试!';
            }
            return json($info);

        }else{
            $result = Db::name('user')->delete($id);

            if ($result > 0) {
                $info['status'] = true;
                $info['id'] = $id;
                $info['info'] = 'ID为: ' . $id . '的用户删除成功!';
            } else {
                $info['status'] = false;
                $info['id'] = $id;
                $info['info'] = 'ID为: ' . $id . '的用户删除失败,请重试!';
            }
            return json($info);
        }

    }


    public function edit ($id)
    {
        $data = Db::name('user')->find($id);
        // var_dump($data);
        return view('user/edit',[
            'data'=> $data
        ]);
    }

    public function update (Request $request,$id)
    {

        $p = $request->post();
        // var_dump($p);
        //处理数据
        $data = [
            'username' => $p['username'],
            'name' => $p['name']

        ];
        $result = Db::name('user')->where('id',$id)->update($data);
        if ($result) {
            return $this->success('修改成功', url('admin/user/Index'));
        }else{
            return $this->error('修改失败', url('admin/user/Index'));

        }

    }

    public function rolelist($id)
    {

        //当前用户信息
        $user = Db::name('user')->where('id',$id)->find();

        //获取角色信息
        $list = Db::name('role')->select();

        //获取 当前用户角色信息
        $rolelist = Db::name('user_role')->where('uid',$id)->select();
        // var_dump($rolelist);
        // exit;
        $myrole = array();
        foreach ($rolelist as $v) {
            $myrole[] = $v['rid'];
        }
        // var_dump($myrole);
        // exit;


        return view('user/rolelist',[
            'user' => $user ,
            'list' => $list,
            'myrole' => $myrole

        ]);

    }

    public function roleupdate(Request $request)
    {
        $p = $request->post();

        //消除用户角色信息

        $uid = $p['uid'];

        Db::name('user_role')->where(array('uid'=>array('eq',$uid)))->delete();
        if(empty($p['role'])){
            return $this->success('修改角色成功', url('admin/user/Index'));
        }else{
        foreach($p['role'] as $val){
            $data['uid'] = $uid;
            $data['rid'] = $val;
            $add = Db::name('user_role')->data($data)->insert();
        }
        }
        if ($add) {
            return $this->success('修改角色成功', url('admin/user/Index'));
        }else{
            return $this->error('修改角色失败', url('admin/user/Index'));
        }
    }

    /**用户搜索
     * @param Request $request
     * @return \think\response\View
     */
    public function search(Request $request)
    {

        $p = $request->post();

        if(isset($p['search'])){
            $data = Db::name('user')->where('username','=',$p['search'])->select();
        }else{
            return $this->redirect('user/index');
        }
        if(empty($data)){
            echo  '<script>alert("没有匹配的用户");</script>';
            $list = Db::name('user')->field('id,username,name')->paginate(3);
            // $data = Db::name('user')->field('id,username,name')->paginate(1);
            // var_dump($data);die;
            foreach($list as $v){
                $role_ids = Db::name('user_role')->field('rid')
                    ->where(array('uid'=>array('eq',$v['id'])))
                    ->select();
                $roles = array();
                foreach ($role_ids as $value) {
                    $roles[] = Db::name('role')
                        ->where(array('id'=>array('eq',$value['rid'])))
                        ->value('name');
                }
                $v['role'] = $roles;
                $arr[] = $v;
            }

            return view('user/index',[
                'list'=> $arr,
                'data'=> $list
            ]);
        }

        $datas = array();
        foreach($data as $v)
        {
            $datas = [
                'id'=>$v['id'],
                'username'=>$v['username'],
                'name'=>$v['name']
            ];
        }
        if($p['search'] == $datas['username'])
        {
            $list = Db::name('user')->where('username','=',$datas['username'])->select();
            foreach($list as $v){
                $role_ids = Db::name('user_role')->field('rid')
                    ->where(array('uid'=>array('eq',$v['id'])))
                    ->select();
                $roles = array();
                foreach ($role_ids as $value) {
                    $roles[] = Db::name('role')
                        ->where(array('id'=>array('eq',$value['rid'])))
                        ->value('name');
                }
                $v['role'] = $roles;
                $arr[] = $v;
            }
        }
        return view('search/user',[
            'list'=>$arr
        ]);
    }
}
