<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8"> 
   <title>教师 收到留言</title>
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
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='index.php'">首页显示</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='course_choose.php'">授课课程</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='create_question.php'">创建题目</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='question_condition.php'">做题情况</button>
			 <button type="button" class="btn btn-default btn-block btn-warning" onclick="window.location.href='message.php'">收到留言</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='edit_password.php'">修改密码</button>
		</div>
		<div class="col-md-7 column">
            <?php
                mysqli_free_result($result);
                $result=mysqli_query($con,"select * from messages where teacher_id='{$teacher_id}'");
                $bookinfo=mysqli_fetch_array($result);
                if($bookinfo){
                    echo '<p><strong>以下为你收到的留言信息，</strong>你可以查看或删除他们。</p>';
                    echo '<table class="table table-bordered table-hover">';
                    echo '<thead><tr><th></th><th>学生信息</th><th>留言时间</th><th>留言内容</th><th>删除</th></tr></thead>';
                    echo '<tbody>';
                    $num=1;
                    $line=1;
                    $result=mysqli_query($con,"select * from messages where teacher_id='{$teacher_id}'");
                    while($row=mysqli_fetch_assoc($result)){
                        if($line%2==0){
                            echo '<tr class="success">';
                        }else{
                            echo '<tr>';
                        }
                        echo '<td>'.$num.'</td>';
                        $result_temp=mysqli_query($con,"select * from student_info where student_id='{$row['student_id']}'");
                        $info=mysqli_fetch_array($result_temp);
                        echo '<td>'.$row['student_id'].' - '.$info['student_name'].'</td>';
                        echo '<td>'.$row['message_time'].'</td>';
                        echo '<td>'.$row['message_contents'].'</td>';
                        echo '<td>';
                        echo '<button type="button" class="btn btn-default btn-block btn-danger btn-xs" onclick="window.location.href=\'message_delete.php?student_id='.$row['student_id'].'&teacher_id='.$row['teacher_id'].'&message_time='.$row['message_time'].'\''.'">删除留言</button>';
                        echo '</td>';
                        echo '</tr>';
                        $num++;
                        $line++;
                    }
                    echo '</tbody></table>';
                }else{
                    echo '<p><strong>对不起，你还未收到任何通知。</strong></p>';
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