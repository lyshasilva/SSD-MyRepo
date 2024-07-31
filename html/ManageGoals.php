<!--Date: June 29, 2024 - 9:41pm start
    Description: Front-end of the Manage Goals Page for the Project
    Edited: July 2 & 3 2024
    Updated:July 4 2024 by Back End Team (BET) - Create Goals Window and Manage Goals Table Functionalities
            July 5 2024 by BET - Archive Feature
            July 8 2024 by BET - Display in the CURRENT GOALS table only the records under the user's department and the current year
                               - Made the PREVIOUS GOALS table work
                               - Automatic Title for the Goals Table based on the user's department
            July 9 2024 by BET - Confirm Archive Dialog
                               - SEARCH Feature
                               - VIEW Feature
            July 10 2024 by BET- EDIT feature
                               - COPY feature 
            July 11 2024 by BET- Added GOAL ID display in VIEW feature
    Comments of the Developer:  Read comments. Functionalities will fail to work indeed until they are connected to a backend API that handles them-->

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
    <title>Manage Goals</title>
    <link rel="stylesheet" href="../css/manage_goals.css">
</head>
<body>
    <header>
        <div class="header">
            <button class="pagebuttons" onclick="location.href='ManageGoals.php'">Manage Goals</button>
            <button class="pagebuttons" onclick="location.href='ManageActionPlans.php'">Manage AP</button>
            <button class="pagebuttons" onclick="location.href='ViewReports.php'">View Reports</button>
            <form method="post" class="logout">
                    <button type="submit" name="logout" class="logout">Log Out</button>
            </form>
        <!--
            <div class="logout">
                <a href="#" class="logout">Logout</a>
            </div>
        -->
        </div>
    </header>

     <!-- Dynamic Goal Title based on the User's Department -->
    <!-- Back End Logic is written in ../php/department-autofill.php -->
    <div class="goal-title"><?php echo $title ; ?> Goals</div>


        <table>
           <tr>
            <td colspan="5" class="medium-style">
            <!--
                <input type="text" class="input-bar" placeholder="Search...">
                <button class="search-button">Search</button>-->
            
                <!--<form method="GET" action="ManageGoals.php">
                    <input type="text" name="search" class="input-bar" placeholder="Search...">
                    <button type="submit" class="search-button">Search</button>
                </form>-->
                    <!--<form method="GET" action="ManageGoals.php" style="display: flex; align-items: center;">
                        <div style="position: relative; display: inline-block;">
                            <input type="text" name="search" id="searchInput" class="input-bar" placeholder="Search..." value="<?php //echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" style="padding-right: 24px;">
                            <button type="button" id="clearSearch" 
                                style="position: absolute; right: 5px; top: 50%; 
                                        transform: translateY(-50%); border: none; background: none; cursor: pointer;
                                        font-size: 16px; display: 
                                        <?php //echo isset($_GET['search']) && $_GET['search'] != '' ? 'inline' : 'none'; ?>;">
                                        &#10005;</button>
                        </div>
                        <button type="submit" class="search-button">Search</button>
                    </form>-->
                    <form method="GET" action="ManageGoals.php" style="display: inline-block"; >
                        <div style="width: 150%; display: flex; flex-direction: row;">
                            <input type="text" name="search" id="searchInput" class="input-bar" placeholder="Search..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <div style = "position: relative;">
                                <button type="button" id="clearSearch" 
                                    style=" position: absolute; left: 5px; top:8px; width: 26px; display: 
                                            <?php echo isset($_GET['search']) && $_GET['search'] != '' ? 'inline' : 'none'; ?>;">
                                            &#10005;
                                </button>
                            </div>
                        
                            <button type="submit" class="search-button" style="margin-left: 45px">Search</button>
                        </div>
                    </form>
                    <button class="create-button" id="createGoalBtn">Create New Goal</button>
                    
            </td>
        </tr>
            <tr>
                <td colspan="5" class="medium-style"></td>
            </tr>
            <tr>
                <th class="medium-style">Current Goals</th>
                <th class="medium-style">Initiative</th>
                <th class="medium-style">Target</th>
                <th class="medium-style">Budget</th>
                <th class="medium-style">Actions</th>
            </tr>

            <!-- php code for displaying CURRENT GOALS and for searching goals -->
            <!-- php code for archiving is included -->
            <?php
            include '../php/current_goal.php'
            ?>

        </table>

    <!-- Search Bar--> 
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
                window.location.href = 'ManageGoals.php';
            });

            // Initial check for displaying the "X" button
            toggleClearButton();

            // Update "X" button visibility when input changes
            searchInput.addEventListener('input', toggleClearButton);
        });
    </script>

