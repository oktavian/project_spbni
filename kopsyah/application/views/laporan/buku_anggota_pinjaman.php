<div class="box_form" style="width:300px; margin: 15px auto; ">
    <h3>FORM PENCARIAN BUKU ANGGOTA</h3>
<?php echo form_open("c_laporan/buku_pinjaman"); ?>    
    <table class="tbl_fm">
        <tr>
            <td>ANGGOTA</td>
            <td>:</td>
            <td><input type="text" name="anggota" id="anggota" /></td>
        </tr>
        <tr>
            <td>ID PINJAMAN</td>
            <td>:</td>
            <td>
                <input type="text" name="idpinjam" id="idpinjam" />
            </td>
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
<div class="box_buku" border="1" style="width:900px; margin: 0 auto;">
    <h2 align="center">BUKU PINJAMAN</h2>
    <div class="ket">
        <table class="kiri">
            <tr>
                <td width="100">ID ANGGOTA</td>
                <td>:</td>
                <td><?php echo @$ket_pinjam->id_anggota; ?></td>
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
    <table id="bk_pinjaman" border="1" width="100%">
        <thead>
            <tr>
                <th width="5%" align="center">NO.</th>
                <th width="10%" align="center">TANGGAL</th>
                <th align="center">SALDO AWAL</th>
                <th align="center">POKOK</th>
                <th align="center">MARGIN</th>
                <th align="center">JUMLAH ANGSURAN</th>
                <th align="center">SISA</th>
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
                <td align="right">
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
                <td align="right">
                    <?php 
                        if($data->pokok!=0){
                            $rupiah3 = number_format($data->pokok,2,",",".");
                            echo "Rp. ".$rupiah3;
                        }else{
                            echo "Rp. -";
                        }
                    ?>
                </td>
                <td align="right">
                    <?php 
                        if($data->margin!=0){
                            $rupiah4 = number_format($data->margin,2,",",".");
                            echo "Rp. ".$rupiah4;
                        }else{
                            echo "Rp. -";
                        }
                    ?>
                </td>
                <td align="right">
                    <?php 
                        if($data->jumlah_bayar!=0){
                            $rupiah5 = number_format($data->jumlah_bayar,2,",",".");
                            echo "Rp. ".$rupiah5;
                        }else{
                            echo "Rp. -";
                        }
                    ?>
                </td>
                <td align="right">
                 <b>
                    <?php 
                        if($data->sisa_bayar!=0){
                            $rupiah6 = number_format($data->sisa_bayar,2,",",".");
                            echo "Rp. ".$rupiah6;
                        }else{
                            echo "Rp. ";
                        }
                    ?>
                 </b>
                </td>
            </tr>
     <?php } ?>       
        </tbody>    
    </table>
</div>