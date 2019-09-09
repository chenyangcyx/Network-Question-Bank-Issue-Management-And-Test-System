<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>发送留言中</title>
</head>
<body>
<?php
    session_start ();
    $teacher_id_temp=$_POST['teacher_id'];
    $message_contents=$_POST['message_contents'];
    $teacher_id=substr($teacher_id_temp,0,strrpos($teacher_id_temp,' - '));
    $message_time=date("Y-m-d h:i:s");
    $con=mysqli_connect("localhost","root","root","stu_test");//连接mysql数据库
    if (!$con) {
      die('数据库连接失败'.mysqli_connect_error());
    }
    mysqli_query($con,"set names 'utf8'");
    if (isset ( $_SESSION ["code"] )) {//判断code存不存在，如果不存在，说明异常登录
        $result=mysqli_query($con,"select * from student_info where student_username='${_SESSION["username"]}'");
        $bookinfo=mysqli_fetch_array($result);
        $student_id=$bookinfo['student_id'];
        mysqli_free_result($result);
        mysqli_query($con,"insert into messages() values('{$student_id}','{$teacher_id}','{$message_time}','{$message_contents}');") or die ( "发送失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con));
        ?>
    <script type="text/javascript">
        alert("发送留言成功！");
        window.location.href="leave_message.php";
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