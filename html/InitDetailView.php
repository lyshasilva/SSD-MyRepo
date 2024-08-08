<!--Date: July 30, 2024 - 10:03pm start
    Edited: August 1, 2024
    Description: Front-end design of the View Reports Page for the Project
    Comments of the Developer:  /* Adjust as needed */ -->


    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Initiative Detail View</title>
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
                margin-top: 2rem; 
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

            .back-button {
                position: absolute;
                top: 1rem;
                left: 1rem;
                display: flex;
                align-items: center;
                cursor: pointer;
            }

            .back-button img {
                width: 24px;
                height: 24px;
                margin-right: 0.5rem;
            }

            .back-button span {
                font-size: 1rem;
                color: #000;
            }

            .filters {
                display: flex;
                justify-content: flex-end;
                align-items: center;
                flex-wrap: wrap;
            }

            .filters label {
                margin-right: 0.5rem;
                color: #555;
                font-size: 1rem;
            }

            .filters select {
                margin-right: 0.5rem;
                padding: 0.5rem;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 1rem;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 0.75rem;
                background-color: #B2B3D0;
            }

            th, td {
                border: 1px solid #ccc;
                padding: 0.75rem;
                text-align: center;
                font-size: 0.9rem;
            }

            th {
                background-color: #6465A2;
                color: #fff;
            }

            td {
                background-color: #D1D2E8;
                color: #333;
            }

            .charts {
                display: flex;
                justify-content: space-between;
                margin-bottom: 1rem;
                flex-wrap: wrap;
            }

            .chart {
                width: 20%;
                height: 20%;
                text-align: center;
                border: 1px solid #ccc;
                border-radius: 8px;
                padding: 1rem;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                background-color: #fff;
                margin-bottom: 1rem;
            }

            .chart-content {
                display: flex;
                flex-direction: column;
                justify-content: center;
                height: 43%;
                font-size: 1rem;
            }

            canvas {
                width: 80%;
                max-height: 160px;
            }

            @media (max-width: 768px) {
                .chart {
                    width: 48%;
                }
            }

            @media (max-width: 480px) {
                .chart {
                    width: 100%;
                }

                .filters {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .filters select {
                    margin-bottom: 1rem;
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

        <div class="filters">
            <div class="filter-group">
                <label for="year">YEAR:</label>
                <select id="year" name="year">
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                </select>
            </div>
        </div>
            <h1>
                <select id="viewDropdown" onchange="changeView()">
                    <option value="InitDetailView.php">Initiative Detail View</option>
                    <option value="ViewReports.php">Reports Summary View</option>
                    <option value="DeptDetailView.php">Department Detail View</option>
                </select>
            </h1>

        <div class="charts">
            <div class="chart">
                <h3>BUDGET</h3>
                <canvas id="budgetChart"></canvas>
            </div>
            <div class="chart">
                <h3>GOALS</h3>
                <div class="chart-content">
                    <p>13/34</p>
                    <p>37%</p>
                </div>
            </div>
            <div class="chart">
                <h3>BAPTISMS</h3>
                <div class="chart-content">
                    <p>2,000/10,000</p>
                    <p>20%</p>
                </div>
            </div>
            <div class="chart">
                <h3>EVENT CONDUCTED</h3>
                <div class="chart-content">
                    <p>14/28</p>
                    <p>50%</p>
                </div>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Dept</th>
                    <th>Budget</th>
                    <th>Goals</th>
                    <th>Baptisms</th>
                    <th>Event Conducted</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Information Tech</td>
                    <td>20,000</td>
                    <td>2/10</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Information Tech</td>
                    <td>50,000</td>
                    <td>3/10</td>
                    <td>500/7,000</td>
                    <td>7/20</td>
                </tr>
                <tr>
                    <td>Stewardship</td>
                    <td>70,000</td>
                    <td>7/14</td>
                    <td>1,300/3,000</td>
                    <td>7/8</td>
                </tr>
                <tr>
                    <td>Dept 1</td>
                    <td>30,000</td>
                    <td>4/12</td>
                    <td>800/2,500</td>
                    <td>4/10</td>
                </tr>
                <tr>
                    <td>Dept 2</td>
                    <td>40,000</td>
                    <td>5/11</td>
                    <td>600/3,000</td>
                    <td>5/15</td>
                </tr>
                <tr>
                    <td>Dept 3</td>
                    <td>60,000</td>
                    <td>6/9</td>
                    <td>900/4,000</td>
                    <td>6/12</td>
                </tr>
            </tbody>
        </table>
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
        });

        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
