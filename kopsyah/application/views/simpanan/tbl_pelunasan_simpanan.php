<div class="box_tabel">
    <h3>Tabel Pelunasan</h3>
    <table border="1" id="filter_lunas_simpan">
    <thead>    
        <tr>
            <th width="10">NO.</th>
            <th width="100">ID<br>SIMPANAN</th>
            <th>ID<br>ANGGOTA</th>
            <th>NAMA ANGGOTA</th>
            <th>TGL<br>BUAT</th>
            <th>TGL<br>TRANSAKSI</th>
            <th>JENIS<br>SIMPANAN</th>
            <th>NILAI</th>
            <th>AKSI</th>
        </tr>
     </thead>
     <tbody>
<?php 
$no = 1;
foreach($hasil->result() as $data){ ?>         
        <tr>
            <td align="center"><?php echo $no++."."; ?></td>
            <td><?php echo $data->id_simpanan; ?></td>
            <td><?php echo $data->id_anggota; ?></td>
            <td><?php echo $data->nama_anggota; ?></td>
            <td><?php echo $data->tgl_pembuatan; ?></td>
            <td><?php echo $data->tgl_transaksi; ?></td>
            <td><?php echo $data->jenis_simpanan;?></td>
            <td align="right">
                <?php
                    $rupiah = number_format($data->nilai,2,",",".");
                    echo "Rp. ".$rupiah; 
                ?>
            </td>
            <td><span class="ganti_status garisbawah" idsimpanan="<?php echo $data->id_simpanan; ?>">BELUM LUNAS</span></td>
        </tr>
<?php } ?>        
     </tbody>
     <tfoot>
         <tr>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
             <td style="opacity: 0.4;">--pilih--</td>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
         </tr>
     </tfoot>
    </table>
</div>