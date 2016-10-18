<?php
namespace Admin\Controller;
use Think\Controller;
class RoleController extends CommonController {
    public function roleList()
    {
        
        $roleInfo = D('role')->field('role_id,role_name')->select();

        $superName = D('admin')->field('name')->where('rid=0')->find()['name'];
        $adminInfo = D('admin')->field('name,rid')->where('rid!=0')->select();



        $this->assign('superName', $superName);
        $this->assign('roleInfo', $roleInfo);
        $this->assign('adminInfo', $adminInfo);


        $this->display();

    }

    public function roleAdd()
    {
        
        if (IS_POST) {
            
            $res = D('role')->saveAuth(I('post.'));
            
            echo $res;



        } else {


            $authInfoA = D('auth')->field('auth_id,auth_name')->where('auth_level=0')->select();
            $authInfoB = D('auth')->field('auth_id,auth_name,auth_pid')->where('auth_level=1')->select();      

            $this->assign('authInfoA', $authInfoA);
            $this->assign('authInfoB', $authInfoB);
            $this->display();

            
        }


    }

    public function roleEdit()
    {
        //实例化Model类
        $role = new \Admin\Model\RoleModel();
        
        if (IS_POST) {

            $res = $role->saveAuth(I('post.'));
            
            echo $res;

            

        } else {

            $id = I('get.id');

            $authInfoA = D('auth')->field('auth_id,auth_name')->where('auth_level=0')->select();
            $authInfoB = D('auth')->field('auth_id,auth_name,auth_pid')->where('auth_level=1')->select();

            $roleInfo = $role->field('role_name,role_auth_ids')->find($id);

            $have_ids = $roleInfo['role_auth_ids'];




            $this->assign('authInfoA', $authInfoA);
            $this->assign('authInfoB', $authInfoB);
            $this->assign('roleName', $roleInfo['role_name']);
            $this->assign('have_ids', $have_ids);
            $this->display();
        }
    }

    public function roleDel()
    {
        $id = I('get.id');

        D('role')->where("role_id=$id")->delete();
    }


    // public function _empty(){     
                     
    //            redirect(U('admin/index/a404'));
    //  }
}