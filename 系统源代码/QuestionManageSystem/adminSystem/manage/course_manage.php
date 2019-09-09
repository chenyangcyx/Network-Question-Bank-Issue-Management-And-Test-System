
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8"> 
   <title>管理员 课程管理</title>
   <link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>
<body background="..\login\images\back.gif">
<?php
    session_start ();
    $con=mysqli_connect("localhost","root","root","stu_test");//连接mysql数据库
    if (!$con) {
      die('数据库连接失败'.mysqli_connect_error());
	}
	mysqli_query($con,"set names 'utf8'");
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
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='index.php'">首页显示</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='teacher_account_manage.php'">教师账号</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='student_account_manage.php'">学生账号</button>
			 <button type="button" class="btn btn-default btn-block btn-warning" onclick="window.location.href='course_manage.php'">课程管理</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='teacher_notice.php'">教师公告</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='student_notice.php'">学生公告</button>
		</div>
		<div class="col-md-7 column">
		<div class="row clearfix">
				<div class="col-md-1 column">
				</div>
				<form action="course_add.php" method="post" role="form">
				<div class="col-md-4 column">
					<p class="text-right">
						 <strong>要添加的课程编号：</strong><br><br><br>
						 <strong>要添加的课程名称：</strong>
					</p>
				</div>
				<div class="col-md-4 column">
				<input type="text" name="add_course_id" class="form-control" id="name" placeholder="请输入课程编号">
				<br>
				<input type="text" name="add_course_name" class="form-control" id="name" placeholder="请输入课程名称">
				</div>
				<div class="col-md-2 column">
					<br>
					 <button type="submit" class="btn btn-default btn-block btn-success">添加课程</button>
				</div>
				</form>
				<div class="col-md-1 column">
				</div>
			</div>
				<?php
                    $result=mysqli_query($con,"select * from id_course;");
                    if($result && mysqli_num_rows($result)){
						$num=1;
						echo '<p><br><br><strong>所有的课程信息如下：</strong></p>';
						echo '<table class="table table-hover table-bordered"><thead><tr><th>课程编号</th><th>课程名称</th><th>删除</th></tr></thead><tbody>';
                        while($row=mysqli_fetch_assoc($result)){
                            if($num%2==0){
                                echo '<tr class="warning">';
                            }else{
                                echo '<tr>';
                            }
                            echo '<td>'.$row['course_id'].'</td>';
							echo '<td>'.$row['course_name'].'</td>';
							echo '<td>';
                            echo '<button type="button" class="btn btn-default btn-block btn-danger btn-xs" onclick="window.location.href=\'course_delete.php?course_id='.$row['course_id'].'\''.'">删除此课程</button>';
                            echo '</td>';
                            $num++;
						}
						echo '</tbody></table>';
                    }else{
                        echo '<strong>'.'没有任何课程信息！'.'</strong>';
                     }
                ?>
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