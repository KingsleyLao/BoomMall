<?php 
	namespace Home\Model;
	use Think\Model;

	class UserModel extends Model
	{
		 

		public function dataSave($post)
		{
			unset($post['code']);

			$post['password'] = password_hash($post['password'],PASSWORD_DEFAULT);
			$post['addtime'] = time();

			$res = $this->add($post);
			return $res;


		}

		
	}




 ?>