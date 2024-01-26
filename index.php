<?php

include("connection.php");

//Get data from mySql
$sql = "SELECT u.id, u.first_name, u.last_name, u.staff_id, u.employment_status, GROUP_CONCAT(t.name) AS team_names
        FROM users u
        LEFT JOIN team_user tu ON u.id = tu.user_id
        LEFT JOIN teams t ON tu.team_id = t.id
        GROUP BY u.id";

$result = $connection-> query($sql);

?>

<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Employee Management System</title>
</head>
<body>
    <div class = "container">

        <h2>EMPLOYEE MANAGEMENT SYSTEM</h2>
        
        <div class = "table_container">
            <table>
                <!-- Labels for each column -->
                <tr>
                    <th>Employee Name</th>
                    <th>Staff ID</th>
                    <th>Employment Status</th>
                    <th>Teams</th>
                    <th>Action</th>
                </tr>

                <?php

                //Display rows or data from sql
                if($result-> num_rows > 0){
                        
                    //loop through the number of rows from table
                    while ($row = $result-> fetch_assoc()){

                        echo "<tr>
                                <td><a href='details.php?id=".$row['id']."' >{$row['first_name']} {$row['last_name']}</a></td>
                                
                                <td>{$row['staff_id']}</td>
                                <td>{$row['employment_status']}</td>
                                <td>{$row['team_names']}</td>

                                <td>
                                    <a id = 'edit' href='edit.php?id=".$row['id']."'>Edit</a>
                                    <a id = 'delete' href='delete.php?id=".$row['id']."'>Delete</a>
                                </td>
        
                            </tr>";
                        }

                        echo "</table>";

                    }

                else {
                        
                    $connection-> close();
                    echo "NO DATA FOUND<br>";
                }

                ?>

            </table>

            </div>

            <a href = 'create.php' id='create'>Create new staff</a>

    </div>
    
</body>
</html>