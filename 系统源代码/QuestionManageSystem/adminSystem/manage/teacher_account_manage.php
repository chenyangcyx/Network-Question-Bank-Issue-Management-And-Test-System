<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8"> 
   <title>管理员 教师管理</title>
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
			 <button type="button" class="btn btn-default btn-block btn-warning" onclick="window.location.href='teacher_account_manage.php'">教师账号</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='student_account_manage.php'">学生账号</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='course_manage.php'">课程管理</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='teacher_notice.php'">教师公告</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='student_notice.php'">学生公告</button>
		</div>
		<div class="col-md-7 column">
                <?php
                    $result=mysqli_query($con,"select teacher_info.*,teacher_account.* from teacher_info,teacher_account where teacher_info.teacher_username=teacher_account.teacher_username");
                    if($result && mysqli_num_rows($result)){
						$num=1;
						echo '<p><strong>所有的教师信息如下：</strong></p><table class="table table-hover table-bordered">';
						echo '<thead><tr><th>编号</th><th>姓名</th><th>用户名</th><th>密码</th><th>重置账号</th><th>删除账号</th></tr></thead><tbody>';
                        while($row=mysqli_fetch_assoc($result)){
                            if($num%2==0){
                                echo '<tr class="warning">';
                            }else{
                                echo '<tr>';
                            }
                            echo '<td>'.$row['teacher_id'].'</td>';
                            echo '<td>'.$row['teacher_name'].'</td>';
                            echo '<td>'.$row['teacher_username'].'</td>';
                            echo '<td>'.$row['teacher_password'].'</td>';
                            echo '<td>';
                            echo '<button type="button" class="btn btn-default btn-block btn-success btn-xs" onclick="window.location.href=\'teacher_reset.php?id='.$row['teacher_username'].'\''.'">重置账号</button>';
                            echo '</td>';
                            echo '<td>';
                            echo '<button type="button" class="btn btn-default btn-block btn-danger btn-xs" onclick="window.location.href=\'teacher_delete.php?teacher_username='.$row['teacher_username'].'&teacher_id='.$row['teacher_id'].'\''.'">删除账号</button>';
                            echo '</td>';
                            echo '</tr>';
                            $num++;
						}
						echo '</tbody></table>';
                    }else{
                        echo '<strong>'.'暂无任何教师账号数据！'.'</strong>';
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