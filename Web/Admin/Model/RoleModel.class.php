<?php 
	namespace Admin\Model;
	use Think\Model;

	class RoleModel extends Model
	{
		/**
		 * 
		 */
		public function getName($rid)
		{	
			if ($rid == '0') {
				
				$data = "超级管理员";
			} else {
				
				$data = $this->field('role_name')->find($rid)['role_name'];	
			}

			return $data;	
		}

		public function saveAuth($post)
		{
			
			$id = $post['id'];
			// var_dump($post['auth_id']);

			if(!empty($post['auth_id'])){
				$auth_ids = implode(',', $post['auth_id']);

				$authInfo = D('auth')->field('auth_c,auth_a,auth_level')->select($auth_ids);
				
				// var_dump($authInfo);

				$str = '';

				foreach ($authInfo as $v) {
					if ($v['auth_level'] !== '0') {
						$str .= $v['auth_c'].'-'.$v['auth_a'].',';
					}
				}

				$str = rtrim($str,',');
			} else {

				$str = '';
				$auth_ids = '';

			}

			//如果存在$id为修改操作,如果没有$id,则为添加操作
			if (empty($id)) {
					
				$data['role_auth_ids'] = $auth_ids;;
				$data['role_auth_ac'] = $str;
				$data['role_name'] = $post['roleName'];

				$res = $this->add($data);

				return $res;

			} else {
				
				$data['role_auth_ids'] = $auth_ids;;
				$data['role_auth_ac'] = $str;
				$data['role_name'] = $post['roleName'];
				$res = $this->where("role_id = $id")->save($data);				
				return $res;
			}
			

		}

	}




 ?>