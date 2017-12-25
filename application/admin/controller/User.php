<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;
class user extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list= Db::name('user')->select();
        // var_dump($result);
        return view('user/index',[
            'list' => $list
        ]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return view('user/add');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
       $p =  $request->post();
        // $data = [
        //     'username' => $p['username'],
        //     'name' => $p['name'],
        //     'userpass' => $p['userpass']
        // ];
        $result = Db::name('user')->insert($p);
        if ($result > 0)
        {
            return $this->success('添加成功(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 起飞！', url('admin/user/index'));
        }else{
            return $this->error('添加失败(o＞ω＜o)雅蠛蝶');
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $data = Db::name('user')->find($id);

        return view('user/edit',[
            'data' => $data
            ]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        $p = $request->post();
        $data = [
           'username' => $p['username'],
           'name' => $p['name']
        ];
        $result = Db::name('user')->where('id' , $id)->update($data);
        if ($result > 0)
        {
            return $this->success('修改成功(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 起飞！', url('admin/user/index'));
        }else{
            return $this->error('修改失败(o＞ω＜o)雅蠛蝶');
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function del($id)
    {
        $result = Db::name('user')->delete($id);
        if ($result > 0)
        {
            return $this->success('删除成功',url('admin/user/index'));
        }else{
            return $this->error('删除失败',url('admin/user/index'));
        }
    }
}
