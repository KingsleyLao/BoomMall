<?php 
namespace Admin\Model;
use Think\Model;
class DiscussModel extends Model
{
	public function getTime()
	{
		$data = $this->select();


		$order = M('order');

		foreach ($data as $k=>&$v){
			$addtime = $v['addtime'];
			$v['addtime'] = date('Y-m-d H:i:s',$addtime);
		}
		
		return $data;
	}


	public function getMessage($id)
	{
		$data = $this->select();

		$discuss = M('discuss');
		$user = M('user');
		$admin = M('admin');
		$order_detail = M('order_detail');

		foreach ($data as $k => &$v) {
			$addtime = $v['addtime'];
			$sayid = $v['sayid'];
			$replayid = $v['replayid'];
			$replaytime = $v['replaytime'];
			$gid = $v['gid'];

			// $useradd->field('name')->getField($private);
			// $useradd->field('name')->getField($city);
			// $useradd->field('name')->getField($area);
		
			$v['sayid'] = $user->where("id=$sayid")->getField('username');
			$v['replay'] = $discuss->where("id=$replayid")->getField('name');
			$v['gid'] = $order_detail->where("gid=$gid")->getField('gname');
			$v['addtime'] = date('Y-m-d H:i:s',$addtime);
			$v['replaytime'] = date('Y-m-d H:i:s',$replaytime);

			
			
		}
		return $data;
	}
	
}




 ?>