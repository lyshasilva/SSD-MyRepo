<?php
/*
Filename: anti-shortcut_ssd.php
Programmer: Lysha Silva
Started: Recycled code from DSS project
Description: ANTI-SHORTCUT AND LOG OUT FEATURES
            - Prevents a user from accessing a page from the system without logging in
            - includes the back end logic for LOG OUT button
*/

// Start the session
session_start();


// Check if the user is logged in
if (!isset($_SESSION['logged_in'])) {
    // User is not logged in, redirect to login page
    header("Location: ../html/LogInPage.html");
    exit();
}

// Logout logic
if (isset($_POST['logout'])) {
    // Unset all session variables
    $_SESSION = array();


    // Destroy the session
    session_destroy();

    // Redirect to login page
    header("Location: ../html/LogInPage.html");
    exit();
}
?>