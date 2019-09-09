<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8"> 
   <title>学生 题目测验</title>
   <link rel="stylesheet" href="../../css/bootstrap.min.css">
   <link rel="stylesheet" href="../../css/buttons.css">
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
			 <button type="button" class="btn btn-default btn-block btn-warning" onclick="window.location.href='do_question.php?if=2&degree=0'">题目测验</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='question_condition.php'">做题情况</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='wrong_question_record.php'">错题记录</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='leave_message.php'">教师留言</button>
			 <button type="button" class="btn btn-default btn-block btn-info" onclick="window.location.href='edit_password.php'">修改密码</button>
		</div>
		<div class="col-md-7 column">
            <?php
                $if=$_GET['if'];
                $degree=$_GET['degree'];
                $result=mysqli_query($con,"select student_course.*,id_course.* from student_course,id_course where student_course.course_id=id_course.course_id and student_id='{$student_id}'");
                $bookinfo=mysqli_fetch_array($result);
                $course_id=$bookinfo['course_id'];
                $course_name=$bookinfo['course_name'];

                echo '<strong>以下信息为目前显示的题目类别信息、是否重点、可选的难度等级：</strong><br><br>';
                //显示选择框插件
                echo '<div class="row clearfix">';
                    //当前信息 部分
                    echo '<div class="col-md-3 column">';
                    echo '<strong>当前选择：</strong><br>';
                    echo '课程ID：<strong>'.$course_id.'</strong><br>';
                    echo '课程名：<strong>'.$course_name.'</strong><br>';
                    echo '是否重点：';
                        if($if==1){echo '<strong>重点</strong><br>';}
                        if($if==0){echo '<strong>非重点</strong><br>';}
                        if($if==2){echo '<strong>全部</strong><br>';}
                    echo '难度等级：';
                        if($degree==0){echo '<strong>全部</strong><br>';}
                        else {echo '<strong>'.$degree.'</strong>';}
                    echo '</div>';

                    echo '<form action="do_question_temp.php" method="post" role="form">';
                    //选择是否为重点
                    echo '<div class="col-md-3 column">';
                    echo '<strong>重点题目选择：</strong>';
                    echo '<br><br><select class="form-control" name="if_keynote">';
                    if($if==0){
                        echo '<option>非重点</option>';
                        echo '<option>重点</option>';
                        echo '<option>全部</option>';
                    }else if($if==1){
                        echo '<option>重点</option>';
                        echo '<option>非重点</option>';
                        echo '<option>全部</option>';
                    }else if($if==2){
                        echo '<option>全部</option>';
                        echo '<option>重点</option>';
                        echo '<option>非重点</option>';
                    }
                    echo '</select>';
                    echo '</div>';

                    //选择难度等级
                    echo '<div class="col-md-3 column">';
                        echo '<strong>难度等级选择：</strong>';
                        echo '<br><br><select class="form-control" name="degree">';
                            $result_temp=mysqli_query($con,"select distinct difficulty_degree from questions where course_id='{$course_id}' order by difficulty_degree asc");
                            echo '<option>'.'全部'.'</option>';
                            while($row=mysqli_fetch_assoc($result_temp)){
                                echo '<option>'.'难度等级 - '.$row['difficulty_degree'].'</option>';
                            }
                        echo '</select>';
                    echo '</div>';

                    echo '<div class="col-md-3 column">';
                        echo '<strong>条件筛选按钮：</strong>';
                        echo '<br><br><button type="submit" class="btn btn-default btn-block btn-warning">筛选</button>';
                    echo '</div>';
                echo '</div>';
                    echo '</form>';
                
                //开始输出所有题目
                if($if==2&&$degree==0){
                    $result=mysqli_query($con,"select * from questions where course_id='{$course_id}'");
                }
                else if($if==2&&$degree!=0){
                    $result=mysqli_query($con,"select * from questions where course_id='{$course_id}' and difficulty_degree='{$degree}'");
                }
                else if($if!=2&&$degree==0){
                    $result=mysqli_query($con,"select * from questions where course_id='{$course_id}' and if_keynote='{$if}'");
                }
                else{
                    $result=mysqli_query($con,"select * from questions where course_id='{$course_id}' and if_keynote='{$if}' and difficulty_degree='{$degree}'");
                }
                $bookinfo=mysqli_fetch_array($result);

                if($if==2&&$degree==0){
                    $result=mysqli_query($con,"select * from questions where course_id='{$course_id}'");
                }
                else if($if==2&&$degree!=0){
                    $result=mysqli_query($con,"select * from questions where course_id='{$course_id}' and difficulty_degree='{$degree}'");
                }
                else if($if!=2&&$degree==0){
                    $result=mysqli_query($con,"select * from questions where course_id='{$course_id}' and if_keynote='{$if}'");
                }
                else{
                    $result=mysqli_query($con,"select * from questions where course_id='{$course_id}' and if_keynote='{$if}' and difficulty_degree='{$degree}'");
                }
                $question_num=0;
                if($bookinfo){
                    echo '<br><br>';
                    while($row=mysqli_fetch_assoc($result)){
                        $question_num++;
                        echo '<div class="panel panel-info">';
                        echo '<div class="panel-heading"><h3 class="panel-title"><strong>'.$question_num.'</strong>';
                        echo ' - - - '.'<strong>题目编号：</strong>'.$row['question_no'];

                        echo '，'.'<strong>教师：</strong>'.$row['teacher_id'];
                        $row_temp=mysqli_query($con,"select * from teacher_info where teacher_id='{$row['teacher_id']}'");
                        $temp_info=mysqli_fetch_array($row_temp);
                        echo '-'.$temp_info['teacher_name'];

                        echo '，'.'<strong>课程：</strong>'.$row['course_id'];
                        $row_temp=mysqli_query($con,"select * from id_course where course_id='{$row['course_id']}'");
                        $temp_info=mysqli_fetch_array($row_temp);
                        echo '-'.$temp_info['course_name'];

                        echo '，<strong>难度等级：'.$row['difficulty_degree'].'</strong>';
                        
                        echo '</h3></div>';
                        if($row['if_keynote']==1){
                            echo '<p style="font-size:16px;color:#FF0000"><strong><br>★这是一道重点题！<strong></p>';
                        }
                        echo '<div class="panel-body">';
                            echo '<p style="font-size:21px"><strong>'.$row['question_describe'].'</strong></p>';
                        echo '</div>';

                        $check_if_do=mysqli_query($con,"select * from do_question where student_id='{$student_id}' and question_no='{$row['question_no']}' and teacher_id='{$row['teacher_id']}' and course_id='{$row['course_id']}'");
                        $if_result=mysqli_fetch_array($check_if_do);
                        if($if_result){
                            //答案显示区
                            echo '<div class="row clearfix">';
                                echo '<div class="col-md-6 column">';
                                echo '<br>';
                                echo '<a href="'.'question_check.php?question_no='.$row['question_no'].'&teacher_id='.$row['teacher_id'].'&course_id='.$row['course_id'].'&student_id='.$student_id.'&choice='.'A'.'&if_keynote='.$if.'&difficulty_degree='.$degree.'"'.'class="button button-block button-rounded button-caution button-small">'.'A选项：'.$row['question_choice_A'].'</a>';
                                echo '<br>';
                                echo '<a href="'.'question_check.php?question_no='.$row['question_no'].'&teacher_id='.$row['teacher_id'].'&course_id='.$row['course_id'].'&student_id='.$student_id.'&choice='.'C'.'&if_keynote='.$if.'&difficulty_degree='.$degree.'"'.'class="button button-block button-rounded button-caution button-small">'.'C选项：'.$row['question_choice_C'].'</a>';
                                echo '</div>';
                                echo '<div class="col-md-6 column">';
                                echo '<br>';
                                echo '<a href="'.'question_check.php?question_no='.$row['question_no'].'&teacher_id='.$row['teacher_id'].'&course_id='.$row['course_id'].'&student_id='.$student_id.'&choice='.'B'.'&if_keynote='.$if.'&difficulty_degree='.$degree.'"'.'class="button button-block button-rounded button-caution button-small">'.'B选项：'.$row['question_choice_B'].'</a>';
                                echo '<br>';
                                echo '<a href="'.'question_check.php?question_no='.$row['question_no'].'&teacher_id='.$row['teacher_id'].'&course_id='.$row['course_id'].'&student_id='.$student_id.'&choice='.'D'.'&if_keynote='.$if.'&difficulty_degree='.$degree.'"'.'class="button button-block button-rounded button-caution button-small">'.'D选项：'.$row['question_choice_D'].'</a>';
                                echo '</div>';
                            echo '</div>';
                            echo '<p style="font-size:15px;color:#D15FEE"><strong><br>★你已经做过这道题，重做将会添加不同时间的记录！★<strong></p>';
                        }else{
                            echo '<div class="row clearfix">';
                                echo '<div class="col-md-6 column">';
                                echo '<br>';
                                echo '<a href="'.'question_check.php?question_no='.$row['question_no'].'&teacher_id='.$row['teacher_id'].'&course_id='.$row['course_id'].'&student_id='.$student_id.'&choice='.'A'.'&if_keynote='.$if.'&difficulty_degree='.$degree.'"'.'class="button button-block button-rounded button-primary button-small">'.'A选项：'.$row['question_choice_A'].'</a>';
                                echo '<br>';
                                echo '<a href="'.'question_check.php?question_no='.$row['question_no'].'&teacher_id='.$row['teacher_id'].'&course_id='.$row['course_id'].'&student_id='.$student_id.'&choice='.'C'.'&if_keynote='.$if.'&difficulty_degree='.$degree.'"'.'class="button button-block button-rounded button-primary button-small">'.'C选项：'.$row['question_choice_C'].'</a>';
                                echo '</div>';
                                echo '<div class="col-md-6 column">';
                                echo '<br>';
                                echo '<a href="'.'question_check.php?question_no='.$row['question_no'].'&teacher_id='.$row['teacher_id'].'&course_id='.$row['course_id'].'&student_id='.$student_id.'&choice='.'B'.'&if_keynote='.$if.'&difficulty_degree='.$degree.'"'.'class="button button-block button-rounded button-primary button-small">'.'B选项：'.$row['question_choice_B'].'</a>';
                                echo '<br>';
                                echo '<a href="'.'question_check.php?question_no='.$row['question_no'].'&teacher_id='.$row['teacher_id'].'&course_id='.$row['course_id'].'&student_id='.$student_id.'&choice='.'D'.'&if_keynote='.$if.'&difficulty_degree='.$degree.'"'.'class="button button-block button-rounded button-primary button-small">'.'D选项：'.$row['question_choice_D'].'</a>';
                                echo '</div>';
                            echo '</div>';
                        }
                        echo '</div>';
                    }
                }else{
                    echo '<div class="row clearfix"><div class="col-md-12 column">';
                        echo '<br><br><strong>抱歉！<br>在你的筛选条件下没有相应的题目，请尝试其他筛选条件！</strong>';
                        echo '</div>';
                    echo '</div>';
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