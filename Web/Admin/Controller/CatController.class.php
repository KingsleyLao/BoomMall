<?php
	namespace Admin\Controller;
	use Think\Controller;

	class CatController extends CommonController
	{
		protected function getTree($data,$pid=0,$count=0)
		{
			//定义一个静态数组。
			static $new = array();
			foreach ($data as $v) {
				if($v['pid']==$pid){
					$v['count']=$count;

					
					$v['newName']=str_repeat('&nbsp;', $v['count']*14).'|--'.$v['name'];
					$new[]=$v;
					$this->getTree($data,$v['id'],$count+1);
				}
			}
			return $new;
		}

		public function index()
		{
			//实例化一个对象进行查询数据库
			$M = D('cat');

			//获取后的数据
			$cData = $M->getData();

			$new = $this->getTree($cData);


			//分配数据
			$this->assign('new',$new);
			$this->display();
		}

		public function del()
		{
			//获取传过来的id值
			$id = I('get.id');
			//var_dump($id);

			//实例化一个对象
			$m= M('cat');
			
			//判断传过来的分类是否有后代子类
			$data=$m->where('pid='.$id)->getfield('name');

			if(empty($data)){
				$bool = $m->delete("$id");
				if($bool) $this->success('删除成功!!');
			}else{
				$this->error('此分类存在子类不能删除！！');
			}
		}

		public function changestatus()
		{
			$data = I('get.');
			//var_dump($data);
			//echo $data['id'];
			$m=M('cat');

			if($data['logo']=='o'){
				$num['status']=2;
				$bool=$m->where('id='.$data['id'])->save($num);
			}

			if($data['logo']=='x'){
				$num['status']=1;
				$bool=$m->where('id='.$data['id'])->save($num);
			}

			if($bool){
				echo '11';
			}
		}

		public function addCat()
		{
			if(I('post.')){
				//var_dump(I('post.'));
				$m=D('cat');
				//进行数据验证
				if(!$m->create()){
					$this->error($m->getError());
					die();
				}else{
					$bool=$m->add();
				}
				//判断是否插入成功
				if($bool){
					$this->success('添加成功！！','index');
				}else{
					$this->error('添加失败！！');
				}
			}else{
				$M = D('cat');
				//获取后的数据
				$cData = $M->getAddData();

				$new = $this->getTree($cData);

				//分配数据
				$this->assign('new',$new);
				$this->display();
			}
		}

		public function edit()
		{
			if(I('post.')){

				$id=I('post.id');
				$m=D('cat');
				$bool=$m->create();

				if(!$bool){
					$this->error($m->getError());
				}else{
					$bool=$m->where("id=$id")->save();
					if($bool){
						$this->success('修改成功！！','index');
					}else{
						$this->error('修改失败！！');
					}
				}
			}else{
				$M = D('cat');
				//获取后的数据
				$cData = $M->getAddData();

				$new = $this->getTree($cData);
				//找到传过来的id的相对应的数据值
				$id=I('get.id');

				$data=$M->where('id='.$id)->find();

				
				//分配分类树的数据  分配相应id的数据
				$this->assign('new',$new);
				$this->assign('data',$data);

				$this->display();
			}
			
		}

		//这个是用来分类的修改操作时候用的ajax，我也不知道怎么描述反正很痛苦。
		public function editAjax()
		{
			$id =I('param.id');
			$m=M('cat');
			$data=$m->field('pid')->where('id='.$id)->find();

			$str=json_encode($data);
			echo $str;
		}
	}

?>