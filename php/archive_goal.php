<?php
/*
Filename: archive_goal.php
Programmer: Lysha Silva
Started: July 4, 2024; 4:12 PM
Finished: July 5, 2024; 9:06 AM
Description: ARCHIVE FEATURE
            -Back end of ARCHIVE button which removes a goal from the user's display
            -The archived data won't be erased from the database

*/

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $goalId = $_POST['goal_id'];
    $goalTitle = $_POST['goal_title'];
    $sql = "UPDATE goal SET archived = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $goalId);

    // Debugging print to check if goal_id is received
    echo "Received goal_id: " . htmlspecialchars($goalId);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        echo "<script>alert('Goal " . $goalTitle . " has been successfully archived.');";
        echo "window.location.href = '../html/ManageGoals.php';</script>";
            exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
