<?php
// echo "welcome to details.php";

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET"){


    //Get staff user id based on the id passed in URL
    $userID = $_GET["id"];

    //Get data from USERS table
    $userQuery = "SELECT * FROM users WHERE id = $userID";
    $userResult = $connection-> query($userQuery);
    $user = $userResult-> fetch_assoc();

    //Get data of user's teams from TEAM_USER table
    $userTeamsQuery = "SELECT t.name FROM team_user tu
                        JOIN teams t ON tu.team_id = t.id
                        WHERE tu.user_id = $userID";
    $userTeamsResult = $connection-> query($userTeamsQuery);
    $userTeamsName = [];
    while ($row = $userTeamsResult-> fetch_assoc()){
        $userTeamsName[] = $row["name"];
    }

}

?>

<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Staff Details</title>
</head>
<body>

    <a href = "index.php">Go Back</a>

    <div class = "container">
        <h2>STAFF DETAILS</h2>

        <div id = "deets">
            <p><strong>Name:</strong> <?php echo "{$user['first_name']} {$user['last_name']}"; ?></p>
            <p><strong>Staff ID:</strong> <?php echo $user['staff_id']; ?></p>
            <p><strong>Employment Status:</strong> <?php echo $user['employment_status']; ?></p>
            <p><strong>Teams:</strong> <?php echo implode(", ", $userTeamsName); ?></p>
        </div>

        
    
    </div>

    
    
</body>
</html>