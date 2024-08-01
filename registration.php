
<?php
//the example of inserting data with variable from HTML form
//input.php
//$conn = mysql_connect('localhost:8080','root','root');//database connection
//mysql_select_db('salil',$conn);
$conn=mysqli_connect('localhost', 'root', '', 'hybrid-book-recommender');
#$conn = mysql_connect("localhost","root","");
#$db=mysql_select_db("hybrid-book-recommender", $conn);


$username=$_POST['userid'];

$pwd=$_POST['passid'];
$name=$_POST['name'];

$age=$_POST['age'];

$email=$_POST['email'];
$city=$_POST['city'];
$country=$_POST['country'];

//inserting data order
 $sql = "INSERT INTO users VALUES('','".$username."','".$pwd."','".$name."',".$age.",'".$email."','".$city."',,'".$country."')";

//declare in the order variable
if (mysqli_query($conn, $sql)) {
    echo "Registration Successfull.";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($connection);
}

/*$query = mysql_query($sql);	//order executes
if(!$query){
	echo "Failed";
} else{
	echo "Successful";
}*/

?>


