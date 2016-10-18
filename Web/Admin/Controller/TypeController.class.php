<?php
	namespace Admin\Controller;
	use Think\Controller;
	use Think\Page;

	class TypeController extends Controller
	{
		public function index()
		{
			$m=M('goods_type');
			$data=$m->field('id,name')->select();
			$this->assign('data',$data);
			$this->display();
		}

		public function addType()
		{
			if(I('post.')){
				$m=M('goods_type');
				$data['name']=I('post.name');
				var_dump($data);
				$bool=$m->add($data);
				if($bool){
					$this->success('添加成功！！');
				}else{
					$this->error('添加失败！！');
				}
			}else{
				$this->display();
			}
		}

		public function delType()
		{
			$id = I('get.id');
			var_dump($id);
		
			$m=M('goods_type');
			$bool=$m->where('id='.$id)->delete();
			if($bool){
				$this->success('删除成功！！');
			}else{
				$this->error('删除失败！！');
			}

		}

		public function editType($id)
		{
			$m=M('goods_type');
			if(I('post.')){
				$data['name']=I('post.name');
				var_dump($data);
				$id=I('post.id');
				var_dump($id);
				$bool=$m->where("id=$id")->save($data);
				if($bool){
					$this->success('修改成功！！');
				}else{

					$this->error('修改失败！！');
				}
			}else{
				$id=I('get.id');
				var_dump($id);
				$data=$m->field('name,id')->where('id='.$id)->find();
				var_dump($data);
			
				$this->assign('data',$data);
				$this->display();
			}

		}
		
	}



?>