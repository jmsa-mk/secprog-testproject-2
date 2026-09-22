<?php
require_once 'init.php';
$hostname = "localhost";
$username = "root";
$password = '';
$database = 'db_upload_exercise';

$conn = new mysqli($hostname, $username, $password, $database);

if($conn->connect_error){
    die($conn->connect_error);
}

