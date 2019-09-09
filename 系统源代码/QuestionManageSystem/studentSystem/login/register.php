<html>
<head>
<meta charset="UTF-8">
  <title>学生注册</title>
</head>
<body>
  <?php 
    session_start();
    $student_id=$_POST["student_id"];
    $student_name=$_POST["student_name"];
    $student_class=$_POST["student_class"];
    $username=$_POST["username"];
    $password=$_POST["password"];
  
    $con=mysqli_connect("localhost","root","root","stu_test");//连接mysql数据库
    if (!$con) {
      die('数据库连接失败'.mysqli_connect_error());
    }
    mysqli_query($con,"set names 'utf8'");
    $dbusername=null;
    $dbpassword=null;
    $result=mysqli_query($con,"select * from student_account where student_username ='{$username}';");
    while ($row=mysqli_fetch_array($result)) {
      $dbusername=$row["student_username"];
      $dbpassword=$row["student_password"];
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
      mysqli_query($con,"insert into student_account() values('{$username}','{$password}')") or die("注册账号失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con)) ;
      mysqli_query($con,"insert into student_info() values('{$student_id}','{$student_name}','{$student_class}','{$username}')") or die("注册账号失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con)) ;
      mysqli_close($con);  //关闭数据库连接
    }
  ?>
  <script type="text/javascript">
    alert("注册成功，返回登录界面");
    window.location.href="login.html";
  </script>
</body>
</html>