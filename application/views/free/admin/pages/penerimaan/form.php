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
        <div class="card-body">
            <form class="form-horizontal" id="FormData" method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="penerimaan_id" value="<?= $penerimaan_id ?>">
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No SP</label>
                    <div class="col-sm-12 col-md-7 id_pemesanan-field">
                        <select name="id_pemesanan" id="id_pemesanan" class="form-control form-select2" style="width: 100%;" data-placeholder="Pilih No. SP">
                            <?php if (isset($pemesanan_arr) && !empty($pemesanan_arr)) {
                                echo '<option value=""></option>';
                                foreach ($pemesanan_arr as $rowArr) {
                                    echo '<option value="' . $rowArr['pemesanan_id'] . '">' . $rowArr['pemesanan_no_sp'] . '</option>';
                                }
                            } ?>
                        </select>
                        <label id="id_pemesanan-error" class="error" for="id_pemesanan" style="display: none;"></label>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal SP</label>
                    <div class="col-sm-12 col-md-7 tanggal_sp-field">
                        <input type="text" name="tanggal_sp" id="tanggal_sp" class="form-control" readonly="" disabled>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Supplier</label>
                    <div class="col-sm-12 col-md-7 supplier-field">
                        <input type="text" name="supplier" id="supplier" class="form-control" readonly="" disabled>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Faktur</label>
                    <div class="col-sm-12 col-md-7 no_faktur-field">
                        <input type="text" name="no_faktur" id="no_faktur" class="form-control" value="">
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal Faktur</label>
                    <div class="col-sm-12 col-md-7 tanggal_faktur-field">
                        <input type="date" name="tanggal_faktur" id="tanggal_faktur" class="form-control">
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis Penerimaan</label>
                    <div class="col-sm-12 col-md-7 jenis_penerimaan-field">
                        <select name="jenis_penerimaan" id="jenis_penerimaan" class="form-control form-select2" style="width: 100%;" data-placeholder="Pilih Jenis Penerimaan">
                            <option value=""></option>
                            <option value="lunas">Cash/Lunas</option>
                            <option value="tempo">Tempo</option>
                        </select>
                        <label id="jenis_penerimaan-error" class="error" for="jenis_penerimaan" style="display: none;"></label>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal Jatuh Tempo</label>
                    <div class="col-sm-12 col-md-7 tanggal_tempo-field">
                        <input type="date" name="tanggal_tempo" id="tanggal_tempo" class="form-control">
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto Faktur</label>
                    <div class="col-sm-12 col-md-7 image_faktur-field">
                        <input type="file" name="image_faktur" id="image_faktur" class="form-control">
                    </div>
                    <?php if ($nama_file != '0') { ?>
                        <div>
                            <a href="<?= site_url('admin/' . $class . '/download/' . $nama_file); ?>" target="_blank">
                                <button type="button" class="btn btn-info">Download faktur</button>
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Penyimpanan</label>
                    <div class="col-sm-12 col-md-7 penyimpanan-field">
                        <input type="text" name="penyimpanan" id="penyimpanan" value="gudang" class="form-control" readonly>
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
                                        <td colspan="8" class="text-center">Silahkan pilih nomor SP terlebih dahulu</td>
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
                                        <td colspan="7" class="text-center">Silahkan pilih nomor SP terlebih dahulu</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Total Harga</label>
                    <div class="col-sm-12 col-md-7 total_harga-field">
                        <input type="number" name="total_harga" id="total_harga" class="form-control" readonly="">
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Diskon (Per Faktur) Rp</label>
                    <div class="col-sm-12 col-md-7 diskon_perfaktur_rp-field">
                        <input type="number" name="diskon_perfaktur_rp" id="diskon_perfaktur_rp" class="form-control">
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Diskon (Per Faktur) %</label>
                    <div class="col-sm-12 col-md-7 diskon_perfaktur_persen-field">
                        <input type="number" name="diskon_perfaktur_persen" id="diskon_perfaktur_persen" class="form-control">
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Grand Total</label>
                    <div class="col-sm-12 col-md-7 total-field">
                        <input type="number" name="total" id="total" class="form-control" readonly="">
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
</style>
<script>
    $(function() {
        $('.form-select2').select2();
    });

    var selected_alkes = [];
    var selected_obat = [];
    var arr_obat = [];
    var arr_alkes = [];
    var total_obat = 0;
    var total_alkes = 0;
    var obat_price = 0;
    var obat_ppn = 0;
    var obat_diskon = 0;
    var alkes_price = 0;
    var total_harga_qty_alkes = 0;
    var total_harga_qty_obat = 0;
    var alkes_ppn, alkes_diskon, harga_obat, diskon_obat, ppn_obat, harga_alkes, diskon_alkes, ppn_alkes = 0;
    var total_harga = 0;
    var merger_array = {};
    var arr_total_obat = [];
    var arr_total_alkes = [];

    $(document).ready(function() {
        var id_penerimaan = $('input[name="penerimaan_id"]').val();
        if (id_penerimaan == 0) {
            if ($('#id_pemesanan').val() == '') {
                selected_obat = [];
                selected_alkes = [];
                validator_form();
                validator_table_obat();
            }
        } else {
            $.ajax({
                url: '<?= site_url('admin/' . $class . '/action_data_form'); ?>',
                type: 'GET',
                dataType: 'json',
                data: {
                    id_penerimaan: id_penerimaan
                },
                success: function(response) {
                    selected_obat = [];
                    selected_alkes = [];
                    if (response['status'] == 200) {
                        var data_edit = response.data;
                        data_edit.forEach(data => {
                            var obat = data.obat;
                            var alkes = data.alkes;
                            alkes.forEach((value, index) => {
                                selected_alkes.push({
                                    id: value.alkes_id,
                                    barcode: value.alkes_barcode,
                                    nama_barang: value.alkes_name,
                                    kemasan: value.alkes_kemasan,
                                    qty: value.qty,
                                    price: value.alkes_price_sale,
                                    ppn: value.ppn,
                                    diskon: value.diskon,
                                    batch: value.batch,
                                    edit: 'edit',
                                });
                            });

                            obat.forEach((value, index) => {
                                console.log(value);
                                selected_obat.push({
                                    id: value.obat_id,
                                    barcode: value.obat_barcode,
                                    nama_barang: value.obat_name,
                                    kemasan: value.kemasan_name,
                                    qty: value.qty,
                                    price: value.harga,
                                    ppn: value.ppn,
                                    diskon: value.diskon,
                                    expired_date: value.expired_date,
                                    batch: value.batch,
                                    edit: 'edit',
                                });
                            });

                            render_obat();
                            render_alkes();

                            total_price();
                            diskon_faktur();

                            $('#id_pemesanan').val(data.pemesanan_id);
                            $('#id_pemesanan').select2().trigger('change');
                            // $('#id_pemesanan').prop('disabled', true);

                            $('#tanggal_sp').val(data.pemesanan_tanggal);
                            $('#supplier').val(data.supplier);
                            $('#no_faktur').val(data.no_faktur);
                            $('#tanggal_faktur').val(data.tanggal_faktur);
                            $('#jenis_penerimaan').val(data.jenis_penerimaan);
                            $('#jenis_penerimaan').val(data.jenis_penerimaan);
                            $('#jenis_penerimaan').select2().trigger('change');
                            $('#tanggal_tempo').val(data.tanggal_tempo);
                            // $('#image_faktur').val(data.image_faktur);
                            // $('#penyimpanan').val(data.penyimpanan);
                            // $('#penyimpanan').select2().trigger('change');
                            $('#total_harga').val(data.total_harga);
                            $('#diskon_perfaktur_rp').val(data.diskon_perfaktur_rp);
                            $('#diskon_perfaktur_persen').val(data.diskon_perfaktur_persen);
                            $('#diskon_perfaktur_persen').val(data.diskon_perfaktur_persen);
                            $('#total').val(data.total);
                        });

                    } else {
                        custom_message(response['status'], response['message']); //get on custom.js				   
                    }
                },
                error: function() {
                    alert('terjadi kesalahan saat validasi');
                    $('.modal-footer').show();
                    $('.button').show();
                    $('.btn').prop('disabled', false);
                }
            });
            validator_form();
            validator_table_obat();
        }

        $("#obat_kemasan_kecil_id").on('change', function(e) {
            var id_kemasan = $(this).val();
            get_kemasan(id_kemasan);
        });

        $('#id_pemesanan').change(function(e) {
            if ($('input[name="penerimaan_id"]').val() == 0) {
                arr_alkes = [];
                arr_obat = [];
                var id = $(this).val();
                $('#total_harga').val(0);
                $('#diskon_perfaktur_rp').val(0);
                $('#diskon_perfaktur_persen').val(0);
                $('#total').val(0);
                $.ajax({
                    url: '<?= site_url('admin/' . $class . '/get_detail_pemesanan'); ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        selected_obat = [];
                        selected_alkes = [];
                        var data = response.data;
                        data.forEach((item, index) => {
                            if (item.detail.obat != undefined) {
                                selected_obat = item.detail.obat;
                            }

                            if (item.detail.alkes != undefined) {
                                selected_alkes = item.detail.alkes;
                            }
                            $('#tanggal_sp').val(item.tanggal);
                            $("#supplier").val(item.supplier);
                        });
                        render_obat();
                        render_alkes();
                        total_price();
                        diskon_faktur();
                    }
                });
            }
        });

        /* aksi simpan/edit diklik */
        $('#save').click(function(e) {
            var data = {};
            var penerimaan_id = $('input[name="penerimaan_id"]').val();
            var form_data = new FormData($('#FormData')[0]);

            //For Obat
            if (selected_obat.length > 0) {
                $.each(selected_obat, function(index, value) {
                    var price = $(".obat_price-" + index).val();
                    var diskon = $(".obat_diskon-" + index).val();
                    var ppn = $(".obat_ppn-" + index).val();
                    var expired_date = $(".expired_date-" + index).val();
                    var batch = $(".obat_batch-" + index).val();
                    var arr_lama = selected_obat[index];

                    if (arr_obat.length != selected_obat.length) {
                        arr_obat.push({
                            id: arr_lama.id,
                            barcode: arr_lama.barcode,
                            nama_barang: arr_lama.nama_barang,
                            kemasan: arr_lama.kemasan,
                            qty: arr_lama.qty,
                            is_obat: arr_lama.is_obat,
                            price: price,
                            ppn: ppn,
                            diskon: diskon,
                            expired: expired_date,
                            batch: batch,
                        });
                    }
                });
            } else {
                arr_obat = [];
            }

            //For Alkes
            if (selected_alkes.length > 0) {
                $.each(selected_alkes, function(index, value) {
                    var price = $(".alkes_price-" + index).val();
                    var diskon = $(".alkes_diskon-" + index).val();
                    var ppn = $(".alkes_ppn-" + index).val();
                    var batch = $(".alkes_batch-" + index).val();
                    var arr_lama = selected_alkes[index];

                    if (arr_alkes.length != selected_alkes.length) {
                        arr_alkes.push({
                            id: arr_lama.id,
                            barcode: arr_lama.barcode,
                            nama_barang: arr_lama.nama_barang,
                            kemasan: arr_lama.kemasan,
                            qty: arr_lama.qty,
                            is_obat: arr_lama.is_obat,
                            price: price,
                            ppn: ppn,
                            diskon: diskon,
                            batch: batch,
                        });
                    }
                });
            } else {
                arr_alkes = [];
            }

            if (penerimaan_id == 0) {
                data = {
                    penerimaan_id: penerimaan_id,
                    obat: arr_obat,
                    alkes: arr_alkes,
                };
            } else {
                data = {
                    penerimaan_id: 'save',
                    id_pemesanan: $('#id_pemesanan').val(),
                    tanggal_sp: $('#tanggal_sp').val(),
                    supplier: $('#supplier').val(),
                    no_faktur: $('#no_faktur').val(),
                    tanggal_faktur: $('#tanggal_faktur').val(),
                    jenis_penerimaan: $('#jenis_penerimaan').val(),
                    tanggal_jatuh_tempo: $('#tanggal_tempo').val(),
                    foto_faktur: $('#image_faktur').val(),
                    penyimpanan: $('#penyimpanan').val(),
                    total_harga: $('#total_harga').val(),
                    diskon_faktur_rp: $('#diskon_perfaktur_rp').val(),
                    diskon_faktur_persen: $('#diskon_perfaktur_persen').val(),
                    grand_total: $('#total').val(),
                    obat: arr_obat,
                    alkes: arr_alkes,
                };
            }

            if ($('#FormData').valid() != false) {
                swal({
                    title: 'Apakah anda yakin?',
                    text: 'Pastikan data sudah sesuai',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                }).then((confirm) => {
                    if (confirm) {
                        $.ajax({
                            url: '<?= site_url('admin/' . $class . '/do_upload'); ?>',
                            type: 'POST',
                            dataType: 'JSON',
                            data: form_data,
                            processData: false,
                            contentType: false,
                            cache: false,
                            async: false,
                            success: function(response) {
                                if (penerimaan_id == 0) {
                                    data = {
                                        penerimaan_id: response,
                                        penyimpanan: $('#penyimpanan').val(),
                                        obat: arr_obat,
                                        alkes: arr_alkes,
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
                            },
                        });
                    }
                });
            }

        });
    });

    $(document).on('change', '#penyimpanan, #id_pemesanan, #jenis_penerimaan', function() {
        var penyimpanan = $('#penyimpanan').val();
        var id_pemesanan = $('#id_pemesanan').val();
        var jenis_penerimaan = $('#jenis_penerimaan').val();
        if (penyimpanan) {
            $('#penyimpanan-error').hide();
        }
        if (id_pemesanan) {
            $('#id_pemesanan-error').hide();
        }
        if (jenis_penerimaan) {
            $('#jenis_penerimaan-error').hide();
        }
    });

    var diskon_faktur_rp = $('#diskon_perfaktur_rp');
    var diskon_faktur_persen = $('#diskon_perfaktur_persen');
    var grand_total = 0;

    function validator_table_obat() {
        var expired, batch_obat, batch_alkes;
        //Obat
        if (selected_obat.length > 1) {
            $.each(selected_obat, function(index, value) {
                expired = $(".expired_date-" + index).val();
                batch_obat = $(".obat_batch-" + index).val();
            });
        }

        var validator_obat = $('#datatable_obat td').validate({
            rules: {
                expired_date: {
                    required: function(element) {
                        return expired.addClass('is-invalid');
                    }
                },
                batch: {
                    required: function(element) {
                        return batch_obat.addClass('is-invalid');
                    }
                },
            }
        });

        //Alkes
        if (selected_alkes.length > 1) {
            $.each(selected_alkes, function(index, value) {
                batch_alkes = $(".alkes_batch-" + index).val();
            });
        }

        var validator_alkes = $('#datatable_alkes td').validate({
            rules: {
                batch: {
                    required: function(element) {
                        return batch_alkes.addClass('is-invalid');
                    }
                },
            }
        });
    }

    function validator_form() {
        $.validator.setDefaults({
            ignore: ":hidden:not('select')" // validate all hidden select elements
        });

        var validator = $('#FormData').validate({
            rules: {
                total: {
                    required: function(element) {
                        return $('.total-field').addClass('is-invalid');
                    }
                },
                supplier: {
                    required: function(element) {
                        return $('.supplier-field').addClass('is-invalid');
                    }
                },
                no_faktur: {
                    required: function(element) {
                        return $('.no_faktur-field').addClass('is-invalid');
                    },
                    remote: {
                        url: "<?= site_url('admin/' . $class . '/action_validation_action_no_faktur'); ?>",
                        type: "post",
                        data: {
                            no_faktur: function() {
                                return $("#no_faktur").val();
                            },
                            id_pemesanan: function() {
                                return $("#id_pemesanan").val();
                            },
                            id_penerimaan: function() {
                                return $('input[name="penerimaan_id"]').val();
                            },
                        }
                    }
                },
                tanggal_sp: {
                    required: function(element) {
                        return $('.tanggal_sp-field').addClass('is-invalid');
                    }
                },
                penyimpanan: {
                    required: function(element) {
                        return $('.penyimpanan-field').addClass('is-invalid');
                    }
                },
                total_harga: {
                    required: function(element) {
                        return $('.total_harga-field').addClass('is-invalid');
                    }
                },
                id_pemesanan: {
                    required: function(element) {
                        return $('.id_pemesanan-field').addClass('is-invalid');
                    }
                },
                image_faktur: {
                    required: function(element) {
                        var nama_file = '<?= $nama_file ?>';
                        if (nama_file == 0) {
                            return $('.image_faktur-field').addClass('is-invalid');
                        } else {
                            return false;
                        }
                    }
                },
                tanggal_tempo: {
                    required: function(element) {
                        return $('.tanggal_tempo-field').addClass('is-invalid');
                    }
                },
                tanggal_faktur: {
                    required: function(element) {
                        return $('.tanggal_faktur-field').addClass('is-invalid');
                    }
                },
                jenis_penerimaan: {
                    required: function(element) {
                        return $('.jenis_penerimaan-field').addClass('is-invalid');
                    }
                },
                diskon_perfaktur_rp: {
                    required: function(element) {
                        return $('.diskon_perfaktur_rp-field').addClass('is-invalid');
                    }
                },
                diskon_perfaktur_persen: {
                    required: function(element) {
                        return $('.diskon_perfaktur_persen-field').addClass('is-invalid');
                    }
                },
            },
            messages: {
                no_faktur: {
                    remote: "Nomor Faktur sudah di gunakan"
                }
            }
        });
    }

    function diskon_faktur() {
        diskon_faktur_rp.keyup(function() {
            diskon_faktur_render();
        });

        diskon_faktur_persen.keyup(function() {
            diskon_faktur_render();
        });
    }

    function diskon_faktur_render() {
        var id_penerimaan = $('input[name="penerimaan_id"]').val();
        var rp = diskon_faktur_rp.val();
        var persen = diskon_faktur_persen.val();

        if (id_penerimaan != 0) {
            total_harga = $('#total_harga').val();
            grand_total = total_harga - rp - (total_harga * (persen / 100));
        }

        if (total_harga > 0) {
            grand_total = total_harga - rp - (total_harga * (persen / 100));
        }
        $('input[name="total"]').val(parseInt(grand_total, 10));
    }


    function total_price() {
        var id_penerimaan = $('input[name="penerimaan_id"]').val();
        $.each(selected_alkes, function(idx, object) {
            harga_alkes = $('.alkes_price-' + idx);
            diskon_alkes = $('.alkes_diskon-' + idx);
            ppn_alkes = $('.alkes_ppn-' + idx);
            var status = 'alkes';


            if (id_penerimaan != 0) {
                harga_alkes = $('.alkes_price-' + idx);
                diskon_alkes = $('.alkes_diskon-' + idx);
                ppn_alkes = $('.alkes_ppn-' + idx);

                alkes_price = harga_alkes.val();
                alkes_diskon = diskon_alkes.val();
                alkes_ppn = ppn_alkes.val();

                var qty_alkes = $('.alkes_qty-' + idx);
                var qty_alkes_value = qty_alkes.text();

                total_harga_qty_alkes = (qty_alkes_value * alkes_price);
                total_alkes = total_harga_qty_alkes - (alkes_price * (alkes_diskon / 100)) + (alkes_price * (alkes_ppn / 100));

                if (arr_total_alkes.length < 0) {
                    arr_total_alkes.push(total_alkes);
                } else {
                    arr_total_alkes[idx] = total_alkes;
                }

                total_alkes = arr_total_alkes.reduce((a, b) => {
                    return a + b;
                }, 0);

                total_harga = total_alkes + total_obat;
            } else {
                arr_total_alkes = [];
                arr_total_obat = [];
            }

            harga_alkes.keyup(function() {
                render_total_price(idx, status);
            });

            diskon_alkes.keyup(function() {
                render_total_price(idx, status);
            });

            ppn_alkes.keyup(function() {
                render_total_price(idx, status);
            });
        });

        $.each(selected_obat, function(index, obj) {
            harga_obat = $('.obat_price-' + index);
            diskon_obat = $('.obat_diskon-' + index);
            ppn_obat = $('.obat_ppn-' + index);
            var status = 'obat';

            if (id_penerimaan != 0) {
                harga_obat = $('.obat_price-' + index);
                diskon_obat = $('.obat_diskon-' + index);
                ppn_obat = $('.obat_ppn-' + index);

                obat_price = harga_obat.val();
                obat_diskon = diskon_obat.val();
                obat_ppn = ppn_obat.val();

                var qty_obat = $('.obat_qty-' + index);
                var qty_obat_value = qty_obat.text();

                total_harga_qty_obat = (qty_obat_value * obat_price);
                total_obat = total_harga_qty_obat - (obat_price * (obat_diskon / 100)) + (obat_price * (obat_ppn / 100));

                if (arr_total_obat.length < 0) {
                    arr_total_obat.push(total_obat);
                } else {
                    arr_total_obat[index] = total_obat;
                }

                total_alkes = arr_total_alkes.reduce((a, b) => {
                    return a + b;
                }, 0);

                total_harga = total_alkes + total_obat;
            } else {
                arr_total_alkes = [];
                arr_total_obat = [];
            }

            harga_obat.keyup(function() {
                render_total_price(index, status);
            });

            diskon_obat.keyup(function() {
                render_total_price(index, status);
            });

            ppn_obat.keyup(function() {
                render_total_price(index, status);
            });
        });
    }

    function render_total_price(idx, status) {
        var qty_alkes = $('.alkes_qty-' + idx);
        var qty_alkes_value = qty_alkes.text();
        var qty_obat = $('.obat_qty-' + idx);
        var qty_obat_value = qty_obat.text();

        //Alkes
        harga_alkes = $('.alkes_price-' + idx);
        diskon_alkes = $('.alkes_diskon-' + idx);
        ppn_alkes = $('.alkes_ppn-' + idx);

        //Obat
        harga_obat = $('.obat_price-' + idx);
        diskon_obat = $('.obat_diskon-' + idx);
        ppn_obat = $('.obat_ppn-' + idx);


        if (status === 'alkes') {
            alkes_price = harga_alkes.val();
            alkes_diskon = diskon_alkes.val();
            alkes_ppn = ppn_alkes.val();

            total_harga_qty_alkes = (qty_alkes_value * alkes_price);

            total_alkes = total_harga_qty_alkes - (alkes_price * (alkes_diskon / 100)) + (alkes_price * (alkes_ppn / 100));

            if (arr_total_alkes.length < 0) {
                arr_total_alkes.push(total_alkes);
            } else {
                arr_total_alkes[idx] = total_alkes;
            }

            total_alkes = arr_total_alkes.reduce((a, b) => {
                return a + b;
            }, 0);

            total_harga = total_alkes + total_obat;

            $('input[name="total_harga"]').val(parseInt(total_harga, 10));
            $('input[name="total"]').val(parseInt(total_harga, 10));

        } else {

            obat_price = harga_obat.val();
            obat_diskon = diskon_obat.val();
            obat_ppn = ppn_obat.val();

            total_harga_qty_obat = (qty_obat_value * obat_price);

            total_obat = total_harga_qty_obat - (obat_price * (obat_diskon / 100)) + (obat_price * (obat_ppn / 100));


            if (arr_total_obat.length < 0) {
                arr_total_obat.push(total_obat);
            } else {
                arr_total_obat[idx] = total_obat;
            }

            total_obat = arr_total_obat.reduce((a, b) => {
                return a + b;
            }, 0);

            total_harga = total_alkes + total_obat;

            $('input[name="total_harga"]').val(parseInt(total_harga, 10));
            $('input[name="total"]').val(parseInt(total_harga, 10));
        }

        if (diskon_faktur_rp.val() || diskon_faktur_persen.val() > 0) {
            diskon_faktur_render();
        }

    }

    /* Render Alkes */
    function render_alkes() {
        if (selected_alkes.length > 0) {
            var html_ = '';
            $('#datatable_alkes').html('');
            var no = 0;

            var id_penerimaan = $('input[name="penerimaan_id"]').val();

            $.each(selected_alkes, function(index, obj) {
                html_ += '<tr>';
                html_ += '<td>' + obj.nama_barang + '</td>';
                html_ += '<td>' + obj.kemasan + '</td>';
                html_ += '<td class="alkes_qty-' + index + '">' + obj.qty + '</td>';
                if (id_penerimaan != 0) {
                    html_ += '<td>' + obj.price + '</td>';
                    html_ += '<td>' + obj.ppn + '</td>';
                    html_ += '<td>' + obj.diskon + '</td>';
                    html_ += '<td>' + obj.batch + '</td>';
                } else {
                    html_ += '<td><input style="width:auto;" type="number" name="alkes_price" class="form-control alkes_price-' + no + '" value="<?= set_value('alkes_price'); ?>" min="0"></td>';
                    html_ += '<td><input style="width:auto;" type="number" name="alkes_ppn" class="form-control alkes_ppn-' + no + '" value="<?= set_value('alkes_ppn'); ?>" min="0"></td>';
                    html_ += '<td><input style="width:auto;" type="text" name="alkes_diskon" class="form-control alkes_diskon-' + no + '" value="<?= set_value('alkes_diskon'); ?>"></td>';
                    html_ += '<td><input style="width:auto;" type="text" name="alkes_batch' + no + '"" class="form-control alkes_batch-' + no + '" value="<?= set_value('alkes_batch'); ?>" required></td>';
                }

                html_ += '</tr>';
                no++;
            });

            $('#datatable_alkes').html(html_);
            if (id_penerimaan == 0) {
                $('input[name="alkes_price"]').val(0);
                $('input[name="alkes_ppn"]').val(11);
                $('input[name="alkes_diskon"]').val(0);
            }

        } else {
            var html_ = '';
            $('#datatable_alkes').html('');
        }
    }

    /* Render Obat */
    function render_obat() {
        if (selected_obat.length > 0) {
            var html_ = '';
            $('#datatable_obat').html('');
            var no = 0;

            var id_penerimaan = $('input[name="penerimaan_id"]').val();

            $.each(selected_obat, function(index, obj) {
                html_ += '<tr>';
                html_ += '<td>' + obj.nama_barang + '</td>';
                html_ += '<td>' + obj.kemasan + '</td>';
                html_ += '<td class="obat_qty-' + index + '">' + obj.qty + '</td>';

                if (id_penerimaan != 0) {
                    html_ += '<td>' + obj.price + '</td>';
                    html_ += '<td>' + obj.ppn + '</td>';
                    html_ += '<td>' + obj.diskon + '</td>';
                    html_ += '<td>' + obj.expired_date + '</td>';
                    html_ += '<td>' + obj.batch + '</td>';

                } else {
                    html_ += '<td><input style="width:auto;" type="number" name="obat_price" class="form-control obat_price-' + no + '" value="<?= set_value('obat_price'); ?>"></td>';
                    html_ += '<td><input style="width:auto;" type="number" name="obat_ppn" class="form-control obat_ppn-' + no + '" value="<?= set_value('obat_ppn') ?>"></td>';
                    html_ += '<td><input style="width:auto;" type="number" name="obat_diskon" class="form-control obat_diskon-' + no + '" value="<?= set_value('obat_diskon') ?>"></td>';
                    html_ += '<td><input type="date" name="expired_date' + no + '"" class="form-control expired_date-' + no + '" required></td>';
                    html_ += '<td><input style="width:auto;" name="obat_batch-' + no + '" type="text" class="form-control obat_batch-' + no + '" value="<?= set_value('obat_batch') ?>" required></td>';
                }
                html_ += '</tr>';
                no++;
            });

            $('#datatable_obat').html(html_);
            if (id_penerimaan == 0) {
                $('input[name="obat_price"]').val(0);
                $('input[name="obat_ppn"]').val(11);
                $('input[name="obat_diskon"]').val(0);
            }
        } else {
            var html_ = '';
            $('#datatable_obat').html('');
        }
    }

    function get_kemasan(id_kemasan) {
        $.ajax({
            url: '<?= site_url('admin/' . $class . '/get_kemasan'); ?>',
            type: 'POST',
            dataType: 'json',
            data: 'id_kemasan=' + id_kemasan,
            success: function(response) {
                $("#kemasan_sedang").text(response.kemasan_name);
                $("#kemasan_besar").text(response.kemasan_name);
            }
        });
    }

    $(function() {
        $("input[type='number']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });

        $('input[type="number"]').on('wheel', function() {
            return false;
        });
    });
</script>