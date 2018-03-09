<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Admin as AdminModel;
class Admin extends Controller
{
  public function lst()
  {
    $admin = new AdminModel();
    $res = $admin -> getadmin();
    $this -> assign('res',$res);
    // $this -> assign()
    return $this -> fetch('lst');
  }

  public function add()
  {
    // $data = input('post.');
    // if (request() -> isPost()) {
    //   $res = db('admin') -> insert($data);
    //   if ($res) {
    //     $this -> success('添加管理员成功！','admin/lst');
    //   }else{
    //     $this -> error('添加管理员失败');
    //   }
    //   return;
    // }
    if (request() -> isPost()) {
      $admin = new AdminModel();
      if ($admin -> addadmin(input('post.'))) {
        $this -> success('添加管理员成功！','lst');
      }else{
        $this -> error('添加管理员失败!');
      }
    }
    return $this -> fetch('add');
  }

  public function edit($id)
  {
    $data = input('post.');
    $admins = db('admin') -> find($id);
    $this -> assign('admin',$admins);
    if (request() -> isPost()) {
      if (!$data['username']) {
        $this -> error('用户名称不能为空！');
      }elseif (!$data['password']) {
        $data['password'] = $admins['password'] ;
      }else {
        $data['password'] = md5($data['password']);
      }
      $res = db('admin') -> updata($data);
      if ($res) {
        $this -> success('修改管理员信息成功！','lst');
      }else {
        $this -> error('修改管理员信息失败！');
      }
    }
    return $this -> fetch('edit');
  }

}
