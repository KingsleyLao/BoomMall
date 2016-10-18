<?php
	namespace Admin\Controller;
	use Think\Controller;

	class CarouselController extends CommonController
	{
		public function index()
		{	
			//调用下面查询轮播图图片的所有数据库
			$a = $this->selectphoto();
			
			$b=1;
			$this->assign('a',$a);
			$this->assign('b',$b);
			$this->display();

		}

		public function selectphoto()
		{
			//查询数据库里的轮播图的图片
			$photo1 = D('carousel');
	        $a = $photo1->select();
	        return $a;
		}

		public function selectphotoDel()
		{
			$model = M('carousel');

			$res = $model->where('id='.I('get.id'))->delete();

			if ($res > 0) {
				$this->success('删除成功');
			} else { 
				$this->error('删除失败');
				
			}
		}

		 public function upload()
    	{    

	  	    /*
	          添加轮播图图片
	         */
	           // 实例化上传类    
	          $upload = new \Think\Upload();

	           // 设置附件上传大小    
	          $upload->maxSize= 3145728 ;

	        // 设置附件上传类型   
	          $upload->exts= array('jpg', 'gif', 'png', 'jpeg');

				//A开发者写了upload()   B开发
	          // 设置附件上传目录   
	           $upload->rootPath='./Public/uploads/'; 

	    
	          //返回上传信息
	          $info=   $upload->uploadOne($_FILES['file']);   
	          // dump($info);exit;
	          if( !$info ) {
	            // 上传错误提示错误信息
	              // $this->error($upload->getError()); 
	              $data['status'] = 404;

	              //错误信息
	              $data['msg']    = $upload->getError();
	              
	              echo  json_encode($data);


	          }else{
	            // 上传成功 (图片路径、图片名字)



	              
	              $data['status']  = 200;
	              $data['msg']     = 'UPLOAD SUCCESS';	       

	              //图片原始名字
	              $data['details']['originName'] = $info['name'];
	              $data['details']['savename'] = $info['savename'];
	              $data['details']['savepath'] = $info['savepath'];
	              $date['pic'] = $data['details']['savepath'].$data['details']['savename'];
	              $pic = $date['pic'];
	              //缩放图片格式
	              $image = new \Think\Image(); 
	              $img1='./Public/uploads/'.$date['pic'];        
					$a = $image->open($img1);
					//var_dump($a);
					// 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
					//var_dump($img2);

					$path='Public/thumb/'.$pic;
					$res = $image->thumb(670, 400,\Think\Image::IMAGE_THUMB_FIXED)->save($img1);
					
					            

	              $photo = M('carousel');
	              $photo->add($date);
				
	             

	          }
  	 }

}
	


?>