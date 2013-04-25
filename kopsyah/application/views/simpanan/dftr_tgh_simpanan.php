<!-- BEGIN TBL TAGIHAN SEBELUMNYA -->
<button id="dftr_simpan" class="tombol" style="width: 340px; height: 50px; margin-bottom: 5px;">LIHAT DAFTAR TAGIHAN SEBELUMNYA</button>
<div id="box_dftr_simpan" style="margin-top: 5px; margin-bottom: 70px; display: none;"> 
    <div class="box_tabel">
        <h3 class="ground">TABEL DAFTAR TAGIH SEBELUMNYA</h3>
        <table border="1" id="filter_tagih_sebelumnya">
            <thead>
            <tr>
                <th width="20">NO.</th>
                <th>ID<br>SIMPANAN</th>
                <th>ID<br>ANGGOTA</th>
                <th width="200">NAMA ANGGOTA</th>
                <th>TANGGAL<br>BUAT</th>
                <th width="100">JENIS<br>SIMPANAN</th>
                <th>NILAI</th>
                <?php if(@$_SESSION['user']=="pengelola"){
                            echo "<th>AKSI</th>"; 
                      }else{
                            echo "<th>STATUS</th>"; 
                      }
                ?>
            </tr>
            </thead>
            <tbody>
<?php 
$no1 = 1;    
foreach($blm->result() as $hsl){ ?>            
            <tr>
                <td align="center"><?php echo $no1++."."; ?></td>
                <td><?php echo $hsl->id_simpanan; ?></td>
                <td><?php echo $hsl->id_anggota; ?></td>
                <td><?php echo $hsl->nama_anggota; ?></td>
                <td><?php echo $hsl->tgl_pembuatan; ?></td>
                <td><?php echo $hsl->jenis_simpanan; ?></td>
                <td align="right">
                    <?php 
                        $rupiah = number_format($hsl->nilai,2,",",".");
                        echo "Rp. ".$rupiah;
                    ?>
                </td>
                <td>
                    <?php if(@$_SESSION['user']=="pengelola"){ ?>
                    <span class="campurkan garisbawah" idsimpan="<?php echo $hsl->id_simpanan; ?>">INLCUDE</span>
                    <?php }elseif(@$_SESSION['user']=="ketua" || $_SESSION['bagian_umum']=="bagian umum"){echo "BELUM LUNAS"; } ?>
                </td>
            </tr>
<?php }?>
         </tbody>
         <tfoot>
             <tr>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td style="opacity:0.4">--Pilih--</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
             </tr>
         </tfoot>
        </table>
    </div>
    <hr>    
</div>
<!-- END TAGIHAN SEBELUMNY -->
<!-- BEGIN BUAT DAFTAR TAGIH -->
<?php if(@$_SESSION['user']=="pengelola"){ ?>
<button id="buat_dftr_simpan" class="tombol" style="padding: 10px; height: 50px; margin-bottom: 5px;">BUAT DAFTAR TAGIHAN</button>
<a href="http://localhost/kopsyah/c_simpanan/print_daftar_tagihan" class="cetak_dftr_tagih">
   <img src="<?php echo base_url(); ?>css/images/icon/panah-icon.jpg" title="Silahkan print daftar tagihan" />
</a>
<?php } ?>
<div id="box_buat_simpan" style="margin-top: 5px; display: none;">  
    <div class="box_form" id="fmdftrtagih" style="width: 300px; margin-top: 15px;">
        <h3>FORM PEMBUATAN DAFTAR TAGIHAN</h3> 
        <?php
        $attr = array("id"=>"idformdftr");
        echo form_open("c_simpanan/tambah_daftar_simpanan",$attr); ?>
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
<p style="color:brown; font-size:14px;"><b>Sebelumnya Anda telah Membuat Daftar Tagih Pada periode : <?php echo $periode; ?></b></p>
<div class="box_tabel" style="margin-top: 25px;">
    <h3>TABEL DAFTAR TAGIH</h3>
<table border="1" id="filter_daftr_tagih">
    <thead>
            <tr>
                <th width="20">NO.</th>
                <th width="100">ID<br>SIMPANAN</th>
                <th width="100">ID<br>ANGGOTA</th>
                <th>NAMA ANGGOTA</th>
                <th width="100">TANGGAL<br>BUAT</th>
                <th width="170">JENIS<br>SIMPANAN</th>
                <th width="100">NILAI</th>
                <th width="70">STATUS TUNGGU</th>
            </tr>
     </thead>
     <tbody>
<?php 
$no = 1;
foreach ($hasil->result() as $data ) {?>            
            <tr>
                <td align="center"><?php echo $no++.".";?></td>
                <td align="center"><?php echo $data->id_simpanan; ?></td>
                <td align="center"><?php echo $data->id_anggota; ?></td>
                <td><?php echo $data->nama_anggota; ?></td>
                <td align="center"><i><?php echo $data->tgl_pembuatan; ?></i></td>
                <td><?php echo $data->jenis_simpanan; ?></td>
                <td align="right">
                    <?php 
                        $rupiah2 = number_format($data->nilai,2,",",".");
                        echo "Rp. ".$rupiah2;
                    ?>
                </td>
                <?php if(@$_SESSION['user']=="pengelola"){ ?>
                <td align="center">
                    <a href="" idstatus="<?php echo $data->id_simpanan;?>" statustagih="<?php echo $data->status; ?>" class="update_status_lunas" id="id_<?php echo $data->id_simpanan;?>"> 
                     <?php
                        if($data->status==0){
                            echo "<img src='".base_url()."css/images/icon/warning-icon.jpg' width='20' title='sedang diproses..' />";
                        }else{
                            echo "<img src='".base_url()."css/images/icon/valid-icon.jpg' width='20' title='selesai' />";
                        }        
                    ?>      
                    </a>
                </td>
                <?php }elseif(@$_SESSION['user']=="ketua" || $_SESSION['bagian_umum']=="bagian umum"){ ?>
                <td align="center">
                    <?php if($data->status==0){echo "PROSES..";}else{echo "SELESAI"; }?>
                </td>
                <?php } ?>
            </tr>
<?php }?>
    </tbody>
    <tfoot>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="opacity: 0.5">-- pilih -- </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </tfoot>
</table>
</div>
<?php if(@$_SESSION['user']=="pengelola"){ ?>
<button class="tombol" id="tombol_transaksi">INPUT TANGGAL TRANSAKSI</button>
<?php } ?>
<div class="box_form" id="box_transaksi_simpan">
    <h3>FORM TRANSAKSI</h3>
    <?php 
    $atribut = array("id"=>"filter_transaksi_simpan");    
    echo form_open("c_simpanan/input_transaksi_simpanan",$atribut); ?>
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




