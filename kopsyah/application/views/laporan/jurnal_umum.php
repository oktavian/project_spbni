<div class="box_form" style="width:200px; margin: 30px auto;">
    <h3>Form Jurnal</h3>
<?php echo form_open("c_laporan/index"); ?>    
    <table class="tbl_fm">
        <tr>
            <td>Tgl. Awal</td>
            <td>:</td>
            <td><input type="text" name="tgl_awal" id="tgl_awal" class="tgl" size="8" /></td>
        </tr>
        <tr>
            <td>Tgl. Ahkir</td>
            <td>:</td>
            <td><input type="text" name="tgl_ahkir" id="tgl_ahkir" class="tgl" size="8" /></td>
        </tr>
        <tr>
            <td colspan="3">
                <input type="submit" value="cari" />
            </td>
        </tr>
    </table>
<?php echo form_close(); ?>    
</div>
<div class="box_tabel" style="margin: 0 auto; width: 600px;">
    <h2 align="center">JURNAL UMUM</h2>
    <h2 align="center">SPBNI SYARIAH</h2>
    <table class="tabel_selingan1" id="jurnal" border="1">
        <thead>
        <tr>
            <th width="100">TANGGAL</th>
            <th width="200">KETERANGAN</th>
            <th>REF</th>
            <th>DEBET</th>
            <th>KREDIT</th>
        </tr>
        </thead>
        <tbody>
<?php foreach ($hasil->result() as $data) { ?>            
            <tr>
                <td class="garis_ilang">
                <?php 
                    if($data->urutan==1){
                        echo $data->tgl_jurnal;
                    }else{
                        echo "&nbsp;";
                    }
                ?>
                </td>
                <td>
                <?php
                    if(($data->nama=="kas" || $data->nama=="piutang anggota") && $data->urutan==1){
                        echo $data->nama;
                    }elseif(
                             $data->nama=="simpanan wajib" || 
                             $data->nama=="dana syirkah temporer" || 
                             $data->nama=="pendapatan usaha" ||
                             $data->nama=="pendapatan usaha" ||
                            ($data->nama=="kas" && $data->urutan!=1) ||
                            ($data->nama=="piutang anggota" && $data->urutan!=1) ||
                             $data->nama=="pendapatan margin"
                            ){
                               echo "&nbsp;&nbsp;&nbsp;&nbsp;".$data->nama;
                    }
                ?>
                </td>
                <td>&nbsp;</td>
                <td align="right">
                    <?php
                    if($data->debet!=0){
                        $rupiah = number_format($data->debet,"2",",",".");
                        echo "Rp.".$rupiah;
                    }elseif($data->debet==0){
                        echo "Rp. -";
                    }
                    ?>
                </td>
                <td align="right">
                    <?php
                    if($data->kredit!=0){
                        $rupiah1 = number_format($data->kredit,"2",",",".");
                        echo "Rp.".$rupiah1;
                    }elseif($data->kredit==0){
                        echo "Rp. -";
                    }
                    ?>
                </td>
            </tr>
<?php } ?>    
        </tbody>
    </table>
</div>