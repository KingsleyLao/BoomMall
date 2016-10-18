<?php 
	namespace Admin\Model;
	use Think\Model;

	class AdminModel extends Model
	{
		 //  protected $_validate = array(     
		 //  array('verify','require','验证码必须！'),     
		 //  array('name','','帐号名称已经存在！',0,'unique',1), 
		 //  array('value',array(1,2,3),'值的范围不正确！',2,'in'), 
		 // array('repassword','password','确认密码不正确',0,'confirm'),  
		 // array('password','checkPwd','密码格式不正确',0,'function'), 
		 //       );

		public function getData()
		{
			date_default_timezone_set("PRC");
			$data = $this->select();
			
			// $sexArr = ['0'=>'男','1'=>女];
			foreach ($data as &$value) {
				$value['addtime'] = date('Y-m-d h:i:s',$value['addtime']);
			}
			return $data;
		}

		public function addData($post)
		{
			$post['addtime']=time();
			$post['password']= password_hash($post['password'], PASSWORD_BCRYPT);
			$res = $this->add($post);

			return $res;
			

		}
	}




 ?>