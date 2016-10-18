<?php
	namespace Admin\Model;
	use Think\Model;

	class CatModel extends Model
	{
		//关于自动验证
		 protected $_validate = array(    
		 array('name','require','名称不能为空！'),  
		 array('name','','名称已经存在！',0,'unique',1),   
		 array('desc','require','分类描述不能为空！！'),     
		   );
		public function getData()
		{
			$data = $this->select();
		
			$arr = array(1=>'o',2=>'x');
			//通过地址引用在循环遍历的时候修改状态值。
			foreach ($data as &$v){
				$v['status']=$arr[$v['status']];
			}
		
			return $data;
		}

		public function getAddData()
		{
			$data=$this->field('id,name,pid')->select();
			return $data;
		}
	}

?>