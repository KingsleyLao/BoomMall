<?php
	namespace Admin\Model;
	use Think\Model;

	class AuthModel extends Model
	{
		
		public function changeCat($authInfo)
		{

			foreach($authInfo as &$v){

				if($v['auth_level']== '1'){


					$v['auth_name'] = ' --/ '.$v['auth_name'];
					
				} else if($v['auth_level']== '0') {

					$v['auth_name'] = '<font color="red" >'.$v['auth_name'].'</font>';

				}

			}

			return $authInfo;
			// var_dump($authInfo);

		}

		public function saveData($post)
		{
			$auth_id = $post['id'];
			$auth_pid = $post['pid'];
			$auth_name = $post['auth_name'];


			$auth_c = $post['auth_c'];
			$auth_a = $post['auth_a'];
			
			

			$data['auth_name'] = $auth_name;
			$data['auth_pid'] = $auth_pid;
			$data['auth_c'] = $auth_c;
			$data['auth_a'] = $auth_a;


			if(!empty($auth_id)){


				$data['auth_path'] = $auth_pid == '0' ? $auth_id : $auth_pid.'-'.$auth_id;

				$data['auth_level'] = substr_count($data['auth_path'], '-');

				$res = $this->where("auth_id=$auth_id")->save($data);

				return $res;


			} else {


				$res = $this->add($data);

			
				$data['auth_path'] = $auth_pid == '0' ? $res : $auth_pid.'-'.$res;

				$data['auth_level'] = substr_count($data['auth_path'], '-');


				$this->where("auth_id=$res")->save($data);




				return $res;
				
			}






		}
	}

?>