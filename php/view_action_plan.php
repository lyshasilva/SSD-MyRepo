<?php
/*
    Filename: view_action_plan.php
    Programmer: Lysha Silca
    Started: July 23, 2024; 9:00 AM
    Finished: July 23, 2024; 10:00 AM
    Description: VIEW FEATURE
                - Backend for VIEW button which lets the user view the details of an action plan
                - Fetches the details of an action plan from the database
                - Also used in the EDIT feature to fetch the action plan details then make them editable
*/

include('db.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT * FROM action_plan WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $actionPlan = $result->fetch_assoc();
        echo json_encode($actionPlan);
    } else {
        echo json_encode(['error' => 'Action plan not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

//$conn->close();
?>
