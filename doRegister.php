<?php
// ur mission is after create connection to database, you need to implement the following functionalities in this file:
// 1. Create a POST request to handle registration form submission
// 2. Validate the input fields: username, email, password, confirm_password make sure confirm_password matches password
// 3. Check if the username or email already exists in the database
// 4. If validation passes, hash the password and insert the new user into the database
// 5. If registration is successful, redirect to login.php with a success message
session_start();

require_once 'db.php';

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirm_password'];
    
    if(empty($username)){
        $_SESSION['error'] = 'Username cannot be empty';
        header('Location: register.php');
        exit();
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $_SESSION['error'] = 'Email not valid';
        header('Location: register.php');
        exit();
    }   

    $q = "SELECT * FROM users WHERE email = '$email' OR username = '$username'";
    $result = $conn->query($q);
    if($result->num_rows > 0){
        $_SESSION['error'] = 'Username or email already registered';
        header('Location: register.php');
        exit();
    }

    if(strlen($password) < 8){
        $_SESSION['error'] = 'Password must be at least 8 characters';
        header('Location: register.php');
        exit();
    }

    if($password !== $cpassword){
        $_SESSION['error'] = 'Password does not match';
        header('Location: register.php');
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $q = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";

    if($conn->query($q)){
        $_SESSION['success'] = 'Registration successful!';
        header('Location: login.php');
        exit();
    }
    else{
        $_SESSION['error'] = $conn->error;
        header('Location: register.php');
        exit();
    }
    
}
else{
    header('Location: register.php');
    exit();
}