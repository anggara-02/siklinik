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
<nav class="navbar navbar-expand-lg main-navbar">
	<form class="form-inline mr-auto">
		<ul class="navbar-nav mr-3">
			<li><a href="#" data-toggle="sidebar" id="navSidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
		</ul>
	</form>
	<ul class="navbar-nav navbar-right">
		
		<li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
			<div class="d-inline-block"><i class="fa fa-user-circle mr-2"></i> Hi, <?php echo (isset($keyAdmin)&&isset($_SESSION[$keyAdmin]['user_name'])?$_SESSION[$keyAdmin]['user_name']:'-');?></div></a>
			<div class="dropdown-menu dropdown-menu-right">
				<a href="<?php echo base_url($module.'/user/mypassword'); ?>" class="dropdown-item has-icon">
					<i class="fas fa-cog"></i> Ganti Password
				</a>
				<div class="dropdown-divider"></div>
				<a href="<?php echo base_url($module.'/account/logout');?>" class="dropdown-item has-icon text-danger">
					<i class="fas fa-sign-out-alt"></i> Logout
				</a>
			</div>
		</li>
	</ul>
</nav>