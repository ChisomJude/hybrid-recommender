
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
            
            <li><a href="register.php">Register</a></li>
            <li><a href="login.php">Login</a></li>
          
            <li class='active' style='float:right;'>
  
            </ul>
        </div>     
            
       </div> 
	  	  
<div class="center_content">
  	<div class="left_content">
        <div class="title"><span class="title_icon"><img src="images/bullet1.gif" alt="" title="" /></span>Register</div>
        
				<div class="feat_prod_box_details">
				<p class="details">
				Fill in the registration form.
				</p>
            
					<div class="contact_form">
						<div class="form_subtitle">Create new account</div>
						<form name='registration' action="registration.php" method="post"><table>
							<tr>
							<td>Username:</td>
							<td><input type="text" name="userid" required size="30" /><br></td>
							</tr>
													
							<tr>
							<td>Password:</td>
							<td><input type="password" name="passid" required  size="30" /><br></td>
							</tr>
																		
							
							<tr>
							<td>Name:</td>
							<td><input type="text" name="name" size="30" required  placeholder="Jennifer"/><br></td>
							</tr>
													
							<tr>
							<td>Age:</td>
							<td><input type="text" name="age" size="30"required  placeholder="15" /><br></td>
							</tr>
							
							<tr>
							<td>Email:</td>
							<td><input type="text" name="email" required  size="30" placeholder="someone@email.com" /><br></td>
							</tr>

							<tr>
							<td>City</td>
							<td><input type="text" name="city" required  size="30" placeholder="Awka" /><br></td>
							</tr>

							<tr>
							<td>Country:</td>
							<td><input type="text" name="country" required  size="30" Placeholder="Nigeria" /><br></td>
							</tr>
							
							<tr>
							<td></td><td><input type="submit" class="register" value="Register" />
							</td>
							</tr>
						</table>
						</form>
					</div>
				</div>
<script>

		function formValidation()
		{
		var uid = document.registration.userid;
		var passid = document.registration.passid;
		var uname = document.registration.name;
		var uage = document.registration.age;
		var uemail = document.registration.email;
		var confirmpass=document.registration.confirmpassid;
		{
		if(passid_validation(passid,7,12))
		{
		if(allLetter(uname))
		{
		if(alphanumeric(uage))
		{ 
		if(ValidateEmail(uemail))
		{
		}
		} 
		}
		}
		}
		return false;
		}

		function userid_validation(uid,mx,my)
		{
		var uid_len = uid.value.length;
		if (uid_len == 0 || uid_len >= my || uid_len < mx)
		{	
		alert("User Id should not be empty / length be between "+mx+" to "+my);
		uid.focus();
		return false;
		}
		return true;
		}	
		
		function passid_validation(passid,mx,my)
		{
		var passid_len = passid.value.length;
		if (passid_len == 0 ||passid_len >= my || passid_len < mx)
		{
		alert("Password should not be empty / length be between "+mx+" to "+my);
		passid.focus();
		return false;
		}
		return true;
		}

		function allLetter(uname)
		{ 
		var letters = /^[a-zA-Z ]*$/;
		uname_len=uname.value.length;
		if (uname_len==0)
		{
		alert("Name field cannot be empty");
		return false;
		uname.focus();
		}
		else if(uname.value.match(letters))
		{
		return true;
		}
		else
		{
		alert('name must have alphabet characters only');
		uname.focus();
		return false;
		}
		}
		
		function alphanumeric(uage)
		{ 	
		var letters = /^[0-9]*$/;
		uage_len=uage.value.length;
		if (uage_len==0)
		{
		alert("Address field cannot be empty");
		return false;
		uage.focus();
		}
		else if(uage.value.match(letters))
		{
		return true;
		}
		else
		{
		alert('Age must have numeric characters only');
		uage.focus();
		return false;
		}
		}

		function ValidateEmail(uemail)
		{
		var mailformat = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/;
		uemail_len=uemail.value.length;
		if (uemail_len==0)
		{
		alert("Email ID field cannot be empty");
		}
		else if(uemail.value.match(mailformat))
		{
		alert("Form Succesfully Submitted");
		uid.focus();
		return true;
		}
		else
		{
		alert("You have entered an invalid email address!");
		uemail.focus();
		return false;
		}
		} 
</script>
         
            
              

            

            
        <div class="clear">
		</div>
    </div><!--end of left content-->
        
    <?php include('right_content.php');?>
       
       <div class="clear">
	   </div>
</div><!--end of center content-->
       
<?php include ('footer.php');?>         
       

</body>
</html>