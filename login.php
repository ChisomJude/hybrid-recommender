
<?php include('top.php');?>

<?php

//session_start(); // Right at the top of your script
//$session_name = session_name("WebsiteID");
//echo session_name();
?> 

       <div class="header">
       		<div class="logo"><a href="index.php"><img src="images/logo.gif" alt="" title="" border="0" /></a></div>            
        <div id="menu">
            <ul>                                                                       
            <li><a href="index.php">Home </a></li>
            <li><a href="about.php">About </a></li>
            
            <li><a href="register.php">Register</a></li>
            <li><a href="login.php">Login</a></li>
          
            <li class='active' style='float:right;'>
  
            </ul>
        </div>     
            
       </div> 
	  	  
       
       
       <div class="center_content">
       	<div class="left_content">
            <div class="title"><span class="title_icon"><img src="images/bullet1.gif" alt="" title="" /></span>My account</div>
        
        	<div class="feat_prod_box_details">
            <p class="details">
             Login using this form
            </p> <p style="color:red;">
                <?php 
                if (isset($_GET['session'])) { 
                    echo htmlspecialchars($_GET['session']); 
                }
                ?>
            
              	<div class="contact_form">
                <div class="form_subtitle">Login</div>
                 <form name="register" action="logindb.php" method="post">
                    <table>
					<tr>
					<td>Username:</td>
                    <td><input type="text" name="myusername" /></td>
					</tr>
                 

                    <tr><td>Password:</td>
					<td><input type="password" name="mypassword" /></td><tr>

                    
					<tr><td></td><td><input type="submit" name="submit" value="login" /></td></tr>
                    </table>
                    
                  </form>     
                    
                </div>  
            
            </div>	
            
              

            

            
        <div class="clear"></div>
        </div><!--end of left content-->
       
	   <?php include('right_content.php');?>
       
       
       <div class="clear"></div>
       </div><!--end of center content-->
       
              
       <?php include ('footer.php');?>         
       

</body>
</html>