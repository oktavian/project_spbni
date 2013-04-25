<?php if(@$_SESSION['user']=="pengelola"){ ?>
<div id="menu_navigasi">
         <h2 class="tetap"><a href="<?php echo base_url(); ?>c_anggota/home">HOME</a></h2>
         <h2 class="tutup">ANGGOTA</h2>
                <ul class="navanggota">
                 <li><a href="<?php echo base_url(); ?>c_anggota/tblanggota" class="a_beda2">Data Anggota</a></li>
                 <li><a href="<?php echo base_url(); ?>c_anggota/fmaddanggota" class="a_beda2">Tambah Anggota</a></li>
                 <li><a href="<?php echo base_url(); ?>c_laporan/buku_simpanan" class="a_beda2">Buku Simpanan</a></li>
                 <li><a href="<?php echo base_url(); ?>c_laporan/buku_pinjaman" class="a_beda2">Buku Pinjaman</a></li>
             </ul>
         <h2 class="tutup">SIMPANAN</h2>
            <ul class="navsimpanan">
                <li><a href="<?php echo base_url(); ?>c_simpanan/index" class="a_beda2">Data Simpanan</a></li>
                <li><a href="<?php echo base_url(); ?>c_simpanan/tampil_tbl_lunas_simpanan" class="a_beda2">Pelunasan Simpanan</a></li>
                <li><a href="<?php echo base_url(); ?>c_simpanan/tampil_daftar_simpanan" class="a_beda2">Tambah Daftar Tagihan</a></li>
            </ul>
         <h2 class="tutup">PINJAMAN</h2>
            <ul class="navpinjaman">
                <li><a href="<?php echo base_url(); ?>c_pinjaman/index" class="a_beda2">Data Pinjaman</a></li>
                <li><a href="<?php echo base_url(); ?>c_pinjaman/form_pinjaman" class="a_beda2">Tambah Pinjaman</a></li>
            </ul>
         <h2 class="tutup">ANGSURAN</h2>
            <ul class="navangsuran">
                <li><a href="<?php echo base_url(); ?>c_angsuran/index" class="a_beda2">Data Angsuran</a></li>
                <li><a href="<?php echo base_url(); ?>c_angsuran/tampil_tbl_lunas_angsuran" class="a_beda2">Pelunasan Pinjaman</a></li>
                <li><a href="<?php echo base_url(); ?>c_angsuran/tampil_daftar_angsuran" class="a_beda2">Tambah Daftar Tagihan</a></li>
            </ul>
         <h2 class="tutup">LAPORAN</h2>
            <ul class="navlaporan">
                <li><a href="<?php echo base_url(); ?>c_laporan/index" class="a_beda2">Jurnal</a></li>
                <li><a href="<?php echo base_url(); ?>c_laporan/gl" class="a_beda2">Buku Besar</a></li>
                <li><a href="<?php echo base_url(); ?>c_laporan/basil" class="a_beda2">Bagi Hasil</a></li>
                <li><a href="<?php echo base_url(); ?>c_laporan/laporan_simpanan" class="a_beda2">Laporan Simpanan</a></li>
                <li><a href="<?php echo base_url(); ?>c_laporan/laporan_pinjaman" class="a_beda2">Laporan pinjaman</a></li>
            </ul>
</div>
<?php }elseif(@$_SESSION['user']=="ketua"){ ?>
<div id="menu_navigasi">
         <h2 class="tetap"><a href="<?php echo base_url(); ?>c_anggota/home">HOME</a></h2>
         <h2 class="tetap"><a href="<?php echo base_url(); ?>c_anggota/tblanggota">DATA ANGGOTA</a></h2>
         <h2 class="tutup">SIMPANAN</h2>
            <ul class="navsimpanan">
                <li><a href="<?php echo base_url(); ?>c_simpanan/index" class="a_beda2">Data Simpanan</a></li>
                <li><a href="<?php echo base_url(); ?>c_simpanan/tampil_daftar_simpanan" class="a_beda2">Daftar Tagihan</a></li>
            </ul>
         <h2 class="tetap"><a href="<?php echo base_url(); ?>c_pinjaman/index">DATA PINJAMAN</a></h2>
         <h2 class="tutup">ANGSURAN</h2>
            <ul class="navangsuran">
                <li><a href="<?php echo base_url(); ?>c_angsuran/index" class="a_beda2">Data Angsuran</a></li>
                <li><a href="<?php echo base_url(); ?>c_angsuran/tampil_daftar_angsuran" class="a_beda2">Daftar Tagihan</a></li>
            </ul>
         <h2 class="tutup">LAPORAN</h2>
            <ul class="navlaporan">
                <li><a href="<?php echo base_url(); ?>c_laporan/index" class="a_beda2">Jurnal</a></li>
                <li><a href="<?php echo base_url(); ?>c_laporan/gl" class="a_beda2">Buku Besar</a></li>
                <li><a href="<?php echo base_url(); ?>c_laporan/basil" class="a_beda2">Bagi Hasil</a></li>
                <li><a href="<?php echo base_url(); ?>c_laporan/laporan_simpanan" class="a_beda2">Laporan Simpanan</a></li>
                <li><a href="<?php echo base_url(); ?>c_laporan/laporan_pinjaman" class="a_beda2">Laporan pinjaman</a></li>
            </ul>
</div>
<?php }elseif($_SESSION['bagian_umum']=="bagian umum"){ ?>
<div id="menu_navigasi">
    <h2 class="tetap"><a href="<?php echo base_url(); ?>c_anggota/home">HOME</a></h2>
    <h2 class="tetap"><a href="<?php echo base_url(); ?>c_anggota/tblanggota">DATA ANGGOTA</a></h2>
    <h2 class="tutup">SIMPANAN</h2>
            <ul class="navsimpanan">
                <li><a href="<?php echo base_url(); ?>c_simpanan/index" class="a_beda2">Data Simpanan</a></li>
                <li><a href="<?php echo base_url(); ?>c_simpanan/tampil_daftar_simpanan" class="a_beda2">Daftar Tagihan</a></li>
            </ul>
    <h2 class="tetap"><a href="<?php echo base_url(); ?>c_pinjaman/index">DATA PINJAMAN</a></h2>
    <h2 class="tutup">ANGSURAN</h2>
            <ul class="navangsuran">
                <li><a href="<?php echo base_url(); ?>c_angsuran/index" class="a_beda2">Data Angsuran</a></li>
                <li><a href="<?php echo base_url(); ?>c_angsuran/tampil_daftar_angsuran" class="a_beda2">Daftar Tagihan</a></li>
            </ul>
</div>
<?php } ?>


