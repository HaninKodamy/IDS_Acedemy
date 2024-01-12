<?php
session_start();

$error = '';
$passwordError = '';

if (isset($_POST['login'])) {
  include "connection.php"; 

  $email = $_POST['email'];
  $pass = $_POST['password'];

  $sql = "SELECT * FROM users WHERE email=?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, 's', $email);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($row = mysqli_fetch_assoc($result)) {
    $passwordHash = $row['password'];

    if (password_verify($pass, $passwordHash)) {
      $_SESSION['id'] = $row['id'];
      $_SESSION['username'] = $row['username'];
      $_SESSION['isLoggedIn'] = true;
      $isAdmin = $row['isAdmin'];
      if ($isAdmin == 1)
        header("location: admin.php");
      else
        header("location: index.php");
      exit;
    } else {
      $passwordError = "Password is incorrect";
    }
  } else {
    $error = "Wrong Email or Password";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/style3.css" rel="stylesheet">
  <!-- Ionic icons -->
  <link href="https://unpkg.com/ionicons@4.2.0/dist/css/ionicons.min.css" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

  <!-- Custom Css -->
  <link rel="stylesheet" href="css/style.css" type="text/css" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
  <title>Login</title>

  <!-- Add style for red error text -->
  <style>
    .error-text {
      color: red;
    }
  </style>
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

          </ul>
        </div>
      </div>
    </nav>
  </header>

  <section class="form-02-main">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="_lk_de">
            <div class="form-03-main">
              <div class="logo">
                <img src="images/user.png">
              </div>
              <form action="" method="POST">
                <div class="form-group">
                  <input type="email" name="email" class="form-control _ge_de_ol" placeholder="Enter Email" required>
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control _ge_de_ol <?php echo (!empty($passwordError) ? 'error-text' : ''); ?>" placeholder="Enter Password" required>
                  <?php
                  if (!empty($passwordError)) {
                    echo '<p class="error-text">' . $passwordError . '</p>';
                  }
                  ?>
                </div>
                <div class="checkbox form-group">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="">
                    <label class="form-check-label" for="">
                      Remember me
                    </label>
                  </div>
                  <a href="#" style="text-decoration: none;">Forgot Password</a>
                </div>
                <div class="form-group">
                  <div class="_btn_04">
                    <button type="submit" name="login" class="btn" style="color:white;">Login</button>
                  </div>
                </div>
                <div class="links">
                  Don't have an account? <a href="signup.php" style="text-decoration: none;">Signup Now</a>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
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


  <!-- External JavaScripts -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <script>
    const toggle = document.querySelector(".toggle"),
      input = document.querySelector(".password");
    toggle.addEventListener("click", () => {
      if (input.type === "password") {
        input.type = "text";
        toggle.classList.replace("fa-eye-slash", "fa-eye");
      } else {
        input.type = "password";
      }
    })
  </script>
</body>

</html>