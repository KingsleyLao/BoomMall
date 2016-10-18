<?php
	namespace Home\Controller;
	use Think\Controller;

	class FeedbackController extends MaintainController
	{
		
		public function index(){


			$this->display();

			
		}
		public function add1(){
			$data['content'] = I('post.content');
			$data['name'] = I('post.name');
			$data['phone'] = I('post.phone');
			$data['static'] = I('post.num');
			$data['addtime']= date('Y-m-d H:i:s',time('now'));
			$sql = M('feedback');
			$sql->add($data);
			$this->success('O(∩_∩)O谢谢提交，我们会尽量完善您所提交的建议','../index');

		}

		public function tiao(){
			$this->display();

		}

		


	}