<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>课程信息删除</title>
</head>
<body>
<?php
    session_start ();
    $course_id=$_GET['course_id'];
    $con=mysqli_connect("localhost","root","root","stu_test");//连接mysql数据库
    if (!$con) {
      die('数据库连接失败'.mysqli_connect_error());
    }
    mysqli_query($con,"set names 'utf8'");
    if (isset ( $_SESSION ["code"] )) {//判断code存不存在，如果不存在，说明异常登录
        mysqli_query($con,"delete from do_question where course_id='{$course_id}'") or die ( "删除课程信息失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con));
        mysqli_query($con,"delete from id_course where course_id='{$course_id}'") or die ( "删除课程信息失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con));
        mysqli_query($con,"delete from questions where course_id='{$course_id}'") or die ( "删除课程信息失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con));
        mysqli_query($con,"delete from student_course where course_id='{$course_id}'") or die ( "删除课程信息失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con));
        mysqli_query($con,"delete from teacher_course where course_id='{$course_id}'") or die ( "删除课程信息失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con));
        ?>
    <script type="text/javascript">
        alert("已经删除该课程信息！");
        window.location.href="course_manage.php";
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