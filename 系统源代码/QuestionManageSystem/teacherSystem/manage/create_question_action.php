<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>正在添加问题</title>
</head>
<body>
<?php
    session_start ();
    $question_no=$_POST['question_id'];
    $question_describe=$_POST['question_describe'];
    $choice_A=$_POST['choice_A'];
    $choice_B=$_POST['choice_B'];
    $choice_C=$_POST['choice_C'];
    $choice_D=$_POST['choice_D'];
    $if_keynote=$_POST['if_keynote'];
    $difficulty_degree=$_POST['difficulty_degree'];
    $correct_choice=$_POST['correct_choice'];
    $answer_detail=$_POST['answer_detail'];
    $con=mysqli_connect("localhost","root","root","stu_test");//连接mysql数据库
    if (!$con) {
      die('数据库连接失败'.mysqli_connect_error());
    }
    mysqli_query($con,"set names 'utf8'");
    if (isset ( $_SESSION ["code"] )) {//判断code存不存在，如果不存在，说明异常登录
        $username=$_SESSION["username"];
        $result=mysqli_query($con,"select teacher_info.teacher_id,teacher_course.course_id from teacher_info,teacher_course where teacher_info.teacher_id=teacher_course.teacher_id and teacher_username='{$username}'");
        $bookinfo=mysqli_fetch_array($result);
        $teacher_id=$bookinfo["teacher_id"];
        $course_id=$bookinfo["course_id"];
        mysqli_free_result($result);
        mysqli_query($con,"insert into questions() values('{$question_no}','{$teacher_id}','{$course_id}','{$question_describe}','{$choice_A}','{$choice_B}','{$choice_C}','{$choice_D}','{$if_keynote}','{$difficulty_degree}','{$correct_choice}','{$answer_detail}')") or die ( "添加问题失败，请检查你的内容！".'<br>'."错误信息：". mysqli_error ($con));
       ?>
    <script type="text/javascript">
        alert("添加问题成功！");
        window.location.href="create_question.php";
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