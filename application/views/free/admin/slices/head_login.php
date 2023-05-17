<!-- ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ -->
	
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<meta charset="utf-8">
<?php echo favicons(); ?>
<?php echo view_port(); ?>
<?php echo apple_mobile(); ?>
<title><?php echo $title; ?></title>
<link href="https://fonts.googleapis.com/css?family=Sacramento|Parisienne|Pacifico|Dosis:400,700" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<?php
echo add_css('admin/default-theme/preloader');
echo add_css('admin/default-theme/bootstrap.min');
echo add_css('admin/default-theme/bootstrap-theme');
echo add_css('admin/default-theme/font-awesome.min');
echo add_css('admin/default-theme/style-login');
echo add_css('admin/default-theme/hover-min');
echo add_js('admin/default-theme/bootstrap.min');
echo add_js('admin/default-theme/preloader');
//echo add_css('admin/default-theme/animsition.min');
//echo add_js('admin/default-theme/animsition.min');
?>
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>
<div class="loading-gif"></div>

