<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>重做题目</title>
</head>
<body>
<?php
    session_start ();
    $student_id=$_GET['student_id'];
    $question_no=$_GET['question_no'];
    $teacher_id=$_GET['teacher_id'];
    $course_id=$_GET['course_id'];
    $question_do_time=$_GET['question_do_time'];
    $con=mysqli_connect("localhost","root","root","stu_test");//连接mysql数据库
    if (!$con) {
      die('数据库连接失败'.mysqli_connect_error());
    }
    mysqli_query($con,"set names 'utf8'");
    if (isset ( $_SESSION ["code"] )) {//判断code存不存在，如果不存在，说明异常登录
        mysqli_query($con,"delete from do_question where student_id='{$student_id}' and question_no='{$question_no}' and teacher_id='{$teacher_id}' and course_id='{$course_id}' and question_do_time='{$question_do_time}'") or die ( "删除错题失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con));
        ?>
    <script type="text/javascript">
        alert("删除错题成功，你可以重做此题！");
        window.location.href="wrong_question_record.php";
    </script>

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