<!-- The create Goal Modal -->
<div id="createGoalModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>CREATE GOAL</h2>
        <form action="../php/creategoal.php" method="post">
            <label for="title" class="modal-label">Title:</label>
            <input type="text" id="title" name="title" class="form-input-1" required>
            <br>
            <label for="year" class="modal-label">Year:</label>
            <input type="number" id="year" name="year" class="form-input-readonly2c" placeholder="Year" value="<?php echo date('Y'); ?>" readonly required>
            <label for="department" class="modal-label">Department:</label>
            <input type="text" id="department" name="department" class="form-input-readonly2c" value="<?php echo htmlspecialchars($department); ?>" readonly required>
            <br>
            <label for="targets" class="modal-label">Targets:</label>
            <input type="text" id="targets" name="targets" class="form-input-1" required>
            <br>
            <label for="totalBudget" class="modal-label">Total Budget:</label>
            <input type="number" id="totalBudget" name="totalBudget" class="form-input-readonly"  value="0" readonly required>
            <label for="initiative" class="modal-label">Initiative:</label>
            <select id="createInitiative" name="initiative" class="form-select" required>
            <option value="" disabled selected>SELECT Initiative</option>
                    <!-- Options from KPI 1.1 to KPI 10.5 -->
                    <?php
                    // Define the range of values for each KPI
                    $kpi_ranges = [
                        1 => 7,
                        2 => 11,
                        3 => 3,
                        4 => 3,
                        5 => 9,
                        6 => 8,
                        7 => 3,
                        8 => 3,
                        9 => 7,
                        10 => 5
                    ];

                    // Loop through the KPIs and generate options
                    foreach ($kpi_ranges as $i => $max_j) {
                        for ($j = 1; $j <= $max_j; $j++) {
                            echo '<option value="KPI ' . $i . '.' . $j . '">KPI ' . $i . '.' . $j . '</option>';
                        }
                    }
                    ?>
                 </select>
            <div class="kpi-text" id="kpiDetails">Key performance indicator details</div>
            <div class="save-button-container">
                <button type="submit" class="create-button">Save Goal</button>
            </div>
        </form>
    </div>
</div>
    
