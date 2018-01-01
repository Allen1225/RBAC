<?php

namespace app\admin\controller;

use think\Request;
use think\Db;
use think\Controller\redirect;

class Node extends AdminController
{
    public function index()
    {
        $list = Db::name('node')->field('id,name,mname,aname,status')->paginate(3);
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
            'aname' => $p['aname']
            // 'status' => $p['status']

        ];
        $result = Db::name('node')->insert($data);
        if ($result) {
            return $this->success('添加成功', url('admin/node/Index'));
        }else{
            return $this->error('添加失败', url('admin/node/add'));

        }


    }

    public function delete($id)
    {
        // var_dump($id);
        $result = Db::name('node')->delete($id);

        if ($result>0) {
            $info['status'] = true;
            $info['id'] = $id;
            $info['info'] = 'ID为: ' . $id . '的节点删除成功!';
        }else{
            $info['status'] = false;
            $info['id'] = $id;
            $info['info'] = 'ID为: ' . $id . '的节点删除失败,请重试!';
        }

        return json($info);

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
            'aname' => $p['aname']
            // 'status' => $p['status']
        ];
        $result = Db::name('node')->where('id' , $id)->update($data);
        if ($result > 0)
        {
            return $this->success('修改成功', url('admin/node/index'));
        }else{
            return $this->error('修改失败');
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
    }

    /**节点搜索
     * @param Request $request
     * @return \think\response\View
     */
    public function search(Request $request)
    {
        $p = $request->post();

        $lists = Db::name('node')->field('id,name,mname,aname,status')->paginate(3);

        if(isset($p['search'])){
            $list = Db::name('node')->where('name','=',$p['search'])->select();
        }else{
            return view('node/index',[
                'list'=>$lists
            ]);
        }

        if(empty($list)){
            echo '<script>alert("没有匹配的节点");</script>';
            // return $this->redirect('node/index');

            return view('node/index',[
                'list'=>$lists
            ]);
        }

        return view('search/node',[
            'list'=>$list
        ]);
    }
}
