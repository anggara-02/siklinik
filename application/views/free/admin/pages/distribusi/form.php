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
                <input type="hidden" name="id" value="<?= $id ?>">
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-2">Tanggal Distribusi</label>
                    <div class="col-md-9 tanggal-field">
                        <input type="text" id="tanggal" name="tanggal" class="form-control" value="<?= $tanggal ?>"
                            readonly="">
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-2">Sumber</label>
                    <div class="col-md-9 sumber-field">
                        <select class="form-control form-select2" name="sumber" id="sumber"
                            data-placeholder="Pilih Sumber">
                            <option value=""></option>
                            <option value="etalase">Etalase</option>
                            <option value="gudang">Gudang</option>
                            <option value="promo">Promo</option>
                        </select>
                        <label id="sumber-error" class="error" for="sumber" style="display: none;"></label>
                        <label id="sumber_error" class="error" style="display: none;color: red"></label>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-2">Tujuan</label>
                    <div class="col-md-9 tujuan-field">
                        <select class="form-control form-select2" name="tujuan" id="tujuan"
                            data-placeholder="Pilih Tujuan">
                            <option value=""></option>
                            <option value="etalase">Etalase</option>
                            <option value="gudang">Gudang</option>
                            <option value="promo">Promo</option>
                        </select>
                        <label id="tujuan-error" class="error" for="tujuan" style="display: none;"></label>
                        <label id="tujuan_error" class="label" style="display: none;color: red;"></label>
                    </div>
                </div>
                <div class="form-group row" style="display: none;" id="same_error">
                    <label class="col-form-label text-md-right col-12 col-md-2"></label>
                    <div class="col-md-9 tujuan-field">
                        <label class="label" style="color: red;"><i>*Sumber dan tujuan sama</i></label>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-2">Obat &amp; Alkes</label>
                    <div class="col-md-9">
                        <?php if ($id == 0) { ?>
                        <div class="form-clone-wrap">
                            <div class="form-group row mb-3 mx-n1 form-original">
                                <div class="col-md-3 px-1">
                                    <input id="items" class="form-control" placeholder="Barcode atau Obat/Alkes">
                                    <input id="id_items" class="form-control" placeholder="Id Items" hidden>
                                    <input id="id_stok" class="form-control" placeholder="Id Stok" hidden>
                                    <input id="is_obat" class="form-control" placeholder="is obat" hidden>
                                    <input id="id_obat" class="form-control" placeholder="id obat" hidden>
                                    <input id="barcode_items" class="form-control" placeholder="Barcode Items" hidden>

                                    <div class="invalid-feedback d-none feedback-items">
                                        Kemasan harus di isi
                                    </div>
                                </div>
                                <div class="col-md-2 px-1">
                                    <select id="kemasan" class="form-control form-select2" name="kemasan_id"
                                        data-placeholder="Kemasan" disabled>
                                        <option value=""></option>
                                    </select>
                                    <div class="invalid-feedback d-none feedback-kemasan">
                                        Kemasan harus di isi
                                    </div>
                                </div>
                                <div class="col-md-2 px-1">
                                    <select id="ex_date" class="form-control form-select2" name="ex_date_id"
                                        data-placeholder="Exp Date" disabled></select>
                                    <div class="invalid-feedback d-none feedback-ex_date">
                                        Expired Date harus di isi
                                    </div>
                                </div>
                                <div class="col-md-2 px-1">
                                    <select id="batch" class="form-control form-select2" name="batch_id"
                                        data-placeholder="Batch" disabled></select>
                                    <div class="invalid-feedback d-none feedback-batch">
                                        Batch harus di isi
                                    </div>
                                </div>
                                <div class="col-md-2 px-1">
                                    <input id="qty" type="number" class="form-input form-control" placeholder="Qty">
                                    <div class="invalid-feedback d-none feedback-qty">
                                        Qty Sebelum tidak boleh kosong atau 0
                                    </div>
                                </div>
                                <div class="col-md-1 px-1">
                                    <div>
                                        <button id="add_newitem" class="btn btn-info btn-clone" type="button"><i
                                                class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="table-responsive">
                            <table class="table table-product table-bordered table-sm">
                                <thead>
                                    <tr class="text-center">
                                        <th>Obat &amp; Alkes</th>
                                        <th>Kemasan</th>
                                        <th>Expired Date</th>
                                        <th>Batch</th>
                                        <th>Qty</th>
                                        <?php
                                        if ($id == 0) { ?>
                                        <th>Action</th>
                                        <?php   }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody id="list_item" scrollbars="yes">
                                    <!-- Multiple Data In Here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php if ($id == 0) { ?>
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
                        <a href="<?= site_url('admin/' . $class . '/data'); ?>" class="btn btn-primary"
                            type="button">Kembali</a>
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
    var id = $('input[name="id"]').val();

    if (id != 0) {
        $.ajax({
            url: '<?= site_url('admin/' . $class . '/trx_edit'); ?>',
            type: 'GET',
            dataType: 'json',
            data: {
                id: id
            },
            success: function(response) {
                let detail = response.data[0].detail;
                let data_edit = response.data;
                detail.forEach(function(item) {
                    selected_barang.push(item);
                });

                data_edit.forEach(function(items) {
                    $('#FormData').find('#tanggal').val(items.tanggal);
                    $('#tujuan').val(items.tujuan);
                    $("#tujuan").select2().trigger('change');
                    $('#tujuan').prop('disabled', true);
                    $('#sumber').val(items.sumber);
                    $("#sumber").select2().trigger('change');
                    $('#sumber').prop('disabled', true);
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
            tanggal: {
                required: function(element) {
                    return $('.tanggal-field').addClass('is-invalid');
                }
            },
            sumber: {
                required: function(element) {
                    return $('.sumber-field').addClass('is-invalid');
                }
            },
            tujuan: {
                required: function(element) {
                    return $('.tujuan-field').addClass('is-invalid');
                }
            },
        },
    });

    $(document).on('change', '#tujuan', function() {
        var tujuan = $('#tujuan').val();
        if (tujuan) {
            $('#tujuan-error').hide();
            reset_form();
            $('.invalid-feedback').removeClass('d-block');
            $('.invalid-feedback').addClass('d-none');
        }
    });

    $(document).on('keyup', '#qty', function() {
        var id_stok = $('#id_stok').val();
        var qty = $('#qty').val();
        var kemasan = $('#kemasan').val();

        get_sisa_sediaan(id_stok, qty, kemasan).success(function(res) {
            if (res.status == 500) {
                swal({
                    title: 'Kesalahan',
                    text: 'Qty melebihi ketersediaan stok',
                    icon: 'error',  
                    buttons: true,
                }).then((e) => {
                    $('#qty').focus();
                });
                $('#add_newitem').hide();
            } else {
                $('#add_newitem').show();
            }
        });
    });


    /* ====================== Call Function ====================== */
    core_form();


    /* ====================== Make Function ====================== */
    function core_form() {
        $('#tanggal').focus();

        let cacheItem = {};
        let is_obat = '';
        let barcode = '';
        var tujuan = $('#tujuan');
        var sumber = $('#sumber');

        $('#tujuan').on('change', function(e) {
            tujuan.removeClass('is-invalid');
            $('#tujuan_error').hide();
            $('#same_error').hide();
            if ($(this).val() == sumber.val()) {
                $('#same_error').show();
            } else {
                $('#same_error').hide();
            }
        });

        $('#sumber').on('change', function(e) {
            sumber.removeClass('is-invalid');
            $('#sumber_error').hide();
            if ($(this).val() == tujuan.val()) {
                $('#same_error').show();
            } else {
                $('#same_error').hide();
            }
        });

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

                if (tujuan.val() == '' && sumber.val() == '') {
                    tujuan.addClass('is-invalid');
                    $('#tujuan_error').show();
                    $('#tujuan_error').text('Pilih tujuan terlebih dahulu');
                    sumber.addClass('is-invalid');
                    $('#sumber_error').show();
                    $('#sumber_error').text('Pilih sumber terlebih dahulu');
                } else if (tujuan.val() == '') {
                    tujuan.addClass('is-invalid');
                    $('#tujuan_error').show();
                    $('#tujuan_error').text('Pilih tujuan terlebih dahulu');
                    sumber.removeClass('is-invalid');
                    $('#sumber_error').hide();
                } else if (sumber.val() == '') {
                    tujuan.removeClass('is-invalid');
                    $('#tujuan_error').hide();
                    sumber.addClass('is-invalid');
                    $('#sumber_error').show();
                    $('#sumber_error').text('Pilih sumber terlebih dahulu');
                } else {
                    $.getJSON('<?= site_url("admin/{$class}/get_stok"); ?>?sumber=' + sumber.val(),
                        request,
                        function(data, status, xhr) {
                            if (data.length == 0) {
                                $('.feedback-items').addClass('d-block');
                                $('.feedback-items').removeClass('d-none');
                                $('.feedback-items').html('Data tidak tersedia');
                            }
                            response(data);
                        });
                }
                // $('.feedback-kemasan').addClass('d-block');
                // $('.feedback-kemasan').removeClass('d-none');
                // $('.feedback-kemasan').html("Pilih Penyimpanan terlebih dahulu");
                // $('.feedback-kemasan').removeClass('d-block');
                // $('.feedback-kemasan').addClass('d-none');
            },
            select: function(event, obj) {
                is_obat = obj.item.is_obat;
                id_item = obj.item.id;
                barcode = obj.item.barcode;
                var id_stok = obj.item.id_stok;
                var sumber = $('#sumber').val();

                $('#kemasan').prop('disabled', false);
                $('#kemasan').focus();
                $('#kemasan').empty();
                $('#ex_date').prop('disabled', true);
                $('#ex_date').empty();
                $('#batch').empty();
                $('#batch').prop('disabled', true);
                $('#id_stok').val(id_stok);
                $('#id_items').val(id_item);
                $('#is_obat').val(is_obat);
                $('#barcode_items').val(barcode);

                cek_kemasan(is_obat, barcode, sumber).success(function(res) {
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
                    $('.feedback-kemasan').addClass('d-none');
                    $('.feedback-kemasan').removeClass('d-block');
                    $('.feedback-kemasan').html('');
                }
                return false;
            },
            focus: function(event, obj) {
                $('#items').val(obj.item.value);
            },
        });

        $('#items').keyup(function() {
            if ($('#items').val() === '') {
                $('#sumber_error').hide();
                $('#tujuan_error').hide();
            }
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
            var tujuan = $('#tujuan').val();
            var barcode = $('#barcode_items').val();
            var sumber = $('#sumber').val();

            if (is_obat == 1) {
                $('#ex_date').empty();
                $('#ex_date').prop('disabled', false);
                $('#ex_date').focus();
                $('#batch').empty();
                $('#batch').prop('disabled', true);

                cek_exp_date(is_obat, sumber, barcode).success(function(res) {
                    $('#ex_date').select2({
                        data: res,
                    });
                    $('#ex_date').select2(res).select2('open');
                });
            } else {
                var prefix = $('#kemasan').val();
                $('#ex_date').prop('disabled', true);
                $('#batch').prop('disabled', false);
                $('#batch').empty();
                $('#batch').focus();
                cek_batch(is_obat, prefix, sumber, barcode).success(function(res) {
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
            var prefix = $('#ex_date option:selected').text();

            var id_stok_ex_date = $('#ex_date').val();
            
            var sumber = $('#sumber').val();
            var barcode = $('#barcode_items').val();
            
            $('#batch').prop('disabled', false);
            $('#batch').empty();
            $('#batch').focus();
            
            cek_batch(is_obat, prefix, sumber, barcode).success(function(res) {
                $('#batch').select2({
                    data: res
                });
                $('#batch').select2(res).select2('open');
            });
            
            if ($('#kemasan').val() == '') {
                $('#ex_date').empty();
                $('#ex_date').prop('disabled', true);
                $('#batch').empty();
                $('#batch').prop('disabled', true);
            }
            
            $('#id_stok').val(id_stok_ex_date);
            
            return false;
        });

        $(document).on('change', '#batch', function() {
            // var batch = $('#batch').val();
            // var sumber = $('#sumber').val();
            // var barcode = $('#barcode_items').val();
            // var id_items = $('#id_items').val();
            
            var id_stok_batch = $(this).val();
            $('#id_stok').val(id_stok_batch);

            var id_stok = $('#id_stok').val();
            var is_obat = $('#is_obat').val();
            var status = 1;
            var kemasan = $('#kemasan').val();

            get_stok_satuan(is_obat, status, id_stok, kemasan).success(function(res) {
                $.each(res, function(index, value) {
                    if (value.qty != 0) {
                        $('#qty').prop('disabled', false);
                        $('.feedback-qty').addClass('d-block');
                        $('.feedback-qty').removeClass('d-none');
                        $('.feedback-qty').html("Qty tersedia adalah " + value.qty);
                    } else {
                        $('#qty').val(value.qty);
                        $('#qty').prop('disabled', true);
                        $('.feedback-qty').html("Qty tersedia adalah " + value.qty);
                    }
                    $('#qty').focus();
                });
            });

            $('#qty').val('');
            $('#add_newitem').show();
            
            return false;
        });

        $('#add_newitem').click(function(e) {
            e.preventDefault();
            // var sumber = $('#sumber').val();
            // var nama_barang = $('#items').val();
            // var batch = $('#batch').val();
            // var id_items = $('#id_items').val();
            // var barcode = $('#barcode_items').val();
            
            var status = 0;
            var is_obat = $('#is_obat').val();
            var id_stok = $('#id_stok').val();
            var kemasan = $('#kemasan').val();
            var ex_date = $('#ex_date').text();
            var qty = $('#qty').val();

            $('.invalid-feedback').removeClass('d-block');
            $('.invalid-feedback').addClass('d-none');

            // is_obat, id_items, sumber, kemasan, batch, barcode
            get_stok_satuan(is_obat, status, id_stok, kemasan, qty).success(function(res) {
                $.each(res, function(index, value) {
                    console.log(value);
                    if (qty != 0) {
                        add_list_detail_produk(value.id, value.nama_barang, value
                            .kemasan,
                            value.ex_date, value.batch, qty, is_obat, value.qty_konversi);
                    } else {
                        swal({
                            text: 'Kuantiti Kurang Dari 1',
                            icon: 'error',
                            buttons: true,
                            dangerMode: true,
                        });
                    }
                });
            });

            if (selected_barang.length > 10) {
                $('#list_item').addClass("add-scroll");
            }

            if ($('#qty').val() == 0 || '') {
                qty_after = 1;
            }

            if (tujuan != '') {
                $('#items').val('');
                $('#kemasan').empty();
                $('#kemasan').prop('disabled', true);
                $('#ex_date').empty();
                $('#ex_date').prop('disabled', true);
                $('#batch').empty();
                $('#batch').prop('disabled', true);
                $('#qty').val('');
            } else {
                $('#items').focus();
            }
        });

        $('#save').click(function(e) {
            let data = {};

            if (id != 0) {
                data = {
                    id: id,
                    tanggal: $('#tanggal').val(),
                    tujuan: $('#tujuan').val(),
                    sumber: $('#sumber').val(),
                    detail_barang: selected_barang
                };
            } else {
                data = {
                    id: 'save',
                    tanggal: $('#tanggal').val(),
                    tujuan: $('#tujuan').val(),
                    sumber: $('#sumber').val(),
                    detail_barang: selected_barang
                };
            }

            if ($('#FormData').valid() != false) {
                if ($('#same_error').is(":hidden")) {
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
                                        // if (response['status'] != 200) {
                                        //     toastr.error(
                                        //         response['message'],
                                        //         'Gagal', {
                                        //             timeOut: 1200,
                                        //             fadeOut: 500,
                                        //             onHidden: function() {
                                        //                 location.reload();
                                        //             }
                                        //         }
                                        //     );
                                        // }
                                        window.location.href =
                                            '<?= base_url('admin/' . $class . '/after_save'); ?>';
                                    },
                                });
                            }
                        });
                    }
                }
            } {
                tujuan.removeClass('is-invalid');
                $('#tujuan_error').hide();
                sumber.removeClass('is-invalid');
                $('#sumber_error').hide();
            }
        });
    }

    /* Fungsi Ajax get kemasan setelah barcode obat/alkes */
    function cek_kemasan(is_obat, barcode, sumber) {
        return $.ajax({
            url: '<?= site_url('admin/' . $class . '/get_kemasan'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                is_obat: is_obat,
                barcode: barcode,
                sumber: sumber,
            }
        });
    }

    /* Fungsi Ajax get exp_date setelah barcode obat/alkes */
    function cek_exp_date(is_obat, sumber, barcode) {
        return $.ajax({
            url: '<?= site_url('admin/' . $class . '/get_exp_date'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                is_obat: is_obat,
                barcode: barcode,
                penyimpanan: sumber,
            }
        });
    }

    /* Fungsi Ajax get batch setelah barcode obat/alkes */
    function cek_batch(is_obat, prefix, sumber, barcode) {
        return $.ajax({
            url: '<?= site_url('admin/' . $class . '/get_batch'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                barcode: barcode,
                is_obat: is_obat,
                prefix: prefix,
                sumber: sumber,
            }
        });
    }

    /* Fungsi Ajax get satuan setelah barcode obat/alkes */
    // is_obat, id_items, sumber, kemasan, batch, barcode
    function get_stok_satuan(is_obat, status, id_stok, kemasan, qty) {
        return $.ajax({
            url: '<?= site_url('admin/' . $class . '/get_stok_satuan'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                is_obat : is_obat,
                id_stok : id_stok,
                status  : status,
                kemasan : kemasan,
                qty     : qty,
            }
        });
    }

    /* Fungsi Ajax sediaan tersedia pada stok barcode obat/alkes */
    function get_sisa_sediaan(id_stok, qty, kemasan) {
        return $.ajax({
            url: '<?= site_url('admin/' . $class . '/get_sisa_sediaan'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                id_stok : id_stok,
                qty     : qty,
                kemasan : kemasan
            }
        });
    }

    function render_items() {
        var id = $('input[name="id"]').val();
        if (selected_barang.length > 0) {
            var html_ = '';
            $('#list_item').html(html_);
            if (id == 0) {
                $.each(selected_barang, function(index, obj) {
                    html_ += '<tr class="text-center">';
                    html_ += '<td>' + obj.nama_barang + '</td>';
                    html_ += '<td>' + obj.kemasan + '</td>';
                    html_ += '<td>' + obj.ex_date + '</td>';
                    html_ += '<td>' + obj.batch + '</td>';
                    html_ += '<td>' + obj.qty + '</td>';
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
                    // html_ +=
                    //     '<td><button class="btn btn-danger disabled" type="button"><i class="fa fa-trash"></i></button></td>';
                    html_ += '</tr>';
                });
            }
            $('#list_item').html(html_);
            remove_items();
        } else {
            var html_ = '';
            $('#list_item').html(html_);
        }
    }

    function add_list_detail_produk(id, nama_barang, kemasan, ex_date, batch, qty, is_obat, qty_konversi) {
        var arr_length = selected_barang.length;
        var items = {};
        var select_product = selected_barang.length;

        if (select_product == 0) {
            items.id = id;
            items.qty = qty;
            items.batch = batch;
            items.is_obat = is_obat;
            items.kemasan = kemasan;
            items.ex_date = ex_date;
            items.nama_barang = nama_barang;
            items.qty_konversi = qty_konversi;

            selected_barang.push(items);

        } else {
            var same_items = false;

            for (var i = 0, select_product = selected_barang.length; i < select_product; i++) {
                if (selected_barang[i]['id'] === id && selected_barang[i]['ex_date'] === ex_date && selected_barang[i]['batch'] === batch) {
                    var remove_array = selected_barang.indexOf(selected_barang[i]);
                    selected_barang.splice(remove_array, 1);

                    items.id = id;
                    items.qty = qty;
                    items.batch = batch;
                    items.is_obat = is_obat;
                    items.kemasan = kemasan;
                    items.ex_date = ex_date;    
                    items.nama_barang = nama_barang;
                    items.qty_konversi = qty_konversi;
                    
                    selected_barang.push(items);

                    same_items = true;
                }
            }

            if (same_items == false) {
                items.id = id;
                items.qty = qty;
                items.batch = batch;
                items.is_obat = is_obat;
                items.kemasan = kemasan;
                items.ex_date = ex_date;
                items.nama_barang = nama_barang;
                items.qty_konversi = qty_konversi;

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
    }
});
</script>