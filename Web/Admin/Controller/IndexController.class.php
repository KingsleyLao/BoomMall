<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
       
        //获取session值
        $adminName = session('admin')['name'];
        $rid = session('admin')['rid'];

        //使用Model模型获取用户角色
        $roleName = D('role')->getName($rid);

        //查找boom_role用户对应的权限id
        $res = M('role')->field('role_auth_ids')->find($rid);
        $auth_ids = $res[role_auth_ids];
        
        //根据用户的权限查找对应boom_auth查看具体的权限
        //判断用户是不是超级管理员admin
        if ($roleName === '超级管理员') {
           
            $auth_infoA = M('auth')->field('auth_id,auth_name,auth_pid,auth_c,auth_a,auth_path')->where("auth_level=0")->select();  //父级
            $auth_infoB = M('auth')->field('auth_id,auth_name,auth_pid,auth_c,auth_a,auth_path')->where("auth_level=1")->select();  //子级
            
        } else {
          
            $auth_infoA = M('auth')->field('auth_id,auth_name,auth_pid,auth_c,auth_a,auth_path')->where("auth_level=0 and auth_id in ($auth_ids)")->select();  //父级
            $auth_infoB = M('auth')->field('auth_id,auth_name,auth_pid,auth_c,auth_a,auth_path')->where("auth_level=1 and auth_id in ($auth_ids)")->select();  //子级
        }


        $this->assign('auth_infoA', $auth_infoA);
        $this->assign('auth_infoB', $auth_infoB);
        $this->assign('adminName',$adminName);
        $this->assign('roleName', $roleName);
        $this->display();
    }

    public function welcome()
    {
    	$this->display();
    }





    /**
     * webuploader 上传文件
     */
    public function ajax_upload(){
        // 根据自己的业务调整上传路径、允许的格式、文件大小  
         
        ajax_upload('/Upload/image/');
        // var_dump($data);
    }

    /**
     * webuploader 上传demo
     */
    public function webuploader(){
        // 如果是post提交则显示上传的文件 否则显示上传页面
        if(IS_POST){
            p($_POST);
            
            die;
        }else{
            $this->display();
        }
    }
}