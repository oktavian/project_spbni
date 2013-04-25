<div class="isi_buku">
<div class="box_form" style="width: 300px; margin: 0 auto">
    <h3>FROM PILIH TANGGAL</h3>
<?php echo form_open("c_anggota/buku_simpanan"); ?>    
    <table class="tbl_fm">
        <tr>
            <td>TGL. AWAL</td>
            <td>:</td>
            <td><input type="text" name="tgl_awal" id="tgl_awal" class="tgl" size="8" /></td>
        </tr>
        <tr>
            <td>TGL. AHKIR</td>
            <td>:</td>
            <td><input type="text" name="tgl_ahkir" id="tgl_ahkir" class="tgl" size="8" /></td>
        </tr>
        <tr>
            <td colspan="3">
                <input type="submit" value="cari" /> 
            </td>
        </tr>
    </table>
</div>
<div class="box_tabel" border="1">
    <h2 align="center">BUKU SIMPANAN</h2>
    <p>ID ANGGOTA : <?php echo $_SESSION['anggota_id']; ?></p>
    <p><span style="padding-right: 35px;">NAMA </span>: <?php echo $nama->nama_anggota; ?></p>
    <table id="bk_simpanan" border="1">
        <thead>
            <tr>
                <th>NO.</th>
                <th>TANGGAL</th>
                <th>SIMP. WAJIB</th>
                <th>SIMP. MUDHARABAH</th>
                <th>SALDO</th>
            </tr>
        </thead>
        <tbody> 
       <?php 
       $no = 1; 
       foreach($hasil->result() as $data){ 
       ?>     
            <tr>
                <td><?php echo $no++."."; ?></td>
                <td><?php echo $data->tanggal; ?></td>
                <td>
                    <?php 
                    $rupiah1 = number_format($data->wajib, 2, ",",".");
                    echo "Rp. ".$rupiah1;
                    ?>
                </td>
                <td>
                    <?php
                    $rupiah2 = number_format($data->mdh, 2, ",",".");
                    echo "Rp. ".$rupiah2;
                    ?>
                </td>
                <td>
                    <?php 
                    $rupiah3 = number_format($data->total, 2, ",",".");
                    echo "Rp. ".$rupiah3; 
                    ?>
                </td>
            </tr>
      <?php } ?>
        </tbody>
        <tfoot>
            <tr class="tr_edit">
                <td align="center" colspan="2">TOTAL</td>
                <td>
                    <?php 
                   if($tot_wjb->total_wjb==0){
                        echo "Rp. -";
                    }else{
                        $rupiah5 = number_format($tot_wjb->total_wjb, 2, ",",".");
                        echo "Rp. ".$rupiah5;
                   }    
                    ?>
                </td>
                <td>
                    <?php 
                    if($tot_mdh->total_mdh==0){
                        echo "Rp. -";
                    }else{
                        $rupiah6 = number_format($tot_mdh->total_mdh, 2, ",",".");
                        echo "Rp. ".$rupiah6;
                    }    
                    ?>
                </td>
                <td>
                    <?php 
                    if($tot->total_all==0){
                        echo "Rp. -";
                    }else{
                        $rupiah4 = number_format($tot->total_all, 2, ",",".");
                        echo "Rp. ".$rupiah4;
                    }    
                    ?>
                </td>
            </tr>
        </tfoot>
    </table>
</div>    
</div>