<?php
include('db.php');

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture user inputs from the form
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $goal = $_POST['goal'] ?? '';
    $department = $_POST['department'] ?? '';
    $budget = $_POST['budget'] ?? '';
    
    // Validate inputs if needed (e.g., check if required fields are empty)
    if (empty($title) || empty($description) || empty($goal) || empty($department) || empty($budget)) {
        echo json_encode(['error' => 'All fields are required.']);
        exit;
    }

    // Prepare the query to insert the new action plan
    $copy_query = "INSERT INTO action_plan (title, ap_description, goal, department, budget)
                   VALUES (?, ?, ?, ?, ?)";
    $stmt_copy = $conn->prepare($copy_query);
    if ($stmt_copy === false) {
        echo json_encode(['error' => 'Error preparing the copy statement: ' . $conn->error]);
        exit;
    }
    $stmt_copy->bind_param("sssis", $title, $description, $goal, $department, $budget);
    $stmt_copy->execute();

    if ($stmt_copy->affected_rows > 0) {
        echo json_encode(['success' => 'Action Plan copied successfully.']);
    } else {
        echo json_encode(['error' => 'Error copying action plan: ' . $stmt_copy->error]);
    }
    $stmt_copy->close();
} else {
    echo json_encode(['error' => 'Invalid request.']);
}

mysqli_close($conn);
?>
