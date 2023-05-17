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
								<div class="row custom_message">
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
							<label class="col-sm-2 control-label">
								Nama Kemasan *
							</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="satuan_name" maxlength="200" value="<?php echo $this->input->post('satuan_name')?$this->input->post('satuan_name'):(isset($satuan_name)?$satuan_name:''); ?>" />
							</div>
						</div>   
						<div class="form-group">
							<label class="col-sm-2 control-label">
								Keterangan
							</label>
							<div class="col-sm-10">
								<textarea class="form-control" name="satuan_keterangan"><?php echo $this->input->post('satuan_keterangan')?$this->input->post('satuan_keterangan'):(isset($satuan_keterangan)?$satuan_keterangan:''); ?></textarea>
							</div>
						</div>   
						<div class="form-group">
						<hr/> 
							<label class="col-sm-12">
								Semua data dengan tanda * harus diisi
							</label> 
						<hr/> 
						</div>   
						<div class="form-group">
						<div class="col-sm-2">
						</div>
						<div class="col-sm-4">
							<a class="btn btn-default" onclick="return confirm('Batal?');" href="<?php echo base_url()?>admin/<?php echo $class;?>/index" shortcut="esc" style="margin-right:20px;">Batal</a>
							<input onclick="return confirm('Simpan?');return false;" type="submit" name="save" shortcut="ctrl+enter" value="Simpan" class="btn btn-success">
						</div>
						</div>
					</form>
					</div>
					
					<div class="col-md-4">
						<div class="callout callout-warning mb-1">
						<h4><i class="fa fa-exclamation-triangle"></i> Catatan</h4> 
						<p class="note_shortcut_form">Petunjuk hotkey/shortcut</p>
					  </div> 
				
					</div>
				</div>
            </div>
		</div>
	</div>
  <script>  
	 $(document).ready(function() { 
		setTimeout(function(){ 
			$('.custom_message').hide();
		}, 5000);	
	});
  </script>