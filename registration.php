
<?php

$conn=mysqli_connect('localhost', 'root', '', 'hybrid-book-recommender');

$username=$_POST['userid'];

$pwd=$_POST['passid'];
$name=$_POST['name'];

$age=$_POST['age'];

$email=$_POST['email'];
$city=$_POST['city'];
$country=$_POST['country'];

//inserting data order
 $sql = "INSERT INTO users VALUES('','".$username."','".$pwd."','".$name."',".$age.",'".$email."','".$city."','".$country."')";

//declare in the order variable
if (mysqli_query($conn, $sql)) {
    header("Location: index.php?session=Registration Successfull, Please Log in here");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

/*$query = mysql_query($sql);	//order executes
if(!$query){
	echo "Failed";
} else{
	echo "Successful";
}*/

?>


