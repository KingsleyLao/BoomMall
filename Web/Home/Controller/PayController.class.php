<?php
namespace Home\Controller;
use Think\Controller;
use Think\Page;
class PayController extends CommonController {
    public function index()
   {
    $id = I('get.id');
    $order = M('order')->where("id=$id")->getField('order_num');
    // var_dump($order);
    $this->assign('order_num',$order);
    $this->display();
   }

   public function shanpay()
   {
      $this->display();
   }
      
} 