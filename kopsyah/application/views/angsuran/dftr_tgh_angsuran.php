<!-- BEGIN TBL TAGIHAN SEBELUMNYA -->
<button id="dftr_angsur" class="tombol" style="width: 340px; height: 50px; margin-bottom: 5px;">LIHAT DAFTAR TAGIHAN SEBELUMNYA</button>
<div id="box_dftr_angsur" style="margin-top: 5px; margin-bottom: 70px; display: none;"> 
    <div class="box_tabel">
        <h3 class="ground">TABEL DAFTAR TAGIH SEBELUMNYA</h3>
        <table border="1" id="filter_tagih_sebelumnya">
            <thead>
            <tr>
                <th>NO.</th>
                <th>ID<br>PINJAMAN</th>
                <th>ID<br>ANGSURAN</th>
                <th>ID<br>ANGGOTA</th>
                <th>NAMA ANGGOTA</th>
                <th>TANGGAL<br>BUAT</th>
                <th>JUMLAH<br>PEMBAYARAN</th>
                <?php 
                    if(@$_SESSION['user']=="pengelola"){
                        echo "<th>AKSI</th>";
                      }else{
                        echo "<th>STATUS</th>";
                      } 
                ?>
            </tr>
            </thead>
            <tbody>
<?php 
$no=1;
$jml_baris = $blm->num_rows();
foreach($blm->result() as $data){ ?>             
            <tr>
                <td align="center"><?php echo $no++."."; ?></td>
                <td align="center"><?php echo $data->id_pinjaman; ?></td>
                <td align="center"><?php echo $data->id_angsuran; ?></td>
                <td align="center"><?php echo $data->id_anggota; ?></td>
                <td><?php echo $data->nama_anggota; ?></td>
                <td align="center"><?php echo $data->tgl_pembuatan; ?></td>
                <td align="center">
                    <?php
                    $number1 = $data->jumlah_bayar;
                    $rupiah1 = number_format($number1, 2,",",".");
                    echo "Rp. ".$rupiah1; 
                    ?>
                </td>
               <?php if($_SESSION['user']=="pengelola"){ ?> 
                <td>
                    <span class='include_angsur garisbawah' 
                          idangsur='<?php echo $data->id_angsuran ?>' 
                          idpjm="<?php echo $data->id_pinjaman; ?>"
                          jmlbrs="<?php echo $jml_baris; ?>">
                        INCLUDE
                    </span>
                </td>
              <?php }elseif($_SESSION['user']=="ketua" || $_SESSION['bagian_umum']=="bagian umum"){echo "<td>BELUM LUNAS</td>";} ?>  
            </tr>
<?php } ?>
         </tbody>
        </table>
            <hr>
    </div>
</div>
<!-- END TAGIHAN SEBELUMNY -->
<!-- BEGIN BUAT DAFTAR TAGIH -->
<?php if(@$_SESSION['user']=="pengelola"){ ?>
<button id="buat_dftr_angsur" class="tombol" style="padding: 10px; height: 50px; margin-bottom: 5px;">BUAT DAFTAR TAGIHAN</button>
<a href="http://localhost/kopsyah/c_angsuran/print_daftar_tagihan" class="cetak_dftr_tagih">
   <img src="<?php echo base_url(); ?>css/images/icon/panah-icon.jpg" title="Silahkan print daftar tagihan" />
</a>
<?php } ?>
<div id="box_buat_angsur" style="margin-top: 5px; display: none;">  
    <div class="box_form" id="fmdftrtagih" style="width: 300px; margin-top: 15px;">
        <h3>FORM PEMBUATAN DAFTAR TAGIHAN</h3> 
        <?php
        $attr = array("id"=>"idformdftr");
        echo form_open("c_angsuran/tambah_daftar_angsuran",$attr); ?>
            <table class="tbl_fm">
                <tr>
                    <td>Buat Daftar</td>
                    <td>:</td>
                    <td><input type="text" name="buat_daftar" id="buat_daftar" class="tgl" size="8"/></td>
                </tr>
                <tr>
                <td colspan="3" align="right">
                    <input type="submit" value="buat" id="iddtarsimp" />
                </td>
                </tr>
            </table>
        <?php echo form_close(); ?>
    </div>
