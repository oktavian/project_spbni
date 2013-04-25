<div class="box_form" style="width: 200px; margin: 30px auto;">
    <h3>FORM PILIH PERIODE</h3>
    <?php echo form_open("c_laporan/laporan_pinjaman"); ?>
    <table class="tbl_fm">
        <tr>
            <td>BULAN</td>
            <td>:</td>
            <td>
                <select name="bln_pjm">
                    <option value="">--pilih--</option>
                 <?php 
                    $arr = array(1=>"january",2=>"february",3=>"maret",4=>"april",
                                 5=>"mei",6=>"juni",7=>"juli",8=>"agustus",9=>"september",
                                 10=>"oktober",11=>"november",12=>"desember");
                    
                    foreach ($arr as $key => $value) {
                        echo "<option value=$key>$value</option>";
                    }
                
                 ?>    
                </select>
            </td>
        </tr>
        <tr>
            <td>TAHUN</td>
            <td>:</td>
            <td><input type="text" name="thn_pjm" id="thn_pjm" size="8" /></td>
        </tr>
        <tr>
            <td colpsan="3">
                <input type="submit" value="cari" /> 
            </td>
        </tr>
    </table>
</div>
<div class="box_tabel" style="width: 500px; margin: 0 auto;">
    <h2 align="center">
        KOPERASI SPBNI SYARIAH BANDUNG<br>
        LAPORAN SALDO PINJAMAN<br>
        Per <?php echo @$ket; ?>
    </h2>
    <table border="1">
      <thead>
        <tr>
            <th>NO</th>
            <th>NAMA ANGGOTA</th>
            <th>SALDO PINJAMAN</th>
        </tr>
     </thead>   
<?php 
$no=1; 
foreach(@$hasil->result() as $data){
?>     
        <tr>
            <td><?php echo @$no++."."; ?></td>
            <td><?php echo @$data->nama_anggota; ?></td>
            <td align="right">
                <?php 
                    if($data->saldo!=0){
                        $rupiah = number_format($data->saldo,2,",",".");
                        echo "Rp. ".$rupiah;
                    }else{echo "Rp. -"; } 
                ?>
            </td>
<?php } ?>        
    </table>
</div>