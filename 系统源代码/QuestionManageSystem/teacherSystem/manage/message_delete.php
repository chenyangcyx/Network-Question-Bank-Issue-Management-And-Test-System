<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>删除留言中</title>
</head>
<body>
<?php
    session_start ();
    $student_id=$_GET['student_id'];
    $teacher_id=$_GET['teacher_id'];
    $message_time=$_GET['message_time'];
    $con=mysqli_connect("localhost","root","root","stu_test");//连接mysql数据库
    if (!$con) {
      die('数据库连接失败'.mysqli_connect_error());
    }
    mysqli_query($con,"set names 'utf8'");
    if (isset ( $_SESSION ["code"] )) {//判断code存不存在，如果不存在，说明异常登录
        mysqli_query($con,"delete from messages where student_id='{$student_id}' and teacher_id='{$teacher_id}' and message_time='{$message_time}'") or die ( "删除失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con));
        ?>
    <script type="text/javascript">
        alert("删除留言成功！");
        window.location.href="message.php";
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