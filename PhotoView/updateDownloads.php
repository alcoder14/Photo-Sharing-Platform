<?php 

    require '../Assets/connection.php';
    $id = $_POST["number"];

    $get_downloads_num_sql = "SELECT Downloads FROM photos WHERE Photo_ID = $id";

    $result = $mysql->query($get_downloads_num_sql);
    $result = $result->fetch_assoc()["Downloads"];

    $result++;

    echo $result;

    $insert_downloads_num = "UPDATE photos SET Downloads = $result WHERE Photo_ID = $id";

    $mysql->query($insert_downloads_num);

    $mysql->close();
    
?>