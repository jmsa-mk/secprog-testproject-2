<?php
// ur mission is after create connection to database, you need to implement the following functionalities in this file:
// 1. Create a POST request to handle file upload form submission & validate the user session to ensure the user is authenticated before allowing file upload
// 2. Validate the uploaded file to ensure it meets the required criteria (e.g., file type, size limit)
// try to limit the file size to 5MB and only allow certain file types (e.g., PDF, DOCX, JPG, PNG)
// 3. Move the uploaded file to a designated directory on the server (e.g., "uploads/")
// 4. Store the file information (e.g., file name, size, upload date, user ID) in the database for future reference

session_start();
require_once 'db.php';

if(isset($_POST['submit'])){
    // var_dump($_FILES);
    // die();

    if($_FILES['fileUpload']['size'] > 5000000){
        $_SESSION['error'] = 'The maximum size of file is 5MB';
        header('Location: upload.php');
        exit();
    }

    $validExtension = ['jpg', 'png', 'docx', 'pdf'];
    $fileType = $_FILES['fileUpload']['type'];
    $fileExtension = explode('/', $fileType);
    $fileExtension = end($fileExtension);

    if(!in_array($fileExtension, $validExtension)){
        $_SESSION['error'] = 'Unsupported file type. Allowed formats: JPG, PNG, PDF, DOCX';
        header('Location: upload.php');
        exit();
    }

    echo 'gacor';

}