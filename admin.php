<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="css/style2.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <title>Admin Panel - Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"> <a href="home.php"> <img src="https://academy.ids.com.lb/Main/images/ids-academy-logo.png"></img></a>
            </div>
            <div class="list-group list-group-flush my-3">
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text active"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-project-diagram me-2"></i>Programs</a>
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i class="fas fa-chart-line me-2"></i>Instructors</a>
                <a href="logout.php" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i class="fas fa-power-off me-2"></i>Logout</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Dashboard</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <?php
                        session_start();
                        require 'connection.php';

                        if (isset($_SESSION['isLoggedIn']) && isset($_SESSION['username'])) {
                            // User is not logged in, display the dropdown
                            $res_id = 0;
                            echo '<li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-person me-1"></i>';

                            $id = $_SESSION['id'];
                            $query = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");

                            while ($result = mysqli_fetch_assoc($query)) {
                                $res_username = $result['username'];
                                $res_email = $result['email'];
                                $res_id = $result['id'];
                            }

                            echo $res_username . '</a>
                                    <ul class="dropdown-menu mt-2" aria-labelledby="navbarDropdown">';

                            echo '<li><a class="dropdown-item" href="edit.php?id=' . $res_id . '">Change Profile</a></li>';
                            echo '<li><a class="dropdown-item" href="logout.php">Logout</a></li>';

                            echo '</ul>
                                </li>';
                        }
                        ?>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid px-4">
                <div class="row g-3 my-2" id="dashboard">
                    <div class="col-md-6">
                        <canvas id="programInternsChart"></canvas>
                        <!-- Button trigger modal -->
                    </div>
                </div>
                <div id="Programs-section" style="display: none;">
                    <div class="d-flex justify-content-end ">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                            <i class="fas fa-plus"></i> Add Program
                        </button>
                    </div>
                    <!-- Add Program Modal -->
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header d-flex align-items-center">
                                    <h5 class=" modalTitle">Add Program Form</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" id="programForm">


                                        <div class="form-group">
                                            <label for="title">Title:</label>
                                            <input type="text" class="form-control" id="title" name="title" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Description:</label>
                                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="startDate">Start Date:</label>
                                            <input type="date" class="form-control" id="startDate" name="startDate" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="endDate">End Date:</label>
                                            <input type="date" class="form-control" id="endDate" name="endDate" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="programCapacity">Program Capacity:</label>
                                            <input type="number" class="form-control" id="programCapacity" name="programCapacity" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="classroomCode">Classroom Code:</label>
                                            <input type="text" class="form-control" id="classroomCode" name="classroomCode" required>
                                        </div>

                                        <div class="form-group">
                                         <label for="instructorSelect">Select Instructor:</label>
                                            <select class="form-control" id="instructorSelect" name="instructors">
                              <?php
                              
                                  $sql = "SELECT id, fullName FROM instructors";
                                  $result = $conn->query($sql);
                                      while ($row = $result->fetch_assoc()) {
                                     $instructorId = $row['id'];
                                               $fullName = $row['fullName'];
                                       echo "<option value='$fullName'>$fullName</option>";
                                         }
                                                 ?>
                                         </select>
                                            </div>
                                        <div class="form-group">
                                            <label for="instructors">Upload Image</label>
                                            <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
                                        </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="submitButton" class="btn btn-primary">Submit</button>
                                </div>

                                </form>

                            </div>
                        </div>
                    </div>




                    <!-- update Program Modal -->
                    <div class="modal fade" id="updateModalCenter" tabindex="-1" role="dialog" aria-labelledby="updateModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header d-flex align-items-center">
                                    <h5 class=" modalTitle">Update Program Form</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeUpdateModal(this)">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" id="updateprogramForm">


                                        <div class="form-group">
                                            <label for="title">Title:</label>
                                            <input type="text" class="form-control" id="title" name="title" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Description:</label>
                                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="startDate">Start Date:</label>
                                            <input type="date" class="form-control" id="startDate" name="startDate" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="endDate">End Date:</label>
                                            <input type="date" class="form-control" id="endDate" name="endDate" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="programCapacity">Program Capacity:</label>
                                            <input type="number" class="form-control" id="programCapacity" name="programCapacity" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="classroomCode">Classroom Code:</label>
                                            <input type="text" class="form-control" id="classroomCode" name="classroomCode" required>
                                        </div>

                                        <div class="form-group">
                                         <label for="instructorSelect">Select Instructor:</label>
                                            <select class="form-control" id="instructorSelect" name="instructors">
                              <?php
                              
                                  $sql = "SELECT id, fullName FROM instructors";
                                  $result = $conn->query($sql);
                                      while ($row = $result->fetch_assoc()) {
                                     $instructorId = $row['id'];
                                               $fullName = $row['fullName'];
                                       echo "<option value='$fullName'>$fullName</option>";
                                         }
                                                 ?>
                                         </select>
                                            </div>
                                        <div class="form-group">
                                            <label for="instructors">Upload Image</label>
                                            <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
                                        </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="updateSubmitButton" class="btn btn-primary">Submit</button>
                                </div>

                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="row g-3 my-2">
                        <div class="col-md-12">

                            <?php
                            $sql = "SELECT * FROM program";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                echo '<div class="row">';

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<div class="col-md-4 program-card">';
                                    echo '<div class="card mb-3">';
                                
                                    // Add the image here
                                    echo '<img src="programsImages/' . $row['image'] . '" class="card-img-top" style="height: 180px;" alt="' . $row['title'] . '">';
                                
                                    echo '<div class="card-body">';
                                    echo '<h5 class="card-title">' . $row['title'] . '</h5>';
                                    echo '<p class="card-text">Description: ' . $row['description'] . '</p>';
                                    echo '<p class="card-text">Start Date: ' . $row['startDate'] . '</p>';
                                    echo '<p class="card-text">End Date: ' . $row['endDate'] . '</p>';
                                    echo '<p class="card-text">Program Capacity: ' . $row['programCapacity'] . '</p>';
                                    echo '<p class="card-text">Current Capacity: ' . $row['currentCapacity'] . '</p>';
                                    echo '<p class="card-text">Classroom Code: ' . $row['classroomCode'] . '</p>';
                                    echo '<p class="card-text">Instructors: ' . $row['instructors'] . '</p>';
                                    echo '<div class="d-flex justify-content-between">';
                                    echo '<button class="btn btn-warning btn-sm" data-program-id="' . $row['id'] . '" data-title="' . $row['title'] . '" data-description="' . $row['description'] . '" data-start-date="' . $row['startDate'] . '" data-end-date="' . $row['endDate'] . '" data-program-capacity="' . $row['programCapacity'] . '" data-classroom-code="' . $row['classroomCode'] . '" data-instructors="' . $row['instructors'] . '" onclick="openUpdateModal(this)"><i class="fas fa-edit"></i> Update</button>';
                                
                                    echo '<button class="btn btn-danger btn-sm" onclick="deleteProgram(' . $row['id'] . ')"><i class="fas fa-trash"></i> Delete</button>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                                
                                echo '</div>';
                                } else {
                                    echo 'No programs found.';
                                }
                            ?>
                        </div>
                    </div>
                </div>

                <div id="Instructors-section" style="display: none;">
                    <div class="d-flex justify-content-end ">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalCenter">
                            <i class="fas fa-plus"></i> Add Instructor
                        </button>
                    </div>
                    <!-- Add Instructor Modal -->
                    <div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header d-flex align-items-center">
                                    <h5 class=" modalTitle">Add Instructor Form</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" id="instructorForm">
                                        <div class="form-group">
                                            <label for="fullName">Full Name:</label>
                                            <input type="text" class="form-control" id="fullName" name="fullName" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input type="text" class="form-control" id="email" name="email" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="position">position:</label>
                                            <input type="text" class="form-control" id="position" name="position" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="instructors">Upload Image</label>
                                            <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
                                        </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="submitButton1" class="btn btn-primary">Submit</button>
                                </div>

                                </form>

                            </div>
                        </div>
                    </div>
                    <!-- update Instructor Modal -->
                    <div class="modal fade" id="updateModalCenter1" tabindex="-1" role="dialog" aria-labelledby="updateModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header d-flex align-items-center">
                                    <h5 class=" modalTitle">Update Instructor Form</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeUpdateModal1(this)">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" id="updateinstructorForm">
                                    <div class="form-group">
                                            <label for="fullName">Full Name:</label>
                                            <input type="text" class="form-control" id="fullName" name="fullName" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input type="text" class="form-control" id="email" name="email" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="position">position:</label>
                                            <input type="text" class="form-control" id="position" name="position" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="instructors">Upload Image</label>
                                            <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="updateSubmitButton1" class="btn btn-primary">Submit</button>
                                </div>

                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="row g-3 my-2">
                        <div class="col-md-12">

                            <?php
                            $sql = "SELECT * FROM instructors";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                echo '<div class="row">';

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<div class="col-md-4 program-card">';
                                    echo '<div class="card mb-3">';
                                    echo '<img src="instructorsImages/' . $row['image'] . '" class="card-img-top" style="height: 180px;">';
                                    echo '<div class="card-body">';
                                    echo '<h5 class="card-title">' . $row['fullName'] . '</h5>';

                                    echo '<p class="card-text">Email: ' . $row['email'] . '</p>';
                                    echo '<p class="card-text">Position: ' . $row['position'] . '</p>';
                                    echo '<div class="d-flex justify-content-between">';
                                    echo '<button class="btn btn-warning btn-sm" data-instructor-id="' . $row['id'] . '" data-email="' . $row['email'] . '" data-fullName="' . $row['fullName'] .'" onclick="openUpdateModal1(this)"><i class="fas fa-edit"></i> Update</button>';

                                    echo '<button class="btn btn-danger btn-sm" onclick="deleteInstructor(' . $row['id'] . ')"><i class="fas fa-trash"></i> Delete</button>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }

                                echo '</div>';
                            } else {
                                echo 'No instructor found.';
                            }
                            ?>
                        </div>
                    </div>
                </div>

            </div>
            <div id="Reports-section" style="display: none;">
                <h3>Reports</h3>
                <p>This is the Reports section.</p>
                <p>Reports data goes here.</p>
            </div>
        </div>
    </div>
    </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");
        var pageTitle = document.querySelector(".navbar h2");

        const dashboardLink = document.querySelector('.list-group-item.active');
        const programsLink = document.querySelector('.list-group-item:nth-child(2)');
        const instructorsLink = document.querySelector('.list-group-item:nth-child(3)');
        const reportsLink = document.querySelector('.list-group-item:nth-child(4)');
        const storeMngLink = document.querySelector('.list-group-item:nth-child(5)');
        const logoutLink = document.querySelector('.list-group-item.text-danger');



        toggleButton.onclick = function() {
            el.classList.toggle("toggled");
        };
        if (sessionStorage.getItem('section') == 'Programs') {
            document.getElementById("Programs-section").style.display = "block";
            pageTitle.textContent = "Programs";
            document.getElementById("dashboard").style.display = "none";
            document.getElementById("Reports-section").style.display = "none";
            programsLink.style.color = 'black';
            reportsLink.style.removeProperty('color');
            instructorsLink.style.removeProperty('color');

        } else if (sessionStorage.getItem('section') == 'Reports') {
            document.getElementById("Reports-section").style.display = "block";
            pageTitle.textContent = "Reports";
            document.getElementById("Programs-section").style.display = "none";
            document.getElementById("dashboard").style.display = "none";
            reportsLink.style.color = 'black';

        } else if (sessionStorage.getItem('section') == 'Instructors') {
            document.getElementById("Instructors-section").style.display = "block";
            pageTitle.textContent = "Instructors";
            document.getElementById("Programs-section").style.display = "none";
            document.getElementById("dashboard").style.display = "none";
            document.getElementById("Reports-section").style.display = "none";
            instructorsLink.style.color = 'black';
        }else if (sessionStorage.getItem('section') == 'Dashboard') {
            document.getElementById("Instructors-section").style.display = "none";
            pageTitle.textContent = "Dashboard";
            document.getElementById("Programs-section").style.display = "none";
            document.getElementById("dashboard").style.display = "block";
            document.getElementById("Reports-section").style.display = "none";
           // instructorsLink.style.color = 'black';
        }

        document.querySelector(".list-group").addEventListener("click", function(e) {
            if (e.target.tagName === "A") {

                document.getElementById("Programs-section").style.display = "none";
                document.getElementById("Instructors-section").style.display = "none";


                if (e.target.textContent === "Programs") {
                    document.getElementById("Programs-section").style.display = "block";
                    pageTitle.textContent = "Programs";
                    document.getElementById("dashboard").style.display = "none";
                    document.getElementById("Reports-section").style.display = "none";
                    sessionStorage.setItem('section', 'Programs')

                    reportsLink.style.removeProperty('color');
                    instructorsLink.style.removeProperty('color');



                } else if (e.target.textContent === "Instructors") {
                    document.getElementById("Instructors-section").style.display = "block";
                    pageTitle.textContent = "Instructors";
                    document.getElementById("Programs-section").style.display = "none";
                    document.getElementById("dashboard").style.display = "none";
                    document.getElementById("Reports-section").style.display = "none";
                    sessionStorage.setItem('section', 'Instructors')
                    reportsLink.style.removeProperty('color');
                    programsLink.style.removeProperty('color');
                } else if (e.target.textContent === "Reports") {
                    document.getElementById("Reports-section").style.display = "block";
                    pageTitle.textContent = "Reports";
                    document.getElementById("Programs-section").style.display = "none";
                    document.getElementById("dashboard").style.display = "none";
                    sessionStorage.setItem('section', 'Reports')
                    instructorsLink.style.removeProperty('color');
                    programsLink.style.removeProperty('color');
                } else {
                    document.getElementById("Programs-section").style.display = "none";
                    document.getElementById("Instructors-section").style.display = "none";
                    pageTitle.textContent = "Dashboard";
                    sessionStorage.setItem('section', 'Dashboard')
                    document.getElementById("dashboard").style.display = "block";

                }


            }
        });
        <?php
        $sql = "SELECT * FROM program";
        $result = mysqli_query($conn, $sql);
        $labels = [];
        $data = [];

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $labels[] = $row['title'];
                $data[] = $row['currentCapacity'];
            }
        }
        ?>

        const programData = {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: "Current Capacity",
                data: <?php echo json_encode($data); ?>,
                backgroundColor: "rgba(75, 192, 192, 0.2)",
                borderColor: "rgba(75, 192, 192, 1)",
                borderWidth: 1,
            }]
        };



        const programInternsCanvas = document.getElementById("programInternsChart").getContext("2d");


        const programInternsChart = new Chart(programInternsCanvas, {
            type: "bar",
            data: programData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 30
                    },
                },
            },
        });
        var selectedProgramId;

        function openUpdateModal(button) {
            // Extract program details from data attributes
            selectedProgramId = $(button).data("program-id");
            var title = $(button).data("title");
            var description = $(button).data("description");
            var startDate = $(button).data("start-date");
            var endDate = $(button).data("end-date");
            var programCapacity = $(button).data("program-capacity");
            var classroomCode = $(button).data("classroom-code");
            var instructors = $(button).data("instructors");

            // Populate the form fields in the update modal
            $("#updateprogramForm #title").val(title);
            $("#updateprogramForm #description").val(description);
            $("#updateprogramForm #startDate").val(startDate);
            $("#updateprogramForm #endDate").val(endDate);
            $("#updateprogramForm #programCapacity").val(programCapacity);
            $("#updateprogramForm #classroomCode").val(classroomCode);
            $("#updateprogramForm #instructors").val(instructors);

            // Show the update modal
            $("#updateModalCenter").modal("show");
        }

        function closeUpdateModal(button) {



            $("#updateModalCenter").modal("hide");
        }

        var selectedInstructorId;

        function openUpdateModal1(button) {
            // Extract program details from data attributes
            selectedInstructorId = $(button).data("instructor-id");
            var email = $(button).data("email");
            var fullName = $(button).data("fullName");
            var programsResponsibleFor = $(button).data("programsResponsibleFor");

            // Populate the form fields in the update modal
            $("#updateprogramForm1 #email").val(email);
            $("#updateprogramForm1 #fullName").val(fullName);
            $("#updateprogramForm1 #programsResponsibleFor").val(programsResponsibleFor);

            // Show the update modal
            $("#updateModalCenter1").modal("show");
        }

        function closeUpdateModal1(button) {



            $("#updateModalCenter1").modal("hide");
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <style>
        table {
            font-size: 13px;
        }

        th {
            white-space: nowrap;
        }
    </style>

    <script>
      $(document).ready(function() {
    $("#submitButton").click(function() {

        $(this).prop("disabled", true);

        var formData = new FormData($("#programForm")[0]);

        $.ajax({
            type: "POST",
            url: "actions/addProgram.php",
            data: formData,
            processData: false,
            contentType: false, 
            success: function(response) {
                alert(response);
                location.reload();

                $("#programForm")[0].reset();
                $("#submitButton").prop("disabled", false);
            },
            error: function(xhr, status, error) {
                alert("Error: " + xhr.responseText);
                $("#submitButton").prop("disabled", false);
            }
        });
    });
});
$(document).ready(function() {
    $("#submitButton1").click(function() {
        $(this).prop("disabled", true);

        var formData = new FormData($("#instructorForm")[0]);

        $.ajax({
            type: "POST",
            url: "actions/addInstructor.php",
            data: formData,
            processData: false, 
            contentType: false, 
            success: function(response) {
                alert(response);
                location.reload();

                $("#instructorForm")[0].reset();
                $("#submitButton1").prop("disabled", false);
            },
            error: function(xhr, status, error) {
                alert("Error: " + xhr.responseText);
                $("#submitButton1").prop("disabled", false);
            }
        });
    });
});

       
    </script>
    <script>
       $(document).ready(function() {
    $("#updateSubmitButton").click(function() {
        $(this).prop("disabled", true);

        var programId = selectedProgramId;
        var formData = new FormData($("#updateprogramForm")[0]);
        formData.append("programId", programId);

        $.ajax({
            type: "POST",
            url: "actions/updateProgram.php",
            data: formData,
            processData: false, 
            contentType: false,
            success: function(response) {
                alert(response);
                location.reload();
                $("#updateModalCenter").modal("hide");
            },
            error: function(xhr, status, error) {
                alert("Error: " + xhr.responseText);
                $("#updateSubmitButton").prop("disabled", false);
            }
        });
    });
});

$(document).ready(function() {
    $("#updateSubmitButton1").click(function() {
        $(this).prop("disabled", true);

        var instructorId = selectedInstructorId;
        var formData = new FormData($("#updateinstructorForm")[0]);
        formData.append("instructorId", instructorId);

        $.ajax({
            type: "POST",
            url: "actions/updateInstructor.php",
            data: formData,
            processData: false, 
            contentType: false, 
            success: function(response) {
                alert(response);
                location.reload();
                $("#updateModalCenter1").modal("hide");
            },
            error: function(xhr, status, error) {
                alert("Error: " + xhr.responseText);
                $("#updateSubmitButton1").prop("disabled", false);
            }
        });
    });
});



        function deleteProgram(programId) {
            if (confirm("Are you sure you want to delete this program?")) {
                $.ajax({
                    type: "POST",
                    url: "actions/deleteProgram.php",
                    data: {
                        program_id: programId
                    },
                    success: function(response) {
                        alert(response);
                        location.reload()
                    },
                    error: function(xhr, status, error) {
                        alert("Error: " + xhr.responseText);
                    }
                });
            }
        }

        function deleteInstructor(instructorId) {
            if (confirm("Are you sure you want to delete this instructor?")) {
                $.ajax({
                    type: "POST",
                    url: "actions/deleteInstructor.php",
                    data: {
                        instructor_id: instructorId
                    },
                    success: function(response) {
                        alert(response);
                        location.reload()
                    },
                    error: function(xhr, status, error) {
                        alert("Error: " + xhr.responseText);
                    }
                });
            }
        }
    </script>

</body>

</html>