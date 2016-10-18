<?php
	namespace Admin\Controller;
	use Think\Controller;

	class FriendshipController extends CommonController
	{
		
		public function index(){
			$Friendship = $this->selected();
			$this->assign('Friendship',$Friendship);
			//var_dump($Friendship);
		


			$this->display();
		}

		public function add(){
			//var_dump($_POST);
			$data['name'] = I('post.name');
			$data['url'] = I('post.address');
			//var_dump($data);

			$Friend = M('Friendship');
			$res = $Friend->add($data);
			if($res > 0 ){
				$this->success('成功添加');
			}else{ 
				$this->error('添加失败');
			}
		}

		//查询广告数据
		public function selected(){
			 $User = M('Friendship'); // 实例化User对象
			   $count= $User->count();// 查询满足要求的总记录数
			   $Page = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			   //var_dump($Page);
			   $show = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			   $list = $User->order('id')->limit($Page->firstRow.','.$Page->listRows)->select();
			   $this->assign('list',$list);// 赋值数据集
			   $this->assign('page',$show);// 赋值分页输
			  //var_dump($list);
			  //var_dump($count);
			///var_dump($page);
			   //var_dump($list);
			
			return $list;


		}
		public function Del()
		{
			$model = M('Friendship');
			$res = $model->where('id='.I('get.id'))->delete();

			if ($res > 0) {
				$this->success('删除成功');
			} else { 
				$this->error('删除失败');
			}
		}
		

		public function alldel(){
			$model = M('Friendship');

			foreach ($_POST as $key => $value) {
				//echo $value;
				$res = $model->where('id='.$value)->delete();
			}
			if ($res > 0) {
				$this->success('删除成功');
			} else { 
				//var_dump($_POST);
				$this->error('删除失败');
			}
		}


	}