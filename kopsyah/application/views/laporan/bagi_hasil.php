<div id="form_basil">
<div class="box_form kiri">
    <h3>FORM INPUT PENDAPATAN</h3>
    <?php echo form_open("c_laporan/jurnalkan_pendapatan_basil"); ?>    
    <table class="tbl_fm">
        <tr>
            <td>TGL. TRANSAKSI</td>
            <td>:</td>
            <td><input type="text" name="tgl_trans" id="tgl_trans" class="tgl" size="8" /></td>
        </tr>
        <tr>
            <td>MASUKAN PENDAPATAN</td>
            <td>:</td>
            <td><input type="text" name="pendapatan" id="pendapatan" size="10" /></td>
        </tr>
        <tr><td colspan="3" align="right"><input type="submit" value="masukan" /></td></tr>
    </table>
    <?php echo form_close(); ?>
</div>   
<!-- end box form pendapatan -->

<div class="box_keterangan" style="width:700px; margin-left: 350px;">
    <p class="phead">KETERANGAN BAGI HASIL</p>
<table class="tbl_fm kiri ket_basil">
    <tr>
        <td>TOTAL SIMP MUDHARABAH</td>
        <td>:</td>
        <td>
            <?php
            $tot_mdh = $simpananan_mdh->total_simpanan_mdh;
            if($tot_mdh==0){
                echo "Rp. -";
            }else{
                $rupiah2 = number_format($tot_mdh, "2", ",", ".");
                echo "Rp. ".$rupiah2;
            }
            ?> 
        </td>
    </tr>
    <tr>
        <td>TOTAL SIMP WAJIB</td>
        <td>:</td>
        <td>
            <?php
            $tot_wjb = $simpananan_wjb->total_simpanan_wjb;
            if($tot_wjb==0){
                echo "Rp. -";
            }else{
                $rupiah2 = number_format($tot_wjb, "2", ",", ".");
                echo "Rp. ".$rupiah2;
            }
            ?> 
        </td>
    </tr>
    <tr>
        <td>TOTAL PENDAPATAN</td>
        <td>:</td>
        <td>
            <?php 
            if($total_untung->total_pendapatan!=0){
                $all = $total_untung->total_pendapatan; 
                $rupiah3 = number_format($all,"2",",",".");
                echo "Rp. ".$rupiah3;
            }elseif($total_untung->total_pendapatan==0){
                echo "Rp. -";
            }
            ?>
        </td>
    </tr>
</table>
    <table style="margin-left: 340px;" class="tbl_fm ket_basil">
        <tr>
            <td>BAGI HASIL</td>
            <td><b>--></b></td>
            <td>30 : 70</td>
        </tr>
        <tr>
            <td>BAGIAN ANGGOTA</td>
            <td>:</td>
            <td>
                <?php
                if($total_untung->total_pendapatan!=0){
                    $bag_koperasi = $all*(30/100);
                    $rupiah4 = number_format($bag_koperasi,"2",",","."); 
                    echo "Rp. ".$rupiah4;
                }elseif($total_untung->total_pendapatan==0){
                     echo "Rp. -";
                 }   
                ?>
            </td>
        </tr>
        <tr>
            <td>BAGIAN KOPERASI</td>
            <td>:</td>
            <td>
                <?php
                if($total_untung->total_pendapatan!=0){
                    $bagian_anggota = $all-$bag_koperasi;
                    $rupiah5 = number_format($bagian_anggota,"2",",",".");
                    echo "Rp. ".$rupiah5;
                }elseif($total_untung->total_pendapatan==0){
                     echo "Rp. -";
                 }
                ?>
            </td>
        </tr>
    </table>
 <div class="clear"></div>
 <div id="bagi">
     <?php echo form_open("c_laporan/bagikanbasil"); ?>
         TAHUN : <input type="text" name="tahun" id="tahun" size="8" /> 
         <input type="submit" value="bagikan" />
     <?php echo form_close(); ?>    
 </div>
</div>
</div>
<!-- end input transaski -->

<div id="hasil_basil">          
<div class="box_form kiri" style="width: 290px;">
    <h3>FORM PILIH BAGI HASIL ANGGOTA</h3>
    <?php echo form_open("c_laporan/basil"); ?>    
    <table class="tbl_fm">
        <tr>
            <td>ANGGOTA</td>
            <td>:</td>
            <td><input type="text" name="anggota" id="anggota" /></td>
        </tr>
        <tr>
            <td>TAHUN</td>
            <td>:</td>
            <td><input type="text" name="tahun_cari" id="tahun_cari" size="8" s/></td>
        </tr>
        <tr>
            <td colspan="3" align="right"><input type="submit" value="cari" class="submit" /></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
</div>
<!-- END FORM -->
<div class="box_tabel" style="margin-left:350px;">
    <table id="tbl_basil">
        <tr>
            <th align="center">ID ANGGOTA</th>
            <th align="center">NAMA ANGGOTA</th>
            <th align="center">TAHUN</th>
            <th align="center">NILAI</th>
        </tr>
        <tr>
            <td align="center"><?php echo @$idanggota; ?></td>
            <td><?php echo @$nama; ?></td>
            <td align="center"><?php echo @$tahunnya; ?></td>
            <td align="right">
                <b>
                <?php
                    if($nilai->basil!=0){
                        $rupiah7 = number_format($nilai->basil,2,",",".");
                        echo "Rp. ".$rupiah7;
                    }else{echo "Rp. -"; }
                     
                ?>
                </b>
            </td>
        </tr>
    </table>
</div>
<!-- END TABEL --> 
    <div class="clear"></div>
</div>

