<?php
	namespace Home\Controller;
	use Think\Controller;
	class MaintainController extends Controller
	{
		public function _initialize ()
		{
			// $this->assign('config', $this->webConfig());
			// $this->assign('flink', $this->freindLink());

			
			$this->assign('flink',$this->flink());
			$this->assign('catData',$this->getCat());
			
		}
		


		protected function _empty()
		{
			R('Home/Empty/index');
		}

		protected function flink()
		{
			$aa = M('friendship')->field('name,url')->select();
			return $aa;
		}

		protected function getCat()
		{
			$m=M('cat');
			$catData=$m->field('id,name')->where('pid=0')->limit(8)->select();
			return $catData;
		}

	}