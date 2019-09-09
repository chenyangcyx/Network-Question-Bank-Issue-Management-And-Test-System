<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>教师账号重置</title>
</head>
<body>
<?php
    session_start ();
    $id=$_GET['id'];
    $newpassword='123456';
    $con=mysqli_connect("localhost","root","root","stu_test");//连接mysql数据库
    if (!$con) {
      die('数据库连接失败'.mysqli_connect_error());
    }
    mysqli_query($con,"set names 'utf8'");
    if (isset ( $_SESSION ["code"] )) {//判断code存不存在，如果不存在，说明异常登录
        mysqli_query($con,"update teacher_account set teacher_password='{$newpassword}' where teacher_username='{$id}'") or die ( "重置教师信息失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con));
        ?>
    <script type="text/javascript">
        alert("已经重置成功，密码为123456");
        window.location.href="teacher_account_manage.php";
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