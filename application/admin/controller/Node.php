<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;


class Node extends Controller
{
    public function index()
    {
        $list = Db::name('node')->select();
        // $list = Db::name('hc_user')->field(['id', 'name'])->order('id', 'asc')->select();
        // var_dump($list);
        return view('node/index',[
            'list'=>$list
        ]);
    }
    public function add ()
    {

        return view('node/add');
    }

    public function save (Request $request)
    {

        $p = $request->post();
        // var_dump($p);
        //处理数据
        $data = [
            'name' => $p['name'],
            'mname' => $p['mname'],
            'aname' => $p['aname'],
            'status' => $p['status']

        ];
        $result = Db::name('node')->data($data)->insert();
        if ($result) {
            return $this->success('添加成功(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 飞天了！', url('admin/node/index'));
        }else{
            return $this->error('添加失败(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 坠机了！', url('admin/node/add'));

        }


    }

    public function delete($id)
    {
        // var_dump($id);
        $result = Db::name('node')->delete($id);

        if ($result>0) {
            return $this->success('删除成功(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 飞天了！', url('admin/node/index'));
        }else{
            return $this->error('删除失败(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 坠机了！', url('admin/node/index'));

        }
    }
    public function edit ($id)
    {
        $data = Db::name('node')->find($id);
        // var_dump($data);
        return view('node/edit',[
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
            'mname' => $p['mname'],
            'aname' => $p['aname'],
            'status' => $p['status']

        ];
        $result = Db::name('node')->where('id',$id)->update($data);
        if ($result) {
            return $this->success('修改成功(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 飞天了！', url('admin/node/index'));
        }else{
            return $this->error('修改失败(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 坠机了！', url('admin/node/add'));

        }


    }
}
