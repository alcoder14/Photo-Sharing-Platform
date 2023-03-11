<?php   

    session_start();

    // Unset sessions if they exist
    if(isset($_SESSION["error"])){
        unset($_SESSION["error"]);
    }

    if(isset($_SESSION["logged_in"])){
        header("location: ../Home");
        die();
    }

    // Check if all fields are full 

    require '../Assets/connection.php';

    $keys = array("firstname", "lastname", "username", "email", "password", "repeat-password");

    for($i = 0; $i < count($keys); $i++){
        if($_POST[$keys[$i]] == ""){
            $_SESSION["error"] = "Some fields are empty";
            //echo $_SESSION["error"];
            header("location: ../signup");
            die();
        }
    }

    // Collect data
    
    $firstname = mysqli_real_escape_string($mysql, $_POST["firstname"]);
    $lastname = mysqli_real_escape_string($mysql, $_POST["lastname"]);

    $username = mysqli_real_escape_string($mysql, $_POST["username"]);
    $email = mysqli_real_escape_string($mysql, $_POST["email"]);

    $password = mysqli_real_escape_string($mysql, $_POST["password"]);
    $repeat_password = mysqli_real_escape_string($mysql, $_POST["repeat-password"]);
    
    // Get number of rows for username and email

    $check_username = "SELECT username FROM users WHERE Username = '$username'";
    $db_response_username = $mysql->query($check_username);
    $num_rows_username = mysqli_num_rows($db_response_username);

    $check_email = "SELECT email FROM users WHERE Email = '$email'";
    $db_response_email = $mysql->query($check_email);
    $num_rows_email = mysqli_num_rows($db_response_email);


    $allow_signup = false;
    $email_username_ok = false;
    $msg = "";

    // Validate email and username

    if($num_rows_username > 0){
        $msg = "This username already exists.";
    } else if($num_rows_email > 0){
        $msg = "This email is already taken. ";
    } else if(($num_rows_username > 0) && ($num_rows_email > 0)){
        $msg = "This email and username are already taken.";
    } else {
        $email_username_ok = true;
    }

    if($email_username_ok == false){
        $_SESSION["error"] = $msg;
        header("location: ../signup");
        die();
    }

    // Check if passwords are the same

    $password_ok = false;

    if($password == $repeat_password){
        $password_ok = true;
    } else {
        $msg = "Passwords are not the same";
        $_SESSION["error"] = $msg;
        header("location: ../signup");
        die();
    }

    // Insert data into the table  

    if($password_ok == true && $email_username_ok){

        $encrypted_password = password_hash($password, PASSWORD_DEFAULT);

        $add_user_sql = "INSERT INTO users (First_Name, Last_Name, Email, Username, Password) VALUES ('$firstname', '$lastname', '$email', '$username', '$encrypted_password')";

        $mysql->query($add_user_sql);

        $mysql->close();

        
        $_SESSION["logged_in"] = $username;
        header("location: ../Home");
        
    }

?>