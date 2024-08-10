<?php
session_start();
if(isset($_SESSION['user_id']))
header("Location:category.php");
else
header("Location:login.php");
?>

<html>
<body>
Login Successful
</body>
</html>