<?php
    if(isset($_SESSION["logged_in"])){
        include 'navbar-user.php'; 
    } else {
        include 'navbar-visitor.php';
    }
?>