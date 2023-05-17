<!-- ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Modified : Badra | sipatan.jana@students.amikom.ac.id
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
==========DON'T REMOVE============ -->

<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="section-body">
    <div class="card">
        <div class="card-header">
            <h4>Form Entry</h4>
        </div>
        <div class="pt-2 p-4 warning_">
            <h6><i>*PASTIKAN BARANG YANG AKAN DI RETUR BERADA DI GUDANG</i></h6>
        </div>
        <div class="card-body">
            <form class="form-horizontal" id="FormData" method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="penerimaan_id" value="<?= $penerimaan_id ?>">
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Faktur</label>
                    <div class="col-sm-12 col-md-7 id_penerimaan-field">
                        <select name="id_penerimaan" id="id_penerimaan" class="form-control form-select2" style="width: 100%;" data-placeholder="Pilih No Faktur">
                            <?php if (isset($penerimaan_arr) && !empty($penerimaan_arr)) {
                                echo '<option value=""></option>';
                                foreach ($penerimaan_arr as $rowArr) {
                                    echo '<option value="' . $rowArr['penerimaan_id'] . '">' . $rowArr['no_faktur'] . '</option>';
                                }
                            } ?>
                        </select>
                        <label id="id_penerimaan-error" class="error" for="id_penerimaan" style="display: none;"></label>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal Faktur</label>
                    <div class="col-sm-12 col-md-7 tanggal_faktur-field">
                        <input type="text" name="tanggal_faktur" id="tanggal_faktur" class="form-control" readonly="" disabled>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Supplier</label>
                    <div class="col-sm-12 col-md-7 supplier-field">
                        <input type="text" name="supplier" id="supplier" class="form-control" readonly="" disabled>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal Retur</label>
                    <div class="col-sm-12 col-md-7 tanggal_retur-field">
                        <input type="date" name="tanggal_retur" id="tanggal_retur" class="form-control" value="">
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Penyimpanan</label>
                    <div class="col-sm-12 col-md-7 penyimpanan-field">
                        <input type="text" name="penyimpanan" id="penyimpanan" class="form-control" value="" disabled>
                        <!-- <select class="form-control form-select2" name="penyimpanan" id="penyimpanan" data-placeholder="Pilih Penyimpanan">
                            <option value=""></option>
                            <option value="etalase">Etalase</option>
                            <option value="gudang">Gudang</option>
                        </select> -->
                        <label id="penyimpanan-error" class="error" for="penyimpanan" style="display: none;"></label>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Obat</label>
                    <div class="col-sm-12 col-md-7">
                        <div class="table-responsive">
                            <table class="table table-product table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Obat</th>
                                        <th>Kemasan</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>PPN (%)</th>
                                        <th>Diskon (%)</th>
                                        <th>Expired Date</th>
                                        <th>Batch</th>
                                    </tr>
                                </thead>
                                <tbody id="datatable_obat">
                                    <tr>
                                        <td colspan="8" class="text-center">Silahkan pilih nomor faktur terlebih dahulu</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alkes</label>
                    <div class="col-sm-12 col-md-7">
                        <div class="table-responsive">
                            <table class="table table-product table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Alkes</th>
                                        <th>Kemasan</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>PPN (%)</th>
                                        <th>Diskon (%)</th>
                                        <th>Batch</th>
                                    </tr>
                                </thead>
                                <tbody id="datatable_alkes">
                                    <tr>
                                        <td colspan="7" class="text-center">Silahkan pilih nomor faktur terlebih dahulu</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Total Harga</label>
                    <div class="col-sm-12 col-md-7 total-field">
                        <input type="number" name="total" id="total" class="form-control" readonly="" disabled>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Diskon Faktur (Rp)</label>
                    <div class="col-sm-12 col-md-7 diskon_faktur_rp-field">
                        <input type="number" name="diskon_faktur_rp" id="diskon_faktur_rp" class="form-control" readonly="" disabled>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Diskon Faktur (%)</label>
                    <div class="col-sm-12 col-md-7 diskon_faktur_persen-field">
                        <input type="number" name="diskon_faktur_persen" id="diskon_faktur_persen" class="form-control" readonly="" disabled>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Grand Total</label>
                    <div class="col-sm-12 col-md-7 grand_total-field">
                        <input type="number" name="grand_total" id="grand_total" class="form-control" readonly="" disabled>
                    </div>
                </div>
                <hr>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                    <div class="col-sm-12 col-md-7">
                        <button type="button" id="save" name="save" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>

            <!-- If select by id nomer faktur -->
            <div class="p-4 table_edit">
                <div class="table-responsive border-bottom border-light">
                    <table id="table_data_retur" class="table">
                    </table>
                </div>

                <div class="form-group row mb-4 mt-4">
                    <!-- <div class="col-sm-12 col-md-7"> -->
                        <div class="table-responsive">
                            <table class="table table-product table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Obat</th>
                                        <th>Kemasan</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>PPN (%)</th>
                                        <th>Diskon (%)</th>
                                        <th>Expired Date</th>
                                        <th>Batch</th>
                                    </tr>
                                </thead>
                                <tbody id="show_obat">
                                    <tr>
                                        <td colspan="8" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <!-- </div> -->
                </div>
                <div class="form-group row mb-4">
                    <!-- <div class="col-sm-12 col-md-7"> -->
                        <div class="table-responsive">
                            <table class="table table-product table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Alkes</th>
                                        <th>Kemasan</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>PPN (%)</th>
                                        <th>Diskon (%)</th>
                                        <th>Batch</th>
                                    </tr>
                                </thead>
                                <tbody id="show_alkes">
                                    <tr>
                                        <td colspan="7" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <!-- </div> -->
                </div>

                <div class="form-group row mb-4">
                    <!-- <label class="col-form-label text-md-right col-12 col-md-2"></label> -->
                    <div class="col-md-9">
                        <a href="<?= site_url('admin/'.$class.'/data');?>" class="btn btn-primary" type="button">Kembali</a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="modal-form" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row custom_message">
                    <div class="col-sm-12 control-label">
                        <div>
                            <div style="text-align:left;" class="mb-1 message"><?= $message; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    tr{
        white-space: nowrap;
    }

    h6{
        color:red;
    }
