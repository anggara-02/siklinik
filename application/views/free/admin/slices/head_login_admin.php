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
echo add_css('admin/default-theme/hover-min');
echo add_css('admin/default-theme/style-login');
echo add_js('admin/default-theme/bootstrap.min');
echo add_js('admin/default-theme/preloader');
//echo add_js('admin/default-theme/animsition.min');
//echo add_css('admin/default-theme/animsition.min');
?>
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>
<div class="loading-gif"></div>
<!--<script type="text/javascript">
    $(document).ready(function () {
        $(".animsition").animsition({
            inClass: 'fade-in-down-sm',
            outClass: 'fade-out-down-sm',
            inDuration: 1500,
            outDuration: 800,
            linkElement: '.animsition-link',
            // e.g. linkElement: 'a:not([target="_blank"]):not([href^="#"])'
            loading: false,
            loadingParentElement: 'body', //animsition wrapper element
            loadingClass: 'animsition-loading',
            loadingInner: '', // e.g '<img src="loading.svg" />'
            timeout: false,
            timeoutCountdown: 5000,
            onLoadEvent: true,
            browser: ['animation-duration', '-webkit-animation-duration'],
            // "browser" option allows you to disable the "animsition" in case the css property in the array is not supported by your browser.
            // The default setting is to disable the "animsition" in a browser that does not support "animation-duration".
            overlay: false,
            overlayClass: 'animsition-overlay-slide',
            overlayParentElement: 'body',
            transition: function (url) {
                window.location.href = url;
            }
        });
        $(".animsition-login").animsition({
            inClass: 'fade-in',
            outClass: 'fade-out',
            inDuration: 1500,
            outDuration: 800,
            linkElement: '.animsition-link',
            // e.g. linkElement: 'a:not([target="_blank"]):not([href^="#"])'
            loading: false,
            loadingParentElement: 'body', //animsition wrapper element
            loadingClass: 'animsition-loading',
            loadingInner: '', // e.g '<img src="loading.svg" />'
            timeout: false,
            timeoutCountdown: 5000,
            onLoadEvent: true,
            browser: ['animation-duration', '-webkit-animation-duration'],
            // "browser" option allows you to disable the "animsition" in case the css property in the array is not supported by your browser.
            // The default setting is to disable the "animsition" in a browser that does not support "animation-duration".
            overlay: false,
            overlayClass: 'animsition-overlay-slide',
            overlayParentElement: 'body',
            transition: function (url) {
                window.location.href = url;
            }
        });
    });
</script>-->
