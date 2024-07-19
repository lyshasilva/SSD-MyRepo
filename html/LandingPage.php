<!--Date: June 29, 2024 - 7:34pm start
    Edited: July 1, 2024
    Description: Front-end of the Landing Page for the Project
    Comments of F Developer:  /* Adjust as needed */ -->

    <?php include('../php/anti-shortcut_ssd.php'); ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #fff;
                margin: 0;
                padding: 0;
            }
    
            .container {
                display: flex;
                flex-wrap: wrap;
                max-width: 890px;
                margin: 20px auto;
                padding: 48px;
                justify-content: space-between;
                align-items: center;
            }
    
            .card {
                width: 200px;
                height: 175px;
                padding: 20px;
                margin-bottom: 20px;
                border-radius: 8px;
                transition: box-shadow 0.3s;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                background: linear-gradient(135deg, #5A4ABD, #78909C);
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                cursor: pointer;
                text-decoration: none;
            }
            .card:hover {
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            }
    
            h2 {
                color: white;
                font-family: 'Lato', sans-serif;
                font-weight: 300;
            }

            .description {
                font-style: italic;
                font-family: 'Lato', sans-serif;
                margin-top: 10px;
                text-align: center;
                color: white;
                font-weight: 150;
                font-size: small;
            }
    
            header {
                background-color: transparent;
                padding: 30px 28px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                margin-bottom: 20px;
            }
    
            .header-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
                max-width: 960px;
                margin: 0 auto;
                padding: 0 20px;
            }
    
            .greetings {
                flex: 1;
                font-family: 'Lato', sans-serif;
                font-weight: 300;
                margin: 0;
                padding: 0;
                color: #5A4ABD;
            }
    
            .logout {
                margin-left: auto;
                text-decoration: none;
                color: inherit;
                border: none;
                background: none;
                font-size: medium;
            }
            .logout:hover {
            color: #4a3bb3;
            cursor:pointer;
        }
        </style>
    </head>
    <body>
        <header>
            <div class="header-container">
                <h1 class="greetings">Welcome, <span id="username">User</span></h1>
                <form method="post" class="logout">
                    <button type="submit" name="logout" class="logout">Logout</button>
                </form>
                <!--<div class="logout">
                    <a href="#" class="logout">Logout</a>
                </div>-->
            </div>
        </header>
    
        <main>
            <section class="container">
                <a href="../html/ManageGoals.php" class="card" role="button" tabindex="0">
                    <h2>Manage Goals</h2>
                    <p class="description">Track and oversee objectives aligned with mission strategies for spreading the gospel globally.</p>
                </a>
    
                <a href="ManageActionPlans.html" class="card" role="button" tabindex="0">
                    <h2>Manage AP</h2>
                    <p class="description">Coordinate detailed plans to enhance spiritual growth initiatives and leadership development within the mission framework.</p>
                </a>
    
                <a href="ViewReports.html" class="card" role="button" tabindex="0">
                    <h2>View Reports</h2>
                    <p class="description">Access comprehensive reports showing the progress and outcomes in mission activities, spiritual growth endeavors, and leadership efforts.</p>
                </a>
            </section>
        </main>
    </body>
    </html>
    