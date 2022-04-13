<?php
session_start();

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

if (isset($_REQUEST['action'])) {
	if ($_REQUEST['action'] == 'login') {
		$query = "SELECT * FROM signup WHERE email='" . $_REQUEST['email'] . "'";

		$result = mysqli_query($con, $query) or exit(mysqli_error($con) . "<br><br>Query: <br>" . $query);

		if ($result->num_rows > 0) {
			// check if password match
			while ($row = $result->fetch_assoc()) {
				if (password_verify($_REQUEST['password'], $row['password'])) {
					$_SESSION['un'] = $row['email'];
					$_SESSION['uid'] = $row['id'];

					echo "<script>alert('Logged in, please book an appointment.'); window.location.href = 'ba.php';</script>";
				} else {
					$msg = 'Invalid password.';
				}
			}
		} else {
			$msg = "User not found, please try another id or SIGN-UP.";
		}
	}

	if ($_REQUEST['action'] == 'signup') {
		$query = "SELECT * FROM signup WHERE email='" . $_REQUEST['email'] . "'";

		$result = mysqli_query($con, $query) or exit(mysqli_error($con) . "<br><br>Query: <br>" . $query);

		if ($result->num_rows > 0) {
			// user exist so display message
			$msg = "User already exists, please try another email id.";
		} else {
			$email = $_REQUEST['email'];
			$password = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);
			$name = $_REQUEST['name'];
			$phone = $_REQUEST['phone'];
			$address = $_REQUEST['address'];

			if ($_REQUEST['password'] != $_REQUEST['cpass']) {
				$msg = "Password does not match.";
			} else if ($email == '' || $name == '' || $phone == '' || $address == '') {
				$msg = "Please enter value in all inputs.";
			} else {
				$query = "INSERT INTO signup (email, password, name, phone, address) VALUES ('$email', '$password', '$name', '$phone', '$address');";

				if ($con->query($query) == true) {
					echo "<script>alert('User added, please login.'); window.location.href = 'ba.php';</script>";
				} else {
					$msg = "ERROR: $query <br> $con->error";
				}
			}
		}
	}

	if ($_REQUEST['action'] == 'booking') {
		$uid = $_REQUEST['uid'];
		$name = $_REQUEST['name'];
		$dob = $_REQUEST['dob'];
		$gender = $_REQUEST['gender'];
		$marital = $_REQUEST['marital'];
		$blood = $_REQUEST['blood'];
		$phone = $_REQUEST['phone'];
		$email = $_REQUEST['email'];
		$address = $_REQUEST['address'];
		$adt = $_REQUEST['adt'];
		$dept = $_REQUEST['dept'];
		$doctor = $_REQUEST['doctor'];
		$time = $_REQUEST['time'];
		$agree = $_REQUEST['agree'];

		
		$query = "INSERT INTO appointments (uid, name, dob, gender, marital, blood, phone, email, address, adt, dept, doctor, time, agree) VALUES ('$uid', '$name', '$dob', '$gender', '$marital', '$blood', '$phone', '$email', '$address', '$adt', '$dept', '$doctor', '$time', '$agree');";

		if ($con->query($query) == true) {
			$msg = "Appointment booked.";
			session_destroy();

		} else {
			$msg = "ERROR: $query <br> $con->error";
		}
	}
}

