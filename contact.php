<?php

$server = "localhost";
$username = "root";
$password = "";
$db = "sgp";

$con = mysqli_connect($server, $username, $password, $db);
if ($con->connect_error) {
	die('Connect Error (' . $con->connect_errno . ') ' . $con->connect_error);
}

mysqli_set_charset($con, "utf8");

$msg = '';
if(isset($_POST['name']))
{
	$name = $_REQUEST['name'];
	$email = $_REQUEST['email'];
	$message = $_REQUEST['message'];

	if ($name == '' || $email == '' || $message == '') 
	{
		$msg = "Please enter value in all fields.";
	}
	else
	{
		$query = "INSERT INTO contactus (name, email, message) VALUES ('$name', '$email', '$message');";
		
		if ($con->query($query) == true) 
		{
			$msg = "Message received.";
		} 
		else 
		{
			$msg = "ERROR: $query <br> $con->error";
		}

		$con->close();
	}
	
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Contact Us</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content="en_US" property="og:locale">
	<!--<meta content='https://' name='og:url' />-->

	<!-- FONTS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">

	<!-- FAVICON -->
	<link rel="icon" type="image/png" href="assets/images/favicon.ico">


	<!-- BOOTSTRAP 
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" />
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	-->

	<!-- STYLE -->
	<link rel="stylesheet" href="css/site.css" />

	<!-- PROGRESS 
	<script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
	-->

	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

	<!-- GSAP 
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/gsap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/CSSRulePlugin.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/TextPlugin.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/EasePack.min.js"></script>
	-->

	<!-- MAIN JS FILE -->
	<script src="js/site.js" type="text/javascript"></script>

</head>

<body>
	<div id="main" class="">
		<header>
		<img src="logo.jpg" alt="" width="220px" height="80px">

			<!-- <div id="nav-top">
				<a class="" href="index.html">Home</a>

				<a class="" href="ds.html">Department & Services</a>

				<a class="" href="ba.php">Book Appointment</a>

				<a class="active" href="contact.php">Contact Us</a>
			</div> -->
			<div id="nav-top">
				<a class="" href="index.html">Home</a>

				
				<div class="dropdown">
					Department & Services
					<div class="dropdown-content">
					<a href="ds.html">Available Doctors</a>
					<a href="radio.html">Radio-diagnosis-imaging</a>
					<a href="icu.html">ICU</a>
					<a href="phar.html">Pharmacy</a>
					<a href="24hr.html">24-hours-emergency</a>
					<a href="clinic.html">Clinical Laboratory</a>
					</div>
				  </div>
				

				<a class="" href="health.html">Health Checkup</a>

				<a class="" href="ba.php">Book Appointment</a>

				<a class="" href="know.html">Know us</a>

				<a class="" href="support.html">Support us</a>

				<a class="" href="contact.php">Contact Us</a>
			</div>
		</header>

		<div class="content">

			<div class="contact">Contact Us</div>

				<form id="contact" method="POST" action="#">

					<div class="form-group">
						<input id="name" name="name" class="" type="text" value="" placeholder="Enter your name">
					</div>

					<div class="form-group">
						<input id="email" name="email" class="" type="email" placeholder="Enter your email address">
					</div>

					<div class="form-group">
						<input id="message" name="message" class="" type="text" placeholder="Enter your message/feedback">
					</div>

					<div class="form-group">
						<input class="btn-submit" type="submit" value="SEND">
					</div>

					<div class="msg"><?= $msg; ?></div>
				</form>

		</div>

		<footer>
			<div class="">Email:<br>chrf@charusat.ac.in
			<br><br>

			Contact no: <br>02697-265502, <br>02697-265504
		 <p><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3683.374601555174!2d72.81900391496006!3d22.60248248516744!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e572db653aed9%3A0xc0060cc3f2b67dc9!2sCHARUSAT%20Hospital!5e0!3m2!1sen!2sin!4v1648746801239!5m2!1sen!2sin" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade width="600" height="450" frameborder="10" style="border:0" allowfullscreen></iframe></p> 
			</div>

		</footer>
	</div>
</body>

</html>
