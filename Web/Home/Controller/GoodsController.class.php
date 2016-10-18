<?php
	namespace Home\Controller;
	use Think\Controller;
	use Think\Page;

class GoodsController extends MaintainController 
{
	public function goods()
	{
		$id=I('get.id');
		$g=M('goods');
		$d=M('goods_detail');
		$c=M('goods_color');
		$s=M('goods_size');
		$p=M('goods_pic');
		$t=M('cat');
		$size=$s->field('size,id')->where("gid=$id")->select();


		$color=$c->field('color')->where("gid=$id")->select();


		$detail=$d->where("gid=$id")->find();
		$content=$detail['contents'];


		$goodsData=$g->where("id=$id")->find();


		$pic=$p->field('pic')->where("gid=$id")->select();
		foreach($pic as $k=>&$v){
			$v['pic']=ltrim($v['pic'],'.');
		}


		$cat=$t->field('id,name,pid')->select();

		$breadcrumb=$this->getFather($cat,$goodsData['typeid']);

		$this->assign('size',$size);
		$this->assign('color',$color);
		$this->assign('goodsData',$goodsData);
		$this->assign('content',$content);
		$this->assign('bc',$breadcrumb);
		$this->assign('pic',$pic);

		$this->display();
	}

	public function goodsList()
	{
		$c=M('cat');
		$b=M('brand');
		$cat=$c->field('id,name')->where('pid=0')->select();
		$brand=$b->field('id,bname')->select();

		$this->assign('brand',$brand);
		$this->assign('cat',$cat);
		$this->display();
	}

	public function catType()
	{
		$typeid=I('get.id');


		$c=M('cat');
		$b=M('brand');
		$g=M();
		$cat=$c->field('id,name')->where('pid=0')->select();
		$brand=$b->field('id,bname')->select();
		$sql="select t.id,t.goodsname,t.pic,t.price  from (select g.id as id,g.goodsname as goodsname,gp.pic as pic,g.price as price from boom_goods g inner join boom_goods_pic gp on g.id=gp.gid where g.typeid={$typeid}) t group by t.id,t.goodsname limit 0,2;";
	
		$goods=$g->query($sql);
		foreach($goods as $k=>&$v){
			$v['pic']=ltrim($v['pic'],'.');
		}


		$this->assign('brand',$brand);
		$this->assign('cat',$cat);
		$this->assign('goods',$goods);
		$this->display('goodsList');
	}

	public function brandType()
	{
		$brandid=I('get.id');


		$c=M('cat');
		$b=M('brand');
		$g=M();
		$cat=$c->field('id,name')->where('pid=0')->select();
		$brand=$b->field('id,bname')->select();
		$sql="select t.id,t.goodsname,t.pic,t.price  from (select g.id as id,g.goodsname as goodsname,gp.pic as pic,g.price as price from boom_goods g inner join boom_goods_pic gp on g.id=gp.gid where g.bid={$brandid}) t group by t.id,t.goodsname limit 0,5;";
	
		$goods=$g->query($sql);
		foreach($goods as $k=>&$v){
			$v['pic']=ltrim($v['pic'],'.');
		}


		$this->assign('brand',$brand);
		$this->assign('cat',$cat);
		$this->assign('goods',$goods);
		$this->display('goodsList');
	}

	public function getFather($data,$cid)
	{
	    static $rec = array();
	    foreach($data as $v){
	      if($v['id']==$cid){
	        $rec[]=$v;
	      
	        $this->getFather($data,$v['pid']);
	      }
	    }
	    krsort($rec);
	    return $rec; 
	}

	public function store(){

		$gid = I('post.gid');
		$color = I('post.color');
		$size = I('post.size');
		$sql1 = M();
		$sql = "select id from boom_goods_size where gid=$gid and size='$size'";
		$res = $sql1->query($sql);
		$sid =$res[0]['id']; 


		$sql1 = M();
		$sql = "select store from boom_goods_color where gid=$gid and sid=$sid and color='$color'";

		$res1 = $sql1->query($sql);

		$store = $res1[0]['store'];

		if($store == null){
			echo '-1'; //为空就不能添加购物车
		}else{ 
			echo '1';	//不为空就可以添加数据库
		}
		
	}

}

?>