$con->close();

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Book Appointment</title>

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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="jquery.js"></script>

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
			<!-- <span id="title">DateYourHealth</span> -->
			<img src="logo.jpg" alt="" width="220px" height="80px">

			<!-- <div id="nav-top">
				<a class="" href="index.html">Home</a>

				<a class="" href="ds.html">Department & Services</a>

				<a class="active" href="ba.php">Book Appointment</a>

				<a class="" href="contact.php">Contact Us</a>
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
			<?php
			if (!isset($_SESSION['un'])) {
				if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'signupform' || $_REQUEST['action'] == 'signup')) {
			?>
					<div id="sform">
						<div class="form-header fs36 txt-center" class="fs36">Sign Up</div>

						<form id="signup" method="POST" action="#">
							<div class="form-group">
								<input id="name" name="name" class="" type="text" value="" placeholder="Enter your Username">
							</div>

							<div class="form-group">
								<input id="email" name="email" class="" type="email" placeholder="Enter your email address">
							</div>

							<div class="form-group">
								<input id="phone" name="phone" class="" type="tel" pattern="\+\d{0,2}[\s\(\-]?([0-9]{3})[\s\)\-]?([\s\-]?)([0-9]{3})[\s\-]?([0-9]{2})[\s\-]?([0-9]{2})" placeholder="Enter your phone number">
							</div>

							<div class="form-group">
								<input id="address" name="address" class="" type="text" placeholder="Enter your address">
							</div>

							<div class="form-group">
								<input id="pass" name="password" class="" type="password" value="" placeholder="Enter Password">
							</div>

							<div class="form-group">
								<input id="cpass" name="cpass" class="" type="password" value="" placeholder="Confirm Password">
							</div>

							<div class="form-group">
								<input id="checkbox" name="checkbox" class="chkbx" type="checkbox" value="1">
								<label for="checkbox" class="">All details entered by me are correct to the best of my knowledge.</label>
							</div>

							<div class="form-group txt-center">
								<input class="btn-submit" type="submit" value="CREATE ACCOUNT">
							</div>

							<div class="msg"><?= $msg; ?></div>

							<input name="action" type="hidden" value="signup">
						</form>

						<form id="showlogin" method="POST" action="#">
							<input name="action" type="hidden" value="loginform">
							<a href="#" onclick="document.getElementById('showlogin').submit();">Already have an account? Login!</a>
						</form>
					</div>
				<?php
				} else {
				?>
					<div id="lform">
						<div class="form-header fs36 txt-center" class="fs36">Sign In</div>

						<form id="login" method="POST" action="#">
							<div class="form-group">
								<input id="email" name="email" class="" type="email" placeholder="Enter your email address">
							</div>

							<div class="form-group">
								<input id="pass" name="password" class="" type="password" value="" placeholder="Enter Password">
							</div>

							<div class="form-group txt-center">
								<input class="btn-submit" type="submit" value="LOGIN">
							</div>

							<div class="msg"><?= $msg; ?></div>

							<input name="action" type="hidden" value="login">
						</form>

						<form id="showsignup" method="POST" action="#">
							<input name="action" type="hidden" value="signupform">
							<a href="#" onclick="document.getElementById('showsignup').submit();">Don't have an account? Sign up!</a>
						</form>
					</div>
				<?php
				}
			} else {
				?>
				<div id="bform">
					<div class="form-header fs36 txt-center" class="fs36">Appointment Form</div>

					<form id="booking" method="POST" action="#">
						<input id="uid" name="uid" type="hidden" value="<?= $_SESSION['uid']; ?>">

						<div class="form-group">
							<label for="name" class="">Enter your full name:</label>
							<input id="name" name="name" class="" type="text" placeholder="First Name  Middle Name  Last name">
						</div>

						<div class="form-group">
							<label for="date-3ed9" class="">Date of birth:</label>
							<input id="dob" name="dob" class="" type="date" placeholder="MM/DD/YYYY">
						</div>

						<div class="form-group">
							<label for="gender" class="">Choose your gender:<br></label>
							
							<input name="gender" class="chkbx" type="radio" value="Male" checked>
							<label class="gender" for="gender">Male</label>
						
							<input name="gender" class="chkbx" type="radio" value="Female">
							<label class="gnder" for="gender">Female</label>

							<input name="gender" class="chkbx" type="radio" value="Other">
							<label class="gender" for="gender">Other</label>
							
						</div>

						<div class="form-group">
							<label for="marital" class="">Marital Status:</label>

							<select id="marital" name="marital" class="">
								<option value="Married">Married</option>
								<option value="Unmarried">Unmarried</option>
							</select>
						</div>

						<div class="form-group">
							<label for="blood " class="">Blood Group:</label>

							<select id="blood " name="blood" class="">
								<option value="A+">A+</option>
								<option value="A-">A-</option>
								<option value="B+">B+</option>
								<option value="B-">B-</option>
								<option value="AB+">AB+</option>
								<option value="AB-">AB-</option>
								<option value="O+">O+</option>
								<option value="O-">O-</option>
							</select>
						</div>

						<div class="form-group">
							<label for="phone" class="">Enter your phone number:</label>
							<input id="phone" name="phone" class="" type="tel" pattern="\+\d{0,2}[\s\(\-]?([0-9]{3})[\s\)\-]?([\s\-]?)([0-9]{3})[\s\-]?([0-9]{2})[\s\-]?([0-9]{2})" placeholder="+91 XXXXX XXXXX">
						</div>

						<div class="form-group">
							<label for="email" class="">Enter your email address:</label>
							<input id="email" name="email" class="" type="email" placeholder="abc@xyz.com">
						</div>

						<div class="form-group">
							<label for="address" class="">Enter your postal address:</label>
							<input id="address" name="address" class="" type="text" placeholder="Mention full address including city and state name along with pincode">
						</div>

						<div class="form-group">
							<label for="adt" class="">Select a date for your appointment:</label>
							<input id="adt" name="adt" class="" type="date" placeholder="MM/DD/YYYY">
						</div>
						
						<div class="form-group">
							<label for="dept" class="">Select the department of need:</label>

							<select id="dept" name="dept" class="">
								<option></option>
								<option class="DENTAL" value="DENTAL">DENTAL</option>
								<option class="GENERAL MEDICINE" value="GENERAL MEDICINE">GENERAL MEDICINE</option>
								<option class="GYNAECOLOGY" value="GYNAECOLOGY">GYNAECOLOGY</option>
								<option class="PAEDIATRICS" value="PAEDIATRICS">PAEDIATRICS</option>
								<option class="PATHOLOGY" value="PATHOLOGY">PATHOLOGY</option>
								<option class="DENTAL" value="1">ORTHOPAEDIC</option>
								<option class="NEUROLOGY" value="NEUROLOGY">NEUROLOGY</option>
								<option class="DENTAL" value="1">UROLOGY</option>
								<option class="DENTAL" value="1">DERMATOLOGY</option>
							</select>
						</div>

						<div class="form-group">
							<label for="doctor" class="">Select the required doctor:</label>

							<select id="doctor" name="doctor" class="">
								<option></option>
								<option class="DENTAL" value="DR. RIDDHI . DESAI">DR. RIDDHI . DESAI</option>
								<option class="DENTAL" value="DR. MEET PATEL">DR. MEET PATEL</option>
								<option class="DENTAL" value="DR. VARUN RAMCHANDRA">DR. VARUN RAMCHANDRA</option>

								<option class="GENERAL MEDICINE" value="DR. JAINISH MODI">DR. JAINISH MODI</option>
								<option class="GENERAL MEDICINE" value="DR. ALPESH VADHER">DR. ALPESH VADHER</option>

								<option class="GYNAECOLOGY" value="	DR. JANAKI AMIN">DR. JANAKI AMIN</option>

								<option class="PAEDIATRICS" value="DR. SHUBHA CHOUGAONKAR">DR. SHUBHA CHOUGAONKAR</option>
								<option class="PAEDIATRICS" value="DR. HARDIK GUPTA">DR. HARDIK GUPTA</option>

								<option class="PATHOLOGY" value="DR. NAITIK BHATIA">DR. NAITIK BHATIA</option>

								<option class="ORTHOPAEDIC" value="DR. SANJAY KUMAR">DR. SANJAY KUMAR</option>
								<option class="ORTHOPAEDIC" value="DR. PINKAL THAKKAR">DR. PINKAL THAKKAR</option>
								<option class="ORTHOPAEDIC" value="DR. SAMIR BABRIA">DR. SAMIR BABRIA</option>

								<option class="NEUROLOGY" value="DR. RISHIKESH GADHAVI">DR. RISHIKESH GADHAVI</option>
								<option class="UROLOGY" value="DR. KRUTIK RAVAL">DR. KRUTIK RAVAL</option>
								<option class="DERMATOLOGY" value="DR. PRATIK AGRAWAL">DR. PRATIK AGRAWAL</option>
							</select>
						</div>
					
					
						<div class="form-group">
							<label for="time" class="">Select a suitable time for your appointment:</label>

							<select id="time" name="time" class="">
								<option value="10A">10:00 AM</option>
								<option value="11A">11:00 AM</option>
								<option value="1P">1:00 PM</option>
								<option value="2P">2:00 PM</option>
								<option value="3P">3:00 PM</option>
								<option value="4P">4:00 PM</option>
								<option value="5P">5:00 PM</option>
								<option value="6P">6:00 PM</option>
								<option value="7P">7:00 PM</option>
							</select>
						</div>

						<div class="form-group">
							<input id="agree" name="agree" class="chkbx" type="checkbox" value="1" checked>
							<label for="agree" class="">I have verified all the details entered by me and am ready to submit.</a></label>
						</div>

						<div class="form-group txt-center">
							<input class="btn-submit" type="submit" value="SUBMIT">
						</div>

						<div class="msg"><?= $msg; ?></div>

						<input name="action" type="hidden" value="booking">
					</form>
				</div>
			<?php
			}
			?>
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
