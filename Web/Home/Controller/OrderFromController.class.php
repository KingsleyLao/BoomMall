<?php
namespace Home\Controller;
use Think\Controller;
use Think\Page;
class OrderFromController extends CommonController {
    public function index()
   {
      $uid = $_SESSION['user']['id'];
   		//查询省份
   	  $model = M('useradd');
  		$arr = $model->where(['pid'=>-1])->select();
      $goods = M('cart')->where("uid=$uid")->select();
      // var_dump($goods);
      $count = M('cart')->where("uid=$uid")->count();
      // var_dump($count);

      //全部地址
      $address = D('address')->where("uid=$uid")->getaddress();

  		// var_dump($address);
      $this->assign("arr",$arr);
      $this->assign("count",$count);
      $this->assign("goods",$goods);
  		$this->assign("address",$address);
      $this->display(index);
   }

   function getaddress()
   {
  		$pid = I('get.pid');
   	  $model = M('useradd');
	    $arr = $model->where("pid=$pid")->select();
	    $this->ajaxReturn($arr);
   }

   function addaddres()
   {
      $map['linkman'] = I('get.linkman');
      $map['private'] = I('get.sheng');
      $map['city'] = I('get.shi');
      $map['area'] = I('get.qu');
      $map['road'] = I('get.road');
      $map['tel'] = I('get.tel');
      $map['uid'] = $_SESSION['user']['id'];

      $res = M('address')->add($map);
      echo $res;
   }


   function changestatus()
   {
      $id = I('get.id');
      $sta['status'] = 1;
      $data['status'] = 0;
      $map = 1;
      $res1 = M('address')->where($map)->save($data);

      $res2 = M('address')->where("id=$id")->save($sta);
      $checkedaddress = D ('address')->where($sta)->getaddress();
      // var_dump($checkedaddress);
      $this->assign('check',$checkedaddress[0]);
      $this->index();
   }


   function addressdel()
   {
    $id = I('get.id');
    $res = M('address')->where("id=$id")->delete();
    if (res) {
      $this->success("删除成功",index);
    } else {
      $this->error('删除失败');
    }
    
      // var_dump(I('get.'));

   }
     

   function addressedit()
   {

   }


   function addorder()
   {
      $uid = $_SESSION['user']['id'];
      $addressid = I('get.addressid');
      $total = I('get.total');
      $linkman = M('address')->field('linkman')->where("id=$addressid")->select();
      // var_dump($linkman[0]['linkman']);
      $map['linkman'] = $linkman[0]['linkman'];
      $map['total'] = $total;
      $map['addressid'] = $addressid;
      $map['addtime'] = time();
      $map['order_num'] = time();
      $map['uid'] = $uid;
      $orderres = M('order')->add($map);

      $cart = M('cart')->field("gid,goodsname gname,price gprice,goodspic gpic,color,number buynum,size")->where("uid=$uid")->select();
      $count = M('cart')->where("uid=$uid")->count();

      for ($i=0; $i < $count; $i++) { 
        $cart[$i]['oid'] = $orderres;
        $res = M('order_detail')->add($cart[$i]);
          if($res){
            $data['status'] = 0;
            $map = 1;
            $res1 = M('address')->where($map)->save($data);
            $delres = M('cart')->where("uid=$uid")->delete();
          }
      }


   }


   public function flow()
   {
    $this->display();
   }

   public function checkSta()
   {
     
      $userid = $_SESSION['user']['id'];
      $checkedcount = M('address')->where("status=1 and uid=$userid")->count();
      echo $checkedcount;
   }
} 