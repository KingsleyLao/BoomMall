<?php
	namespace Admin\Controller;
	use Think\Controller;
	

	class AttributesController extends Controller
	{
		public function index()
		{
			$id=I('get.id');
			$m=new \Think\Model();
			$data=$m->query("select a.id,t.name,a.attr_name from boom_Attributes as a,boom_goods_type as t where a.type_id=t.id and a.type_id=$id");
			$this->assign('id',$id);
			$this->assign('data',$data);
			$this->display();
		}

		public function delAttr()
		{
			$id = I('get.id');
			$m=M('Attributes');
			$bool=$m->where('id='.$id)->delete();
			if($bool){
				$this->success('删除成功！！');
			}else{
				$this->error('删除失败！！');
			}
		}

		public function addAttributes()
		{
			//哪一个类型的id
			$id=I('get.id');
			if(I('post.')){
				$m=M('Attributes');
				$data['attr_name']=I('post.attr_name');
				$data['type_id']=I('post.type_id');
				$bool=$m->add($data);
				if($bool){
					$this->success('添加成功！！',U("Attributes/index?id=$id"));
				}else{	
					$this->error('添加失败！！');
				}
			}else{
				$m=M('goods_type');
				$data=$m->field('id,name')->select();
				$this->assign('id',$id);
				$this->assign('type_data',$data);
				$this->display();
			}	
		}

		public function editAttr()
		{
			$m=M('Attributes');
			if(I('post.')){
				$data['attr_name']=I('post.attr_name');
				var_dump($data);
				$ed=I('post.ed');
				$id=I('get.id');
				var_dump($id);
				
				$bool=$m->where("id=$ed")->save($data);
				if($bool){
					$this->success('修改成功！！',U("Attributes/index?id=$id"));
				}else{

					$this->error('修改失败！！');
				}
			}else{
				$ed=I('get.ed');
				$id=I('get.id');
				$data=$m->field('id,attr_name')->where('id='.$ed)->find();
				//var_dump($data);
				$this->assign('id',$id);
				$this->assign('data',$data);
				$this->display();
			}
		}

	}


?>