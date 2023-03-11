<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <?php require '../Assets/links.php'; ?>
    <title>Document</title>
</head>
<body>
    <?php

        // Import Mobile Header
        if(isset($_SESSION["logged_in"])){
            require '../Navbars/Mobile/mobile-header-user.php'; 
        } else {
            require '../Navbars/Mobile/mobile-header-visitor.php'; 
        }

        // Import Desktop Navbar
        require '../Navbars/Desktop/visitor_vs_user.php';
        

        include '../Assets/connection.php';
        $id = $_GET["id"];
        $_SESSION["photo_active"] = $id;

        $get_photo_data_sql = "SELECT * FROM photos WHERE Photo_ID = '$id'";

        $get_photo_data_result = $mysql->query($get_photo_data_sql);
        $photo_data = $get_photo_data_result->fetch_assoc();

        // Update Views

        $num_views = $photo_data["Views"];
        $num_views++;
        $update_views_sql = "UPDATE photos SET Views = '$num_views' WHERE Photo_ID = '$id'";

        $mysql->query($update_views_sql);

        // Next and previous IDs

        $posts_ids = $_SESSION["ids"];
        $posts_ids_num = count($_SESSION["ids"]);
        $current_id_index = array_search($id, $posts_ids);

        if($posts_ids_num != 1){
            if($current_id_index == 0){

                $previous_id = $posts_ids[count($posts_ids) - 1];
                $next_id = $posts_ids[$current_id_index + 1];
    
            } else if ($current_id_index == count($posts_ids) - 1){
    
                $previous_id = $posts_ids[$current_id_index - 1];
                $next_id = $posts_ids[0];
    
            } else {
                $previous_id = $posts_ids[$current_id_index - 1];
                $next_id = $posts_ids[$current_id_index + 1];
            }
        }

    ?>
    
    <section class="photo-viewer">
        <div class="photo-slideshow">

            <?php if($posts_ids_num != 1): ?>
            <a href="../PhotoView/?id= <?php echo $previous_id; ?>" class="left chevron"><i class="fa-solid fa-chevron-left"></i></a>
            <?php endif; ?>

            <img src="../Posts/<?php echo $photo_data["Image_Name"]; ?>" class="photo">

            <?php if($posts_ids_num != 1): ?>
            <a href="../PhotoView/?id= <?php echo $next_id; ?>" class="right chevron"><i class="fa-solid fa-chevron-right"></i></a>
            <?php endif; ?>

        </div>
        <div class="photo-controls">
            <a href="<?php echo $_SESSION["page"]; ?>"><i class="fa-solid fa-arrow-left"></i></a>
            <a href="../Posts/<?php echo $photo_data["Image_Name"]; ?>"  download class="download-image"><i class="fa-solid fa-download"></i></a>
            <p class="counter"><?php echo $current_id_index + 1; ?> / <?php echo $posts_ids_num; ?></p>
            <p style="visibility:hidden;" id="image_id"><?php echo $id; ?></p>
        </div>
    </section>

    <!-- SMALL SCREEN COMPONENTS -->
    
    <?php if($posts_ids_num != 1): ?>
    <div class="gallery-navigation-mobile">
        <a href="../PhotoView/?id= <?php echo $previous_id; ?>" class="left chevron"><i class="fa-solid fa-chevron-left"></i></a>
        <a href="../PhotoView/?id= <?php echo $next_id; ?>" class="right chevron"><i class="fa-solid fa-chevron-right"></i></a>
    </div>
    <?php endif; ?>

    <div class="photo-controls-mobile">
        <div class="mobile-control-cell">
            <a href="<?php echo $_SESSION["page"]; ?>"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
        <div class="mobile-control-cell">
            <a href="../Posts/<?php echo $photo_data["Image_Name"]; ?>" download class="download-image"><i class="fa-solid fa-download"></i></a>
        </div>
        <div class="mobile-control-cell">
            <p class="counter"><?php echo $current_id_index + 1; ?> / <?php echo $posts_ids_num; ?></p>
        </div>
    
    </div>

    <!-- END -->

    <section class="photo-data-container">
        <div class="item">
            <h1 class="title">Author</h1>
            <a href="../Profile/?user=<?php echo $photo_data["Username"]; ?>"><div class="content">@<?php echo $photo_data["Username"];?></div></a>
        </div>
        <div class="item">
            <h1 class="title">Posted</h1>
            <div class="content"><?php echo $photo_data["Photo_Posted"];?></div>
        </div>
        <div class="item">
            <h1 class="title">Location</h1>
            <div class="content"><?php echo $photo_data["Photo_Location"];?></div>
        </div>
        <div class="item">
            <h1 class="title">Views</h1>
            <div class="content"><?php echo $photo_data["Views"];?></div>
        </div>
        <div class="item">
            <h1 class="title">Downloads</h1>
            <div class="content downloads_number"><?php echo $photo_data["Downloads"];?></div>
        </div>
        <div class="item">
            <h1 class="title">Software</h1>
            <div class="content"><?php echo $photo_data["Editing_Software"];?></div>
        </div>
        <div class="item">
            <h1 class="title">Height</h1>
            <div class="content"><?php echo $photo_data["Image_Height"];?>px</div>
        </div>
        <div class="item">
            <h1 class="title">Width</h1>
            <div class="content"><?php echo $photo_data["Image_Width"];?>px</div>
        </div>
        <div class="item">
            <h1 class="title">Category</h1>
            <div class="content"><?php echo $photo_data["Category"];?></div>
        </div>
    </section>

    <div class="comment-section">

        <form action="post-comment.php" method="post" class="comment-form">
            <textarea name="comment" rows="1" cols="50" placeholder="Type comment..." required></textarea>
            <button type="submit">Submit</button>
        </form>

        <div class="comments-container">
            <?php
                $get_comments_sql = "SELECT * FROM comments WHERE Photo_ID = $id";

                $comments = $mysql->query($get_comments_sql);
                $num_comments = mysqli_num_rows($comments);

                if($num_comments == 0){
                    echo "<div class='no-comments'>";
                        echo "<p>No comments yet.</p>";
                    echo "</div>";
                }
            ?>


            <?php
                while($row = $comments->fetch_assoc()):
            ?>
                    <div class="comment">
                        <div class="comment-upper-line">
                            <h2 class="comment-author"><?php echo $row['User_commented']; ?></h2>
                            <?php if($row["User_commented"] == $_SESSION["logged_in"]): ?>
                                <a href="delete-comment.php?comment_id=<?php echo $row["Comment_ID"]; ?>"><i class="fa-solid fa-trash"></i></a>
                            <?php endif; ?>
                        </div>
                        <h3 class="comment-time"><?php echo $row['Comment_Posted']; ?></h3>
                        <p class="comment-content"><?php echo $row['Comment']; ?></p>
                    </div>

            <?php endwhile; ?>


        </div>

    </div>
    <?php 
        // Import Mobile Navbar - Choose Between USER and VISITOR variants 
        if(isset($_SESSION["logged_in"])){
            require '../Modals/UploadPhotoModal/upload_photo_modal.php';
        } 

    ?>
    <script src="../JavaScript/upload-file.js"></script>
    <script src="../JavaScript/comments.js"></script>
    <script src="../JavaScript/update-downloads.js"></script>
    <script src="../JavaScript/scaleImage.js"></script>
</body>
</html>