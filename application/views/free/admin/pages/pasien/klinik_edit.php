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
<div class="section-header">
	<div class="section-header-back">
      	<a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Pasien Klinik</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item"><a href="#">Dashboard</a></div>
      	<div class="breadcrumb-item">Pasien Klinik</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="card-header">
        	<h4>Form Pasien Klinik</h4>
      	</div>
      	<div class="card-body">
			
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
		
			<form action="#" id="formApotek" method="POST" enctype="multipart/form-data" enctype="multipart/form-data">
			<div class="table-responsive">
				<table class="table">
					<tbody>
						<tr>
							<td width="10%">No RM</td>
							<td width="40%"><?php echo isset($pasien_rm)?$pasien_rm:'-';?></td>
						</tr>
						<tr>
							<td  width="10%">Nama Pasien</td>
							<td  width="40%">
								<input type="text" id="pasien_name" autocomplete="off" name="pasien_name" class="form-control input-sm" value="<?php echo $this->input->post('pasien_name')?$this->input->post('pasien_name'):(isset($pasien_name)?$pasien_name:'-');?>">
							</td>
							<td  width="10%">NIK</td>
							<td  width="40%">
								<input type="text" id="pasien_nik" autocomplete="off" name="pasien_nik" class="form-control input-sm" value="<?php echo $this->input->post('pasien_nik')?$this->input->post('pasien_nik'):(isset($pasien_nik)?$pasien_nik:'-');?>">
							</td>
						</tr>
						<tr>
							<td width="10%">Jenis Penjaminan</td>
							<td width="40%">
								<select name="pasien_penjamin_id" class="form-control">
									<?php foreach($penjamin_arr as $arr) { ?>
									<option value="<?php echo $arr['penjamin_id'];?>" <?php echo $this->input->post('penjamin_id')==$arr['penjamin_id']?'selected':(isset($pasien_penjamin_id)&&$pasien_penjamin_id==$arr['penjamin_id']?'selected':'');?>>
										<?php echo $arr['penjamin_name'];?>
									</option>
									<?php } ?>
								</select>
							</td>
							<td width="10%">Tgl Lahir</td>
							<td width="40%"><input type="date" id="pasien_birthdate" autocomplete="off" name="pasien_birthdate" class="form-control input-sm" value="<?php echo $this->input->post('pasien_birthdate')?$this->input->post('pasien_birthdate'):(isset($pasien_birthdate)?$pasien_birthdate:'-');?>"></td>
						</tr>
						<tr>
							<td width="10%">Jenis Kelamin</td>
							<td width="40%">
								
								<select name="pasien_gender" class="form-control">
									<option value="male" <?php echo $this->input->post('pasien_gender')=='male'?'selected':(isset($pasien_gender)&&$pasien_gender=='male'?'selected':'');?>>Laki-Laki</option>
									<option value="female" <?php echo $this->input->post('pasien_gender')=='female'?'selected':(isset($pasien_gender)&&$pasien_gender=='female'?'selected':'');?>>Perempuan</option>
									
								</select>
							</td>
							<td width="10%">Tempat Lahir</td>
							<td width="40%">
							<textarea type="text" id="pasien_birthplace" autocomplete="off" name="pasien_birthplace" class="form-control input-sm"><?php echo $this->input->post('pasien_birthplace')?$this->input->post('pasien_birthplace'):(isset($pasien_birthplace)?$pasien_birthplace:'-');?></textarea>
							</td>
						</tr>
						<tr>
							<td width="10%">No Penjaminan</td>
							<td width="40%">
								<input type="text" id="pasien_penjamin_no" autocomplete="off" name="pasien_penjamin_no" class="form-control input-sm" value="<?php echo $this->input->post('pasien_penjamin_no')?$this->input->post('pasien_penjamin_no'):(isset($pasien_penjamin_no)?$pasien_penjamin_no:'-');?>">
							</td>
							<td width="10%">Alamat</td>
							<td width="40%">
							<textarea type="text" id="pasien_address" autocomplete="off" name="pasien_address" class="form-control input-sm"><?php echo $this->input->post('pasien_address')?$this->input->post('pasien_address'):(isset($pasien_address)?$pasien_address:'-');?></textarea>
							</td>
						</tr>
						<tr>
							<td width="10%">Ibu</td>
							<td width="40%">
								<input type="text" id="pasien_ibu" autocomplete="off" name="pasien_ibu" class="form-control input-sm" value="<?php echo $this->input->post('pasien_ibu')?$this->input->post('pasien_ibu'):(isset($pasien_ibu)?$pasien_ibu:'-');?>">
							</td>
							<td width="10%">Pernikahan</td>
							<td width="40%">
								<select name="pasien_pernikahan" class="form-control">
									<option value="kawin" <?php echo $this->input->post('pasien_pernikahan')=='kawin'?'selected':(isset($pasien_pernikahan)&&$pasien_pernikahan=='kawin'?'selected':'');?>>Kawin</option>
									<option value="belum kawin" <?php echo $this->input->post('pasien_pernikahan')=='belum kawin'?'selected':(isset($pasien_pernikahan)&&$pasien_pernikahan=='belum kawin'?'selected':'');?>>Belum Kawin</option>
									
								</select>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		
		 
				
			<div class="form-group row mb-5">
				<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">&nbsp;</label>
				<div class="col-sm-12 col-md-8">
					<input type="hidden" class="form-control" name="pasien_id" value="<?php echo (isset($pasien_id)?$pasien_id:'');?>"> 
					<button class="btn btn-primary" name="submit" value="kasir">Simpan</button>
				</div>
			</div>
			</form>
			
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>No</th>
							<th>Aksi</th>
							<th>Tgl Pemeriksaan</th>
							<!--th>Poli</th-->
						</tr>
					</thead>
					<tbody>
					<?php 
					$no =0;
					foreach($pemeriksaan_arr as $arr){
						$no++;
						?>
						<tr>
							<td><?php echo $no;?></td>
							<td>
								<a class="btn btn-info btn-icon" href="<?php echo base_url('admin/pemeriksaan/view/'.intval($arr['pemeriksaan_id']));?>">
								<i class="fa fa-eye"></i>
								</a>
							</td>
							<td>
								<?php echo date('d-m-Y H:i:s',strtotime($arr['pemeriksaan_date']));?>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
			
		</div>
	</div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/autoNumeric.js"></script>

<script type="text/javascript">
	$(function(){
		$('.form-select2').select2();
		find_obat_nr();
		find_obat_r();
		currency_rupiah();
		calculate_subtotal();
	});
	
$('#formApotek').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});


