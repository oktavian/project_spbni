<div class="box_tabel">
    <h3>Tabel Pelunasan</h3>
    <table border="1" id="filter_lunas_angsur">
    <thead>    
        <tr>
            <th width="20">NO.</th>
            <th width="80">ID<br>PINJAMAN</th>
            <th width="80">ID<br>ANGSUR</th>
            <th width="80">ID<br>ANGGOTA</th>
            <th width="300">NAMA ANGGOTA</th>
            <th>TGL<br>BUAT</th>
            <th>TGL<br>TRANSAKSI</th>
            <th>JUMLAH<br>BAYAR</th>
            <th>AKSI</th>
        </tr>
     </thead>
     <tbody>
<?php 
$no = 1;
foreach($hasil->result() as $data){ ?>         
        <tr>
            <td align="center"><?php echo $no++."."; ?></td>
            <td align="center"><?php echo $data->id_pinjaman; ?></td>
            <td align="center"><?php echo $data->id_angsuran; ?></td>
            <td align="center"><?php echo $data->id_anggota; ?></td>
            <td><?php echo $data->nama_anggota; ?></td>
            <td align="center"><?php echo $data->tgl_buat; ?></td>
            <td align="center"><?php echo $data->tanggal_transaksi;?></td>
            <td align="right">
                <?php
                $rupiah = number_format($data->jml_byr,2,",",".");
                echo "Rp. ".$rupiah; 
                ?>
            </td>
            <td align="center"><span class="ganti_status garisbawah" idangsur="<?php echo $data->id_angsuran; ?>" idpinjam="<?php echo $data->id_pinjaman; ?>">
                    BELUM LUNAS
                </span>
            </td>
        </tr>
<?php } ?>        
     </tbody>
    </table>
</div>