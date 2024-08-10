<?php include('top.php'); ?>
<?php include('header.php'); ?>

<?php
$user_id = $_SESSION['user_id']; // Assuming the logged-in user has user_id = 1

// Check if a book is being removed from likes
if (isset($_GET['remove'])) {
    $book_id = intval($_GET['remove']);
    $remove_query = "DELETE FROM userlikes WHERE user_id = ? AND book_id = ?";
    $remove_stmt = mysqli_prepare($conn, $remove_query);
    mysqli_stmt_bind_param($remove_stmt, 'ii', $user_id, $book_id);
    mysqli_stmt_execute($remove_stmt);
}

// Fetch user information
$user_query = "SELECT age, city FROM users WHERE user_id = ?";
$user_stmt = mysqli_prepare($conn, $user_query);
mysqli_stmt_bind_param($user_stmt, 'i', $user_id);
mysqli_stmt_execute($user_stmt);
$user_result = mysqli_stmt_get_result($user_stmt);
$user_data = mysqli_fetch_assoc($user_result);
$age = $user_data['age'];
$city = $user_data['city'];

// Fetch liked books
$liked_books_query = "SELECT b.book_id, b.booktitle, b.image_id FROM books b INNER JOIN userlikes ul ON b.book_id = ul.book_id WHERE ul.user_id = ?";
$liked_books_stmt = mysqli_prepare($conn, $liked_books_query);
mysqli_stmt_bind_param($liked_books_stmt, 'i', $user_id);
mysqli_stmt_execute($liked_books_stmt);
$liked_books_result = mysqli_stmt_get_result($liked_books_stmt);
?>

<div class="center_content">
    <div class="left_content">
        <div class="title"><span class="title_icon"><img src="images/bullet1.gif" alt="" title="" /></span>Your Liked Books</div>

        <?php if (mysqli_num_rows($liked_books_result) > 0): ?>
            <?php while ($book = mysqli_fetch_assoc($liked_books_result)): ?>
                <div class="feat_prod_box">
                    <div class="prod_img"><a href="details.php?bid=<?php echo $book['book_id']; ?>"><img src="images/book-cover/<?php echo $book['image_id']; ?>" alt="" title="" border="0" /></a></div>
                    <div class="prod_det_box">
                        <span class="special_icon"><img src="images/special_icon.gif" alt="" title="" /></span>
                        <div class="box_top"></div>
                        <div class="box_center">
                            <div class="prod_title"><?php echo $book['booktitle']; ?></div>
                            <p class="details">This is a dummy description...</p>
                            <a href="details.php?bid=<?php echo $book['book_id']; ?>" class="more">- more details -</a>
                            <a href="likes.php?remove=<?php echo $book['book_id']; ?>" class="remove">- remove from likes -</a>
                            <div class="clear"></div>
                        </div>
                        <div class="box_bottom"></div>
                    </div>
                    <div class="clear"></div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no_recommendations">
            <p>You haven't liked any books yet. Go to <a href="category.php">our collection</a> and start liking books.</p>
        </div>
        <?php endif; ?>
        
        <div class="pagination">
            <span class="disabled">&lt;&lt;</span>
            <span class="current">1</span>
            <a href="#?page=2">2</a>
            <a href="#?page=3">3</a>
            <a href="#?page=4">4</a>
            <a href="#?page=5">5</a>
            <a href="#?page=6">&gt;&gt;</a>
        </div>

        <div class="clear"></div>
    </div><!-- end of left content -->

    
    <?php include('otherlikes.php'); ?>
    <div class="clear"></div>
</div><!-- end of center content -->
<style>
    .center_content {
        display: flex;
        justify-content: space-between;
       
    }

    .left_content {
        width: 65%;
        background: #f9f9f9;
        padding-right : 50px;
    }

    .right_content {
        width: 30%;
        background: #f1f1f1;
        padding: 20px;
        padding-bottom:50px;
        
    }

    .no_recommendations {
        margin-top: 50px;
        font-size: 16px;
        color: #555;
    }

    .clear {
        clear: both;
    }
</style>

<?php include('footer.php'); ?>
