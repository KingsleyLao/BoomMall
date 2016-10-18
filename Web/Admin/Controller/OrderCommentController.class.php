<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
class OrderCommentController extends CommonController {
    public function index()
   {
      //接收传过来的搜索值
      if(!empty(I('get.word'))){
        
        $map['order_num']=['like', '%'.I('get.word').'%'];
        $map['sayid']=['like', '%'.I('get.word').'%'];
        $map['_logic']='OR';
      }
            // var_dump($map);
        $discuss=M('discuss');
        // //分页类            
        $page= new Page($discuss->where($map)->count(),3);
        $data=D('discuss')->field('id,order_num,addtime,star,gid,sayid,saycomment,status')->where($map)->limit($page->firstRow.','.$page->listRows)->getMessage();
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
            
        $btn=$page->show();
        //这里应该在model处理
        $status = array('0'=>'隐藏','1'=>'显示');
        
        $this->assign('status',$status);
        $this->assign('totalRows', $page->totalRows);
        $this->assign('totalPages', $page->totalPages);
        $this->assign('btn', $btn);
        $this->assign('count',$mapcount);
        $this->assign('data',$data);
        $this->display();
      }


      function replay()
      {
        // var_dump($_SESSION);
      	// echo  '11111';
      	$id = I('get.id');
      	$comment = D('discuss')->field('id,addtime,sayid,saycomment,star,replayid,recomment,replaytime,gid')->where("id=$id")->getMessage($id);
      	// var_dump($comment);
      	$this->assign('comment',$comment);
      	$this->display();
      }


      function doreplay()
      {
      	// var_dump(I('post.'));
      	// var_dump($_SESSION);
      	$id = I('post.id');
      	$map['recomment'] = I('post.recomment');
      	$map['replayid'] = $_SESSION['admin']['name'];
      	$map['replaytime'] = time();
      	// echo '1111';
     	  $res = M('discuss')->where("id=$id")->save($map);
     	  // var_dump($res);
        if ($res) {
            $this->success('回复成功',"replay?id=$id");
        } else {
            $this->error('回复失败',"replay?id=$id");
        }
      }

      function changeStatus()
      {
          $id = I('get.id');
          $status = I('get.status');
          $status = $status^1;

          $model = M('discuss');
          $model->status = "$status";
          // var_dump($status);
          $res = $model->where("id=$id")->save();
          // var_dump($res);

           if ($res) {
            $this->success('修改成功',"");
          } else {
              $this->error('修改失败',"");
          }


      }

} 