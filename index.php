<?php
session_start();

include("connection.php");

if (isset($_SESSION['username'])) {
  $_SESSION['loggedin'] = true;
}
try {

  $query = "SELECT title FROM home WHERE id = 1";
  $result = $conn->query($query);
  $row = $result->fetch_assoc();
  $title = $row['title'];

  $query = "SELECT quote FROM home WHERE id = 1";
  $result = $conn->query($query);
  $row = $result->fetch_assoc();
  $quote = $row['quote'];

  $query = "SELECT aboutus FROM home WHERE id = 1";
  $result = $conn->query($query);
  $row = $result->fetch_assoc();
  $aboutus = $row['aboutus'];
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}
?>




<!doctype html>
<html lang="en-US">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

 
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

 
  <link rel="stylesheet" href="css/style.css" type="text/css" />


  <link href="https://unpkg.com/ionicons@4.2.0/dist/css/ionicons.min.css" rel="stylesheet">


  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">

  <title>IDS Academy</title>
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
            if (!isset($_SESSION['isloggedin']) && !isset($_SESSION['username'])) {
             
              echo '<li class="nav-item">
              <a class="nav-link" href="login.php">LogIn</a>
            </li>';
            }
            ?>
            <?php
            if (isset($_SESSION['isLoggedIn']) && isset($_SESSION['username'])) {
             
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

  <!-- E N D  N A V B A R -->
  <?php
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['username'])) {
    echo '<div class="name" style="background-color: #70b2de!important;color: white!important;">
            <center>Welcome ' . $_SESSION['username'] . '!</center>
        </div>';
  }
  ?>


  <!-- H O M E -->
  <section id="hero">
    <div class="container">
      <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5" style="margin-top: 50px!important;">
          <img src="images/home.png" class="img-fluid" alt="Demo image">
        </div>
        <div class="col-md-7 content-box hero-content">
          <span>New Program</span>
          <h1><?php echo $title; ?></h1>
          <p><?php echo $quote; ?></p>
          <a href="programs.php" class="btn btn-regular">Apply Now</a>
        </div>
      </div>
    </div>
  </section>
  <!-- E N D  H O M E -->

  <!-- A B O U T   U S -->
  <section id="aboutUs">
    <div class="container">
      <div class="row">
        <div class="col-md-5">
          <div class="content-box" style="margin-top: 50px!important;">
            <span>About Us</span>
            <h2>IDS Acedamy</h2>
            <p><?php echo $aboutus; ?></p>
            <a href="aboutus.php" class="btn btn-regular">Learn More</a>
          </div>
        </div>
        <div class="col-md-7">
          <img src="images/about.jpeg" class="img-fluid" alt="Demo image">
        </div>
      </div>
    </div>
  </section>
  <!-- E N D  A B O U T   U S -->

  <section id="testimonials">
    <div class="container">
      <div class="title-block">
        <h2>Top agencies have endorsed our company</h2>
        <p>Highlighting their experiences and the exceptional outcomes they've achieved.</p>
      </div>
      <div id="testimonial-carousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#testimonial-carousel" data-slide-to="0" class="active"></li>
          <li data-target="#testimonial-carousel" data-slide-to="1"></li>
          <!-- Add more carousel indicators as needed -->
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="testimonial-box">
              <div class="row personal-info">
                <div class="col-md-2 col-xs-2">
                  <div class="profile-picture review-one" style="background-image: url('images/mokhtar.png')!important;"></div>
                </div>
                <div class="col-md-10 col-xs-10">
                  <h6>Makhateer<span class="rating">5 <i class="icon ion-md-star"></i></span></h6>
                  <small>Cooperative Fund of <b>Makhateer</b></small>
                </div>
              </div>
              <p>We're satisfied dealing with IDS; being a company with good experience and excellent reputation in the industry, and delivering to us the recommended output.
                The most satisfying aspects about their work are: professionalism in communication, organized behavior, and user-friendly technologies usage.</p>
            </div>
          </div>
          <div class="carousel-item">
            <div class="testimonial-box">
              <div class="row personal-info">
                <div class="col-md-2 col-xs-2">
                  <div class="profile-picture review-two" style="background-image: url('images/undp.jpeg')!important;"></div>
                </div>
                <div class="col-md-10 col-xs-10">
                  <h6>UNDP-Iraq<span class="rating">5 <i class="icon ion-md-star"></i></span></h6>
                  <small>Ministry of Interior and <b>UNDP- Iraq</b></small>
                </div>
              </div>
              <p>We can describe our experience with IDS as very good. They have the required ability to deliver the service on time and they are eager to share their technical advice when necessary, and they have the flexibility to deal with the changes of our requests.
                The most satisfying aspect is their customer service and their availability to offer the required support that reflects positively on the quality of delivered service.</p>
            </div>
          </div>
          <!-- Add more carousel items as needed -->
          <div class="carousel-item">
            <div class="testimonial-box">
              <div class="row personal-info">
                <div class="col-md-2 col-xs-2">
                  <div class="profile-picture review-three" style="background-image: url('images/person.png')!important;"></div>
                </div>
                <div class="col-md-10 col-xs-10">
                  <h6>Hassan Alaeddine<span class="rating">5 <i class="icon ion-md-star"></i></span></h6>
                  <small>Financial and Operational Manager, <b>Yaras International</b></small>
                </div>
              </div>
              <p>I always recommend IDS company, and LIBRA in particular, to my acquaintances because, after 10 years of experience, the result remained awesome and the treatment remained excellent.</p>
            </div>
          </div>
          <div class="carousel-item">
            <div class="testimonial-box">
              <div class="row personal-info">
                <div class="col-md-2 col-xs-2">
                  <div class="profile-picture review-three" style="background-image: url('images/person.png')!important;"></div>
                </div>
                <div class="col-md-10 col-xs-10">
                  <h6>Cynthia Esber<span class="rating">5 <i class="icon ion-md-star"></i></span></h6>
                  <small>Managing Director, <b>Tania Health</b></small>
                </div>
              </div>
              <p>The customer support team at
                IDS is always ready to answer our calls and to visit us no matter how simple the reasons are.
                Libra saved me time and cost and gave me a clear and guaranteed result. I enjoyed working with IDS because I'm sure that no matter how much my work expands, Libra will be able to fulfill all my needs without any problem.</p>
            </div>
          </div>
          <div class="carousel-item">
            <div class="testimonial-box">
              <div class="row personal-info">
                <div class="col-md-2 col-xs-2">
                  <div class="profile-picture review-three" style="background-image: url('images/person.png')!important;"></div>
                </div>
                <div class="col-md-10 col-xs-10">
                  <h6>Hasan Hashem<span class="rating">5 <i class="icon ion-md-star"></i></span></h6>
                  <small>Project Manager of <b>Nahno, UNICEF</b></small>
                </div>
              </div>
              <p>We worked with a highly professional company. Since the beginning and throughout the project life cycle, IDS team approached us with international standards.
                The implementation of the application was very professional. The team's professional project management and development skills resulted in the success we reached;
                because without the structure they offered, from planning till monitoring, we wouldn't have reached this successful moment with a flawless platform and an excellent relationship.</p>
            </div>
          </div>
          <div class="carousel-item">
            <div class="testimonial-box">
              <div class="row personal-info">
                <div class="col-md-2 col-xs-2">
                  <div class="profile-picture review-three" style="background-image: url('images/person.png')!important;"></div>
                </div>
                <div class="col-md-10 col-xs-10">
                  <h6>Lina Haidar<span class="rating">5 <i class="icon ion-md-star"></i></span></h6>
                  <small>Creative Director</small>
                </div>
              </div>
              <p>This step was all about keeping up with the trendiest designs and sending the right visual message to our target audience. We kept our identity free to adapt to all platforms and we created flexible guidelines that convey our modern innovative image.</p>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#testimonial-carousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#testimonial-carousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
  </section>

  <!-- E N D  T E S T I M O N I A L S -->

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

</body>

</html>