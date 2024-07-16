<?php
/*
    Filename: edit_goal.php
    Programmer: Lysha Silva        
    Started: July 10, 2024; 11:03 AM
    Finished: July 8, 2024; 11:56 AM
    Description: EDIT FEATURE
                 - Back End of the SAVE CHANGES button
                 - Updates the contents of the selected goal from the goal table in the database
                    with the user input data             
*/

include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $goal_id = intval($_POST['goal_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $targets = mysqli_real_escape_string($conn, $_POST['targets']);
    $initiative = mysqli_real_escape_string($conn, $_POST['initiative']);


    // Prepare update query
    $query = "UPDATE goal SET title = '$title', targets = '$targets', initiative = '$initiative' WHERE id = $goal_id";

    if (mysqli_query($conn, $query)) {
        //echo json_encode(['success' => 'Goal updated successfully.']);
        echo "<script>
        alert('Goal updated successfully.');
        window.location.href = '../html/ManageGoals.php'; // Redirect to the ManageGoals page
    </script>";
    } else {
        //echo json_encode(['error' => 'Error updating goal: ' . mysqli_error($conn)]);
        "<script>
            alert('Error updating goal: " . mysqli_error($conn) . "');
            window.history.back(); // Redirects the user back to the previous page
        </script>";
    }
} else {
    echo json_encode(['error' => 'Invalid request.']);
}

mysqli_close($conn);
?>
