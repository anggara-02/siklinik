<?php
defined('BASEPATH') or exit('No direct script access allowed');
$websiteConfig = common_lib::getConfig();
$config_logo = (isset($websiteConfig['config_logo']) and file_exists(FCPATH . $websiteConfig['config_logo']) and trim($websiteConfig['config_logo']) != '') ? base_url() . $websiteConfig['config_logo'] : '';
$config_favicon = (isset($websiteConfig['config_app_favicon']) and file_exists(FCPATH . $websiteConfig['config_app_favicon']) and trim($websiteConfig['config_app_favicon']) != '') ? base_url() . $websiteConfig['config_app_favicon'] : '';

$ThemeUrl = common_lib::getThemeUrl();
$current_uri = $this->uri->segment(3);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="X-UA-Compatible" content="text/html; charset=UTF-8" />

	<title><?php echo isset($seoTitle) ? $seoTitle : $websiteConfig['config_app_name']; ?></title>
	<meta name="description" content="<?php echo common_lib::removeHtmlTag($websiteConfig['config_app_description']); ?>">
	<meta name="keywords" content="<?php echo common_lib::removeHtmlTag($websiteConfig['config_app_keywords']); ?>">

	<meta property="og:site_name" content="<?php echo isset($Title) ? $websiteConfig['config_app_name'] . ' - ' . $Title : $websiteConfig['config_app_name']; ?>" />
	<meta property="og:title" content="<?php echo isset($Title) ? $websiteConfig['config_app_name'] . ' - ' . $Title : $websiteConfig['config_app_name']; ?>" />
	<meta property="og:image" content="<?php echo $config_logo ?>" />
	<meta property="og:description" content="<?php echo common_lib::removeHtmlTag($websiteConfig['config_app_description']); ?>" />
	<meta property="og:url" content="<?php echo isset($current_url) ? $current_url : base_url() ?>" />

	<meta property="og:image:type" content="image/jpeg" />
	<meta property="og:image:width" content="650" />
	<meta property="og:image:height" content="366" />

	<meta name="thumbnailUrl" content="<?php echo $config_logo ?>" itemprop="thumbnailUrl" />
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:site" content="<?php echo $websiteConfig['config_app_name'] ?>" />
	<meta name="twitter:site:id" content="<?php echo $websiteConfig['config_app_name'] ?>" />
	<meta name="twitter:creator" content="<?php echo $websiteConfig['config_app_name'] ?>" />
	<meta name="twitter:description" content="<?php echo common_lib::removeHtmlTag($websiteConfig['config_app_description']); ?>" />
	<meta name="twitter:image:src" content="<?php echo $config_logo ?>" />

	<link rel="shortcut icon" href="<?php echo $config_favicon; ?>" />

	<!-- General CSS Files -->
	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-431.css">
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.css"> -->
	<!-- Template CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/components.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/custom.css">

	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $ThemeUrl; ?>images/ico/favicon.ico">


	<!-- END PAGE LEVEL JS-->
</head>

<body class="bg-theme">
	<div id="app">
		<section class="section">
			<div class="container mt-5">
				<div class="row">
					<div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
						<div class="login-brand">
							<h1 class="text-white"><?php echo $websiteConfig['config_app_name'] ?></h1>
						</div>
						<div class="card">
							<div class="card-header">
								<h4>Login</h4>
							</div>
							<div class="card-body">
								<?php echo $content ?>
							</div>
						</div>

						<div class="simple-footer">
							<?php echo $websiteConfig['config_app_copyright']; ?>
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
	<script src="<?php echo base_url(); ?>/assets/js/stisla.js"></script>
	<!-- JS Libraies -->
	<!-- Template JS File -->
	<script src="<?php echo base_url(); ?>/assets/js/scripts.js"></script>
	<script src="<?php echo base_url(); ?>/assets/js/custom.js"></script>
	<!-- Page Specific JS File -->
</body>

</html>