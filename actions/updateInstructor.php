<?php
require '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $instructorId = $_POST['instructorId'];
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $imagename = $_FILES['image']['name'];
    $file = $_FILES['image']['tmp_name'];
    if (move_uploaded_file($file, '../instructorsImages/' . $imagename)) {
        $sql = "UPDATE instructors SET fullName=?, email=?, image=?, position=? WHERE id=?";
        $stmt = $conn->prepare($sql);
    
        $stmt->bind_param("ssssi", $fullName, $email, $imagename, $position, $instructorId);

        if ($stmt->execute()) {
            echo "Instructor updated successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error uploading the image.";
    }
}
?>
