<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>教师 修改/发布通知</title>
</head>
<body>
<?php
    session_start ();
    $contents=$_POST['notice_contents'];
    $time=date("Y-m-d h:i:s");
    $con=mysqli_connect("localhost","root","root","stu_test");//连接mysql数据库
    if (!$con) {
      die('数据库连接失败'.mysqli_connect_error());
    }
    mysqli_query($con,"set names 'utf8'");
    if (isset ( $_SESSION ["code"] )) {//判断code存不存在，如果不存在，说明异常登录
        $result=mysqli_query($con,"select * from notice_teacher where admin_username='${_SESSION["username"]}'");
        $bookinfo=mysqli_fetch_array($result);
        if($bookinfo){
            mysqli_query($con,"update notice_teacher set notice_contents='{$contents}',notice_time='{$time}' where admin_username='${_SESSION["username"]}'") or die ( "更新通知信息失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con));
?>
            <script type="text/javascript">
            alert("已经更新通知内容！");
            window.location.href="teacher_notice.php";
            </script>
<?php
        }else{
            mysqli_query($con,"insert into notice_teacher values('${_SESSION["username"]}','{$contents}','{$time}')") or die ( "添加通知信息失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con));
?>
            <script type="text/javascript">
            alert("已经添加通知内容！");
            window.location.href="teacher_notice.php";
            </script>
<?php
        }
?>

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