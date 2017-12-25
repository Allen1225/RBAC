<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;

class Role extends Controller
{
    public function index()
    {
        $list = Db::name('role')->select();
        return view('role/index',[
            'list'=> $list
        ]);
    }

    public function add()
    {
        return view('role/add');
    }

    public function save (Request $request)
    {

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
            return $this->success('添加成功(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 飞天了！', url('admin/role/index'));
        }else{
            return $this->error('添加失败(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 坠机了！', url('admin/role/add'));

        }


    }

    public function ss()
    {
        return '111';
    }


    public function delete($id)
    {
        // var_dump($id);
        $result = Db::name('role')->delete($id);

        if ($result>0) {
            return $this->success('删除成功(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 飞天了！', url('admin/role/index'));
        }else{
            return $this->error('删除失败(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 坠机了！', url('admin/role/index'));

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
        $data = [
            'name' => $p['name'],
            'status' => $p['status'],
            'remark' => $p['remark']

        ];
        $result = Db::name('role')->where('id',$id)->update($data);
        if ($result) {
            return $this->success('修改成功(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 飞天了！', url('admin/role/index'));
        }else{
            return $this->error('修改失败(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 坠机了！', url('admin/role/add'));

        }


    }



}