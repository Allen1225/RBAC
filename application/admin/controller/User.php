<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

class User extends Controller
{

    public function index()
    {
        $list = Db::name('user')->select();
        return view('user/index',[
            'list'=> $list
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
            return $this->success('添加成功(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 飞天了！', url('admin/user/index'));
        }else{
            return $this->error('添加失败(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 坠机了！', url('admin/user/add'));

        }


    }

    public function delete($id)
    {
        // var_dump($id);
        $result = Db::name('user')->delete($id);

        if ($result>0) {
            return $this->success('删除成功(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 飞天了！', url('admin/user/index'));
        }else{
            return $this->error('删除失败(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 坠机了！', url('admin/user/index'));

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
            return $this->success('修改成功(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 飞天了！', url('admin/user/index'));
        }else{
            return $this->error('修改失败(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 坠机了！', url('admin/user/index'));

        }


    }
}
