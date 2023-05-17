<?php
defined('BASEPATH') or exit('No direct script access allowed');
$websiteConfig = common_lib::getConfig();
$config_logo = (isset($websiteConfig['config_logo']) and file_exists(FCPATH . $websiteConfig['config_logo']) and trim($websiteConfig['config_logo']) != '') ? base_url() . $websiteConfig['config_logo'] : '';
$config_favicon = (isset($websiteConfig['config_app_favicon']) and file_exists(FCPATH . $websiteConfig['config_app_favicon']) and trim($websiteConfig['config_app_favicon']) != '') ? base_url() . $websiteConfig['config_app_favicon'] : '';
$ThemeUrl = common_lib::getThemeUrl();
$current_uri = $this->uri->segment(2);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<!-- ==========DON'T REMOVE============
		Create with Love
		Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
		Support : Alfons Permana | 
		Megistra Team : megistra.com
		Contact Us : support@megistra.com
		==========DON'T REMOVE============ -->


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

	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<!-- General CSS Files -->
	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-431.css">
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.css"> -->
	<!-- Template CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/components.css">


	<!-- General JS Scripts -->
	<script src="<?php echo base_url(); ?>assets/js/jquery-2.2.4.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/addons/jui/js/jquery-ui-1.9.2.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/addons/jui/css/jquery.ui.all.css">
	<script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap.4.3.1.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.nicescroll.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/stisla.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>
	<!-- JS Libraies -->


	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/addons/flexigrid/js/flexigrid.js"></script>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/js/addons/flexigrid/css/flexigrid.css" />
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/js/addons/flexigrid/button/style.css" />
	<script src="<?php echo base_url(); ?>assets/js/jquery.hotkeys.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/autoNumeric.js"></script>

	<link rel="stylesheet" href="<?php echo $ThemeUrl; ?>dist/css/font/source-sans-pro.css">
	<!-- Template JS File -->

	<script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
	<script src="<?php echo base_url(); ?>assets/js/lightbox.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/lightbox.min.css">
	<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
	<!-- Page Specific JS File -->


	<!-- datatable -->
	<script src="<?php echo base_url() . 'assets/plugins/datatables/js/jquery.dataTables.js'; ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/plugins/datatables/css/jquery.dataTables.min.css'; ?>">
	<!-- datatable -->

	<!-- select2 -->
	<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/css/select2.css'; ?>">
	<script src="<?php echo base_url(); ?>assets/js/select2.js"></script>
	<!-- select2 -->

	<!-- validasi -->
	<script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
</head>

