<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends MaintainController {
	public function login()
	{
		if (IS_POST) {
            // var_dump($_POST);
            // 判断验证码
            $Verify = new \Think\Verify();
            if (!$Verify->check(I('post.yzm'))) {
                $this->ajaxReturn('aa','eval');
            }
        
            // 判断用户名和密码
            $map['username'] = I('post.username');

            $info = D('User')->field('id,username,password,status')->where($map)->find();

            if(!$info){
    	
	            //向前台说明不存在用户或用户名错误
	            $this->ajaxReturn('bb','eval');
	            die;
            } else {
            	//验证密码是否正确
            	if(!password_verify(I('post.password'),$info['password'])){

            		$this->ajaxReturn('cc', 'eval');
            		die();

            	} else if($info['status']==1){

                    //判断用户状态
            		$this->ajaxReturn('dd', 'eval');
            		die();
            	} else {
                    //成功返回
                    $_SESSION['user'] = $info;
            		$this->ajaxReturn('ee', 'eval');
            		die;
            	}      	
            }
        } else {
            //显示登录页面
            $this->display();
        }
	}

	 /**
     * 用于显示验证码
     */
    public function yzm()
    {
        $Verify = new \Think\Verify();
        $Verify->fontSize = 25;
        $Verify->length   = 3;
        $Verify->useNoise = false;
        $Verify->useCurve = false;
        $Verify->entry();
    }


    /**
     * 登录
     */
    public function reg()
    {	

        if (IS_POST) {
                
            $Verify = new \Think\Verify();
            if (!$Verify->check(I('post.code'))) {
                $this->ajaxReturn('aa','eval');
                die();
            }

            $res = D('user')->dataSave(I('post.'));
            echo $res;
        } else {


            $this->display();
        }


    	
    }

    /**
     * 检测用户名是否重复
     */
    public function checkUsername()
    {
    	$name = I('get.name');
		$res = D('user')->where("username='$name'")->find();
		echo $res;
    }


    public function logout()
    {
        unset($_SESSION['user']);  
        // var_dump($_SESSION['admin']);

        // die();
        $this->redirect('index/index');
    }
}
?>