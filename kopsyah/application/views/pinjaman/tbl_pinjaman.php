<div class="box_form" style="width: 300px; margin-bottom: 15px;">
    <h3>FORM PILIH TRANSAKSI PINJAMAN</h3>
<?php echo form_open("c_pinjaman/index"); ?>    
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
            <td colspan="3"><input type="submit" value="cari" id="caripnjm" /></td>
        </tr>
    </table>
<?php 
echo form_close();
echo @$ingat;
?>    
</div>
<div class="box_tabel">
    <table border="1" id="tabel_pinjam">
        <thead>
        <tr>
            <th width="30" align="center">NO.</th>
            <th width="70" align="center">ID<br>PINJAMAN</th>
            <th width="70" align="center">ID<br>ANGGOTA</th>
            <th width="300" align="center" align="center">NAMA ANGGOTA</th>
            <th align="center" align="center">TGL<BR>PINJAM</th>
            <th width="150" align="center" align="center">NOMINAL<br>PINJAMAN</th>
            <th width="50" align="center">JUMLAH<br>ANGSUR</th>
            <th width="40" align="center">BAYAR<br>KE</th>
            <th width="50" align="center">ACC</th>
            <th align="center">STATUS</th>
        </tr>
        </thead>
        <tbody>
<?php 
$no = 1;
foreach($hasil->result() as $data){?>        
        <tr>
            <td><?php echo $no++."."; ?></td>
            <td align="center"><?php echo $data->id_pinjaman; ?></td>
            <td align="center"><?php echo $data->id_anggota; ?></td>
            <td><?php echo $data->nama_anggota; ?></td>
            <td align="center"><?php echo $data->tanggal_pinjam; ?></td>
            <td align="right">
                <?php 
                 $nominal = $data->nominal_pinjaman;
                 $rupiah = number_format($nominal, "3", ",", ".");
                 echo "Rp. ".$rupiah;  
                 ?>
            </td>
            <td align="center"><?php echo $data->jml_angsuran; ?></td>
            <td align="center"><?php echo $data->pembayaran_ke; ?></td>
            <td align="center">
                <?php 
                    $acc = $data->acc; 
                    if($acc=="0"){
                        echo "<span class='acc_edit garisbawah merah' diacc='$data->id_pinjaman' id='id_$data->id_pinjaman'>BELUM ACC</span>";
                    }else{
                        echo "<span id='id_$data->id_pinjaman'>ACC</span>";
                    }
                ?>
            </td>
            <td><?php echo $data->status_pembayaran; ?></td>
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
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td style="opacity: 0.4;">--pilih--</td>
            </tr>
        </tfoot>
    </table>
</div>
    