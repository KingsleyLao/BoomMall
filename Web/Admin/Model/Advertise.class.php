<?php
	namespace Admin\Model;
	use Think\Model;

	class AdvertiseModel extends Model
	{
		
		public function getData()
		{
			$data = $this->select();
		
			$arr = array(1=>'打开显示',2=>'关闭显示');
			//通过地址引用在循环遍历的时候修改状态值。
			foreach ($data as &$v){
				$v['status']=$arr[$v['status']];
			}
		
			return $data;
		}

	
	}

?>