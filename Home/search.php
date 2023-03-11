<?php
    require '../Assets/connection.php';

    $text = $_POST["text"];

    $get_locations_sql = "SELECT DISTINCT Photo_Location FROM photos WHERE Photo_Location LIKE '$text%'";

    $result = $mysql->query($get_locations_sql);

    $num_results = mysqli_num_rows($result);

    if($num_results == 1){
        $final_result = $result->fetch_assoc()['Photo_Location'];
    ?>
    <div class="search-result"><?php echo $final_result; ?> </div>
    
    <?php
     } else { 
        while($row = $result->fetch_assoc()):
            $item = $row["Photo_Location"];
    ?>
    <div class="search-result"><?php echo $row["Photo_Location"]; ?> </div>

<?php endwhile; } ?>