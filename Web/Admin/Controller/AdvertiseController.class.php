<?php
	namespace Admin\Controller;
	use Think\Controller;

	class AdvertiseController extends CommonController
	{
		
		public function index(){
			$advertise = $this->selected();
			  


			$this->assign('advertise',$advertise);

			$this->display();
		}

		//查询广告数据
		public function selected(){
			 $User = M('advertise'); // 实例化User对象
			   $count= $User->count();// 查询满足要求的总记录数
			   $Page = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			   //var_dump($Page);
			   $show = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			   $list = $User->order('addtime')->limit($Page->firstRow.','.$Page->listRows)->select();
			   $this->assign('list',$list);// 赋值数据集
			   $this->assign('page',$show);// 赋值分页输出
			  // var_dump($show);
			 // var_dump($list);
			  //var_dump($count);
			  //var_dump($page);

			$advertise = $this->getData($list);
			//var_dump($advertise);

			$time = date('Y-m-d H:i:s');
			foreach($advertise as $v){
				if($v['stime'] < $time){
					$data['status'] = 0;
					 $tim = M('advertise'); 
					 $tim->where("id=$v[id]")->save($data);

				}
			}
			return $advertise;


		}


		public function inadd(){
			//获取页面传输过来的post数据
			$advertise['name'] = I('post.name');
			$advertise['url'] = I('post.address');
			$advertise['common'] = I('post.common');
			//创建的当前时间
			$addtime = date('Y-m-d H:i:s');
			$addtime1 = date('Y-m-d H:i:s',strtotime('+1 day'));
			
			$advertise['addtime'] = $addtime;
			$advertise['stime'] = $addtime1  ;

			//var_dump($advertise);
			$adv = M('advertise');

			$this->assign('advertise',$advertise);
			$res =$adv->add($advertise);
			//var_dump($res);

			if($res>0){
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}			
		}

			
			
			
		

		public function update(){
			//读取页面传过来的值

			$id = I('get.id');
			//var_dump($id);
			$data1 = M("advertise");
			$res = $data1->where("id=$id")->select();
			echo  json_encode($res);

		}

		public function content_update(){
			$id  = I('post.id');
			$advertise['id'] = I('post.id');
			$advertise['name'] = I('post.name');
			$advertise['name'] = I('post.name');
			$advertise['url'] = I('post.address');
			$advertise['common'] = I('post.common');
			$adv1 = M('advertise');

			
			$adv1->where("id=$id")->save($advertise);
			$this->success('修改成功');
		}



		public function Del()
		{
			$model = M('advertise');
			$res = $model->where('id='.I('get.id'))->delete();

			echo json_encode($res);
		}
		
		public function getData($advertise)
		{
			$arr = array(1=>'打开显示',0=>'关闭显示');
			//通过地址引用在循环遍历的时候修改状态值。
			foreach ($advertise as &$v){
				$v['statusname']=$arr[$v['status']];
			}
		
			return $advertise;
		}

		//判断状态值
		public function status(){
			$id = I('get.id');
			$status = I('get.status');
			//var_dump($status);
			//var_dump($id);
			$data1 = M("advertise");
			if($status == 0){
				$data['status'] = 1;
				var_dump($data);
				$res = $data1->where("id=$id")->save($data);
			}else{
				$data['status'] = 0;
				$res = $data1->where("id=$id")->save($data);
			}
			return;
		}
		










	}