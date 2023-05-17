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
        <div class="px-4 pt-4 pb-0">
            <div class="row">
                <div class="col-md-auto align-self-end">
                    <a href="#" class="btn btn-success" id="export">Export Excel</a>
                </div>
                <div class="col-md-auto px-4 ml-auto">
                    <div class="row">
                        <div class="search">
                            <input type="date" class="form-control tooltips" value="<?php echo ($this->input->get('start_date'))?$this->input->get('start_date'):''?>" id="tanggal_awal" title="Tanggal Awal">
                        </div>
                        <div class="search">
                            <input type="date" class="form-control tooltips" value="<?php echo $this->input->get('end_date')?$this->input->get('end_date'):''?>" id="tanggal_akhir" title="Tanggal Akhir">
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-primary" shortcut="ctrl+enter" onclick="load_table();return false;"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatables" class="table table-sm table-bordered text-nowrap">
                    <thead>
                        <tr class="bg-light">
                            <th class="align-middle text-center" width="20">No.</th>
                            <th class="align-middle text-center">Item ID</th>
                            <th class="align-middle text-center">Item Barcode</th>
                            <th class="align-middle text-center">Nama Produk</th>
                            <th class="align-middle text-center">Stok</th>
                            <th class="align-middle text-center">Kemasan Dasar</th>
                            <th class="align-middle text-center">Isi</th>
                            <th class="align-middle text-center">Kemasan Sedang</th>
                            <th class="align-middle text-center">Isi</th>
                            <th class="align-middle text-center">Kemasan Besar</th>
                            <th class="align-middle text-center">Isi</th>
                            <th class="align-middle text-center">Harga Modal</th>
                            <th class="align-middle text-center">Margin Resep</th>
                            <th class="align-middle text-center">Harga Jual Resep</th>
                            <th class="align-middle text-center">Margin Non Resep</th>
                            <th class="align-middle text-center">Harga Jual Non Resep</th>
                            <th class="align-middle text-center">Jesni Obat</th>
                            <th class="align-middle text-center">Status</th>
                            <th class="align-middle text-center">Inputer</th>
                            <th class="align-middle text-center">Tanggal Update</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        load_table();
    });
    
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

    $('#export').click(function(e) {
        var tanggal_awal = $("#tanggal_awal").val();
        var tanggal_akhir = $("#tanggal_akhir").val();
        if (checkDateRange(tanggal_awal, tanggal_akhir) != false) {
            var link_service = '?tanggal_awal=' + tanggal_awal + '&tanggal_akhir=' + tanggal_akhir;
        } else {
            var link_service = '';
        }
        location.href = "<?php echo site_url('admin/laporan/data_master/' . $class . '/export') ?>" + link_service;
    });

    function load_table() {
        if ($('#datatables thead>tr').length > 0) {
            $('#datatables').dataTable().fnDestroy();
        }

        var tanggal_awal = $("#tanggal_awal").val();
        var tanggal_akhir = $("#tanggal_akhir").val();
        if (checkDateRange(tanggal_awal, tanggal_akhir) != false) {
            var link_service = '?tanggal_awal=' + tanggal_awal + '&tanggal_akhir=' + tanggal_akhir;
        } else {
            var link_service = '';
        }
        dataReload(link_service);
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
                url: '<?= base_url('admin/laporan/data_master/' . $class . '/get_datatable'); ?>' + link_service,
                type: 'POST',
                dataType: 'JSON',
            },
            'columns': [
                {data: "no","width": "80px",visible: true},
                {data: "item_id","width": "200px",visible: true},
                {data: "item_barcode",visible: true},
                {data: "produk_name",visible: true},
                {data: "stok",visible: true},
                {data: "kemasan_dasar",visible: true},
                {data: "isi_dasar",visible: true},
                {data: "kemasan_sedang",visible: true},
                {data: "isi_sedang",visible: true},
                {data: "kemasan_besar",visible: true},
                {data: "isi_besar",visible: true},
                {data: "harga_modal",visible: true},
                {data: "margin_resep",visible: true},
                {data: "harga_jual_resep",visible: true},
                {data: "margin_non_resep",visible: true},
                {data: "harga_jual_non_resep",visible: true},
                {data: "jenis_obat",visible: true},
                {data: "status",visible: true},
                {data: "inputer",visible: true},
                {data: "tanggal_update",visible: true},
            ],
        });
        setTimeout(function() {
            $("#datatables th").removeClass("sorting_asc");
        }, 1000);
    }
</script>