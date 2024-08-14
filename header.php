<?php 
session_start();
if(isset($_SESSION['user_id'])){


include('top.php');
require('dbcon.php');
}else{

    header("Location: index.php?session=Session Expired, Please Login Again");    
}
?>


       <div class="header">
       		<div class="logo"><a href="index.php"><img src="images/logo.gif" alt="" title="" border="0" /></a></div>            
        <div id="menu">
            <ul>                                                                       
            <li><a href="category.php">Home</a></li>
            <li><a href="profile.php">Your Profile</a></li>
            <li><a href="likes.php">Your Preferences</a></li>
            <li><a href="specials.php">Recommendation</a></li>
            <li><a href="logout.php">Log Out</a></li>
           
<li class='active' style='float:right;'>
  
            </ul>
        </div>     
            
       </div> 
	  	   
	   


