<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="section-body">
    <div class="card">
		<?php if ($this->session->flashdata('status')) {$sukses = $this->session->flashdata('sukses'); $gagal = $this->session->flashdata('gagal');?>
			<div class="col-sm-12 control-label action_message" id="action_message"> 
				<div class="callout mb-1 <?= ($this->session->flashdata('status')=='200')?'callout-success':'callout-danger'; ?>">
					<div style="text-align:left;" class="message"><?= $sukses ? $sukses : $gagal; ?></div>
				</div>
			</div>
		<?php } ?>
        <div class="section-body">
            <div class="card">
                <div class="p-4 border-bottom border-light">
                    <div class="row mx-n2">
                        <div class="col-md-auto mb-3 mb-md-0 px-2">
                            <a href="<?= site_url('admin/' . $class . '/add'); ?>" class="btn btn-primary">Tambah</a>
                            <!-- <a href="<?= site_url('admin/' . $class . '/get_datatables'); ?>" class="btn btn-primary">Tambah</a> -->
                        </div>
                        <div class="col-md-auto px-2 ml-auto">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="date" class="form-control tooltips" id="tanggal_awal"
                                        title="Tanggal Awal">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" class="form-control tooltips" id="tanggal_akhir"
                                        title="Tanggal Akhir">
                                </div>
                                <div class="col-md-3">
                                    <select name="" id="supplier" class="form-select2 select2-hidden-accessible"
                                        data-placeholder="Pilih Supplier" data-select2-id="select2-data-1-izj7"
                                        tabindex="-1" aria-hidden="true">
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
                                <div class="col-md-3 input-group">
                                    <input type="text" class="form-control" id="keyword" placeholder="Search No SP..">
                                    <div class="input-group-append">
                                        <button onclick="return load_table();" class="btn btn-primary"><i
                                                class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatables" class="table table-sm table-bordered text-nowrap" style="width: 100%">
                            <thead>
                                <tr class="bg-light">
                                    <th class="align-middle text-center">No.</th>
                                    <th class="align-middle text-center">Aksi</th>
                                    <th class="align-middle text-center">No SP</th>
                                    <th class="align-middle text-center">Jenis SP</th>
                                    <th class="align-middle text-center">Tanggal SP</th>
                                    <th class="align-middle text-center">Supplier</th>
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
</div>
<script>
$(document).ready(function() {
    $('.form-select2').select2();
    load_table();
    setTimeout(function() {
        $('.action_message').hide();
        $('.action_message').find('.message').html('');
    }, 2000);


});

function checkDateRange(start, end) {
    // Parse the entries
    var startDate = Date.parse(start);
    var endDate = Date.parse(end);

    // Check the date range, 86400000 is the number of milliseconds in one day
    var difference = (endDate - startDate) / (86400000 * 7);
    if (difference < 0) {
        alert("Tanggal Mulai harus lebih kecil dari tanggal selesai.");
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
    var supplier_id = $("#supplier").val();
    var no_sp = $("#keyword").val();

    if (checkDateRange(tanggal_awal, tanggal_akhir) != false) {
        var link_service = '?no_sp=' + no_sp + '&tanggal_awal=' + tanggal_awal + '&tanggal_akhir=' + tanggal_akhir + '&supplier=' + supplier_id;
        dataReload(link_service);
    } else{
        var link_service = '?no_sp=' + no_sp + '&supplier=' + supplier_id;
        dataReload(link_service);
    }
}

function dataReload(link_service) {
    $('#datatables').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        "scrollX": true,
        aoColumnDefs: [{
            "bSortable": true,
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
            {data: "no", "width": "20px", visible: true },
            {data: "action", "width": "50px", visible: true },
            {data: "no_sp", visible: true },
            {data: "jenis_sp", visible: true },
            {data: "tanggal", visible: true },
            {data: "supplier", visible: true },
            {data: "item", "width": "300px", visible: true },
            {data: "kemasan", visible: true },
            {data: "jumlah", visible: true },
        ],
    });
    setTimeout(function() {
        $("#datatables th").removeClass("sorting_asc");
    }, 1000);
}
</script>