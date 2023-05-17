<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
		<title>Login - SI KLINIK</title>
		<!-- General CSS Files -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
		<!-- Template CSS -->
		<link rel="stylesheet" href="assets/css/style.css">
		<link rel="stylesheet" href="assets/css/components.css">
		<link rel="stylesheet" href="assets/css/custom.css">

		<!-- General JS Scripts -->
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
		<script src="assets/js/stisla.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
		<!-- JS Libraies -->
		<!-- Template JS File -->
		<script src="assets/js/scripts.js"></script>
		<script src="assets/js/custom.js"></script>
		<!-- Page Specific JS File -->
	</head>
	<body>
		<div id="app">
			<div class="main-wrapper">
				<div class="navbar-bg bg-theme"></div>
				<?php include 'navbar.php';?>
				<?php include 'sidebar.php';?>
				
				<!-- Main Content -->
				<div class="main-content">
					<section class="section">
						<?php if(!isset($_GET['page'])) $_GET['page'] = 0;?>
				        <?php
				            if ($_GET['page']) {
				                require_once 'pages/'.$_GET['page'] . '.php';
				            } else {
				                require_once 'pages/dashboard.php';
				            }
				        ?>
					</section>
				</div>
				<footer class="main-footer">
					<div class="footer-left">
						Copyright &copy; 2021 <div class="bullet"></div> SI KLINIK
					</div>
					<div class="footer-right">
						1.0.0
					</div>
				</footer>
			</div>
		</div>
	</body>
</html>