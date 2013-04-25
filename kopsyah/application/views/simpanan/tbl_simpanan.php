<div class="box_form" style="width: 300px; margin-bottom: 15px;">
    <h3>FORM PILIH TRANSAKSI SIMPANAN</h3>
<?php echo form_open("c_simpanan/index"); ?>    
    <table class="tbl_fm">
        <tr>
            <td>tgl. awal</td>
            <td>:</td>
            <td><input type="text" name="tgl_awal" id="tgl_awal" class="tgl" size="8" /></td>
        </tr>
        <tr>
            <td>Tgl. Ahkir</td>
            <td>:</td>
            <td><input type="text" name="tgl_ahkir" id="tgl_ahkir" class="tgl" size="8" /></td>
        </tr>
        <tr>
            <td colspan="3"><input type="submit" value="cari" id="carisimpan" /></td>
        </tr>
    </table>
<?php echo form_close(); ?>    
</div>
<div class="box_tabel">
    <table id="filter_tbl_transaksi" border="1">
        <thead>
        <tr>
            <th width="40">NO.</th>
            <th width="120" align="center">ID<br>SIMPANAN</th>
            <th width="120" align="center">ID<br>ANGGOTA</th>
            <th width="450">NAMA ANGGOTA</th>
            <th width="100">TGL. TRANSAKSI</th>
            <th width="150">JENIS SIMPANAN</th>
            <th width="100">NILAI</th>
        </tr>
        </thead>
        <tbody>
<?php 
$no = 1;
foreach($hasil->result() as $data){?>        
        <tr>
            <td align="center"><?php echo $no++."."; ?></td>
            <td align="center"><?php echo $data->id_simpanan; ?></td>
            <td align="center"><?php echo $data->id_anggota; ?></td>
            <td><?php echo $data->nama_anggota; ?></td>
            <td align="center"><?php echo $data->tgl_transaksi; ?></td>
            <td><?php echo $data->jenis_simpanan; ?></td>
            <td align="right">
                <?php
                    $rupiah = number_format($data->nilai,2,",",".");
                    echo "Rp.".$rupiah; 
                 ?>
            </td>
        </tr>
<?php } ?>
        </tbody>
       <tfoot>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td style="opacity: 0.4;">--Pilih--</td>
                <td>&nbsp;</td>
            </tr>
        </tfoot>
    </table>
</div>
    