function calculate_disc(tipe)
{
	
	apotek_subtotal=$('[name="apotek_subtotal"]').autoNumeric('get')*1;
	rp=$('[name="apotek_disc_rp"]').autoNumeric('get')*1;
	persen=$('[name="apotek_disc_persen"]').val()*1;
	disc=0;
	if(tipe=='rp')
	{
		disc=rp;
		$('[name="apotek_disc_persen"]').val('0');
	}
	else if(tipe=='persen')
	{
		disc=(apotek_subtotal*persen/100);
		$('[name="apotek_disc_rp"]').autoNumeric('set',0);
	}
	
	$('[name="apotek_disc"]').val(disc);
}
function calculate_grandtotal()
{
	subtotal=$('[name="apotek_subtotal"]').autoNumeric('get')*1;
	apotek_tuslah=$('[name="apotek_tuslah"]').autoNumeric('get')*1;
	apotek_embalage=$('[name="apotek_embalage"]').autoNumeric('get')*1;
	apotek_disc=$('[name="apotek_disc"]').val()*1;
	
	grandtotal=subtotal+apotek_tuslah+apotek_embalage-apotek_disc;
	
	apotek_disc=$('[name="apotek_grandtotal"]').autoNumeric('set',grandtotal);
	
}

function calculate_subtotal()
{
	total=0;
	$('.add_row_r > tr').each(function(){
			r_total=$(this).find('.obat_total').val();
			total+=(r_total*1);
	});

	$('.add_row_nr > tr').each(function(){
			r_total=$(this).find('.obat_total').val();
			total+=(r_total*1);
	});
	
	$('[name="apotek_subtotal"]').autoNumeric('set',total);
	calculate_grandtotal();
}

