<?php
// ur mission is after create connection to database, you need to implement the following functionalities in this file:
// 1. Create a POST request to handle login form submission
// 2. Validate the username and password against the database
// 3. If the credentials are valid, start a session and redirect to index.php
// 4. If the credentials are invalid, redirect back to login.php with an error message
// 5. Dont forget to include session_start() at the beginning of the file to manage user sessions
require_once 'init.php';
session_start();
require_once 'db.php';

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $q = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($q);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $res = $stmt->get_result();
    if($res->num_rows > 0){
        while($users = $res->fetch_assoc()){
            if(password_verify($password, $users['password'])){
                session_regenerate_id(true);
                $_SESSION['user'] = [
                    'id' => $users['id'],
                    'username' => $users['username']
                ];
                header('Location: index.php');
                exit();
            }
        }
    }

    $_SESSION['error'] = 'Wrong username or password combination';
    header('Location: login.php');
    exit();
}
else{
    header('Location: login.php');
    exit();
}