<?php
$user_id = "";
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reg_btn'])) {
    require_once 'db_config.php';
    
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);
    $user_id = $email;
    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }
      
    // Hash the password before storing it
   //hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $insertQuery = "INSERT INTO wu_users (full_name, email, phone, passwords) VALUES ('$name', '$email', '$phone', '$password')";

    if (mysqli_query($conn, $insertQuery)) {
        $history = $conn->query("INSERT INTO transaction_history(user_id,sender_name,transaction_type,amount,t_status) VALUES('$user_id','Western Union Welcome bonus','Credit','250','Successfully')");
        
        header("Location: welcome.html");

    } else {
        echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

    };
?>