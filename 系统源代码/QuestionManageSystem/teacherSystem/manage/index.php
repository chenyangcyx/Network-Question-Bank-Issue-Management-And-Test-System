<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8"> 
   <title>教师 首页</title>
   <link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>
<body background="..\login\images\back.gif">
<?php
	session_start ();
	if (isset ( $_SESSION ["code"] )) {//判断code存不存在，如果不存在，说明异常登录
		$con=mysqli_connect("localhost","root","root","stu_test");//连接mysql数据库
		if (!$con) {
		  die('数据库连接失败'.mysqli_connect_error());
		}
		mysqli_query($con,"set names 'utf8'");
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
				网络题库发布管理与测验系统<br>教师界面
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
				<?php
					$result=mysqli_query($con,"select * from teacher_info where teacher_username='${_SESSION["username"]}'");
					$bookinfo=mysqli_fetch_array($result);
					$teacher_id=$bookinfo["teacher_id"];
					$teacher_name=$bookinfo["teacher_name"];
					$username=$_SESSION["username"];
				?>
				<h4>
				<strong>欢迎你，<?php echo "$teacher_name"?>！</strong></h4>
				<?php
					$notice_check=mysqli_query($con,"select * from notice_teacher");
					$notice=mysqli_fetch_array($notice_check);
					if(!$notice){
						echo '<strong>目前暂无管理员发布的通知。</strong><br>'.'在开始使用本系统前，请详细阅读界面首页的操作使用提示！';
					}else{
						echo '<strong>'.'现有通知：'.'</strong>'.'<br>';
						mysqli_free_result($notice_check);
						$notice_check=mysqli_query($con,"select * from notice_teacher");
						while($row_notice=mysqli_fetch_assoc($notice_check)){
							echo '<strong>'.$row_notice['admin_username'].'：</strong>'.$row_notice['notice_contents'].'          '.'<strong>发布于：</strong>'.$row_notice['notice_time'].'<br>';
						}
					}
				?>
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
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='course_choose.php'">授课课程</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='create_question.php'">创建题目</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='question_condition.php'">做题情况</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='message.php'">收到留言</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='edit_password.php'">修改密码</button>
		</div>
		<div class="col-md-7 column">
			<p>
				 <strong>您的登录信息：</strong>
			</p>
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>
							编号
						</th>
						<th>
							姓名
						</th>
						<th>
							用户名
						</th>
						<th>
							登录日期
						</th>
					</tr>
				</thead>
				<tbody>
					<tr class="warning">
						<td>
							<?php echo "$teacher_id";//显示教师编号 ?>
						</td>
						<td>
							<?php echo "$teacher_name";//显示教师名称 ?>
						</td>
						<td>
							<?php echo "$username" //显示账号名称?>
						</td>
						<td>
							<?php echo date("Y-m-d");?>
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
					<strong>授课课程：</strong>进入“授课课程管理”界面。在界面中，你可以选择修改自己所教授的课程，此修改将导致自己所创建题目的类别发生变化！
				</dd>
				<dd>
					<strong>创建题目：</strong>进入“创建题目”界面。在界面中，你可以在自己所选定的授课课程类别下创建相应的题目。
				</dd>
				<dd>
					<strong>做题情况：</strong>进入“课程管理”界面。在界面中，你可以了解自己的题目被学生的使用情况及一些其他信息。
				</dd>
				<dd>
					<strong>收到留言：</strong>进入“收到留言”界面。在界面中，你可以了解其他学生给自己发送的留言，并删除一些留言。
				</dd>
				<dd>
					<strong>修改密码：</strong>进入“课程管理”界面。在界面中，你可以修改自己的账号密码。
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
  mysqli_close($con);  //关闭数据库连接
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