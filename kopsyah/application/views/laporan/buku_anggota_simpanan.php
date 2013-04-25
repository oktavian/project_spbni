<div class="box_form" style="width:300px; margin: 15px auto;">
    <h3>FORM PENCARIAN BUKU ANGGOTA</h3>
 <?php echo form_open("c_laporan/buku_simpanan"); ?>   
    <table class="tbl_fm">
        <tr>
            <td>ANGGOTA</td>
            <td>:</td>
            <td><input type="text" name="anggota" id="anggota" /></td>
        </tr>
        <tr>
            <td>TGL. AWAL</td>
            <td>:</td>
            <td><input type="text" name="tgl_awal" id="tgl_awal" size="8" class="tgl" /></td>
        </tr>
        <tr>
            <td>TGL. AHKIR</td>
            <td>:</td>
            <td><input type="text" name="tgl_ahkir" id="tgl_ahkir" size="8" class="tgl" /></td>
        </tr>
        <tr>
            <td colspan="3"><input type="submit" value="cari" /></td>
        </tr>
    </table>
 <?php echo form_close(); ?>   
</div>
<div class="box_tabel" style="margin: 0 auto; width: 700px;">
    <table border="1">
      <thead>
        <tr>
            <th align="center" width="40">NO.</th>
            <th align="center">TANGGAL</th>
            <th align="center">SIMPANAN<br>WAJIB</th>
            <th align="center">SIMPANAN<br>MUDHARABAH</th>
            <th align="center">JUMLAH</th>
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
            <td align="right">
                <?php
                    $rupiah1 = number_format($data->wajib,2, ",", ".");
                    echo "Rp. ".$rupiah1; 
                ?>
            </td>
            <td align="right">
                <?php 
                    $rupiah2 = number_format($data->mdh,2,",",".");
                    echo "Rp. ".$rupiah2; 
                ?>
            </td>
            <td align="right">
                <?php
                    $rupiah3 = number_format($data->total,2,",",".");
                    echo "Rp. ".$rupiah3;
                ?>
            </td>
        </tr>
<?php } ?> 
      </tbody>
      <tfoot>
        <tr>
            <td colspan="2" align="center"><b>TOTAL</b></td>
            <td align="right">
                <b>
                <?php 
                    if($tot_wjb->total_wjb!=0){
                        $rupiah4 = number_format($tot_wjb->total_wjb,2,",",".");
                        echo "Rp. ".$rupiah4; 
                    }else{echo "Rp. -"; }
                ?>
                </b>
            </td>
            <td align="right">
                <b>
                    <?php
                        if($tot_mdh->total_mdh!=0){
                            $rupiah5 = number_format($tot_mdh->total_mdh,2,",",".");
                            echo "Rp. ".$rupiah5;
                        }else{echo "Rp. -"; }
                    ?>
                </b>
            </td>
            <td align="right">
                <b>
                <?php
                    if($all->total_all!=0){
                    $rupiah6 = number_format($all->total_all,2,",",".");
                    echo "Rp. ".$rupiah6;
                    }else{echo "Rp. -"; }
                ?>
                </b>
            </td>
        </tr>
       </tfoot>
    </table>
</div>