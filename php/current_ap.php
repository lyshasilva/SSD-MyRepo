<?php



$user_id = $_SESSION['user_id'];

// Fetch the current year
$current_year = date('Y');

// Query to get the goals for the current year
$goal_query = $conn->prepare("SELECT id FROM goal WHERE user_id = ? AND year = ?");
$goal_query->bind_param("ii", $user_id, $current_year);
$goal_query->execute();
$goal_result = $goal_query->get_result();

$goal_ids = [];
while ($row = $goal_result->fetch_assoc()) {
    $goal_ids[] = $row['id'];
}

if (empty($goal_ids)) {
    echo "<tr><td colspan='5'>No action plans available for the current year.</td></tr>";
} else {
    // Prepare and execute the query to get action plans under the goals
    // Prepare and execute the query to get action plans and join with goals to get the goal title
    $goal_ids_placeholders = implode(',', array_fill(0, count($goal_ids), '?'));
    $ap_query = $conn->prepare("
        SELECT 
            action_plan.title, 
            action_plan.ap_description, 
            action_plan.budget, 
            goal.title AS goal_title 
        FROM action_plan
        JOIN goal ON action_plan.goal = goal.id
        WHERE goal.id IN ($goal_ids_placeholders)
    ");
    $ap_query->bind_param(str_repeat('i', count($goal_ids)), ...$goal_ids);
    $ap_query->execute();
    $ap_result = $ap_query->get_result();

    // Output the action plans in table rows
    $row_class = 'row-1';
    while ($row = $ap_result->fetch_assoc()) {
        echo "<tr class='$row_class'>";
        echo "<td>{$row['title']}</td>";
        echo "<td>{$row['ap_description']}</td>";
        echo "<td>{$row['budget']}</td>";
        echo "<td>{$row['goal_title']}</td>"; // Display the goal title
        echo "<td>
                <button class='edit-button'>Edit</button>
                <button class='archive-button'>Archive</button>
              </td>";
        echo "</tr>";

        // Toggle row class for alternating colors
        $row_class = ($row_class === 'row-1') ? 'row-2' : 'row-1';
    }
}

$goal_query->close();
$ap_query->close();
//$conn->close();
?>