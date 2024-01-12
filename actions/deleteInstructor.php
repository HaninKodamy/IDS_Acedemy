<?php
require '../connection.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['instructor_id'])) {
    $instructorId = $_POST['instructor_id'];
    $checkSql = "SELECT id FROM instructors WHERE id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $instructorId);
    $checkStmt->execute();
    $checkStmt->store_result();
    if ($checkStmt->num_rows > 0) {
        $deleteSql = "DELETE FROM instructors WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $instructorId);
        if ($deleteStmt->execute()) {
            echo "Instructor deleted successfully!";
        } else {
            echo "Error: " . $deleteStmt->error;
        }
    } else {
        echo "Instructor not found.";
    }
    $checkStmt->close();
    $deleteStmt->close();
}
?>
