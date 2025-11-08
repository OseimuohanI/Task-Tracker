<?php

$db_server = '127.0.0.1:3305';
$db_user = "root";
$db_password ="";
$db_name = "tasks_db";

$conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);

if ($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}