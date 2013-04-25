<?php $profil = $ketanggota->row(); ?>
<?php $total_simpanan = $kettotsimp->row(); ?>
<?php $total_wajib = $kettotwjb->row(); ?>
<?php $total_mdh = $kettotmdh->row();?>
<script type="text/javascript" src="<?php echo base_url();?>js/js_ajax.js"></script>
<div class="box_keterangan">
    <p class="phead">KETERANGAN PEMINJAM</p>
    <table class="kiri tbl_fm" width="350">
        <tr>
            <td>Id Anggota</td>
            <td>:</td>
            <td><?php echo $profil->id_anggota; ?></td>
        </tr>
        <tr>
            <td>Nama Anggota</td>
            <td>:</td>
            <td><?php echo $profil->nama_anggota; ?></td>
        </tr>
        <tr>
            <td>Tanggal Masuk</td>
            <td>:</td>
            <td><?php echo $profil->tgl_masuk; ?></td>
        </tr>
        <tr>
            <td width="100">Lama Masuk</td>
            <td>:</td>
            <td><?php echo $ketmasuk; ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><?php echo $profil->alamat; ?></td>
        </tr>
        <tr>
            <td>No. Telp</td>
            <td>:</td>
            <td><?php echo $profil->no_telp; ?></td>
        </tr>
        <tr>
            <td>Status Pegawai</td>
            <td>:</td>
            <td><?php echo $profil->status_pegawai; ?></td>
        </tr>
    </table>
    <table class="tbl_fm" style="border: 1px solid red; margin-left: 380px; padding: 5px;" width="350">
        <tr>
            <td width="155">Simpanan Wajib</td>
            <td>:</td>
            <td><?php
                    if($total_wajib->tot_wajib!=0){
                        $rupiah = number_format($total_wajib->tot_wajib,2,",",".");
                        echo "Rp. ".$rupiah;
                    }else{echo "Rp. -"; }
                 ?>
            </td>
        </tr>
        <tr>
            <td>Simpanan Mudharabah</td>
            <td>:</td>
            <td>
                <?php
                    if($total_mdh->tot_mdh!=0){
                        $rupiah2 = number_format($total_mdh->tot_mdh,2,",",".");
                        echo "Rp. ".$rupiah2;
                    }else{echo "Rp. -"; }
                 ?>
            </td>
        </tr>
        <tr>
            <td>Total Simpanan Anggota</td>
            <td>:</td>
            <td>
            <?php 
                $alltotal = $total_wajib->tot_wajib + $total_mdh->tot_mdh;
                if($alltotal!=0){
                    $rupiah3 = number_format($alltotal,2,",",".");
                    echo "Rp. ".$rupiah3;
                }else{echo "Rp. -"; }
                
            ?>
            </td>
        </tr>
        <tr class="font_16" style="color:brown;">
            <td>Total Simpanan Koperasi</td>
            <td>:</td>
            <td>
                <?php
                    if($total_simpanan->total!=0){
                        $rupiah4 = number_format($total_simpanan->total,2,",",".");
                        echo "Rp. ".$rupiah4;
                    }else{echo "Rp. -"; }
                ?>
            </td>
        </tr>
    </table>
    <p class="font_16" style="margin-left: 460px;" id="konfirm">Apakah Anda Yakin Ingin Meminjamkan? 
        <span id="ya">YA</span><span id="tidak" style="margin-left:10px;">TIDAK</span>
    </p>
    <div class="clear"></div>
</div>