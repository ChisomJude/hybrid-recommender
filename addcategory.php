<?php include('top.php'); ?>
<?php include('header.php'); ?>

<?php
// Initialize variables
$categoryName = $message = '';
$action = '';

// Handle form submission for adding, deleting, or editing categories
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == "add" && isset($_POST['categoryName'])) {
        $categoryName = mysqli_real_escape_string($conn, $_POST['categoryName']);
        
        // Check if categoryname already exists
        $checkSql = "SELECT * FROM bookcategory WHERE categoryname='$categoryName'";
        $checkResult = mysqli_query($conn, $checkSql);

        if ($checkResult && mysqli_num_rows($checkResult) > 0) {
            $message = "Category already exists.";
        } else {
            // Generate a random category_id and ensure it does not already exist
            do {
                $categoryId = rand(1, 100);
                $checkIdSql = "SELECT * FROM bookcategory WHERE category_id='$categoryId'";
                $checkIdResult = mysqli_query($conn, $checkIdSql);
            } while ($checkIdResult && mysqli_num_rows($checkIdResult) > 0);

            // Insert new category
            $insertSql = "INSERT INTO bookcategory (category_id, categoryname) VALUES ('$categoryId', '$categoryName')";
            if (mysqli_query($conn, $insertSql)) {
                $message = "Category added successfully!";
            } else {
                $message = "Error adding category: " . mysqli_error($conn);
            }
        }
    } elseif ($action == "delete" && isset($_POST['categoryId'])) {
        $categoryId = mysqli_real_escape_string($conn, $_POST['categoryId']);

        // Check if the category is attached to any book
        $checkBookSql = "SELECT * FROM books WHERE category_id='$categoryId'";
        $checkBookResult = mysqli_query($conn, $checkBookSql);

        if ($checkBookResult && mysqli_num_rows($checkBookResult) > 0) {
            $message = "Cannot delete category; it is attached to existing books. Consider editing the category name instead.";
        } else {
            // Delete the selected category
            $deleteSql = "DELETE FROM bookcategory WHERE category_id='$categoryId'";
            if (mysqli_query($conn, $deleteSql)) {
                $message = "Category deleted successfully!";
            } else {
                $message = "Error deleting category: " . mysqli_error($conn);
            }
        }
    } elseif ($action == "edit" && isset($_POST['categoryId']) && isset($_POST['newCategoryName'])) {
        $categoryId = mysqli_real_escape_string($conn, $_POST['categoryId']);
        $newCategoryName = mysqli_real_escape_string($conn, $_POST['newCategoryName']);

        // Update the category name in both bookcategory and books tables
        $updateCategorySql = "UPDATE bookcategory SET categoryname='$newCategoryName' WHERE category_id='$categoryId'";
        $updateBooksSql = "UPDATE books SET categoryname='$newCategoryName' WHERE category_id='$categoryId'";

        if (mysqli_query($conn, $updateCategorySql) && mysqli_query($conn, $updateBooksSql)) {
            $message = "Category name updated successfully!";
        } else {
            $message = "Error updating category name: " . mysqli_error($conn);
        }
    }
}
?>

<style>
/* Style the form */
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
            <span class="title_icon"><img src="images/bullet1.gif" alt="" title="" /></span>Delete or Add Category
        </div>
        
        <div class="category-form">
            <h2>Select Action</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="action">What would you like to do?</label>
                <select id="action" name="action" onchange="this.form.submit()" required>
                    <option value="">-- Select an action --</option>
                    <option value="add" <?php if ($action == "add") echo 'selected'; ?>>Add Category</option>
                    <option value="delete" <?php if ($action == "delete") echo 'selected'; ?>>Delete Category</option>
                    <option value="edit" <?php if ($action == "edit") echo 'selected'; ?>>Edit Category Name</option>
                </select>
            </form>
            
            <?php if ($action == "add"): ?>
                <h2>Add Category</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="action" value="add">
                    <label for="categoryName">Enter New Category Name:</label>
                    <input type="text" id="categoryName" name="categoryName" required>
                    <input type="submit" value="Add Category">
                </form>
            <?php elseif ($action == "delete"): ?>
                <h2>Delete Category</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="action" value="delete">
                    <label for="categoryId">Select Category to Delete:</label>
                    <select id="categoryId" name="categoryId" required>
                        <?php
                        // Fetch categories from bookcategory table
                        $categorySql = "SELECT category_id, categoryname FROM bookcategory";
                        $categoryResult = mysqli_query($conn, $categorySql);

                        if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
                            while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
                                echo '<option value="' . $categoryRow['category_id'] . '">' . $categoryRow['categoryname'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <input type="submit" value="Delete Category">
                </form>
            <?php elseif ($action == "edit"): ?>
                <h2>Edit Category Name</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="action" value="edit">
                    <label for="categoryId">Select Category to Edit:</label>
                    <select id="categoryId" name="categoryId" required>
                        <?php
                        // Fetch categories from bookcategory table
                        $categorySql = "SELECT category_id, categoryname FROM bookcategory";
                        $categoryResult = mysqli_query($conn, $categorySql);

                        if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
                            while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
                                echo '<option value="' . $categoryRow['category_id'] . '">' . $categoryRow['categoryname'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <label for="newCategoryName">Enter New Category Name:</label>
                    <input type="text" id="newCategoryName" name="newCategoryName" required>
                    <input type="submit" value="Update Category">
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
