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
						<!--<a href="#" onclick="add_form()" class="btn btn-primary add" shortcut="f2">Tambah</a>-->
					<?php } ?>	
				</div>						
					<div class="col-md-auto px-2">
						<div class="input-group">
							<input type="date" data-date-format="dd-mm-yyyy" value="<?php echo ($this->input->get('start_date'))?$this->input->get('start_date'):date('Y-m-d')?>" id="date_start" class="form-control datepicker" placeholder="Tgl Awal" size="10">
							<input type="date" data-date-format="dd-mm-yyyy" value="<?php echo $this->input->get('end_date')?$this->input->get('end_date'):date('Y-m-d')?>" id="date_end" class="form-control datepicker" placeholder="Tgl Akhir" size="10">

							<input type="text" id="filter_search" autocomplete="off" name="filter_search" class="form-control input-sm" placeholder="Search" size="20">
							 
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
				
				<table id="datatables" class="table table-striped table-bordered display nowrap" style="width: 100%">
					 
				</table>
			</div> 
		  </div> 
	  </div>  
	</div> 
</div> 

 
 <script>
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
            });

			/* konfirmasi validasi sebelum delete baris */
            function validasi_delete(id) {
				swal({
					title: 'Apakah anda yakin?',
					text: 'Anda akan menghapus user ini',
					icon: 'warning',
					buttons: true,
					dangerMode: true,
				})
				.then((confirm) => {
					if (confirm) {
						window.location.href ="<?php echo site_url('admin/pemeriksaan/delete');?>/"+id;
						return true;
					}
					else
					{
						return false;
					}
					
				});
						return false;
			}
            
			/* fitur aktif/nonaktifkan user */
			function send_to_pemeriksaan(status,pemeriksaan_id) {
				text_status=(status=='laboratorium')?'Laboratorium':'-';
				swal({
					title: 'Apakah anda yakin?',
					text: 'Anda akan mengirimkan data ini ke bagian '+text_status+'.',
					icon: 'warning',
					buttons: true,
					dangerMode: true,
				})
				.then((confirm) => {
					if (confirm) {
						$.ajax({
						   url:'<?php echo site_url('admin/'.$class.'/send_to_lab');?>',
						   type:'POST',
						   dataType:'json',
						   data:'pemeriksaan_id='+pemeriksaan_id
						   +'&status='+status
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
              
            function load_table() {
				if($('#datatables thead>tr').length>0)
				{
					$('#datatables').dataTable().fnDestroy();
				}
				
                var search=$("#filter_search").val();   
                var date_start=$("#date_start").val();   
                var date_end=$("#date_end").val();   
                var link_service='?search='+search
				+'&date_start='+date_start
				+'&date_end='+date_end
                ; 
				dataReload(link_service);
            }

			
			function dataReload(link_service){
			  $('#datatables').DataTable({
			    responsive: true,
				scrollX: true,
				processing: true,
				serverSide: true,   
				searching: false,
				// dom: ' Bt<"table-footer clearfix"<"DT-label"i><"DT-pagination"p>>', 				
				aoColumnDefs: [{ "bSortable": false, "aTargets": [ "_all" ],"orderable": false }],
				lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
				'ajax': {
				  url: '<?php echo base_url('admin/'.$class.'/get_datatable');?>'+link_service,
				  type: 'post',
				  dataType: 'json',
				},
				'columns':[
					{ title: "No.", data: "no","width":"80px", visible: true}, 
					{ title: "Aksi", data: "action","width":"200px", visible: true},
					{ title: "No Pendaftaran", data: "pendaftaran_no", visible: true},
					{ title: "No RM", data: "pendaftaran_pasien_rm", visible: true},
					{ title: "Tgl Pendaftaran", data: "pendaftaran_date", visible: true},
					{ title: "Nama Pasien", data: "pendaftaran_pasien_name", visible: true},
					{ title: "Jenis Kelamin", data: "pendaftaran_pasien_gender", visible: true},
					{ title: "Tgl Lahir", data: "pendaftaran_date", visible: true},
					{ title: "Jenis Penjaminan", data: "pendaftaran_penjamin_nama", visible: true},
					{ title: "Status", data: "pemeriksaan_status", visible: true}
				],
			  });
				
				setTimeout(function(){ $("#datatables th").removeClass("sorting_asc");}, 1000);
			}     

			
            function load_tableold() {
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