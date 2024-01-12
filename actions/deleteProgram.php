<?php
require '../connection.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['program_id'])) {
    $programId = $_POST['program_id'];
    $checkSql = "SELECT id FROM program WHERE id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $programId);
    $checkStmt->execute();
    $checkStmt->store_result();
    if ($checkStmt->num_rows > 0) {
        $deleteSql = "DELETE FROM program WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $programId);
        if ($deleteStmt->execute()) {
            echo "Program deleted successfully!";
        } else {
            echo "Error: " . $deleteStmt->error;
        }
    } else {
        echo "Program not found.";
    }
    $checkStmt->close();
    $deleteStmt->close();
}
?>
