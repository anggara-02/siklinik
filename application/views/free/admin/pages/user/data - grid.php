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
           
<div class="section-body">
	<div class="card">	
	  <?php 
			if(trim($status)!='' AND trim($message)!=''){
		  ?> 
				<div class="col-sm-12 control-label custom_message" id="custom_message"> 
					<div class="callout  mb-1 <?php echo ($status==200)?'callout-success':'callout-danger'; ?>">
					  <div style="text-align:left;"><i class="<?php echo ($status==200)?'icon-thumbs-up':'icon-remove'; ?>"></i><?php echo $message; ?></div>
					  </div>
				</div> 

		  <?php
			}
			else{
		  ?>	
				<div class="col-sm-12 control-label custom_message" style="display:none" id="custom_message"> 
					<div class="callout  mb-1 <?php echo ($status==200)?'callout-success':'callout-danger'; ?>">
					  <div style="text-align:left;" class="message">-</div>
					  </div>
				</div> 
		  <?php } ?>		  
	
<div class="section-body">
	<div class="card">
		<div class="p-4 border-bottom border-light">
			<div class="row mx-n2">
				<div class="col-md-auto mb-3 mb-md-0 px-2">
					<?php if(common_lib::hak_akses($access,'add','menu')=='1'){?>
						<!--<a href="<?php echo site_url('admin/'.$class.'/add');?>" class="btn btn-primary add" shortcut="f2">Tambah</a>-->
						<a href="#" onclick="add_form()" class="btn btn-primary add" shortcut="f2">Tambah</a>
					<?php } ?>	
				</div>			
					<div class="col-md-auto px-2 ml-auto"> 											
						<select class="form-control" id="filter_role_id" name="filter_role_id">
							<option value="">Semua Role</option>
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
					
					<div class="col-md-auto px-2">
						<div class="input-group">
							<input type="text" id="filter_user_name" autocomplete="off" name="filter_user_name" class="form-control input-sm" placeholder="Search" size="20">
							<div class="input-group-append">
								<button class="btn btn-primary" shortcut="ctrl+enter" onclick="load_table();return false;"><i class="fa fa-search"></i></button>
							</div> 
						</div>
					</div>
				</div>
			</div>
		</div> 
	</div> 
	<div class="col-md-12">
		<div class="box box-success">
			<div class="box-body"> 
				<div class="clearfix"></div>								
				<table id="flexygrid" style="display:none;"></table>								
			</div> 
		  </div> 
	  </div>  
	</div> 
</div> 


<div class="modal fade" id="modal-form" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
		
		<form class="form-horizontal" id="FormData" method="POST" action="" enctype="multipart/form-data">
			<div class="modal-header">
				<h5 class="modal-title">Form Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">			
				<div class="col-sm-12 control-label custom_message" style="display:none" id="custom_message"> 
					<div class="callout  mb-1 <?php echo ($status==200)?'callout-success':'callout-danger'; ?>">
					  <div style="text-align:left;" class="message">-</div>
					  </div>
				</div> 
				<div class="form-group">
					<label for="" class="form-label">Nama Karyawan</label>
					<input type="text" name="user_karyawan" class="form-control" value="">
				</div>
				<div class="form-group">
					<label for="" class="form-label">Username</label>
					<input type="text" name="user_name" class="form-control" value="">
				</div>
				<div class="form-group password">
					<label for="" class="form-label">Password</label>
					<input type="password" name="user_password" class="form-control" value="">
				</div>
				<div class="form-group">
					<label for="" class="form-label">Role</label>					
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
				<div class="form-group">
					<label for="" class="form-label">SIP/STRA</label>
					<input type="text" name="user_sip" class="form-control" value="">
				</div>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="user_id" class="form-control" value="0">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button type="button" class="btn btn-primary" onclick="return trx_save();">Simpan</button>
			</div>
		</form>
		</div>
	</div>
