<?php
	namespace Admin\Controller;
	use Think\Controller;
	use Think\Page;

	class Goodscontroller extends Controller
	{
		//商品列表页
		public function index()
		{
			//获取从搜索框过来的值

        	if(!empty(I('get.keyword'))){
        		
        		
        		$map['goodsname']=['like', '%'.I('get.keyword').'%'];
        		$map['desc']=['like', '%'.I('get.keyword').'%'];

        		
        		$map['_logic']='OR';


        	}
        	$m=M('goods');
        	//就是说在tp里面如果where里面的数据为空，就默认查全部的。
        	$mapcount= $m->where($map)->count();
        	
        	
			//实例化出一个分页对象，第一次参数是总共有多少条数据，没页显示5条。
			$page= new Page($mapcount,5);
			

			$data=$m->field('id,desc,goodsname,price,state')->where($map)->limit($page->firstRow.','.$page->listRows)->select();
			$data = D('goods')->getData($data);

			// var_dump($data);



			



			$page->setConfig('prev', '上一页');
        	$page->setConfig('next', '下一页');
        	
			$btn=$page->show();
			
			$this->assign('totalRows', $page->totalRows);
        	$this->assign('totalPages', $page->totalPages);
        	$this->assign('btn', $btn);
			$this->assign('count',$mapcount);
			$this->assign('data',$data);
			$this->display();
		}

		protected function getTree($data,$pid=0,$count=0)
		{
			//定义一个静态数组。
			static $new = array();
			foreach ($data as $v) {
				if($v['pid']==$pid){
					$v['count']=$count;
					$v['newName']=str_repeat('&nbsp;', $v['count']*10).'|--'.$v['name'];
					$new[]=$v;
					$this->getTree($data,$v['id'],$count+1);
				}
			}
			return $new;
		}

		public function changeState()
		{
			$data=I('get.');
			$m=M('goods');
			if(I('get.state')==1){
				$map['state']=2;
				$m->where('id='.I('get.id'))->save($map);
				die();
			}

			if(I('get.state')==2){
				$map['state']=1;
				$m->where('id='.I('get.id'))->save($map);
				die();
			}
		}

		//添加商品数据
		public function add()
		{
			if(I('post.')){
				// var_dump(I('post.'));
				
				//因为自动验证不能成功验证插件是否有成功赋值，所以要手动在这里去验证
				if(empty(I('post.img'))||empty(I('post.editorValue'))){
					$this->error('商品图片或商品详情为空，请添加数据');
					die();
				}
				//对应数据要插入的各个表进行实例化。
				$g=D('goods');
				$s=D('goods_size');
				$c=D('goods_color');
				$p=D('goods_pic');
				$d=D('goods_detail');
				$bool=$g->create();
				if(!$bool){
					$this->error($g->getError());
				}else{
					// echo 'caonidaye';
					//要插入goods表的数据
					$gdata['goodsname']=I('post.goodsname');
					$gdata['typeid']=I('post.typeid');
					$gdata['makein']=I('post.makein');
					$gdata['ispro']=I('post.ispro');
					$gdata['state']=I('post.state');
					$gdata['bid']=I('post.brand');
					$gdata['price']=I('post.price');
					$gdata['desc']=I('post.desc');
					$gdata['addtime']=date('Y-m-d H:i:s',time());
					//返回上一次插入goods数据表的id。
					$gid=$g->add($gdata);
					if(!$gid){
						$this->error('商品表添加失败！！');
						die();
					}

					//要插入size表的数据
					$sdata['size']=I('post.size');
					//定义一个数组去接受返回值
					$sid=array();
					//返回上一次插入size表的数据
					foreach($sdata['size'] as $k=>$v){
						$sdata['gid']=$gid;
						$sdata['size']=$v;
						$sid[]=$s->add($sdata);
					}
					//var_dump($sid);

					if(!$sid){
						$this->error('size表插入失败！！');	
					}

					//要插入颜色表的数据
					
					$cdata['sid']=$sid;
					$cdata['color']=I('post.color');
					$cdata['store']=I('post.store');
					for($i=0;$i<count($sid);$i++){
						$vv['gid']=$gid;
						$vv['sid']=$cdata['sid'][$i];
						$vv['color']=$cdata['color'][$i];
						$vv['store']=$cdata['store'][$i];
						$cid=$c->add($vv);
						//echo $cid;
					}
					if(!$cid){
						$this->error('颜色表插入失败！');	
					}

					//要插入图片表的数据
					$pdata['pic']=I('post.img');
					//1.因为商品的图片有可能不止一张，所以需要用遍历的方式去插入数据
					//2.反正都要循环了，把照片的格式顺便也在循环当中截取出来存入数据库吧
					foreach($pdata['pic'] as $k=>$v){
						$pdata['gid']=$gid;
						$pdata['pic']=$v;
						$pdata['type']=substr($v,strripos($v,'.')+1);
						$pid=$p->add($pdata);
					}
					if(!$pid){
						$this->error('图片表插入失败！');
						die();
					}


					//这是要插入商品详情表的数据
					$ddata['contents']=I('post.editorValue');
					$ddata['gid']=$gid;
					$ddata['addtime']=date('Y-m-d',time());
					$did=$d->add($ddata);
					if(!$did){
						$this->error('详情表插入失败！');
						die();
					}

					if($gid&&$sid&&$pid&&$cid&&$did){
						$this->success('插入成功！！');
					}else{
						$this->error('插入失败！！');
					}

				}
			}else{
				$m=M('cat');
				$b=M('brand');
				$data=$m->field('id,name,pid')->select();
				$brand=$b->field('id,bname')->select();
				// var_dump($brand);
				$newData=$this->getTree($data);
				$this->assign('data',$newData);
				$this->assign('brand',$brand);
				$this->display();
			}
		}

		public function upload()
		{
			/*
          添加商品 ：商品名、商品图片
         */

           // 实例化上传类    
          $upload = new \Think\Upload();

           // 设置附件上传大小    
          $upload->maxSize   = 75536;

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
              echo json_encode($data);  
          }
		}

		

		public function del()
		{
			$id = I('id');
			D('goods')->delete($id);
		}
	}


?>