<?php
	namespace Home\Widget;
	use Think\Controller;
	class CateWidget extends Controller 
	{    
		public function menu()
		{        
			$m=M('cat');
			$cat=$m->field('id,name')->select();

			$this->assign('cat', $cat);
			$this->display('Public/base');
		 }
	}



?>