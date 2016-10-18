<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
use Think\Model;
class OrderController extends CommonController {
    //显示订单列表页面
    public function orderList()   
    {
      //接收传过来的搜索值
      if(!empty(I('get.word'))){
        
        $map['order_num']=['like', '%'.I('get.word').'%'];
        $map['linkman']=['like', '%'.I('get.word').'%'];
        $map['_logic']='OR';
            }

        $order=M('order');
        // var_dump($order);
            
        //实例化出一个分页对象，第一次参数是总共有多少条数据，没页显示5条。
        $page= new Page($order->where($map)->count(),3);
        // var_dump($page);
        

        $data=D('order')->field('id,order_num,addtime,total,linkman,orderstatus')->where($map)->limit($page->firstRow.','.$page->listRows)->getTime();
        // var_dump($data);
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
            
        $btn=$page->show();
        
        $status = array('0'=>'用户已下单','1'=>'等待发货','2'=>'已发货','3'=>'已完成');
        $this->assign('status',$status);
        $this->assign('totalRows', $page->totalRows);
        $this->assign('totalPages', $page->totalPages);
        $this->assign('btn', $btn);
        $this->assign('count',$mapcount);
        $this->assign('data',$data);
        $this->display();
      }

    //详情订单
    public function detail()
    {
        // echo '1111';
        $oid = (I('get.id'));
        $order = D('order')->field('id,order_num,addtime,total,addressid,orderstatus')->where("id=$oid")->getTime();
        $aid = $order[0]['addressid'];
        $useraddress = D('address')->field('linkman,private,city,road,area,tel')->where("id=$aid")->getaddress();
        $goodsdetail = M('order_detail')->field('gname,color,size,buynum,gprice,gpic')->where("oid=$oid")->select();
        $this->assign('order',$order[0]);
        $this->assign('useraddress',$useraddress[0]);
        $this->assign('goodsdetail',$goodsdetail);
        // var_dump($order[0]);
        // var_dump($useraddress);
        // var_dump($goodsdetail);
    	$this->display();
    }

    //删除选中的行数
    public function del($id)
    {
        $res = M('order')->delete($id);
        if ($res) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }


    function changeStatus()
    {
        // var_dump(I('get.'));
        $oid = I('get.oid');
        $ostatus['orderstatus'] = 2;
        $osres = M('order')->where("id=$oid")->save($ostatus);
        // var_dump($osres);

        if($osres == 1){
            $this->success('发货成功',U('Order/orderList'));
            die;
        }else{
            $this->error('发货操作失败');
        }
    }
  
}