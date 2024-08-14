<?php include('top.php'); ?>
<?php include('header.php'); 
       
    // Define the query to fetch data
    if (isset($_GET['bid'])) {
        $userId = $_SESSION['user_id'];  // Assuming the logged-in user has user_id = 1
        $bookId = intval($_GET['bid']); // Assuming the book_id is passed as a parameter in the URL
    
        // Define the query to fetch data
        $sql = "SELECT * FROM books WHERE book_id = $bookId";
        $result = mysqli_query($conn, $sql);

        // Check if query executed successfully
        if ($result) {
            // Check if any rows were returned
            if (mysqli_num_rows($result) > 0) {
                // Fetch the data and save it to a variable
                $row = mysqli_fetch_assoc($result);
                $booktitle = $row['booktitle'];
                $cat = $row['categoryname'];
                $img = $row['image_id'];
            } else {
                echo "No records found.";
            }
        }
    }
    ?>

    <div class="center_content">
        <div class="left_content">
            <div class="crumb_nav">
                <a href="index.php">Home</a> &gt;&gt; product name
            </div>
            <div class="title">
                <span class="title_icon">
                    <img src="images/smallimagecover/<?php echo $img ; ?>.png" alt="" title="" />
                </span> 
                <?php echo $booktitle ; ?>
            </div>
            <div class="feat_prod_box_details">
                <div class="prod_img">
                    <a href="">
                        <img src="images/book-cover/<?php echo $img;?>" alt="" title="" border="0" />
                    </a>
                    <br /><br />
                    <p>Book Category: <?php echo $cat ; ?></p>
                </div>
                <div class="prod_det_box">
                    <div class="box_top"></div>
                    <div class="box_center">
                        <form id="myForm">
                            <div class="prod_title">Book Title: <?php echo $booktitle ; ?></div>
                            <p class="details">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.<br />
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.
                            </p>
                            <div class="price"><strong>PRICE:</strong> <span class="red">100 $</span></div>
                            <input type="hidden" id="bookId" value="<?php echo $bookId; ?>" />
                            <input type="hidden" id="userId" value="<?php echo $userId; ?>" />
                            <button type="button" onclick="submitForm()" name="like" class="more">
                                <img src="images/likebtn.png" alt="" title="" border="0" />
                            </button>
                            <div id="result"></div>
                            <div class="clear"></div>
                        </form>
                    </div>
                    <div class="box_bottom"></div>
                </div>
                <div class="clear"></div>
            </div>    
        </div><!--end of left content-->
        
        <?php include('otherlikes.php');?>
       
        <div class="clear"></div>
    </div><!--end of center content-->
       
    <?php include ('footer.php');?>         

</div>

<script>
function submitForm() {
    var bookId = $('#bookId').val();
    var userId = $('#userId').val();

    console.log("bookId:", bookId, "userId:", userId); // Log form data

    $.ajax({
        url: 'submitlikes.php',
        type: 'POST',
        data: { bookId: bookId, userId: userId },
        success: function(response) {
            $('#result').html(response).addClass('success');
        },
        error: function() {
            $('#result').html('Error occurred').addClass('error');
        }
    });
}
</script>

</body>
</html>
