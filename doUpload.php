<?php
// ur mission is after create connection to database, you need to implement the following functionalities in this file:
// 1. Create a POST request to handle file upload form submission & validate the user session to ensure the user is authenticated before allowing file upload
// 2. Validate the uploaded file to ensure it meets the required criteria (e.g., file type, size limit)
// try to limit the file size to 5MB and only allow certain file types (e.g., PDF, DOCX, JPG, PNG)
// 3. Move the uploaded file to a designated directory on the server (e.g., "uploads/")
// 4. Store the file information (e.g., file name, size, upload date, user ID) in the database for future reference

session_start();
require_once 'db.php';

if(!isset($_SESSION['user'])){
    header('Location: login.php');
    exit();
}

if(isset($_POST['submit'])){
    // var_dump($_FILES);
    // die();

    $fileName = $_FILES['fileUpload']['name'];
    $fileTemp = $_FILES['fileUpload']['tmp_name'];
    $fileSize = $_FILES['fileUpload']['size'];

    if($fileSize > 5 * 1024 * 1024){
        $_SESSION['error'] = 'The maximum size of file is 5MB';
        header('Location: upload.php');
        exit();
    }

    $validExtension = ['jpg', 'png', 'docx', 'pdf'];
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if(!in_array($fileType, $validExtension)){
        $_SESSION['error'] = 'Only JPG, PNG, PDF, DOCX file types are allowed';
        header('Location: upload.php');
        exit();
    }

    $storedName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $fileType;
    move_uploaded_file($fileTemp, 'uploads/' . $storedName);

    $userId = $_SESSION['user']['id'];

    $q = "INSERT INTO files (user_id, original_name, stored_name, file_size, file_type) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($q);
    $stmt->bind_param("issis", $userId, $fileName, $storedName, $fileSize, $fileType);
    $stmt->execute();

    header('Location: list.php');
    exit();
}
else{
    header('Location: index.php');
    exit();
}