<?php
/*

    Filename: view_goal.php
    Programmer: Prinz Juancho Magallamento
    Started: July 9, 2024; 8:18 AM
    Finished: July 9, 2024; 10:18 AM
    Description: VIEW FEATURE
                - Back end of VIEW button which lets the user view the details of the previous goals
                -fetches the details of a goal from the database
                -also used in the EDIT feature to fetch the goal details then make them editable
*/

include('../php/db.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT * FROM goal WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $goal = $result->fetch_assoc();
        echo json_encode($goal);
    } else {
        echo json_encode(['error' => 'Goal not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

//$conn->close();
?>
