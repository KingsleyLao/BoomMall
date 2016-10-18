<?php
	namespace Home\Controller;

	class EmptyController extends MaintainController
	{
		public function index()
		{
			$this->error('您访问的页面不存在！！','',3);
		}
	}
