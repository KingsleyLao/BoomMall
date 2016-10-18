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


	<link href="/BoomMall v1/Boommall/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">




	<title>品牌类型</title>


</head>

<body>


	<div class="row">
		<div style="margin-top:20px" class="container col-md-3 col-md-offset-5">
			<button type="button" class="btn btn-primary "><a href="/BoomMall v1/Boommall/Admin/Brand/addBrand" style="color:white">添加品牌</a></button>
		</div>
		<div class="container col-md-8" style="margin-top:60px">
				<table class="table  table-bordered table-hover table-striped" >
					<tr>
						<th>品牌名</th>
						<th>图片</th>
						<th>品牌描述</th>
						<th>操作</th>	
					</tr>

				<?php if(is_array($data)): foreach($data as $key=>$vo): ?><tr>
						<td><?php echo ($vo["bname"]); ?></td>
					
						<td>
							<img width="60" class="product-thumb" src="/BoomMall v1/Boommall/Public<?php echo ($vo["pic"]); ?>">
						</td>
					
						<td><?php echo ($vo["desc"]); ?></td>
						<td><a href="/BoomMall v1/Boommall/Admin/Brand/del/id/<?php echo ($vo["id"]); ?>" onclick="return confirm('是否确认删除？？') "><i class='icon-trash'></i></a>|<a href="/BoomMall v1/Boommall/Admin/Brand/edit/id/<?php echo ($vo["id"]); ?>"><i class='icon-pencil'></i></a>
					</tr><?php endforeach; endif; ?>
			</table>
		</div>
	</div>






</body>
</html>


	<script src="/BoomMall v1/Boommall/Public/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/BoomMall v1/Boommall/Public/js/jquery-1.7.2.min.js"></script>