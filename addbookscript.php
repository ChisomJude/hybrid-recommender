<?php

// Sanitize input data
$category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
$image_id = mysqli_real_escape_string($conn, $_POST['image_id']);
$booktitle = mysqli_real_escape_string($conn, $_POST['booktitle']);
$book_category_age = mysqli_real_escape_string($conn, $_POST['book_category_age']);
$book_category_city = mysqli_real_escape_string($conn, $_POST['book_category_city']);

// Prepare and execute the SQL statement
$sql = "INSERT INTO books (category_id, image_id, booktitle, book_category_age, book_category_city) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssss", $category_id, $image_id, $booktitle, $book_category_age, $book_category_city);

if (mysqli_stmt_execute($stmt)) {
    echo "Book added successfully!";
} else {
    echo "Error adding book: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
