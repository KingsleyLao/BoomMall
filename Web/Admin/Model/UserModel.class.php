<?php 
	namespace Admin\Model;
	use Think\Model;

	class UserModel extends Model
	{
		 

		public function getData()
		{
			// date_default_timezone_set("PRC");
			

			$data = $this->select();
			
			$sexArr = ['0'=>'女','1'=>'男'];
			foreach ($data as &$value) {
				$value['sex'] = $sexArr[$value['sex']];
				$value['addtime'] = date('Y-m-d h:i:s',$value['addtime']);
			}
			return $data;
		}

		
	}




 ?>