<div class="isi_buku">
<div class="box_form" style="width: 300px; margin: 30px auto">
    <h3>FORM LIHAT PINJAMAN</h3>
<?php echo form_open("c_anggota/buku_pinjaman"); ?>    
    <table class="tbl_fm">
        <tr>
            <td>ID PINJAMAN</td>
            <td>:</td>
            <td>
                <select name="id_pinjam" id="id_pinjam">
                    <option value="">--pilih pinjaman--</option>
                    <?php 
                        foreach($allpinjam->result() as $dt){
                            echo "<option value=$dt->id_pinjaman>$dt->id_pinjaman - $dt->tanggal</option>";
                        } 
                    ?>
                </select>
            </td>
        </tr>
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
<?php echo form_close(); ?>    
</div>
<div class="box_buku" border="1">
    <h2 align="center">BUKU PINJAMAN</h2>
    <div class="ket">
        <table class="kiri">
            <tr>
                <td width="100">ID ANGGOTA</td>
                <td>:</td>
                <td><?php echo $_SESSION['anggota_id']; ?></td>
            </tr>
            <tr>
                <td>NAMA</td>
                <td>:</td>
                <td><?php echo @$ket_pinjam->nama_anggota; ?></td>
            </tr>
            <tr>
                <td>TGL. PINJAM</td>
                <td>:</td>
                <td><?php echo @$ket_pinjam->tgl_pinjam; ?></td>
            </tr>
            <tr>
                <td>STATUS</td>
                <td>:</td>
                <td><?php echo @$ket_pinjam->status;?></td>
            </tr>
            <?php if(@$ket_pinjam->status=="belum lunas"){ ?>
            <tr>
                <td>ANGSUR KE</td>
                <td>:</td>
                <td><?php echo @$ket_pinjam->bayar_ke; ?></td>
            </tr>        
            <?php } ?>
        </table>
        <table style="margin-left: 610px;">
            <tr>
                <td width="100">ID PINJAMAN</td>
                <td>:</td>
                <td><?php echo @$ket_pinjam->id_pinjaman; ?></td>
            </tr>
            <tr>
                <td>PINJAMAN</td>
                <td>:</td>
                <td>
                    <?php 
                        if(@$ket_pinjam->jml_pinjam!=0){
                            $rupiah = number_format(@$ket_pinjam->jml_pinjam,2,",",".");
                            echo "Rp. ".$rupiah;
                        }else{echo "Rp. -"; }
                    ?>
                </td>
            </tr>
            <tr>
                <td>POT. MARGIN</td>
                <td>:</td>
                <td>1.5 persen (%)</td>
            </tr>
            <tr>
                <td>JML. ANGSUR</td>
                <td>:</td>
                <td><?php echo @$ket_pinjam->jumlah_angsur; ?> kali</td>
            </tr>
            <?php if(@$ket_pinjam->status=="belum lunas"){ ?>
            <tr>
                <td>SISA ANGSUR</td>
                <td>:</td>
                <td><?php $sisa = @$ket_pinjam->jumlah_angsur-@$ket_pinjam->bayar_ke; echo $sisa; ?> kali lagi</td>
            </tr>
            <?php } ?>
        </table>
        <div class="clear"></div>
    </div>
    <table id="bk_pinjaman">
        <thead>
            <tr>
                <th>NO.</th>
                <th>TANGGAL</th>
                <th>SALDO AWAL</th>
                <th>POKOK</th>
                <th>MARGIN</th>
                <th>JUMLAH ANGSURAN</th>
                <th>SISA</th>
            </tr>
        </thead>
        <tbody>   
     <?php 
     $no=1;  
     foreach($hasil->result() as $data){ 
     ?>       
            <tr>
                <td><?php echo $no++."."; ?></td>
                <td><?php echo $data->tanggal; ?></td>
                <td>
                    <?php
                        $sisa = $data->sisa_bayar; 
                        $byr  = $data->jumlah_bayar;
                        $awal = $data->jumlah_bayar+$data->sisa_bayar;
                        if($awal!=0){
                            $rupiah2 = number_format($awal,2,",",".");
                            echo "Rp. ".$rupiah2;
                        }else{
                            echo "Rp. -";
                        }
                    ?>
                </td>
                <td>
                    <?php 
                        if($data->pokok!=0){
                            $rupiah3 = number_format($data->pokok,2,",",".");
                            echo "Rp. ".$rupiah3;
                        }else{
                            echo "Rp. -";
                        }
                    ?>
                </td>
                <td>
                    <?php 
                        if($data->margin!=0){
                            $rupiah4 = number_format($data->margin,2,",",".");
                            echo "Rp. ".$rupiah4;
                        }else{
                            echo "Rp. -";
                        }
                    ?>
                </td>
                <td>
                    <?php 
                        if($data->jumlah_bayar!=0){
                            $rupiah5 = number_format($data->jumlah_bayar,2,",",".");
                            echo "Rp. ".$rupiah5;
                        }else{
                            echo "Rp. -";
                        }
                    ?>
                </td>
                <td>
                    <?php 
                        if($data->sisa_bayar!=0){
                            $rupiah6 = number_format($data->sisa_bayar,2,",",".");
                            echo "Rp. ".$rupiah6;
                        }else{
                            echo "Rp. ";
                        }
                    ?>
                </td>
            </tr>
     <?php } ?>       
        </tbody>    
    </table>
</div>    
</div>