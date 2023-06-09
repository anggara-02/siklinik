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
	</head>
	<body class="bg-theme">
		<div id="app">
			<section class="section">
				<div class="container mt-5">
					<div class="row">
						<div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
							<div class="login-brand">
								<h1 class="text-white">SI KLINIK</h1>
							</div>
							<div class="card">
								<div class="card-header"><h4>Login</h4></div>
								<div class="card-body">
									<form method="POST" action="admin.php" class="needs-validation" novalidate="">
										<div class="form-group">
											<label for="username">Username</label>
											<input id="username" type="text" class="form-control" name="username" tabindex="1" required autofocus>
											<div class="invalid-feedback">
												Please fill in your username
											</div>
										</div>
										<div class="form-group">
											<div class="d-block">
												<label for="password" class="control-label">Password</label>
												<div class="float-right">
													<a href="auth-forgot-password.html" class="text-small">
														Forgot Password?
													</a>
												</div>
											</div>
											<input id="password" type="password" class="form-control" name="password" tabindex="2" required>
											<div class="invalid-feedback">
												please fill in your password
											</div>
										</div>
										<div class="form-group">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
												<label class="custom-control-label" for="remember-me">Remember Me</label>
											</div>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
											Login
											</button>
										</div>
									</form>
								</div>
							</div>
							
							<div class="simple-footer">
								Copyright &copy; SI KLINIK 2021
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<!-- General JS Scripts -->
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
		<script src="assets/js/stisla.js"></script>
		<!-- JS Libraies -->
		<!-- Template JS File -->
		<script src="assets/js/scripts.js"></script>
		<script src="assets/js/custom.js"></script>
		<!-- Page Specific JS File -->
	</body>
</html>