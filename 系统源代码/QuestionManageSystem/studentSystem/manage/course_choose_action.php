<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>选择课程中</title>
</head>
<body>
<?php
    session_start ();
    $course_id=$_GET['id'];
    $con=mysqli_connect("localhost","root","root","stu_test");//连接mysql数据库
    if (!$con) {
      die('数据库连接失败'.mysqli_connect_error());
    }
    mysqli_query($con,"set names 'utf8'");
    if (isset ( $_SESSION ["code"] )) {//判断code存不存在，如果不存在，说明异常登录
        $result=mysqli_query($con,"select * from student_info where student_username='${_SESSION["username"]}'");
        $bookinfo=mysqli_fetch_array($result);
        $student_id=$bookinfo["student_id"];

        $result=mysqli_query($con,"select * from student_course where student_id='{$student_id}'");
        $bookinfo=mysqli_fetch_array($result);
        if($bookinfo){
          mysqli_query($con,"update student_course set course_id='{$course_id}' where student_id='{$student_id}'") or die ( "选择课程失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con));
        }else{
          mysqli_query($con,"insert into student_course values('{$student_id}','{$course_id}');") or die ( "选择课程失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con));
        }
        ?>
    <script type="text/javascript">
        alert("选择该课程成功！");
        window.location.href="course_choose.php";
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