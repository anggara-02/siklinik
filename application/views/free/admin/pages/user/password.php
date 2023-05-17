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
        <div class="row">
          <div class="col-md-12">
            <div class="box box-success">
                <div class="box-body">  
					<form class="form-horizontal" id="psForm" method="POST" action="" enctype="multipart/form-data">
					  <?php 
							if(trim($status)!='' AND trim($message)!=''){
						  ?>
								<div class="row">
									<div class="col-sm-12 control-label"> 
										<div class="callout  mb-1 <?php echo ($status==200)?'callout-success':'callout-danger'; ?>">
										  <div style="text-align:left;"><i class="<?php echo ($status==200)?'icon-thumbs-up':'icon-remove'; ?>"></i><?php echo $message; ?></div> 

										</div>
									</div>
								</div>
						  <?php
							}
						  ?>  
						
					<div class="row">
						<div class="col-md-8">  
							<div class="form-group">
								<label class="col-sm-4 control-label" for="form-field-1">
									Nama User *
								</label>
								<div class="col-sm-8">
									<?php echo $this->input->post('user_name')?$this->input->post('user_name'):(isset($data['user_name'])?$data['user_name']:''); ?>
								</div>
							</div> 
							
							<div class="form-group password">
								<label class="col-sm-4 control-label">
									Password *
								</label>
								<div class="col-sm-8">
									<input class="form-control" type="password" name="user_password" value="" />
								</div>
							</div> 
							<div class="form-group password">
								<label class="col-sm-4 control-label">
									Konfirmasi Password *
								</label>
								<div class="col-sm-8">
									<input class="form-control" type="password" name="user_repassword" value="" />
								</div>
							</div>  
							<div class="form-group">
							<hr/> 
								<div class="col-md-2">
								</div>
								<label class="col-md-10">
									Semua data dengan tanda * harus diisi
								</label> 
							<hr/> 
							</div>     
							<div class="form-group">
							<div class="col-sm-4">
							</div>
							<div class="col-sm-4">
								<input class="form-control" type="hidden" name="user_id" value="<?php echo (isset($data['user_id'])?$data['user_id']:''); ?>" />
								
								<a class="btn btn-default" href="<?php echo base_url()?>admin/<?php echo $class;?>/index" onclick="return confirm('Batal?');" shortcut="esc" style="margin-right:20px;">Batal</a>
								<input onclick="return confirm('Edit?');return false;" type="submit" name="save" value="Edit" shortcut="ctrl+enter" class="btn btn-success">
							</div>
							</div>
						 
						</div>
						<div class="col-md-4">
							<div class="callout callout-warning mb-1">
							<h4><i class="fa fa-exclamation-triangle"></i> Catatan</h4> 
							<p class="note_shortcut_form">Petunjuk hotkey/shortcut</p>
						  </div> 
					
						</div>
					</div>
				</form>
			</div>
		</div>
	 </div> 
 </div>

<script>
 $(document).ready(function() { 
	
});

</script> 