<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
    table,
    tr td {
        border: 1px solid red
    }

    .add-scroll {
        height: 550px;
    }

    tbody {
        display: block;
        overflow: auto;
        width: 100%;
    }

    thead,
    tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    table {
        width: 400px;
    }

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
<div class="section-body">
    <div class="card">
        <div class="card-header">
            <h4>Form Entry</h4>
        </div>
        <div class="card-body">
            <form class="form-horizontal" id="FormData" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="so_id" value="<?= $so_id ?>">
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-2">Tanggal SO</label>
                    <div class="col-md-9 tanggal_so-field">
                        <input type="text" id="tanggal_so" name="tanggal_so" class="form-control" value="<?= $tanggal ?>" readonly="">
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-2">Keterangan</label>
                    <div class="col-md-9 keterangan-field">
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="10" style="height: 86px;"></textarea>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-2">Penyimpanan</label>
                    <div class="col-md-9 penyimpanan-field">
                        <select class="form-control form-select2" name="penyimpanan" id="penyimpanan" data-placeholder="Pilih Penyimpanan">
                            <option value=""></option>
                            <option value="etalase">Etalase</option>
                            <option value="gudang">Gudang</option>
                        </select>
                        <label id="penyimpanan-error" class="error" for="penyimpanan" style="display: none;"></label>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-2">Obat &amp; Alkes</label>
                    <div class="col-md-9">
                        <?php if ($so_id == 0) { ?>
                            <div class="form-clone-wrap">
                                <div class="form-group row mb-3 mx-n1 form-original">
                                    <div class="col-md-3 px-1">
                                        <input id="items" class="form-control" placeholder="Barcode atau Obat/Alkes">
                                        <input id="id_items" class="form-control" placeholder="Id Items" hidden>
                                        <input id="barcode_items" class="form-control" placeholder="Barcode Items" hidden>
                                        <input id="is_obat" class="form-control" placeholder="is obat" hidden>
                                        <div class="invalid-feedback d-none feedback-items">
                                            Kemasan harus di isi
                                        </div>
                                    </div>
                                    <div class="col-md-2 px-1">
                                        <select id="kemasan" class="form-control form-select2" name="kemasan_id" data-placeholder="Kemasan" disabled>
                                            <option value=""></option>
                                        </select>
                                        <div class="invalid-feedback d-none feedback-kemasan">
                                            Kemasan harus di isi
                                        </div>
                                    </div>
                                    <div class="col-md-2 px-1">
                                        <select id="ex_date" class="form-control form-select2" name="ex_date_id" data-placeholder="Exp Date" disabled></select>
                                        <div class="invalid-feedback d-none feedback-ex_date">
                                            Expired Date harus di isi
                                        </div>
                                    </div>
                                    <div class="col-md-2 px-1">
                                        <select id="batch" class="form-control form-select2" name="batch_id" data-placeholder="Batch" disabled>
                                            <option value=""></option>
                                        </select>
                                        <div class="invalid-feedback d-none feedback-batch">
                                            Batch harus di isi
                                        </div>
                                    </div>
                                    <div class="col-md-1 px-1">
                                        <input id="qty" type="number" class="form-input form-control" placeholder="Qty" readonly>
                                        <div class="invalid-feedback d-none feedback-qty">
                                            Qty Sebelum tidak boleh kosong atau 0
                                        </div>
                                    </div>
                                    <div class="col-md-1 px-1">
                                        <input id="qty_after" type="number" class="form-input form-control" placeholder="Qty" min="0">
                                        <div class="invalid-feedback d-none feedback-qty">
                                            Qty Sesudah tidak boleh kosong atau 0
                                        </div>
                                    </div>
                                    <div class="col-md-1 px-1">
                                        <div>
                                            <button id="add_newitem" class="btn btn-info btn-clone" type="button"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="table-responsive">
                            <table class="table table-product table-bordered table-sm">
                                <thead>
                                    <tr class="text-center">
                                        <th rowspan="2">Obat &amp; Alkes</th>
                                        <th rowspan="2">Kemasan</th>
                                        <th rowspan="2">Expired Date</th>
                                        <th rowspan="2">Batch</th>
                                        <th colspan="2">Qty</th>
                                        <?php
                                        if ($so_id == 0) { ?>
                                            <th rowspan="2">Action</th>
                                        <?php }
                                        ?>
                                    </tr>
                                    <tr class="text-center">
                                        <th>Sebelum</th>
                                        <th>Sesudah</th>
                                    </tr>
                                </thead>
                                <tbody id="list_item" scrollbars="yes">
                                    <!-- Multiple Data In Here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php if ($so_id == 0) { ?>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-2"></label>
                        <div class="col-md-9">
                            <button class="btn btn-primary" type="button" id="save">Simpan</button>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-2"></label>
                        <div class="col-md-9">
                            <a href="<?= site_url('admin/' . $class . '/data'); ?>" class="btn btn-primary" type="button">Kembali</a>
                        </div>
                    </div>
                <?php } ?>
            </form>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('.form-select2').select2();
    });

    $(document).ready(function() {
        let x = 0
        let qty = 0
        let selected_barang = [];
        let id_item = '';
        var so_id = $('input[name="so_id"]').val();

        if (so_id != 0) {
            $.ajax({
                url: '<?= site_url('admin/' . $class . '/trx_edit'); ?>',
                type: 'GET',
                dataType: 'json',
                data: {
                    so_id: so_id
                },
                success: function(response) {
                    let detail = response.data[0].detail;
                    let data_edit = response.data;
                    var items = {};
                    detail.forEach(function(item) {
                        selected_barang.push(item);
                    });
                    
                    data_edit.forEach(function(items) {
                        $('#FormData').find('#tanggal_so').val(items.tanggal_so);
                        $('#FormData').find('#keterangan').val(items.keterangan);
                        $('#penyimpanan').val(items.penyimpanan);
                        $("#penyimpanan").select2().trigger('change');
                        $("#penyimpanan").prop('disabled', true);
                    });
                    render_items();
                }
            });
        }

        $.validator.setDefaults({
            ignore: ":hidden:not('select')" // validate all hidden select elements
        });

        var validator = $('#FormData').validate({
            rules: {
                tanggal_so: {
                    required: function(element) {
                        return $('.tanggal_so-field').addClass('is-invalid');
                    }
                },
                keterangan: {
                    required: function(element) {
                        return $('.keterangan-field').addClass('is-invalid');
                    }
                },
                penyimpanan: {
                    required: function(element) {
                        return $('.penyimpanan-field').addClass('is-invalid');
                    }
                },
            },
        });

        $(document).on('change', '#penyimpanan', function() {
            var penyimpanan = $('#penyimpanan').val();
            var so_id = $('input[name="so_id"]').val();

            if (penyimpanan) {
                $('#penyimpanan-error').hide();
                reset_form();
                $('.invalid-feedback').removeClass('d-block');
                $('.invalid-feedback').addClass('d-none');
                
            }
                        
            if (so_id == 0) {
                selected_barang = [];
            }
            render_items();
        });


        /* ====================== Call Function ====================== */
        core_form();

        /* ====================== Make Function ====================== */
        function core_form() {
            $('#tanggal_so').focus();

            let cacheItem = {};
            let is_obat = '';
            var barcode = '';

            /* ====================== Input Dinamis Here ====================== */
            $("#items").autocomplete({
                minLength: 1,
                source: function(request, response) {
                    $('#kemasan').empty();
                    $('#kemasan').prop('disabled', true);
                    $('#ex_date').empty();
                    $('#ex_date').prop('disabled', true);
                    $('#batch').empty();
                    $('#batch').prop('disabled', true);
                    $('#qty').val('');

                    if ($('#penyimpanan').val() == '') {
                        $('.feedback-kemasan').addClass('d-block');
                        $('.feedback-kemasan').removeClass('d-none');
                        $('.feedback-kemasan').html("Pilih Penyimpanan terlebih dahulu");
                    } else {
                        $('.feedback-kemasan').removeClass('d-block');
                        $('.feedback-kemasan').addClass('d-none');
                        $('.feedback-kemasan').html("Pilih Penyimpanan terlebih dahulu");
                    }

                    $.getJSON('<?= site_url("admin/{$class}/get_stok"); ?>?penyimpanan=' + $(
                        '#penyimpanan').val(), request, function(data, status, xhr) {
                        if (data.length == 0) {
                            $('.feedback-items').addClass('d-block');
                            $('.feedback-items').removeClass('d-none');
                            $('.feedback-items').html('Data tidak tersedia');
                        }
                        response(data);
                    });
                },
                select: function(event, obj) {
                    is_obat = obj.item.is_obat;
                    id_item = obj.item.id;
                    barcode = obj.item.barcode;
                    var penyimpanan = $('#penyimpanan').val();

                    $('#kemasan').prop('disabled', false);
                    $('#kemasan').focus();
                    $('#kemasan').empty();
                    $('#ex_date').prop('disabled', true);
                    $('#ex_date').empty();
                    $('#batch').prop('disabled', true);
                    $('#batch').empty();
                    
                    $('#id_items').val(id_item);
                    $('#barcode_items').val(barcode);
                    $('#is_obat').val(is_obat);

                    cek_kemasan(is_obat, barcode, penyimpanan).success(function(res) {
                        $('#kemasan').select2({
                            data: res,
                        });
                        $('#kemasan').select2(res).select2('open');
                    });

                    if ($('#items').val() == '') {
                        $('#kemasan').empty();
                        $('#kemasan').prop('disabled', true);
                        $('#ex_date').empty();
                        $('#ex_date').prop('disabled', true);
                        $('#batch').empty();
                        $('#batch').prop('disabled', true);
                    }
                    return false;
                },
                focus: function(event, obj) {
                    $('#items').val(obj.item.value);
                },
            });

            $('#items').focusout(function(e) {
                if ($('#items').val() == '' || null) {
                    $('#kemasan').empty();
                    $('#kemasan').prop('disabled', true);
                    $('#ex_date').empty();
                    $('#ex_date').prop('disabled', true);
                    $('#batch').empty();
                    $('#batch').prop('disabled', true);
                }
            });

            $(document).on('change', '#kemasan', function() {
                var is_obat = $('#is_obat').val();
                var prefix = $('#kemasan').val();
                var penyimpanan = $('#penyimpanan').val();
                barcode = $('#barcode_items').val();

                if (is_obat == 1) {
                    $('#ex_date').prop('disabled', false);
                    $('#ex_date').empty();
                    $('#batch').prop('disabled', true);
                    $('#batch').empty();
                    $('#qty').val('');

                    // (is_obat, barcode, penyimpanan, id_kemasan)
                    cek_exp_date(is_obat, barcode, penyimpanan).success(function(res) {
                        $('#ex_date').select2({
                            data: res,
                        });
                        $('#ex_date').select2(res).select2('open');
                    });
                } else {
                    $('#ex_date').prop('disabled', true);
                    $('#batch').prop('disabled', false);
                    $('#batch').empty();
                    $('#batch').focus();

                    // is_obat, prefix, penyimpanan, barcode
                    cek_batch(is_obat, prefix, penyimpanan, barcode).success(function(res) {
                        $('#batch').select2({
                            data: res,
                        });
                        $('#batch').select2(res).select2('open');
                    });
                }

                if ($('#kemasan').val() == '') {
                    $('#ex_date').empty();
                    $('#ex_date').prop('disabled', true);
                    $('#batch').empty();
                    $('#batch').prop('disabled', true);
                }
                return false;
            });

            $(document).on('change', '#ex_date', function() {
                var is_obat = $('#is_obat').val();
                var prefix = $('#ex_date').val();
                var penyimpanan = $('#penyimpanan').val();
                barcode = $('#barcode_items').val();

                $('#batch').prop('disabled', false);
                $('#batch').empty();
                $('#qty').val('');

                // is_obat, prefix, penyimpanan, barcode
                cek_batch(is_obat, prefix, penyimpanan, barcode).success(function(res) {
                    $('#batch').select2({
                        data: res,
                    });
                    $('#batch').select2(res).select2('open');
                });

                if ($('#kemasan').val() == '') {
                    $('#ex_date').empty();
                    $('#ex_date').prop('disabled', true);
                    $('#batch').empty();
                    $('#batch').prop('disabled', true);
                }
                return false;
            });

            $(document).on('change', '#batch', function() {
                barcode = $('#barcode_items').val();
                id_items = $('#id_items').val();
                var batch = $(this).val();
                var kemasan = $('#kemasan').val();
                var penyimpanan = $('#penyimpanan').val();
                var ex_date = $('#ex_date').val();
                var is_obat = $('#is_obat').val();

                get_stok_konversi(is_obat, id_items, penyimpanan, kemasan, batch, barcode, ex_date).success(
                    function(res) {
                        $.each(res, function(index, value) {
                            $('#qty').val(value.qty);
                            $('#qty_after').focus();
                        });
                    }
                );
                return false;
            });

            $('#add_newitem').click(function(e) {
                e.preventDefault();
                barcode = $('#barcode_items').val();
                id_items = $('#id_items').val();

                var penyimpanan = $('#penyimpanan').val();
                var nama_barang = $('#items').val();
                var batch = $('#batch').val();
                var kemasan = $('#kemasan').val();
                var qty = $('#qty').val();
                var is_obat = $('#is_obat').val();
                var qty_after = $('#qty_after').val();
                var ex_date = $('#ex_date').val();
                var nama_kemasan = '';

                get_stok_satuan(is_obat, id_items, penyimpanan, kemasan, batch, barcode, ex_date).success(function(
                    res) {
                    $.each(res, function(index, value) {
                        console.log(value);
                        add_list_detail_produk(value.id, value.nama_barang, value.kemasan,
                            value.ex_date, value.batch, qty, qty_after, is_obat,
                            barcode, penyimpanan, value.id_barang, value.id_kemasan
                        );
                    });
                });

                if (selected_barang.length > 10) {
                    $('#list_item').addClass("add-scroll");
                }

                if ($('#qty_after').val() == 0 || '') {
                    qty_after = 1;
                }

                if (penyimpanan != '') {
                    $('#items').val('');
                    $('#kemasan').empty();
                    $('#kemasan').prop('disabled', true);
                    $('#ex_date').empty();
                    $('#ex_date').prop('disabled', true);
                    $('#batch').empty();
                    $('#batch').prop('disabled', true);
                    $('#qty').val('');
                    $('#qty_after').val('');
                } else {
                    $('#items').focus();
                }
            });

            $('#save').click(function(e) {
                let data = {};
                data = {
                    so_id: so_id,
                    tanggal_so: $('#tanggal_so').val(),
                    keterangan: $('#keterangan').val(),
                    penyimpanan: $('#penyimpanan').val(),
                    detail_barang: selected_barang
                };
                if ($('#FormData').valid() != false) {
                    if (selected_barang.length < 1) {
                        $('#items').focus();
                    } else {
                        swal({
                            title: 'Apakah anda yakin?',
                            text: 'Pastikan data sudah sesuai',
                            icon: 'warning',
                            buttons: true,
                            dangerMode: true,
                        }).then((confirm) => {
                            if (confirm) {
                                $.ajax({
                                    url: '<?= site_url('admin/' . $class . '/trx_save'); ?>',
                                    type: 'POST',
                                    dataType: 'JSON',
                                    data: data,
                                    success: function(response) {
                                        if (response['status'] != 200) {
                                            toastr.error(
                                                response['message'],
                                                'Gagal', {
                                                    timeOut: 1200,
                                                    fadeOut: 500,
                                                    onHidden: function() {
                                                        location.reload();
                                                    }
                                                }
                                            );
                                        }
                                        window.location.href =
                                            '<?= base_url('admin/' . $class . '/after_save'); ?>';
                                    },
                                });
                            }
                        });
                    }
                }
            });
        }

        /*

            $id = $this->input->post('id');
            $kemasan = $this->input->post('kemasan');
            $penyimpanan = $this->input->post('penyimpanan');
            $batch = $this->input->post('batch');
            $barcode = $this->input->post('barcode');
            $new_qty = $this->input->post('new_qty');

        */

        //Cari kemasan untuk new_qty
        function search_kemasan(id, id_kemasan, penyimpanan, batch, barcode, qty_after, is_obat) {
            return $.ajax({
                url: '<?= site_url('admin/' . $class . '/search_kemasan'); ?>',
                type: 'GET',
                dataType: 'json',
                data: {
                    id: id,
                    id_kemasan: id_kemasan,
                    penyimpanan: penyimpanan,
                    batch: batch,
                    barcode: barcode,
                    new_qty: qty_after,
                }
            });
        }

        /* Fungsi untuk mencari nama kemasan */
        function kemasan_id(kemasan) {
            return $.ajax({
                url: '<?= site_url('admin/' . $class . '/kemasan_by_id'); ?>',
                type: 'GET',
                dataType: 'json',
                data: {
                    id: kemasan
                }
            });
        }

        /* Fungsi Ajax get kemasan setelah barcode obat/alkes */
        function cek_kemasan(is_obat, barcode, penyimpanan) {
            return $.ajax({
                url: '<?= site_url('admin/' . $class . '/get_kemasan'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    is_obat: is_obat,
                    barcode: barcode,
                    penyimpanan: penyimpanan,
                }
            });
        }

        /* Fungsi Ajax get exp_date setelah barcode obat/alkes */
        function cek_exp_date(is_obat, barcode, penyimpanan) {
            return $.ajax({
                url: '<?= site_url('admin/' . $class . '/get_exp_date'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    is_obat: is_obat,
                    // id_kemasan: id_kemasan,
                    barcode: barcode,
                    penyimpanan: penyimpanan,
                }
            });
        }

        /* Fungsi Ajax get batch setelah barcode obat/alkes */
        function cek_batch(is_obat, prefix, penyimpanan, barcode) {
            return $.ajax({
                url: '<?= site_url('admin/' . $class . '/get_batch'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    is_obat: is_obat,
                    prefix: prefix,
                    penyimpanan: penyimpanan,
                    barcode: barcode,
                }
            });
        }

        /* Fungsi Ajax get satuan setelah barcode obat/alkes */
        function get_stok_satuan(is_obat, id_barang, penyimpanan, kemasan, batch, barcode, ex_date) {
            return $.ajax({
                url: '<?= site_url('admin/' . $class . '/get_stok_satuan'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    is_obat: is_obat,
                    id: id_barang,
                    penyimpanan: penyimpanan,
                    kemasan: kemasan,
                    batch: batch,
                    barcode: barcode,
                    ex_date: ex_date,
                }
            });
        }
        
        /* Fungsi Ajax get satuan setelah di konversi kuantiti */
        function get_stok_konversi(is_obat, id, penyimpanan, kemasan, batch, barcode, ex_date) {
            return $.ajax({
                url: '<?= site_url('admin/' . $class . '/get_stok_konversi'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    is_obat: is_obat,
                    id: id,
                    penyimpanan: penyimpanan,
                    kemasan: kemasan,
                    batch: batch,
                    barcode: barcode,
                    ex_date: ex_date,
                }
            });
        }

        function render_items() {
            var so_id = $('input[name="so_id"]').val();
            if (selected_barang.length > 0) {
                var html_ = '';
                $('#list_item').html('');

                if (so_id == 0) {
                    $.each(selected_barang, function(index, obj) {
                        html_ += '<tr class="text-center">';
                        html_ += '<td>' + obj.nama_barang + '</td>';
                        html_ += '<td>' + obj.kemasan + '</td>';
                        html_ += '<td>' + obj.ex_date + '</td>';
                        html_ += '<td>' + obj.batch + '</td>';
                        html_ += '<td>' + obj.qty + '</td>';
                        html_ += '<td>' + obj.qty_after + '</td>';

                        html_ +=
                            '<td><button class="btn btn-danger btn_remove" type="button" data-index="' +
                            index + '"><i class="fa fa-trash"></i></button></td>';

                        html_ += '</tr>';
                    });
                } else {
                    $.each(selected_barang, function(index, obj) {
                        html_ += '<tr class="text-center">';
                        html_ += '<td>' + obj.nama_barang + '</td>';
                        html_ += '<td>' + obj.kemasan + '</td>';
                        html_ += '<td>' + obj.ex_date + '</td>';
                        html_ += '<td>' + obj.batch + '</td>';
                        html_ += '<td>' + obj.qty + '</td>';
                        html_ += '<td>' + obj.qty_after + '</td>';
                        html_ += '</tr>';
                    });
                }
                $('#list_item').html(html_);
            } else {
                $('#list_item').html('');
            }
            remove_items();
        }

        function add_list_detail_produk(id, nama_barang, kemasan, ex_date, batch, qty, qty_after, is_obat,
            barcode, penyimpanan, id_barang, id_kemasan) {
            var arr_length = selected_barang.length;
            var items = {};
            var select_product = selected_barang.length;

            if (select_product == 0) {

                search_kemasan(id_barang, id_kemasan, penyimpanan, batch, barcode, qty_after, is_obat).success(function(
                    data) {
                    items.qty_konversi = data.new_qty;
                    items.id_kemasan = data.id_kemasan;
                });

                items.id = id;
                items.qty = qty;
                items.batch = batch;
                items.is_obat = is_obat;
                items.kemasan = kemasan;
                items.ex_date = ex_date;
                items.qty_after = qty_after;
                items.nama_barang = nama_barang;

                selected_barang.push(items);
            } else {
                var same_items = false;

                for (var i = 0, select_product = selected_barang.length; i < select_product; i++) {
                    // if (selected_barang[i]['id'] === id && selected_barang[i]['kemasan'] === kemasan) {

                    /* For hapus array jika barang, expired_date dan batch sama */ 
                    if (selected_barang[i]['id'] === id && selected_barang[i]['ex_date'] == ex_date && selected_barang[i]['batch'] == batch) {
                        var remove_array = selected_barang.indexOf(selected_barang[i]);
                        selected_barang.splice(remove_array, 1);

                        search_kemasan(id_barang, id_kemasan, penyimpanan, batch, barcode, qty_after, is_obat).success(function(
                            data) {
                            items.qty_konversi = data.new_qty;
                            items.id_kemasan = data.id_kemasan;
                        });

                        items.id = id;
                        items.qty = qty;
                        items.batch = batch;
                        items.is_obat = is_obat;
                        items.kemasan = kemasan;
                        items.ex_date = ex_date;
                        items.qty_after = qty_after;
                        items.nama_barang = nama_barang;

                        selected_barang.push(items);

                        // selected_barang[i]['qty_after'] = parseInt(selected_barang[i]['qty_after']) + parseInt(
                        //     qty_after);

                        // search_kemasan(id_obat, selected_barang[i]['id_kemasan'], penyimpanan, batch, barcode,
                        //     selected_barang[i]['qty_konversi']).success(function(
                        //     data) {
                        //     selected_barang[i]['qty_konversi'] = parseInt(selected_barang[i][
                        //         'qty_konversi'
                        //     ]) + parseInt(
                        //         data.new_qty);
                        // });

                        same_items = true;
                    }
                }

                if (same_items == false) {
                    search_kemasan(id_barang, id_kemasan, penyimpanan, batch, barcode, qty_after, is_obat).success(function(
                        data) {
                        items.qty_konversi = data.new_qty;
                        items.id_kemasan = data.id_kemasan;
                    });

                    items.id = id;
                    items.qty = qty;
                    items.batch = batch;
                    items.is_obat = is_obat;
                    items.kemasan = kemasan;
                    items.ex_date = ex_date;
                    items.qty_after = qty_after;
                    items.nama_barang = nama_barang;

                    selected_barang.push(items);
                }
            }
            render_items();
        }

        function remove_items() {
            $('.btn_remove').click(function() {
                var index = $(this).attr('data-index');
                selected_barang.splice(index, 1);
                render_items();
            });
        }

        function reset_form() {
            $('#items').val('');
            $('#kemasan').empty();
            $('#kemasan').prop('disabled', true);
            $('#ex_date').empty();
            $('#ex_date').prop('disabled', true);
            $('#batch').empty();
            $('#batch').prop('disabled', true);
            $('#qty').val('');
            $('#qty_after').val('');
        }
    });
</script>