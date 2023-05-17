<!-- ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Modified : Badra | sipatan.jana@students.amikom.ac.id
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
==========DON'T REMOVE============ -->

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="section-body">
    <div class="card">
    <?php if ($this->session->flashdata('status')) {$sukses = $this->session->flashdata('sukses');$gagal = $this->session->flashdata('gagal'); ?>
            <div class="col-sm-12 control-label action_message" id="action_message">
                <div class="callout mb-1 <?= ($this->session->flashdata('status') == '200') ? 'callout-success' : 'callout-danger'; ?>">
                    <div style="text-align:left;" class="message"><?= $sukses ? $sukses : $gagal; ?></div>
                </div>
            </div>
        <?php } ?>
        <div class="section-body">
            <div class="card">
                <div class="p-4 border-bottom border-light">
                    <div class="row mx-n2">
                        <div class="col-md-auto mb-3 mb-md-0 px-2">
                            <a href="<?= site_url('admin/'.$class.'/add');?>" class="btn btn-primary add"
                                shortcut="f2">Tambah</a>
                        </div>
                        <div class="col-md-auto px-2 ml-auto">
                            <div class="row">
                                <div class="col-md-3 search">
                                    <input type="date" class="form-control tooltips" id="tanggal_awal"
                                        title="Tanggal Awal">
                                </div>
                                <div class="col-md-3 search">
                                    <input type="date" class="form-control tooltips" id="tanggal_akhir"
                                        title="Tanggal Akhir">
                                </div>
                                <div class="col-md-3 search">
                                <select name="" id="supplier_id" class="form-select2 select2-hidden-accessible" data-placeholder="Pilih Supplier" data-select2-id="select2-data-1-izj7" tabindex="-1" aria-hidden="true">
                                        <?php
                                        if (isset($supplier_arr) && !empty($supplier_arr)) {
                                            echo '<option value=""</option>';
                                            foreach ($supplier_arr as $row) {
                                                echo '<option value="' . $row['supplier_id'] . '">' . $row['supplier_name'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3 input-group search">
                                    <input type="text" id="keyword" autocomplete="off" name="keyword"
                                        class="form-control input-sm" placeholder="Search No Faktur" size="20">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" shortcut="ctrl+enter"
                                            onclick="load_table();return false;"><i class="fa fa-search"></i></button>
                                    </div>
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
                    <table id="datatables" class="table table-sm table-bordered text-nowrap" style="width: 100%">
                        <thead>
                            <tr class="bg-light">
                                <th class="align-middle text-center">No.</th>
                                <th class="align-middle text-center">Aksi</th>
                                <th class="align-middle text-center">No Faktur</th>
                                <th class="align-middle text-center">Tanggal Faktur</th>
                                <th class="align-middle text-center">Tanggal Retur</th>
                                <th class="align-middle text-center">Supplier</th>
                                <th class="align-middle text-center">Total Harga</th>
                                <th class="align-middle text-center">Nama Item</th>
                                <th class="align-middle text-center">Kemasan</th>
                                <th class="align-middle text-center">Jumlah</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.search {
    padding: 0 5px;
}
</style>
<script>
$(function() {
    $('.form-select2').select2();
});

function custom_message(status, message) {
    $('.custom_message').show();
    if (status != 200) {
        $('.custom_message').find('.callout').addClass('callout-danger');
        $('.custom_message').find('.callout').removeClass('callout-success');
    } else {
        $('.custom_message').find('.callout').addClass('callout-success');
        $('.custom_message').find('.callout').removeClass('callout-danger');
    }
    $('.custom_message').find('.message').html(message);
    $(this).scrollTop(0);
    setTimeout(function() {
        $('.custom_message').hide();
    }, 5000);
}

$(document).ready(function() {
    load_table();
    setTimeout(function() {
        $('.action_message').hide();
        $('.action_message').find('.message').html('');
    }, 2000);
});

/* konfirmasi validasi sebelum delete baris */
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
            } else {
                return false;
            }

        });
}

/* fitur aktif/nonaktifkan user */
function trx_aktif(status, user_id) {
    text_status = (status == '1') ? 'mengaktifkan' : 'menonaktifkan';
    swal({
            title: 'Apakah anda yakin?',
            text: 'Anda akan ' + text_status + ' user ini',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
        .then((confirm) => {
            if (confirm) {
                $.ajax({
                    url: '<?= site_url('admin/'.$class.'/action_is_active');?>',
                    type: 'POST',
                    dataType: 'json',
                    data: 'user_id=' + user_id + '&is_active=' + status,
                    success: function(response) {
                        custom_message(response['status'], response['message']);
                        reset_trx();
                    },
                    error: function() {
                        alert('terjadi kesalahan saat validasi');
                        $('.modal-footer').show();
                        $('.button').show();
                        $('.btn').prop('disabled', false);
                    }
                });
            }
        });
}

function checkDateRange(start, end) {
    // Parse the entries
    var startDate = Date.parse(start);
    var endDate = Date.parse(end);

    // Check the date range, 86400000 is the number of milliseconds in one day
    var difference = (endDate - startDate) / (86400000 * 7);
    if (difference < 0) {
        alert("Tanggal Mmulai harus lebih kecil dari tanggal selesai.");
        return false;
    }
    return true;
}

function load_table() {
    if ($('#datatables thead>tr').length > 0) {
        $('#datatables').dataTable().fnDestroy();
    }

    var tanggal_awal = $("#tanggal_awal").val();
    var tanggal_akhir = $("#tanggal_akhir").val();
    var supplier_id = $("#supplier_id").val();
    var no_faktur = $("#keyword").val();

    if (checkDateRange(tanggal_awal, tanggal_akhir) != false) {
        var link_service = '?no_faktur=' + no_faktur + '&tanggal_awal=' + tanggal_awal + '&tanggal_akhir=' + tanggal_akhir +
        '&supplier_id=' + supplier_id;
        dataReload(link_service);
    }else{
        var link_service = '?no_faktur=' + no_faktur + '&supplier_id=' + supplier_id;
        dataReload(link_service);
    }
}

function dataReload(link_service) {
    $('#datatables').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        aoColumnDefs: [{
            "bSortable": false,
            "aTargets": ["_all"],
            "orderable": false
        }],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        'ajax': {
            url: '<?= base_url('admin/'.$class.'/get_datatable');?>' + link_service,
            type: 'post',
            dataType: 'json',
        },
        'columns': [
            {data: "no", "width": "20px", visible: true},
            {data: "action", "width": "100px", visible: true },
            {data: "no_faktur", visible: true },
            {data: "tanggal_faktur", visible: true },
            {data: "tanggal_tempo", visible: true },
            {data: "supplier", visible: true },
            {data: "total", visible: true },
            {data: "item", visible: true },
            {data: "kemasan", visible: true },
            {data: "jumlah", visible: true },
        ],
    });
    setTimeout(function() {
        $("#datatables th").removeClass("sorting_asc");
    }, 1000);

    $("#tanggal_awal").val('');
    $("#tanggal_akhir").val('');
    $("#supplier_id").val('');
    $('#supplier_id').select2().trigger('change');
    $("#keyword").val('');
}
</script>
<!-- ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Modified : Badra | sipatan.jana@students.amikom.ac.id
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
==========DON'T REMOVE============ -->