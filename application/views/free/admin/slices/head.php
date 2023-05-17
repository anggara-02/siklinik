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
<meta name="description" content="Indah &amp; Ismail's Wedding">
<meta name="keywords" content="Indah Ismail Wedding, The Wedding, Married Couple, eternalnine">
<title><?php echo $title; ?></title>
<?php echo chrome_frame(); ?>
<?php echo favicons(); ?>
<?php echo view_port(); ?>
<?php echo apple_mobile(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<?php
if (!isset($folder))
    $folder = "public/default/";
echo add_css($folder . 'bootstrap');
echo add_css($folder . 'bootstrap-theme');
echo add_css($folder . 'font-awesome.min');
echo add_css($folder . 'main');
echo add_css($folder . 'flexslider');
echo add_css($folder . 'preloader');
echo add_css($folder . 'animate');
echo add_css($folder . 'sweetalert2.min');
echo add_css($folder . 'jquery.countdown');
echo add_css($folder . 'photobox');
echo add_css($folder . 'style');
echo add_js($folder . 'bootstrap.min');
echo add_js($folder . 'jquery.countdown.min');
echo add_js($folder . 'jquery.flexslider');
echo add_js($folder . 'jquery.sticky');
echo add_js($folder . 'jquery.easing.min');
echo add_js($folder . 'scrolling-nav');
echo add_js($folder . 'parallax.min');
echo add_js($folder . 'sweetalert2.min');
echo add_js($folder . 'jquery.photobox');
echo add_js($folder . 'preloader');
?>
<link href="https://fonts.googleapis.com/css?family=Dosis:400,700|Pacifico|Handlee|Parisienne|Sacramento|Yanone+Kaffeesatz|Raleway:400,500|Josefin+Sans" rel="stylesheet">
<script type="text/javascript">
    $(document).ready(function () {
        $('#countdown').countdown({
            date: '11/11/2017 10:00:00',
            offset: +2,
            day: 'Day',
            days: 'Days'
        }, function () {
            swal('Yeay!',"Finally, we're married! Thank you for celebrating with us!",'success');
        });
        $("#header").sticky({
            topSpacing: 0,
            zIndex: 1
        });
        $('#gallery').photobox('a', {time: 0});
    });

    function initMap() {
        // var matrimony = {lat: -7.788316, lng: 110.371036};
        var reception = {lat: -6.1632923, lng: 106.8948546};
        var center = {lat: -6.1632923, lng: 106.8948546};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            center: center
        });
        // var contentString = '<div id="content">' +
                // '<h5 class="dosis-bold"><i class="fa fa-fw fa-bell"></i> St. Antonius Padua Church, Kotabaru</h5>' +
                // '</div>';

        // var infowindow = new google.maps.InfoWindow({
            // content: contentString
        // });
        var contentString2 = '<div id="content">' +
                '<h5 style="margin:0 padding:0;color:black;"class="dosis-bold"><i class="fa fa-fw fa-cutlery"></i> Grand Ballroom Klub Kelapa Gading</h5>' +
                '</div>';

        var infowindow2 = new google.maps.InfoWindow({
            content: contentString2
        });
        // var marker1 = new google.maps.Marker({
            // title: 'Holy Matrimony',
            // position: matrimony,
            // map: map
        // });
        var marker2 = new google.maps.Marker({
            position: reception,
            map: map
        });
        // google.maps.event.addListener(marker1, 'click', function () {
            // infowindow.open(map, marker1);
        // });
        google.maps.event.addListener(marker2, 'click', function () {
            infowindow2.open(map, marker2);
        });
        // infowindow.open(map, marker1);
        infowindow2.open(map, marker2);
        // marker1.addListener('click', function() {
          // map.setZoom(17);
          // map.setCenter(marker1.getPosition());
        // });
        marker2.addListener('click', function() {
          map.setZoom(17);
          map.setCenter(marker2.getPosition());
        });
    }
    $(window).load(function () {
        $('.flexslider').flexslider({
            animation: "fade",
            controlNav: false,
            directionNav: false,
            animationLoop: true,
            slideshow: true,
            slideshowSpeed: 7000,
            animationSpeed: 1500
        });
    });

</script>
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>
<div class="loading-gif"></div>