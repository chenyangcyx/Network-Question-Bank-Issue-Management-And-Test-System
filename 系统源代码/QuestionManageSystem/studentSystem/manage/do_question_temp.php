<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>筛选 跳转中</title>
</head>
<body>
<?php
    session_start ();
    $if_keynote_temp=$_POST['if_keynote'];
    $degree_temp=$_POST['degree'];
    if($if_keynote_temp=='非重点'){$if_keynote=0;}
    if($if_keynote_temp=='重点'){$if_keynote=1;}
    if($if_keynote_temp=='全部'){$if_keynote=2;}
    if($degree_temp=='全部'){
        $degree=0;
    }else{
        $degree=substr($degree_temp,15,10);
    }
    $con=mysqli_connect("localhost","root","root","stu_test");//连接mysql数据库
    if (!$con) {
      die('数据库连接失败'.mysqli_connect_error());
    }
    mysqli_query($con,"set names 'utf8'");
    if (isset ( $_SESSION ["code"] )) {//判断code存不存在，如果不存在，说明异常登录
        ?>
    <script type="text/javascript">
        window.location.href="do_question.php?if=<?php echo $if_keynote ?>&degree=<?php echo $degree ?>";
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