<?php

namespace app\admin\controller;


use think\Request;
use think\Db;
use think\Session;

class User extends AdminController
{

    public function index()
    {


        $list = Db::name('user')->select();
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
        // var_dump($arr);
        // exit;

        return view('user/index',[
            'list'=> $arr
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

        // var_dump($p);
        //处理数据
        $data = [
            'username' => $p['username'],
            'name' => $p['name'],
            'userpass' => md5($p['userpass'])

        ];
        $result = Db::name('user')->data($data)->insert();
        if ($result) {
            return $this->success('添加成功', url('admin/user/Index'));
        }else{
            return $this->error('添加失败', url('admin/user/add'));

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
        $uid = $p['uid'];
        //消除用户角色信息
        Db::name('user_role')->where(array('uid'=>array('eq',$uid)))->delete();
        foreach($p['role'] as $val){
            $data['uid'] = $uid;
            $data['rid'] = $val;

            $add = Db::name('user_role')->data($data)->insert();

        }

        if ($add) {
            return $this->success('修改角色成功', url('admin/user/Index'));
        }else{
            return $this->error('修改角色失败', url('admin/user/Index'));

        }
    }

}
