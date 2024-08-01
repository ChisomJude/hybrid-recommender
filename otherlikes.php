<?php


// Fetch user information
$user_id = $_SESSION['user_id']; // Assuming the logged-in user has user_id = 1
$user_query = "SELECT age, city FROM users WHERE user_id = ?";
$user_stmt = mysqli_prepare($conn, $user_query);
mysqli_stmt_bind_param($user_stmt, 'i', $user_id);
mysqli_stmt_execute($user_stmt);
$user_result = mysqli_stmt_get_result($user_stmt);
$user_data = mysqli_fetch_assoc($user_result);
$age = $user_data['age'];
$city = $user_data['city'];

// Fetch similar users' liked books
$similar_users_query = "SELECT DISTINCT b.book_id, b.booktitle, b.image_id FROM users u 
                        JOIN userlikes ul ON u.user_id = ul.user_id 
                        JOIN books b ON ul.book_id = b.book_id 
                        WHERE u.age BETWEEN ? AND ? AND u.city = ? AND ul.book_id NOT IN (SELECT book_id FROM userlikes WHERE user_id = ?) LIMIT 5";
$similar_users_stmt = mysqli_prepare($conn, $similar_users_query);
$age_lower = $age - 7;
$age_upper = $age + 7;
mysqli_stmt_bind_param($similar_users_stmt, 'iisi', $age_lower, $age_upper, $city, $user_id);
mysqli_stmt_execute($similar_users_stmt);
$similar_users_result = mysqli_stmt_get_result($similar_users_stmt);
?>

<div class="right_content">
    <div class="right_box">
        <div class="title" align="right"><span class="title_icon"><img src="images/bullet4.gif" alt="" title=""/></span>Books liked by similar users</div>

        <?php if ($similar_users_result && mysqli_num_rows($similar_users_result) > 0): ?>
            <?php while ($book = mysqli_fetch_assoc($similar_users_result)): ?>
                <div class="new_prod_box">
                    <a href="details.php?bid=<?php echo $book['book_id']; ?>"><?php echo $book['booktitle']; ?></a>
                    <div class="new_prod_bg">
                        <span class="new_icon"><img src="images/promo_icon.gif" alt="" title="" class="right"/></span>
                        <a href="details.php?bid=<?php echo $book['book_id']; ?>"><img src="images/book-cover/<?php echo $book['image_id']; ?>.png" alt="" title="" class="thumb" border="0" /></a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <h4>No book recommendations available from similar users.</h4>
            <p>You are seeing this because you haven't <a href="category.php">liked any books on our collection</a> or there are no users with similar behaviour.</p>
        <?php endif; ?>

    </div>
</div>
