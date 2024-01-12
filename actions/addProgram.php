<?php
require '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $programCapacity = $_POST['programCapacity'];
    $classroomCode = $_POST['classroomCode'];
    $instructors = $_POST['instructors'];

    $imagename=$_FILES['image']['name'];
    $file=$_FILES['image']['tmp_name'];
    if (move_uploaded_file($file,'../programsImages/' . $imagename)) {  
        $sql = "INSERT INTO program (title, description, startDate, endDate, programCapacity, classroomCode, instructors, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssisss", $title, $description, $startDate, $endDate, $programCapacity, $classroomCode, $instructors, $imagename);
        if ($stmt->execute()) {
            echo "Program added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error uploading the image.";
    }
}


?>