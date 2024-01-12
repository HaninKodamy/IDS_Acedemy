<?php
session_start();

include("connection.php");
if (!isset($_SESSION['loggedin']) && !isset($_SESSION['id'])) {
  header("location: login.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

  <!-- Custom Css -->
  <link rel="stylesheet" href="css/style.css" type="text/css" />

  <!-- Ionic icons -->
  <link href="https://unpkg.com/ionicons@4.2.0/dist/css/ionicons.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
  <title>Programs</title>


</head>

<body>
  <header class="navbar-section">
    <nav class="navbar navbar-expand-lg">
      <div class="container-fluid">
        <img src="images/ids-academy-logo.png" class="img-fluid nav-logo-desktop" alt="Company Logo">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="aboutus.php">About us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="programs.php">Programs</a>
            </li>
            <?php
            if (!isset($_SESSION['loggedin']) && !isset($_SESSION['username'])) {

              echo '<li class="nav-item">
              <a class="nav-link" href="login.php">LogIn</a>
            </li>';
            }
            ?>
            <?php
            if (isset($_SESSION['loggedin']) && isset($_SESSION['username'])) {
              // User is not logged in, display the dropdown
              $res_id = 0;
              echo '<li class="nav-item">
              <a class="nav-link" href="myPrograms.php">My Programs</a>
            </li>';
              echo '<li class="nav-item">
            <div class="dropdown">
                <a class="nav-link dropdown-toggle" href="edit.php?id=' . $res_id . '" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person"></i>
                </a>
                <ul class="dropdown-menu mt-2 mr-0" aria-labelledby="dropdownMenuLink">
                    <li>';

              $id = $_SESSION['id'];
              $query = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");

              while ($result = mysqli_fetch_assoc($query)) {
                $res_username = $result['username'];
                $res_email = $result['email'];
                $res_id = $result['id'];
              }

              echo '<a class="dropdown-item" href="edit.php?id=' . $res_id . '">Change Profile</a>';

              echo '</li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </li>';
            }
            ?>

          </ul>
        </div>
      </div>
    </nav>
  </header>



  <div class="container-fluid py-5">
    <div class="row">
      <?php
      $isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
      $query = "SELECT p.*
            FROM program p
            JOIN intern si ON p.id = si.program_id
            WHERE si.userId =$id";
      $result = mysqli_query($conn, $query);

      if (mysqli_num_rows($result) == 0) {
        echo "<td>You  are not registered in any program.</td>";
      } else {
        while ($row = mysqli_fetch_assoc($result)) {
          $title = $row['title'];
          $desc = $row['description'];
          $startDate = $row['startDate'];
          $endDate = $row['endDate'];
          $classRoomCode = $row['classroomCode'];
          $instructors = $row['instructors'];


          echo '<div class="col-12 col-md-4">
                            <div class="card mb-3">
                                <img class="card-img-top" style="height:210px" src="programsImages/' . $row['image'] . '" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">' . $title . '</h5>
                                    <p class="card-text">' . $desc . '</p>
                                    <p class="card-text">Start Date: <small class="text-muted">' . $startDate . '</small>&nbsp;&nbsp;&nbsp;&nbsp;End Date: <small class="text-muted">' . $endDate . '</small></p>
                                    <p class="card-text">Class Room Code: ' . $classRoomCode . '</p>
                                    <p class="card-text">Instructors: ' . $instructors . '</p>
                                </div>
                            </div>
                        </div>';
        }
      }
      ?>
    </div>
  </div>





  <script>
    function confirmApplication() {
      if (<?php echo $currentCapacity; ?> >= <?php echo $programCapacity; ?>) {
        alert("No Enough Spaces!");
        return false;
      }
      return true;
    }
  </script>



  <!--  F O O T E R  -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h5>Contact Info</h5>
          <ul>
            <li><a class="link-footer btn-icon-gray-100 text-spacing-bg-active-opacity-75 font-sec" href="tel:#">
                <i class="fas fa-phone"></i> (+961) 1859501/2/3/4</a></li>
            <li><a class="link-footer btn-icon-gray-100 text-spacing-bg-active-opacity-75 font-sec" href="mailto:info@ids.com.lb">
                <i class="fas fa-envelope"></i> info@ids.com.lb
              </a></li>
            <li><a class="link-footer btn-icon-gray-100 text-spacing-bg-active-opacity-75 font-sec" href="https://www.ids.com.lb/">
                <i class="fas fa-globe"></i> Integrated Digital Systems
              </a></li>
          </ul>
        </div>
        <div class="col-md-6">
          <h5>Company Address</h5>
          <a class="link-footer btn-icon-gray-100 text-spacing-bg-active-opacity-75 font-sec blue-icon" href="https://goo.gl/maps/CmNKC3yz3NV1LweJ8">
            <i class="fas fa-map-marker-alt"></i> Beirut, Bir Hassan, United Nations St. Al-Zahra Bldg
          </a>
        </div>
      </div>
      <div class="divider"></div>
      <div class="row">
        <div class="col-md-6 col-xs-12">
          <a href="https://www.facebook.com/IDS.com.lb/"><i class="icon ion-logo-facebook"></i></a>
          <a href="https://www.instagram.com/idssolutions/?hl=en"><i class="icon ion-logo-instagram"></i></a>
          <a href="https://twitter.com/_ids_?lang=en"><i class="icon ion-logo-twitter"></i></a>
        </div>
        <div class="col-md-6 col-xs-12">
          <small>Copyright © 2023 | Integrated Digital Systems - IDS</small>
        </div>
      </div>
    </div>
  </footer>
  <!--  E N D  F O O T E R  -->


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>