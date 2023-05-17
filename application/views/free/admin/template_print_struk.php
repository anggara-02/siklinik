<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$websiteConfig=common_lib::getConfig();
$config_logo=(isset($websiteConfig['config_logo']) AND file_exists(FCPATH . $websiteConfig['config_logo']) AND trim($websiteConfig['config_logo']) != '')?base_url() . $websiteConfig['config_logo']:'';
$config_favicon=(isset($websiteConfig['config_favicon']) AND file_exists(FCPATH . $websiteConfig['config_favicon']) AND trim($websiteConfig['config_favicon']) != '')?base_url() . $websiteConfig['config_favicon']:'';
$ThemeUrl=common_lib::getThemeUrl();
$current_uri=$this->uri->segment(3);
?>
<!DOCTYPE html>
<html lang="en">
    <head> 
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta http-equiv="X-UA-Compatible" content="text/html; charset=UTF-8" />

		<title><?php echo isset($seoTitle) ? $seoTitle:$websiteConfig['config_app_name']; ?></title>
		<meta name="description" content="<?php echo common_lib::removeHtmlTag($websiteConfig['config_app_description']);?>">
		<meta name="keywords" content="<?php echo common_lib::removeHtmlTag($websiteConfig['config_app_keywords']);?>">

		<meta property="og:site_name" content="<?php echo isset($Title)?$websiteConfig['config_app_name'].' - '.$Title:$websiteConfig['config_app_name'];?>" />
		<meta property="og:title" content="<?php echo isset($Title)?$websiteConfig['config_app_name'].' - '.$Title:$websiteConfig['config_app_name'];?>" />
		<meta property="og:image" content="<?php echo $config_logo?>" />
		<meta property="og:description" content="<?php echo common_lib::removeHtmlTag($websiteConfig['config_app_description']);?>" />
		<meta property="og:url" content="<?php echo isset($current_url)?$current_url:base_url()?>" />

		<meta property="og:image:type" content="image/jpeg" /> 
		<meta property="og:image:width" content="650" /> 
		<meta property="og:image:height" content="366" />

		<meta name="thumbnailUrl" content="<?php echo $config_logo?>" itemprop="thumbnailUrl" />
		<meta name="twitter:card" content="summary_large_image" />
		<meta name="twitter:site" content="<?php echo $websiteConfig['config_app_name']?>" />
		<meta name="twitter:site:id" content="<?php echo $websiteConfig['config_app_name']?>" />
		<meta name="twitter:creator" content="<?php echo $websiteConfig['config_app_name']?>" />
		<meta name="twitter:description" content="<?php echo common_lib::removeHtmlTag($websiteConfig['config_app_description']);?>" />
		<meta name="twitter:image:src" content="<?php echo $config_logo?>" />

		<link rel="shortcut icon" href="<?php echo $config_favicon;?>" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
		  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
		  rel="stylesheet">
		
		 <link rel="apple-touch-icon" href="<?php echo $ThemeUrl;?>images/ico/apple-icon-120.png">
		  <link rel="shortcut icon" type="image/x-icon" href="<?php echo $ThemeUrl;?>images/ico/favicon.ico"> 
		<link rel="stylesheet" href="<?php echo $ThemeUrl;?>bootstrap/css/bootstrap.min.css"> 
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-print-struk.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/print-struk.css">
		   
  <!-- END PAGE LEVEL JS-->
    </head>
   
		
	<body class="hold-transition login-page">  
					<?php echo $content ?>  
		</body>
</html>