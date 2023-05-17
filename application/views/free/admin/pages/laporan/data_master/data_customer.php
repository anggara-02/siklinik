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
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatables" class="table table-sm table-bordered text-nowrap">
                    <thead>
                        <tr class="bg-light">
                            <th class="align-middle text-center" width="5">No</th>
                            <th class="align-middle text-center" width="200">Nama Lengkap</th>
                            <th class="align-middle text-center" width="100">Email</th>
                            <th class="align-middle text-center" width="">Alamat</th>
                            <th class="align-middle text-center" width="50">No HP</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        dataReload();
    });

    $('#export').click(function(e) {
        location.href = "<?php echo site_url('admin/laporan/data_master/' . $class . '/export') ?>";
    })

    function dataReload(){
        $('#datatables').DataTable({
        processing: true,
        serverSide: true,   
        searching: false,
        // dom: ' Bt<"table-footer clearfix"<"DT-label"i><"DT-pagination"p>>', 				
        aoColumnDefs: [{ "bSortable": false, "aTargets": [ "_all" ],"orderable": false }],
        lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        'ajax': {
            url: '<?= base_url('admin/laporan/data_master/'.$class.'/get_datatable');?>',
            type: 'post',
            dataType: 'json',
        },
        'columns':[
            {data: "no", visible: true}, 
            {data: "nama", visible: true},
            {data: "email", visible: true},
            {data: "alamat", visible: true},
            {data: "nomor_telpon", visible: true},
        ],
        });
        
        setTimeout(function(){ $("#datatables th").removeClass("sorting_asc");}, 1000);
    }
</script>