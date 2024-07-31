<?php
/*
    Filename: previous_goal.php
    Programmer: Lysha Silva
    Started: July 8, 2024; 10:55 AM
    Finished: July 8, 2024; 11:01 AM
    Updated: July 19, 2028; 8:02 AM by Prinz J M. - upgraded the alert archive confirmation message
                     to sweet alert message (ARCHIVE button)
    Description: PREVIOUS GOALS TABLE
                -fetchES unarchived goals under the user's department from previous years

*/
// Database connection
include('db.php');
            

            $sql = "SELECT id, title, initiative, targets, total_budget, created_at FROM goal WHERE archived IS NULL AND department = ? AND year < ? ORDER BY created_at DESC";
            $stmt_goals = $conn->prepare($sql);

            // Bind parameters
            $stmt_goals->bind_param("si", $department, $current_year); // "si" for string and integer

            // Execute the statement
            $stmt_goals->execute();

            // Get result set
            $result = $stmt_goals->get_result();

            if ($result->num_rows > 0) {
                $rowClass = "row-1";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class=\"$rowClass\">";
                    echo "<td>{$row['title']}</td>";
                    echo "<td>{$row['initiative']}</td>";
                    echo "<td>{$row['targets']}</td>";
                    echo "<td>{$row['total_budget']}</td>";
                    echo '<td>
                            <button class="view-button" data-goal-id="' . $row['id'] . '">View</button>
                            <!--<button class="copy-button">Copy</button>-->
                            <form method="post" action="../php/copy_goal.php" style="display:inline">
                                <input type="hidden" name="goal_id" value="' . $row['id'] . '">
                                <button type="submit" class="copy-button">Copy</button>
                            </form>
                           <form method="post" action="../php/archive_goal.php" style="display:inline" onsubmit="return confirmArchive(event);">
                                <input type="hidden" name="goal_id" value="' . $row['id'] . '">
                                <input type="hidden" name="goal_title" value="' . $row['title'] . '">
                                <button type="button" class="archive-button" data-goal-id="' . $row['id'] . '" data-goal-title="' . $row['title'] . '">Archive</button>
                            </form>
                        </td>';
                    echo '</tr>';
                    // Alternate row class for styling
                    $rowClass = ($rowClass == "row-1") ? "row-2" : "row-1";
                }
            } else {
                echo "<tr><td colspan='5'>No goals found.</td></tr>";
            }

            $stmt_goals->close();
           // $conn->close();
            ?>