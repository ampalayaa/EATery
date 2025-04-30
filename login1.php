<?php 
    session_start();
    if ($_POST["username"] == "admin" && $_POST["password"] == "123") {
        $_SESSION["loggedin"] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid Credentials');</script>";
    }

?>