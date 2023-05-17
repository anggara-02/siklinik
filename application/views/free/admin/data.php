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
					  
					   <div class="col-md-12">
							<div class="box box-warning">
								<div class="box-header with-border">
								  <h3 class="box-title"><i class="fa fa-search"></i> Pencarian</h3>
								  <div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
									</button>
								  </div>
								  </div>
								<div class="box-header with-border">
								  <div class="col-lg-6 col-md-6 col-sm-6"> 
										<form class="form-horizontal" id="psForm">
											<div class="form-group">
												<label class="col-sm-12">
												Nama Pasien
												</label>
												<div class="col-sm-8">
													<input type="text" name="pendaftaran_nama" id="pendaftaran_nama" class="form-control"/>
												</div>
											</div>
											 <div class="form-group mb-1">
												<label class="col-sm-12">
												Tgl. Pendaftaran
												</label>
												<div class="col-sm-4">
													<input type="text" data-date-format="dd-mm-yyyy" value="<?php echo ($this->input->get('date_start'))?$this->input->get('date_start'):date('d-m-Y')?>" id="date_start" class="form-control datepicker" placeholder="Tgl Awal">
												</div>
												<div class="col-sm-4 mb-1">
													<input type="text" data-date-format="dd-mm-yyyy" value="<?php echo $this->input->get('date_end')?$this->input->get('date_end'):date('d-m-Y')?>" id="date_end" class="form-control datepicker" placeholder="Tgl Akhir">
												</div>
											</div>
											<div class="form-group">
												 <label class="col-sm-12">
												</label>
												<div class="col-sm-12">
												  <button class="btn btn-sm btn-success" shortcut="ctrl+enter" onclick="load_table();return false;">Cari</button>
												</div>
											</div>
										</form>
								  </div>
										  
								<div class="col-lg-6 col-md-6 col-sm-6">   
									<div class="callout callout-warning mb-1">
										<h4><i class="fa fa-exclamation-triangle"></i> Catatan</h4> 
										<p class="note_shortcut_grid"></p>
									</div>
								</div>   
								</div> 		  
							</div> 		  
						</div> 		  
					
					<div class="col-md-12">
						<div class="box box-success">
							<div class="box-body">
								<?php if(common_lib::hak_akses($access,'add','menu')=='1'){?>
									<a class="btn btn-sm btn-success" shortcut="f2" href="<?php echo site_url('admin/'.$class.'/add');?>">Tambah</a>
								<?php } ?>		
								<table id="flexygrid" style="display:none;"></table>
									
							</div> 
						</div> 
					</div> 
				</div> 
                 
 <script>
 
            $("#flexygrid").flexigrid({
                dataType: 'json',
                colModel: [ 
                    { display: 'No', name: 'no', width: 30, sortable: true, nowrap:false, align: 'right' },
                    // { display: 'Edit', name: 'action', width: 80, sortable: true, nowrap:false, align: 'center' },
                    // { display: 'Hapus', name: 'delete', width: 80, sortable: true, nowrap:false, align: 'center' },
                    { display: 'Tgl Pasien', name: 'pendaftaran_tanggal', width: 120, sortable: true, nowrap:false, align: 'left' }, 
                    { display: 'No RM', name: 'pasien_rm_number', width: 80, sortable: true, nowrap:false, align: 'left' }, 
                    { display: 'Nama', name: 'pendaftaran_nama', width: 300, sortable: true, nowrap:false, align: 'left' }, 
                    { display: 'Tgl Lahir', name: 'pendaftaran_birthdate', width: 100, sortable: true, nowrap:false, align: 'left' }, 
                    { display: 'No Telp/Hp', name: 'pendaftaran_telp', width: 150, sortable: true, nowrap:false, align: 'left' }, 
                    { display: 'Alamat', name: 'pendaftaran_alamat', width: 280, sortable: true,  nowrap:false, align: 'left' }, 
                    // { display: 'Medsos', name: 'pendaftaran_medsos', width: 100, sortable: true, nowrap:false, align: 'left' }, 
                    // { display: 'Riwayat Pemakaian Sebelumnya', name: 'pendaftaran_riwayat', width: 300, sortable: true, nowrap:false, align: 'center' }, 
                    // { display: 'Kondisi Sebelumnya', name: 'pendaftaran_kondisi_kulit', width: 300, sortable: true, nowrap:false, align: 'center' }, 
                ],
                buttons: [
                ],
                buttons_right: [ 
                ],
              
                sortname: "id",
                sortorder: "asc",
                usepager: true,
                title: ' ',
                useRp: true,
                rp: 50,
                showTableToggleBtn: true,
                showToggleBtn: true,
                width: 'auto', 
                resizable: false,
                dragmove: false,
                singleSelect: false,
                nowrap:false,
            });


             $(document).ready(function() { 
			 
                $( ".datepicker" ).datepicker({
                defaultDate: "+1w",
					changeMonth: true,
					numberOfMonths: 3,
					dateFormat: "dd-mm-yyyy",
					onClose: function( selectedDate ) {
					$( ".datepicker" ).datepicker( "option", "maxDate", selectedDate );
					}
                });    
				
                load_table(); 
            });

            function load_table() {
                var pendaftaran_nama=$("#pendaftaran_nama").val(); 
                var date_start=$("#date_start").val(); 
                var date_end=$("#date_end").val(); 
                var link_service='?pendaftaran_nama='+pendaftaran_nama
				+'&date_start='+date_start
				+'&date_end='+date_end
                ;
                $("#flexygrid").flexOptions({url:'<?php echo site_url('admin/'.$class.'/get_data'); ?>'+link_service}).flexReload(); 
            }

 </script>