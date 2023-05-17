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
									<select class="form-control" name="pegawai_id" onchange="cek_pegawai($(this))">
										<option value="">Silahkan Pilih</option>
										<?php 
											if(isset($pegawai_arr)&&!empty($pegawai_arr))
											{
												foreach($pegawai_arr as $rowArr)
												{
													$selected=$this->input->post('pegawai_id')==$rowArr['pegawai_id']?'selected':(isset($data['pegawai_id'])&&$data['pegawai_id']==$rowArr['pegawai_id']?'selected':'');
													echo '<option value="'.$rowArr['pegawai_id'].'" '.$selected.'>'.$rowArr['pegawai_name'].'</option>';
												}
											}
										?>
									</select> 
									<input class="form-control" type="hidden" autocomplete="off" name="user_karyawan" maxlength="200" value="<?php echo $this->input->post('user_karyawan')?$this->input->post('user_karyawan'):(isset($user_karyawan)?$user_karyawan:''); ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label" for="form-field-1">
									Nama User *
								</label>
								<div class="col-sm-8">
									<input class="form-control" type="text" name="user_name" maxlength="200" value="<?php echo $this->input->post('user_name')?$this->input->post('user_name'):(isset($data['user_name'])?$data['user_name']:''); ?>" />
								</div>
							</div> 
							<div class="form-group">
								<label class="col-sm-4 control-label" for="form-field-1">
									Jenis Akun *
								</label>
								<div class="col-sm-8">
									<select class="form-control" name="role_id">
										<?php 
											if(isset($role_arr)&&!empty($role_arr))
											{
												foreach($role_arr as $rowArr)
												{
													$selected=(isset($data['role_id'])&&$data['role_id']==$rowArr['role_id']?'selected':'');
													echo '<option value="'.$rowArr['role_id'].'" '.$selected.'>'.$rowArr['role_name'].'</option>';
												}
											}
										?>
									</select> 
								</div>
							</div> 
							
							<div class="form-group">
								<label class="col-sm-4 control-label" for="form-field-1"> 
								</label>
								<div class="col-sm-8">
									<label for="change"><input type="radio" id="change" onclick="cek_password($(this).val())" <?php echo $this->input->post('change')=="0"?'checked':($this->input->post('change')!=1?'checked':'')?> name="change" value="0"/> Password Tetap</label> 
									<label for="change_"><input type="radio" id="change_" name="change" onclick="cek_password($(this).val())" <?php echo $this->input->post('change')=="1"?'checked':''?> value="1" /> Ubah Password</label> 
								</div>
							</div> 
							<div class="form-group password" style="display:none">
								<label class="col-sm-4 control-label">
									Password *
								</label>
								<div class="col-sm-8">
									<input class="form-control" type="password" name="user_password" value="" />
								</div>
							</div> 
							<div class="form-group password"  style="display:none">
								<label class="col-sm-4 control-label">
									Konfirmasi Password *
								</label>
								<div class="col-sm-8">
									<input class="form-control" type="password" name="user_repassword" value="" />
								</div>
							</div> 
							<div class="form-group">
								<label class="col-sm-4 control-label" for="form-field-1">
									Keterangan
								</label>
								<div class="col-sm-8">
									<textarea class="form-control" name="user_keterangan"><?php echo $this->input->post('user_keterangan')?$this->input->post('user_keterangan'):(isset($data['user_keterangan'])?$data['user_keterangan']:''); ?></textarea>
								</div>
							</div>  
							<div class="form-group">
								<label class="col-sm-4 control-label" for="form-field-1"> 
								Status
								</label>
								<div class="col-sm-8">
									<label for="is_active"><input type="checkbox" id="is_active" name="is_active" <?php echo $this->input->post('is_active')=="1"?'checked':(isset($data['is_active'])&&$data['is_active']=='1'?'checked':''); ?> value="1" /> Aktifkan</label>
									<p><small>Centang untuk mengijinkan user login ke sistem</small></p>
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
	value=$('[name="change"]:checked').val();
	cek_password(value);
	setTimeout(function(){ 
		$('.custom_message').hide();
	}, 5000);	
});
function cek_pegawai(elem)
{
	nama=$('[name="pegawai_id"] option:selected').text();
	$('[name="user_karyawan"]').val(nama);
}
function cek_password(vlue)
{
	$('.password').hide();
	if(vlue=='1')
	{
		$('.password').show(); 
	}
}	
</script> 