<?php
namespace Admin\Controller;
use Think\Controller;
class AuthController extends CommonController {
    public function authList()
    { 

        $search = I('post.search');
        $map['auth_name'] = array('like',"%".$search."%");
        
        $auth = new \Admin\Model\AuthModel();
        
        //获取所有数据
        $authInfo = $auth->where($map)->order('auth_path')->select();
        //处理获得的数据
        $authInfo = $auth->changeCat($authInfo);

        // if($authInfo== null){
        //   $authInfo =
        // } else {

        //   echo 1;
        // }
        $this->assign('authInfo', $authInfo);
        $this->assign('search', $search);
        $this->display();


    }

    public function authAdd()
    {
       
       $auth = new \Admin\Model\AuthModel();
       if (IS_POST) {
               
            $res = $auth->saveData(I('post.'));
            echo $res;
             // var_dump(I('post.'));

       } else {
           $authInfo = $auth->field('auth_id,auth_name,auth_pid')->where('auth_pid=0')->select();
           // var_dump($authInfo);

           $this->assign('authInfo', $authInfo);
           $this->display();
       }
    }

    public function authEdit()
    {
        
        if(IS_POST){

           $res = D('auth')->saveData(I('post.'));
           echo $res;

        } else {

          $id = I('get.id');

          $data = D('auth')->field('auth_id,auth_name,auth_pid,auth_c,auth_a')->where("auth_id=$id")->find();

          $authInfo = D('auth')->field('auth_id,auth_name,auth_pid')->where('auth_pid=0')->select();

          $this->assign('data', $data);
          $this->assign('authInfo', $authInfo);
          $this->display();

          
        }
    }

    public function authDel()
    {
        $id = I('get.id');

        $res = D('auth')->where("auth_pid=$id")->select();
        
        if($res){

          echo aa;


        } else {
          
          D('auth')->delete($id);
          echo null;

        }
        
    }


}