<?php

namespace app\admin\controller;

use think\Db;
use think\Request;


class Role extends AdminController
{
    public function index()
    {
        $list = Db::name('role')->select();

        foreach($list as $v){
            $node_ids = Db::name('role_node')->field('nid')
                ->where(array('rid'=>array('eq',$v['id'])))
                ->select();
            $roles = array();
            foreach ($node_ids as $value) {
                $roles[] = Db::name('node')
                    ->where(array('id'=>array('eq',$value['nid'])))
                    ->value('name');
            }
            $v['role'] = $roles;
            $arr[] = $v;
        }
        // var_dump($arr);
        // exit;
        return view('role/index',[
            'list'=> $arr
        ]);
    }

    public function add()
    {
        return view('role/add');
    }

    public function save (Request $request)
    {
        // var_dump($_POST);
        $p = $request->post();
        // var_dump($p);
        //处理数据

        $data = [
            'name' => $p['name'],
            'status' => $p['status'],
            'remark' => $p['remark']

        ];
        $result = Db::name('role')->data($data)->insert();
        if ($result) {
            return $this->success('添加成功', url('admin/role/index'));
        }else{
            return $this->error('添加失败', url('admin/role/add'));

        }


    }




    public function delete($id)
    {
        // var_dump($id);
        $result = Db::name('role')->delete($id);

        if ($result>0) {
            return $this->success('删除成功', url('admin/role/index'));
        }else{
            return $this->error('删除失败', url('admin/role/index'));

        }
    }
    public function edit ($id)
    {
        $data = Db::name('role')->find($id);
        // var_dump($data);
        return view('role/edit',[
            'data'=> $data
        ]);
    }

    public function update (Request $request,$id)
    {

        $p = $request->post();
        // var_dump($p);
        //处理数据
        // exit;
        $data = [
            'name' => $p['name'],
            'status' => $p['status'],
            'remark' => $p['remark']

        ];
        $result = Db::name('role')->where('id',$id)->update($data);
        if ($result) {
            return $this->success('修改成功', url('admin/role/index'));
        }else{
            return $this->error('修改失败', url('admin/role/add'));

        }


    }

    public function nodelist($id)
    {

        //当前角色信息
        $role = Db::name('role')->where('id',$id)->find();

        //获取权限所有信息
        $list = Db::name('node')->select();
        $num = Db::name('node')->count();
                //获取当前角色的权限信息
        $nodelist = Db::name('role_node')->where('rid',$id)->select();
        // var_dump($nodelist);
        // exit;
        $mynode = array();
        foreach ($nodelist as $v) {
            $mynode[] = $v['nid'];
        }



        return view('role/nodelist',[
            'role' => $role ,
            'list' => $list,
            'mynode' => $mynode,
            'num' => $num

        ]);

    }

    public function nodeupdate(Request $request)
    {
        $p = $request->post();
        $rid = $p['rid'];

        //消除用户角色信息
        Db::name('role_node')->where(array('rid'=>array('eq',$rid)))->delete();
        foreach($p['node'] as $val){
            $data['rid'] = $rid;
            $data['nid'] = $val;

            $add = Db::name('role_node')->data($data)->insert();

        }

        if ($add) {
            return $this->success('修改权限成功', url('admin/user/index'));
        }else{
            return $this->error('修改权限失败', url('admin/user/index'));

        }
    }



}