</div>
<!-- END BUAT DAFTAR TAGIH -->
<p style="color:brown; font-size:14px;"><b>Sebelumnya Anda Pernah Menginputkan Daftar Tagih Pada periode : <?php if(!isset($periode)){echo "-";}else{echo $periode; }; ?></b></p>
<div class="box_tabel" style="margin-top: 25px;">
    <h3>TABEL DAFTAR TAGIH</h3>
    <table border="1" id="filter_angsuran">
            <thead>
            <tr>
                <th>NO.</th>
                <th>ID<br>PINJAMAN</th>
                <th>ID<br>ANGSURAN</th>
                <th>ID<br>ANGGOTA</th>
                <th>TANGGAL<br>BUAT</th>
                <th>SISA<br>BAYAR ULANG</th>
                <th>JUMLAH<br>PEMBAYARAN</th>
                <th>SISA<br>PEMBAYARAN</th>
                <th width="70" align="center">STATUS TUNGGU</th>
            </tr>
            </thead>
            <tbody>
<?php 
$no=1;
$jml_tgh = $hasil->num_rows();
foreach($hasil->result() as $data){ ?>             
            <tr>
                <td align="center"><?php echo $no++."."; ?></td>
                <td align="center"><?php echo $data->id_pinjaman; ?></td>
                <td align="center"><?php echo $data->id_angsuran; ?></td>
                <td align="center"><?php echo $data->id_anggota; ?></td>
                <td align="center"><?php echo $data->tgl_pembuatan; ?></td>
                <td align="center"><?php echo $data->sisa_byr_ulang; ?> kali</td>
                <td align="center">
                    <?php
                    $number = $data->jumlah_bayar;
                    $rupiah = number_format($number, 2,",",".");
                    echo "Rp. ".$rupiah; 
                    ?>
                </td>
                <td>
                    <?php 
                    $angka = $data->sisa_jml_bayar;
                    $sisa = number_format($angka, "2", ",", ".");
                    echo "Rp. ".$sisa;
                    ?>
                </td>
                    <?php if(@$_SESSION['user']=="pengelola"){ ?>    
                <td align="center">
                    <?php 
                        $sts = $data->sts_tunggu;
                        if($sts==0){
                            echo "<span class='update_angsur garisbawah' idangsur='$data->id_angsuran' id='id_$data->id_angsuran' stat='PROSES'>
                                    <img src='".base_url()."css/images/icon/warning-icon.jpg' width='20' title='sedang diproses..' />
                                  </span>";
                        }else{
                            echo "<span class='update_angsur garisbawah' idangsur='$data->id_angsuran' id='id_$data->id_angsuran' stat='SELESAI'>
                                    <img src='".base_url()."css/images/icon/valid-icon.jpg' width='20' title='selesai' />
                                  </span>
                                 ";
                        }
                    ?>
                </td>
            <?php }elseif(@$_SESSION['user']=="ketua" || @$_SESSION['bagian_umum']=="bagian umum"){ ?>
                <td>
                    <?php if($data->sts_tunggu==0){echo "PROSES.."; }else{echo "SELESAI";}?>
                </td>
            <?php } ?>    
            </tr>
<?php } ?>
         </tbody>
   </table>
</div>
<?php if(@$_SESSION['user']=="pengelola"){ ?>
<button class="tombol" id="tombol_transaksi">INPUT TANGGAL TRANSAKSI</button>
<?php } ?>
<div class="box_form" id="box_transaksi_angsur">
    <h3>FORM TRANSAKSI</h3>
    <?php 
    $atribut = array("id"=>"filter_transaksi_angsur");    
    echo form_open("c_angsuran/input_transaksi_angsuran",$atribut); ?>
    <table class="tbl_fm">
        <tr>
            <td>tgl. transaksi</td>
            <td>:</td>
            <td><input type="" id="id_trans" name="id_trans" class="tgl" size="8" /></td>
        </tr>
        <tr>
            <td colspan="3">
                <input type="submit" value="SIMPAN" />
            </td>
        </tr>
    </table>
    <?php echo form_close(); ?>
</div>
<?php echo @$ingat; ?>