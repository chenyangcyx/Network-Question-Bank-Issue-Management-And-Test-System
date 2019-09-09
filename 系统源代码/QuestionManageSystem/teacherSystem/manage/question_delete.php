<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>正在删除问题</title>
</head>
<body>
<?php
    session_start ();
    $question_no=$_GET['question_no'];
    $teacher_id=$_GET['teacher_id'];
    $course_id=$_GET['course_id'];
    $con=mysqli_connect("localhost","root","root","stu_test");//连接mysql数据库
    if (!$con) {
      die('数据库连接失败'.mysqli_connect_error());
    }
    mysqli_query($con,"set names 'utf8'");
    if (isset ( $_SESSION ["code"] )) {//判断code存不存在，如果不存在，说明异常登录
        mysqli_query($con,"delete from questions where question_no='{$question_no}' and teacher_id='{$teacher_id}' and course_id='{$course_id}'") or die ( "删除问题失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con));
        mysqli_query($con,"delete from do_question where question_no='{$question_no}' and teacher_id='{$teacher_id}' and course_id='{$course_id}'") or die ( "删除问题失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con));
        ?>
    <script type="text/javascript">
        alert("已经删除该问题！");
        window.location.href="create_question.php";
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