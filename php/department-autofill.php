<?php
/*
    Filename: department-autofill.php
    Programmer: Lysha Silva        
    Started: July 8, 2024; 8:30 AM
    Finished: July 8, 2024; 8:50 AM
    Updated: 
            July 8, 2024; 3:52 PM - Added the back end for the dynamic generation of title of Goals table
                                        according to the user's department
    Description: 
                - fetches the department of the user from the user table in the database
                - this code is used to autofill the Department input field in the Create New Goal Modal
                - also used to generate dynamic Goals table title

                - stores the current year to $current_year
                - used to autofill the Year input field in the Create New Goal Modal
*/
//session_start();
$userId = $_SESSION['user_id'];

// Database connection
include('db.php');

// Query to fetch the department
$sql = "SELECT department FROM user WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($department);
$stmt->fetch();
$stmt->close();

// Get current year
$current_year = date('Y');

//code to generate the dynamic title of Goals table in ManageGoals page
//$title = "<div class=\"page-title\">" . htmlspecialchars($department) . " Department Goals</div>";
$title = htmlspecialchars($department);

$sql2 = "SELECT first_name FROM user WHERE user_id = ?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("i", $userId);
$stmt2->execute();
$stmt2->bind_result($first_name);
$stmt2->fetch();
$stmt2->close();

$first_name = htmlspecialchars($first_name);


// Check if department is fetched correctly
if (empty($department)) {
    echo "department-autofill.php : Department not found for user ID: $userId";
    exit; // Exit or handle accordingly
}

if (empty($first_name)) {
    echo "department-autofill.php : First name not found for user ID: $userId";
    exit; // Exit or handle accordingly
}
?>
