
<?php

/*

    Filename: get_goal_details.php
    Programmer: Lysha Silva
    Started: July 10, 2024; 8:14 AM
    Finished: July 10, 2024; 8:20 AM
    Description: EDIT FEATURE
                -fetches the details of a goal from the database

    Remarks: It has the same logic as the php code, view_goal.php.
            -The back end code of the EDIT FEATURE to fetch goal details is already 
                implemented in the view_goal.php. Therefore, this file can be safely deleted

*/
//include('db.php');

if (isset($_GET['id'])) {
    $goal_id = intval($_GET['id']);
    $query = "SELECT * FROM goal WHERE id = $goal_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $goal = mysqli_fetch_assoc($result);
        echo json_encode($goal);
    } else {
        echo json_encode(['error' => 'Goal not found.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request.']);
}


//mysqli_close($conn);
?>
