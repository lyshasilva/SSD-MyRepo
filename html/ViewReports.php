<!--Date: July 15, 2024 - 10:03pm start
    Edited: July 23, 2024
    Description: Front-end of the View Reports Page for the Project
    Comments of the Developer:  /* Adjust as needed */ -->


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Reports</title>
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
    
            .container {
                padding: 1rem; 
                margin-top: 4rem; 
                width: 95%;
                max-width: 1200px;
                margin: 0 auto;
                background: linear-gradient(to bottom, #fff, #f9f9f9);
                border-radius: 12px;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1), 0 4px 16px rgba(0, 0, 0, 0.1); /* Reduced shadow */
                overflow-y: auto;
            }
    
            #viewDropdown {
                font-family: 'Lato', sans-serif;
                font-size: 22px;
                font-weight: 300;
                color:black;
                outline: none;
                border: none;
                cursor: pointer;
            }

            .filters {
                display: flex;
                justify-content: flex-end;
                align-items: center;
                margin-top: -2rem;
                margin-bottom: 2rem;
                flex-wrap: wrap;
            }
    
            .filters label {
                margin-right: 0.5rem;
                color: #555;
                font-size: 0.875rem; 
            }
    
            .filters select {
                margin-right: 1rem;
                padding: 0.5rem;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 0.875rem; 
            }
    
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 1rem;
            }
    
            th, td {
                border: 1px solid #ccc;
                padding: 0.75rem; 
                text-align: center;
                font-size: 0.875rem; 
            }
    
            th {
                background-color: #6465A2;
                color: #fff;
                cursor: pointer;
            }
    
            table tr:last-child td {
                font-weight: bold;
            }
    
            .charts {
                display: flex;
                flex-wrap: wrap; 
                gap: 1rem; 
                justify-content: center; 
                margin-bottom: 1rem;
            }
    
            .chart {
                flex: 1 1 100%; 
                max-width: 400px;
                text-align: center;
                margin-bottom: 1rem;
            }
    
            canvas {
                width: 100%;
                max-height: 250px; 
            }
    
            /* Responsive adjustments */
            @media screen and (min-width: 768px) {
                .chart {
                    flex: 1 1 30%; 
                }
            }
    
            @media screen and (max-width: 768px) {
                .chart {
                    flex: 1 1 100%;
                    max-width: none;
                }
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
    
        <div class="container">
            <h1>
                <select id="viewDropdown" onchange="changeView()">
                    <option value="ViewReports.php">Reports Summary View</option>
                    <option value="InitDetailView.php">Initiative Detail View</option>
                    <option value="DeptDetailView.php">Department Detail View</option>
                </select>
            </h1>
            
            <div class="filters">
                <label for="year">YEAR:</label>
                <select id="year" name="year">
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                </select>
                <label for="targets">TARGETS:</label>
                <select id="targets" name="targets">
                    <option value="baptisms">BAPTISMS</option>
                </select>
            </div>
    
            <table>
                <thead>
                    <tr>
                        <th onclick="toggleColumnContent()">INITIATIVE</th>
                        <th>ALLOCATED BUDGET</th>
                        <th>SPEND</th>
                        <th>GOALS COMPUTE / TOTAL</th>
                        <th>BAPTISMS TARGET</th>
                        <th>BAPTISMS RESULT</th>
                    </tr>
                </thead>
                <tbody id="dataRows">
                    <tr>
                        <td class="initiative">KPI 1.1</td>
                        <td>73,480</td>
                        <td>20,480 (34%)</td>
                        <td>14/23</td>
                        <td>10,000</td>
                        <td>2,343 (23%)</td>
                    </tr>
                    <tr>
                        <td class="initiative">KPI 1.2</td>
                        <td>4,320</td>
                        <td>7,340 (.73%)</td>
                        <td>0/4</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td class="initiative">KPI 1.3</td>
                        <td>200,000</td>
                        <td>5,000 (2%)</td>
                        <td>7/11</td>
                        <td>3,000</td>
                        <td>6,487 (213%)</td>
                    </tr>
                    <tr>
                        <td>TOTALS:</td>
                        <td>$277,800</td>
                        <td>$32,634</td>
                        <td>21/34</td>
                        <td>13,000</td>
                        <td>8,720</td>
                    </tr>
                </tbody>
            </table>
        </div>
    
        <div class="charts">
            <div class="chart">
                <h2>BUDGET</h2>
                <canvas id="budgetChart"></canvas>
            </div>
            <div class="chart">
                <h2>GOALS</h2>
                <canvas id="goalsChart"></canvas>
            </div>
            <div class="chart">
                <h2>BAPTISM</h2>
                <canvas id="baptismChart"></canvas>
            </div>
        </div>
        
        <script>
            function changeView() {
                const dropdown = document.getElementById('viewDropdown');
                const url = dropdown.value;
                if (url) {
                    window.location.href = url;
                }
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const budgetCtx = document.getElementById('budgetChart').getContext('2d');
                const goalsCtx = document.getElementById('goalsChart').getContext('2d');
                const baptismCtx = document.getElementById('baptismChart').getContext('2d');
                const budgetChart = new Chart(budgetCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Spend', 'Total'],
                        datasets: [{
                            data: [32634, 277800 - 32634],
                            backgroundColor: ['#6465A2', '#B2B3D0']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
                const goalsChart = new Chart(goalsCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Completed', 'Total'],
                        datasets: [{
                            data: [21, 34 - 21],
                            backgroundColor: ['#6465A2', '#B2B3D0']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
                const baptismChart = new Chart(baptismCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Result', 'Target'],
                        datasets: [{
                            data: [8720, 13000 - 8720],
                            backgroundColor: ['#6465A2', '#B2B3D0']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            });
    
            function toggleColumnContent() {
                const columnCells = document.querySelectorAll('td:nth-child(1)');
                const isInitiative = columnCells[0].innerText.startsWith('KPI');
                const headerCell = document.querySelector('th:nth-child(1)');
    
                if (isInitiative) {
                    headerCell.innerText = 'DEPARTMENT';
                    columnCells.forEach(cell => {
                        cell.innerText = cell.innerText.replace(/KPI\s+\d+\.\d+/, 'Department');
                    });
                } else {
                    headerCell.innerText = 'INITIATIVE';
                    columnCells.forEach(cell => {
                        cell.innerText = cell.innerText.replace('Department', 'KPI 1.1'); // Update this to reflect the actual KPI
                    });
                }
            }
        </script>
    </body>
    </html>
    