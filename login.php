<?php
session_start();

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['log_btn'])) {
    require_once 'db_config.php';

    $email = mysqli_real_escape_string($conn, $_POST['l_Email']);
    $password = mysqli_real_escape_string($conn, $_POST['l_Password']);

    $query = "SELECT * FROM wu_users WHERE email='$email' AND passwords='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['user_email'] = $email;
        $_SESSION['user_password'] = $password;
        $_SESSION['userid'] =  mysqli_fetch_assoc($result)['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        header("Location: error.html");
    }
    mysqli_close($conn);

}
    ?>