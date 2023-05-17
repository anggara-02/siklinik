<!-- ==========DON'T REMOVE============
Create with Love
Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
Support : Alfons Permana | 
Megistra Team : megistra.com
Contact Us : support@megistra.com
==========DON'T REMOVE============ -->

<?php
defined('BASEPATH') or exit('No direct script access allowed');
$websiteConfig = common_lib::getConfig();
if (isset($title) & ($title == 'Jenis Penjamin' | $title == 'Poli' | $title == 'Supplier' | $title == 'Layanan Medis' | $title == 'Kemasan' | $title == 'Satuan Dosis' | $title == 'Obat' | $title == 'Alkes')) {
        $data_master = true;
        $display_data_master = true;
} else {
        $data_master = false;
        $display_data_master = false;
}
if (($this->uri->segment(2) == 'pemesanan') | ($this->uri->segment(2) == 'penerimaan') | ($this->uri->segment(2) == 'inkaso') | ($this->uri->segment(2) == 'stock_opname') | ($this->uri->segment(2) == 'distribusi') || ($this->uri->segment(2) == 'retur_supplier')) {
        $inventory = true;
        $display_inventory = true;
} else {
        $inventory = false;
        $display_inventory = false;
}
?>
<div class="main-sidebar">
        <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
                        <a href="<?php echo base_url('admin/dashboard'); ?>"><?php echo $websiteConfig['config_app_name'] ?></a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm">
                        <a href="<?php echo base_url('admin/dashboard'); ?>">SI</a>
                </div>
                <ul class="sidebar-menu">
                        <li class="menu-header">Navigation</li>
                        <li><a class="nav-link" href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-home"></i><span>Dashboard</span></a></li>

                        <li class="menu-header">Transaksi</li>
                        <li><a class="nav-link" href="<?= base_url('admin/registration'); ?>"><i class="fa fa-book"></i><span>Pendaftaran</span></a></li>
                        <li><a class="nav-link" href="<?= base_url('admin/pemeriksaan/index'); ?>"><i class="fa fa-stethoscope"></i><span>Pemeriksaan</span></a></li>
                        <li><a class="nav-link" href="<?= base_url('admin/pemeriksaan/lab'); ?>"><i class="fa fa-tint"></i>
                                        <span>Laboratorium</span></a></li>
                        <li><a class="nav-link" href="#"><i class="fa fa-medkit"></i>
                                        <span>Gigi</span></a></li>
                        <li><a class="nav-link" href="#"><i class="fa fa-plus-square"></i>
                                        <span>KIA</span></a></li>
										
                        <li><a class="nav-link" href="<?= base_url('admin/pemeriksaan/apotek'); ?>"><i class="fa fa-calculator"></i>
                                        <span>Farmasi</span></a></li>
                        <li><a class="nav-link" href="<?= base_url('admin/pemeriksaan/kasir'); ?>"><i class="fa fa-cash-register"></i> <span>Kasir</span></a></li>

                        <li class="menu-header">Data Master & Inventori</li>
                        <li class="nav-item dropdown <?= $data_master ? 'active' : '' ?>">
                                <a href="#" class="nav-link has-dropdown"><i class="fa fa-database"></i><span>Data Master</span></a>
                                <ul class="dropdown-menu" style="display: <?= $display_data_master ? 'block' : 'none' ?>;">
                                        <li class="<?= $title == 'Jenis Penjamin' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/penjamin'); ?>">Jenis Penjamin</a></li>
                                        <li class="<?= $title == 'Poli' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/poli'); ?>">Poli</a></li>
                                        <li class="<?= $title == 'Layanan Medis' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/layanan'); ?>">Layanan Medis</a></li>
                                        <li class="<?= $title == 'Supplier' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/suplier'); ?>">Supplier</a></li>
                                        <li class="<?= $title == 'Kemasan' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/kemasan'); ?>">Kemasan</a></li>
                                        <li class="<?= $title == 'Satuan Dosis' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/dosis'); ?>">Satuan Dosis</a></li>
                                        <li class="<?= $title == 'Obat' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/obat'); ?>">Obat</a></li>
                                        <li class="<?= $title == 'Alkes' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/alkes'); ?>">Alkes</a></li>
                                </ul>
                        </li>

                        <li class="nav-item dropdown <?= $inventory ? 'active' : '' ?>">
                                <a href="#" class="nav-link has-dropdown"><i class="fa fa-truck"></i><span>Inventori</span></a>
                                <ul class="dropdown-menu" style="display: <?= $display_inventory ? 'block' : 'none' ?>;">
                                        <li class="<?= $this->uri->segment(2) == 'pemesanan' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/pemesanan'); ?>">Pemesanan</a></li>
                                        <li class="<?= $this->uri->segment(2) == 'penerimaan' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/penerimaan'); ?>">Penerimaan</a></li>
                                        <li class="<?= $this->uri->segment(2) == 'inkaso' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/inkaso'); ?>">Inkaso</a></li>
                                        <li class="<?= $this->uri->segment(2) == 'stock_opname' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/stock_opname'); ?>">Stok Opname</a></li>
                                        <li class="<?= $this->uri->segment(2) == 'distribusi' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/distribusi'); ?>">Distribusi Antar Gudang</a></li>
                                        <li class="<?= $this->uri->segment(2) == 'retur_supplier' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/retur_supplier'); ?>">Retur Supplier</a></li>
                                </ul>
                        </li>

                        <li class="menu-header">Database</li>
                        <li><a class="nav-link" href="<?= base_url('admin/pasien/klinik/index'); ?>"><i class="fa fa-users"></i>
                                        <span>Pasien Klinik</span></a></li>
                        <li class="hidden"><a class="nav-link" href="<?= base_url('admin/pasien/apotek/index'); ?>"><i class="fa fa-users"></i>
                                        <span>Pasien Apotek</span></a></li>

                        <li class="menu-header">Manajemen</li>
                        <li><a class="nav-link" href="<?php echo base_url('admin/user'); ?>"><i class="fa fa-user-secret"></i><span>Manajemen User</span></a></li>
                        <li><a class="nav-link" href="<?= base_url('admin/shift'); ?>"><i class="fa fa-sitemap"></i> <span>Manajemen
                                                Shift</span></a></li>
                        <li><a class="nav-link" href="<?= base_url('admin/jadwal'); ?>"><i class="fa fa-calendar"></i><span>Manajemen Jadwal</span></a></li>

                        <li class="menu-header">Laporan</li>
                        <li class="nav-item dropdown <?= ($this->uri->segment(3) == 'klinik') ? 'active' : '' ?> ">
                                <a href="#" class="nav-link has-dropdown"><i class="fa fa-print"></i><span>Laporan Klinik</span></a>
                                <ul class="dropdown-menu">
                                        <li class="<?= $title == 'Laporan Kunjungan Pasien' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/laporan/klinik/kunjungan_pasien'); ?>">Kunjungan Pasien</a></li>
                                        <li class="<?= $title == 'Laporan Pemeriksaan Medis' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/laporan/klinik/pemeriksaan_medis'); ?>">Pemeriksaan Medis</a></li>
                                        <li class="<?= $title == 'Laporan Jenis Tindakan Medis' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/laporan/klinik/jenis_tindakan_medis'); ?>">Jenis Tindakan
                                                        Medis</a></li>
                                </ul>
                        </li>
                        <li class="nav-item dropdown <?= ($this->uri->segment(3) == 'laborat') ? 'active' : '' ?> ">
                                <a href="#" class="nav-link has-dropdown"><i class="fa fa-print"></i><span>Laporan Laborat</span></a>
                                <ul class="dropdown-menu">
                                        <li class="<?= $title == 'Laporan Pemeriksaan Laborat' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/laporan/laborat/pemeriksaan_laborat'); ?>">Pemeriksaan Laborat</a>
                                        </li>
                                        <li class="<?= $title == 'Laporan Jenis Pemeriksaan Laborat' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/laporan/laborat/jenis_pemeriksaan_laborat'); ?>">Jenis Pemeriksaan
                                                        Laborat</a></li>
                                </ul>
                        </li>
                        <li class="nav-item dropdown <?= ($this->uri->segment(3) == 'penjualan') ? 'active' : '' ?> ">
                                <a href="#" class="nav-link has-dropdown"><i class="fa fa-print"></i><span>Laporan Penjualan</span></a>
                                <ul class="dropdown-menu">
                                        <li class="<?= $title == 'Laporan Transaksi' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/laporan/penjualan/transaksi'); ?>">Transaksi</a></li>
                                        <li class="<?= $title == 'Laporan Piutang' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/laporan/penjualan/piutang'); ?>">Piutang</a></li>
                                        <li class="<?= $title == 'Laporan Barang Terjual' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/laporan/penjualan/barang_terjual'); ?>">Barang Terjual</a></li>
                                        <li class="<?= $title == 'Laporan Resep Dokter' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/laporan/penjualan/resep_dokter'); ?>">Resep Dokter</a></li>
                                </ul>
                        </li>
                        <li class="nav-item dropdown <?= ($this->uri->segment(3) == 'data_master') ? 'active' : '' ?> ">
                                <a href="#" class="nav-link has-dropdown"><i class="fa fa-print"></i><span>Laporan Data
                                                Master</span></a>
                                <ul class="dropdown-menu">
                                        <li class="<?= $title == 'Laporan Master Barang' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/laporan/data_master/master_barang'); ?>">Master Barang</a></li>
                                        <li class="<?= $title == 'Laporan Customer' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/laporan/data_master/customer'); ?>">Customer</a></li>
                                </ul>
                        </li>
                        <!-- <li class="nav-item dropdown <?= ($this->uri->segment(3) == 'inventory') ? 'active' : '' ?> ">
                <a href="#" class="nav-link has-dropdown"><i class="fa fa-print"></i><span>Laporan Inventory</span></a>
                <ul class="dropdown-menu">
                    <li class="<?= $title == 'Laporan Inventory Pemesanan' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/laporan/inventory/pemesanan'); ?>">Pemesanan</a></li>
                    <li class="<?= $title == 'Laporan Inventory Penerimaan' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/laporan/inventory/Penerimaan'); ?>">Penerimaan</a></li>
                </ul>
            </li> -->
                        <li class="nav-item dropdown <?= ($this->uri->segment(3) == 'stok') ? 'active' : '' ?> ">
                                <a href="#" class="nav-link has-dropdown"><i class="fa fa-print"></i><span>Laporan Stok</span></a>
                                <ul class="dropdown-menu">
                                        <li class="<?= $title == 'Laporan Rekap Stok' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/laporan/stok/rekap_stok'); ?>">Rekap Stok</a></li>
                                        <li class="<?= $title == 'Laporan Mutasi Stok' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/laporan/stok/mutasi_stok'); ?>">Mutasi Stok</a></li>
                                        <li class="<?= $title == 'Laporan Stok Opname' ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/laporan/stok/stok_opname'); ?>">Stok Opname</a></li>
                                </ul>
                        </li>

                        <li class="menu-header">Settings</li>
                        <li class="<?= ($this->uri->segment(2) == 'setting') ? 'active' : '' ?>"><a class="nav-link" href="<?= base_url('admin/setting'); ?>"><i class="fa fa-home"></i> <span>Settings</span></a></li>
                </ul>
        </aside>
</div>