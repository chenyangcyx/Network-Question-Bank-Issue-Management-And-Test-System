<!doctype html>
<html>
<head>
<meta charset="UTF-8">
</head>
<body>
<?php
session_start ();//将session销毁时调用destroy
session_destroy ();
?>
<script type="text/javascript">
 window.location.href="../login/login.html";
</script>
</body>
</html>