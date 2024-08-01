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
        	
            <div class="title"><span class="title_icon"><img src="images/bullet1.gif" alt="" title="" /></span>Featured books</div>
        
        	<div class="feat_prod_box">
            
            	<div class="prod_img"><a href=""><img src="images/book-cover/1.png" alt="" title="" border="0" /></a></div>
                
                <div class="prod_det_box">
                	<div class="box_top"></div>
                    <div class="box_center">
                    <div class="prod_title">Hello January</div>
                    <p class="details">You are in for a new start and intentional growth</p>
                    <a href="" class="more">- more details -</a>
                    <div class="clear"></div>
                    </div>
                    
                    <div class="box_bottom"></div>
                </div>    
            <div class="clear"></div>
            </div>	
            
            
        	<div class="feat_prod_box">
            
            	<div class="prod_img"><a href=""><img src="images/book-cover/6.png" alt="" title="" border="0" /></a></div>
                
                <div class="prod_det_box">
                	<div class="box_top"></div>
                    <div class="box_center">
                    <div class="prod_title">Summer Vibes</div>
                    <p class="details">Focused on JAPA, a summer location and plans, get ready to fly this Summer</p>
                    <a href="" class="more">- more details -</a>
                    <div class="clear"></div>
                    </div>
                    
                    <div class="box_bottom"></div>
                </div>    
            <div class="clear"></div>
            </div>      
            
            
            
           <div class="title"><span class="title_icon"><img src="images/bullet2.gif" alt="" title="" /></span>New books</div> 
           
           <div class="new_products">
           
                    <div class="new_prod_box">
                        <a href="details.html">ABC Kids</a>
                        <div class="new_prod_bg">
                        <span class="new_icon"><img src="images/new_icon.gif" alt="" title="" /></span>
                        <a href="details.html"><img src="images/smallbookcover/5.png" alt="" title="" class="thumb" border="0" /></a>
                        </div>           
                    </div>
                    
                    <div class="new_prod_box">
                        <a href="details.html">Minimalist Skincare Routine</a>
                        <div class="new_prod_bg">
                        <span class="new_icon"><img src="images/new_icon.gif" alt="" title="" /></span>
                        <a href="details.html"><img src="images/smallbookcover/8.png" alt="" title="" class="thumb" border="0" /></a>
                        </div>           
                    </div>                    
                    
                    <div class="new_prod_box">
                        <a href="details.html">ATOM</a>
                        <div class="new_prod_bg">
                        <span class="new_icon"><img src="images/new_icon.gif" alt="" title="" /></span>
                        <a href="details.html"><img src="images/smallbookcover/9.png" alt="" title="" class="thumb" border="0" /></a>
                        </div>           
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