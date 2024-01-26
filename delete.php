<?php

// echo "Welcome to delete.php";

include("connection.php");

if($_SERVER["REQUEST_METHOD"] == "GET"){

    //Get staff user id based on the id passed in URL
    $userID = $_GET["id"];

    //Delete staff data from TEAM_USER table
    $deleteTeamUser = "DELETE FROM team_user WHERE user_id = $userID";
    $connection->query($deleteTeamUser);

    //Delete staff data from USERS table
    $deleteUser = "DELETE FROM users WHERE id = $userID";
    $connection->query($deleteUser);

    //Redirect user to main page
    header("Location: index.php");
    exit();

}

?>

