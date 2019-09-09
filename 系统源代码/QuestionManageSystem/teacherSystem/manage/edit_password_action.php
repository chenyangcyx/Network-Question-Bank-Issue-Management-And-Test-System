<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>正在修改密码</title>
</head>
<body>
<?php
    session_start ();
    $oldpassword=$_POST["old_password"];
    $newpassword=$_POST["new_password"];
    $confirmpassword=$_POST["confirm_password"];
    $con=mysqli_connect("localhost","root","root","stu_test");//连接mysql数据库
    if (!$con) {
      die('数据库连接失败'.mysqli_connect_error());
    }
    mysqli_query($con,"set names 'utf8'");
    if (isset ( $_SESSION ["code"] )) {//判断code存不存在，如果不存在，说明异常登录
        $result=mysqli_query($con,"select * from teacher_account where teacher_username='${_SESSION["username"]}'");
		$bookinfo=mysqli_fetch_array($result);
        $dbpassword=$bookinfo["teacher_password"];
        if($dbpassword!=$oldpassword){
            ?>
        <script type="text/javascript">
            alert("输入的原密码不正确！");
            window.location.href="edit_password.php";
        </script>
        <?php
        }
        if($newpassword!=$confirmpassword){
            ?>
        <script type="text/javascript">
            alert("两次输入的密码不匹配！");
            window.location.href="edit_password.php";
        </script>
        <?php
        }
        if(($dbpassword==$oldpassword)&&($newpassword==$confirmpassword)){
        mysqli_query($con,"update teacher_account set teacher_password='{$newpassword}' where teacher_username='${_SESSION["username"]}'") or die ( "修改密码失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con));
        //如果上述用户名密码判定不错，则update进数据库中
        }
        ?>
    <script type="text/javascript">
        alert("密码修改成功！");
        window.location.href="edit_password.php";
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