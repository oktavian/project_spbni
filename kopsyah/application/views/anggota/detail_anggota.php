<?php $data = $hasil->row(); ?>
<h3 align="center">DETAIL ANGGOTA</h3>
<table>
    <tr>
        <td style="width: 100px;">Id anggota</td>
        <td>:</td>
        <td><?php echo $data->id_anggota; ?></td>
    </tr>
    <tr>
        <td>Id Identitas</td>
        <td>:</td>
        <td><?php echo $data->id_identitas; ?></td>
    </tr>
    <tr>
        <td>Nama</td>
        <td>:</td>
        <td><?php echo $data->nama_anggota; ?></td>
    </tr>
    <tr>
        <td>Tgl. Masuk</td>
        <td>:</td>
        <td><?php echo $data->tgl_masuk; ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td><?php echo $data->alamat; ?></td>
    </tr>
    <tr>
        <td>No. Telp</td>
        <td>:</td>
        <td><?php echo $data->no_telp; ?></td>
    </tr>
    <tr>
        <td>Tgl. Lahir</td>
        <td>:</td>
        <td><?php echo $data->tgl_lahir; ?></td>
    </tr>
    <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td><?php echo $data->jabatan; ?></td>
    </tr>
    <tr>
        <td>Sts Pegawai</td>
        <td>:</td>
        <td><?php echo $data->status_pegawai; ?></td>
    </tr>
    <tr>
        <td>Sts anggota</td>
        <td>:</td>
        <td>
            <?php 
                $sts = $data->status_anggota;
                if($sts==1){
                    echo "aktiv";
                }else{
                    echo "tidak aktif";
                }
            ?>
        </td>
    </tr>
</table>