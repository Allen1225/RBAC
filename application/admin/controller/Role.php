<?php

namespace app\admin\controller;

use think\Db;
use think\Request;
use think\Controller\redirect;

class Role extends AdminController
{
    public function index()
    {
        $list = Db::name('role')->field('id,name,remark,status')->paginate(3);

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
        return view('role/Index',[
            'list'=> $arr,
            'data' => $list
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
        // var_dump($p);die;
        //处理数据

        $data = [
            'name' => $p['name'],
            // 'status' => $p['status'],
            'remark' => $p['remark']

        ];
        $result = Db::name('role')->data($data)->insert();
        if ($result) {
            return $this->success('添加成功', url('admin/role/Index'));
        }else{
            return $this->error('添加失败', url('admin/role/add'));

        }


    }




    public function delete($id)
    {

         $rid = Db::name('role_node')->where('rid','=',$id)->select();
        foreach($rid as $v)
        {
            $rids = $v['rid'];
        }

        if(!(empty($rids))){
            Db::name('role_node')->where('rid','=',$rids)->delete();
            $result = Db::name('role')->delete($id);

            if ($result>0) {
                $info['status'] = true;
                $info['id'] = $id;
                $info['info'] = 'ID为: ' . $id . '的角色删除成功!';
            }else{
                $info['status'] = false;
                $info['id'] = $id;
                $info['info'] = 'ID为: ' . $id . '的角色删除失败,请重试!';
            }

            return json($info);
        }else{
            $result = Db::name('role')->delete($id);

            if ($result>0) {
                $info['status'] = true;
                $info['id'] = $id;
                $info['info'] = 'ID为: ' . $id . '的角色删除成功!';
            }else{
                $info['status'] = false;
                $info['id'] = $id;
                $info['info'] = 'ID为: ' . $id . '的角色删除失败,请重试!';
            }
            return json($info);
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
        // var_dump($p);die;
        $data = [
            'name' => $p['name'],
            // 'status' => $p['status'],
            'remark' => $p['remark']

        ];
        $result = Db::name('role')->where('id',$id)->update($data);
        if ($result) {
            return $this->success('修改成功', url('admin/role/Index'));
        }else{
            return $this->error('修改失败', url('admin/role/Index'));

        }


    }

    public function nodelist($id)
    {
        //当前角色信息
        $role = Db::name('role')->where('id',$id)->find();

        //获取权限所有信息
        $list = Db::name('node')->select();

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
        ]);

    }

    public function nodeupdate(Request $request)
    {
        $p = $request->post();
        $rid = $p['rid'];
        // var_dump($p);die;
        //消除用户角色信息
        Db::name('role_node')->where(array('rid'=>array('eq',$rid)))->delete();
        if(empty($p['node'])){
            return $this->success('修改权限成功', url('admin/role/Index'));
        }else{
            foreach($p['node'] as $val){
                $data['rid'] = $rid;
                $data['nid'] = $val;
                $add = Db::name('role_node')->data($data)->insert();
            }
        }

        if ($add) {
            return $this->success('修改权限成功', url('admin/role/Index'));
        }else{
            return $this->error('修改权限失败', url('admin/role/Index'));

        }
    }

    public function search(Request $request)
    {
        $p = $request->post();

        if(isset($p['search'])){
            $data = Db::name('role')->where('name','=',$p['search'])->select();
        }else{
            return $this->redirect('role/index');
        }

        if(empty($data)){
            echo '<script>alert("没有匹配的角色");</script>';
            $list = Db::name('role')->field('id,name,remark,status')->paginate(3);
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
            return view('role/Index',[
                'list'=> $arr,
                'data' => $list
            ]);
        }

        $datas = array();
        foreach($data as $v)
        {
            $datas = [
                'id'=>$v['id'],
                'name'=>$v['name'],
                'remark'=>$v['remark']
            ];
        }

        if($p['search'] == $datas['name'])
        {

            $list = Db::name('role')->where('name','=',$datas['name'])->select();

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
        }
        return view('search/role',[
            'list'=> $arr
        ]);
    }
}