function add_row_r()
{
	r_is_obat=$('[name="r_is_obat"]').val();
	r_obat_resep=$('[name="r_obat_resep"]').val();
	r_obat_dosis=$('[name="r_obat_dosis"]').val();
	r_obat_aturan_pakai=$('[name="r_obat_aturan_pakai"]').val();
	r_obat_name=$('[name="r_obat_name"]').val();
	r_obat_id=$('[name="r_obat_id"]').val();
	r_obat_price=$('[name="r_obat_price"]').val();
	r_obat_kemasan_name=$('[name="r_obat_kemasan_id"] option:selected').text();
	r_obat_kemasan_id=$('[name="r_obat_kemasan_id"]').val();
	r_obat_qty=$('[name="r_obat_qty"]').val();
	r_obat_total=$('[name="r_obat_total"]').autoNumeric('get');
	// diagnosis_name=$('[name="diagnosis_id"]  option:selected').text(); 
	if(r_obat_resep==''||r_obat_dosis==''||r_obat_aturan_pakai==''||r_obat_name==''||r_obat_id==''||r_obat_price==''||r_obat_qty==''||r_obat_kemasan_id==''||r_obat_total=='')
	{
		alert('Silahkan lengkapi isi resep');
	}
	else
	{
		
		r_obat_price=r_obat_total/r_obat_qty;
		num=$('.tr_data').length;
		lain=0;
		if($('tr.trr_'+r_is_obat+'_'+r_obat_id+'_'+r_obat_kemasan_id+'_'+r_obat_resep).find('.produk_qty').length>0)
		{
			lain=$('tr.trr_'+r_is_obat+'_'+r_obat_id+'_'+r_obat_kemasan_id+'_'+r_obat_resep).find('.r_obat_qty').val();
			r_obat_price=$('tr.trr_'+r_is_obat+'_'+produk_id_div+'_'+r_obat_kemasan_id+'_'+r_obat_resep).find('.r_obat_price').val();
			// penjualan_detail_id=$('tr.trr_'+produk_id_div).find('.penjualan_detail_id').val();
		}
		
		r_obat_qty=(r_obat_qty*1)+(lain*1);
		
		
		$('tr.trr_'+r_is_obat+'_'+r_obat_id+'_'+r_obat_kemasan_id+'_'+r_obat_resep).remove();
		html='<tr class="tr_data trr_'+r_is_obat+'_'+r_obat_id+'_'+r_obat_kemasan_id+'_'+r_obat_resep+'">'
					+'<td class="td">'
						+r_obat_resep 
						+'<input type="hidden" readonly class="form-control obat_resep" id="obat_resep" name="obat_resep[]" value="'+r_obat_resep+'">'
					+'</td>'
					+'<td class="td">'
						+r_obat_name 
						+'<input type="hidden" readonly class="form-control obat_name" id="obat_name" name="obat_name[]" value="'+r_obat_name+'">'
						+'<input type="hidden" class="form-control obat_id" readonly name="obat_id[]" value="'+r_obat_id+'">'
						+'<input type="hidden" class="form-control obat_price" readonly name="obat_price[]" value="'+r_obat_price+'">'
						+'<input type="hidden" class="form-control is_obat" readonly name="is_obat[]" value="'+r_is_obat+'">'
						+'<input type="hidden" class="form-control obat_type" readonly name="obat_type[]" value="resep">'
					+'</td>'
					+'<td class="td">'
						+r_obat_kemasan_name 
						+'<input type="hidden" readonly class="form-control obat_kemasan_id" id="obat_kemasan_id" name="obat_kemasan_id[]" value="'+r_obat_kemasan_id+'">'
						+'<input type="hidden" readonly class="form-control obat_kemasan_name" id="obat_kemasan_name" name="obat_kemasan_name[]" value="'+r_obat_kemasan_name+'">'
					+'</td>'
					+'<td class="td">'
						+r_obat_qty 
						+'<input type="hidden" readonly class="form-control obat_qty" id="obat_qty" name="obat_qty[]" value="'+r_obat_qty+'">'
					+'</td>'
					+'<td class="td">'
						+r_obat_dosis 
						+'<input type="hidden" readonly class="form-control obat_qty" id="obat_dosis" name="obat_dosis[]" value="'+r_obat_dosis+'">'
					+'</td>'
					+'<td class="td">'
						+r_obat_aturan_pakai
						+'<input type="hidden" readonly class="form-control obat_aturan_pakai" id="obat_dosis" name="obat_aturan_pakai[]" value="'+r_obat_aturan_pakai+'">'
					+'</td>'
					+'<td class="td">'
						+r_obat_total 
						+'<input type="hidden" readonly class="form-control obat_total" id="obat_total" name="obat_total[]" value="'+r_obat_total+'">'
					+'</td>'
					+'<td class="td">'
						+'<button class="btn btn-danger btn-clone4 btn-sm" type="button" onclick="$(this).parent().parent().remove();calculate_subtotal();return false;"><i class="fa fa-trash"></i></button>'
					+'</td>'
			+'</tr>'
			;
				
		$('.add_row_r').append(html);
		
		r_obat_resep=$('[name="r_search_obat_name"]').val('');
		r_obat_resep=$('[name="r_obat_resep"]').val('');
		r_obat_dosis=$('[name="r_obat_dosis"]').val('');
		r_obat_aturan_pakai=$('[name="r_obat_aturan_pakai"]').val('');
		r_obat_name=$('[name="r_obat_name"]').val('');
		r_obat_id=$('[name="r_obat_id"]').val('');
		r_obat_price=$('[name="r_obat_price"]').val('');
		r_obat_kemasan_id=$('[name="r_obat_kemasan_id"]').val('');
		r_obat_qty=$('[name="r_obat_qty"]').val('');
		r_is_obat=$('[name="r_is_obat"]').val('');
		r_obat_total=$('[name="r_obat_total"]').autoNumeric('set','');
		calculate_subtotal();
	}
}

