<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8"> 
   <title>教师 做题情况</title>
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
<script src="../../js/echarts.min.js"></script>
<script src="../../js/macarons.js"></script>
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
	</div>
	<div class="row clearfix">
		<div class="col-md-3 column">
            <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='index.php'">首页显示</button>
			<button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='course_choose.php'">授课课程</button>
			<button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='create_question.php'">创建题目</button>
			<button type="button" class="btn btn-default btn-block btn-warning" onclick="window.location.href='question_condition.php'">做题情况</button>
			<button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='message.php'">收到留言</button>
			<button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='edit_password.php'">修改密码</button>
		</div>
		<div class="col-md-9 column">
		<?php
					$result=mysqli_query($con,"select do_question.*,questions.* from do_question,questions where do_question.question_no=questions.question_no and do_question.course_id=questions.course_id and do_question.teacher_id=questions.teacher_id and do_question.teacher_id='{$teacher_id}'");
                    if($result && mysqli_num_rows($result)){
						echo '<p align="center"><strong>你创建的题目 做题情况：</strong></p><table id="table_1" class="display">';
						echo '<thead><tr><th>题号</th><th>课程</th><th>题目描述</th><th>学生姓名</th><th>做题时间</th><th>是否正确</th></tr>';
						echo '</thead><tbody>';
                        while($row=mysqli_fetch_assoc($result)){
                            echo '<tr>';
							$result1=mysqli_query($con,"select * from id_course where course_id='{$row['course_id']}'");
							$info1=mysqli_fetch_array($result1);
							$result2=mysqli_query($con,"select * from student_info where student_id='{$row['student_id']}'");
							$info2=mysqli_fetch_array($result2);
                            echo '<td>'.$row['question_no'].'</td>';
                            echo '<td>'.$info1['course_name'].'</td>';
                            echo '<td>'.$row['question_describe'].'</td>';
                            echo '<td>'.$info2['student_name'].'</td>';
                            echo '<td>'.$row['question_do_time'].'</td>';
                            if($row['if_correct']==1){
                                echo '<td>'.'是'.'</td>';
                            }else{
                                echo '<td>'.'否'.'</td>';
                            }
						}
						echo '</tbody><tfoot><tr><th>题号</th><th>课程</th><th>题目描述</th><th>学生姓名</th><th>做题时间</th><th>是否正确</th></tr></tfoot>';
						echo '</table>';
						?>
						<script type="text/javascript">
						$(document).ready( function () {
							$('#table_1').DataTable({
							"aLengthMenu": [5, 10, 20, 50], 
							"order": [[ 4, "asc" ]],
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
					<?php
                    }
                    else{
                            echo '<strong>'.'还没有学生做过你的题目！'.'</strong>';
                    }
                ?>

				<br><br>
                <?php
                    $result=mysqli_query($con,"select do_question.*,questions.* from do_question,questions where do_question.question_no=questions.question_no and do_question.teacher_id=questions.teacher_id and do_question.course_id=questions.course_id");
                    if($result && mysqli_num_rows($result)){
						echo '<p align="center"><strong>所有题目 做题情况：</strong></p><table id="table_2" class="display"><thead>';
						echo '<tr><th>出题教师</th><th>课程</th><th>题目描述</th><th>学生姓名</th><th>做题时间</th><th>是否正确</th></tr>';
						echo '</thead><tbody>';
                        while($row=mysqli_fetch_assoc($result)){
							echo '<tr>';
							$result1=mysqli_query($con,"select * from id_course where course_id='{$row['course_id']}'");
							$info1=mysqli_fetch_array($result1);
							$result2=mysqli_query($con,"select * from student_info where student_id='{$row['student_id']}'");
							$info2=mysqli_fetch_array($result2);
							$result3=mysqli_query($con,"select * from teacher_info where teacher_id='{$row['teacher_id']}'");
							$info3=mysqli_fetch_array($result3);
                            echo '<td>'.$info3['teacher_name'].'</td>';
                            echo '<td>'.$info1['course_name'].'</td>';
                            echo '<td>'.$row['question_describe'].'</td>';
                            echo '<td>'.$info2['student_name'].'</td>';
                            echo '<td>'.$row['question_do_time'].'</td>';
                            if($row['if_correct']==1){
                                echo '<td>'.'是'.'</td>';
                            }else{
                                echo '<td>'.'否'.'</td>';
                            }
						}
						echo '</tbody><tfoot><tr><th>出题教师</th><th>课程</th><th>题目描述</th><th>学生姓名</th><th>做题时间</th><th>是否正确</th></tr></tfoot>';
						echo '</table>';
				?>
				<script type="text/javascript">
						$(document).ready( function () {
							$('#table_2').DataTable({
							"aLengthMenu": [5, 10, 20, 50], 
							"order": [[ 4, "asc" ]],
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

		<div class="row clearfix"><div class="col-md-12 column">
		<br><br><p align="center";style="font-size:20px"><strong>学生做题记录表<br></strong></p>
       <div id="container1" style="height: 400%"></div>
       <script type="text/javascript">
			var dom = document.getElementById("container1");
			var myChart = echarts.init(dom, 'macarons');
			var app = {};
			option = null;
			app.title = '学生做题记录表';

			option = {
				tooltip: {
					trigger: 'axis',
					axisPointer: {
						type: 'cross',
						crossStyle: {
							color: '#999'
						}
					}
				},
				toolbox: {
					feature: {
						dataView: {show: true, readOnly: false},
						magicType: {show: true, type: ['line', 'bar']},
						restore: {show: true},
						saveAsImage: {show: true}
					}
				},
				legend: {
					data:['正确题','错误题','总题目','正确率']
				},
				xAxis: [
					{
						type: 'category',
						data: [
					<?php
						$date_0=date("Y-m-d");
						$date_1=date("Y-m-d",strtotime('-1 day'));
						$date_2=date("Y-m-d",strtotime('-2 day'));
						$date_3=date("Y-m-d",strtotime('-3 day'));
						$date_4=date("Y-m-d",strtotime('-4 day'));
						$date_5=date("Y-m-d",strtotime('-5 day'));
						$date_6=date("Y-m-d",strtotime('-6 day'));
						$date_7=date("Y-m-d",strtotime('-7 day'));
						$date_8=date("Y-m-d",strtotime('-8 day'));
						$date_9=date("Y-m-d",strtotime('-9 day'));
						echo '\''.substr($date_9,5,6).'\',';
						echo '\''.substr($date_8,5,6).'\',';
						echo '\''.substr($date_7,5,6).'\',';
						echo '\''.substr($date_6,5,6).'\',';
						echo '\''.substr($date_5,5,6).'\',';
						echo '\''.substr($date_4,5,6).'\',';
						echo '\''.substr($date_3,5,6).'\',';
						echo '\''.substr($date_2,5,6).'\',';
						echo '\''.substr($date_1,5,6).'\',';
						echo '\''.substr($date_0,5,6).'\',';
					?>
						],
						axisPointer: {
							type: 'shadow'
						}
					}
				],
				yAxis: [
					{
						type: 'value',
						name: '题目数量',
						min: 0,
						max: 150,
						interval: 15,
						axisLabel: {
							formatter: '{value} 题'
						}
					},
					{
						type: 'value',
						name: '正确率',
						min: 0,
						max: 100,
						interval: 10,
						axisLabel: {
							formatter: '{value} %'
						}
					}
				],
				series: [
					{
						name:'正确题',
						type:'bar',
						data:[
							<?php
							$line_query=mysqli_query($con,"select * from do_question where if_correct=1 and question_do_time>'$date_9' and question_do_time<'$date_8}'");
							$line_num=mysqli_num_rows($line_query);
							$date_9_r=$line_num;
							echo $line_num.',';
							mysqli_free_result($line_query);
							$line_query=mysqli_query($con,"select * from do_question where if_correct=1 and question_do_time>'$date_8' and question_do_time<'$date_7}'");
							$line_num=mysqli_num_rows($line_query);
							$date_8_r=$line_num;
							echo $line_num.',';
							mysqli_free_result($line_query);
							$line_query=mysqli_query($con,"select * from do_question where if_correct=1 and question_do_time>'$date_7' and question_do_time<'$date_6}'");
							$line_num=mysqli_num_rows($line_query);
							$date_7_r=$line_num;
							echo $line_num.',';
							mysqli_free_result($line_query);
							$line_query=mysqli_query($con,"select * from do_question where if_correct=1 and question_do_time>'$date_6' and question_do_time<'$date_5}'");
							$line_num=mysqli_num_rows($line_query);
							$date_6_r=$line_num;
							echo $line_num.',';
							mysqli_free_result($line_query);
							$line_query=mysqli_query($con,"select * from do_question where if_correct=1 and question_do_time>'$date_5' and question_do_time<'$date_4}'");
							$line_num=mysqli_num_rows($line_query);
							$date_5_r=$line_num;
							echo $line_num.',';
							mysqli_free_result($line_query);
							$line_query=mysqli_query($con,"select * from do_question where if_correct=1 and question_do_time>'$date_4' and question_do_time<'$date_3}'");
							$line_num=mysqli_num_rows($line_query);
							$date_4_r=$line_num;
							echo $line_num.',';
							mysqli_free_result($line_query);
							$line_query=mysqli_query($con,"select * from do_question where if_correct=1 and question_do_time>'$date_3' and question_do_time<'$date_2}'");
							$line_num=mysqli_num_rows($line_query);
							$date_3_r=$line_num;
							echo $line_num.',';
							mysqli_free_result($line_query);
							$line_query=mysqli_query($con,"select * from do_question where if_correct=1 and question_do_time>'$date_2' and question_do_time<'$date_1}'");
							$line_num=mysqli_num_rows($line_query);
							$date_2_r=$line_num;
							echo $line_num.',';
							mysqli_free_result($line_query);
							$line_query=mysqli_query($con,"select * from do_question where if_correct=1 and question_do_time>'$date_1' and question_do_time<'$date_0}'");
							$line_num=mysqli_num_rows($line_query);
							$date_1_r=$line_num;
							echo $line_num.',';
							mysqli_free_result($line_query);
							$line_query=mysqli_query($con,"select * from do_question where if_correct=1 and question_do_time>'$date_0'");
							$line_num=mysqli_num_rows($line_query);
							$date_0_r=$line_num;
							echo $line_num.',';
							mysqli_free_result($line_query);
							?>
						]
					},
					{
						name:'错误题',
						type:'bar',
						data:[
							<?php
							$line_query=mysqli_query($con,"select * from do_question where if_correct=0 and question_do_time>'$date_9' and question_do_time<'$date_8}'");
							$line_num=mysqli_num_rows($line_query);
							$date_9_w=$line_num;
							echo $line_num.',';
							mysqli_free_result($line_query);
							$line_query=mysqli_query($con,"select * from do_question where if_correct=0 and question_do_time>'$date_8' and question_do_time<'$date_7}'");
							$line_num=mysqli_num_rows($line_query);
							$date_8_w=$line_num;
							echo $line_num.',';
							mysqli_free_result($line_query);
							$line_query=mysqli_query($con,"select * from do_question where if_correct=0 and question_do_time>'$date_7' and question_do_time<'$date_6}'");
							$line_num=mysqli_num_rows($line_query);
							$date_7_w=$line_num;
							echo $line_num.',';
							mysqli_free_result($line_query);
							$line_query=mysqli_query($con,"select * from do_question where if_correct=0 and question_do_time>'$date_6' and question_do_time<'$date_5}'");
							$line_num=mysqli_num_rows($line_query);
							$date_6_w=$line_num;
							echo $line_num.',';
							mysqli_free_result($line_query);
							$line_query=mysqli_query($con,"select * from do_question where if_correct=0 and question_do_time>'$date_5' and question_do_time<'$date_4}'");
							$line_num=mysqli_num_rows($line_query);
							$date_5_w=$line_num;
							echo $line_num.',';
							mysqli_free_result($line_query);
							$line_query=mysqli_query($con,"select * from do_question where if_correct=0 and question_do_time>'$date_4' and question_do_time<'$date_3}'");
							$line_num=mysqli_num_rows($line_query);
							$date_4_w=$line_num;
							echo $line_num.',';
							mysqli_free_result($line_query);
							$line_query=mysqli_query($con,"select * from do_question where if_correct=0 and question_do_time>'$date_3' and question_do_time<'$date_2}'");
							$line_num=mysqli_num_rows($line_query);
							$date_3_w=$line_num;
							echo $line_num.',';
							mysqli_free_result($line_query);
							$line_query=mysqli_query($con,"select * from do_question where if_correct=0 and question_do_time>'$date_2' and question_do_time<'$date_1}'");
							$line_num=mysqli_num_rows($line_query);
							$date_2_w=$line_num;
							echo $line_num.',';
							mysqli_free_result($line_query);
							$line_query=mysqli_query($con,"select * from do_question where if_correct=0 and question_do_time>'$date_1' and question_do_time<'$date_0}'");
							$line_num=mysqli_num_rows($line_query);
							$date_1_w=$line_num;
							echo $line_num.',';
							mysqli_free_result($line_query);
							$line_query=mysqli_query($con,"select * from do_question where if_correct=0 and question_do_time>'$date_0'");
							$line_num=mysqli_num_rows($line_query);
							$date_0_w=$line_num;
							echo $line_num.',';
							mysqli_free_result($line_query);
							?>
						]
					},
					{
						name:'总题目',
						type:'bar',
						data:[
					<?php
						echo $date_9_w+$date_9_r.',';
						echo $date_8_w+$date_8_r.',';
						echo $date_7_w+$date_7_r.',';
						echo $date_6_w+$date_6_r.',';
						echo $date_5_w+$date_5_r.',';
						echo $date_4_w+$date_4_r.',';
						echo $date_3_w+$date_3_r.',';
						echo $date_2_w+$date_2_r.',';
						echo $date_1_w+$date_1_r.',';
						echo $date_0_w+$date_0_r.',';
					?>
						]
					},
					{
						name:'正确率',
						type:'line',
						yAxisIndex: 1,
						data:[
					<?php
						$num_result=($date_9_r/($date_9_w+$date_9_r))*100;
						echo $num_result.',';
						$num_result=($date_8_r/($date_8_w+$date_8_r))*100;
						echo $num_result.',';
						$num_result=($date_7_r/($date_7_w+$date_7_r))*100;
						echo $num_result.',';
						$num_result=($date_6_r/($date_6_w+$date_6_r))*100;
						echo $num_result.',';
						$num_result=($date_5_r/($date_5_w+$date_5_r))*100;
						echo $num_result.',';
						$num_result=($date_4_r/($date_4_w+$date_4_r))*100;
						echo $num_result.',';
						$num_result=($date_3_r/($date_3_w+$date_3_r))*100;
						echo $num_result.',';
						$num_result=($date_2_r/($date_2_w+$date_2_r))*100;
						echo $num_result.',';
						$num_result=($date_1_r/($date_1_w+$date_1_r))*100;
						echo $num_result.',';
						$num_result=($date_0_r/($date_0_w+$date_0_r))*100;
						echo $num_result.',';
					?>
						]
					}
				]
			};
			;
			if (option && typeof option === "object") {
				myChart.setOption(option, true);
			}
       </script>

		<?php
			echo '</div></div>';
			//输出图表：总题章节分布表
			echo '<div class="row clearfix"><div class="col-md-6 column">';
			echo '<br>';
			echo '<div id="container2" style="height: 300%"></div>';
		?>
			<script type="text/javascript">
				var dom = document.getElementById("container2");
				var myChart = echarts.init(dom, 'macarons');
				var app = {};
				option = null;
				option = {
					title : {
						text: '学生总做题章节分布图',
						x:'center'
					},
					tooltip : {
						trigger: 'item',
						formatter: "{a} <br/>{b} : {c} 题"
					},
					legend: {
						orient: 'vertical',
						left: 'left',
						data: [
							<?php
							$pie1_query=mysqli_query($con,"select distinct course_id from do_question");
							while($pie1_row=mysqli_fetch_assoc($pie1_query)){
								$pie1_row_courseid=$pie1_row['course_id'];
								$pie1_row_courseid_query=mysqli_query($con,"select * from id_course where course_id='{$pie1_row_courseid}'");
								$pie1_row_courseid_query_info=mysqli_fetch_array($pie1_row_courseid_query);
								$pie1_row_courseid_query_info_coursename=$pie1_row_courseid_query_info['course_name'];
								echo '\''.$pie1_row_courseid_query_info_coursename.'\''.',';
							}
							?>
						]
					},
					series : [
						{
							name: '做题章节',
							type: 'pie',
							radius : '70%',
							center: ['50%', '50%'],
							data:[
							<?php
							$pie1_query=mysqli_query($con,"select distinct course_id from do_question");
							while($pie1_row=mysqli_fetch_assoc($pie1_query)){
								$pie1_row_courseid=$pie1_row['course_id'];
								$pie1_row_courseid_query=mysqli_query($con,"select * from id_course where course_id='{$pie1_row_courseid}'");
								$pie1_row_courseid_query_info=mysqli_fetch_array($pie1_row_courseid_query);
								$pie1_row_courseid_query_info_coursename=$pie1_row_courseid_query_info['course_name'];
								$pie1_row_num_query=mysqli_query($con,"select * from do_question where course_id='{$pie1_row_courseid}'");
								$pie1_row_num=mysqli_num_rows($pie1_row_num_query);
								echo '{value:'.$pie1_row_num.', name:'.'\''.$pie1_row_courseid_query_info_coursename.'\''.'},';
							}
							?>
							],
							itemStyle: {
								emphasis: {
									shadowBlur: 10,
									shadowOffsetX: 0,
									shadowColor: 'rgba(0, 0, 0, 0.5)'
								}
							}
						}
					]
				};
				;
				if (option && typeof option === "object") {
					myChart.setOption(option, true);
				}
					</script>
					<?php
						echo '</div>';
					//输出图表：总错题章节分布表
						echo '<div class="col-md-6 column">';
						echo '<br>';
						echo '<div id="container3" style="height: 300%"></div>';
						?>

						<script type="text/javascript">
							var dom = document.getElementById("container3");
							var myChart = echarts.init(dom, 'macarons');
							var app = {};
							option = null;
							option = {
								title : {
									text: '学生总错题章节分布图',
									x:'center'
								},
								tooltip : {
									trigger: 'item',
									formatter: "{a} <br/>{b} : {c} 题"
								},
								legend: {
									orient: 'vertical',
									left: 'left',
									data: [
										<?php
										$pie1_query=mysqli_query($con,"select distinct course_id from do_question where if_correct=0");
										while($pie1_row=mysqli_fetch_assoc($pie1_query)){
											$pie1_row_courseid=$pie1_row['course_id'];
											$pie1_row_courseid_query=mysqli_query($con,"select * from id_course where course_id='{$pie1_row_courseid}'");
											$pie1_row_courseid_query_info=mysqli_fetch_array($pie1_row_courseid_query);
											$pie1_row_courseid_query_info_coursename=$pie1_row_courseid_query_info['course_name'];
											echo '\''.$pie1_row_courseid_query_info_coursename.'\''.',';
										}
										?>
									]
								},
								series : [
									{
										name: '做题章节',
										type: 'pie',
										radius : '70%',
										center: ['50%', '50%'],
										data:[
										<?php
										$pie1_query=mysqli_query($con,"select distinct course_id from do_question where if_correct=0");
										while($pie1_row=mysqli_fetch_assoc($pie1_query)){
											$pie1_row_courseid=$pie1_row['course_id'];
											$pie1_row_courseid_query=mysqli_query($con,"select * from id_course where course_id='{$pie1_row_courseid}'");
											$pie1_row_courseid_query_info=mysqli_fetch_array($pie1_row_courseid_query);
											$pie1_row_courseid_query_info_coursename=$pie1_row_courseid_query_info['course_name'];
											$pie1_row_num_query=mysqli_query($con,"select * from do_question where course_id='{$pie1_row_courseid}' and if_correct=0");
											$pie1_row_num=mysqli_num_rows($pie1_row_num_query);
											echo '{value:'.$pie1_row_num.', name:'.'\''.$pie1_row_courseid_query_info_coursename.'\''.'},';
										}
										?>
										],
										itemStyle: {
											emphasis: {
												shadowBlur: 10,
												shadowOffsetX: 0,
												shadowColor: 'rgba(0, 0, 0, 0.5)'
											}
										}
									}
								]
							};
							;
							if (option && typeof option === "object") {
								myChart.setOption(option, true);
							}
								</script>
					<?php
						echo '</div>';
					//输出图表：老师出题数量占比
						echo '<div class="row clearfix"><div class="col-md-6 column">';
						echo '<br>';
						echo '<div id="container4" style="height: 300%"></div>';
						?>

						<script type="text/javascript">
							var dom = document.getElementById("container4");
							var myChart = echarts.init(dom, 'macarons');
							var app = {};
							option = null;
							option = {
								title : {
									text: '老师出题数量分布图',
									x:'center'
								},
								tooltip : {
									trigger: 'item',
									formatter: "{a} <br/>{b} : {c} 题"
								},
								legend: {
									orient: 'vertical',
									left: 'left',
									data: [
										<?php
										$pie1_query=mysqli_query($con,"select * from teacher_info");
										while($pie1_row=mysqli_fetch_assoc($pie1_query)){
											$pie1_row_teachername=$pie1_row['teacher_name'];
											echo '\''.$pie1_row_teachername.'\''.',';
										}
										?>
									]
								},
								series : [
									{
										name: '题目所在章节',
										type: 'pie',
										radius : '70%',
										center: ['50%', '50%'],
										data:[
										<?php
										$pie1_query=mysqli_query($con,"select * from teacher_info");
										while($pie1_row=mysqli_fetch_assoc($pie1_query)){
											$pie1_row_teachername=$pie1_row['teacher_name'];
											$pie1_row_teacherid=$pie1_row['teacher_id'];
											$pie1_row_teacherid_query=mysqli_query($con,"select * from questions where teacher_id='{$pie1_row_teacherid}'");
											$pie1_row_teacher_questions_num=mysqli_num_rows($pie1_row_teacherid_query);
											echo '{value:'.$pie1_row_teacher_questions_num.', name:'.'\''.$pie1_row_teachername.'\''.'},';
										}
										?>
										],
										itemStyle: {
											emphasis: {
												shadowBlur: 10,
												shadowOffsetX: 0,
												shadowColor: 'rgba(0, 0, 0, 0.5)'
											}
										}
									}
								]
							};
							;
							if (option && typeof option === "object") {
								myChart.setOption(option, true);
							}
								</script>
						<?php
						echo '</div>';
						//输出图表：做题章节分布表
						echo '<div class="col-md-6 column">';
						echo '<br>';
						echo '<div id="container5" style="height: 300%"></div>';
						?>

						<script type="text/javascript">
							var dom = document.getElementById("container5");
							var myChart = echarts.init(dom, 'macarons');
							var app = {};
							option = null;
							option = {
								title : {
									text: '出题章节分布图',
									x:'center'
								},
								tooltip : {
									trigger: 'item',
									formatter: "{a} <br/>{b} : {c} 题"
								},
								legend: {
									orient: 'vertical',
									left: 'left',
									data: [
										<?php
										$pie1_query=mysqli_query($con,"select * from id_course");
										while($pie1_row=mysqli_fetch_assoc($pie1_query)){
											$pie1_row_coursename=$pie1_row['course_name'];
											echo '\''.$pie1_row_coursename.'\''.',';
										}
										?>
									]
								},
								series : [
									{
										name: '出题所在章节',
										type: 'pie',
										radius : '70%',
										center: ['50%', '50%'],
										data:[
										<?php
										$pie1_query=mysqli_query($con,"select * from id_course");
										while($pie1_row=mysqli_fetch_assoc($pie1_query)){
											$pie1_row_coursename=$pie1_row['course_name'];
											$pie1_row_courseid=$pie1_row['course_id'];
											$pie1_row_courseid_query=mysqli_query($con,"select * from questions where course_id='{$pie1_row_courseid}'");
											$pie1_row_courseid_num=mysqli_num_rows($pie1_row_courseid_query);
											echo '{value:'.$pie1_row_courseid_num.', name:'.'\''.$pie1_row_coursename.'\''.'},';
										}
										?>
										],
										itemStyle: {
											emphasis: {
												shadowBlur: 10,
												shadowOffsetX: 0,
												shadowColor: 'rgba(0, 0, 0, 0.5)'
											}
										}
									}
								]
							};
							;
							if (option && typeof option === "object") {
								myChart.setOption(option, true);
							}
								</script>
				<?php
                }
                    else{
                            echo '<strong><br><br>'.'没有任何学生的做题情况记录！'.'</strong>';
                    }
                ?>

		</div>
	<div class="row clearfix">
		<div class="col-md-10 column">
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