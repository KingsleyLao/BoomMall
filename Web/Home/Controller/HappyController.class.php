<?php
namespace Home\Controller;
use Think\Controller;
class HappyController extends Controller {
	public function index($url, $params, $method = 'GET', $header = array(), $multi = false){
		  $opts = array(
		      CURLOPT_TIMEOUT        => 30,
		      CURLOPT_RETURNTRANSFER => 1,
		      CURLOPT_SSL_VERIFYPEER => false,
		      CURLOPT_SSL_VERIFYHOST => false,
		      CURLOPT_HTTPHEADER     => $header
		  );
		  
		  /* 根据请求类型设置特定参数 */
		  switch(strtoupper($method)){
		    case 'GET':
		      $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
		      break;
		    case 'POST':
		      //判断是否传输文件
		      //$params = $multi ? $params : http_build_query($params);
		      $opts[CURLOPT_URL] = $url;
		      $opts[CURLOPT_POST] = 1;
		      $opts[CURLOPT_POSTFIELDS] = $params;
		      break;
		    default:
		      throw new Exception('不支持的请求方式！');
		  }
		  
		  /* 初始化并执行curl请求 */
		  $ch = curl_init();
		  curl_setopt_array($ch, $opts);
		  $data  = curl_exec($ch);
		  $error = curl_error($ch);
		  curl_close($ch);
		  if($error) throw new Exception('请求发生错误：' . $error);
		  return  $data;
		}

		//笑话
		private function get_jock(){
		    $param=array(
		        "key"   => "free",
		        "appid" =>   "0",
		        "msg"   =>   "笑话"
		    );
		      
		    $datas=index("http://api.ajaxsns.com/api.php",$param);
		    $json=json_decode($datas);
		    if($json->result==0){
		        $content=str_replace("{br}","\n",$json->content);
		    }else{
		        $content="从前有座山,山上有座庙,庙里有个小和尚,-^-,连接出错,请稍后再试,^_^.";
		    }
		    return array($content,"text");

}

}

?>