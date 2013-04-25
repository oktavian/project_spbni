<div class="outer_buku">
        <h1>SILAHKAN PILIH</h1>
    <a href="<?php echo base_url(); ?>c_anggota/buku_simpanan" class="buku kiri">
        <div class="box_keterangan" style="width: 300px; height: 350px;">
            <p class="phead">&nbsp;</p>
            <table class="tbl_fm" align="center">
                <tr>
                    <td>id anggota</td>
                    <td>:</td>
                    <td><?php echo $hasil->id_anggota; ?></td>
                </tr>
                <tr>
                    <td>nama</td>
                    <td>:</td>
                    <td><?php echo $hasil->nama_anggota; ?></td>
                </tr>
                <tr>
                    <td>tgl masuk</td>
                    <td>:</td>
                    <td><?php echo $hasil->tgl_masuk; ?></td>
                </tr>
            </table>
            <div align="center" class="judul_buku"><h2>BUKU SIMPANAN<br>SPBNI SYARIAH</h2></div>
        </div>
     </a>
     <a href="<?php echo base_url(); ?>c_anggota/buku_pinjaman" class="buku kanan">
        <div class="box_keterangan" style="width: 300px; height: 350px;">
            <p class="phead">&nbsp;</p>
            <table class="tbl_fm" align="center">
                <tr>
                    <td>id anggota</td>
                    <td>:</td>
                    <td><?php echo $hasil->id_anggota; ?></td>
                </tr>
                <tr>
                    <td>nama</td>
                    <td>:</td>
                    <td><?php echo $hasil->nama_anggota; ?></td>
                </tr>
                <tr>
                    <td>tgl masuk</td>
                    <td>:</td>
                    <td><?php echo $hasil->tgl_masuk; ?></td>
                </tr>
            </table>
            <div align="center" class="judul_buku"><h2>BUKU PINJAMAN<br>SPBNI SYARIAH</h2></div>
        </div>
     </a>
        <div class="clear"></div>   
     </div>