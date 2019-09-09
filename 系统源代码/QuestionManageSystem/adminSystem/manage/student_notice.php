<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8"> 
   <title>管理员 学生公告</title>
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
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='index.php'">首页显示</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='teacher_account_manage.php'">教师账号</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='student_account_manage.php'">学生账号</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='course_manage.php'">课程管理</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='teacher_notice.php'">教师公告</button>
			 <button type="button" class="btn btn-default btn-block btn-warning" onclick="window.location.href='student_notice.php'">学生公告</button>
		</div>
		<div class="col-md-7 column">
			<p>
                <?php
                    $result=mysqli_query($con,"select * from notice_student where admin_username='${_SESSION["username"]}'");
                    $bookinfo=mysqli_fetch_array($result);
                    mysqli_free_result($result);
				if($bookinfo){
					echo '<strong>你已发布的通知：</strong>';
					echo '<br><strong>通知内容：</strong>';
					echo $bookinfo["notice_contents"];
					echo '<br><strong>发布时间：</strong>';
					echo $bookinfo["notice_time"];
					echo '<br><br><p><strong>你可以在下面更新你的通知，更新后的通知将会代替原来的消息。</strong></p>';
				}else{
					echo '<strong>你还未发布过通知，<br>你可以在下面发布你的通知。</strong>';
				}
				?>
				<form action="notice_student_change.php" method="post" role="form">
					<p>
						<?php
						if($bookinfo){
							echo '<strong>要更新的通知内容：</strong>';
						}else{
							echo '<strong>要发布的通知内容：</strong>';
						}
						?>
					</p>
                    <textarea type="text" name="notice_contents" class="form-control" rows="4" placeholder="请输入通知内容"></textarea>
					<br>
					<?php
					if($bookinfo){
						echo '<button type="submit" class="btn btn-default btn-block btn-info">更新通知</button>';
						echo '<button type="button" class="btn btn-default btn-block btn-danger" onclick="window.location.href=\'notice_student_delete.php?admin_username='.$_SESSION["username"].'\''.'">删除通知</button>';
					}else{
						echo '<button type="submit" class="btn btn-default btn-block btn-info">发布通知</button>';
					}
					?>
				</form>
			</p>
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