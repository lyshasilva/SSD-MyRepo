<!--Date: July 4, 2024 - 10:50am start
    Edited: July 15, 2024 - 8:58am
    Update: July 22, 2024; 9:48 AM by Back End Team (BET)  -

    Description: Front-end of the Manage Action Plans Page for the Project
    Comments of the Developer:  /* Adjust as needed but maintain interface */
                                No modals yet for edit, view, copy, archive -->
    <?php 
        include('../php/db.php');
        include('../php/anti-shortcut_ssd.php');
        include('../php/department-autofill.php');
        //include('../php/total_budget-autofill.php');
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage Action Plans</title>
        <link rel="stylesheet" href="../css/manage_ap.css">
        
    </head>
    <body>
        <header>
            <div class="header">
            <button class="pagebuttons" onclick="location.href='ManageGoals.php'">Manage Goals</button>
            <button class="thispagebuttons" onclick="location.href='ManageActionPlans.php'">Manage AP</button>
            <button class="pagebuttons" onclick="location.href='ViewReports.php'">View Reports</button>
                <form method="post" class="logout">
                    <button type="submit" name="logout" class="logout">Logout</button>
                </form>
            </div>
        </header>
    
        <!-- Dynamic AP Title based on the User's Department -->
        <!-- Back End Logic is written in ../php/department-autofill.php -->
        <div class="ap-title"><?php echo $title ; ?> Action Plans</div>
      
    
        <table>
            <tr>
                <td colspan="5" class="medium-style">
                    <form method="GET" action="ManageActionPlans.php" style="display: inline-block"; >
                        <div style="width: 150%; display: flex; flex-direction: row;">
                            <input type="text" name="search" id="searchInput" class="input-bar" placeholder="Search..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <div style = "position: relative;">        
                                <button type="button" id="clearSearch" 
                                    style="position: absolute; left: 5px; top: 8px; width: 26px; display: 
                                    <?php echo isset($_GET['search']) && $_GET['search'] != '' ? 'inline' : 'none'; ?>;">
                                                    &#10005;
                                </button>
                            </div>
                            <button type="submit" class="search-button" style="margin-left: 45px">Search</button>
                        </div>
                    </form>
                    <button class="create-button" id="createAPBtn">Create New AP</button>
                </td>
            </tr>
            <tr>
                <td colspan="5" class="medium-style"></td>
            </tr>
            <tr>
                <th class="medium-style">Current APs</th>
                <th class="medium-style">Description</th>
                <th class="medium-style">Budget</th>
                <th class="medium-style">Goal</th>
                <th class="medium-style">Actions</th>
            </tr>

            <!-- dynamic rows -->
            <?php include '../php/current_ap.php'; ?>
            
        </table>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const clearSearch = document.getElementById('clearSearch');

            // Show or hide the "X" button based on input value
            function toggleClearButton() {
                if (searchInput.value.length > 0) {
                    clearSearch.style.display = 'inline';
                } else {
                    clearSearch.style.display = 'none';
                }
            }

            // Event listener to handle clearing the search
            clearSearch.addEventListener('click', function() {
                searchInput.value = '';
                toggleClearButton();
                window.location.href = 'ManageActionPlans.php';
            });

            // Initial check for displaying the "X" button
            toggleClearButton();

            // Update "X" button visibility when input changes
            searchInput.addEventListener('input', toggleClearButton);
        });
    </script>
    
        <!-- The Modal -->
        <div id="createAPModal" class="modal" style="display: none";>
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>CREATE ACTION PLAN</h2>
                <form action="../php/create_ap.php" method="post" class="create-ap">
                    <label for= "title" class="modal-label">Title:</label>
                    <input type="text" id="title" name="title" class="form-input-1" required>
                    <br>
                    <label for= "description" class="modal-label">Description:</label>
                    <br>
                    <textarea id="description" name="description" class="description" required></textarea>          
                    <br>
                    <label for= "goal" class="modal-label">Goal:</label>
                    <select id="goal" name="goal" class="form-select" required>
                        <option value="" disabled selected> SELECT Goal</option>
                        <?php
                        // Get the logged-in user's ID
                            $user_id = $_SESSION['user_id'];
                            $current_year = date('Y');

                            // Prepare and execute the query to fetch the user's goals
                            $stmt = $conn->prepare("SELECT id, title, targets, initiative FROM goal WHERE user_id = ? and archived IS NULL and year = ?");
                            $stmt->bind_param("ii", $user_id, $current_year);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Check if any goals were found and populate the dropdown
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['id'] . '" data-initiative="' . htmlspecialchars($row['initiative']) . '" data-target="' . htmlspecialchars($row['targets']) . '">' . htmlspecialchars($row['title']) . '</option>';
                                }
                            } else {
                                echo '<option value="" disabled>No goals found</option>';
                            }
                            ?>
                    </select>
                    <br>
                    <div class="text-details" id="textDetails">Goal details will appear here.</div>
                    <br>
                   
                    <!--<p class="text-fields">Budget</p>-->
            
                    <label for= "department" class="modal-label">Department:</label>
                    <input type="text" id="department" name="department" class="form-input-readonly" placeholder="Department" value="<?php echo htmlspecialchars($department); ?>" readonly required>
                    <br>
                    <label for= "budget" class="modal-label">Budget:</label>
                    <input type="text" id="budget" name="budget" class="form-input-2c" required>
                    <br>
                        <!-- Placeholder for Goal selections -->
                    </select>
                    
                    <div class="save-button-container">
                        <button type="submit" class="create-button">Save AP</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
           document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById("createAPModal");
    var btn = document.getElementById("createAPBtn");
    var span = document.getElementsByClassName("close")[0];

    // Ensure modal and button exist
    if (modal && btn) {
        console.log("createAPModal and createAPBtn are present.");
        
        btn.onclick = function() {
            if (modal) {
                modal.style.display = "block";
                console.log("Create AP modal displayed.");
            } else {
                console.error("Modal element not found when clicking the button.");
            }
        }

        // Close the modal when the user clicks on <span> (x)
        if (span) {
            span.onclick = function() {
                if (modal) {
                    modal.style.display = "none";
                    console.log("Create AP modal hidden.");
                } else {
                    console.error("Modal element not found when closing.");
                }
            }
        } else {
            console.error("Close button not found.");
        }

        // Close the modal when the user clicks anywhere outside of it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
                console.log("Modal hidden by clicking outside.");
            }
        }
    } else {
        console.error("createAPModal or createAPBtn is not present.");
    }

    // Handle goal selection
    var goalElement = document.getElementById("goal");
    if (goalElement) {
        goalElement.onchange = function() {
            var selectedOption = this.options[this.selectedIndex];
            var initiative = selectedOption.getAttribute('data-initiative');
            var target = selectedOption.getAttribute('data-target');
            var textDetails = document.getElementById("textDetails");
            if (textDetails) {
                textDetails.textContent = "Initiative: " + initiative + " | Target: " + target;
            }
        
        }
    } else {
        console.error("Goal select element not found.");
    }
});

        </script>

        <!-- Archive AP Confirmation Modal-->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Attach the confirmArchive function to buttons with the class 'archive-action-plan-button'
    $('.archive-action-plan-button').on('click', function(event) {
        event.preventDefault(); // Prevent default button behavior
        
        const actionPlanId = $(this).data('action-plan-id');
        const actionPlanTitle = $(this).data('action-plan-title');

        Swal.fire({
            title: 'Confirm Archiving',
            text: `Are you sure you want to archive this action plan titled '${actionPlanTitle}'?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Perform the AJAX request
                $.ajax({
                    url: '../php/archive_ap.php',
                    method: 'POST',
                    data: {
                        id: actionPlanId,
                        title: actionPlanTitle
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Archived!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload(); // Optional: Reload the page
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'There was an error archiving the action plan.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });
});
</script>



        <!-- Copy Action Plan Modal -->
         
<div id="copyAPModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>COPY ACTION PLAN</h2>
        <form id="copyActionPlanForm" action="../php/copy_ap.php" method="post" class="copyAP-form">
            <!-- Hidden field to store action plan ID -->
            <input type="hidden" id="action_plan_id" name="action_plan_id">
            <label for="ap_title" class="modal-label">Title: </label>
            <input type="text" id="ap_title" name="title" class="form-input-readonly" placeholder="Title" required>
            <br>
            <label for="ap_description" class="modal-label">Description: </label>
            <br>
            <textarea id="ap_description" name="description" class="description-readonly" placeholder="Description" required readonly></textarea>
            <br>
            <label for="ap_goal" class="modal-label">Goal: </label>
            <select id="ap_goal" name="goal" class="form-select" required>
                <option value="" disabled selected>Goal</option>
                <?php
                // Fetch goals for the current year or other necessary data
                $user_id = $_SESSION['user_id'];
                $current_year = date('Y');

                // Prepare and execute the query to fetch the user's goals
                $stmt = $conn->prepare("SELECT id, title, targets, initiative FROM goal WHERE user_id = ? AND archived IS NULL AND year = ?");
                $stmt->bind_param("ii", $user_id, $current_year);
                $stmt->execute();
                $result = $stmt->get_result();

                // Check if any goals were found and populate the dropdown
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '" data-ap-initiative="' . htmlspecialchars($row['initiative']) . '" data-ap-target="' . htmlspecialchars($row['targets']) . '">' . htmlspecialchars($row['title']) . '</option>';
                    }
                } else {
                    echo '<option value="" disabled>No goals found</option>';
                }
                ?>
            </select>
            
            <div class="text-details" id="apTextDetails">Goal details will appear here.</div>
            <br>
            <label for="department"class="modal-label">Department: </label>
            <input type="text" id="department" name="department" class="form-input-readonly" placeholder="Department" value="<?php echo htmlspecialchars($department); ?>" readonly required>
            <br>
            <label for="ap_budget"class="modal-label">Budget: </label>
            <input type="text" id="ap_budget" name="budget" class="form-input-readonly" placeholder="ex: 2000" required>
            <br>
            <!-- Placeholder for additional fields -->
            
            <div class="save-button-container">
                <button type="submit" class="create-button">Save AP</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var copyActionPlanModal = document.getElementById("copyAPModal");
    var copyActionPlanSpan = copyActionPlanModal.getElementsByClassName("close")[0];

    // Close the modal when the user clicks on <span> (x)
    copyActionPlanSpan.onclick = function() {
        copyActionPlanModal.style.display = "none";
    }

    // Close the modal when the user clicks anywhere outside of it
    window.onclick = function(event) {
        if (event.target == copyActionPlanModal) {
            copyActionPlanModal.style.display = "none";
        }
    }
    // Handle goal selection
    var goalElement = document.getElementById("ap_goal");
    if (goalElement) {
        console.log("Goal element found.");
        goalElement.onchange = function() {
            var selectedOption = this.options[this.selectedIndex];
            var initiative = selectedOption.getAttribute('data-ap-initiative');
            var target = selectedOption.getAttribute('data-ap-target');
            var textDetails = document.getElementById("apTextDetails");

             // Debugging: log values to the console
            console.log("Selected Option Value: ", selectedOption.value);
            console.log("Initiative: ", initiative);
            console.log("Target: ", target);

            if (textDetails) {
                textDetails.textContent = "Initiative: " + initiative + " | Target: " + target;
            }
        }
    } else {
        console.error("Goal select element not found.");
    }
/*
    document.querySelectorAll('.copy-action-plan-button').forEach(function(button) {
        button.addEventListener('click', function() {
            var actionPlanId = this.getAttribute('action_plan_id'); // data-action-plan-id attribute is set on button
            fetchCopyActionPlanDetails(actionPlanId);
        });
    });*/

    
});
</script>

    
        
 
    <!--Previous Action Plans Table-->
    <div class="previous-aps-section">
        <div class="toggle-table">
            <span id="toggleChevron" class="chevron" onclick="toggleTable()">▼</span> 
        </div>
        <table id="previousAPsTable" style="display: table;">
            <tr>
                <th class="medium-style2">Previous APs</th>
                <th class="medium-style2">Description</th>
                <th class="medium-style2">Budget</th>
                <th class="medium-style2">Goal</th>
                <th class="medium-style2">Actions</th>
            </tr>
            <?php include '../php/previous_ap.php'; ?>
            
        </table>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>/*
            // Get the modal
            var modal = document.getElementById("createAPModal");
    
            var btn = document.getElementById("createAPBtn");
    
            var span = document.getElementsByClassName("close")[0];
    
            btn.onclick = function() {
                modal.style.display = "block";
            }
    
            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }
    
            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
    
            document.getElementById("goal").onchange = function() {
                var selectedValue = this.value;
                var textDetails = document.getElementById("textDetails");
                textDetails.textContent = "Details for " + selectedValue;
            }
    


        function toggleTable() {
            var table = document.getElementById("previousAPsTable");
            var chevron = document.getElementById("toggleChevron");
    
            if (table.style.display === "none") {
                table.style.display = "table";
                chevron.textContent = "▼";
            } else {
                table.style.display = "none";
                chevron.textContent = "▶";
            }
        }*/
    </script>

<script>
    /*
    document.addEventListener("DOMContentLoaded", function() {
        // Get the modal
        var createModal = document.getElementById("createAPModal");
        var copyModal = document.getElementById("copyAPModal");

        // Ensure modals exist
        if (!createModal || !copyModal) {
            console.error("One or both modal elements not found");
            return;
        }

        // Get the close buttons and close functionality
        var closeCreateModal = createModal.getElementsByClassName("close")[0];
        var closeCopyModal = copyModal.getElementsByClassName("close")[0];

        if (closeCreateModal) {
            closeCreateModal.onclick = function() {
                createModal.style.display = "none";
            }
        } else {
            console.error("Close button for createAPModal not found");
        }

        if (closeCopyModal) {
            closeCopyModal.onclick = function() {
                copyModal.style.display = "none";
            }
        } else {
            console.error("Close button for copyAPModal not found");
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == createModal) {
                createModal.style.display = "none";
            } else if (event.target == copyModal) {
                copyModal.style.display = "none";
            }
        }

        // Open create action plan modal
        var createAPBtn = document.getElementById("createAPBtn");
        if (createAPBtn) {
            createAPBtn.onclick = function() {
                createModal.style.display = "block";
            }
        } else {
            console.error("Create Action Plan button not found");
        }

        // Handle goal selection
        var goalElement = document.getElementById("goal");
        if (goalElement) {
            goalElement.onchange = function() {
                var selectedValue = this.value;
                var textDetails = document.getElementById("textDetails");
                if (textDetails) {
                    textDetails.textContent = "Details for " + selectedValue;
                }
            }
        } else {
            console.error("Goal select element not found");
        }

        // Function to handle copying an action plan
        window.copyActionPlan = function(form) {
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
                    window.location.href = 'create_goal.php';
                } else if (result.isDismissed) {
                    copyModal.style.display = "block";
                }
            }).catch(error => {
                console.error('Swal.fire error:', error);
            });
        }
    });

    function toggleTable() {
        var table = document.getElementById("previousAPsTable");
        var chevron = document.getElementById("toggleChevron");

        if (table.style.display === "none") {
            table.style.display = "table";
            chevron.textContent = "▼";
        } else {
            table.style.display = "none";
            chevron.textContent = "▶";
        }
    }*/
</script>

    
      <!-- The Edit Action Plan Modal -->
<div id="editAPModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Action Plan</h2>
        <form id="editForm" action="../php/edit_ap.php" method="post" class="create-ap">
            <input type="hidden" id="editActionPlanId" name="action_plan_id">
            <label for="editActionPlanTitle" class="modal-label">Title: </label>
            <input type="text" id="editActionPlanTitle" name="title" class="form-input-1" placeholder="Title" required>
            <br>
            <label for="editActionPlanDescription" class="modal-label">Description: </label>
            <textarea id="editActionPlanDescription" name="edit_ap_description" class="description" placeholder="Description" required></textarea>
            <br>
            <label for="editActionPlanGoal" class="modal-label">Goal: </label>
            <select id="editActionPlanGoal" name="goal" class="form-select" required>
                <option value="" disabled selected>Goal</option>
                <?php
                // Get the logged-in user's ID
                $user_id = $_SESSION['user_id'];
                $current_year = date('Y');

                // Prepare and execute the query to fetch the user's goals
                $stmt = $conn->prepare("SELECT id, title, targets, initiative FROM goal WHERE user_id = ? AND archived IS NULL AND year = ?");
                $stmt->bind_param("ii", $user_id, $current_year);
                $stmt->execute();
                $result = $stmt->get_result();

                // Check if any goals were found and populate the dropdown
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '" data-ap-initiative="' . htmlspecialchars($row['initiative']) . '" data-ap-target="' . htmlspecialchars($row['targets']) . '">' . htmlspecialchars($row['title']) . '</option>';
                    }
                } else {
                    echo '<option value="" disabled>No goals found</option>';
                }
                ?>
            </select>
            
            <div class="text-details" id="editAPTextDetails">Goal details will appear here.</div>
            <br>
            <label for="department" class="modal-label">Department: </label>
            <input type="text" id="department" name="department" class="form-input-readonly" placeholder="Department" value="<?php echo htmlspecialchars($department); ?>" readonly required>   
            <br>
            <label for="editActionPlanBudget" class="modal-label">Budget: </label>
            <input type="text" id="editActionPlanBudget" name="budget" class="form-input-2c" placeholder="ex: 2000" required>
            <br>
            <div class="save-button-container">
                <button type="submit" class="create-button">Save Changes</button>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var editActionPlanModal = document.getElementById("editAPModal");
    var editActionPlanSpan = editActionPlanModal.getElementsByClassName("close")[0];

    // Close the modal when the user clicks on <span> (x)
    editActionPlanSpan.onclick = function() {
        editActionPlanModal.style.display = "none";
    }

    // Close the modal when the user clicks anywhere outside of it
    window.onclick = function(event) {
        if (event.target == editActionPlanModal) {
            editActionPlanModal.style.display = "none";
        }
    }

    document.querySelectorAll('.edit-action-plan-button').forEach(function(button) {
        button.addEventListener('click', function() {
            var actionPlanId = this.getAttribute('data-action-plan-id'); // data-action-plan-id attribute is set on button
            fetchEditActionPlanDetails(actionPlanId);
        });
    });

    function fetchEditActionPlanDetails(actionPlanId) {
        fetch(`../php/view_action_plan.php?id=${actionPlanId}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    populateEditActionPlanModal(data);
                    editActionPlanModal.style.display = "block";
                    updateGoalDetails();
                }
            })
            .catch(error => console.error('Error fetching action plan details:', error));
    }

    function populateEditActionPlanModal(actionPlan) {
        document.getElementById("editActionPlanId").value = actionPlan.id;
        document.getElementById("editActionPlanTitle").value = actionPlan.title;
        document.getElementById("editActionPlanDescription").value = actionPlan.ap_description;
        document.getElementById("editActionPlanBudget").value = actionPlan.budget;
        document.getElementById("editActionPlanGoal").value = actionPlan.goal;
    }

    function updateGoalDetails() {
        var goalElement = document.getElementById("editActionPlanGoal");
        var selectedOption = goalElement.options[goalElement.selectedIndex];
        var initiative = selectedOption.getAttribute('data-ap-initiative');
        var target = selectedOption.getAttribute('data-ap-target');
        var textDetails = document.getElementById("editAPTextDetails");

        if (textDetails) {
            textDetails.textContent = "Initiative: " + initiative + " | Target: " + target;
        }
    }

    // Handle goal selection
    var goalElement = document.getElementById("editActionPlanGoal");
    if (goalElement) {
        goalElement.onchange = function() {
            updateGoalDetails();
        }
    } else {
        console.error("Goal select element not found.");
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.view-action-plan-button').forEach(function(button) {
        button.addEventListener('click', function() {
            var actionPlanId = this.dataset.actionPlanId; // Assuming data-action-plan-id attribute is set on button
            fetchActionPlanDetails(actionPlanId);
        });
    });

    function fetchActionPlanDetails(actionPlanId) {
        fetch(`../php/view_action_plan.php?id=${actionPlanId}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    Swal.fire('Error', data.error, 'error');
                } else {
                    displayActionPlanDetails(data);
                }
            })
            .catch(error => console.error('Error fetching Action Plan details:', error));
    }

    function displayActionPlanDetails(actionPlan) {
        Swal.fire({
            title: 'Action Plan Details',
            html: `
                <p><strong>Action Plan ID:</strong> ${actionPlan.id}</p>
                <p><strong>Title:</strong> ${actionPlan.title}</p>
                <p><strong>Description:</strong> ${actionPlan.ap_description}</p>
                <p><strong>Goal:</strong> ${actionPlan.goal}</p>
                <p><strong>Department:</strong> ${actionPlan.department}</p>
                <p><strong>Total Budget:</strong> ${actionPlan.budget}</p>
            `,
            confirmButtonText: 'OK'
        });
    }
});
</script>
    
    <script>
        // Function to simulate viewing a AP (replace with actual functionality later)
        function viewAP(apName) {
            alert("Viewing " + apName);
            // Implement actual view functionality when backend is integrated
        }
    
        // Function to simulate editing a AP (replace with actual functionality later)
        function editAP(apName) {
            alert("Editing " + apName);
            // Implement actual edit functionality when backend is integrated
        }
    
        // Function to simulate copying a AP (replace with actual functionality later)
        function copyAP(apName) {
            alert("Copying " + apName);
            // Implement actual copy functionality when backend is integrated
        }
    
        // Function to simulate archiving a AP (replace with actual functionality later)
        function archiveAP(apName) {
            alert("Archiving " + apName);
            // Implement actual archive functionality when backend is integrated
        }
    
        // Function to simulate searching for a AP (replace with actual functionality later)
        function searchAP() {
            var searchQuery = document.getElementById("searchInput").value;
            alert("Searching for " + searchQuery);
            // Implement actual search functionality when backend is integrated
        }
    </script>
    </body>
    </html>
    