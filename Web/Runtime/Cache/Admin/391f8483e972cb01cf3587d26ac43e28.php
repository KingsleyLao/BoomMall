<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />


<LINK rel="Bookmark" href="/favicon.ico" >
<LINK rel="Shortcut Icon" href="/favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/BoomMall v1/Boommall/Public/lib/html5.js"></script>
<script type="text/javascript" src="/BoomMall v1/Boommall/Public/lib/respond.min.js"></script>
<script type="text/javascript" src="/BoomMall v1/Boommall/Public/lib/PIE_IE678.js"></script>
<![endif]-->
<link href="/BoomMall v1/Boommall/Public/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="/BoomMall v1/Boommall/Public/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
<link href="/BoomMall v1/Boommall/Public/skin/default/skin.css" rel="stylesheet" type="text/css" id="skin" />
<link href="/BoomMall v1/Boommall/Public/lib/Hui-iconfont/1.0.1/iconfont.css" rel="stylesheet" type="text/css" />
<link href="/BoomMall v1/Boommall/Public/css/style.css" rel="stylesheet" type="text/css" />
<!-- <link href="/BoomMall v1/Boommall/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" /> -->
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->


<title>H-ui.admin v2.3</title>
<meta name="keywords" content="H-ui.admin v2.3,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
<meta name="description" content="H-ui.admin v2.3，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>
<header class="Hui-header cl"> <a class="Hui-logo l" title="Boom 后台" >Boom 后台</a> 
	
	<ul class="Hui-userbar">
		<li><?php echo ($roleName); ?></li>
		<li class="dropDown dropDown_hover"><a href="#" class="dropDown_A"><?php echo ($adminName); ?> <i class="Hui-iconfont">&#xe6d5;</i></a>
			<ul class="dropDown-menu radius box-shadow">
				<li><a href="#">个人信息</a></li>
				<li><a href="#">切换账户</a></li>
				<li><a href="<?php echo U('login/loginout');?>">退出</a></li>
			</ul>
		</li>
		<li id="Hui-msg"> <a href="#" title="消息"><span class="badge badge-danger">1</span><i class="Hui-iconfont" style="font-size:18px">&#xe68a;</i></a> </li>
	</ul>
	<a aria-hidden="false" class="Hui-nav-toggle" href="#"></a> </header>
<aside class="Hui-aside">
	<input runat="server" id="divScrollValue" type="hidden" value="" />
	<div class="menu_dropdown bk_2">
		
		<?php if(is_array($auth_infoA)): foreach($auth_infoA as $key=>$v): ?><dl id="menu-admin">
			<dt><i class=".Hui-iconfont-unordered-list">&#xe6f5;</i> <?php echo ($v["auth_name"]); ?><i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
					<?php if(is_array($auth_infoB)): foreach($auth_infoB as $key=>$vo): if(($vo["auth_pid"]) == $v["auth_id"]): ?><li><a _href="/BoomMall v1/Boommall/Admin/<?php echo ($vo["auth_c"]); ?>/<?php echo ($vo["auth_a"]); ?>" href="javascript:void(0)"><?php echo ($vo["auth_name"]); ?></a></li><?php endif; endforeach; endif; ?>
				</ul>
			</dd>
		</dl><?php endforeach; endif; ?>
		
	</div>
</aside>
<div class="dislpayArrow"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
<section class="Hui-article-box">
	<div id="Hui-tabNav" class="Hui-tabNav">
		<div class="Hui-tabNav-wp">
			<ul id="min_title_list" class="acrossTab cl">
				<li class="active"><span title="我的桌面" data-href="/BoomMall v1/Boommall/Admin/Index/welcome">我的桌面</span><em></em></l
			</ul>
		</div>
		<div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
	</div>
	<div id="iframe_box" class="Hui-article">
		<div class="show_iframe">
			<div style="display:none" class="loading"></div>
			<iframe scrolling="yes" frameborder="0" src="welcome.html"></iframe>
		</div>
	</div>
</section>
<script type="text/javascript" src="/BoomMall v1/Boommall/Public/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/BoomMall v1/Boommall/Public/lib/layer/1.9.3/layer.js"></script> 
<script type="text/javascript" src="/BoomMall v1/Boommall/Public/js/H-ui.js"></script> 
<script type="text/javascript" src="/BoomMall v1/Boommall/Public/js/H-ui.admin.js"></script> 
<script type="text/javascript">
/*资讯-添加*/
function article_add(title,url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}
/*图片-添加*/
function picture_add(title,url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}
/*产品-添加*/
function product_add(title,url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}
/*用户-添加*/
function member_add(title,url,w,h){
	layer_show(title,url,w,h);
}
</script> 
<script type="text/javascript">
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?080836300300be57b7f34f4b3e97d911";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s)})();
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F080836300300be57b7f34f4b3e97d911' type='text/javascript'%3E%3C/script%3E"));
</script>
</body>
</html>