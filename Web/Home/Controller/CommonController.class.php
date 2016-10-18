<?php
	namespace Home\Controller;

	class CommonController extends MaintainController
	{
		// //	接收用户id
		// protected $UserID = 0;

		public function _initialize()
		{
			parent::_initialize();
			if (empty($_SESSION['user']['id']))
			{
				$_SESSION['backUrl'] = $_SERVER['REQUEST_URI'];
				redirect(U('Home/login/login'));
			} else {
				// var_dump($_SESSION['user']['id']);
				$this->UserID = $_SESSION['user']['id'];
			}
		}

	}
