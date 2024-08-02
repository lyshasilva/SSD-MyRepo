<?php
session_start();
require 'db.php'; // Include your database connection file

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action_plan_id = $_POST['action_plan_id'];
    $title = $_POST['title'];
    $ap_description = $_POST['edit_ap_description'];
    $budget = $_POST['budget'];
    $new_goal_id = $_POST['goal']; // New goal selected in the form

     // Fetch the old budget and associated goal_id
     $select_query = $conn->prepare("
     SELECT budget, goal 
     FROM action_plan 
     WHERE id = ? AND user_id = ?
 ");

    $select_query->bind_param('ii', $action_plan_id, $user_id);
    $select_query->execute();
    $select_query->bind_result($old_budget, $old_goal_id);
    $select_query->fetch();
    $select_query->close();



    // Update budgets if the goal has changed
    if ($old_goal_id != $new_goal_id) {
        // Subtract the old budget from the old goal's total_budget
        $update_old_goal_query = $conn->prepare("
            UPDATE goal 
            SET total_budget = total_budget - ? 
            WHERE id = ? AND user_id = ?
        ");
        $update_old_goal_query->bind_param('dii', $old_budget, $old_goal_id, $user_id);
        if (!$update_old_goal_query->execute()) {
            echo "Error updating old goal budget: " . $conn->error;
            exit();
        }
        $update_old_goal_query->close();

        // Add the new budget to the new goal's total_budget
        $update_new_goal_query = $conn->prepare("
            UPDATE goal 
            SET total_budget = total_budget + ? 
            WHERE id = ? AND user_id = ?
        ");
        $update_new_goal_query->bind_param('dii', $budget, $new_goal_id, $user_id);
        if (!$update_new_goal_query->execute()) {
            echo "Error updating new goal budget: " . $conn->error;
            exit();
        }
        $update_new_goal_query->close();
    } else {
        // Goal hasn't changed, just update the budget on the same goal
        // Subtract the old budget and add the new budget to the goal's total_budget
        $update_goal_query = $conn->prepare("
            UPDATE goal 
            SET total_budget = total_budget - ? + ? 
            WHERE id = ? AND user_id = ?
        ");
        if (!$update_goal_query) {
            die('Prepare failed: ' . $conn->error);
        }
        $update_goal_query->bind_param('ddii', $old_budget, $budget, $old_goal_id, $user_id);
        if (!$update_goal_query->execute()) {
            die('Execute failed: ' . $update_goal_query->error);
        }
        $update_goal_query->close();
    }


    // Update the action plan in the database
    $update_query = $conn->prepare("
        UPDATE action_plan 
        SET title = ?, ap_description = ?, budget = ?, goal = ? 
        WHERE id = ? AND user_id = ?
    ");


 $update_query->bind_param('ssdiii', $title, $ap_description, $budget, $new_goal_id, $action_plan_id, $user_id);


 if (!$update_query->execute()) {
    echo "Error updating goal budget: " . $conn->error;
    exit();
}

    // Update the action plan in the database
    $update_query = $conn->prepare("
        UPDATE action_plan 
        SET title = ?, ap_description = ?, budget = ? 
        WHERE id = ? AND user_id = ?
    ");
    $update_query->bind_param('ssdii', $title, $ap_description, $budget, $action_plan_id, $user_id);

    if ($update_query->execute()) {
        // Redirect back to the page or display success message
        //header('Location: ../html/ManageActionPlans.php');
        echo "Action plan updated ";
        exit();
    } else {
        echo "Error updating action plan: " . $conn->error;
    }

    $update_query->close();
}

$conn->close();
?>
