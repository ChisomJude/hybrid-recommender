<?php include('top.php'); ?>
<?php include('header.php'); ?>

<?php
$user_id = $_SESSION['user_id']; // Assuming the logged-in user has user_id = 1

// Fetch user information
$user_query = "SELECT age, city FROM users WHERE user_id = ?";
$user_stmt = mysqli_prepare($conn, $user_query);
if (!$user_stmt) {
    die('mysqli error: ' . mysqli_error($conn));
}
mysqli_stmt_bind_param($user_stmt, 'i', $user_id);
mysqli_stmt_execute($user_stmt);
$user_result = mysqli_stmt_get_result($user_stmt);
if (!$user_result) {
    die('mysqli error: ' . mysqli_error($conn));
}
$user_data = mysqli_fetch_assoc($user_result);
$age = $user_data['age'];
$city = $user_data['city'];

// Fetch liked categories
$liked_books_query = "SELECT b.book_id, b.categoryname FROM books b INNER JOIN userlikes ul ON b.book_id = ul.book_id WHERE ul.user_id = ?";
$liked_books_stmt = mysqli_prepare($conn, $liked_books_query);
if (!$liked_books_stmt) {
    die('mysqli error: ' . mysqli_error($conn));
}
mysqli_stmt_bind_param($liked_books_stmt, 'i', $user_id);
mysqli_stmt_execute($liked_books_stmt);
$liked_books_result = mysqli_stmt_get_result($liked_books_stmt);
if (!$liked_books_result) {
    die('mysqli error: ' . mysqli_error($conn));
}
$liked_categories = [];
while ($book = mysqli_fetch_assoc($liked_books_result)) {
    $liked_categories[] = $book['categoryname'];
}

// Fetch recommendations by liked categories
$category_result = null;
if (!empty($liked_categories)) {
    $category_in = "'" . implode("', '", $liked_categories) . "'";
    $category_query = "SELECT * FROM books WHERE categoryname IN ($category_in) AND book_id NOT IN (SELECT book_id FROM userlikes WHERE user_id = ?) LIMIT 4";
    $category_stmt = mysqli_prepare($conn, $category_query);
    if (!$category_stmt) {
        die('mysqli error: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($category_stmt, 'i', $user_id);
    mysqli_stmt_execute($category_stmt);
    $category_result = mysqli_stmt_get_result($category_stmt);
    if (!$category_result) {
        die('mysqli error: ' . mysqli_error($conn));
    }
}

// Fetch recommendations by age category
$age_category = ($age > 18) ? 'Adult' : (($age > 12) ? 'Teenage' : 'Kids');
$age_query = "SELECT * FROM books WHERE book_category_age = ? AND book_id NOT IN (SELECT book_id FROM userlikes WHERE user_id = ?) LIMIT 4";
$age_stmt = mysqli_prepare($conn, $age_query);
if (!$age_stmt) {
    die('mysqli error: ' . mysqli_error($conn));
}
mysqli_stmt_bind_param($age_stmt, 'si', $age_category, $user_id);
mysqli_stmt_execute($age_stmt);
$age_result = mysqli_stmt_get_result($age_stmt);
if (!$age_result) {
    die('mysqli error: ' . mysqli_error($conn));
}

// Fetch recommendations by user city
$city_query = "SELECT * FROM books WHERE (book_category_city = ? OR book_category_city = 'All') AND book_id NOT IN (SELECT book_id FROM userlikes WHERE user_id = ?) LIMIT 4";
$city_stmt = mysqli_prepare($conn, $city_query);
if (!$city_stmt) {
    die('mysqli error: ' . mysqli_error($conn));
}
mysqli_stmt_bind_param($city_stmt, 'si', $city, $user_id);
mysqli_stmt_execute($city_stmt);
$city_result = mysqli_stmt_get_result($city_stmt);
if (!$city_result) {
    die('mysqli error: ' . mysqli_error($conn));
}
?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var tabLinks = document.querySelectorAll('.tab-links a');
    var tabContent = document.querySelectorAll('.tab-content .tab');

    tabLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();

            // Remove active class from all links and tabs
            tabLinks.forEach(function(link) {
                link.parentElement.classList.remove('active');
            });
            tabContent.forEach(function(tab) {
                tab.classList.remove('active');
            });

            // Add active class to clicked link and corresponding tab
            var activeTab = document.querySelector(this.getAttribute('href'));
            this.parentElement.classList.add('active');
            activeTab.classList.add('active');
        });
    });
  });

