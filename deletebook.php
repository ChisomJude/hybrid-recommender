<?php
include('top.php');
include('header.php');

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteBook'])) {
    $bookId = $_POST['bookId'];
    
    // Get book details for confirmation message
    $sql = "SELECT * FROM books WHERE book_id = $bookId";
    $result = mysqli_query($conn, $sql);
    $book = mysqli_fetch_assoc($result);

    if ($book) {
        // Confirm deletion
        $message = "<h3>Are you sure you want to delete the following book?</h3>";
        $message .= "<p><strong>Book Title:</strong> " . $book['booktitle'] . "</p>";
        $message .= "<p><strong>Category:</strong> " . $book['categoryname'] . "</p>";
        $message .= "<form method='POST' action='deletebook.php'>";
        $message .= "<input type='hidden' name='confirmDelete' value='" . $bookId . "'>";
        $message .= "<input type='submit' name='confirmDeleteBtn' value='Yes, Delete' class='btn'>";
        $message .= "<a href='deletebook.php' class='btn'>Cancel</a>";
        $message .= "</form>";
    } else {
        $message = "Book not found.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmDeleteBtn'])) {
    $bookId = $_POST['confirmDelete'];

    // Get book details to find the image file path
    $sql = "SELECT image_id FROM books WHERE book_id = $bookId";
    $result = mysqli_query($conn, $sql);
    $book = mysqli_fetch_assoc($result);

    if ($book) {
        $imageId = $book['image_id'];
        $imagePath = "images/book-cover/" . $imageId;

        // Delete the book
        $deleteBookSql = "DELETE FROM books WHERE book_id = $bookId";
        if (mysqli_query($conn, $deleteBookSql)) {
            // Delete the book cover image if it exists
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $message = "<p>Book and cover image deleted successfully.</p>";
        } else {
            $message = "<p>Error deleting book: " . mysqli_error($conn) . "</p>";
        }
    } else {
        $message = "Book not found.";
    }
}
?>

<style>
/* The existing CSS styles from your other form page */
.category-form {
    width: 300px;
    margin: 0 auto;
}

.category-form h2 {
    text-align: center;
}

.category-form label {
    display: block;
    margin: 10px 0 5px;
}

.category-form input[type="text"],
.category-form select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
}

.category-form input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

.category-form input[type="submit"]:hover {
    background-color: #45a049;
}

.success-message {
    text-align: center;
}

.bold-links {
    text-align: center;
    margin-top: 20px;
}

.bold-links a {
    font-weight: bold;
    color: #0066cc;
    text-decoration: none;
}

.bold-links a:hover {
    text-decoration: underline;
}
</style>

<div class="center_content">
    <div class="left_content">
        <div class="title">
            <span class="title_icon"><img src="images/bullet1.gif" alt="" title="" /></span>Delete Book
        </div>
        
        <div class="category-form">
            <h2>Select Book to Delete</h2>
            <form method="POST" action="deletebook.php">
                <label for="category">Select Category:</label>
                <select id="category" name="categoryId" onchange="this.form.submit()">
                    <option value="">Select a Category</option>
                    <?php
                    $sql = "SELECT category_id, categoryname FROM bookcategory";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $selected = ($_POST['categoryId'] == $row['category_id']) ? "selected" : "";
                        echo "<option value='" . $row['category_id'] . "' $selected>" . $row['categoryname'] . "</option>";
                    }
                    ?>
                </select>
            </form>

            <?php if (isset($_POST['categoryId']) && !empty($_POST['categoryId'])): ?>
                <form method="POST" action="deletebook.php">
                    <label for="book">Select Book:</label>
                    <select id="book" name="bookId">
                        <option value="">Select a Book</option>
                        <?php
                        $categoryId = $_POST['categoryId'];
                        $sql = "SELECT book_id, booktitle FROM books WHERE category_id = $categoryId";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['book_id'] . "'>" . $row['booktitle'] . "</option>";
                        }
                        ?>
                    </select>
                    <input type="submit" name="deleteBook" value="Delete Book" class="btn">
                </form>
            <?php endif; ?>
        </div>

        <div class="success-message">
            <p><?php echo $message; ?></p>
        </div>
        
        <div class="bold-links">
            <a href="addbook.php">Add Books</a>
            <br>
            <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">Reset</a>
        </div>
    </div>
    <div class="clear"></div>
</div>

<?php include('footer.php'); ?>
</body>
</html>
