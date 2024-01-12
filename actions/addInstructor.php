<?php
require '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $position = $_POST['position'];

    $imagename=$_FILES['image']['name'];
    $file=$_FILES['image']['tmp_name'];
   
    if (move_uploaded_file($file,'../instructorsImages/' . $imagename)) {  

    $sql = "INSERT INTO instructors (fullName, email,position, image) VALUES (?, ?,?, ?)";
    $stmt = $conn->prepare($sql);
    
    
    $stmt->bind_param("ssss", $fullName, $email,$position, $imagename);

    if ($stmt->execute()) {
        echo "Instructor added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
}


?>