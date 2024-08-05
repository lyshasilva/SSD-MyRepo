<?php
/*
Filename: archive_ap.php
Programmer: Lysha Silva
Started: July 30, 2024
Description: ARCHIVE FEATURE
            - Back end of ARCHIVE button which sets the archived column of an action plan to 1.
            - The archived data won't be erased from the database
*/

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $actionPlanId = $_POST['id']; // Get action plan ID from POST request

    if (isset($actionPlanId) && is_numeric($actionPlanId)) {
        $sql = "UPDATE action_plan SET archived = 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $actionPlanId);

        // Execute the statement and check for success
        if ($stmt->execute()) {
            // Send a success response back to the AJAX request
            echo json_encode(['status' => 'success', 'message' => "Action plan has been successfully archived."]);
        } else {
            // Send an error response back to the AJAX request
            echo json_encode(['status' => 'error', 'message' => $stmt->error]);
        }

        $stmt->close();
    } else {
        // Send an error response for invalid ID
        echo json_encode(['status' => 'error', 'message' => 'Invalid action plan ID.']);
    }

    $conn->close();
}
?>