<!-- The Edit Goal Modal -->
<div id="editGoalModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>EDIT GOAL</h2>
        <form action="../php/edit_goal.php" method="post">
            <input type="hidden" id="editGoalId" name="goal_id">
            <label for="editTitle" class="modal-label">Title:</label>
            <input type="text" id="editTitle" name="title" class="form-input-1" placeholder="Title" required>
            <br>
            <label for="editYear" class="modal-label">Year:</label>
            <input type="number" id="editYear" name="year" class="form-input-readonly2c" placeholder="Year" readonly required>
            <label for="editDepartment" class="modal-label">Department:</label>
            <input type="text" id="editDepartment" name="department" class="form-input-readonly2c" placeholder="Department" readonly required>
            <br>
            <label for="editTargets" class="modal-label">Targets:</label>
            <input type="text" id="editTargets" name="targets" class="form-input-1" placeholder="Targets" required>
            <br>
            <label for="editTotalBudget" class="modal-label">Total Budget:</label>
            <input type="number" id="editTotalBudget" name="totalBudget" class="form-input-readonly" placeholder="Total Budget" readonly required>
            <label for="editInitiative" class="modal-label">Initiative:</label>
            <select id="editInitiative" name="initiative" class="form-select" required>
                <option value="" disabled selected>Select Initiative</option>
                <?php
                    // Define the range of values for each KPI
                    $kpi_ranges = [
                        1 => 7,
                        2 => 11,
                        3 => 3,
                        4 => 3,
                        5 => 9,
                        6 => 8,
                        7 => 3,
                        8 => 3,
                        9 => 7,
                        10 => 5
                    ];

                    // Loop through the KPIs and generate options
                    foreach ($kpi_ranges as $i => $max_j) {
                        for ($j = 1; $j <= $max_j; $j++) {
                            echo '<option value="KPI ' . $i . '.' . $j . '">KPI ' . $i . '.' . $j . '</option>';
                        }
                    }
                    ?>
            </select>
            <div class="kpi-text" id="editKpiDetails">Key performance indicator details</div>
            <div class="save-button-container">
                <button type="submit" class="create-button">Save Changes</button>
            </div>
        </form>
    </div>