function calculate_r()
{
	// $('r_obat_kemasan_id')
	konversi=$('#r_obat_kemasan_id option:selected').attr('konversi');
	// konversi=$("#r_obat_kemasan_id").select2().find(":selected").data("konversi");
	r_obat_price=$('[name="r_obat_price"]').val();
	r_obat_qty=$('[name="r_obat_qty"]').val();
	total=r_obat_price*r_obat_qty*konversi;
	// alert(r_obat_price+'*'+r_obat_qty+'*'+konversi);
	$('[name="r_obat_total"]').autoNumeric('set',total);
	
	return false;
}

function calculate_nr()
{
	// $('nr_obat_kemasan_id')
	konversi=$('#nr_obat_kemasan_id option:selected').attr('konversi');
	// konversi=$("#nr_obat_kemasan_id").select2().find(":selected").data("konversi");
	nr_obat_price=$('[name="nr_obat_price"]').val();
	nr_obat_qty=$('[name="nr_obat_qty"]').val();
	total=nr_obat_price*nr_obat_qty*konversi;
	// alert(nr_obat_price+'*'+nr_obat_qty+'*'+konversi);
	$('[name="nr_obat_total"]').autoNumeric('set',total);
	
	return false;
}

function get_kemasan(id,type)
{ 
	$.ajax({
	   url:'<?php echo base_url();?>admin/<?php echo $class?>/get_kemasan_by_id',
	   type:'post',
	   dataType:'json',
	   data:'id='+id+'&type='+type,
	   success:function(response){
		   html='';
		   if(type=='1')
		   {
			html+='<option value="">Silahkan Pilih</option>';
		   }
		   if(response.length>0)
		   {
			   for(i=0;i<response.length;i++)
			   {
				   html+='<option value="'+response[i].kemasan_id+'" konversi="'+response[i].konversi+'">'+response[i].kemasan_name+'</option>';				   
			   }
		   }
		   
		   $('#nr_obat_kemasan_id').html(html);
		  $('#nr_obat_kemasan_id').focus();
		  $('#nr_obat_kemasan_id').select();
		  
		  
		   if(type=='0')
		   {
				calculate_nr();
		   }
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

function find_obat_nr()
{ 
	  var cacheItem = {};
	  $("#nr_search_obat_name").autocomplete({
		  minLength: 2,
		  source: function( request, response ) {
			  var term = request.term;
			  if ( term in cacheItem ) {
				  response( cacheItem[ term ] );
				  return;
			  } 
			  $.getJSON( "<?php echo site_url();?>admin/<?php echo $class?>/search_obat_by_name", request, function( data, status, xhr ) {
				  $('#nr_obat_id').val(''); 
				  cacheItem[ term ] = data;
				  response( data ); 
			  });
		  },
		  select: function (event, ui) {
				$('[name="nr_obat_id"]').val(ui.item.id);     
				// $('[name="search_pasien"]').val(ui.item.label);      
				$('[name="nr_obat_name"]').val(ui.item.obat_name); 
				$('[name="nr_is_obat"]').val(ui.item.is_obat); 
				$('[name="nr_obat_price"]').val(ui.item.obat_price_non_resep); 
				$('[name="nr_obat_type"]').val(ui.item.obat_type); 
				nr_obat_qty=$('[name="nr_obat_qty"]').val(); 
				if(nr_obat_qty=='')
				{
					$('[name="nr_obat_qty"]').val('1'); 
				}
				calculate_nr();
				get_kemasan(ui.item.id,ui.item.is_obat);
			return false;
		  },
		  focus: function (event, ui) {  
				$('[name="nr_obat_id"]').val(ui.item.id);     
				// $('[name="search_pasien"]').val(ui.item.label);      
				$('[name="nr_obat_name"]').val(ui.item.obat_name); 
				$('[name="nr_obat_price"]').val(ui.item.obat_price_non_resep); 
				return false;
		  },
	  }).on("focus", function () {
		$(this).autocomplete("search", '');
	  });
}


function add_row_nr()
{
	nr_obat_name=$('[name="nr_obat_name"]').val();
	nr_is_obat=$('[name="nr_is_obat"]').val();
	nr_obat_id=$('[name="nr_obat_id"]').val();
	nr_obat_price=$('[name="nr_obat_price"]').val();
	nr_obat_kemasan_name=$('[name="nr_obat_kemasan_id"] option:selected').text();
	nr_obat_kemasan_id=$('[name="nr_obat_kemasan_id"]').val();
	nr_obat_qty=$('[name="nr_obat_qty"]').val();
	nr_obat_type=$('[name="nr_obat_type"]').val();
	nr_obat_total=$('[name="nr_obat_total"]').autoNumeric('get');
	// diagnosis_name=$('[name="diagnosis_id"]  option:selected').text(); 
	if(nr_obat_name==''||nr_obat_id==''||nr_obat_price==''||nr_obat_qty==''||nr_obat_kemasan_id==''||nr_obat_total=='')
	{
		alert('Silahkan lengkapi isi non resep');
	}
	else
	{
		
		nr_obat_price=nr_obat_total/nr_obat_qty;
		num=$('.tr_data').length;
		lain=0;
		if($('tr.trr_'+nr_is_obat+'_'+nr_obat_id+'_'+nr_obat_kemasan_id).find('.produk_qty').length>0)
		{
			lain=$('tr.trr_'+nr_is_obat+'_'+nr_obat_id+'_'+nr_obat_kemasan_id).find('.nr_obat_qty').val();
			nr_obat_price=$('tr.trr_'+nr_is_obat+'_'+nr_obat_id+'_'+nr_obat_kemasan_id).find('.nr_obat_price').val();
			// penjualan_detail_id=$('tr.trr_'+produk_id_div).find('.penjualan_detail_id').val();
		}
		
		nr_obat_qty=(nr_obat_qty*1)+(lain*1);
		
		
		$('tr.trr_'+nr_is_obat+'_'+nr_obat_id+'_'+nr_obat_kemasan_id).remove();
		html='<tr class="tr_data trr_'+nr_is_obat+'_'+nr_obat_id+'_'+nr_obat_kemasan_id+'">'
					+'<td class="td">'
						+nr_obat_name 
						+'<input type="hidden" readonly class="form-control obat_name" id="obat_name" name="obat_name[]" value="'+nr_obat_name+'">'
						+'<input type="hidden" class="form-control obat_id" readonly name="obat_id[]" value="'+nr_obat_id+'">'
						+'<input type="hidden" class="form-control obat_price" readonly name="obat_price[]" value="'+nr_obat_price+'">'
						+'<input type="hidden" class="form-control obat_resep" readonly name="obat_resep[]" value="">'
						+'<input type="hidden" class="form-control obat_dosis" readonly name="obat_dosis[]" value="">'
						+'<input type="hidden" class="form-control obat_type" readonly name="obat_type[]" value="non_resep">'
						+'<input type="hidden" class="form-control obat_aturan_pakai" readonly name="obat_aturan_pakai[]" value="">'
						+'<input type="hidden" class="form-control is_obat" readonly name="is_obat[]" value="'+nr_is_obat+'">' 
					+'</td>'
					+'<td class="td">'
						+nr_obat_kemasan_name 
						+'<input type="hidden" readonly class="form-control obat_kemasan_id" id="obat_kemasan_id" name="obat_kemasan_id[]" value="'+nr_obat_kemasan_id+'">'
						+'<input type="hidden" readonly class="form-control obat_kemasan_name" id="obat_kemasan_name" name="obat_kemasan_name[]" value="'+nr_obat_kemasan_name+'">'
					+'</td>'
					+'<td class="td">'
						+nr_obat_qty 
						+'<input type="hidden" readonly class="form-control obat_qty" id="obat_qty" name="obat_qty[]" value="'+nr_obat_qty+'">'
					+'</td>'
					+'<td class="td">'
						+nr_obat_total 
						+'<input type="hidden" readonly class="form-control obat_total" id="obat_total" name="obat_total[]" value="'+nr_obat_total+'">'
					+'</td>'
					+'<td class="td">'
						+'<button class="btn btn-danger btn-clone4 btn-sm" type="button" onclick="$(this).parent().parent().remove();calculate_subtotal();return false;"><i class="fa fa-trash"></i></button>'
					+'</td>'
			+'</tr>'
			;
				
		$('.add_row_nr').append(html);
		r_obat_resep=$('[name="nr_search_obat_name"]').val('');
		nr_obat_name=$('[name="nr_obat_name"]').val('');
		nr_obat_id=$('[name="nr_obat_id"]').val('');
		nr_obat_price=$('[name="nr_obat_price"]').val('');
		nr_obat_kemasan_id=$('[name="nr_obat_kemasan_id"]').val('');
		nr_obat_qty=$('[name="nr_obat_qty"]').val('');
		nr_obat_qty=$('[name="nr_is_obat"]').val('');
		nr_obat_total=$('[name="nr_obat_total"]').autoNumeric('set','');
		calculate_subtotal();
	}
}
 
function get_kemasan_r(id,type)
{ 
	$.ajax({
	   url:'<?php echo base_url();?>admin/<?php echo $class?>/get_kemasan_by_id',
	   type:'post',
	   dataType:'json',
	   data:'id='+id+'&type='+type,
	   success:function(response){
		   html='';
		   if(type=='1')
		   {
			html+='<option value="">Silahkan Pilih</option>';
		   }
		   if(response.length>0)
		   {
			   for(i=0;i<response.length;i++)
			   {
				   html+='<option value="'+response[i].kemasan_id+'" konversi="'+response[i].konversi+'">'+response[i].kemasan_name+'</option>';				   
			   }
		   }
		   
		   $('#r_obat_kemasan_id').html(html);
		  $('#r_obat_kemasan_id').focus();
		  $('#r_obat_kemasan_id').select();
		  
		  
		   if(type=='0')
		   {
			calculate_r()
		   $('[name="r_obat_dosis"]').val(0);
		   $('[name="r_obat_aturan_pakai"]').val('-');
		   }
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

function find_obat_r()
{ 
	  var cacheItem = {};
	  $("#r_search_obat_name").autocomplete({
		  minLength: 2,
		  source: function( request, response ) {
			  var term = request.term;
			  if ( term in cacheItem ) {
				  response( cacheItem[ term ] );
				  return;
			  } 
			  $.getJSON( "<?php echo site_url();?>admin/<?php echo $class?>/search_obat_by_name", request, function( data, status, xhr ) {
				  $('#r_obat_id').val(''); 
				  cacheItem[ term ] = data;
				  response( data ); 
			  });
		  },
		  select: function (event, ui) {
				$('[name="r_obat_id"]').val(ui.item.id);     
				// $('[name="search_pasien"]').val(ui.item.label);      
				$('[name="r_obat_name"]').val(ui.item.obat_name); 
				$('[name="r_is_obat"]').val(ui.item.is_obat); 
				$('[name="r_obat_price"]').val(ui.item.obat_price_non_resep); 
				$('[name="r_obat_type"]').val(ui.item.obat_type); 
				r_obat_qty=$('[name="r_obat_qty"]').val(); 
				if(r_obat_qty=='')
				{
					$('[name="r_obat_qty"]').val('1'); 
				}
				calculate_r();
				get_kemasan_r(ui.item.id,ui.item.is_obat);
			return false;
		  },
		  focus: function (event, ui) {  
				$('[name="r_obat_id"]').val(ui.item.id);     
				// $('[name="search_pasien"]').val(ui.item.label);      
				$('[name="r_obat_name"]').val(ui.item.obat_name); 
				$('[name="r_obat_price"]').val(ui.item.obat_price_non_resep); 
				return false;
		  },
	  }).on("focus", function () {
		$(this).autocomplete("search", '');
	  });
}


function currency_rupiah()
{
	var myOptions = {aSep: '.', aDec: ',',mDec: '0'};
	$('.currency_rupiah').autoNumeric('init', myOptions); 
}

</script>