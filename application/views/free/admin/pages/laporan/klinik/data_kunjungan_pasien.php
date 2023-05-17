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
        <?php if (trim($status) != '' & $message != '') { ?>
            <div class="col-sm-12 control-label action_message" id="action_message">
                <div class="callout mb-1 <?= ($status == 200) ? 'callout-success' : 'callout-danger'; ?>">
                    <div style="text-align:left;" class="message"><?= $message; ?></div>
                </div>
            </div>
        <?php } ?>
        <div class="px-4 pt-4 pb-0">
            <div class="row">
                <div class="col-md-auto align-self-end">
                    <a href="#" class="btn btn-success" id="export">Export Excel</a>
                </div>
                <div class="col-md-auto px-4 ml-auto">
                    <div class="row">
                        <div class="search pr-2">
                            <input type="date" class="form-control tooltips" value="<?php echo ($this->input->get('start_date')) ? $this->input->get('start_date') : '' ?>" id="tanggal_awal" title="Tanggal Awal">
                        </div>
                        <div class="search pr-2">
                            <input type="date" class="form-control tooltips" value="<?php echo $this->input->get('end_date') ? $this->input->get('end_date') : '' ?>" id="tanggal_akhir" title="Tanggal Akhir">
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
                <table id="datatables" class="table table-sm table-bordered text-nowrap" style="width: 100%">
                    <thead>
                        <tr class="bg-light">
                            <th class="align-middle text-center">No</th>
                            <th class="align-middle text-center">Tanggal</th>
                            <th class="align-middle text-center">Shift</th>
                            <th class="align-middle text-center">No RM</th>
                            <th class="align-middle text-center">Nama</th>
                            <th class="align-middle text-center">Tgl Lahir</th>
                            <th class="align-middle text-center">Alamat</th>
                            <th class="align-middle text-center">No Telp</th>
                            <th class="align-middle text-center">Penjamin</th>
                            <th class="align-middle text-center">Diagnosis</th>
                            <th class="align-middle text-center">Pemeriksaan Medis</th>
                            <th class="align-middle text-center">Pemeriksaan Laborat</th>
                            <th class="align-middle text-center">Resep Obat/Terapi</th>
                        </tr>
                    </thead>
                    <!-- <tbody>
                        <tr>
                            <td>1</td>
                            <td>01-01-2021</td>
                            <td>Pagi</td>
                            <td>AH000001</td>
                            <td>Doni Salmanan</td>
                            <td>01-01-1999</td>
                            <td>Jalan Kusumanegara Yogyakarta</td>
                            <td>08123456789</td>
                            <td>Rico Kyle</td>
                            <td>
                                <ul>
                                    <li>Diagnosis A</li>
                                    <li>Diagnosis B</li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li>Pemeriksaan Medis A</li>
                                    <li>Pemeriksaan Medis B</li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li>Pemeriksaan Laborat A</li>
                                    <li>Pemeriksaan Laborat B</li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li>Obat A</li>
                                    <li>Obat B</li>
                                </ul>
                            </td>
                        </tr>
                    </tbody> -->
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('.action_message').hide();
            $('.action_message').find('.message').html('');
        }, 2000);
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
            // dom: ' Bt<"table-footer clearfix"<"DT-label"i><"DT-pagination"p>>', 				
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
                url: '<?= base_url('admin/laporan/klinik/' . $class . '/get_datatable'); ?>' + link_service,
                type: 'post',
                dataType: 'json',
            },
            'columns': [{
                    data: "no",
                    visible: true
                },
                {
                    data: "tanggal",
                    visible: true
                },
                {
                    data: "shift",
                    visible: true
                },
                {
                    data: "no_rm",
                    visible: true
                },
                {
                    data: "nama",
                    visible: true
                },
                {
                    data: "tanggal_lahir",
                    visible: true
                },
                {
                    data: "alamat",
                    visible: true
                },
                {
                    data: "no_telepon",
                    visible: true
                },
                {
                    data: "penjamin",
                    visible: true
                },
                {
                    data: "diagnosis",
                    visible: true
                },
                {
                    data: "pemeriksaan_medis",
                    visible: true
                },
                {
                    data: "pemeriksaan_laborat",
                    visible: true
                },
                {
                    data: "resep_obat",
                    visible: true
                },
            ],
        });

        setTimeout(function() {
            $("#datatables th").removeClass("sorting_asc");
        }, 1000);
    }

    $('#export').click(function(e) {
        var tanggal_awal = $("#tanggal_awal").val();
        var tanggal_akhir = $("#tanggal_akhir").val();
        if (checkDateRange(tanggal_awal, tanggal_akhir) != false) {
            var link_service = '?tanggal_awal=' + tanggal_awal + '&tanggal_akhir=' + tanggal_akhir;
        } else {
            var link_service = '';
        }
        location.href = "<?php echo site_url('admin/laporan/klinik/' . $class . '/export') ?>" + link_service;
    });
</script>