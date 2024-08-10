<?php require('dbcon.php');

// username and password sent from form 
$myusername=$_POST['myusername']; 
$mypassword=$_POST['mypassword'];

// To protect MySQL injection
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysqli_real_escape_string($conn, $myusername);
$mypassword = mysqli_real_escape_string($conn, $mypassword);
$sql="SELECT * FROM $tbl_name WHERE myusername='$myusername' and mypassword='$mypassword'";

$result = mysqli_query($conn, $sql);


if ($result) {
    // Get row count
    $count = mysqli_num_rows($result);

    // If result matched $myusername and $mypassword, table row must be 1 row
    if ($count == 1) {
        // Fetch the user data
        $user = mysqli_fetch_assoc($result);

        // Start the session
        session_start();

        // Store username and user ID in session variables
        $_SESSION['username'] = $myusername;
        $_SESSION['user_id'] = $user['user_id']; // Replace 'user_id' with the actual column name for user ID in your table

        // Optionally redirect to another page
        header("Location: category.php");
        exit;
    } else {
        echo "Invalid username or password.";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>