</script> 
<div class="center_content">
   <div class="left_content">
        <div class="tabs">
            <ul class="tab-links">
                <li class="active"><a href="#tab1">Liked Categories</a></li>
                <li><a href="#tab2">Age Category</a></li>
                <li><a href="#tab3">City Category</a></li>
            </ul>

            <div class="tab-content">
                <div id="tab1" class="tab active">
                    <div class="title"><span class="title_icon"><img src="images/bullet1.gif" alt="" title="" /></span>Books you might like</div>
                    <?php if ($category_result && mysqli_num_rows($category_result) > 0): ?>
                        <?php while ($book = mysqli_fetch_assoc($category_result)): ?>
                            <div class="feat_prod_box">
                                <div class="prod_img"><a href="details.php?bid=<?php echo $book['book_id']; ?>"><img src="images/book-cover/<?php echo $book['image_id']; ?>" alt="" title="" border="0" /></a></div>
                                <div class="prod_det_box">
                                    <span class="special_icon"><img src="images/special_icon.gif" alt="" title="" /></span>
                                    <div class="box_top"></div>
                                    <div class="box_center">
                                        <div class="prod_title"><?php echo $book['booktitle']; ?></div>
                                        <p class="details">This is a dummy description...</p>
                                        <a href="details.php?bid=<?php echo $book['book_id']; ?>" class="more">- more details -</a>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="box_bottom"></div>
                                </div>
                                <div class="clear"></div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="no_recommendations">
                            <p>No book recommendations available based on your likes or you currently have no likes.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div id="tab2" class="tab">
                    <div class="title"><span class="title_icon"><img src="images/bullet1.gif" alt="" title="" /></span>Books for Age Category</div>
                    <?php if ($age_result && mysqli_num_rows($age_result) > 0): ?>
                        <?php while ($book = mysqli_fetch_assoc($age_result)): ?>
                            <div class="feat_prod_box">
                                <div class="prod_img"><a href="details.php?bid=<?php echo $book['book_id']; ?>"><img src="images/book-cover/<?php echo $book['image_id']; ?>" alt="" title="" border="0" /></a></div>
                                <div class="prod_det_box">
                                    <span class="special_icon"><img src="images/special_icon.gif" alt="" title="" /></span>
                                    <div class="box_top"></div>
                                    <div class="box_center">
                                        <div class="prod_title"><?php echo $book['booktitle']; ?></div>
                                        <p class="details">This is a dummy description...</p>
                                        <a href="details.php?bid=<?php echo $book['book_id']; ?>" class="more">- more details -</a>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="box_bottom"></div>
                                </div>
                                <div class="clear"></div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="no_recommendations">
                            <p>No book recommendations available based on your age category.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div id="tab3" class="tab">
                    <div class="title"><span class="title_icon"><img src="images/bullet1.gif" alt="" title="" /></span>Books for City Category</div>
                    <?php if ($city_result && mysqli_num_rows($city_result) > 0): ?>
                        <?php while ($book = mysqli_fetch_assoc($city_result)): ?>
                            <div class="feat_prod_box">
                                <div class="prod_img"><a href="details.php?bid=<?php echo $book['book_id']; ?>"><img src="images/book-cover/<?php echo $book['image_id']; ?>" alt="" title="" border="0" /></a></div>
                                <div class="prod_det_box">
                                    <span class="special_icon"><img src="images/special_icon.gif" alt="" title="" /></span>
                                    <div class="box_top"></div>
                                    <div class="box_center">
                                        <div class="prod_title"><?php echo $book['booktitle']; ?></div>
                                        <p class="details">This is a dummy description...</p>
                                        <a href="details.php?bid=<?php echo $book['book_id']; ?>" class="more">- more details -</a>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="box_bottom"></div>
                                </div>
                                <div class="clear"></div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="no_recommendations">
                            <p>No book recommendations available based on your city category.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="right_content">
        <?php include('otherlikes.php'); ?>
    </div>
    <div class="clear"></div>
</div>

<?php include('footer.php'); ?>
<style>
        .no_recommendations {
                margin-top: 50px;
                font-size: 16px;
                color: #555;
            }



        .tabs {
            width: 100%;
            display: inline-block;
        }

        .tab-links:after {
            display: block;
            clear: both;
            content: '';
        }

        .tab-links li {
            margin: 0;
            float: left;
            list-style: none;
        }

        .tab-links a {
            padding: 9px 15px;
            display: inline-block;
            border-radius: 3px 3px 0 0;
            background: #7FB5DA;
            font-size: 16px;
            font-weight: 600;
            color: #4c4c4c;
            transition: all linear 0.15s;
            text-decoration: none;
        }

        .tab-links a:hover {
            background: #;
            text-decoration: none;
        }

        .tab-links .active a {
            background: #fff;
            color: #4c4c4c;
        }

        .tab-content {
            padding: 15px;
            border-radius: 3px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.15);
            background: #fff;
        }

        .tab {
            display: none;
        }

        .tab.active {
            display: block;
        }

</style>