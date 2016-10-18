<?php 
	namespace Admin\Controller;
	use Think\Controller;
	class AdminController extends CommonController {


		public function adminList()
		{	

			$search = I('post.search');
			$map['name'] = array('like',"%".$search."%");


        	$mapcount= D('admin')->where($map)->count();
        	
			$page= new \Think\Page($mapcount,6);

			$page->setConfig('prev', '上一页');
        	$page->setConfig('next', '下一页');
        	
			$btn=$page->show();


			$adminList = D('admin')->field('id,name,phone,email,rid,addtime,state')->where($map)->limit($page->firstRow.','.$page->listRows)->getData($map);

			$roleInfo = D('role')->field('role_id,role_name')->select();

			// var_dump($adminList);

			$this->assign('btn', $btn);
			$this->assign('totalRows', $page->totalRows);
        	$this->assign('totalPages', $page->totalPages);
			$this->assign('search', $search);
			$this->assign('roleInfo', $roleInfo);
			$this->assign('adminList',$adminList);
			$this->display();

			
		}

		public function adminChange()
		{
			$id = I('get.id');
			$state = I('get.state');

			$change = D('admin');
			$change->state = $state;
			$change->where("id=$id")->save();

		}

		public function adminAdd()
		{
			
			if(IS_POST){

				$res = D('admin')->addData(I('post.'));
				echo $res;

			} else {

				$roleInfo = D('role')->field('role_id,role_name')->select();

				$this->assign('roleInfo', $roleInfo);

				$this->display();

			}

			
		}

		public function checkAdminName()
		{
			
			// var_dump(I('get.'));
			$name = I('get.name');
			$res = D('admin')->where("name='$name'")->find();
			echo $res;
		}

		public function adminEdit()
		{
			if(IS_POST){

				$id = I('post.id');
				$post = I('post.');
				$post['password'] = password_hash($post['password'], PASSWORD_BCRYPT);

				$res = D('admin')->where("id=$id")->save($post);
				echo $res;


			} else {

				$id = I('get.id');

				$adminInfo = D('admin')->field('id,name,password,phone,email,rid')->where("id=$id")->find();
				$roleInfo = D('role')->field('role_id,role_name')->select();
				// var_dump($adminInfo);
				// var_dump($roleInfo);

				$this->assign('adminInfo', $adminInfo);
				$this->assign('roleInfo', $roleInfo);
				$this->display();
			}
		}

		public function checkOldpass()
		{
			$oldpass = I('get.pass');
			$id = I('get.id');
			
			$passA = D('admin')->field('password')->where("id=$id")->getField('password');

			if( password_verify($oldpass,$passA ) ){

				echo 'aa';

			} else {

				echo null;
			}

			

		}

		public function del()
		{
			$id = I('get.id');

			D('admin')->delete($id);

		}


	}


 ?>