</div>

 <script>
 
            $("#flexygrid").flexigrid({
                dataType: 'json',
                colModel: [ 
                    { display: 'No', name: 'no', width: 30, sortable: true, align: 'right' },
                    { display: 'Aksi', name: 'action', width: 150, sortable: true, align: 'center' },
                    { display: 'Username', name: 'user_name', width: 100, sortable: true, align: 'center' },
                    { display: 'Jenis Akun', name: 'role_name', width: 100, sortable: true, align: 'center' },
                    { display: 'Status', name: 'is_active', width: 70, sortable: true, align: 'center' },
                    { display: 'Keterangan', name: 'user_keterangan', width: 150, sortable: true, align: 'center' },
                    { display: 'Terakhir Login', name: 'last_login', width: 350, sortable: true, align: 'left' }, 
                ],
                buttons: [
                ],
                buttons_right: [ 
                ],
              
                // sortname: "id",
                // sortorder: "asc",
                usepager: true,
                title: ' ',
                useRp: true,
                rp: 50,
                showTableToggleBtn: false,
                showToggleBtn: false,
                width: 'auto', 
                resizable: false,
                dragmove: false,
                singleSelect: false,
                nowrap:false,
            });

			
			function custom_message(status,message)
			{			
				$('.custom_message').show();
				if(status!=200)
				{
					$('.custom_message').find('.callout').addClass('callout-danger');
					$('.custom_message').find('.callout').removeClass('callout-success');
				}
				else
				{ 
					$('.custom_message').find('.callout').addClass('callout-success');
					$('.custom_message').find('.callout').removeClass('callout-danger');
				}
					$('.custom_message').find('.message').html(message); 
					$(this).scrollTop(0);
					setTimeout(function(){ $('.custom_message').hide(); }, 5000);
			}
			

             $(document).ready(function() { 
                load_table(); 
				// setTimeout(function(){ 
					// $('.custom_message').hide();
				// }, 5000);	
            });

            function validasi_delete() {
				swal({
					title: 'Apakah anda yakin?',
					text: 'Anda akan menghapus user ini',
					icon: 'warning',
					buttons: true,
					dangerMode: true,
				})
				.then((confirm) => {
					if (confirm) {
						return true;
					}
					else
					{
						return false;
					}
					
				});
			}
            
			function trx_aktif(status,user_id) {
				text_status=(status=='1')?'mengaktifkan':'menonaktifkan';
				swal({
					title: 'Apakah anda yakin?',
					text: 'Anda akan '+text_status+' user ini',
					icon: 'warning',
					buttons: true,
					dangerMode: true,
				})
				.then((confirm) => {
					if (confirm) {
						$.ajax({
						   url:'<?php echo site_url('admin/'.$class.'/action_is_active');?>',
						   type:'POST',
						   dataType:'json',
						   data:'user_id='+user_id
						   +'&is_active='+status
						   ,
						   success:function(response){
								   custom_message(response['status'],response['message']);
								   reset_trx();
						   },
						   error:function(){
								alert('terjadi kesalahan saat validasi'); 
								$('.modal-footer').show();	
								$('.button').show();
								$('.btn').prop('disabled',false);			
						   }
					   });	
					}
				});
			}
            
			function add_form() {
				$('.password').show();
				$('#modal-form').modal('show');
				reset_trx();
			}
			
            function edit_form(user_id) {
				$.ajax({
				   url:'<?php echo site_url('admin/'.$class.'/action_data_form');?>',
				   type:'GET',
				   dataType:'json',
				   data:'user_id='+user_id,
				   success:function(response){
					   reset_trx();
					   if(response['status']==200)
					   {
							$('#FormData').find('[name="user_karyawan"]').val(response['data']['user_karyawan']);
							$('#FormData').find('[name="user_name"]').val(response['data']['user_name']);
							$('#FormData').find('[name="role_id"]').val(response['data']['role_id']);
							$('#FormData').find('[name="user_sip"]').val(response['data']['user_sip']);
							$('#FormData').find('[name="user_id"]').val(response['data']['user_id']);
							$('#FormData').find('[name="user_password"]').val('-');
							$('#FormData').find('.password').hide();
							$('#modal-form').modal('show');
					   }
					   else
					   {
						   custom_message(response['status'],response['message']);						   
					   }
				   },
				   error:function(){
						alert('terjadi kesalahan saat validasi'); 
						$('.modal-footer').show();	
						$('.button').show();
						$('.btn').prop('disabled',false);			
				   }
			   });	
			}
			
            function trx_validation() {
				$.ajax({
				   url:'<?php echo site_url('admin/'.$class.'/action_validation');?>',
				   type:'POST',
				   dataType:'json',
				   data:$('#FormData').serialize(),
				   success:function(response){
					   if(response['status']==500)
					   {
						   custom_message(response['status'],response['message']);
							// alert(response['status']);
					   }
					   else{
						   swal({
								title: 'Apakah anda yakin?',
								text: 'Pastikan data sudah sesuai',
								icon: 'warning',
								buttons: true,
								dangerMode: true,
							})
							.then((confirm) => {
								if (confirm) {
									trx_stored();
								}
							});
					   }
				   },
				   error:function(){
						alert('terjadi kesalahan saat validasi'); 
						$('.modal-footer').show();	
						$('.button').show();
						$('.btn').prop('disabled',false);			
				   }
			   });	
			}
			
            function reset_trx() {
				$('#modal-form').find('input,textarea,select').val('');
			    $('#FormData').find('textarea').html('');
				load_table();
			}
			
            function trx_stored() {
				$.ajax({
				   url:'<?php echo site_url('admin/'.$class.'/action_stored');?>',
				   type:'POST',
				   dataType:'json',
				   data:$('#FormData').serialize(),
				   success:function(response){
						  custom_message(response['status'],response['message']);
						  reset_trx();
						  $('#modal-form').modal('hide');
				   },
				   error:function(){
						alert('terjadi kesalahan saat validasi'); 
						$('.modal-footer').show();	
						$('.button').show();
						$('.btn').prop('disabled',false);
						session_id='';			
				   }
			   });	
			}
			
            function trx_save() {
				trx_validation();
			}
			
            function load_table() {
                var user_name=$("#filter_user_name").val();  
                var role_id=$("#filter_role_id").val();  
                var link_service='?user_name='+user_name
				+'&role_id='+role_id
                ;
					/* $.ajax({
					   url:'<?php echo site_url('admin/'.$class.'/get_data');?>'+link_service,
					   type:'GET',
					   dataType:'json',
					   success:function(response){
						  
					   },
					   error:function(){
							alert('terjadi kesalahan saat validasi'); 
							$('.modal-footer').show();	
							$('.button').show();
							$('.btn').prop('disabled',false);
							session_id='';			
					   }
				   }); */
						
                $("#flexygrid").flexOptions({url:'<?php echo site_url('admin/'.$class.'/get_data'); ?>'+link_service}).flexReload(); 
            }

 </script>