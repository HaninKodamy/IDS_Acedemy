<?php
require '../connection.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $programId = $_POST['programId'];
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
    $sql = "UPDATE program SET title=?, description=?, startDate=?, endDate=?, programCapacity=?, classroomCode=?, instructors=? ,image=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssisssi", $title, $description, $startDate, $endDate, $programCapacity, $classroomCode, $instructors,$imagename, $programId);
    if ($stmt->execute()) {
        echo "Program updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
}
?>
