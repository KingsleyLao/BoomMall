<?php 
namespace Admin\Model;
use Think\Model;
class OrderModel extends Model
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

	
}




 ?>