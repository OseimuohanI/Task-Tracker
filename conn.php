<?php

$db_server = '127.0';
$db_user = "";
$db_password ="";
$db_name = "";

$conn = mysqli_connect();

if ($conn->connect_error){
    die();
}