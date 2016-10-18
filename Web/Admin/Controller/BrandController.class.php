<?php
	namespace Admin\Controller;
	use Think\Controller;
	use Think\Page;

	class BrandController extends Controller
	{
		public function index()
		{
			$m=D('brand');
			$data=$m->getData();
			// var_dump($data);
			$this->assign('data',$data);
			$this->display();
		}

		public function upload()
		{
           // 实例化上传类    
          $upload= new \Think\Upload();
           // 设置附件上传大小    
          $upload->maxSize=75536;
        // 设置附件上传类型   
          $upload->exts=array('jpg', 'gif', 'png', 'jpeg');
          $upload->rootPath= './Public/';
          // 设置附件上传目录   
           $upload->savePath='./Uploads/'; 
          //返回上传信息
          $info=$upload->uploadOne($_FILES['userImg']);   
          // dump($info);exit;
          if( !$info ) {
            // 上传错误提示错误信息
              // $this->error($upload->getError()); 
              $data['status']=404;
              //错误信息
              $data['msg']= $upload->getError();
              echo  json_encode($data);
          }else{
              //上传成功 (图片路径、图片名字)
              $data['status']  = 200;
              $data['msg']     = 'UPLOAD SUCCESS';
              //图片原始名字
              $data['details']['originName'] = $info['name'];
              $data['details']['savename'] = $info['savename'];
              $data['details']['savepath'] = $info['savepath'];
              echo json_encode($data);  
          }
		}

		public function addBrand()
		{
			if(I('post.')){
				// var_dump(I('post.'));
				$m=D('brand');
				$bool=$m->addData(I('post.'));
				if($bool){
					$this->success('插入成功！！','index');
				}else{
					$this->error('插入失败！！');
				}
			}else{
				$this->display();
			}	
		}

		public function edit()
		{
			if(I('post.')){
				$m=D('brand');
				$id=I('post.ed');
				// var_dump($id);
				$bool=$m->addData(I('post.'),$id);
				if($bool){
					$this->success('修改成功！！');
				}else{
					$this->error('修改失败！！');
				}

			}else{
				$m=D('brand');
				$id=I('get.id');
				$data=$m->getData($id);
				// var_dump($data);
				$this->assign('data',$data);
				$this->display();
			}
		}

		public function del()
		{
			$id = I('id');
			// var_dump($id);

			D('brand')->delete($id);

			$this->success('删除成功');
		}
	}


?>