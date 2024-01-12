<?php
require '../connection.php';
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $full_name = $_POST["full_name"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $university = $_POST["university"];
  $major = $_POST["major"];
  $programId = $_POST["program_id"];
  $userId = $_SESSION['id'];

  $checkQuery = "SELECT * FROM intern WHERE userId='$userId' and program_id='$programId'";
  $result = mysqli_query($conn, $checkQuery);

  if (mysqli_num_rows($result) > 0) {
    echo "You are Already registered in this program";
  } else {
    $checkQuery = "SELECT * FROM program where id='$programId'";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      if ($row['programCapacity'] > $row['currentCapacity']) {
        $cv_filename = $_FILES["cv"]["name"];
        $cv_tmp = $_FILES["cv"]["tmp_name"];
        $upload_directory = "uploads/";

        if (!file_exists($upload_directory)) {
          mkdir($upload_directory, 0777, true);
        }

        move_uploaded_file($cv_tmp, $upload_directory . $cv_filename);


        $sql = "INSERT INTO intern (userId,fullName, gmail, mobileNumber, university, major, cv,program_id) VALUES (?,?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $userId, $full_name, $email, $phone, $university, $major, $cv_filename, $programId);

        if ($stmt->execute()) {

          echo "Application submitted successfully!";


          $sql_update = "UPDATE program SET currentCapacity = currentCapacity + 1 WHERE id = $programId";
          $stmt_update = $conn->prepare($sql_update);
          if ($stmt_update->execute()) {
          } else {
            echo "Error updating current capacity: " . $stmt_update->error;
          }
        } else {
          echo "Error: " . $stmt->error;
        }

        $stmt->close();

        $conn->close();
      } else {
        echo "the program capacity is full";
      }
    } else {
      echo "no program found";
    }
  }
}
