<?php
// createap.php
include 'anti-shortcut_ssd.php';
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $goal = $_POST['goal'];
    $description = $_POST['description'];
    $department = $_POST['department'];
    $budget = $_POST['budget'];
    
    // Sanitize inputs
    $title = htmlspecialchars($title);
    $goal = htmlspecialchars($goal);
    $description = htmlspecialchars($description);
    $department = htmlspecialchars($department);
    $budget = htmlspecialchars($budget);
    
    // Validate inputs
    if (empty($title) || empty($goal) || empty($description) || empty($department) || empty($budget)) {
        echo "All fields are required.";
        exit;
    }

     // Check if user_id is set in session
     if (!isset($_SESSION['user_id'])) {
        die("User ID not set in session.");
    }

    $user_id = $_SESSION['user_id']; // 'user_id' is stored in the session

    // Start transaction
    $conn->begin_transaction();

    // Insert into the database
    //$stmt = $conn->prepare("INSERT INTO action_plan (title, goal, ap_description, department, budget, user_id) VALUES (?, ?, ?, ?, ?, ?)");
    //$stmt->bind_param("ssssdi", $title, $goal, $description, $department, $budget, $user_id);
    try {
        // Insert into the database
        $stmt = $conn->prepare("INSERT INTO action_plan (title, goal, ap_description, department, budget, user_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sissdi", $title, $goal, $description, $department, $budget, $user_id);
        
        if ($stmt->execute()) {
            // Fetch the current total_budget from the goal table
            $stmt = $conn->prepare("SELECT total_budget FROM goal WHERE id = ?");
            $stmt->bind_param("i", $goal);
            $stmt->execute();
            $stmt->bind_result($current_total_budget);
            $stmt->fetch();
            $stmt->close();

            // Add the inputted budget to the current total_budget
            $new_total_budget = $current_total_budget + $budget;

            // Update the total_budget in the goal table
            $stmt = $conn->prepare("UPDATE goal SET total_budget = ? WHERE id = ?");
            $stmt->bind_param("di", $new_total_budget, $goal);
            $stmt->execute();
            $stmt->close();

            // Commit transaction
            $conn->commit();

            echo "<script>alert('Action Plan created successfully.'); window.location.href='../html/ManageActionPlans.php'</script>";
            exit;
        } else {
            throw new Exception("Error: " . $stmt->error);
        }
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollback();
        echo $e->getMessage();
    }

    $conn->close();
}
/*
    if ($stmt->execute()) {
        echo "<script>alert('Action Plan created successfully.'); window.location.href='../html/ManageActionPlans.html'</script>";
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
    */
?>
