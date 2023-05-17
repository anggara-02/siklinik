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
                <div class="col-md-auto mb-3 mb-md-0">
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
                            <th class="align-middle text-center" width="5">No</th>
                            <th class="align-middle text-center" width="100">Item ID</th>
                            <th class="align-middle text-center" width="100">Item Barcode</th>
                            <th class="align-middle text-center" width="100">Nama Produk</th>
                            <th class="align-middle text-center" width="100">Expired Date</th>
                            <th class="align-middle text-center" width="100">No Batch</th>
                            <th class="align-middle text-center" width="100">Stok Etalase</th>
                            <th class="align-middle text-center" width="100">Stok Gudang</th>
                            <th class="align-middle text-center" width="100">Stok Promo</th>
                            <th class="align-middle text-center" width="100">Kemasan Dasar</th>
                            <th class="align-middle text-center" width="100">HNA + PPN</th>
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
        location.href = "<?php echo site_url('admin/laporan/stok/' . $class . '/export') ?>" + link_service;
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

    function dataReload(link_service){
        $('#datatables').DataTable({
        processing: true,
        serverSide: true,   
        searching: false,
        // dom: ' Bt<"table-footer clearfix"<"DT-label"i><"DT-pagination"p>>', 				
        aoColumnDefs: [{ "bSortable": false, "aTargets": [ "_all" ],"orderable": false }],
        lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        'ajax': {
            url: '<?= base_url('admin/laporan/stok/'.$class.'/get_datatable');?>' + link_service,
            type: 'post',
            dataType: 'json',
        },
        'columns':[
            {data: "no", visible: true}, 
            {data: "id_barang", visible: true},
            {data: "barcode", visible: true},
            {data: "produk", visible: true},
            {data: "expired_date", visible: true},
            {data: "batch", visible: true},
            {data: "etalase", visible: true},
            {data: "gudang", visible: true},
            {data: "promo", visible: true},
            {data: "kemasan", visible: true},
            {data: "harga", visible: true},
        ],
        });
        
        setTimeout(function(){ $("#datatables th").removeClass("sorting_asc");}, 1000);
    }
</script>