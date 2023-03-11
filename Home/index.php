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
    <title>Home</title>
</head>
<body id="feed-body">
    <?php

        // Set Identifier to determine which icon in selected in navbar
        $_SESSION["navbar-identifier"] = "Home";

        // Import Mobile Header
        if(isset($_SESSION["logged_in"])){
            require '../Navbars/Mobile/mobile-header-user.php'; 
        } else {
            require '../Navbars/Mobile/mobile-header-visitor.php'; 
        }
    ?>

    <?php
        // Import Desktop Navbar
        require '../Navbars/Desktop/visitor_vs_user.php';
    ?>

    <?php 

        if(isset($_SESSION["ids"])){
            unset($_SESSION["ids"]);
        }

        // Set Session for page

        $_SESSION["page"] = "../Home/";
        
        // Spremeni stvari na get 
        // Prepare data 

        require '../Assets/connection.php';

        $filter;
        $category;
        $location;

        if(isset($_GET["location"])){
            $location = $_GET["location"];
            if($location == ""){
                unset($location);
            }
       } 

        if(isset($_GET["category"])){
            $category = $_GET["category"];
        } else {
            $category = "all";
        }

        if(isset($_GET["filter"])){
            $filter = $_GET["filter"];
        } else {
            $filter = "DESC";
        }

        $get_posts_sql = "SELECT * FROM photos";
        $hasParameters = false;

        if($category != "all" && isset($location)){
            $get_posts_sql = $get_posts_sql . " WHERE Category = '$category' AND Photo_Location = '$location'";

            $_SESSION["page"] = $_SESSION["page"] . "?category=" . $category . "&location=" . $location;
            $hasParameters = true;

        } else if ($category == "all" && isset($location)){
            $get_posts_sql = $get_posts_sql . " WHERE Photo_Location = '$location'";

            $_SESSION["page"] = $_SESSION["page"] . "?location=" . $location;
            $hasParameters = true;

        } else if ($category != "all" && !isset($location)){
            $get_posts_sql = $get_posts_sql . " WHERE Category = '$category'";

            $_SESSION["page"] = $_SESSION["page"] . "?category=" . $category;

            $hasParameters = true;

        } else if($category == "all" && !isset($location)){
            $get_posts_sql = $get_posts_sql;

        }



        if($filter != "Views"){
            $get_posts_sql = $get_posts_sql . " ORDER BY Photo_ID $filter";
        } else {
            $get_posts_sql = $get_posts_sql . " ORDER BY $filter DESC";
        }

        if($hasParameters == true){
            $_SESSION["page"] = $_SESSION["page"] . "&filter=" . $filter;
        } else {
            $_SESSION["page"] = $_SESSION["page"] . "?filter=" . $filter;
        }

        /*
        echo $get_posts_sql; 
        die();
        */

        $db_response_get_posts = $mysql->query($get_posts_sql);
        $num_posts = mysqli_num_rows($db_response_get_posts);
    ?>
    <!-- Home Container -->

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="filters-section">
    
        <div class="live-search">
            <?php if(isset($location)): ?>
            <input type="text" placeholder="Search photos by location" id="search-bar" value="<?php echo $location; ?>" class="search-filter" name="location" autocomplete="off">
            <?php else: ?>
            <input type="text" placeholder="Search photos by location" id="search-bar" class="search-filter" name="location" autocomplete="off">
            <?php endif; ?>

            <div class="live-search-results">
                <div class="column"></div>
            </div>
        </div>
        
        <div class="select-filters">
            <select name="category" class="category-filter">
            <?php 
                $categories = array("all", "wildlife", "scientific", "landscape", "astro", "aerial", "travel", "macro", "food", "architecture", "underwater");

                // Check which of the available categories matches the chose one and set it on selected.

                for($i = 0; $i < count($categories); $i++){
                    if($category == $categories[$i]){
                        echo "<option value=".$categories[$i]." selected>".$categories[$i]."</option>";   
                    } else {
                        echo "<option value=".$categories[$i].">".$categories[$i]."</option>";   
                    }
                }

            ?>
            </select>
            <select name="filter" class="sorting-filter">
            <?php
                $filters = array("DESC", "ASC", "Views");
                $filters_screen_names = array("New", "Old", "Most Viewed");

                // Check which of the available filters matches the chose one and set it on selected.

                for($i = 0; $i < count($filters); $i++){
                    if($filter == $filters[$i]){
                        echo "<option value=".$filters[$i]." selected>".$filters_screen_names[$i]."</option>";   
                    } else {
                        echo "<option value=".$filters[$i].">".$filters_screen_names[$i]."</option>";   
                    }
                }
            ?>
            </select>
        </div>
        <button type="submit" class="submit-button">Submit</button>
    </form>
    
    <h2 class="results-count">Results: <?php echo $num_posts; ?></h2>
    
    <section class="feed">
        <?php
        
        $_SESSION["ids"] = array();
        $delay_counter = 0;
        // Loop through posts
            while($row = $db_response_get_posts->fetch_assoc()):
                array_push($_SESSION["ids"], $row["Photo_ID"]);
                $delay_counter += 100;
                if($delay_counter == 250){
                    $delay_counter = 0;
                }
        ?>
        
        <div class="post" data-aos="zoom-in" data-aos-delay="<?php echo $delay_counter; ?>" style="transition: 0.4s;" >
            <div class="upper-row">
                <a href="../Profile/?user=<?php echo $row["Username"]; ?>" class="text"><h3>@<?php echo $row["Username"]; ?></h3></a>
            </div>
            
            <div>
                <a href="../PhotoView?id=<?php echo $row["Photo_ID"]; ?>">
                    <img src="../Posts/<?php echo $row['Image_Name']; ?>" alt="<?php echo $row['Image_Name']; ?>" class="photo">
                </a>

                <div class="lower-row">
                    <i class="fa-solid fa-eye text"></i>
                    <h3 class="text"><?php echo $row["Views"]?></h3>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </section>
    
    <?php 
        if(isset($_SESSION["logged_in"])){
            require '../Modals/UploadPhotoModal/upload_photo_modal.php';
        }
        

    ?>

    <script>
        AOS.init();
    </script>

    <script src="../JavaScript/upload-file.js"></script>
    <script src="../JavaScript/search.js"></script>
</body>
</html>