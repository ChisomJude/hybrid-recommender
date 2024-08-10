<?php include('top.php'); ?>
<?php include('header.php'); ?>

<?php
$user_id = 1; // Assuming the logged-in user has user_id = 1

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
    $category_query = "SELECT * FROM books WHERE categoryname IN ($category_in) AND book_id NOT IN (SELECT book_id FROM userlikes WHERE user_id = ?)";
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
$age_query = "SELECT * FROM books WHERE book_category_age = ? AND book_id NOT IN (SELECT book_id FROM userlikes WHERE user_id = ?)";
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
$city_query = "SELECT * FROM books WHERE (book_category_city = ? OR book_category_city = 'All') AND book_id NOT IN (SELECT book_id FROM userlikes WHERE user_id = ?)";
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

function getPagination($result, $page, $limit = 3) {
    if ($result === false || $result === null) {
        return [[], 0];
    }
    
    $total = mysqli_num_rows($result);
    $pages = ceil($total / $limit);
    $start = ($page - 1) * $limit;
    $books = [];

    mysqli_data_seek($result, $start);
    for ($i = 0; $i < $limit; $i++) {
        $book = mysqli_fetch_assoc($result);
        if ($book) {
            $books[] = $book;
        } else {
            break;
        }
    }

    return [$books, $pages];
}

// Handle pagination
$page_category = isset($_GET['page_category']) ? intval($_GET['page_category']) : 1;
$page_age = isset($_GET['page_age']) ? intval($_GET['page_age']) : 1;
$page_city = isset($_GET['page_city']) ? intval($_GET['page_city']) : 1;

list($category_books, $total_category_pages) = getPagination($category_result, $page_category);
list($age_books, $total_age_pages) = getPagination($age_result, $page_age);
list($city_books, $total_city_pages) = getPagination($city_result, $page_city);
?>

<div class="center_content">
    <div class="tabs">
        <ul class="tab-links">
            <li class="active"><a href="#tab1">Liked Categories</a></li>
            <li><a href="#tab2">Age Category</a></li>
            <li><a href="#tab3">City Category</a></li>
        </ul>

        <div class="tab-content">
            <div id="tab1" class="tab active">
                <div class="title"><span class="title_icon"><img src="images/bullet1.gif" alt="" title="" /></span>Books you might like</div>
                <?php if (!empty($category_books)): ?>
                    <?php foreach ($category_books as $book): ?>
                        <div class="feat_prod_box">
                            <div class="prod_img"><a href="details.php?like=<?php echo $book['book_id']; ?>"><img src="images/book-cover/<?php echo $book['image_id']; ?>.png" alt="" title="" border="0" /></a></div>
                            <div class="prod_det_box">
                                <span class="special_icon"><img src="images/special_icon.gif" alt="" title="" /></span>
                                <div class="box_top"></div>
                                <div class="box_center">
                                    <div class="prod_title"><?php echo $book['booktitle']; ?></div>
                                    <p class="details">This is a dummy description...</p>
                                    <a href="details.php?like=<?php echo $book['book_id']; ?>" class="more">- more details -</a>
                                    <div class="clear"></div>
                                </div>
                                <div class="box_bottom"></div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no_recommendations">
                        <p>No book recommendations available based on your likes.</p>
                    </div>
                <?php endif; ?>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $total_category_pages; $i++): ?>
                        <a href="?page_category=<?php echo $i; ?>" <?php if ($i == $page_category) echo 'class="current"'; ?>><?php echo $i; ?></a>
                    <?php endfor; ?>
                </div>
            </div>

            <div id="tab2" class="tab">
                <div class="title"><span class="title_icon"><img src="images/bullet1.gif" alt="" title="" /></span>Books for Age Category</div>
                <?php if (!empty($age_books)): ?>
                    <?php foreach ($age_books as $book): ?>
                        <div class="feat_prod_box">
                            <div class="prod_img"><a href="details.php?like=<?php echo $book['book_id']; ?>"><img src="images/book-cover/<?php echo $book['image_id']; ?>.png" alt="" title="" border="0" /></a></div>
                            <div class="prod_det_box">
                                <span class="special_icon"><img src="images/special_icon.gif" alt="" title="" /></span>
                                <div class="box_top"></div>
                                <div class="box_center">
                                    <div class="prod_title"><?php echo $book['booktitle']; ?></div>
                                    <p class="details">This is a dummy description...</p>
                                    <a href="details.php?like=<?php echo $book['book_id']; ?>" class="more">- more details -</a>
                                    <div class="clear"></div>
                                </div>
                                <div class="box_bottom"></div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no_recommendations">
                        <p>No book recommendations available based on your age category.</p>
                    </div>
                <?php endif; ?>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $total_age_pages; $i++): ?>
                        <a href="?page_age=<?php echo $i; ?>" <?php if ($i == $page_age) echo 'class="current"'; ?>><?php echo $i; ?></a>
                    <?php endfor; ?>
                </div>
            </div>

            <div id="tab3" class="tab">
                <div class="title"><span class="title_icon"><img src="images/bullet1.gif" alt="" title="" /></span>Books for City Category</div>
                <?php if (!empty($city_books)): ?>
                    <?php foreach ($city_books as $book): ?>
                        <div class="feat_prod_box">
                            <div class="prod_img"><a href="details.php?like=<?php echo $book['book_id']; ?>"><img src="images/book-cover/<?php echo $book['image_id']; ?>.png" alt="" title="" border="0" /></a></div>
                            <div class="prod_det_box">
                                <span class="special_icon"><img src="images/special_icon.gif" alt="" title="" /></span>
                                <div class="box_top"></div>
                                <div class="box_center">
                                    <div class="prod_title"><?php echo $book['booktitle']; ?></div>
                                    <p class="details">This is a dummy description...</p>
                                    <a href="details.php?like=<?php echo $book['book_id']; ?>" class="more">- more details -</a>
                                    <div class="clear"></div>
                                </div>
                                <div class="box_bottom"></div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no_recommendations">
                        <p>No book recommendations available based on your city category.</p>
                    </div>
                <?php endif; ?>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $total_city_pages; $i++): ?>
                        <a href="?page_city=<?php echo $i; ?>" <?php if ($i == $page_city) echo 'class="current"'; ?>><?php echo $i; ?></a>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="right_content">
    <?php include('otherlikes.php'); ?>