</div>
<script src="../php/kpidetails.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // General Functions

        function closeModal(modal) {
            modal.style.display = "none";
        }

        function openModal(modal) {
            modal.style.display = "block";
        }

        // Edit Modal
        var editModal = document.getElementById("editGoalModal");
        var editSpan = editModal.getElementsByClassName("close")[0];

        editSpan.onclick = function() {
            closeModal(editModal);
        }

        window.onclick = function(event) {
            if (event.target == editModal) {
                closeModal(editModal);
            }
        }

        document.querySelectorAll('.edit-button').forEach(function(button) {
            button.addEventListener('click', function() {
                var goalId = this.dataset.goalId; // data-goal-id attribute is set on button
                fetchEditGoalDetails(goalId);
            });
        });

        function fetchEditGoalDetails(goalId) {
            fetch(`../php/view_goal.php?id=${goalId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        populateEditGoalModal(data);
                        openModal(editModal);
                    }
                })
                .catch(error => console.error('Error fetching goal details:', error));
        }

        function populateEditGoalModal(goal) {
            document.getElementById("editGoalId").value = goal.id;
            document.getElementById("editTitle").value = goal.title;
            document.getElementById("editYear").value = goal.year;
            document.getElementById("editDepartment").value = goal.department;
            document.getElementById("editTargets").value = goal.targets;
            document.getElementById("editTotalBudget").value = goal.total_budget;
            document.getElementById("editInitiative").value = goal.initiative;
            // document.getElementById("kpiDetails").textContent = "Details for " + goal.initiative;
        }

        // Create Modal
        var createModal = document.getElementById("createGoalModal");
        var createBtn = document.getElementById("createGoalBtn");
        var createSpan = createModal.getElementsByClassName("close")[0];

        createBtn.onclick = function() {
            openModal(createModal);
        }

        createSpan.onclick = function() {
            closeModal(createModal);
        }

        window.onclick = function(event) {
            if (event.target == createModal) {
                closeModal(createModal);
            }
        }

    });

    
</script>

<!-- Archive Confirmation Modal-->
<div id="archiveModal" class="modal" style="display:none;">
    <div class="modal-content">
        <h2>Confirm Archiving</h2>
        <p>Are you sure you want to archive this goal?</p>
        <button id="confirmYes">Yes</button>
        <button id="confirmNo">No</button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Attach the confirmArchive function to buttons with the class 'archive-button'
        $('.archive-button').on('click', function(event) {
            event.preventDefault(); // Prevent default button behavior
            
            const goalId = $(this).data('goal-id');
            const goalTitle = $(this).data('goal-title');

            Swal.fire({
                title: 'Confirm Archiving',
                text: `Are you sure you want to archive this goal '${goalTitle}'?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform the AJAX request
                    $.ajax({
                        url: '../php/archive_goal.php',
                        method: 'POST',
                        data: {
                            goal_id: goalId,
                            goal_title: goalTitle
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
                                text: 'There was an error archiving the goal.',
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



<!--PREVIOUS GOALS TABLE-->
<div class="previous-goals-section">
    <div class="toggle-table">
        <span id="toggleChevron" class="chevron" onclick="toggleTable()">▶</span> 
    </div>
    <table id="previousGoalsTable" style="display: none;">
        <tr>
            <th class="medium-style2">Previous Goals</th>
            <th class="medium-style2">Initiative</th>
            <th class="medium-style2">Target</th>
            <th class="medium-style2">Budget</th>
            <th class="medium-style2">Actions</th>
        </tr>

         <!-- php code for displaying PREVIOUS GOALS -->
         <!-- php codes for displaying archiving and viewing are included -->
         <?php
        include '../php/previous_goal.php'
        ?>

    </table>
</div>

    <script>
        function toggleTable() {
            var table = document.getElementById("previousGoalsTable");
            var chevron = document.getElementById("toggleChevron");

            if (table.style.display === "none") {
                table.style.display = "table";
                chevron.textContent = "▼";
            } else {
                table.style.display = "none";
                chevron.textContent = "▶";
            }
        }
    </script>

<!-- View Goal Modal -->
<div id="viewGoalModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Goal Details</h2>
        <div id="goalDetails"></div>
        <button class="ok-button" id="okButton">OK</button>
    </div>
</div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById("viewGoalModal");
    var span = modal.getElementsByClassName("close")[0];
    var okButton = document.getElementById("okButton");

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks on "OK" button, close the modal
    okButton.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    document.querySelectorAll('.view-button').forEach(function(button) {
        button.addEventListener('click', function() {
            var goalId = this.dataset.goalId; // Assuming data-goal-id attribute is set on button
            fetchGoalDetails(goalId);
        });
    });

    function fetchGoalDetails(goalId) {
        fetch(`../php/view_goal.php?id=${goalId}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    displayGoalDetails(data);
                    modal.style.display = "block";
                }
            })
            .catch(error => console.error('Error fetching goal details:', error));
    }

    function displayGoalDetails(goal) {
        var details = `
            <p><strong>Goal ID:</strong> ${goal.id}</p>
            <p><strong>Title:</strong> ${goal.title}</p>
            <p><strong>Year:</strong> ${goal.year}</p>
            <p><strong>Department:</strong> ${goal.department}</p>
            <p><strong>Targets:</strong> ${goal.targets}</p>
            <p><strong>Total Budget:</strong> ${goal.total_budget}</p>
            <p><strong>Initiative:</strong> ${goal.initiative}</p>
        `;
        document.getElementById("goalDetails").innerHTML = details;
            }
        });
        
    </script>

<script>
    // Function to simulate viewing a goal (replace with actual functionality later)
    function viewGoal(goalName) {
        alert("Viewing " + goalName);
        // Implement actual view functionality when backend is integrated
    }

    // Function to simulate editing a goal (replace with actual functionality later)
    function editGoal(goalName) {
        alert("Editing " + goalName);
        // Implement actual edit functionality when backend is integrated
    }

    // Function to simulate copying a goal (replace with actual functionality later)
    function copyGoal(goalName) {
        alert("Copying " + goalName);
        // Implement actual copy functionality when backend is integrated
    }

    // Function to simulate archiving a goal (replace with actual functionality later)
    function archiveGoal(goalName) {
        alert("Archiving " + goalName);
        // Implement actual archive functionality when backend is integrated
    }

    // Function to simulate searching for a goal (replace with actual functionality later)
    function searchGoal() {
        var searchQuery = document.getElementById("searchInput").value;
        alert("Searching for " + searchQuery);
        // Implement actual search functionality when backend is integrated
    }
</script>
</body>
</html>