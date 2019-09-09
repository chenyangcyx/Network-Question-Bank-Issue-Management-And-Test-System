<html>
<head>
<meta charset="UTF-8">
  <title>教师注册</title>
</head>
<body>
  <?php 
    session_start();
    $teacher_id=$_POST["teacher_id"];
    $teacher_name=$_POST["teacher_name"];
    $username=$_POST["username"];
    $password=$_POST["password"];
  
    $con=mysqli_connect("localhost","root","root","stu_test");//连接mysql数据库
    if (!$con) {
      die('数据库连接失败'.mysqli_connect_error());
    }
    mysqli_query($con,"set names 'utf8'");
    $dbusername=null;
    $dbpassword=null;
    $result=mysqli_query($con,"select * from teacher_account where teacher_username ='{$username}';");
    while ($row=mysqli_fetch_array($result)) {
      $dbusername=$row["teacher_username"];
      $dbpassword=$row["teacher_password"];
    }
    if(!is_null($dbusername)){
  ?>
  <script type="text/javascript">
    alert("用户已存在！请更换用户名");
    window.location.href="login.html";
  </script>
  <?php
    }
    else{
      mysqli_query($con,"insert into teacher_account() values('{$username}','{$password}')") or die("注册账号失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con)) ;
      mysqli_query($con,"insert into teacher_info() values('{$teacher_id}','{$teacher_name}','{$username}')") or die("注册账号失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con)) ;
      mysqli_close($con);  //关闭数据库连接
    }
  ?>
  <script type="text/javascript">
    alert("注册成功，返回登录界面");
    window.location.href="login.html";
  </script>
</body>
</html>