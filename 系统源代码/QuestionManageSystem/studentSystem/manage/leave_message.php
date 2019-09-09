<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8"> 
   <title>学生 教师留言</title>
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
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='index.php'">首页显示</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='course_choose.php'">学习课程</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='do_question.php?if=2&degree=0'">题目测验</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='question_condition.php'">做题情况</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='wrong_question_record.php'">错题记录</button>
			 <button type="button" class="btn btn-default btn-block btn-warning" onclick="window.location.href='leave_message.php'">教师留言</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='edit_password.php'">修改密码</button>
		</div>
		<div class="col-md-7 column">
			<?php
                $result=mysqli_query($con,"select messages.*,teacher_info.teacher_name from messages,teacher_info where messages.teacher_id=teacher_info.teacher_id and messages.student_id='{$student_id}'");
                $bookinfo=mysqli_fetch_array($result);
                if(!$bookinfo){
                    echo '<p><strong>你还未写过任何留言，赶紧在下面的留言板中留言吧！</strong></p>';
                }else{
					$num=1;
					$line=1;
                    echo '<p><strong>你的所有留言如下，你可以在列表中查看、删除。</strong></p>';
                    echo '<table class="table table-bordered table-hover">';
                    echo '<thead><tr><th></th><th>对象</th><th>时间</th><th>留言内容</th><th>删除</th></tr></thead>';
                    echo '<tbody>';
                    $result=mysqli_query($con,"select messages.*,teacher_info.teacher_name from messages,teacher_info where messages.teacher_id=teacher_info.teacher_id and messages.student_id='{$student_id}'");
                    while($row=mysqli_fetch_assoc($result)){
						if($line%2==0){
							echo '<tr class="success">';
						}else{
							echo '<tr>';
						}
                        echo '<td>'.$num.'</td>';
                        echo '<td>'.$row['teacher_id'].' - '.$row['teacher_name'].'</td>';
                        echo '<td>'.substr($row['message_time'],0,10).'</td>';
                        echo '<td>'.$row['message_contents'].'</td>';
                        echo '<td>';
                        echo '<button type="button" class="btn btn-default btn-block btn-danger btn-xs" onclick="window.location.href=\'message_delete.php?student_id='.$row['student_id'].'&teacher_id='.$row['teacher_id'].'&message_time='.$row['message_time'].'\''.'">删除留言</button>';
                        echo '</td>';
                        echo '</tr>';
						$num++;
						$line++;
                    }
                    echo '</tbody>';
                    echo '</table>';
                }
            ?>
            <p><br><strong>你可以在下面的输入留言内容，并选择你要留言的对象。</strong></p>
            <div class="row clearfix">
                <form action="leave_message_action.php" method="post" role="form">
                <div class="col-md-3 column">
                    <p><strong>留言对象：</strong></p>
                    <select class="form-control" name="teacher_id">
                        <?php
                            mysqli_free_result($result);
                            $result=mysqli_query($con,"select * from teacher_info");
                            while($row=mysqli_fetch_assoc($result)){
                                echo '<option>'.$row['teacher_id'].' - '.$row['teacher_name'].'</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-9 column">
                    <p><strong>留言内容：</strong></p>
                    <input type="text" name="message_contents" class="form-control" id="name" placeholder="请输入留言内容">
                </div>
	        </div>
            <div class="row clearfix">
                <div class="col-md-2 column">
                </div>
                <div class="col-md-8 column">
                    <br><button type="submit" class="btn btn-default btn-block btn-success">发送留言</button>
                </div>
                <div class="col-md-2 column">
                </div>
            </div>
            </form>
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