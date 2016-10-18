<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
    public function _initialize()
    {
        //会在所有方法之前执行，通常用于权限验证
        if (empty(session('admin'))) {
            $this->redirect('Login/login');
            
        } else {

        	//获得当前用户访问的"控制器/方法";
        	//获得当前用户允许访问权限
        	//当前访问的权限与 允许访问权限对比

        	$nowac = CONTROLLER_NAME."-".ACTION_NAME;
        	// echo $nowac;

        	$admin_rid = session('admin')['rid'];

        	if ($admin_rid !=="0") {
        		
        			$auth_ac = D('role')->where("role_id=$admin_rid")->getField('role_auth_ac');
					// var_dump($auth_ac);

					//允许所有人访问的页面
        			$allow_ac = "Index-index,Index-welcome";

        			if (strpos($auth_ac, $nowac)===false && strpos($allow_ac, $nowac)===false) {
        				
        				
        				$this->error('你没有权限访问',U('Admin/Index/index'));
        			}



        	} 

        }

        
    }

}