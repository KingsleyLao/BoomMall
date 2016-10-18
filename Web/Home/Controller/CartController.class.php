<?php
	namespace Home\Controller;
	use Think\Controller;

	class CartController extends CommonController
	{
		
		public function index(){

			$cart = $this->select();
			$this->assign('cart',$cart);
			//var_dump($cart);
			
			//统计总金额
			foreach($cart as $v){
				$money +=$v['total'];
			}
			$this->assign('money',$money);


			$this->display();

			
		}
		public function ajax(){
		//读取页面传过来的值	
			//var_dump($_POST);
			$id = $_SESSION['user']['id'];
			$data1['uid'] = $id; 		//用户id
			$data1['gid'] = I('post.gid');			//商品id
			$data1['price'] = I('post.price');		//商品单价
			$data1['number'] = I('post.number');		//商品数量
			$data1['goodspic'] = I('post.goodspic');	//商品图片路径
			$data1['goodsname'] = I('post.goodsname');	//商品名称
			$data1['total'] = $data1['price'] * $data1['number'];
			$data2['color'] = I('post.color');
			$data2['size'] = I('post.size');		//商品大小尺码
			$data1['color'] = I('post.color');
			$data1['size'] = I('post.size');

			$data1['attr'] = serialize($data2);
		
			//$data = unserialize($data);*/
		

			//判断购物车里是否已经有相同数据
			$my = M();
			$sql99 = "select id from boom_cart where gid={$data1['gid']} and color='{$data2['color']}' and size='{$data2['size']}'";

			$sql999=$my->query($sql99);

			if($sql999 == null){
				$sql = M('cart');
				$res=$sql->add($data1);

			}else{
				$id = $sql999[0]['id'];
				//var_dump($id);
				$sql = M('cart');
				$res=$sql->field('number')->where("id=$id")->select();
				$number = $res[0]['number'];
		
				$date['number'] = $number +$data1['number'];
				//var_dump($date);
				$res=$sql->where("id=$id")->save($date);
				//var_dump($res);
		}
	
			if($res > 0){
				echo  1;
			}else{
				echo  0;
			}
		}


		public function select(){
			$id = $_SESSION['user']['id'];
			$sql = M('cart');

			$cart=$sql->where("uid=$id")->select();
			

			foreach ($cart as $key => &$value) {
				$a = $value['attr'];

				$b = unserialize($a);
				//var_dump($b);
				$value['attr'] = $b ;

			}

			
			return $cart;

		}

		public function add(){
			var_dump($_POST);
			$id = I('post.id');
			$gid = I('post.gid');
			$color = I('post.color');
			$size = I('post.size');
			$date['gid']=$id;
			//$date['color'] = $color;
			$date['size'] = $size;
			var_dump($date);
			

			//根据商品id和商品尺码来查询size
			$sql1 = M();
			$sql = "select id from boom_goods_size where gid=$gid and size='$size'";
			$res = $sql1->query($sql);
			$sid =$res[0]['id']; 
			var_dump($sid);

			//查询库存数量
			$sql1 = M();
			$sql = "select store from boom_goods_color where gid=$gid and sid=$sid and color='$color'";

			$res1 = $sql1->query($sql);
			var_dump($res1);
			$store = $res1[0]['store'];
			var_dump($store);
			die();
			


			$sql = M('cart');

			$cart=$sql->field('number,total,price')->where("id=$id")->select();
	
			$data['number'] = $cart['0']['number'] +1; 
			$data['total'] = $cart['0']['price'] * $data['number'];
			//var_dump($data); 
			if($store >=$data['number']){
			$cart=$sql->where("id=$id")->save($data);
				echo $cart;
			}else{
				echo '-1';
			}	


			

		}
				
		public function unadd(){
			$id = I('post.id');
			$sql = M('cart');

			$cart=$sql->field('number,total,price')->where("id=$id")->select();
			var_dump($cart);
			if($cart['0']['number'] >1){
				$data['number'] = $cart['0']['number'] -1; 
				$data['total'] = $cart['0']['price'] * $data['number'];
				//var_dump($data); 

			$cart=$sql->where("id=$id")->save($data);
		}
		
		}

		public function del1(){
			$id = I('post.id');
			
			$sql = M('cart');

			$res = $cart=$sql->where("id=$id")->delete();
			
			echo  json_encode($res);
				
			
			
		}

		


	}