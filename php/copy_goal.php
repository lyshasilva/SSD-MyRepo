<?php
/*
Filename: copy_goal.php
Programmer: Lysha Silva
Started: July 11, 2024; 1:15 PM
Finished: July 11, 2024; 1:23 PM
Description: COPY FEATURE
            -Back end of COPY button which lets the user copy a goal from the previous goals to the current goals.
            -It copies all of the goal's details EXCEPT for the YEAR which will be automatically set to the 
                current year and for the goal ID.
*/


include('db.php');
include('anti-shortcut_ssd.php');
//session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['goal_id'])) {
    // Retrieve goal_id from POST data
    $goal_id = intval($_POST['goal_id']);

    // Retrieve user_id from session
    $user_id = $_SESSION['user_id'];

    // Fetch existing goal details from database
    $query = "SELECT * FROM goal WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $goal_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $goal = $result->fetch_assoc();

        // Insert new goal with copied details
        $copy_query = "INSERT INTO goal (title, initiative, targets, total_budget, department, year, user_id)
                       VALUES (?, ?, ?, ?, ?, ?, ?)";
        $current_year = date('Y');
        $stmt_copy = $conn->prepare($copy_query);
        $stmt_copy->bind_param("sssssii", $goal['title'], $goal['initiative'], $goal['targets'], $goal['total_budget'], $goal['department'], $current_year, $user_id);
        $stmt_copy->execute();
/*
        if ($stmt_copy->affected_rows > 0) {
            echo json_encode(['success' => 'Goal copied successfully.']);
        } else {
            echo json_encode(['error' => 'Error copying goal.']);
        }
        $stmt_copy->close();
        */
        if ($stmt_copy->affected_rows > 0) {
            echo "<script>alert('Goal copied successfully.'); window.location.href = '../html/ManageGoals.php';</script>";
        } else {
            echo "<script>alert('Error copying goal.'); window.location.href = '../html/ManageGoals.php';</script>";
        }
        $stmt_copy->close();
        
    } else {
        echo json_encode(['error' => 'Goal not found.']);
    }
    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid request.']);
}

mysqli_close($conn);
?>
