<?php

    require '../Assets/connection.php';
    $username = $_POST["username"];

    $sql = "SELECT * FROM users WHERE Username LIKE '$username%'";
    $result = $mysql->query($sql);

    $_SESSION["search-query"] = $username;

    while($row = $result->fetch_assoc()):
?>
<a href="../Profile/?user=<?php echo $row["Username"]; ?>">
    <div class="user">
        <i class="fa-solid fa-user"></i>
        <h2><?php echo $row["Username"]; ?></h2>
    </div>
</a>

<?php endwhile; ?>