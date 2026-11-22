<?php
session_start();
if($_SESSION['user_email'] == "" || $_SESSION['user_password'] == "") {
    header("Location: index.html");
    exit();
}
$user_id = $_SESSION['user_email'];

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['save_btn'])) { 
    require_once 'db_config.php';

    $region = mysqli_real_escape_string($conn, $_POST['region']);
    $states = mysqli_real_escape_string($conn, $_POST['state']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
}

// Handle file upload
$file = $_FILES['picture']['name'];
$upload_dir = 'profile/'; // Directory to store uploaded files  
$extension = pathinfo($file, PATHINFO_EXTENSION);

$allowed_ext =array("jpg", "jpeg", "png", "gif");

if (!in_array($extension, $allowed_ext)) {
    echo "<div>Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.</div>";
    exit();
}

if(move_uploaded_file($_FILES['picture']['tmp_name'], $upload_dir . $file)) {
    $profile_picture_path = $upload_dir . $file; // Store the path to the uploaded file
} else {
    echo "<div>Error uploading file.</div>";
    exit();
}

    // Insert or update user profile in the database
    $query_profile = "INSERT INTO user_profile (user_id, profile_picture, region, states, city, country) 
                      VALUES ('$user_id', '$profile_picture_path', '$region', '$states', '$city', '$country')
                      ON DUPLICATE KEY UPDATE 
                      profile_picture='$profile_picture_path', region='$region', states='$states', city='$city', country='$country'";

    if (mysqli_query($conn, $query_profile)) {
        header("Location:update-success.php");
    } else {
        echo "<div>Error updating profile: " . mysqli_error($conn) . "</div>";
    }



?>