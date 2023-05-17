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

    /* 
thead {
    width: calc(100% - 1em)
} */

    table {
        width: 400px;
    }

    #items_error {
        color: red;
    }
</style>
<div class="section-body">
    <!-- <div class="row">
        <div class="col-md-12"> -->
    <div class="card">
        <div class="card-header">
            <h4>Form Entry</h4>
        </div>
        <div class="card-body">
            <form class="form-horizontal" id="FormData" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="pemesanan_id" value="<?= $pemesanan_id ?>">
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No SP</label>
                    <div class="col-sm-12 col-md-7 no_SP-field">
                        <input id="no_SP" name="no_SP" type="text" class="form-control">
                        <div class="invalid-feedback">
                            Masukkan Nomor SP
                        </div>
                        <label id="no_sp-error" class="error" for="no_SP" style="display: none;"></label>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis SP</label>
                    <div class="col-sm-12 col-md-7 jenis_SP-field">
                        <select name="jenis_SP" class="form-control form-select2" id="jenis_SP" style="width: 100%;" data-placeholder="Pilih Jenis SP">
                            <option value=""></option>
                            <option value="Generik">Generik</option>
                            <option value="Prekursor">Prekursor</option>
                            <option value="OOT">OOT</option>
                            <option value="Psikotropik">Psikotropik</option>
                            <option value="Narkotik">Narkotik</option>
                        </select>
                        <label id="jenis_SP-error" class="error" for="jenis_SP" style="display: none;"></label>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal SP</label>
                    <div class="col-sm-12 col-md-7 tanggal-field">
                        <input id="tanggal" name="tanggal" type="date" class="form-control">
                        <div class=" invalid-feedback">
                            Masukkan Tanggal SP
                        </div>
                        <!-- <label id="tanggal-error" class="error" for="no_SP" style="display: none;"></label> -->
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Supplier</label>
                    <div class="col-sm-12 col-md-7 supplier-field">
                        <select name="supplier" id="supplier" class="form-control form-select2" style="width: 100%;" data-placeholder="Pilih Supplier">
                            <?php
                            if (isset($supplier_arr) && !empty($supplier_arr)) {
                                echo '<option value=""></option>';
                                foreach ($supplier_arr as $row) {
                                    echo '<option value="' . $row['supplier_id'] . '">' . $row['supplier_name'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <label id="supplier-error" class="error" for="supplier" style="display: none;"></label>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Obat &amp;
                        Alkes</label>
                    <div class="col-sm-12 col-md-7">
                        <div class="form-clone-wrap">
                            <div class="form-group row mb-3 mx-n1 form-original">
                                <div class="col-md-5 px-1 items-field">
                                    <input id="items" class="form-control" placeholder="Barcode atau Nama Obat/Alkes">
                                    <input id="id_items" class="form-control" placeholder="Id Items" hidden>
                                    <p id="items_error" class="label" style="display: none;">Barcode tidak ditemukan</p>
                                </div>
                                <div class="col-md-3 px-1">
                                    <select id="kemasan" class="form-control form-select2" name="kemasan_id" data-placeholder="Pilih Kemasan" disabled>
                                        <option value=""></option>
                                    </select>
                                    <input type="hidden" name="kemasan_alkes" value="">
                                    <input type="hidden" name="is_obat" value="">
                                    <div class="invalid-feedback d-none feedback-kemasan">
                                        Kemasan harus di isi
                                    </div>
                                </div>
                                <div class="col-md-2 px-1">
                                    <input id="qty" type="number" class="form-input form-control" placeholder="Qty" min="1">
                                    <div class="invalid-feedback d-none feedback-qty">
                                        Qty tidak boleh kosong atau 0
                                    </div>
                                </div>
                                <div class="col-md-1 px-1">
                                    <div>
                                        <button id="add_newitem" class="btn btn-info btn-clone" type="button"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-product table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Obat &amp; Alkes</th>
                                        <th>Kemasan</th>
                                        <th>Qty</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="list_item" scrollbars="yes">
                                    <!-- Multiple Data In Here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                    <div class="col-sm-12 col-md-7">
                        <button class="btn btn-primary" type="button" id="save">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- </div>
    </div> -->
</div>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    $(function() {
        $('.form-select2').select2();
    });

    $(document).ready(function() {
        let x = 0
        let qty = 0
        let selected_barang = [];
        let id_item = '';
        var is_autocomplete = 0;
        var pemesanan_id = $('input[name="pemesanan_id"]').val();

        if (pemesanan_id != 0) {
            // $('#no_SP').prop('disabled', true);
            $.ajax({
                url: '<?= site_url('admin/' . $class . '/trx_edit'); ?>',
                type: 'GET',
                dataType: 'json',
                data: {
                    pemesanan_id: pemesanan_id
                },
                success: function(response) {
                    let detail = response.data[0].detail;
                    let data_edit = response.data;
                    detail.forEach(function(item) {
                        selected_barang.push(item);
                    });

                    data_edit.forEach(function(items) {
                        $('#FormData').find('[name="no_SP"]').val(items.no_sp);
                        $('#FormData').find('[name="tanggal"]').val(items.tanggal);
                        $('#jenis_SP').val(items.jenis_sp);
                        $("#jenis_SP").select2().trigger('change');
                        $("#supplier").val(items
                            .supplier);
                        $("#supplier").select2().trigger('change');
                    });
                    render_items();
                }
            });
        }



        /* ====================== Call Function ====================== */
        core_form();
        validator_form();

        /* ====================== Make Function ====================== */

        function validator_form() {
            $.validator.setDefaults({
                ignore: ":hidden:not('select')" // validate all hidden select elements
            });

            var validator = $('#FormData').validate({
                rules: {
                    no_SP: {
                        required: function(element) {
                            return $('.no_SP-field').addClass('is-invalid');
                        },
                        remote: {
                            url: "<?= site_url('admin/' . $class . '/action_validation'); ?>",
                            type: "POST",
                            data: {
                                no_SP: function() {
                                    return $("#no_SP").val();
                                },
                                pemesanan_id: function() {
                                    return $('input[name=pemesanan_id]').val();
                                }
                            }
                        }
                    },
                    jenis_SP: {
                        required: function(element) {
                            return $('.jenis_SP-field').addClass('is-invalid');
                        }
                    },
                    tanggal: {
                        required: function(element) {
                            return $('.tanggal-field').addClass('is-invalid');
                        }
                    },
                    supplier: {
                        required: function(element) {
                            return $('.supplier-field').addClass('is-invalid');
                        }
                    },
                },
                messages: {
                    no_SP: {
                        remote: "No SP sudah di gunakan"
                    },
                }
            });
        }

        function core_form() {
            $('#no_SP').focus();

            let cacheItem = {};
            var is_obat = '';
            var barcode = '';
            var id = '';

            /* ====================== Input Dinamis Here ====================== */
            $("#items").autocomplete({
                minLength: 1,
                source: function(request, response) {
                    let term = request.term;
                    if (term in cacheItem) {
                        response(cacheItem[term]);
                        return;
                    }
                    $.getJSON("<?= site_url('admin/' . $class . '/get_obat'); ?>", request, function(
                        data, status, xhr) {
                        cacheItem[term] = data;
                        response(data);
                    });
                },
                select: function(event, obj) {
                    is_obat = obj.item.is_obat;
                    id_item = obj.item.id;
                    barcode = obj.item.barcode;
                    is_autocomplete = 1;

                    if (is_obat != 0) {
                        $('input[name="is_obat"]').val(1);
                        // if (is_autocomplete == 1) {
                        $('#kemasan').prop('disabled', false);
                        $('#kemasan').empty();
                        $('#kemasan').focus();
                        cek_kemasan(is_obat, id_item).success(function(res) {
                            $('#kemasan').select2({
                                data: res,
                            });
                            $('#kemasan').select2(res).select2('open');
                            $('#id_items').val(id_item);
                            $('#qty').focus();
                        });
                        if ($('#items').val() == '') {
                            $('#kemasan').empty();
                            $('#kemasan').prop('disabled', true);
                        }
                        $("#items").removeClass("is-invalid");
                        $('#items_error').hide();
                        return false;
                        // }
                    } else {
                        $('input[name="is_obat"]').val(0);
                        $('#id_items').val(id_item);
                        cek_kemasan(is_obat, id_item).success(function(res) {
                            res.forEach(el => {
                                $('input[name="kemasan_alkes"]').val(el.text);
                            });
                        });
                        $('#qty').focus();
                    }
                },
                focus: function(event, obj) {
                    $('#items').val(obj.item.value);
                },
            });

            $('#kemasan').on("select2:select", function(e) {
                e.preventDefault();
                $('#kemasan').select2('close');
                $('#qty').focus();
            });

            $('#qty').keydown(function(e) {
                if (e.keyCode == 13) {
                    // if (is_autocomplete == 0) {
                    is_obat = $('input[name="is_obat"]').val()
                    id = $('#id_items').val();
                    let nama_barang = $('#items').val();
                    let kemasan;
                    if ($('input[name="is_obat"]').val() == 1) {
                        kemasan = $('#kemasan :selected').text();
                    } else {
                        kemasan = $('input[name="kemasan_alkes"]').val();
                    }

                    let qty = $('#qty').val();

                    if (qty == 0 || '') {
                        qty = 1;
                    }

                    add_items(id, nama_barang, kemasan, qty, is_obat, barcode);
                    $('#items').focus();
                    // }
                }
                $('#items').data().autocomplete.term = null;
            })

            $("#items").keydown(function(e) {
                if (e.keyCode == 13) {
                    if ($(this).val() != '' && is_autocomplete == 0) {
                        $.ajax({
                            type: 'GET',
                            url: '<?= site_url() . 'admin/' . $class . '/get_product_by_barcode' ?>',
                            data: {
                                barcode: $(this).val()
                            },
                            dataType: "json",
                            success: function(data) {
                                barcode = data.barcode;
                                id = data.id;
                                if (data.status != false) {
                                    if (data.is_obat != 0) {
                                        $('input[name="is_obat"]').val(1);
                                        $('#kemasan').prop('disabled', false);
                                        $('#kemasan').focus();
                                        $('#kemasan').empty();
                                        cek_kemasan(data.is_obat, data.id).success(function(
                                            res) {
                                            $('#kemasan').select2({
                                                data: res,
                                            });
                                            $('#kemasan').select2(res).select2('open');
                                            $('#qty').focus();
                                        });
                                        $("#id_items").val(data.id);
                                        $("#items").val(data.value);
                                        $("#items").removeClass("is-invalid");
                                        $('#items_error').hide();
                                    } else {
                                        $('input[name="is_obat"]').val(0);
                                        $("#id_items").val(data.id);
                                        // $('#id_items').val(id_item);
                                        cek_kemasan(data.is_obat, data.id).success(function(
                                            res) {
                                            res.forEach(el => {
                                                $('input[name="kemasan_alkes"]')
                                                    .val(el.text);
                                            });
                                        });
                                        $("#items").val(data.value);
                                        $('#qty').focus();
                                    }
                                    $('#items').blur();
                                    $("#items").removeClass("is-invalid");
                                    $('#items_error').hide();
                                } else {
                                    $('#items').blur();
                                    $("#items").addClass("is-invalid");
                                    $('#items_error').show();
                                    $('#items').val('');
                                    $('#items').focus();
                                    $('#kemasan').prop('disabled', true);
                                }
                            }
                        });
                    }
                }
                $('#items').data().autocomplete.term = null;
            });

            $('#add_newitem').click(function(e) {
                e.preventDefault();
                is_obat = $('input[name="is_obat"]').val()
                id = $('#id_items').val();
                let nama_barang = $('#items').val();
                let kemasan;
                if ($('input[name="is_obat"]').val() == 1) {
                    kemasan = $('#kemasan :selected').text();
                } else {
                    kemasan = $('input[name="kemasan_alkes"]').val();
                }
                let qty = $('#qty').val();
                add_items(id, nama_barang, kemasan, qty, is_obat, barcode)
            });

            $('#items').focusout(function(e) {
                if ($('#items').val() == '' || null) {
                    $('#kemasan').empty();
                    $('#kemasan').prop('disabled', true);
                }
            });

            $('#save').click(function(e) {
                let data = {};
                if (pemesanan_id != 0) {
                    data = {
                        pemesanan_id: pemesanan_id,
                        no_sp: $('#no_SP').val(),
                        jenis_sp: $('#jenis_SP :selected').text(),
                        tanggal: $('#tanggal').val(),
                        supplier: $('#supplier :selected').val(),
                        detail_barang: selected_barang
                    };
                } else {
                    data = {
                        pemesanan_id: 'save',
                        no_sp: $('#no_SP').val(),
                        jenis_sp: $('#jenis_SP :selected').text(),
                        tanggal: $('#tanggal').val(),
                        supplier: $('#supplier :selected').val(),
                        detail_barang: selected_barang
                    };
                }

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

            // $('#add_newitem').click(function(e) {
            //     e.preventDefault();
            //     let id = $('#id_items').val();
            //     let nama_barang = $('#items').val();
            //     let kemasan = $('#kemasan :selected').text();
            //     let qty = $('#qty').val();

            //     if (selected_barang.length > 10) {
            //         $('#list_item').addClass("add-scroll");
            //     }

            //     if ($('#qty').val() == 0 || '') {
            //         qty = 1;
            //     }

            //     if (nama_barang != '') {
            //         add_list_detail_produk(id, nama_barang, kemasan, qty, is_obat, barcode);
            //         $('#items').val('');
            //         $('#kemasan').empty();
            //         $('#kemasan').prop('disabled', true);
            //         $('#qty').val('');
            //     } else {
            //         $('#items').focus();
            //     }
            //     console.log(selected_barang);
            // });
        }

        function add_items(id, nama_barang, kemasan, qty, is_obat, barcode) {
            is_autocomplete = 0;
            if (selected_barang.length > 10) {
                $('#list_item').addClass("add-scroll");
            }

            if ($('#qty').val() == 0 || '') {
                qty = 1;
            }

            if (nama_barang != '') {
                add_list_detail_produk(id, nama_barang, kemasan, qty, is_obat, barcode);
                $('#items').val('');
                $('#kemasan').empty();
                $('#kemasan').prop('disabled', true);
                $('#qty').val('');
            } else {
                $('#items').focus();
            }
        }

        /* Fungsi Ajax get kemasan setelah barcode obat/alkes */
        function cek_kemasan(is_obat, id_item) {
            return $.ajax({
                url: '<?= site_url('admin/' . $class . '/get_kemasan'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    is_obat: is_obat,
                    id_item: id_item,
                }
            });
        }

        function render_items() {
            console.log(selected_barang);
            if (selected_barang.length > 0) {
                var html_ = '';
                $('#list_item').html('');

                $.each(selected_barang, function(index, obj) {
                    // console.log(obj);
                    html_ += '<tr>';
                    html_ += '<td>' + obj.nama_barang + '</td>';
                    html_ += '<td>' + obj.kemasan + '</td>';
                    html_ += '<td>' + obj.qty + '</td>';
                    html_ +=
                        '<td><button class="btn btn-danger btn_remove" type="button" data-index="' +
                        index + '"><i class="fa fa-trash"></i></button></td>';
                    html_ += '</tr>';
                });
                $('#list_item').html(html_);
                remove_items();
            } else {
                var html_ = '';
                $('#list_item').html('');
            }
        }

        function add_list_detail_produk(id, nama_barang, kemasan, qty, is_obat, barcode) {
            is_autocomplete == 0;
            var arr_length = selected_barang.length;
            var items = {};
            var select_product = selected_barang.length;

            if (select_product == 0) {

                items.id = id;
                items.barcode = barcode;
                items.nama_barang = nama_barang;
                items.kemasan = kemasan;
                items.qty = qty;
                items.is_obat = is_obat;

                selected_barang.push(items);

            } else {
                var same_items = false;

                for (var i = 0, select_product = selected_barang.length; i < select_product; i++) {
                    //Untuk Alkes


                    //Untuk Obat
                    if (selected_barang[i]['id'] === id && selected_barang[i]['kemasan'] === kemasan) {
                        selected_barang[i]['qty'] = parseInt(selected_barang[i]['qty']) + parseInt(qty);
                        same_items = true;
                    }
                }

                if (same_items == false) {
                    items.id = id;
                    items.barcode = barcode;
                    items.nama_barang = nama_barang;
                    items.kemasan = kemasan;
                    items.qty = qty;
                    items.is_obat = is_obat;

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
            $('#no_SP').empty();
            $('#jenis_SP').empty();
            $('#tanggal').empty();
            $('#supplier').empty();
        }
    });

    $(document).on('change', '#jenis_SP, #supplier', function() {
        let jenis_SP = $('#jenis_SP').val();
        let supplier = $('#supplier').val();

        if (jenis_SP) {
            $('#jenis_SP-error').hide();
        }
        if (supplier) {
            $('#supplier-error').hide();
        }
    });
</script>