<?php

$host="127.0.0.1"; // Host name 
$username="root"; // Mysql username 
$password=""; // Mysql password 
$db_name="hybrid-book-recommender"; // Database name 
$tbl_name="users"; // Table name 

// Connect to server and select database.
$conn=mysqli_connect($host, $username, $password, $db_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

