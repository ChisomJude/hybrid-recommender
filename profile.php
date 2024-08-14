<?php include('top.php'); ?>
<?php include('header.php'); 
$user_id = $_SESSION['user_id']; 
?>

<div class="center_content">
    <div class="left_content">

        <div class="title"><span class="title_icon"><img src="images/bullet1.gif" alt="" title="" /></span>Edit Profile</div>
        
        <div class="feat_prod_box_details">
            <p class="details">
                Update your profile information
            </p>
                <?php
                // Handle form submission
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $newUsername = mysqli_real_escape_string($conn, $_POST['username']);
                    $newPassword = mysqli_real_escape_string($conn, $_POST['passid']); // Consider hashing this
                    $newName = mysqli_real_escape_string($conn, $_POST['name']);
                    $newAge = mysqli_real_escape_string($conn, $_POST['age']);
                    $newEmail = mysqli_real_escape_string($conn, $_POST['email']);
                    $newCity = mysqli_real_escape_string($conn, $_POST['city']);
                    $newCountry = mysqli_real_escape_string($conn, $_POST['country']);

                    // Update user data in the database
                    $updateQuery = "
                        UPDATE users 
                        SET myusername='$newUsername', mypassword='$newPassword', name='$newName', age='$newAge', email='$newEmail', city='$newCity', country='$newCountry' 
                        WHERE user_id='$user_id'
                    ";
                    if (mysqli_query($conn, $updateQuery)) {
                        echo "<div class='success'>Profile updated successfully!</div>";
                        // Update session data
                        //$_SESSION['user_id'] = $newUsername;
                    } else {
                        echo "<div class='error'>Error updating profile: " . mysqli_error($conn) . "</div>";
                    }
                }

                // Fetch updated user data from the database
                $query = "SELECT * FROM users WHERE user_id='$user_id'";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    $user = mysqli_fetch_assoc($result);
                } else {
                    echo "User not found.";
                    exit;
                }

                // Initialize variables with user data
                $username = $user['myusername'];
                $password = $user['mypassword']; // Consider encrypting this before displaying
                $name = $user['name'];
                $age = $user['age'];
                $email = $user['email'];
                $city = $user['city'];
                $country = $user['country'];
                ?>

            <div class="contact_form">
                <div class="form_subtitle">Your Profile</div>
                <form name='profile' action="profile.php" method="post">
                    <table>
                        <tr>
                            <td>Username:</td>
                            <td><input type="text" name="username" value="<?php echo $username; ?>" required size="30" /><br></td>
                        </tr>
                                                
                        <tr>
                            <td>Password:</td>
                            <td><input type="password" name="passid" value="<?php echo $password; ?>" required size="30" /><br></td>
                        </tr>
                                                                        
                        <tr>
                            <td>Name:</td>
                            <td><input type="text" name="name" value="<?php echo $name; ?>" size="30" required /><br></td>
                        </tr>
                                                
                        <tr>
                            <td>Age:</td>
                            <td><input type="text" name="age" value="<?php echo $age; ?>" size="30" required /><br></td>
                        </tr>
                        
                        <tr>
                            <td>Email:</td>
                            <td><input type="text" name="email" value="<?php echo $email; ?>" required size="30" /><br></td>
                        </tr>

                        <tr>
                            <td>City:</td>
                            <td><input type="text" name="city" value="<?php echo $city; ?>" required size="30" /><br></td>
                        </tr>

                        <tr>
                            <td>Country:</td>
                            <td><input type="text" name="country" value="<?php echo $country; ?>" required size="30" /><br></td>
                        </tr>
                        
                        <tr>
                            <td></td>
                            <td><input type="submit" class="register" value="Update" /></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div> 

        <div class="clear"></div>
    </div><!--end of left content-->
        
    <?php include('right_content.php'); ?>
    
    <div class="clear"></div>
</div><!--end of center content-->

<?php include ('footer.php'); ?>         
</body>
</html>
