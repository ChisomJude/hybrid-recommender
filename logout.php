<?php 
session_start();
session_destroy();
header("Location: login.php?session=You are logged out, Please Log in here");
?>
