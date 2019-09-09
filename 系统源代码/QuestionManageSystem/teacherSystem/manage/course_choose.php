<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8"> 
   <title>教师 授课课程</title>
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
						$teacher_name=$bookinfo["teacher_name"];
						$teacher_id=$bookinfo["teacher_id"];
						$result=mysqli_query($con,"select * from teacher_course where teacher_id='{$teacher_id}'");
						$bookinfo=mysqli_fetch_array($result);
						$teacher_course_id=$bookinfo["course_id"];
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
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='index.php'">首页显示</button>
			 <button type="button" class="btn btn-default btn-block btn-warning" onclick="window.location.href='course_choose.php'">授课课程</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='create_question.php'">创建题目</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='question_condition.php'">做题情况</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='message.php'">收到留言</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='edit_password.php'">修改密码</button>
		</div>
		<div class="col-md-7 column">
				<?php
          $result=mysqli_query($con,"select * from id_course;");
          if($result && mysqli_num_rows($result)){
			echo '<p><strong>已有课程信息：</strong><br>你可以在如下列表中更改你的选项。绿色代表可选，红色代表已经选择。</p>';
			echo '<table class="table table-bordered table-hover">';
			echo '<thead><tr><th>课程编号</th><th>课程名</th><th>是否可选</th><th>已经选择</th><th>选择课程</th></tr></thead><tbody>';
            $num=1;
            while($row=mysqli_fetch_assoc($result)){
              if($num%2==0){
                echo '<tr class="success">';
              }else{
                echo '<tr>';
              }
              echo '<td>'.$row['course_id'].'</td>';
							echo '<td>'.$row['course_name'].'</td>';
							echo '<td>'.'是'.'</td>';
							if($row['course_id']==$teacher_course_id){
								echo '<td>'.'是'.'</td>';
								echo '<td>';
								echo '<button type="button" class="btn btn-default btn-block btn-danger btn-xs">已选此课程</button>';
								echo '</td>';
							}else{
								echo '<td>'.'否'.'</td>';
								echo '<td>';
								echo '<button type="button" class="btn btn-default btn-block btn-success btn-xs" onclick="window.location.href=\'course_choose_action.php?id='.$row['course_id'].'\''.'">选择此课程</button>';
								echo '</td>';
							}
              $num++;
            }
          }else{
            echo '<strong>'.'暂时未开设课程，无法选择！'.'</strong>';
          }
        ?>
				</tbody>
			</table>
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