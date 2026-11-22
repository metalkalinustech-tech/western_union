<?php
$server = 'localhost';
$username = 'root';
$password = '';

$conn = mysqli_connect($server, $username, $password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}else{
  //  echo "Connected successfully";
}


$db_create = mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS western_union");

if (!$db_create) {
    die("Database creation failed: " . mysqli_error($conn));
} else {
    //echo "Database created successfully";
}   

$dbname = 'western_union';
mysqli_select_db($conn, $dbname);

$db_create= mysqli_query($conn, "CREATE TABLE IF NOT EXISTS wu_users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    passwords VARCHAR(100) NOT NULL,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

if (!$db_create) {
    die("Table creation failed: " . mysqli_error($conn));   
}else{
   // echo "Table created successfully";
}


$profiile_create= mysqli_query($conn, "CREATE TABLE IF NOT EXISTS user_profile (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(250) NOT NULL,
    profile_picture VARCHAR(255) DEFAULT 'default.jpg',
    region VARCHAR(100) DEFAULT 'Unknown',
    states VARCHAR(100) DEFAULT 'Unknown',
    city VARCHAR(100) DEFAULT 'Unknown',
    country VARCHAR(100) DEFAULT 'Unknown'
        )   ");



if (!$profiile_create) {
    die("Profile table creation failed: " . mysqli_error($conn));   
}else{
   // echo "Profile table created successfully";
}


$tb_history_create= mysqli_query($conn, "CREATE TABLE IF NOT EXISTS transaction_history (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(222) NOT NULL,
    sender_name VARCHAR(300) NOT NULL,
    transaction_type VARCHAR(50) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    t_status VARCHAR(50) NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )   ");
?>