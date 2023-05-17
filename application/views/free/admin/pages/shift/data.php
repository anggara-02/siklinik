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
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
                	<h4>Manajemen Shift</h4>
              	</div>
				<div class="card-body">
				 
					  <?php 
							if(trim($status)!='' AND trim($message)!=''){
						  ?> 
								<div class="col-sm-12 control-label custom_message"> 
									<div class="callout  mb-1 <?php echo ($status==200)?'callout-success':'callout-danger'; ?>">
									  <div style="text-align:left;"><i class="<?php echo ($status==200)?'icon-thumbs-up':'icon-remove'; ?>"></i><?php echo $message; ?></div>
									  </div>
								</div> 
						  <?php
							}
						  ?>  
					<form action="#" method="POST" class="needs-validation" novalidate="">	 
						<div class="row">
						<?php foreach($shiftArr as $arr){?>
												
							<div class="col-md-6">	
									<div class="row mb-4">
										<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Shift</label>
										<div class="col-sm-12 col-md-7">
											<input type="hidden" class="form-control" name="shift_id[]" value="<?php echo $arr['shift_id'];?>" readonly="">
											<input type="text" class="form-control" name="shift_name[]" value="<?php echo $arr['shift_name'];?>" readonly="">
										</div>
									</div>
									<div class="row mb-4">
										<label class="col-form-label text-md-right col-12 col-md-2 col-lg-3">Jam</label>
										<div class="col-sm-12 col-md-4">
											<input type="time" name="shift_hour_start[]" required value="<?php echo $arr['shift_hour_start'];?>" class="form-control">
										</div>
										<div class="col-sm-12 col-md-4">
											<input type="time" name="shift_hour_end[]" required value="<?php echo $arr['shift_hour_end'];?>" class="form-control">
										</div>
									</div>
									<div class="row mb-4">
										<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Shift</label>
										<div class="col-sm-12 col-md-7">
											<select name="shift_is_active[]" class="form-input form-select2 form-control">
												<option value="1" <?php echo ($arr['shift_is_active']=='1')?'selected':''?>>Aktif</option>
												<option value="0" <?php echo ($arr['shift_is_active']=='0')?'selected':''?>>Non Aktif</option>
											</select>
										</div>
									</div>
							</div> 
						<?php } ?>
						
						</div>
						<?php if(common_lib::hak_akses($access,'edit','menu')=='1'){?>
						<div class="row">
							<div class="col-sm-12 col-md-12">
								<hr/>
								<center>
									<input onclick="return confirm('Edit?');return false;" type="submit" name="save" value="Edit" shortcut="ctrl+enter" class="btn btn-success">
								</center>
							</div>
						</div>
						<?php } ?>
					</form>					
			  </div> 
		  </div> 
	  </div> 
  </div> 
</div> 
                 
 <script>
 
            $("#flexygrid").flexigrid({
                dataType: 'json',
                colModel: [ 
                    { display: 'No', name: 'no', width: 30, sortable: true, nowrap:false, align: 'right' },
                    { display: 'Edit', name: 'action', width: 80, sortable: true, nowrap:false, align: 'center' },
                    { display: 'Hapus', name: 'delete', width: 80, sortable: true, nowrap:false, align: 'center' },
                    { display: 'Nama Kemasan', name: 'satuan_name', width: 100, sortable: true, nowrap:false, align: 'center' }, 
                    { display: 'Keterangan', name: 'satuan_keterangan', width: 150, sortable: true, nowrap:false, align: 'center' }, 
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
                load_table(); 
				setTimeout(function(){ 
					$('.custom_message').hide();
				}, 5000);	
            });

            function load_table() {
                var satuan_name=$("#satuan_name").val(); 
                var link_service='?satuan_name='+satuan_name
                ;
                $("#flexygrid").flexOptions({url:'<?php echo site_url('admin/'.$class.'/get_data'); ?>'+link_service}).flexReload(); 
            }

 </script>