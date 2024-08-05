<?php
/*
    Filename: edit_goal.php
    Programmer: Lysha Silva        
    Started: July 10, 2024; 11:03 AM
    Finished: July 8, 2024; 11:56 AM
    Updated: July 18, 2024; 2:29 PM by Amiel O. - upgraded the copy success alert message into a sweet alert message
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
    $target_value = mysqli_real_escape_string($conn, $_POST['target_value']);
    $initiative = mysqli_real_escape_string($conn, $_POST['initiative']);


    // Prepare update query
    $query = "UPDATE goal SET title = '$title', targets = '$targets', target_value = '$target_value', initiative = '$initiative' WHERE id = $goal_id";
if (mysqli_query($conn, $query)) {
    // Show SweetAlert confirmation
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Goal updated successfully.'
            }).then((result) => {
                if (result.isConfirmed || result.isDismissed) {
                    window.location.href = '../html/ManageGoals.php';
                }
            });
        });
    </script>";
} else {
    // Show SweetAlert error message
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Error updating goal: " . mysqli_error($conn) . "'
            }).then((result) => {
                if (result.isConfirmed || result.isDismissed) {
                    window.history.back();
                }
            });
        });
    </script>";
}
} else {
// Invalid request
echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Request!',
            text: 'Please try again.'
        }).then((result) => {
            if (result.isConfirmed || result.isDismissed) {
                window.history.back();
            }
        });
    });
</script>";
}

//mysqli_close($conn);
?>
