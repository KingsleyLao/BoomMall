<?php
	namespace Admin\Controller;
	use Think\Controller;

	class feedbackController extends CommonController
	{
		
		public function index(){

		if(IS_POST){
			$model = M('feedback');

			foreach ($_POST as $key => $value) {
				//echo $value;
				$res = $model->where('id='.$value)->delete();
			}
			if ($res > 0) {
				$this->success('删除成功');
			} else { 
				$feedback = $this->selected();
				$this->assign('feedback',$feedback);
				$this->display();
				//$this->error('删除失败');
			}
		}else{
		
			$feedback = $this->selected();
			$this->assign('feedback',$feedback);
			//var_dump($feedback);


			$this->display();
		}
	}

		//查询广告数据
		public function selected(){
			 $User = M('feedback'); // 实例化User对象
			   $count= $User->count();// 查询满足要求的总记录数
			   $Page = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			   //var_dump($Page);
			   $show = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			   $list = $User->order('addtime')->limit($Page->firstRow.','.$Page->listRows)->select();
			   $this->assign('list',$list);// 赋值数据集
			   $this->assign('page',$show);// 赋值分页输出
			  // var_dump($show);
			 // var_dump($list);
			  //var_dump($count);
			///var_dump($page);
			   //var_dump($list);
			$feedback = $this->getData($list);
			//var_dump($feedback);
			return $feedback;


		}
		public function Del()
		{
			$model = M('feedback');
			$res = $model->where('id='.I('get.id'))->delete();

			if ($res > 0) {
				$this->success('删除成功');
			} else { 
				
				$this->error('删除失败');
			}
		}
		
		public function getData($feedback)
		{
			$arr = array(0=>'非常满意',1=>'满意',2=>'一般',3=>'不满意',4=>'非常不满意');
			
			//通过地址引用在循环遍历的时候修改满意度。
			foreach ($feedback as &$v){
				$v['sname']=$arr[$v['static']];

			}
			//var_dump($feedback);
			return $feedback;



		}

		


	}