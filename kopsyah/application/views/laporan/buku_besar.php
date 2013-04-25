<div class="box_form" style="width:400px; margin-bottom: 15px;">
<h3>Form Buku Besar</h3>
<?php echo form_open("c_laporan/gl"); ?>    
    <table class="tbl_fm">
        <tr>
            <td>Pilih Akun</td>
            <td>:</td>
            <td>
         <select id="akun" name="akun">
             <option value="">--pilih--</option>
                <?php 
                    foreach ($akun->result() as $dt) {
                        $kode = $dt->kode_akun;
                        $nama = $dt->nama;
                        echo "<option value=$kode>$kode - $nama</option>";
                    }
                ?>
        </select>
            </td>
        </tr>
        <tr>
            <td>Bulan</td>
            <td>:</td>
            <td>
                <select id="bulan" name="bulan">
                    <option value="">--pilih--</option>    
                <?php 
                    $arr = array(1=>"january",2=>"february",3=>"maret",4=>"april",5=>"mei",6=>"juni",7=>"juli",8=>"agustus",
                                    9=>"september",10=>"oktober",11=>"november",12=>"desember"
                                 ); 
                    foreach ($arr as $key => $value) {
                        echo "<option value='$key'>$value</option>";
                    }
                ?>
                 </select>
            </td>
        </tr>
        <tr>
            <td>Tahun</td>
            <td>:</td>
            <td><input type="text" name="tahun" id="tahun" size="8" /></td>
        </tr>
        <tr>
            <td colspan="3" align="right"><input type="submit" value="pilih" /></td>
        </tr>
    </table>
<?php echo form_close(); ?>    
</div>
<div id="gl">  
    <h2 align="center">BUKU BESAR</h2>
    <p>No. Akun &nbsp;&nbsp;&nbsp;&nbsp;: <?php echo @$kd_akun; ?></p>
    <p>Nama Akun : <?php echo @$nm_akun; ?></p>  
    <table id="id_gl">
        <tr>
            <th width="100" rowspan="2">Tanggal</th>
            <th width="400" rowspan="2">Keterangan</th>
            <th width="50" rowspan="2">Ref</th>
            <th rowspan="2">Debet</th>
            <th rowspan="2">Kredit</th>
            <th colspan="2">Saldo</th>
       </tr>
       <tr>
           <th>Debet</th>
           <th>Kredit</th>
       </tr>       
 <?php   
 $debet  = 0;
 $kredit = 0;
 foreach(@$hasil->result() as $data){ 
 $debet  = $debet+$data->debet;
 $kredit = $kredit+$data->kredit;
 
 $saldo = $debet-$kredit;
     
 ?>       
        <tr>
            <td><?php echo $data->tgl_jurnal; ?></td>
            <td><?php echo $data->nama_transaksi; ?></td>
            <td>&nbsp;</td>
            <td align="right">
                <?php 
                    if($data->debet>0){
                        $rupiah6 = number_format($data->debet,2,",",".");
                        echo "Rp. ".$rupiah6;
                    }elseif($data->debet==0){
                        echo "&nbsp;";
                    }
                ?>
            </td>
            <td align="right">
                <?php 
                    if($data->kredit>0){
                        $rupiah7 = number_format($data->kredit,2,",",".");
                        echo "Rp. ".$rupiah7;
                    }elseif($data->kredit==0){
                        echo "&nbsp;";
                    }
                ?>
            </td>
            <td align="right">
                <?php
                    if($saldo>0){
                        $rupiah8 = number_format(abs($saldo),2,",",".");
                        echo "Rp. ".$rupiah8;
                    }else{
                        echo "&nbsp;";
                    }
                ?>
            </td>
            <td align="right">
                <?php 
                    if($saldo<0){
                        $rupiah9 = number_format(abs($saldo),2,",",".");
                        echo "Rp. ".$rupiah9; 
                    }else{
                        echo "&nbsp;";
                    }
                ?>
            </td>
        </tr>
 <?php } ?>        
    </table>
</div>
