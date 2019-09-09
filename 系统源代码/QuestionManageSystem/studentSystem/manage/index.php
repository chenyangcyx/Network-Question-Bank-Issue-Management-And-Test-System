<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8"> 
   <title>学生 首页</title>
   <link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>
<body background="..\login\images\back.png">
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
				网络题库发布管理与测验系统<br>学生界面
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
					$result=mysqli_query($con,"select * from student_info where student_username='${_SESSION["username"]}'");
					$bookinfo=mysqli_fetch_array($result);
					$student_id=$bookinfo["student_id"];
                    $student_name=$bookinfo["student_name"];
                    $student_class=$bookinfo["student_class"];
					$username=$_SESSION["username"];
				?>
                <h4>
				<strong>欢迎你，<?php echo "$student_name"?>！</strong></h4>
				<?php
					$notice_check=mysqli_query($con,"select * from notice_student");
					$notice=mysqli_fetch_array($notice_check);
					if(!$notice){
						echo '<strong>目前暂无管理员发布的通知。</strong><br>'.'在开始使用本系统前，请详细阅读界面首页的操作使用提示！';
					}else{
						echo '<strong>'.'现有通知：'.'</strong>'.'<br>';
						mysqli_free_result($notice_check);
						$notice_check=mysqli_query($con,"select * from notice_student");
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
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='course_choose.php'">学习课程</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='do_question.php?if=2&degree=0'">题目测验</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='question_condition.php'">做题情况</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='wrong_question_record.php'">错题记录</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='leave_message.php'">教师留言</button>
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
							学号
						</th>
						<th>
							姓名
						</th>
						<th>
							班级
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
						<?php echo "$student_id"; //显示学生学号 ?>
					</td>
					<td>
						<?php echo "$student_name"; //显示学生姓名 ?>
					</td>
					<td>
						<?php echo "$student_class"; //显示学生姓名 ?>
					</td>
					<td>
						<?php echo "$username"; //显示学生姓名 ?>
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
					<strong>学习课程：</strong>进入“学习课程管理”界面。在界面中，你可以选择修改自己所需要学习的课程，此修改将导致自己所测验题目的类别发生变化！
				</dd>
				<dd>
					<strong>题目测验：</strong>进入“创建题目”界面。在界面中，你可以在自己选择的课程下进行相应的题目测验。
				</dd>
				<dd>
					<strong>做题情况：</strong>进入“课程管理”界面。在界面中，你可以了解自己所做过的题目的情况及其他信息。
				</dd>
				<dd>
					<strong>错题记录：</strong>进入“课程管理”界面。在界面中，你可以了解自己所做的题目的错题记录并查看答案解析。
				</dd>
				<dd>
					<strong>教师留言：</strong>进入“教师留言”界面。在界面中，你可以查看自己的留言记录或删除他们，以及对指定老师发布新的留言记录。
				</dd>
				<dd>
					<strong>修改密码：</strong>进入“课程管理”界面。在界面中，你可以修改自己的账号密码。
				</dd>
			</dl>
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