<body>
	<div id="app">
		<div class="main-wrapper">
			<div class="navbar-bg bg-theme"></div>
			<?php
			require_once(common_lib::getSliceUrl() . '/navbar_admin.php');
			require_once(common_lib::getSliceUrl() . '/menu_admin.php');
			?>



			<small></small>
			</h1>
			<?php echo (isset($breadcrumbs) ? $breadcrumbs : ''); ?>


			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1><?php echo isset($title) ? $title : (isset($config) ? $congif['config_app_name'] : ''); ?></h1>
						<?php echo (isset($breadcrumbs) ? $breadcrumbs : ''); ?>
					</div>
					<div class="section-body">
						<?php echo $content ?>
					</div>
				</section>
			</div>

			<!-- /.content-wrapper -->
			<footer class="main-footer">
				<div class="pull-left">
					<strong><?php echo $websiteConfig['config_app_footer']; ?> </strong>
				</div>
				<div class="pull-right">
					<?php echo $websiteConfig['config_app_copyright']; ?>
				</div><br />
			</footer>

			<!-- datepicker -->
			<script src="<?php echo $ThemeUrl; ?>plugins/datepicker/bootstrap-datepicker.js"></script>
			<!-- datepicker -->
			<link rel="stylesheet" href="<?php echo $ThemeUrl; ?>plugins/datepicker/datepicker3.css">
			<script>
				$(document).ready(function() {
					$(".date").datepicker({
						defaultDate: "+1w",
						changeMonth: true,
						numberOfMonths: 3,
						dateFormat: 'dd-mm-yy',
					});
					shortcut_note();
					// action on key up
					/* 	$(document).keyup(function(e) {
							console.log('keyup=');
							shortcut(e);
						});*/
					// action on key down
					$(document).keydown(function(e) {
						// console.log('keydown=');
						shortcut(e);
					});
					// action on key down
					/* $(document).keypress(function(e) {
						console.log('keypress=');
						shortcut(e);
					}); */
					setTimeout(function() {
						// $(this).find('input,textarea,select').filter(':visible:first').focus();
						// $(this).find('input,textarea,select').filter(':visible:first').select();
						$('[shortcut="f1"]').focus();
						$('[shortcut="f1"]').select();
						// console.log('sini '+$('[shortcut="f1"]').attr('class'));
					}, 500);
				});

				function shortcut(e) {
					// console.log('key='+e.which);
					if (e.which == 112) { //f1
						e.preventDefault();
						$('#psForm').find('input,textarea,select').filter(':visible:first').focus();
						$('#psForm').find('input,textarea,select').filter(':visible:first').select();
						if ($('[shortcut="f1"]').length > 0) {
							$('[shortcut="f1"]').trigger('click');
						}
					}
					if (e.which == 113) { //f2 
						if ($('[shortcut="f2"]').length > 0) {
							shortc = $('.add').attr('shortcut');
							if (shortc == 'f2') {
								var href = $('[shortcut="f2"]').attr('href');
								if (href != '') {
									window.location.href = href; //causes the browser to refresh and load the requested url
								}

							} else {
								$('[shortcut="f2"]').trigger('click');
							}
						}
						e.preventDefault();
					}
					if (e.which == 27) { //esc
						if ($('[shortcut="esc"]').length > 0) {
							if ($('#ajax-cat').is(':visible')) {
								$('#ajax-cat').find('.close').trigger('click');
								e.preventDefault();
							}
							if ($('#ModalBayar').is(':visible')) {
								$('#ModalBayar').find('.close').trigger('click');
								e.preventDefault();
							} else if ($('.trow').length <= 0) {
								// $('[shortcut="esc"]').trigger('click');
								conf = confirm($('[shortcut="esc"]').html().text() + '?');
								if (conf) {
									var href = $('[shortcut="esc"]').attr('href');
									if (href != '') {
										window.location.href = href; //causes the browser to refresh and load the requested url
									}
								}

								e.preventDefault();
							}

						}
					}
					if (e.which == 117) { //f6
						if ($('[shortcut="f6"]').length > 0) {
							$('[shortcut="f6"]').trigger('click');
							console.log('f6 pressed');
							/* conf=confirm($('[shortcut="esc"]').html()+'?');
							if(conf)
							{
								var href = $('[shortcut="esc"]').attr('href');
								if(href!='')
								{
									window.location.href = href; //causes the browser to refresh and load the requested url
								}
							} */

						}
						e.preventDefault();
					}
					if (e.keyCode == 13 && e.ctrlKey) //ctrl+enter
					{
						console.log('ctrl+enter');
						if ($('#ModalBayar').length > 0 && $('#ModalBayar').is(':visible')) {
							console.log('#ModalBayar');
							if ($('[shortcut="ctrl+enter"]').length > 0) {
								$('[shortcut="ctrl+enter"]').trigger('click');
								console.log('click');
							}
						} else {
							console.log('#ModalBayar');
							if ($('[shortcut="ctrl+enter"]').length > 0) {
								$('[shortcut="ctrl+enter"]').trigger('click');
								console.log('click');
							}
						}

						e.preventDefault();
						return false;
					} else if (e.keyCode == 13) //enter
					{
						/* alert($(this).index(this));
						var nextIndex = $('.form-control').index(this) + 2;
						$('.form-control')[nextIndex].focus();
						alert(nextIndex); */
						// e.preventDefault();
						return false;
					}
					//alert(e.which);
				}

				function shortcut_note() {
					if ($('#flexygrid').length > 0) {
						i = 0;
						if ($('[shortcut="f2"]').length > 0) {
							i++;
							$('.note_shortcut_grid').append('<p>' + i + '. Tekan F2 untuk ' + $('[shortcut="f2"]').val() + $('[shortcut="f2"]').html() + '</p>');
						}
						if ($('[shortcut="ctrl+enter"]').length > 0) {
							i++;
							$('.note_shortcut_grid').append('<p>' + i + '. Tekan CTRL+Enter untuk ' + $('[shortcut="ctrl+enter"]').html() + $('[shortcut="ctrl+enter"]').val() + '</p>');
						}
					}
					if ($('#psForm').length > 0) {
						i = 0;
						$('#psForm').find('input,textarea,select').filter(':visible:first').attr('placeholder', 'Tekan F1 untuk ke sini');
						//$('#psForm').find('input[shortcut="ctrl+enter"]').after('<p>tekan CTRL+ENTER untuk '+$('#psForm').find('input[shortcut="ctrl+enter"]').val()+'</p>');

						i++;
						$('.note_shortcut_form').append('<p>' + i + '. Tekan TAB untuk pindah baris inputan</p>');

						if ($('[shortcut="ctrl+enter"]').length > 0) {
							i++;
							$('.note_shortcut_form').append('<p>' + i + '. Tekan CTRL+ENTER untuk ' + $('[shortcut="ctrl+enter"]').val() + '</p>');
						}
						if ($('[shortcut="esc"]').length > 0) {
							i++;
							$('.note_shortcut_form').append('<p>' + i + '. Tekan ESC untuk ' + $('#psForm').find('[shortcut="esc"]').html() + '</p>');
						}
					}
				}
			</script>

			<!-- ////////////////////////////////////////////////////////////////////////////-->

		</div>
		<div class="clearfix"></div>
		<div id="ajax-cat" data-width="100%" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;z-index:1;"></div>
		<div id="ajax-custom" data-width="70%" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;z-index:1;"></div>

</body>

</html>