</div><!-- end of right content -->
<div class="clear"></div>

<?php include('footer.php'); ?>

<style>
    .center_content {
        display: flex;
        justify-content: space-between;
    }

    .left_content {
        width: 65%;
        background: #f9f9f9;
        padding-right: 50px;
    }

    .right_content {
        width: 30%;
        background: #f1f1f1;
        padding: 20px;
        padding-bottom: 50px;
    }

    .no_recommendations {
        margin-top: 50px;
        font-size: 16px;
        color: #555;
    }

    .clear {
        clear: both;
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
        margin: 0px 5px;
        float: left;
        list-style: none;
    }

    .tab-links a {
        padding: 9px 15px;
        display: inline-block;
        border-radius: 3px 3px 0px 0px;
        background: #7FB5DA;
        font-size: 16px;
        font-weight: 600;
        color: #4c4c4c;
        transition: all linear 0.15s;
    }

    .tab-links a:hover {
        background: #a7cce5;
        text-decoration: none;
    }

    .tab-links .active a {
        background: #fff;
        color: #4c4c4c;
    }

    .tab-content {
        padding: 15px;
        border-radius: 3px;
        box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.15);
        background: #fff;
    }

    .tab {
        display: none;
    }

    .tab.active {
        display: block;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination a {
        margin: 0 5px;
        padding: 8px 16px;
        background: #ddd;
        color: #333;
        text-decoration: none;
        border-radius: 4px;
    }

    .pagination a.current {
        background: #007bff;
        color: #fff;
    }

    .pagination a:hover {
        background: #0056b3;
        color: #fff;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('.tab-links a').on('click', function (e) {
            var currentAttrValue = $(this).attr('href');

            // Show/Hide Tabs
            $('.tab' + currentAttrValue).show().siblings().hide();

            // Change/remove current tab to active
            $(this).parent('li').addClass('active').siblings().removeClass('active');

            e.preventDefault();
        });
    });
</script>
