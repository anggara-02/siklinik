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
                    <a href="#" class="btn btn-success">Export Excel</a>
                </div>
                <!-- <div class="col-md-3 ml-md-auto">
					<table class="table table-sm">
						<tr>
							<td><strong>Total</strong></td>
							<td class="text-right">26.000</td>
						</tr>
						<tr>
							<td><strong>Diskon</strong></td>
							<td class="text-right">2.000</td>
						</tr>
						<tr>
							<td><strong>Grand Total</strong></td>
							<td class="text-right">24.000</td>
						</tr>
					</table>
				</div> -->
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered text-nowrap">
                    <thead>
                        <tr class="bg-light">
                            <th class="align-middle text-center" rowspan="3" width="5">No</th>
                            <th class="align-middle text-center" rowspan="3">Hari</th>
                            <th class="align-middle" rowspan="3">Tanggal</th>
                            <th class="align-middle text-center" rowspan="3">Shift</th>
                            <th class="align-middle text-center" rowspan="3">Dokter</th>
                            <th class="align-middle text-center" rowspan="3">Perawat/Bidan</th>
                            <th class="align-middle text-center" colspan="11">Jumlah Pemeriksaan (Pasien)</th>
                            <th class="align-middle text-center" colspan="11">Jumlah Pemeriksaan (Rp)</th>
                            <th class="align-middle text-center" rowspan="3">Total</th>
                        </tr>
                        <tr>
                            <th class="align-middle text-center" colspan="3">BPJS</th>
                            <th class="align-middle text-center" colspan="2">Asuransi</th>
                            <th class="align-middle text-center" colspan="2">Umum</th>
                            <th class="align-middle text-center" rowspan="2">SKD</th>
                            <th class="align-middle text-center" colspan="3">Gratis</th>
                            <th class="align-middle text-center" colspan="3">BPJS</th>
                            <th class="align-middle text-center" colspan="2">Asuransi</th>
                            <th class="align-middle text-center" colspan="2">Umum</th>
                            <th class="align-middle text-center" rowspan="2">SKD</th>
                            <th class="align-middle text-center" colspan="3">Gratis</th>
                        </tr>
                        <tr>
                            <th class="align-middle text-center">Berobat</th>
                            <th class="align-middle text-center">Prolanis</th>
                            <th class="align-middle text-center">Rujukan</th>
                            <th class="align-middle text-center">Berobat</th>
                            <th class="align-middle text-center">Rujukan</th>
                            <th class="align-middle text-center">Berobat</th>
                            <th class="align-middle text-center">Rujukan</th>
                            <th class="align-middle text-center">Umum</th>
                            <th class="align-middle text-center">Karyawan</th>
                            <th class="align-middle text-center">Relasi/Keluarga</th>
                            <th class="align-middle text-center">Berobat</th>
                            <th class="align-middle text-center">Prolanis</th>
                            <th class="align-middle text-center">Rujukan</th>
                            <th class="align-middle text-center">Berobat</th>
                            <th class="align-middle text-center">Rujukan</th>
                            <th class="align-middle text-center">Berobat</th>
                            <th class="align-middle text-center">Rujukan</th>
                            <th class="align-middle text-center">Umum</th>
                            <th class="align-middle text-center">Karyawan</th>
                            <th class="align-middle text-center">Relasi/Keluarga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Senin</td>
                            <td>01-01-2021</td>
                            <td>Pagi</td>
                            <td>Dr Boyke</td>
                            <td>Mas Gareng</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                        </tr>
                    </tbody>
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
</script>