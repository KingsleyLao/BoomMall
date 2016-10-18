<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
	public function userInfo()
	{
		// // var_dump($_SESSION['user']['id']);
		// $userInfo = D('user')->field('username,sex,phone,email')->find(1);
		// $sexArr = ['0'=>'女','1'=>'男'];
		// $userInfo['sex'] = $sexArr[$userInfo['sex']];




		// $ch = curl_init();
	 //    $url = 'http://apis.baidu.com/avatardata/mingrenmingyan/lookup';
	 //    $header = array(
	 //        'apikey: 5e72b2bedf4e853f078c876d0fdf2ebd',
	 //    );

	 //    $data = ['keyword'=>'天才','dtype'=>'JSON','page'=>'2','rows'=>'5'];


	 //    // 添加apikey到header
	 //    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
	 //    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	 //    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	 //    // 执行HTTP请求
	 //    curl_setopt($ch , CURLOPT_URL , $url);
	 //    $res = curl_exec($ch);
	 //    $res1 = json_decode($res,true);

	 //    // var_dump($res1);
	 //    var_dump($res1['result']);






		 $ch = curl_init();
   		 $url = 'http://apis.baidu.com/txapi/mvtp/meinv?num=10';
	   	$header = array(
	        'apikey: 5e72b2bedf4e853f078c876d0fdf2ebd',
	    );
	    // 添加apikey到header
	    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    // 执行HTTP请求
	    curl_setopt($ch , CURLOPT_URL , $url);
	    $res = curl_exec($ch);

	    $res1 = json_decode($res,true);

	    // var_dump($res1);
	    // var_dump($res1['newslist']);


	    $this->assign('res1', $res1['newslist']);			




		
		$this->assign('userInfo',$userInfo);
		$this->display();
	}
}
?>