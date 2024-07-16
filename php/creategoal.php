<?php
/*

    Filename: creategoal.php
    Programmer: Prinz Juancho Magallamento
    Started: July 4, 2024; 8:51 AM
    Finished: July 4, 2024; 9:43 AM
    Description: CREATE NEW GOAL FEATURE
                - Back end of the SAVE GOAL button from CREATE NEW GOAL modal
                - Adds a new row in the goal table in the database, contents are 
                    according to the user input
*/
session_start();

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $year = $_POST['year'];
    $department = $_POST['department'];
    $targets = $_POST['targets'];
    $total_budget = $_POST['totalBudget'];
    $initiative = $_POST['initiative'];
     
    // Check if user_id is set in session
    if (!isset($_SESSION['user_id'])) {
        die("User ID not set in session.");
    }
    $user_id = $_SESSION['user_id']; // 'user_id' is stored in the session

    $sql = "INSERT INTO goal (title, year, department, targets, total_budget, initiative, user_id)
            VALUES ('$title', '$year', '$department', '$targets', '$total_budget', '$initiative', '$user_id')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New goal created successfully'); window.location.href = '../html/ManageGoals.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
