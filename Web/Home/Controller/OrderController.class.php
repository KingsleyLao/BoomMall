<?php
namespace Home\Controller;
use Think\Controller;
use Think\Page;
use Think\Model;
class OrderController extends CommonController {
   public function index()
   {
      //接收传过来的搜索值
      if(!empty(I('get.keyword'))){
        
        $map['order_num']=['like', '%'.I('get.keyword').'%'];
        $map['linkman']=['like', '%'.I('get.keyword').'%'];
        $map['_logic']='OR';
      }

      //以状态为查询条件
      if(!empty(I('get.'))){
        $map['orderstatus'] = I('get.status');
      }

        $map['del'] = 0;
        $order=M('order');
        //分页类 
        $uid = $_SESSION['user']['id'];
        $map['uid'] = $uid;
        // $page= new Page($count,3);
        $list = D('order')->field('id,order_num,uid,total,orderstatus,addtime,linkman')->where($map)->getTime();
        // var_dump($list);

        //每一种状态的数量
        $c = $order->field('id,order_num,uid,total,orderstatus,addtime')->where("orderstatus=0")->count();
        $c1 = $order->field('id,order_num,uid,total,orderstatus,addtime')->where("orderstatus=2")->count();
        $c2 = $order->field('id,order_num,uid,total,orderstatus,addtime')->where("orderstatus=3")->count();
        // var_dump($c2);
        $orderstatus = array(0=>'去付款',1=>'待发货',2=>'确认收货',3=>'已收货',4=>'已取消');
            
        // $btn=$page->show();
        $this->assign('orderstatus', $orderstatus);

        $this->assign('c1',$c1);
        $this->assign('c2',$c2);
        $this->assign('c',$c);
        $this->assign('list',$list);
        $this->display();
      }


      function del()
      {
        // var_dump(I('get.'));
        $id = I('get.id');
        $data['del'] = 1;
        $res = M('order')->where("id=$id")->save($data);
        // var_dump($res);
        if ($res) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }       
      }

      function changestatus()
      {
        $id = I('get.id');
        // $map['orderstatus'] = 1;
        $status = M('order')->where("id=$id")->getField('orderstatus');
        if($status == 0){
           $map['orderstatus'] = 1;
         }else if($status == 2){
           $map['orderstatus'] = 3;
         }
         

        $res = M('order')->where("id=$id")->save($map);
        $afterStatus = M('order')->where("id=$id")->getField('orderstatus');
        if($afterStatus == 1){
          $this->success('付款成功');
        }else if($afterStatus ==3){
          $this->success("收货成功");
        }
      }
}
?>