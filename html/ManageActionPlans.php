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
        <title>Manage Goals</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400&display=swap');
    
            body {
                font-family: Arial, sans-serif;
                background-color: #fff;
                margin: 0;
                padding: 0;
            }
    
            .header {
                display: flex;
                justify-content: flex-end;
                align-items: center;
                padding: 30px 28px;
                background-color: transparent;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                margin-bottom: 20px;
                gap: 10px;
            }
    
            .header button {
                margin-left: 18px;
                padding: 10px 20px;
                border: none;
                border-radius: 8px;
                background: linear-gradient(135deg, #5A4ABD, #78909C);
                color: white;
                cursor: pointer;
                transition: background-color 0.3s ease;
                font-size: 16px;
            }
    
            .header button:hover {
                background: #D9E4F5;
                color: #4a3bb3
            }
    
            .logout {
                margin-left: 40px;
                margin-right: 62.5px;
                color: inherit;
                text-decoration: none;
                font-size: 16px;
                cursor: pointer;
            }
    
            .logout:hover {
                color: #4a3bb3;
            }
    
            .ap-title {
                font-family: 'Lato', sans-serif;
                color: black;
                font-size: 18px;
                font-weight: 300;
                margin: 20px 28px;
            }
    
            table {
                width: calc(100% - 56px);
                border-collapse: collapse;
                margin: 20px 28px;
                font-family: 'Lato', sans-serif;
                border: 1px solid #ddd;
                border-collapse: collapse;
            }
    
            tr {
                width: 30px;
            }
    
            th, td {
                padding: 10px;
                text-align: left;
                border: 1px solid #ddd;
            }
    
            th {
                background-color: #f4f4f4;
            }
    
            .medium-style {
                background-color: #e8ebfc;
            }
    
            .medium-style2 {
                background-color: #D1D1D1;
            }
    
            .input-bar {
                width: 30%;
                padding: 10px;
                font-size: 14px;
                border: 1px solid #ccc;
                border-radius: 4px;
                background-color: white;
            }
    
            .search-button, .create-button {
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                background-color: #595B9B;
                color: white;
                cursor: pointer;
                font-size: 14px;
                font-weight: 300;
            }
    
            .create-button {
                margin-left: 160px;
            }
    
            .edit-button, .archive-button {
                padding: 5px 10px;
                border: none;
                border-radius: 4px;
                background-color: #5A4ABD;
                color: white;
                cursor: pointer;
                font-size: 12px;
                margin-right: 3px;
            }
    
            .view-button, .copy-button {
                padding: 5px 10px;
                border: none;
                border-radius: 4px;
                background-color: #5A4ABD;
                color: white;
                cursor: pointer;
                font-size: 12px;
                margin-right: 3px;
                display: inline-block;
            }
    
            .row-1 td:first-child {
                background-color: #FEFEFE;
            }
    
            .row-2 td:first-child {
                background-color: #e8e8fc;
            }

            .p-row-2 td:first-child {
                background-color: #edeef0;
            }

            /* Modal styles */
            .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgb(0,0,0);
                background-color: rgba(0,0,0,0.4);
                padding-top: 60px;
            }
    
            .modal-content {
                background-color: #fefefe;
                margin: 5% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
                max-width: 500px;
                border-radius: 10px;
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
            }
    
            .modal-content h2 {
                width: 100%;
            }
    
            .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }
    
            .close:hover,
            .close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }
    
            .form-input {
                width: calc(48% - 10px);
                padding: 10px;
                margin: 5px 0;
                font-size: 14px;
                border: 1px solid #ccc;
                border-radius: 4px;
                background-color: white;
            }
    
            .form-select {
                width: calc(48% - 10px);
                padding: 10px;
                margin: 5px 0;
                font-size: 14px;
                border: 1px solid #ccc;
                border-radius: 4px;
                background-color: white;
            }
    
            .form-full {
                width: 100%;
            }
    
            .text-details {
                width: 43.5%;
                padding-left: 10px;
                margin: 5px 0;
                font-size: 14px;
                border: 1px solid #ccc;
                border-radius: 4px;
                background-color: #f4f4f4;
                color: #333;
            }

            .text-fields {
                padding-left: 7px;
                font-size: 14px;
            }
    
            .save-button-container {
                width: 100%;
                text-align: right;
            }
        </style>
    </head>
    <body>
        <header>
            <div class="header">
                <button onclick="location.href='ManageGoals.php'">Manage Goals</button>
                <button onclick="location.href='ManageActionPlans.php'">Manage AP</button>
                <button onclick="location.href='ViewReports.php'">View Reports</button>
                <div class="logout">
                    <a href="#" class="logout">Logout</a>
                </div>
            </div>
        </header>
    
        <div class="ap-title">Sabbath School Action Plans</div>
    
        <table>
            <tr>
                <td colspan="5" class="medium-style">
                    <input type="text" class="input-bar" placeholder="Search...">
                    <button class="search-button">Search</button>
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
            <?php include '../php/current_ap.php'; ?>
            <!-- Add dynamic rows here as new APs are created -->
        </table>
    
        <!-- The Modal -->
        <div id="createAPModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>CREATE ACTION PLAN</h2>
                <form action="../php/create_ap.php" method="post">
                    <input type="text" id="title" name="title" class="form-input" placeholder="Title" required>
                    <select id="goal" name="goal" class="form-select" required>
                        <option value="" disabled selected>Goal</option>
                        <?php
                        // Get the logged-in user's ID
                            $user_id = $_SESSION['user_id'];

                            // Prepare and execute the query to fetch the user's goals
                            $stmt = $conn->prepare("SELECT id, title FROM goal WHERE user_id = ?");
                            $stmt->bind_param("i", $user_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Check if any goals were found and populate the dropdown
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['title']) . '</option>';
                                }
                            } else {
                                echo '<option value="" disabled>No goals found</option>';
                            }
                            ?>
                    </select>
                    <input type="text" id="description" name="description" class="form-input" placeholder="Description" required>           
                    <div class="text-details" id="textDetails">Text details</div>
                    <p class="text-fields">Budget</p>
                    <input type="text" id="department" name="department" class="form-input-readonly" placeholder="Department" value="<?php echo htmlspecialchars($department); ?>" readonly required>
                    <input type="text" id="budget" name="budget" class="form-input" placeholder="ex: 2000" required>
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
        </script>

 
    <!--Previous Action Plans Table-->
    <div class="previous-aps-section">
        <div class="toggle-table">
            <span id="toggleChevron" class="chevron" onclick="toggleTable()">▶</span> 
        </div>
        <table id="previousAPsTable" style="display: none;">
            <tr>
                <th class="medium-style2">Previous APs</th>
                <th class="medium-style2">Description</th>
                <th class="medium-style2">Budget</th>
                <th class="medium-style2">Goal</th>
                <th class="medium-style2">Actions</th>
            </tr>
            <!-- Example rows, replace with your actual data -->
            <tr class="row-1">
                <td>Previous AP 1</td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <button class="view-button">View</button>
                    <button class="copy-button">Copy</button>
                    <button class="archive-button">Archive</button>
                </td>
            </tr>
            <tr class="p-row-2">
                <td>Previous AP 2</td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <button class="view-button">View</button>
                    <button class="copy-button">Copy</button>
                    <button class="archive-button">Archive</button>
                </td>
            </tr>
            <!-- Add more rows as needed -->
        </table>
    </div>
    
    <script>
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
        }
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
    