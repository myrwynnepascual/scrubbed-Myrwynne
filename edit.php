<?php 

// echo "welcome to edit.php";

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET"){


    //Get staff user id based on the id passed in URL
    $userID = $_GET["id"];

    //Get data from USERS table
    $userQuery = "SELECT * FROM users WHERE id = $userID";
    $userResult = $connection-> query($userQuery);
    $user = $userResult-> fetch_assoc();

    //Get data from TEAMS table
    $teamsQuery = "SELECT * FROM teams";
    $teamsResult = $connection-> query($teamsQuery);

    //Get data of user's teams from TEAM_USER table
    $userTeamsQuery = "SELECT team_id FROM team_user WHERE user_id = $userID";
    $userTeamsResult = $connection-> query($userTeamsQuery);
    $userTeamsID = [];
    while ($row = $userTeamsResult-> fetch_assoc()){
        $userTeamsID[] = $row["team_id"];
    }

}

else if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
    //Pass staff data
    $userID = $_POST["id"];
    $fName = $_POST["first_name"];
    $lName = $_POST["last_name"];
    $staffID = $_POST["staff_id"];
    $empStatus = $_POST["employment_status"];
    $empTeams = $_POST["teams"];

    //Update staff data in USERS table
    $updateUser = "UPDATE users 
    SET first_name = '$fName', last_name = '$lName', staff_id = $staffID, employment_status = '$empStatus' 
    WHERE id = $userID";
    
    $connection-> query($updateUser);

    //Delete old staff data in TEAM_USER table
    $deleteOldTeam = "DELETE FROM team_user WHERE user_id = $userID";
    $connection-> query($deleteOldTeam);

    //Insert new staff's team to TEAM_USER table
    foreach ($empTeams as $teamID){
        $insertTeam = "INSERT INTO team_user (team_id, user_id) 
                        VALUES ($teamID, $userID)";

        $connection-> query($insertTeam);
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
    <title>Edit Staff</title>
</head>
<body>

    <a href = "index.php">Go Back</a>

    <div class = "container">

        <h2>EDIT STAFF</h2>

        <div>
            <form method = "POST" action = "" id = "create_form">

                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

                <label for = "first_name">First Name </label>
                <input type = "text" name = "first_name" value="<?php echo $user['first_name']; ?>"><br>

                <label for = "last_name">Last Name </label>
                <input type = "text" name = "last_name" value="<?php echo $user['last_name']; ?>"><br>

                <label for = "staff_id">Staff ID </label>
                <input type = "number" name = "staff_id" value="<?php echo $user['staff_id']; ?>"><br>

                <label for = "employment_status">Employment Status </label>
                <select name = "employment_status">

                    <option value = "Probationary" <?php echo ($user['employment_status'] == 'Probationary') ? 'selected' : ''; ?>>Probationary</option>
                    <option value = "Regular" <?php echo ($user['employment_status'] == 'Regular') ? 'selected' : ''; ?>>Regular</option>
                    <option value = "Resigning" <?php echo ($user['employment_status'] == 'Resigning') ? 'selected' : ''; ?>>Resigning</option>
                    <option value = "Resigned" <?php echo ($user['employment_status'] == 'Resigned') ? 'selected' : ''; ?>>Resigned</option>
                </select><br>

                <div id="teams">
                    <label for="teams">Teams </label><br>
                    <?php

                    while ($team = $teamsResult-> fetch_assoc()){
                        $checked = in_array($team['id'], $userTeamsID) ? 'checked' : '';
                        echo "<input type='checkbox' name='teams[]' value='{$team['id']}'$checked> {$team['name']}";
                    }

                    ?>
                </div>
                
                <br>

                <input type = "submit" value = "Update" id = "update">


            </form>
        </div>
    </div>

    

</body>
</html>