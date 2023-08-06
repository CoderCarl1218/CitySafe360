<!DOCTYPE html>
<html lang="en">
<!--divinectorweb.com-->

<head>
    <?php
    session_start();
    include('admin/db_connect.php');
    ?>
    <?php
    require 'admin/db_connect.php';
    if (!empty($_SESSION["id"])) {
        $id = $_SESSION["id"];
        $result = mysqli_query($conn, "SELECT * FROM complainants WHERE id = $id");
        $row = mysqli_fetch_assoc($result);

        $fullName = $row["name"];
        $firstName = explode(" ", $fullName)[0];

    } else {
        header("Location: index.php");
    }
    ?>

    <meta charset="UTF-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>CitySafe360</title>
    <!-- All CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- JAVASCRIPT -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    <!-- Bootstrap CSS (Replace with correct path if needed) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Font Awesome Icons (Replace with correct path if needed) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Bootstrap JS (Place before the closing body tag) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link href="./css/style.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><span class="text-warning">CitySafe</span>360</a> <button
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
                class="navbar-toggler" data-bs-target="#navbarSupportedContent" data-bs-toggle="collapse"
                type="button"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Emergency Tips</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Latest Update</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="my_reports.php">My Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">
                            Welcome <span style="color: red;">
                                <?php echo $firstName ?> !
                            </span>
                        </a>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user"></i> </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accountDropdown">
                            <!-- Add links for managing the account (e.g., profile, settings, etc.) -->
                            <!-- ... -->
                            <a class="dropdown-item" href="manageaccount.php">Manage Account</a>
                            <a class="dropdown-item" href="logout.php">Logout</a>

                        </div>

                    </li>

                </ul>
            </div>
        </div>
        <script>
            // Initialize Bootstrap dropdowns
            $(document).ready(function () {
                $('.dropdown-toggle').dropdown();
            });
        </script>

    </nav>

    </div><!-- about section starts -->
    <?php
    // Step 1: Include the database connection file
    require_once "admin/db_connect.php";

    // Step 2: Check if the user is logged in (i.e., user ID is stored in the session)
    session_start();
    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];

        // Step 3: Build the SQL query with a JOIN to retrieve user and complaint data
        $sql = "SELECT c.date_created, c.message, c.incident_address, c.status, u.name, u.email
                FROM complaints c
                INNER JOIN complainants u ON c.complainant_id = u.id
                WHERE c.complainant_id = $user_id"; // Replace "complaints" with your actual table names
    
        $result = mysqli_query($conn, $sql);

        // Step 4: Display the data in the table
        ?>
        <section class="about section-padding" id="tips ">
            <div class="container">
                <h5>List of Reports</h5>
                <div class="col-lg-12 fr-wrapper" id="">
                    <table class="table table-bordered table-hover" id="complaint-tbl">
                        <thead>
                            <tr>
                                <th width="20%">Date</th>
                                <th width="30%">Report</th>
                                <th width="30%">Incident Address</th>
                                <th width="10%">Status</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Check if there is data to display
                            if (mysqli_num_rows($result) > 0) {
                                // Loop through the result and display data in the table
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['date_created'] . "</td>";
                                    echo "<td>" . $row['message'] . "</td>";
                                    echo "<td>" . $row['incident_address'] . "</td>";
                                    echo "<td>" . $row['status'] . "</td>";
                                    $status_label = '';
                                    $status_class = ''; // Variable to store the CSS class for status
                                    switch ($row['status']) {
                                        case 1:
                                            $status_label = 'Pending';
                                            $status_class = 'status-pending';
                                            break;
                                        case 2:
                                            $status_label = 'Received';
                                            $status_class = 'status-received';
                                            break;
                                        case 3:
                                            $status_label = 'Done';
                                            $status_class = 'status-done';
                                            break;
                                        default:
                                            $status_label = 'Unknown';
                                            break;
                                    }
                                    echo "<td class='$status_class'>" . $status_label . "</td>";


                                    echo "</tr>";
                                }
                            } else {
                                // Display a message if there is no data to show
                                echo "<tr><td colspan='4'>No records found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
    } else {
        // If the user is not logged in, handle the appropriate action (e.g., redirect to the login page)
        // or display a message encouraging them to log in.
    }
    ?>

        </div>
        <style>
            .status-pending {
                color: orange;
                font-weight: bold;
            }

            .status-received {
                color: green;
                font-weight: bold;
            }

            .status-done {
                color: blue;
                font-weight: bold;
            }
        </style>

    </section><!-- about section Ends -->
    <!-- portfolio strats -->
    <section class="portfolio section-padding" id="portfolio">
        <div class="container">
            <div class="row">
                <div class="col-md-15">
                    <div class="section-header text-center pb-2	">
                        <h2>Latest News</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card text-light text-center bg-white pb-2">
                        <div class="card-body text-dark">
                            <div class="img-area mb-4"><img alt="" class="img-fluid" src="img/fire.jpg"></div>
                            <h3 class="card-title">Fire Update</h3>
                            <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci eligendi
                                modi temporibus alias iste. Accusantium?</p><button
                                class="btn bg-warning text-dark">Learn
                                More</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card text-light text-center bg-white pb-2">
                        <div class="card-body text-dark">
                            <div class="img-area mb-4"><img alt="" class="img-fluid" src="img/typhoon.jpg"></div>
                            <h3 class="card-title">Typhoon Alona</h3>
                            <p class="lead">In Capiz, Philippines, the powerful typhoon "Commander
                                Alona" made
                                landfall,
                                causing devastation as homes and infrastructure were ravaged. Yet, the indomitable
                                spirit of the Capizeños emerged, as they united, rebuilt, and faced the future with
                                courage, inspired by the memory of the legendary female warrior the typhoon was named
                                after.</p><button class="btn bg-warning text-dark">learn More</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card text-light text-center bg-white pb-2">
                        <div class="card-body text-dark">
                            <div class="img-area mb-4"><img alt="" class="img-fluid" src="img/flood.jpg"></div>
                            <h3 class="card-title">Flood Update</h3>
                            <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci eligendi
                                modi temporibus alias iste. Accusantium?</p><button
                                class="btn bg-warning text-dark">Learn
                                More</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- portfolio ends -->


    <!-- footer starts -->
    <footer class="bg-dark p-2 text-center">
        <div class="container">
            <p class="text-white">All Right Reserved By @CAPSTONESHIT2023</p>
        </div>
    </footer>
    <!-- footer ends -->




    <!-- All Js -->
    <script src="js/bootstrap.bundle.min.js"></script>


</body>

</html>