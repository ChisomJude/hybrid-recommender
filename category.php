<?php include('top.php');?>
<?php include('header.php'); ?>

<style>
/* Add this CSS to your existing stylesheet */

/* Style for the new_products container */
.new_products {
    display: flex;
    flex-direction: column;
    gap: 20px; /* Add space between rows */
}

/* Style for each new product row */
.new_products .row {
    display: flex;
    justify-content: space-between;
    gap: 20px; /* Add space between columns */
}

/* Style for each new product box in the new_products container */
.new_products .new_prod_box {
    background-color: #f9f9f9;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 10px;
    width: calc(33.33% - 13.33px); /* Adjust width to fit three items per row, accounting for gap */
    box-sizing: border-box; /* Include padding and border in the element's total width and height */
    text-align: center;
    overflow: hidden; /* Ensure the content does not overflow the box */
}

/* Style for product links in the new_products container */
.new_products .new_prod_box a {
    color: #333;
    text-decoration: none;
    font-weight: bold;
}

.new_products .new_prod_box a:hover {
    color: #0066cc;
}

/* Style for the product background in the new_products container */
.new_products .new_prod_bg {
    margin-top: 10px;
    position: relative; /* Ensure the image fits within the parent div */
}

/* Style for the product image in the new_products container */
.new_products .new_prod_bg img.thumb {
    max-width: 100%;
    max-height: 100%;
    height: auto; /* Maintain the aspect ratio */
    width: auto; /* Maintain the aspect ratio */
    object-fit: contain; /* Ensure the image scales correctly within its container */
}

/* Style for the pagination */
.pagination {
    margin-top: 20px;
    text-align: center;
}

.pagination span,
.pagination a {
    margin: 0 5px;
    padding: 5px 10px;
    border: 1px solid #ddd;
    border-radius: 3px;
    text-decoration: none;
}

.pagination .current {
    background-color: #0066cc;
    color: #fff;
}

.pagination a {
    color: #0066cc;
}

.pagination a:hover {
    background-color: #ddd;
}

 </style>   
       
<div class="center_content">
    <div class="left_content">
        <div class="crumb_nav">
            <a href="index.php">Home</a> &gt;&gt; All Books
        </div>
        <div class="title">
            <span class="title_icon"><img src="images/bullet1.gif" alt="" title="" /></span>All Category & Books
        </div>
        <div class="new_products">
            <?php
            $sql = "SELECT book_id, category_id, image_id, booktitle, categoryname FROM books";
            $result = mysqli_query($conn, $sql);
            
            if ($result && mysqli_num_rows($result) > 0) {
                $count = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($count % 3 == 0) {
                        echo '<div class="row">';
                    }
                    
                    $bookId = $row['book_id'];
                    $categoryId = $row['category_id'];
                    $imageId = $row['image_id'];
                    $bookTitle = $row['booktitle'];
                    $categoryName = $row['categoryname'];
                    
                    echo '
                    <div class="new_prod_box">
                        <a href="details.php?bid=' . $bookId . '">' . $bookTitle . '</a>
                        <div class="new_prod_bg">
                            <a href="details.php?bid=' . $bookId . '"><img src="images/book-cover/' . $imageId . '.png" alt="" title="" class="thumb" border="0" /></a>
                        </div>
                    </div>';
                    
                    $count++;
                    if ($count % 3 == 0) {
                        echo '</div>';
                    }
                }
                if ($count % 3 != 0) {
                    echo '</div>';
                }
            } else {
                echo "No books found.";
            }
            ?>
        </div>
        <div class="pagination">
            <span class="disabled"><<</span><span class="current">1</span><a href="#?page=2">2</a><a href="#?page=3">3</a>>><a href="#?page=199">10</a><a href="#?page=200">11</a><a href="#?page=2">>></a>
        </div>
    </div>
    <?php include('otherlikes.php');?>
    <div class="clear"></div>
</div>
<?php include ('footer.php');?>         
</body>
</html>