</style>

<script>
    $(function() {
        $('.form-select2').select2();

        $('#FormData').each(function(){
            this.reset();
            $(".form-select2").val('').trigger('change');
        });
    });

    $(document).ready(function() {
        $('.table_edit').hide();

        var selected_alkes = [];
        var selected_obat= [];

        var penerimaan_id = $('input[name="penerimaan_id"]').val();

        if (penerimaan_id == 0) {
            if ($('#id_penerimaan').val() == '') {
                selected_obat = [];
                selected_alkes = [];

                $.validator.setDefaults({
                    ignore: ":hidden:not('select')" // validate all hidden select elements
                });

                var validator = $('#FormData').validate({
                    rules: {
                        id_penerimaan: {
                            required: function(element) {
                                return $('.id_penerimaan-field').addClass('is-invalid');
                            }
                        },
                        tanggal_retur: {
                            required: function(element) {
                                return $('.tanggal_retur-field').addClass('is-invalid');
                            }
                        },
                    },
                });
            }
        }else{
            $('.table_edit').show();
            $('#FormData').hide();
            $('.card-header').hide();
            $('.warning_').hide();

            $.ajax({
                url: '<?= site_url('admin/' . $class . '/action_data_form'); ?>',
                type: 'GET',
                dataType: 'json',
                data: {
                    penerimaan_id: penerimaan_id
                },
                success: function(response) {
                    var data_retur = response.data;
                    var data_obat = [];
                    var data_alkes = [];
                    var html = '';
                    $('#table_data_retur').html('');

                    data_retur.forEach(obj => {
                        selected_obat = obj.obat;
                        selected_alkes = obj.alkes;

                        html = `
                        <tbody>
                            <tr>
                                <td width="200">No Faktur</td>		
                                <td>: ${obj.no_faktur}</td>
                                <td width="200">Total</td>		
                                <td>: ${convertToRupiah(obj.total_harga)}</td>
                            </tr>
                            <tr>
                                <td width="200">Tanggal Faktur</td>		
                                <td>: ${obj.tanggal_faktur}</td>
                                <td width="200">Diskon(Rp.)</td>	
                                <td>: ${convertToRupiah(obj.diskon_perfaktur_rp)}</td>
                            </tr>
                            <tr>
                                <td width="200">Tanggal Retur</td>		
                                <td>: ${obj.tanggal_retur}</td>
                                <td width="200">Diskon(%)</td>		
                                <td>: ${obj.diskon_perfaktur_persen}</td>
                                </tr>
                                <tr>
                                <td width="200">Supplier</td>		
                                <td>: ${obj.supplier}</td>
                                <td width="200">Grand Total</td>		
                                <td>: ${convertToRupiah(obj.total)}</td>
                            </tr>
                        </tbody>
                        `;
                    });
                    $('#table_data_retur').html(html);
                    render_obat();
                    render_alkes();
                }
            });
        }

        $('#id_penerimaan').change(function(e) {
            if ($('input[name="penerimaan_id"]').val() == 0) {
                var id = $(this).val();
                $('#total_harga').val(0);
                $.ajax({
                    url: '<?= site_url('admin/' . $class . '/get_detail_penerimaan'); ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        //Data Form
                        var data_parrent = response.data.parrentData;
                        data_parrent.forEach(element => {
                            $('#tanggal_sp').val(element.pemesanan_tanggal);
                            $('#supplier').val(element.supplier_name);
                            $('#tanggal_faktur').val(element.tanggal_faktur);
                            $('#penyimpanan').val(element.penyimpanan);
                            $('#total').val(element.total_harga);
                            $('#grand_total').val(element.total);
                            $('#diskon_faktur_rp').val(element.diskon_perfaktur_rp);
                            $('#diskon_faktur_persen').val(element.diskon_perfaktur_persen);
                        });

                        //Detail ALkes
                        var data_alkes = response.data.alkes
                        selected_alkes = data_alkes;
                        
                        //Detail Obat
                        var data_obat = response.data.obat
                        selected_obat = data_obat;
                        render_obat();
                        render_alkes();
                    }
                });
            }
        });

        $('#save').click(function(e){
            var id_penerimaan = $('#id_penerimaan').val();
            var tgl_retur = $('#tanggal_retur').val();

            if ($('#FormData').valid() != false) {
                swal({
                    title: 'Apakah anda yakin?',
                    text: 'Pastikan data sudah sesuai',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                }).then((confirm) => {
                    if (penerimaan_id == 0) {
                        data = {
                            id_penerimaan: id_penerimaan,
                            tgl_retur : tgl_retur,
                        };
                        $.ajax({
                            url: '<?= site_url('admin/' . $class . '/trx_save'); ?>',
                            type: 'POST',
                            dataType: 'JSON',
                            data: data,
                            success: function(response) {
                                window.location.href = '<?= base_url('admin/' . $class . '/after_save'); ?>';
                            },
                        });
                    } else {
                        window.location.href = '<?= base_url('admin/' . $class . '/after_save'); ?>';
                    }
                });
            }
        });

        function render_show_retur(){
            var html = '';
            $('').html('');
        }

        function render_alkes(){
            if (selected_alkes.length > 0) {
                var html_ = '';
                var no = 0;

                $('#datatable_alkes').html('');
                $('#show_alkes').html('');

                $.each(selected_alkes, function(index, obj) {
                    html_ += '<tr>';
                    html_ += '<td>' + obj.alkes_name + '</td>';
                    html_ += '<td>' + obj.alkes_kemasan + '</td>';
                    html_ += '<td class="obat_qty-'+index+'">' + obj.qty + '</td>';
                    html_ += '<td class="obat_harga-'+index+'">' + obj.harga + '</td>';
                    html_ += '<td class="obat_ppn-'+index+'">' + obj.ppn + '</td>';
                    html_ += '<td class="obat_diskon-'+index+'">' + obj.diskon + '</td>';
                    html_ += '<td class="obat_batch-'+index+'">' + obj.batch + '</td>';
                    html_ += '</tr>';
                    no++;
                });
                if (penerimaan_id != 0) {
                    $('#show_alkes').html(html_);
                }else{
                    $('#datatable_alkes').html(html_);
                }
            } else {
                var html_ = '';
                $('#datatable_alkes').html('');
            }
        }
        
        function render_obat(){
            if (selected_obat.length > 0) {
                var html_ = '';
                var no = 0;

                $('#datatable_obat').html('');
                $('#show_obat').html('');

                $.each(selected_obat, function(index, obj) {
                    html_ += '<tr>';
                    html_ += '<td>' + obj.obat_name + '</td>';
                    html_ += '<td>' + obj.kemasan_name + '</td>';
                    html_ += '<td class="obat_qty-'+index+'">' + obj.qty + '</td>';
                    html_ += '<td class="obat_harga-'+index+'">' + obj.harga + '</td>';
                    html_ += '<td class="obat_ppn-'+index+'">' + obj.ppn + '</td>';
                    html_ += '<td class="obat_diskon-'+index+'">' + obj.diskon + '</td>';
                    html_ += '<td class="obat_expired_date-'+index+'">' + obj.expired_date + '</td>';
                    html_ += '<td class="obat_batch-'+index+'">' + obj.batch + '</td>';
                    html_ += '</tr>';
                    no++;
                });
                if (penerimaan_id != 0) {
                    $('#show_obat').html(html_);
                }else{
                    $('#datatable_obat').html(html_);
                }
            } else {
                var html_ = '';
                $('#datatable_obat').html('');
            }
        }
    });

    $(document).on('change', '#id_penerimaan', function() {
        var id_penerimaan = $('#id_penerimaan').val();
        if (id_penerimaan) {
            $('#id_penerimaan-error').hide();
        }
    });
</script>