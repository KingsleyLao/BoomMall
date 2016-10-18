<?php
namespace Home\Controller;
use Think\Controller;
use Think\Page;
use Think\Model;
class OrderDetailController extends CommonController {
   //待付款,待发货，待收货，已完成详情界面
   public function index()
   {
       //接收对应订单的id 
      $id = I('get.oid');
      // var_dump($id);
      $model = new Model();
      $data1 = $model->query("select a.*,o.* from boom_address a,boom_order o where o.addressid = a.id and o.id = {$id}");
      $data = D('address')->getaddress2($data1);
      $goodsList = M('order_detail')->where("oid=$id")->select();
      // var_dump($goodsList);

      $orderstatus = M('order')->field('orderstatus')->where("id=$id")->select();

      $status = array(0=>'评论',1=>'查看评论');

      $this->assign('status',$status);
      $this->assign('orderstatus',$orderstatus[0]);
      $this->assign('payway',$payway);
      $this->assign('sendway',$sendway);
      $this->assign('sendtime',$sendtime);
      $this->assign('data',$data[0]);
      $this->assign('goodsList',$goodsList);

        $this->display();
   }


}
?>