<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function login()
    {
    	$this->display();
    }

    public function checkLogin()
    {   
        $name = I('post.name');
        $pass = I('post.password');

    	//查询数据库,判断用户的有效性
        // $res = D('admin')->field('name,rid,state')->where("name=$name")->find();
    	$res = D('admin')->field('name,password,rid,state')->where("name='$name'")->find();
        
    	if ($res == null) {
    		
    		$this->error('你的用户名错误或者不存在','login/login');
    		die;

    	} else if(!password_verify($pass, $res['password'])){

            $this->error('你的密码错误','login/login');
            die;

        } else if($res['state'] == 0) {
    		
    		$this->error('该用户没有权限访问','login/login');
    		die;

    	} else {


    		//设置session保存登录用户数据
    		session('admin',$res);
    		redirect(U('Index/index'));

    		// var_dump(session('admin')['name']);
    		// var_dump($res);
    	}
    }

    public function loginout()
    {	
		unset($_SESSION['admin']);	
		// var_dump($_SESSION['admin']);

		// die();
		$this->redirect('login/login');
    }
}