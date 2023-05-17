<style>
.top-address {
    vertical-align: text-bottom;
    text-align: right;
    font-size: 10pt;
}

.middle {
    vertical-align: middle;
}

.data_html {
    font-size: 8pt;
}

.center {
    text-align: center;
}

.table-font-size {
    font-size: 10pt;
}
</style>

<?php
// echo "<pre>";

// print_r($data);
// die();
// $jenis_sp = "Psikotropik";

?>
<html>

<head>
    <title>Print Laporan</title>
</head>

<body>
    <div class="main">
        <table>
            <tr>
                <td width="15%" class="center">
                    <?php
                    $dir = 'assets/uploads/logo/' . $setting['logo'];
                    if (@file_exists($dir)) {
                    ?>
                    <img src="<?php echo $dir; ?>" style="height: 70px;" />
                    <?php
                    } else {
                        echo '<div style="font-size:18pt">Logo</div>';
                    }
                    ?>
                </td>
                <td width="85%" class="top-address" style="text-align:right;">
                    <table>
                        <tr>
                            <td></td>
                            <td class="too-address"><?= $setting['alamat']; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><?= $setting['no_telpon'] ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border-bottom: solid 1px #222; font-size:2pt;"></td>
            </tr>
        </table>

        <table>
            <!-- Jarak -->
            <tr>
                <td>
                    <br>
                </td>
            </tr>

            <tr>
                <td>
                    <table>
                        <tr>
                            <td class="center" style="font-size:12ptmargin: 205px;"><strong><?= $judul; ?></strong></td>
                        </tr>
                        <tr>
                            <td class="center" style="font-size:10pt;">Nomor SP : <?= $setting['sia']; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Jarak -->
            <tr>
                <td colspan="3">
                    <br>
                </td>
            </tr>

            <!-- Keterangan Penerima -->
            <tr>
                <td>
                    <table class="table-font-size">
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td width="80%"><strong>Yang bertanda tangan dibawah ini:</strong></td>
                                        <td width="20%" class="center"
                                            style="font-size:12pt; padding:2px 15px 2px 15px; border:solid 1px #222; text-align:center;">
                                            <strong>ASLI</strong>
                                        </td>
                                        <td></td>
                                    </tr>
                                </table>
                                <table cellpadding="1">
                                    <tr>
                                        <td width="15%">Nama</td>
                                        <td width="1%" class="center">: </td>
                                        <td width="80%" align="left"><?= $setting['apoteker'] ?></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Jabatan</td>
                                        <td width="1%" class="center">:</td>
                                        <td width="80%" align="left">Apoteker Pengelola Apotek</td>
                                    </tr>
                                    <?php
                                    if ($jenis_sp == 'Psikotropik') { ?>
                                    <tr>
                                        <td width="15%">Alamat</td>
                                        <td width="1%" class="center">:</td>
                                        <td width="40%" align="left"><?= $setting['alamat']; ?></td>
                                        <td width="444%"></td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr>
                                        <td width="15%">Nomor SIPA</td>
                                        <td width="1%" class="center">:</td>
                                        <td width="80%" align="left"><?= $setting['sipa'] ?></td>
                                    </tr>
                                    <tr>
                                        <td width="80%"><strong>Mengajukan pesanan <?= $text_pengajuan_pemesanan; ?>
                                                :</strong></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Nama Perusahaan</td>
                                        <td width="85%"> :</td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Alamat</td>
                                        <td width="85%"> :</td>
                                    </tr>
                                    <tr>
                                        <?php
                                        if ($jenis_sp != 'Psikotropik') { ?>
                                        <td width="25%">Jenis Obat yang di pesan adalah</td>
                                        <td width="75%"> :</td>
                                        <?php } else { ?>
                                        <td width="30%">Jenis Psikotropik yang di pesan adalah</td>
                                        <td width="70%"> :</td>
                                        <?php }
                                        ?>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <?php
            $html = '';
            $data_html = '';
            $no = 1;

            if ($jenis_sp != 'Generik') {
                if ($jenis_sp == 'OOT') { //Jika jenis OOT
                    $html = '
                                <th class="center" width="5%"><strong>No.</strong></th>
                                <th class="center" width="20%"><strong>Nama Obat Mengandung OOT</strong></th>
                                <th class="center" width="20%"><strong>Zat Aktif OOT</strong></th>
                                <th class="center" width="18%"><strong>Bentuk dan Kekuatan</strong></th>
                                <th class="center" width="15%"><strong>Satuan</strong></th>
                                <th class="center" width="10%"><strong>Jumlah</strong></th>
                                <th class="center" width="13%"><strong>Keterangan</strong></th>
                            ';

                    foreach ($data['detail'] as $key => $value) {
                        $nama_obat = $value['nama_barang'];
                        $jumlah = $value['qty'];
                        $satuan = $value['kemasan'];
                        $data = '
                                <tr class="data_html">
                                    <td class="center">' . $no . '</td>
                                    <td>' . $nama_obat . '</td>
                                    <td></td>
                                    <td></td>
                                    <td class="center">' . $satuan . '</td>
                                    <td class="center">' . $jumlah . '</td>
                                    <td></td>
                                </tr>
                                ';
                        $data_html .= $data;
                        $no++;
                    }
                } else if ($jenis_sp == 'Psikotropik') {  //Jika jenis Psikotropik
                    $html = '
                                <th class="center" width="5%"><strong>No.</strong></th>
                                <th class="center" width="35%"><strong>Nama Obat</strong></th>
                                <th class="center" width="25%"><strong>Kekuatan/Potensi</strong></th>
                                <th class="center" width="20%"><strong>Bentuk Sediaan</strong></th>
                                <th class="center" width="15%"><strong>Jumlah</strong></th>
                            ';

                    foreach ($data['detail'] as $key => $value) {
                        // print_r($value);
                        $nama_obat = $value['nama_barang'];
                        $jumlah = $value['qty'];
                        $satuan = $value['kemasan'];
                        $terbilang = $value['terbilang'];
                        $data = '
                                <tr class="data_html">
                                    <td class="center">' . $no . '</td>
                                    <td>' . $nama_obat . '</td>
                                    <td></td>
                                    <td class="center">' . $satuan . '</td>
                                    <td class="center">' . $jumlah . ' (' . $terbilang . ')</td>
                                </tr>
                                ';
                        $data_html .= $data;
                        $no++;
                    }
                    // die();
                } else {  //Jika jenis Prekursor
                    $html = '
                                <th class="center" width="5%"><strong>No.</strong></th>
                                <th class="center" width="20%"><strong>Nama Obat Mengandung Prekursor Farmasi</strong></th>
                                <th class="center" width="20%"><strong>Zat Aktif Prekursor Farmasi</strong></th>
                                <th class="center" width="18%"><strong>Bentuk dan Kekuatan</strong></th>
                                <th class="center" width="15%"><strong>Satuan</strong></th>
                                <th class="center" width="10%"><strong>Jumlah</strong></th>
                                <th class="center" width="13%"><strong>Keterangan</strong></th>
                            ';

                    foreach ($data['detail'] as $key => $value) {
                        $nama_obat = $value['nama_barang'];
                        $jumlah = $value['qty'];
                        $satuan = $value['kemasan'];
                        $data = '
                                <tr class="data_html">
                                    <td class="center">' . $no . '</td>
                                    <td>' . $nama_obat . '</td>
                                    <td></td>
                                    <td></td>
                                    <td class="center">' . $satuan . '</td>
                                    <td class="center">' . $jumlah . '</td>
                                    <td></td>
                                </tr>
                                ';
                        $data_html .= $data;
                        $no++;
                    }
                }
            }
            ?>

        </table>
        <table>
            <!-- Daftar produk -->
            <tr>
                <td>
                    <table border="1" cellpadding="5">
                        <tr style="font-size:8pt;background-color: #d3d3d3">
                            <?= $html; ?>
                        </tr>
                        <!-- Detai Isi Table -->
                        <?= $data_html; ?>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="table-font-size" cellpadding="2">
                        <tr>
                            <th width="65%"><strong><?= $text_tujuan_pengajuan; ?></strong></th>
                            <th width="35%">Sokaraja, </th>
                        </tr>
                        <tr>
                            <td width="15%">Nama Apotek</td>
                            <td width="2%">:</td>
                            <td width="48%"><?= $setting['nama_klinik']; ?></td>
                            <td width="35%" align="center">Pemesan,</td>
                        </tr>
                        <tr>
                            <td width="15%">Alamat Lengkap</td>
                            <td width="2%">:</td>
                            <td width="43%">
                                <?= $setting['alamat'] . '<br>Telp. ' . $setting['no_telpon']; ?></td>
                            <td width="40%"></td>
                        </tr>
                        <tr>
                            <td width="15%">Surat izin Apotek</td>
                            <td width="2%">:</td>
                            <td width="43%"><?= $setting['sia'] ?></td>
                            <td width="40%"></td>
                        </tr>
                        <tr>
                            <td width="65%"></td>
                            <td width="35%" align="center"><strong><?= $setting['apoteker'] ?></strong></td>
                        </tr>
                        <tr>
                            <td width="65%"></td>
                            <td width="35%" align="center">SIPA: <?= $setting['sipa'] ?></td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Jarak -->
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td><br></td>
            </tr>

            <!-- <tr style="font-size:8pt;">
                    <td>
                        <table class="table-font-size">
                            <tr>
                                <td align="right">Pemesan</td>
                            </tr> -->
            <!-- Jarak -->
            <!-- <tr>
                                <td>
                                    <br/>
                                    <br/>
                                    <br/>
                                    <br/>
                                </td>
                            </tr>
                            <tr>
                                <td align="right"><strong>(apt.Wahyu Utaminingrum, M.Sc.)</strong></td>
                            </tr>
                        </table>
                    </td>
                </tr> -->
        </table>

    </div>
</body>

</html>