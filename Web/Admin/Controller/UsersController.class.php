<?php 
	namespace Admin\Controller;
	use Think\Controller;
	class UsersController extends CommonController {


		public function usersList()
		{	
			
			
			if (I('get.status')!=="") {
				
				$status = I('get.status')== '0' ? '0': '1';
				
			} else {

				$status = 0;
			}


			// echo $status;

			// var_dump($status);
			$search = I('post.search');
			$map['username'] = array('like',"%".$search."%");


        	$mapcount= D('user')->where($map)->where("status=$status")->count();
        	
			$page= new \Think\Page($mapcount,6);

			$page->setConfig('prev', '上一页');
        	$page->setConfig('next', '下一页');
        	
			$aaa=$page->show();

			// var_dump($mapcount);
			// var_dump($btn);

			$usersInfo = D('user')->field('id,username,sex,phone,email,addtime,status')->where($map)->where("status=$status")->limit($page->firstRow.','.$page->listRows)->getData();
			

			$this->assign('status', $status);
			$this->assign('btn', $aaa);
			$this->assign('search', $search);
			$this->assign('totalRows', $page->totalRows);
        	$this->assign('totalPages', $page->totalPages);
			$this->assign('usersInfo', $usersInfo);
			$this->display();

			
		}

		public function changeStatus()
		{	
			// var_dump(I('get.'));
			D('user')->save(I('get.'));
		}

		
	}


 ?>