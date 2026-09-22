<?php
//Coba latihan delete sendiri koh
//CRUD agak kurang kalo insert doang :) 

session_start();
require_once 'db.php';

if(!isset($_SESSION['user'])){
    header('Location: login.php');
    exit();
}

if(isset($_GET['id'])){
    $fileId = $_GET['id'];
    $userId = $_SESSION['user']['id'];

    $q = "SELECT stored_name FROM files WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($q);
    $stmt->bind_param("ii", $fileId, $userId);
    $stmt->execute();
    $res = $stmt->get_result();

    if($res->num_rows > 0){
        $file = $res->fetch_assoc();

        $q = "DELETE FROM files WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($q);
        $stmt->bind_param("ii", $fileId, $userId);
        $stmt->execute();

        unlink('uploads/' . $file['stored_name']);
        header('Location: list.php');
        exit();
    }
}
else{
    header('Location: list.php');
    exit();
}