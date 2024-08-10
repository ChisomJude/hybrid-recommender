<?php
include ('dbcon.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bookId = intval($_POST['bookId']);
    $userId = intval($_POST['userId']);

    // Check if the user has already liked the book
    $checkSql = "SELECT * FROM `userlikes` WHERE user_id = ? AND book_id = ?";
    $stmt = mysqli_prepare($conn, $checkSql);
    mysqli_stmt_bind_param($stmt, "ii", $userId, $bookId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "You have already liked this book.";
    } else {
        // Insert the like into the database
        $insertSql = "INSERT INTO userlikes (user_id, book_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $insertSql);
        mysqli_stmt_bind_param($stmt, "ii", $userId, $bookId);

        if (mysqli_stmt_execute($stmt)) {
            echo "Book liked successfully.";
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }
    }

    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
?>
