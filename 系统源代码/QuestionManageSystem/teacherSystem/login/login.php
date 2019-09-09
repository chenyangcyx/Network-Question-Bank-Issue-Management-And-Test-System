<html>
<head>
  <meta charset="UTF-8">
  <title>教师登录</title>
</head>
<body>
  <?php 
    session_start();//登录系统开启一个session内容
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
    //查出对应用户名的信息
    while ($row=mysqli_fetch_array($result)) {//while循环将$result中的结果找出来
      $dbusername=$row["teacher_username"];
      $dbpassword=$row["teacher_password"];
    }
    if (is_null($dbusername)) { //用户名在数据库中不存在时跳回login.html界面
  ?>
  <script type="text/javascript">
    alert("用户名不存在，请重新输入！");
    window.location.href="login.html";
  </script>
  <?php
    }
    else {
      if ($dbpassword!=$password){  //当对应密码不对时跳回login.html界面
  ?>
  <script type="text/javascript">
    alert("密码错误，请重新输入！");
    window.location.href="login.html";
  </script>
  <?php
      }
      else {
        $_SESSION["username"]=$username;
        $_SESSION["code"]=mt_rand(0, 100000);
        //给session附一个随机值，防止用户直接通过调用界面访问
  ?>
  <script type="text/javascript">
    window.location.href="../manage/index.php";
  </script>
  <?php
      }
    }
  mysqli_close($con);  //关闭数据库连接
  ?>
</body>
</html>