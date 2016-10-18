<?php
namespace Home\Controller;
use Think\Controller;
use Think\Page;
use Think\Model;
class OrderCommentController extends CommonController {
   //待付款,待发货，待收货，已完成详情界面
   public function index()
   {
      // var_dump(I('get.'));
      $gid = I('get.gid');
      $oid = I('get.oid');
      $discussstatus = I('get.disstatus');
      // var_dump(I('get.'));

      if($discussstatus == 1){

         $ordernum = M('order')->field('order_num')->where("id=$oid")->select();
         $onum = $ordernum[0]['order_num'];
         // var_dump($onum);
         $map['order_num']="$onum";
         $map['gid'] = "$gid";
         // 评论信息
         $comment = M('discuss')->field('addtime,star,saycomment,order_num,sayid')->where($map)->select();
         // var_dump($comment);
         
         foreach ($comment as $k => &$v) {
               $v['addtime'] = date('Y-m-d H:i:s',$v['addtime']);
         }


         //评论页面商品信息
      	$goods = M('order_detail')->field('gpic,gname,gprice')->where("gid=$gid")->select();
	      // var_dump($goods);
         $buytime = M('order')->field('addtime')->where("id=$oid")->select();
         $buytime = $buytime[0];
         // var_dump($buytime);

         $bytime = date('Y-m-d H:i:s',$buytime['addtime']);
         // var_dump($bytime);

         $this->assign("onum",$onum);
         $this->assign("comment",$comment[0]);
         $this->assign("goods",$goods[0]);
         $this->assign("bytime",$bytime);          
	      $this->showComment();

      }else if($discussstatus == 0){
      	  // echo '这里是写评论页面';
            $map['oid']="$oid";
            $map['gid'] = "$gid";
            $goods = M('order_detail')->field('gid,gpic,gname,gprice,color,size')->where($map)->select();
            // var_dump($goods);
             $ordernum = M('order')->field('order_num')->where("id=$oid")->select();
            $onum = $ordernum[0]['order_num'];
            // var_dump($onum);
            $this->assign("oid",$oid);
            $this->assign('goods',$goods[0]);
            $this->assign('onum',$onum);
      	   $this->addComment();

      }
     
   }

   public function addComment()
   {
      // var_dump(I(.get))
   		$this->display('addComment');
   }

   public function showComment()
   {
      // var_dump(I('get.'));
   		$this->display('showComment');
   }

   public function adddis()
   {
      $uid = $_SESSION['user']['id'];
      // var_dump(I('post.'));
      $data['gid']  = I('post.gid');
      $data['saycomment'] = I('post.text');
      $data['order_num'] = I('post.onum');
      $data['star'] = I('post.star');
      $data['addtime']=time();
      $data['sayid']= $uid;

      $res = M('discuss')->add($data);
      // var_dump($res);

      $sta['discussstatus'] = '1';
      $map['gid']=I('post.gid');
      $map['oid']=I('post.oid');
      $sta['discussid'] = $res;
      
      $status = M('order_detail')->where($map)->save($sta);

      $this->ajaxReturn($res);
   }

   public function untilcomment()
   {
      // echo '111';
      $notcomment = M('order_detail')->where("discussstatus=0")->select();
      // var_dump($notcomment);
      $count = M('order_detail')->where("discussstatus=0")->count();
      // var_dump($count);
      $this->assign('notcomment',$notcomment);
      $this->assign('count',$count);
      $this->display();
   }

}
?>