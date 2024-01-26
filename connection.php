<?php

error_reporting(0);

$db_host = "localhost";
$db_user = "root";
$db_password ="";
$db_name = "scrubbed_activity";

$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if ($connection-> connect_error){
    die("Connection Failed".$connection->connect_error());
}


?>