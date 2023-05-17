<style>
.top-address {
    vertical-align: text-bottom;
    text-align: right;
    font-size: 10pt;
}

.table-font-size {
    font-size: 10pt;
}
</style>

<?php
//     echo "<pre>";
//     print_r($data);
//     die();
?>
<html>

<head>
    <title>Print Laporan</title>
</head>

<body>
    <table width="100%">
        <tr>
            <td width="15%" style="text-align:center;">
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
                <table width=" 100%" wrap>
                    <tr>
                        <td></td>
                        <td class="top-address"><?= $setting['alamat'] ?></td>
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
                        <td>
                            <table>
                                <tr>
                                    <td width="65%" style="font-size:10pt;text-align: left;"></td>
                                    <td width="35%" style="font-size:10pt;text-align: left;">Kepada Yth.</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td width="65%" style="font-size:10pt;text-align: left;">No.
                                        ____________________________</td>
                                    <td width="35%" style="font-size:10pt;text-align: left;">PBF
                                        ____________________________</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="font-size:14pt;text-align: center;"><strong>SURAT PESANAN</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="font-size:10pt;">Mohon dikirim obat-obatan untuk keperluan Apotek sebagai berikut:
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <?php
    $html = "";
    $no = 1;

    foreach ($data['detail'] as $key => $value) {
        $nama_barang = $value['nama_barang'];
        $jumlah = $value['qty'];
        $html .= '
                    <tr>
                        <td align="center">' . $no . '</td>
                        <td>' . $nama_barang . '</td>
                        <td align="center">' . $jumlah . '</td>
                    </tr>
                ';
        $no++;
    }
    ?>
    <table>
        <!-- Daftar produk -->
        <tr>
            <td>
                <table border="1" cellpadding="5" style="font-size:10pt;">
                    <tr style="background-color:#EDEDEE;">
                        <th align="center" width="10%"><strong>No.</strong></th>
                        <th align="center" width="70%"><strong>Nama Obat</strong></th>
                        <th align="center" width="15%"><strong>Jumlah</strong></th>
                    </tr>
                    <?= $html; ?>
                </table>
            </td>
        </tr>

        <!-- Jarak -->
        <tr style="font-size:8pt;">
            <td>
                <br><br><br><br>
            </td>
        </tr>

        <tr style="font-size:8pt;">
            <td>
                <table class="table-font-size" cellpadding="2">
                    <tr>
                        <td width="65%"></td>
                        <td width="35%" align="center">Sokaraja, ______________________</td>
                    </tr>
                    <!-- Jarak -->
                    <tr>
                        <td width="65%"></td>
                        <td width="35%" align="center">Apotek Pengelola Apotek</td>
                    </tr>
                    <tr>
                        <td>
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                        </td>
                    </tr>
                    <tr>
                        <td width="65%"></td>
                        <td width="35%" align="center"><strong><?= $setting['apoteker']; ?></strong></td>
                    </tr>
                    <tr>
                        <td width="65%"></td>
                        <td width="35%" align=" center">NO.SIPA: <?= $setting['sipa']; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>