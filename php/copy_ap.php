<?php
/*
Filename: copy_ap.php
Programmer: Lysha Silva
Started: August 12, 2024
Description: COPY FEATURE
            - Back end of COPY button which lets the user copy an action plan.
            - It copies all details of the action plan and updates the corresponding goal's budget.
*/

include('db.php');
include('anti-shortcut_ssd.php');
include('department-autofill.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture user inputs from the form
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $goal = $_POST['goal'] ?? '';
    $budget = $_POST['budget'] ?? '';
    $department = $_POST['department'] ?? ''; // Ensure department is captured
    $user_id = $_SESSION['user_id'];
    
    // Validate inputs if needed
    if (empty($title) || empty($description) || empty($goal) || empty($department) || empty($budget)) {
        $message = 'All fields are required.';
        $status = 'error';
    } else {
        // Prepare the query to insert the new action plan
        $copy_query = "INSERT INTO action_plan (title, ap_description, goal, department, budget, user_id)
                       VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_copy = $conn->prepare($copy_query);
        if ($stmt_copy === false) {
            $message = 'Error preparing the copy statement: ' . $conn->error;
            $status = 'error';
        } else {
            $stmt_copy->bind_param("ssisii", $title, $description, $goal, $department, $budget, $user_id);
            $stmt_copy->execute();

            if ($stmt_copy->affected_rows > 0) {
                // Prepare and execute the query to update the goal's total budget
                $update_goal_query = $conn->prepare("
                    UPDATE goal 
                    SET total_budget = total_budget + ? 
                    WHERE id = ? AND user_id = ?
                ");
                if ($update_goal_query === false) {
                    $message = 'Error preparing the update goal statement: ' . $conn->error;
                    $status = 'error';
                } else {
                    $update_goal_query->bind_param("iii", $budget, $goal, $user_id);
                    $update_goal_query->execute();

                    if ($update_goal_query->affected_rows > 0) {
                        $message = 'Action Plan copied and goal updated successfully.';
                        $status = 'success';
                    } else {
                        $message = 'Error updating goal budget: ' . $update_goal_query->error;
                        $status = 'error';
                    }
                    $update_goal_query->close();
                }
            } else {
                $message = 'Error copying action plan: ' . $stmt_copy->error;
                $status = 'error';
            }
            $stmt_copy->close();
        }
    }
} else {
    $message = 'Invalid request.';
    $status = 'error';
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Copy Action Plan Result</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: '<?php echo $status; ?>',
        title: '<?php echo $status == "success" ? "Success!" : "Error!"; ?>',
        text: '<?php echo $message; ?>'
    }).then(() => {
        if ('<?php echo $status; ?>' === 'success') {
            window.location.href = '../html/ManageActionPlans.php'; // Redirect to the desired page
        } else {
            window.history.back(); // Go back to the previous page
        }
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
