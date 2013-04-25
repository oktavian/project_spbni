<div class="box_form" style="width: 300px; margin-bottom: 15px;">
    <h3>FORM PILIH TRANSAKSI ANGSURAN</h3>
<?php echo form_open("c_angsuran/index"); ?>    
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
            <th width="30">NO.</th>
            <th width="80">ID<br>PINJAMAN</th>
            <th width="80">ID<br>ANGSUR</th>
            <th width="80">ID<br>ANGGOTA</th>
            <th>NAMA ANGGOTA</th>
            <th>TGL<br>BUAT</th>
            <th>TGL<br>TRANSAKSI</th>
            <th>JUMLAH<br>BAYAR</th>
            <th>SISA<br>BAYAR</th>
            <th>SISA</th>
        </tr>
        </thead>
        <tbody>
<?php 
$no = 1;
foreach($hasil->result() as $data){?>        
        <tr>
            <td align="center"><?php echo $no++."."; ?></td>
            <td align="center"><?php echo $data->id_pinjaman; ?></td>
            <td align="center"><?php echo $data->id_angsuran; ?></td>
            <td align="center"><?php echo $data->id_anggota; ?></td>
            <td><?php echo $data->nama_anggota; ?></td>
            <td align="center"><?php echo $data->tgl_buat; ?></td>
            <td align="center"><?php echo $data->tanggal_transaksi; ?></td>
            <td align="right">
                <?php
                    $rupiah = number_format($data->jumlah_bayar,2,",",".");
                    echo "Rp. ".$rupiah;
                ?>
            </td>
            <td align="right">
                <?php 
                    $rupiah2 = number_format($data->sisa_bayar,2,",",".");
                    echo "Rp. ".$rupiah2;
                ?>
            </td>
            <td align="right">
                <?php 
                    $rupiah3 = number_format($data->sisa,2,",",".");
                    echo "Rp. ".$rupiah3;
                ?>
            </td>
        </tr>
<?php } ?>
        </tbody>
    </table>
</div>