<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<script type="text/javascript" src="/BoomMall v1/Boommall/Public/js/jquery-1.7.2.min.js"></script>
<script src="/BoomMall v1/Boommall/Public/bootstrap/js/bootstrap.min.js"></script>


<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<script type="text/javascript" src="lib/PIE_IE678.js"></script>
<![endif]-->
<link href="/BoomMall v1/Boommall/Public/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="/BoomMall v1/Boommall/Public/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
<link href="/BoomMall v1/Boommall/Public/css/style.css" rel="stylesheet" type="text/css" />
<link href="/BoomMall v1/Boommall/Public/lib/Hui-iconfont/1.0.1/iconfont.css" rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->




<title>管理员列表</title>


</head>

<body>


<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 管理员列表 
<a class="btn btn-success radius r mr-20" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20" style="padding-top:0px">
	
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"> <a href="javascript:;" onclick="admin_add('添加管理员','<?php echo U('Admin/adminAdd');?>','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a></span> 

	<div class="text-c r"> 
		<form action="<?php echo U('Admin/adminList');?>" method="post">
		<input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name="search" value="<?php echo ($search); ?>">
		<button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜管理员</button>
		</form>
	</div>

	</div>
	<table class="table table-border table-bordered table-bg">
		<thead>
			<tr>
				<th scope="col" colspan="9">员工列表</th>
			</tr>
			<tr class="text-c">
				<!-- <th width="25"><input type="checkbox" name="" value=""></th> -->
				<th width="40">ID</th>
				<th width="150">登录名</th>
				<th width="90">手机</th>
				<th width="150">邮箱</th>
				<th>角色</th>
				<th width="130">加入时间</th>
				<th width="100">是否已启用</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>

			
			<?php if(is_array($adminList)): foreach($adminList as $key=>$v): ?><tr class="text-c">
				<!-- <td><input type="checkbox" value="1" name=""></td> -->
				<td><?php echo ($v["id"]); ?></td>
				<td><?php echo ($v["name"]); ?></td>
				<td><?php echo ($v["phone"]); ?></td>
				<td><?php echo ($v["email"]); ?></td>
				
				<td>
				<?php if($v["rid"] == 0 ): ?>超级管理员
				<?php else: ?>
					
					<?php if(is_array($roleInfo)): foreach($roleInfo as $key=>$vo): if(($vo["role_id"]) == $v["rid"]): echo ($vo["role_name"]); endif; endforeach; endif; endif; ?>
				</td>

				<td><?php echo ($v["addtime"]); ?></td>
				<td class="td-status"><span class="label <?php echo ($v['state'] == 1 ? 'label-success':'label-default'); ?> radius"><?php echo ($v['state'] == 1? '已启用':'停用'); ?></span></td>
				

				<td class="td-manage">
					
					<?php if($v["rid"] != 0 ): ?><a style="text-decoration:none" onClick="<?php echo ($v['state'] == 1? 'admin_stop':'admin_start'); ?>(this,'<?php echo ($v["id"]); ?>')" href="javascript:;" title="<?php echo ($v['state'] == 0? '启用':'停用'); ?>"><i class="Hui-iconfont"><?php echo ($v['state'] == 1? '&#xe631':'&#xe615'); ?>;</i></a><?php endif; ?>

					<a title="编辑" href="javascript:;" onclick="admin_edit('管理员编辑','<?php echo U('Admin/AdminEdit');?>','<?php echo ($v['id']); ?>','800','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> 

					
					<?php if($v["rid"] != 0 ): ?><a title="删除" href="javascript:;" onclick="admin_del(this,'<?php echo ($v["id"]); ?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a><?php endif; ?>

					


					
					</td>
			</tr><?php endforeach; endif; ?>
			
			<tr >
				
				<td colspan="8" style="text-align:right;margin-right:5px">
				<a style="text-decoration:none" href="javascript:void(0)" class="btn btn-link">共有<?php echo ($totalRows); ?>条记录 第<?php echo ((isset($_GET['p']) && ($_GET['p'] !== ""))?($_GET['p']):1); ?>/<?php echo ($totalPages); ?>页</a>
				<?php echo ($btn); ?>
				</td>
			</tr>
		</tbody>
		
			
		
	</table>
	
</div>



<footer class="footer">
  <p>感谢jQuery、layer、laypage、Validform、UEditor、My97DatePicker、iconfont、Datatables、WebUploaded、icheck、highcharts、bootstrap-Switch<br>Copyright &copy;2015 H-ui.admin v2.3 All Rights Reserved.<br>
    本后台系统由<a href="http://www.h-ui.net/" target="_blank" title="H-ui前端框架">H-ui前端框架</a>提供前端技术支持</p>
</footer>



</body>
</html>



<script type="text/javascript" src="/BoomMall v1/Boommall/Public/lib/jquery/1.9.1/jquery.min.js"></script>  
<script type="text/javascript" src="/BoomMall v1/Boommall/Public/lib/layer/1.9.3/layer.js"></script> 
<script type="text/javascript" src="/BoomMall v1/Boommall/Public/lib/laypage/1.2/laypage.js"></script> 
<script type="text/javascript" src="/BoomMall v1/Boommall/Public/lib/My97DatePicker/WdatePicker.js"></script> 
<script type="text/javascript" src="/BoomMall v1/Boommall/Public/js/H-ui.js"></script> 
<script type="text/javascript" src="/BoomMall v1/Boommall/Public/js/H-ui.admin.js"></script> 
<script type="text/javascript">
/*
	参数解释：
	title	标题
	url		请求的url
	id		需要操作的数据id
	w		弹出层宽度（缺省调默认值）
	h		弹出层高度（缺省调默认值）
*/
/*管理员-增加*/
function admin_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-删除*/
function admin_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		
		$.get("<?php echo U('Admin/del');?>",'id='+id);
		
		$(obj).parents("tr").remove();
		layer.msg('已删除!',{icon:1,time:1000});
	});

}
/*管理员-编辑*/
function admin_edit(title,url,id,w,h){
	layer_show(title,url+'?id='+id,w,h);
}
/*管理员-停用*/
function admin_stop(obj,id){
	layer.confirm('确认要停用吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
		$.get('<?php echo U('Admin/adminChange');?>','state=0&id='+id);

		$(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,'+id+')" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
		$(obj).remove();
		layer.msg('已停用!',{icon: 5,time:1000});
	});
}

/*管理员-启用*/
function admin_start(obj,id){
	layer.confirm('确认要启用吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
		


		$.get('<?php echo U('Admin/adminChange');?>','state=1&id='+id);




		$(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,'+id+')" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
		$(obj).remove();
		layer.msg('已启用!', {icon: 6,time:1000});
	});
}


$(function(){
	$('.num').unwrap();
	$('.prev').attr('class','btn btn-primary radius');
	$('.next').attr('class','btn btn-primary radius');
	$('.num').attr('class','btn btn-default radius').css('background-color','white');
	$('.current').attr('class','btn btn-default radius').css('background-color','white');



});
</script>