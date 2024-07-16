<?php
/*
    Filename: total_budget-autofill.php
    Programmer: Lysha Silva
    Started: 
    Finished: 
    Description:
            - Code to fetch total_budget of a certain goal from the database
            - PARA SAN NGA 'TOOO?
            - Bakit ko nga ginawa 'to?

*/
$userId = $_SESSION['user_id'];

// Database connection
include('db.php');

// Query to fetch the total_budget
$sql = "SELECT total_budget FROM goal WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($total_budget);
$stmt->fetch();
$stmt->close();




// Check if department is fetched correctly
if (empty($total_budget)) {
    echo "total_budget-autofill.php : Department not found for user ID: $userId";
    exit;
}
?>
