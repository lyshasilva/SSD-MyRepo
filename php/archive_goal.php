<?php
/*
Filename: archive_goal.php
Programmer: Lysha Silva
Started: July 4, 2024; 4:12 PM
Finished: July 5, 2024; 9:06 AM
Updated: July 19, 2024; 8:02 AM by Prinz J M. - Changed the alert message to json response
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

    // Execute the statement and check for success
    if ($stmt->execute()) {
        // Send a success response back to the AJAX request
        echo json_encode(['status' => 'success', 'message' => "Goal $goalTitle has been successfully archived."]);
    } else {
        // Send an error response back to the AJAX request
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
