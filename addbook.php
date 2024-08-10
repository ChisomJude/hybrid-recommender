<?php include('top.php'); ?>
<?php include('header.php'); ?>

<?php
// Initialize variables
$bookTitle = $categoryId = $categoryName = $bookCategoryAge = $bookCategoryCity = $message = '';
$formVisible = true;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookTitle = mysqli_real_escape_string($conn, $_POST['bookTitle']);
    $categoryId = mysqli_real_escape_string($conn, $_POST['categoryId']);
    $bookCategoryAge = mysqli_real_escape_string($conn, $_POST['bookCategoryAge']);
    $bookCategoryCity = mysqli_real_escape_string($conn, $_POST['bookCategoryCity']);

    // Retrieve the categoryname from the bookcategory table
    $categorySql = "SELECT categoryname FROM bookcategory WHERE category_id='$categoryId'";
    $categoryResult = mysqli_query($conn, $categorySql);
    if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
        $categoryRow = mysqli_fetch_assoc($categoryResult);
        $categoryName = $categoryRow['categoryname'];

        // Handle file upload
        if (isset($_FILES['bookCover']) && $_FILES['bookCover']['error'] == 0) {
            $targetDir = "images/book-cover/";
            $imageId = basename($_FILES["bookCover"]["name"]);
            $targetFilePath = $targetDir . $imageId;
            $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

            // Check if the file is an image
            $check = getimagesize($_FILES["bookCover"]["tmp_name"]);
            if ($check !== false) {
                // Allow certain file formats
                $allowedTypes = array("jpg", "jpeg", "png");
                if (in_array($fileType, $allowedTypes)) {
                    // Check if the file name already exists in the database
                    $fileCheckSql = "SELECT image_id FROM books WHERE image_id='$imageId'";
                    $fileCheckResult = mysqli_query($conn, $fileCheckSql);

                    if (mysqli_num_rows($fileCheckResult) > 0) {
                        // If file name exists, rename it by adding a random string
                        $randomString = uniqid();
                        $imageId = $randomString . "_" . $imageId;
                        $targetFilePath = $targetDir . $imageId;
                    }

                    // Resize the image
                    if (resizeImage($_FILES["bookCover"]["tmp_name"], $targetFilePath, 100, 150, $fileType)) {
                        // Insert the new book with image, category_id, and categoryname
                        $bookInsertSql = "INSERT INTO books (category_id, categoryname, booktitle, book_category_age, book_category_city, image_id) 
                                          VALUES ('$categoryId', '$categoryName', '$bookTitle', '$bookCategoryAge', '$bookCategoryCity', '$imageId')";
                        if (mysqli_query($conn, $bookInsertSql)) {
                            $message = "<div class='add_success'>Book added successfully!</div>";
                            $formVisible = false;
                        } else {
                            $message = "<div class='add_success'>Error adding book: " . mysqli_error($conn) . "</div>";
                        }
                    } else {
                        $message = "<div class='add_success'>Sorry, there was an error resizing your image.</div>";
                    }
                } else {
                    $message = "<div class='add_success'>Sorry, only JPG, JPEG, and PNG files are allowed.</div>";
                }
            } else {
                $message = "<div class='add_success'>File is not an image.</div>";
            }
        } else {
            $message = "<div class='add_success'>Please select an image file to upload.</div>";
        }
    } else {
        $message = "<div class='add_success'>Invalid category selected.</div>";
    }
}

// Resize image function
function resizeImage($sourcePath, $targetPath, $width, $height, $fileType) {
    // Create a new image from file
    if ($fileType == 'jpg' || $fileType == 'jpeg') {
        $srcImg = imagecreatefromjpeg($sourcePath);
    } elseif ($fileType == 'png') {
        $srcImg = imagecreatefrompng($sourcePath);
    } else {
        return false;
    }

    $srcWidth = imagesx($srcImg);
    $srcHeight = imagesy($srcImg);
    $dstImg = imagecreatetruecolor($width, $height);

    // Resize image
    imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);

    // Save the resized image
    if ($fileType == 'jpg' || $fileType == 'jpeg') {
        imagejpeg($dstImg, $targetPath);
    } elseif ($fileType == 'png') {
        imagepng($dstImg, $targetPath);
    }

    // Free up memory
    imagedestroy($srcImg);
    imagedestroy($dstImg);

    return true;
}
?>

<style>
/* Style the form */
.add_success {
    margin-top: 50px;
    font-size: 16px;
    color: #555;
}

.add-book-form {
    width: 300px;
    margin: 0 auto;
}

.add-book-form h2 {
    text-align: center;
}

.add-book-form label {
    display: block;
    margin: 10px 0 5px;
}

.add-book-form input[type="text"],
.add-book-form select,
.add-book-form input[type="file"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
}

.add-book-form input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

.add-book-form input[type="submit"]:hover {
    background-color: #45a049;
}

.success-message {
    text-align: center;
}
</style>

<div class="center_content">
    <div class="left_content">
        <div class="title">
            <span class="title_icon"><img src="images/bullet1.gif" alt="" title="" /></span>Add New Book
        </div>
        
        <?php if ($formVisible): ?>
        <div class="add-book-form">
            <h2>Add New Book</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <label for="bookTitle">Book Title:</label>
                <input type="text" id="bookTitle" name="bookTitle" required>

                <label for="categoryId">Category:</label>
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

                <label for="bookCategoryAge">Book Category Age:</label>
                <select id="bookCategoryAge" name="bookCategoryAge" required>
                    <option value="Kids">Kids</option>
                    <option value="Teenage">Teenage</option>
                    <option value="Adult">Adult</option>
                </select>

                <label for="bookCategoryCity">Book Category City:</label>
                <input type="text" id="bookCategoryCity" name="bookCategoryCity" required>

                <label for="bookCover">Book Cover Image:</label>
                <input type="file" id="bookCover" name="bookCover" required>

                <input type="submit" value="Add Book">
            </form>
        </div>
        <?php else: ?>
        <div class="success-message">
            <p><?php echo $message; ?></p>
            <a href="addbook.php">Add More Books</a>
        </div>
        <?php endif; ?>
    </div>
    <div class="clear"></div>
</div>

<?php include('footer.php'); ?>
</body>
</html>
