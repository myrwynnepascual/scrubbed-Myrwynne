<?php

// echo "Welcome to create.php";

include("connection.php");

//Get data from mySql
$teamSql = "SELECT * FROM teams";

$teamsResult = $connection-> query($teamSql);

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    //Pass staff data
    $fName = $_POST["first_name"];
    $lName = $_POST["last_name"];
    $staffID = $_POST["staff_id"];
    $empStatus = $_POST["employment_status"];
    $empTeams = $_POST["teams"];


    //Insert new staff data to USERS table
    $insertUser = "INSERT INTO users (first_name, last_name, staff_id, employment_status)
                    VALUES ('$fName', '$lName', '$staffID', '$empStatus')";
    
    $connection->query($insertUser);

    //Get ID of new inserted staff
    $userID = $connection->insert_id;

    //Insert new staff's team to TEAM_USER table
    foreach ($empTeams as $teamID){
        $insertTeam = "INSERT INTO team_user (team_id, user_id) 
                        VALUES ($teamID, $userID)";

        $connection->query($insertTeam);
    }

    //Redirect user to main page
    header("Location: index.php");
    exit();

}

?>

<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Create Staff</title>
</head>
<body>

    <a href = "index.php">Go Back</a>

    <div class = "container">
        
        <h2>ADD NEW STAFF</h2>
        
        <div>
            <form method = "POST" action = "" id = "create_form">

                <label for = "first_name">First Name </label>
                <input type = "text" name = "first_name" required><br>

                <label for = "last_name">Last Name </label>
                <input type = "text" name = "last_name" required><br>

                <label for = "staff_id">Staff ID </label>
                <input type = "number" name = "staff_id" required><br>

                <label for = "employment_status">Employment Status </label>
                <select name = "employment_status" required>
                    <option value = "" disabled selected>-- Select option --</option>
                    <option value = "Probationary">Probationary</option>
                    <option value = "Regular">Regular</option>
                    <option value = "Resigning">Resigning</option>
                    <option value = "Resigned">Resigned</option>
                </select><br>

                <div id="teams">
                    <label for="teams[]">Teams </label><br>
                    <?php
    
                    while ($team = $teamsResult-> fetch_assoc()){
                        echo "<input type='checkbox' name='teams[]' value='{$team['id']}'> {$team['name']}";
                    }

                    ?>
                </div>
                

                <br>

                <input type = "submit" value = "Create" id = "add">
            </form>
 
        </div>

        

    </div>
    
</body>
</html>