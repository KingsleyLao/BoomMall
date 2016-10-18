<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends MaintainController {
	public function index()
	{
		
		$res = S('res');
		$res1 = S('res1');
		$res2 = S('res2');
		$res3 = S('res3');


		if (empty($res3) && empty($res2) && empty($res1) && empty($res) ) {
			
			// echo 123;
			S(
				array(   
				'type'=>'memcache', 
				'host'=>'localhost',
				'port'=>'11211', 
				'prefix'=>'boom',
				'expire'=>60)
			);
			$res3 = $this->select2($res3);
			$res2 = $this->select($res2);
			$res1 = $this->adv($res1);
			$res = $this->lunbo($res);

			S('res3', $res3, 3600);
			S('res2', $res2, 3600);
			S('res1', $res1, 3600);
			S('res', $res, 3600);


		} 
			

		$this->assign('res',$res);	//轮播图
		$this->assign('res1',$res1);	//广告
		$this->assign('res2',$res2);//女装
		$this->assign('res3',$res3);//女装

		$this->display();
	}

	//轮播图
	public function lunbo(){
		//查询数据库里的轮播图的图片
		$lunbo = M('carousel');
	    $res = $lunbo->order('id desc')->limit(0,6)->select();
	    return $res;
		
	}

	//广告
	public function adv(){
		//查询广告内容
		$adv = M('advertise');
	    $res1 = $adv->where("status=1")->order('addtime desc')->limit(0,8)->select();
	    
	    return $res1;
		
	}

	//查询女装商品1
	public function select(){
		$res2 = M();
		$sql = "select t.id,t.goodsname,t.pic,t.price  from (select g.id as id,g.goodsname as goodsname,gp.pic as pic,g.price as price from boom_goods g inner join boom_goods_pic gp on g.id=gp.gid where g.typeid=6) t group by t.id,t.goodsname limit 0,8;";
	
	  	$res2 =  $res2->query($sql);


	    return $res2;
	}

	public function select2(){
		$res3 = M();
		$sql = "select t.id,t.goodsname,t.pic,t.price  from (select g.id as id,g.goodsname as goodsname,gp.pic as pic,g.price as price from boom_goods g inner join boom_goods_pic gp on g.id=gp.gid where g.typeid=6 ) t group by t.id,t.goodsname limit 0,5;";
	
	  	$res3 =  $res3->query($sql);


	    return $res3;
	}


}
?>