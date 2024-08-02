<?php
/*
    Filename: verify.php
    Programmer: Lysha Silva
    Started: July 1, 2024; 11:12 AM
    Finished: July 2, 2024; 8:47 AM
    Description:
                - program to verify a user if it is registered in the database
            
*/

// Include database connection details
include('db.php');


// Get user input from the login form
$username = $_POST['username'];
$password = $_POST['password'];

// SQL query to check if the provided credentials are valid
$sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
$result = $conn->query($sql);

// Check if the query returned a matching user
if ($result === false) {
    die("Query failed: " . $conn->error);
}

if ($result->num_rows > 0) {
    // Valid credentials, fetch user details
    $user = $result->fetch_assoc();
    $user_id = $user['user_id'];
	
	 // Set session variables
    session_start();    
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $user_id;

    
    
   
    // Redirect to the home page
    header("Location: ../html/LandingPage.php");
}
else {
    // Invalid credentials, display error message in a dialog box
    echo '<script>';
    echo 'alert("Wrong username or password. Please try again.");';
    echo 'window.location.href = "../html/LoginPage.html";';
    echo '</script>';
    exit();
}




// Close the database connection
$conn->close();
?>
