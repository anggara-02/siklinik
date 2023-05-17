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
							<div class="form-group" style="display:none">
								<label class="col-sm-4 control-label" for="form-field-1">
									Pegawai *
								</label>
								<div class="col-sm-8"> 
									<input class="form-control" type="text" autocomplete="off" name="user_karyawan" maxlength="200" value="<?php echo $this->input->post('user_karyawan')?$this->input->post('user_karyawan'):(isset($user_karyawan)?$user_karyawan:''); ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">
									Username *
								</label>
								<div class="col-sm-8">
									<input class="form-control" type="text" autocomplete="off" name="user_name" maxlength="100" value="<?php echo $this->input->post('user_name')?$this->input->post('user_name'):(isset($user_name)?$user_name:''); ?>" />
								</div>
							</div> 
							<div class="form-group">
								<label class="col-sm-4 control-label">
									Password *
								</label>
								<div class="col-sm-8">
									<input class="form-control" type="password" autocomplete="off" name="user_password" value="<?php echo $this->input->post('user_password')?$this->input->post('user_password'):(isset($user_password)?$user_password:''); ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">
									Konfirmasi Password *
								</label>
								<div class="col-sm-8">
									<input class="form-control" type="password" name="user_repassword" value="<?php echo $this->input->post('user_repassword')?$this->input->post('user_repassword'):(isset($user_password)?$user_password:''); ?>" />
								</div>
							</div>  
							<div class="form-group">
								<label class="col-sm-4 control-label">
									Jenis Akun *
								</label>
								<div class="col-sm-8">
									<select class="form-control" name="role_id">
										<?php 
											if(isset($role_arr)&&!empty($role_arr))
											{
												foreach($role_arr as $rowArr)
												{
													echo '<option value="'.$rowArr['role_id'].'">'.$rowArr['role_name'].'</option>';
												}
											}
										?>
									</select> 
								</div>
							</div> 
							<div class="form-group">
								<label class="col-sm-4 control-label"> 
									Status
								</label>
								<div class="col-sm-8">
									<label for="is_active"><input type="checkbox" id="is_active" name="is_active" <?php echo $this->input->post('is_active')=="1"?'checked':($this->input->post('is_active')==""?'checked':''); ?> value="1" /> Aktifkan</label>
									<p><small>Centang untuk mengijinkan user login ke sistem</small></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">
									Keterangan
								</label>
								<div class="col-sm-8">
									<textarea class="form-control" name="user_keterangan"><?php echo $this->input->post('user_keterangan')?$this->input->post('user_keterangan'):(isset($user_keterangan)?$user_keterangan:''); ?></textarea>
								</div>
							</div>  
							<div class="form-group">
							<hr/> 
								<div class="col-sm-4">
								</div>
								<label class="col-sm-8">
									Semua data dengan tanda * harus diisi
								</label> 
							<hr/> 
							</div>   
							<div class="form-group">
							<div class="col-sm-4">
							</div>
							<div class="col-sm-4">
								<a class="btn btn-default" onclick="return confirm('Batal?');" href="<?php echo base_url()?>admin/<?php echo $class;?>/index" shortcut="esc" style="margin-right:20px;">Batal</a>
								<input onclick="return confirm('Simpan?');return false;" type="submit" name="save" shortcut="ctrl+enter" value="Simpan" class="btn btn-success">
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
	setTimeout(function(){ 
		$('.custom_message').hide();
	}, 5000);	
});

function cek_pegawai(elem)
{
	nama=$('[name="pegawai_id"] option:selected').text();
	$('[name="user_karyawan"]').val(nama);
}
 </script>