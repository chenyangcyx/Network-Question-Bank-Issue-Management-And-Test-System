<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>检查题目中</title>
</head>
<body>
<?php
    session_start ();

    $student_id=$_GET['student_id'];
    $question_no=$_GET['question_no'];
    $teacher_id=$_GET['teacher_id'];
    $course_id=$_GET['course_id'];
    $choice=$_GET['choice'];
    $if_keynote=$_GET['if_keynote'];
    $difficulty_degree=$_GET['difficulty_degree'];
    $question_do_time=date("Y-m-d h:i:s");

    $con=mysqli_connect("localhost","root","root","stu_test");//连接mysql数据库
    if (!$con) {
      die('数据库连接失败'.mysqli_connect_error());
    }
    mysqli_query($con,"set names 'utf8'");
    if (isset ( $_SESSION ["code"] )) {//判断code存不存在，如果不存在，说明异常登录
        $result=mysqli_query($con,"select * from questions where question_no='{$question_no}' and teacher_id='{$teacher_id}' and course_id='{$course_id}'");
        $bookinfo=mysqli_fetch_array($result);
        $correct_choice=$bookinfo['question_correct_choice'];
        if($choice==$correct_choice){
          mysqli_query($con,"insert into do_question values ('{$student_id}','{$question_no}','{$teacher_id}','{$course_id}','{$question_do_time}','1');") or die ( "写入做题记录失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con));
?>
          <script type="text/javascript">
            alert("答案正确！");
            window.location.href="do_question.php?if=<?php echo $if_keynote ?>&degree=<?php echo $difficulty_degree ?>";
          </script>
<?php
        }else{
          mysqli_query($con,"insert into do_question values ('{$student_id}','{$question_no}','{$teacher_id}','{$course_id}','{$question_do_time}','0');") or die ( "写入做题记录失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con));
?>
          <script type="text/javascript">
            alert("答案错误！正确答案为：<?php echo $correct_choice;  ?>");
            window.location.href="do_question.php?if=<?php echo $if_keynote ?>&degree=<?php echo $difficulty_degree ?>";
          </script>
<?php
        }
?>

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
</html>