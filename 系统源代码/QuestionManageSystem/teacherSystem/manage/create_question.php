<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8"> 
   <title>教师 创建题目</title>
   <link rel="stylesheet" href="../../css/bootstrap.min.css">
   	<!-- DataTables CSS -->
	<link rel="stylesheet" type="text/css" href="../../css/jquery.dataTables.min.css">
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
	<!-- jQuery -->
	<script src="../../js/jquery.js"></script>
	<!-- DataTables -->
	<script src="../../js/jquery.dataTables.js"></script>
<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
            <p>
				<br><br>
			</p>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-4 column">
            <h3>
				网络题库发布管理与测验系统<br>教师界面
			</h3>
		</div>
		<div class="col-md-4 column">
		</div>
		<div class="col-md-2 column">
            <p class="text-right" style="font-size:18px">
			<br><br><strong>当前账号：<?php echo "${_SESSION["username"]}";//显示登录用户名 ?></strong>
			</p>
		</div>
		<div class="col-md-2 column">
			<br><br><button type="button" class="btn btn-default btn-block btn-warning" onclick="window.location.href='exit.php'">注销登录</button>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-12 column">
            <p>
			</p>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-12 column">
			<div class="alert alert-dismissable alert-info">
				 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php
						$result=mysqli_query($con,"select * from teacher_info where teacher_username='${_SESSION["username"]}'");
						$bookinfo=mysqli_fetch_array($result);
						$teacher_id=$bookinfo["teacher_id"];
						$teacher_name=$bookinfo["teacher_name"];
						$username=$bookinfo["teacher_username"];
						mysqli_free_result($result);
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
	</div>
	<div class="row clearfix">
		<div class="col-md-3 column">
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='index.php'">首页显示</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='course_choose.php'">授课课程</button>
			 <button type="button" class="btn btn-default btn-block btn-warning" onclick="window.location.href='create_question.php'">创建题目</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='question_condition.php'">做题情况</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='message.php'">收到留言</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='edit_password.php'">修改密码</button>
		</div>
		<div class="col-md-9 column">
			<p>
				 <strong>请在下面的表格中填写你要添加的题目信息：</strong>
			</p>
			<form action="create_question_action.php" method="post" role="form">
			<div class="row clearfix">
				<div class="col-md-3 column">
					<p><strong>题目编号：</strong></p>
					<input type="text" name="question_id" class="form-control" id="name" placeholder="请输入题目编号">
				</div>
				<div class="col-md-9 column">
					<p><strong>题目描述：</strong></p>
					<input type="text" name="question_describe" class="form-control" id="name" placeholder="请输入题目描述">
				</div>
			</div>
			<div class="row clearfix">
				<div class="col-md-2 column">
				<br><p><strong>选项A：</strong></p>
				<input type="text" name="choice_A" class="form-control" id="name" placeholder="选项A">
				</div>
				<div class="col-md-2 column">
				<br><p><strong>选项B：</strong></p>
				<input type="text" name="choice_B" class="form-control" id="name" placeholder="选项B">
				</div>
				<div class="col-md-2 column">
				<br><p><strong>选项C：</strong></p>
				<input type="text" name="choice_C" class="form-control" id="name" placeholder="选项C">
				</div>
				<div class="col-md-2 column">
				<br><p><strong>选项D：</strong></p>
				<input type="text" name="choice_D" class="form-control" id="name" placeholder="选项D">
				</div>
				<div class="col-md-2 column">
				<br><p><strong>是否重点：</strong></p>
				<input type="text" name="if_keynote" class="form-control" id="name" placeholder="1 / 0">
				</div>
				<div class="col-md-2 column">
				<br><p><strong>难度等级：</strong></p>
				<input type="text" name="difficulty_degree" class="form-control" id="name" placeholder="难度等级">
				</div>
			</div>
			<div class="row clearfix">
				<div class="col-md-4 column">
				<br><p><strong>正确选项：</strong></p>
				<input type="text" name="correct_choice" class="form-control" id="name" placeholder="请输入正确选项">
				</div>
				<div class="col-md-6 column">
				<br><p><strong>答案解析：</strong></p>
				<input type="text" name="answer_detail" class="form-control" id="name" placeholder="请输入答案解析">
				</div>
				<div class="col-md-2 column">
				<br><br><button type="submit" class="btn btn-default btn-block btn-success">添加题目</button>
				</div>
			</div>
			</form>
			<br><br>
				<?php
					$result=mysqli_query($con,"select * from questions where teacher_id='{$teacher_id}';");
					if($result && mysqli_num_rows($result)){
						echo '<strong>你编写过的题目：</strong></p><table id="table_1" class="display"><thead>';
						echo '<tr><th>题号</th><th>课程</th><th>题目描述</th><th>是否重点</th><th>难度等级</th><th>删除题目</th></tr>';
						echo '</thead><tbody>';
						while($row=mysqli_fetch_assoc($result)){
						echo '<tr>';
						echo '<td>'.$row['question_no'].'</td>';

						//查询该问题的所属课程信息
						$course_id=$row['course_id'];
						$result_temp=mysqli_query($con,"select * from id_course where course_id='{$course_id}'");
						$bookinfo=mysqli_fetch_array($result_temp);
						echo '<td>'.$bookinfo['course_name'].'</td>';
						mysqli_free_result($result_temp);
						echo '<td>'.$row['question_describe'].'</td>';

						if($row['if_keynote']==1){
							echo '<td>'.'是'.'</td>';
						}else{
							echo '<td>'.'否'.'</td>';
						}
						echo '<td>'.$row['difficulty_degree'].'</td>';
						echo '<td>';
						echo '<button type="button" class="btn btn-default btn-block btn-danger btn-xs" onclick="window.location.href=\'question_delete.php?question_no='.$row['question_no'].'&teacher_id='.$teacher_id.'&course_id='.$course_id.'\''.'">删除此题目</button>';
						echo '</td>';
						}
						echo '<tfoot><tr><th>题号</th><th>课程</th><th>题目描述</th><th>是否重点</th><th>难度等级</th><th>删除题目</th></tr></tfoot>';
					}else{
						echo '<strong>'.'你还没有编写过题目，来创建你的第一道题吧！'.'</strong>';
					}
				?>
				</tbody>
			</table>
			<script type="text/javascript">
				$(document).ready( function () {
					$('#table_1').DataTable({
						"aLengthMenu": [10, 20, 30, 40], 
					language: {
						"sProcessing": "处理中...",
						"sLengthMenu": "显示 _MENU_ 项结果",
						"sZeroRecords": "没有匹配结果",
						"sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
						"sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
						"sInfoFiltered": "(由 _MAX_ 项结果过滤)",
						"sInfoPostFix": "",
						"sSearch": "搜索:",
						"sUrl": "",
						"sEmptyTable": "表中数据为空",
						"sLoadingRecords": "载入中...",
						"sInfoThousands": ",",
						"oPaginate": {
							"sFirst": "首页",
							"sPrevious": "上页",
							"sNext": "下页",
							"sLast": "末页"
						},
						"oAria": {
							"sSortAscending": ": 以升序排列此列",
							"sSortDescending": ": 以降序排列此列"
						}
					}
				});
				} );
				</script>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-12 column">
            <p>
				 <br>
			</p>
			<p class="text-center">
				 数据库课程设计：网络题库发布管理与测验系统    制作：陈扬    王子聪    徐昊
			</p>
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