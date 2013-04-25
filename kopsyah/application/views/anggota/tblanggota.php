<div class="box_tabel kiri" style="width:959px;">
<h3>TABEL ANGGOTA</h3>
<!-- BEGIN COBA -->
<table border="1" id="tabelanggota">
    <thead>
        <tr>
            <th width="20">NO.</th>
            <th width="100">ID<br>ANGGOTA</th>
            <th>NAMA ANGGOTA</th>
            <th width="100">TANGGAL<br>MASUK</th>
            <th width="135">NO. TELP</th>
            <th width="100">STATUS<br>PEGAWAI</th>
            <th width="60">AKSI</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($hasil as $data) {
        ?>   
        <tr>
            <td align="center"><?php echo $no++."."; ?></td>
            <td align="center"><?php echo $data->id_anggota; ?></td>
            <td><?php echo $data->nama_anggota; ?></td>
            <td align="center"><?php echo $data->tgl_masuk; ?></td>
            <td align="center"><?php echo $data->no_telp; ?></td>
            <td align="center"><?php echo $data->status_pegawai; ?></td>
            <td align="center">
            <?php if(@$_SESSION['user']=="pengelola"){ ?>    
                <a href="http://localhost/kopsyah/c_anggota/fmeditanggota/<?php echo $data->id_anggota; ?>" class="klik_edit" id="">
                    <img src="<?php echo base_url(); ?>css/images/icon/edit-icon.png" width="20" title="edit data">
                </a>
            <?php } ?>    
                <a href="" class="hover_anggota" hoveranggota="<?php echo $data->id_anggota; ?>">
                    <img src="<?php echo base_url(); ?>css/images/icon/search.jpg" width="20">
                </a>
            </td>
        </tr>
        <?php }?>
    </tbody>
</table>
</div>
<!-- END COBA -->
<!-- BEGIN KETERANGAN TABEL -->
<div id="tbl_detail_anggota"></div>
<div class="box_keterangan" style="width: 270px; margin-left: 990px;">
    <p class="phead">KETERANGAN TABEL</p>
    <table class="tbl_fm">
        <tr>
            <td>Cari</td>
            <td>:</td>
            <td>
                <select name="cr" id="cr">
                    <option value="">--cari--</option>
                    <option value="id">Id Anggota</option>
                    <option value="nm">Nama Anggota</option>
                </select>
            </td>
        </tr>
        <tr id="crsil" style="display: none;">
            <td>silahkan</td>
            <td>:</td>
            <td><input type="text" name="sil" id="sil" size="8" /></td>
        </tr>
    </table>

    <div class="font_12">    
        <p align="center">Total Anggota : <?php $tot = $out + $ttp; echo $tot; ?></p>
        <p align="center">
            <span style="display: inline-block; margin-right: 30px;">Outsourcing : <?php echo $out; ?></span>
            <span>Tetap : <?php echo $ttp; ?></span>
        </p>
    </div>
    <!-- END KETERANGAN TABEL -->  
</div>

