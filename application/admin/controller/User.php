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
        $list = Db::name('user')->select();
        foreach($list as $v){
            $role_ids = Db::name('user_role')->field('rid')
                ->where(array('uid'=>array('eq',$v['id'])))
                ->select();
            // var_dump($role_ids);
            // die;
            $roles = array();
            // var_dump($role_ids);
            foreach ($role_ids as $value) {
                $roles[] = Db::name('role')
                    ->where(array('id'=>array('eq',$value['rid'])))
                    ->value('name');
            }
            // var_dump($roles);
            $v['role'] = $roles;
            $arr[] = $v;
        }
        // var_dump($arr);
        return view('user/index',[
            'arr' => $arr
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

    /**
     * noderole 分配角色
     */
    public function noderole($id)
    {
        $user = Db::name('user')->find($id);

        $role = Db::name('role')->select();
        $user_role = Db::name('user_role')->where('uid',$id)->select();
        $myrole = array();
        foreach($user_role as $v){
            $myrole[] =$v['rid'];
        }
        // var_dump($myrole);die;
        return view('user/noderole', [
            'user' => $user,
            'user_role' => $myrole,
            'role' => $role
        ]);
    }

    public function getrole(Request $request)
    {
        if(empty($_POST['role'])){
            $this->error("请选择一个角色！");
        }
        $p = $request->post();
        $uid = $p['uid'];

        Db::name('user_role')->where('uid','=',$uid)->delete();

        foreach($p['role'] as $v){
            $data['uid'] = $uid;
            $data['rid'] = $v;
            //执行添加
            $result = Db::name('user_role')->insert($data);
        }
        // var_dump($data);die;
        if ($result > 0)
        {
            return $this->success('角色分配成功',url('admin/user/index'));
        }else{
            return $this->error('角色分配失败',url('admin/user/index'));
        }
    }
}
