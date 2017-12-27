<?php

namespace app\admin\controller;

<<<<<<< HEAD

use think\Request;
use think\Db;



class Node extends AdminController
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
        $result = Db::name('node')->insert($data);
        if ($result) {
            return $this->success('添加成功', url('admin/node/index'));
        }else{
            return $this->error('添加失败', url('admin/node/add'));

        }


    }

    public function delete($id)
    {
        // var_dump($id);
        $result = Db::name('node')->delete($id);

        if ($result>0) {
            return $this->success('删除成功', url('admin/node/index'));
        }else{
            return $this->error('删除失败', url('admin/node/index'));

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
=======
use think\Controller;
use think\Request;
use think\Db;
class Node extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list= Db::name('node')->select();
        // var_dump($result);
        return view('node/index',[
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
        return view('node/add');
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
        $result = Db::name('node')->insert($p);
        if ($result > 0)
        {
            return $this->success('添加成功(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 起飞！', url('admin/node/index'));
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
        $data = Db::name('node')->find($id);

        return view('node/edit',[
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
>>>>>>> 8aa8129c464630872995f1daeb3f6430c7bedb79
        $data = [
            'name' => $p['name'],
            'mname' => $p['mname'],
            'aname' => $p['aname'],
            'status' => $p['status']
<<<<<<< HEAD

        ];
        $result = Db::name('node')->where('id',$id)->update($data);
        if ($result) {
            return $this->success('修改成功', url('admin/node/index'));
        }else{
            return $this->error('修改失败', url('admin/node/add'));

        }


=======
        ];
        $result = Db::name('node')->where('id' , $id)->update($data);
        if ($result > 0)
        {
            return $this->success('修改成功(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 起飞！', url('admin/node/index'));
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
        $result = Db::name('node')->delete($id);
        if ($result > 0)
        {
            return $this->success('删除成功',url('admin/node/index'));
        }else{
            return $this->error('删除失败',url('admin/node/index'));
        }
>>>>>>> 8aa8129c464630872995f1daeb3f6430c7bedb79
    }
}
