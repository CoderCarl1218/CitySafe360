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
						<a class="nav-link" href="#">Home</a>
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
	<div class="carousel slide" data-bs-ride="carousel" id="carouselExampleIndicators">
		<div class="carousel-indicators">
			<button aria-label="Slide 1" class="active" data-bs-slide-to="0" data-bs-target="#carouselExampleIndicators"
				type="button"></button> <button aria-label="Slide 2" data-bs-slide-to="1"
				data-bs-target="#carouselExampleIndicators" type="button"></button> <button aria-label="Slide 3"
				data-bs-slide-to="2" data-bs-target="#carouselExampleIndicators" type="button"></button>
		</div>
		<div class="carousel-inner">
			<div class="carousel-item active">
				<img alt="..." class="d-block w-100" src="img/emer2.jpg">
				<div class="carousel-caption">
					<h5>CitySafe360</h5>
					<p>A Roxas City Incident and Emergency Response Reporting Platform</p>
					<!-- Button to trigger the modal -->
					<p>
						<a class="btn btn-warning mt-3" href="#" id="report-incident-btn">Report an Incident</a>
					</p>

					<!-- The Modal -->
					<div class="modal" id="reportModal">
						<form method="post" action="#" enctype="multipart/form-data">
							<div class="modal-content">
								<h2>Report an Incident</h2>
								<label for="reportMessage">Report Message:</label>
								<textarea id="reportMessage" name="reportMessage" rows="4" cols="50"
									placeholder="Enter your report message" required></textarea>
								<label for="incidentAddress">Incident Address:</label>
								<input type="text" id="incidentAddress" name="incidentAddress"
									placeholder="Enter incident address" required>
								<label for="attachment">Upload Files (Optional)</label>
								<input type="file" id="attachment" name="attachment" accept=".jpg, .jpeg, .png, .pdf">
								<br>
								<div class="custom-btn-container">
									<button type="submit" class="custom-btn btn btn-primary" id="submitReport"
										name="submit">Submit</button>
								</div>
							</div>
						</form>
						<?php
						// Initialize the success message and error message variables
						$successMessage = "";
						$errorMessage = "";

						// Check if the form was submitted
						if ($_SERVER["REQUEST_METHOD"] == "POST") {
							// Include the database connection
							require_once 'admin/db_connect.php';

							// Assuming you have a user session with a user ID
							// Replace 'user_id' with the actual session variable storing the user ID
							$complainant_id = $_SESSION['id'];

							// Get the form data and sanitize it
							$reportMessage = mysqli_real_escape_string($conn, $_POST["reportMessage"]);
							$incidentAddress = mysqli_real_escape_string($conn, $_POST["incidentAddress"]);



							if ($_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
								$image_data = file_get_contents($_FILES['attachment']['tmp_name']);
								$image_name = $_FILES['attachment']['name'];
								$image_type = $_FILES['attachment']['type'];
							} else {
								// If no image is uploaded, set default values for image fields
								$image_data = null;
								$image_name = "";
								$image_type = "";
							}

							// Insert the form data into the database, including image data and user ID
							$sql = "INSERT INTO complaints (complainant_id, message, incident_address, date_created, status, image_data, image_name, image_type) 
            VALUES (?, ?, ?, NOW(), 1, ?, ?, ?)";

							$stmt = $conn->prepare($sql);
							$stmt->bind_param("isssss", $complainant_id, $reportMessage, $incidentAddress, $image_data, $image_name, $image_type);

							if ($stmt->execute()) {
								$successMessage = "Report submitted successfully!";
							} else {
								$errorMessage = "Error: " . $conn;
							}

							// Close the database connection
							$stmt->close();
							$conn->close();
						}
						?>


						<script>
							// Display success and error messages using JavaScript alerts
							<?php if (!empty($successMessage)) { ?>
								alert("<?php echo $successMessage; ?>");
							<?php } ?>

							<?php if (!empty($errorMessage)) { ?>
								alert("<?php echo $errorMessage; ?>");
							<?php } ?>
						</script>
					</div>
				</div>
			</div>






			<div class="carousel-item">
				<img alt="..." class="d-block w-100" src="img/emer2.jpg">
				<div class="carousel-caption">
					<h5>CitySafe360</h5>
					<p>A Roxas City Incident and Emergency Response Reporting Platform</p>
					<p>
						<a class="btn btn-warning mt-3" href="#" id="report-incident-btn">Report an Incident</a>
					</p>

				</div>
			</div>
			<div class="carousel-item">
				<img alt="..." class="d-block w-100" src="img/emer.jpg">
				<div class="carousel-caption">
					<h5>CitySafe360</h5>
					<p>A Roxas City Incident and Emergency Response Reporting Platform</p>
					<p><a class="btn btn-warning mt-3" href="#" id="report-incident-btn">Report an Incident</a></p>
				</div>
			</div>
		</div><button class="carousel-control-prev" data-bs-slide="prev" data-bs-target="#carouselExampleIndicators"
			type="button"><span aria-hidden="true" class="carousel-control-prev-icon"></span> <span
				class="visually-hidden">Previous</span></button> <button class="carousel-control-next"
			data-bs-slide="next" data-bs-target="#carouselExampleIndicators" type="button"><span aria-hidden="true"
				class="carousel-control-next-icon"></span> <span class="visually-hidden">Next</span></button>



	</div><!-- about section starts -->
	<section class="about section-padding" id="tips">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-12 col-12">
					<div class="about-img"><img alt="" class="img-fluid" src="img/emer4.png"></div>
				</div>
				<div class="col-lg-8 col-md-12 col-12 ps-lg-5 mt-md-5">
					<div class="about-text">
						<h2>"Stay Safe During a Fire: Essential General Safety Tips to Remember"<br></h2>
						<p>In the event of a fire, knowing how to protect yourself and your loved ones is of utmost
							importance. Fires can spread rapidly and pose serious risks to life and property.
							Understanding and practicing general safety tips can make a significant difference in your
							ability to respond effectively during such emergencies.</p><a class="btn btn-warning"
							href="#">Show More</a>
					</div>
				</div>
			</div>
		</div>
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
	<style>
		.modal {
			display: none;
			position: fixed;
			z-index: 1;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			overflow: auto;
			background-color: rgba(0, 0, 0, 0.4);
		}

		.modal h2 {
			color: red;
		}

		.modal-content {
			background-color: #fefefe;
			margin: 15% auto;
			padding: 50px;
			border: 5px solid #888;
			width: 50%;
			color: black;
			height: 90%;
		}

		.modal-close {
			float: left;
			cursor: pointer;
			font-size: 50px;
		}

		.modal-close:hover {
			color: black;
		}

		/* Custom class for the button */
		.custom-btn {
			padding: 10px 20px;
			width: 30%;
			font-size: 14px;
		}

		.reportMessage {
			color: blue;
		}
	</style>




	<!-- All Js -->
	<script src="js/bootstrap.bundle.min.js"></script>
	<script>
		//for modal
		const reportModal = document.getElementById("reportModal");
		const reportModalBtn = document.getElementById("report-incident-btn");
		const modalCloseBtn = document.getElementById("modalClose");

		// Open the modal when the "Report an Incident" button is clicked
		reportModalBtn.addEventListener("click", () => {
			reportModal.style.display = "block";
		});

		// Close the modal when the close button is clicked
		modalCloseBtn.addEventListener("click", () => {
			reportModal.style.display = "none";
		});

		// Close the modal when the user clicks outside the modal content
		window.addEventListener("click", (event) => {
			if (event.target === reportModal) {
				reportModal.style.display = "none";
			}
		});
	</script>


</body>

</html>