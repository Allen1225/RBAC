<?php

namespace app\admin\controller;

<<<<<<< HEAD

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
=======
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
>>>>>>> 8aa8129c464630872995f1daeb3f6430c7bedb79
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
<<<<<<< HEAD
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
            return $this->success('添加成功', url('admin/user/index'));
        }else{
            return $this->error('添加失败', url('admin/user/add'));

        }


    }

    public function delete($id)
    {
        // var_dump($id);
        $result = Db::name('user')->delete($id);

        if ($result>0) {
            return $this->success('删除成功', url('admin/user/index'));
        }else{
            return $this->error('删除失败', url('admin/user/index'));

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
            return $this->success('修改成功', url('admin/user/index'));
        }else{
            return $this->error('修改失败', url('admin/user/index'));

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
            return $this->success('修改角色成功', url('admin/user/index'));
        }else{
            return $this->error('修改角色失败', url('admin/user/index'));

        }
    }

=======
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
>>>>>>> 8aa8129c464630872995f1daeb3f6430c7bedb79
}
