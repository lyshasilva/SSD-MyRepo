<?php
/* 
    Filename: previous_ap.php
    Programmer: Lysha Silva
    Started: July 22, 2024; 5:35 PM
    Finished: 
    Description: 
*/



$user_id = $_SESSION['user_id'];

// Fetch the current year
$current_year = date('Y');

// Query to get the goals for the current year
$goal_query = $conn->prepare("SELECT id FROM goal WHERE user_id = ? AND year < ? AND archived IS NULL");
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
    // Prepare and execute the query to get action plans and join with goals to get the goal title
    $goal_ids_placeholders = implode(',', array_fill(0, count($goal_ids), '?'));
    $ap_query = $conn->prepare("
        SELECT
            action_plan.id,        
            action_plan.title, 
            action_plan.ap_description, 
            action_plan.budget, 
            goal.title AS goal_title 
        FROM action_plan
        JOIN goal ON action_plan.goal = goal.id
        WHERE goal.id IN ($goal_ids_placeholders)
        AND action_plan.archived is NULL
        ORDER BY action_plan.id DESC;
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
                <button class='view-action-plan-button' data-action-plan-id='{$row['id']}'>View</button>
                <form class='copy-form' style='display:inline'>
                    <input type='hidden' name='action_plan_id' value='{$row['id']}'>
                    <button type='button' class='copy-action-plan-button' onclick='copyActionPlan(this.form)'>Copy</button>
                </form>
                <button class='archive-action-plan-button'
                                data-action-plan-id='". $row['id']. "'
                                data-action-plan-title='". $row['title']."'>Archive</button>
              </td>";
        echo "</tr>";

        // Toggle row class for alternating colors
        $row_class = ($row_class === 'row-1') ? 'row-2' : 'row-1';
    }
}

//$goal_query->close();
//$ap_query->close();
//$conn->close();

?>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Get the modal
    var modal = document.getElementById("copyAPModal");

    // Get the close button and close functionality
    var span = document.getElementsByClassName("close")[0];
    
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Handle the goal selection and update details
    document.getElementById("goal").onchange = function() {
        var selectedValue = this.value;
        var textDetails = document.getElementById("textDetails");
        textDetails.textContent = "Details for " + selectedValue;
    }
    
    function copyActionPlan(form) {

        var actionPlanId = form.querySelector('input[name="action_plan_id"]').value;
        // First, show the Swal confirmation dialog
        Swal.fire({
            title: 'Choose an Option',
            text: 'Would you like to create a new goal or choose from the existing ones?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Create New Goal',
            cancelButtonText: 'Choose Existing Goal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // If user chooses to create a new goal
                window.location.href = '../html/ManageGoals.php';  // Adjust the URL as necessary
            } else if (result.isDismissed) {
                // If user chooses to select an existing goal, show the modal
                modal.style.display = "block";
                fetchCopyActionPlanDetails(actionPlanId); 
                
                // Optionally, you might want to populate or reset the modal content here
                // For example, you can load relevant content dynamically if needed
            }
        });
    }
</script>



<script>
    function fetchCopyActionPlanDetails(actionPlanId) {
    console.log('Fetching action plan details for ID:', actionPlanId); // Log actionPlanId

    fetch(`../php/view_action_plan.php?id=${actionPlanId}`)
        .then(response => {
            console.log('Response received:', response); // Log the response object
            return response.json();
        })
        .then(data => {
            console.log('Fetched data:', data); // Log the data received

            if (data.error) {
                console.error('Error from server:', data.error); // Log the error
                alert(data.error);
            } else {
                console.log('Data is valid, populating modal'); // Log before populating the modal
                populateCopyActionPlanModal(data);
                copyAPModal.style.display = "block";
            }
        })
        .catch(error => console.error('Error fetching action plan details:', error));
}


    function populateCopyActionPlanModal(actionPlan) {
        
        console.log('populateCopyPlanModal function');
        console.log(`id= ${actionPlan.id}`);
        console.log(`title= ${actionPlan.title}`);
        console.log(`description= ${actionPlan.ap_description}`);

        // Check that the elements are correctly selected
    let idElement = document.getElementById("action_plan_id");
    let titleElement = document.getElementById("title");
    let descriptionElement = document.getElementById("description");
    let budgetElement = document.getElementById("budget");

    console.log('ID Element:', idElement);
    console.log('Title Element:', titleElement);
    console.log('Description Element:', descriptionElement);
    console.log('Budget Element:', budgetElement);

    if (idElement && titleElement && descriptionElement && budgetElement) {
        idElement.value = actionPlan.id || '';
        titleElement.value = actionPlan.title || '';
        descriptionElement.value = actionPlan.ap_description || '';
        budgetElement.value = actionPlan.budget || '';
    } else {
        console.error('One or more elements were not found');
    }

        document.getElementById("action_plan_id").value = actionPlan.id;
       document.getElementById("ap_title").value = actionPlan.title;
        document.getElementById("ap_description").value = actionPlan.ap_description;
        document.getElementById("ap_budget").value = actionPlan.budget;
        //   The goal dropdown is left unpopulated as per the requirements
    }
    /*
    // Get the modal
    var modal = document.getElementById("copyAPModal");

    // Get the close button and close functionality
    var span = document.getElementsByClassName("close")[0];
    
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Handle the goal selection and update details
    document.getElementById("goal").onchange = function() {
        var selectedValue = this.value;
        var textDetails = document.getElementById("textDetails");
        textDetails.textContent = "Details for " + selectedValue;
    }
    
    function copyActionPlan(form) {
        // First, show the Swal confirmation dialog
        Swal.fire({
            title: 'Choose an Option',
            text: 'Would you like to create a new goal or choose from the existing ones?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Create New Goal',
            cancelButtonText: 'Choose Existing Goal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // If user chooses to create a new goal
                window.location.href = 'create_goal.php';  // Adjust the URL as necessary
            } else if (result.isDismissed) {
                // If user chooses to select an existing goal, show the modal
                modal.style.display = "block";
                
                // Optionally, you might want to populate or reset the modal content here
                // For example, you can load relevant content dynamically if needed
            }
        });
    }*/
</script>