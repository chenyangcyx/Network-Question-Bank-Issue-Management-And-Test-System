<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8"> 
   <title>管理员 首页</title>
   <link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>
<body background="..\login\images\back.gif">
<?php
	session_start ();
	if (isset ( $_SESSION ["code"] )) {//判断code存不存在，如果不存在，说明异常登录
	?>
<script src="../../js/bootstrap.js"></script>
<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<p>
				<br><br>
			</p>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-1 column">
		</div>
		<div class="col-md-4 column">
			<h3>
				网络题库发布管理与测验系统<br>管理员界面
			</h3>
		</div>
		<div class="col-md-2 column">
		</div>
		<div class="col-md-2 column">
			<p class="text-right" style="font-size:18px">
			<br><br><strong>当前账号：<?php echo "${_SESSION["username"]}";//显示登录用户名 ?></strong>
			</p>
		</div>
		<div class="col-md-2 column">
			<br><br><button type="button" class="btn btn-default btn-block btn-warning" onclick="window.location.href='exit.php'">注销登录</button>
		</div>
		<div class="col-md-1 column">
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-12 column">
			<p>
			</p>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-1 column">
		</div>
		<div class="col-md-10 column">
			<div class="alert alert-dismissable alert-info">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4>
				<strong>欢迎你，管理员！</strong>
				</h4> 在开始使用本系统前，请详细阅读界面首页的操作使用提示！
			</div>
			<div class="row clearfix">
				<div class="col-md-12 column">
					<p>
						 <br>
					</p>
				</div>
			</div>
		</div>
		<div class="col-md-1 column">
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-1 column">
		</div>
		<div class="col-md-3 column">
			 <button type="button" class="btn btn-default btn-block btn-warning" onclick="window.location.href='index.php'">首页显示</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='teacher_account_manage.php'">教师账号</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='student_account_manage.php'">学生账号</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='course_manage.php'">课程管理</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='teacher_notice.php'">教师公告</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='student_notice.php'">学生公告</button>
		</div>
		<div class="col-md-7 column">
			<p>
				 <strong>您的登录信息：</strong>
			</p>
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>
							用户名
						</th>
						<th>
							IP地址
						</th>
						<th>
							登录日期
						</th>
						<th>
							使用语言
						</th>
					</tr>
				</thead>
				<tbody>
					<tr class="warning">
						<td>
							<?php echo "${_SESSION["username"]}";//显示登录用户名 ?>
						</td>
						<td>
							<?php echo "${_SERVER['REMOTE_ADDR']}";//显示ip ?>
						</td>
						<td>
							<?php echo date("Y-m-d");?>
						</td>
						<td>
							<?php echo "${_SERVER['HTTP_ACCEPT_LANGUAGE']}";//使用的语言 ?>
						</td>
					</tr>
				</tbody>
			</table>
			<dl>
				<dt>
					<br>功能使用介绍：
				</dt>
				<dd>
					<strong>首页显示：</strong>回到首页，即现在正在打开阅读的网页。
				</dd>
				<dd>
					<strong>教师账号：</strong>进入“教师账号管理”界面。在界面中，你可以删除一些现有的教师的账号。
				</dd>
				<dd>
					<strong>学生账号：</strong>进入“学生账号管理”界面。在界面中，你可以删除一些现有的学生的账号。
				</dd>
				<dd>
					<strong>课程管理：</strong>进入“课程管理”界面。在界面中，你可以增加、删除现有的课程类别。
				</dd>
				<dd>
					<strong>教师公告：</strong>进入“教师公告发布”界面。在界面中，你可以发布对所有教师的公告内容。
				</dd>
				<dd>
					<strong>学生公告：</strong>进入“学生公告发布”界面。在界面中，你可以发布对所有学生的公告内容。
				</dd>
			</dl>
		</div>
		<div class="col-md-1 column">
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-1 column">
		</div>
		<div class="col-md-10 column">
			<p>
				 <br>
			</p>
			<p class="text-center">
				 数据库课程设计：网络题库发布管理与测验系统    制作：陈扬    王子聪    徐昊
			</p>
		</div>
		<div class="col-md-1 column">
		</div>
	</div>
</div>

<?php
} else {//code不存在，调用exit.php 退出登录
  ?>
<script type="text/javascript">
  alert("请先登录再访问！");
  window.location.href="exit.php";
</script>
<?php
}
?>

</body>