<?php
session_start();
// Destroy the session and redirect to the login page
session_destroy();

sleep(1); // Optional: Add a slight delay to ensure session is destroyed before redirecting
header("Location: index.html");


?>