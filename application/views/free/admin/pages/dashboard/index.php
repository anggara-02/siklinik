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
  <?php 
		if(trim($status)!='' AND trim($message)!=''){
	  ?> 
			<div class="col-sm-12 control-label"> 
				<div class="callout  mb-1 <?php echo ($status==200)?'callout-success':'callout-danger'; ?>">
				  <div style="text-align:left;"><i class="<?php echo ($status==200)?'icon-thumbs-up':'icon-remove'; ?>"></i><?php echo $message; ?></div>
				  </div>
			</div> 
	  <?php
		}
	  ?>  
<div class="row mx-n2"> 
		
</div> 