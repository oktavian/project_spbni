<div class="box_form" style="width: 600px;">
<h3>FORM EDIT ANGGOTA</h3>    
<?php echo form_open("c_anggota/proses_edit_anggota"); ?>
<table class="tbl_fm">
    <tr>
        <td>No. Pegawai</td>
        <td>:</td>
        <td>
            <input type="text" name="ididentitas" id="ididentitas" size="8" value="<?php echo $editan->id_identitas; ?>" />
            <input type="hidden" name="idgta" id="idgta" size="8" value="<?php echo $editan->id_anggota; ?>" />
        </td>
        <td class="ididentitas_pesan">
            <span class="error"></span>
            <span class="valid"><img src="<?php echo base_url(); ?>css/images/icon/oke.jpg" height="20" /></span>
        </td>
    </tr>
    <tr>
        <td>Nama Anggota</td>
        <td>:</td>
        <td>
            <input type="text" name="nmanggota" id="nmanggota" value="<?php echo $editan->nama_anggota; ?>" />
        </td>
        <td class="nmanggota_pesan">
            <span class="error"></span>
            <span class="valid"><img src="<?php echo base_url(); ?>css/images/icon/oke.jpg" height="20" /></span>
        </td>
    </tr>
    <tr>
        <td>Tgl Masuk</td>
        <td>:</td>
        <td>
            <input type="text" name="tglmasuk" id="tglmasuk" class="tgl" size="8" value="<?php echo $editan->tgl_masuk; ?>" />
        </td>
        <td class="tglmasuk_pesan">
            <span class="error"></span>
            <span class="valid"><img src="<?php echo base_url(); ?>css/images/icon/oke.jpg" height="20" /></span>
        </td>
    </tr>
    <tr>
        <td>Tgl Lahir</td>
        <td>:</td>
        <td>
            <input type="text" name="tgllahir" id="tgllahir" class="tgl" size="8" value="<?php echo $editan->tgl_lahir; ?>" />
        </td>
        <td class="tgllahir_pesan">
            <span class="error"></span>
            <span class="valid"><img src="<?php echo base_url(); ?>css/images/icon/oke.jpg" height="20" /></span>
        </td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>
            <textarea name="almt" id="almt"><?php echo $editan->alamat; ?></textarea>
        </td>
        <td class="almt_pesan">
            <span class="error"></span>
            <span class="valid"><img src="<?php echo base_url(); ?>css/images/icon/oke.jpg" height="20" /></span>
        </td>
    </tr>
    <tr>
        <td>No. telp</td>
        <td>:</td>
        <td>
            <input type="text" name="tlp" id="tlp" size="10" value="<?php echo $editan->no_telp; ?>" />
        </td>
        <td class="tlp_pesan">
            <span class="error"></span>
            <span class="valid"><img src="<?php echo base_url(); ?>css/images/icon/oke.jpg" height="20" /></span>
        </td>
    </tr>
    <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td>
            <input type="text" name="jbt" id="jbt" value="<?php echo $editan->jabatan; ?>" />
        </td>
        <td class="jbt_pesan">
            <span class="error"></span>
            <span class="valid"><img src="<?php echo base_url(); ?>css/images/icon/oke.jpg" height="20" /></span>
        </td>
    </tr>
    <tr>
        <td>Status Pegawai</td>
        <td>:</td>
        <td>
            <select name="sts" id="sts">
                <?php 
                    if($editan->id_identitas=="tetap"){
                        $ttp = "selected";
                        $out = "";
                    }else{
                        $ttp = "";
                        $out = "selected";
                    }
                ?>
                <option value="">--pilih--</option>
                <option value="outsourcing" <?php echo $out; ?> >Outsourcing</option>
                <option value="tetap" <?php echo $ttp; ?> >Tetap</option>
            </select>
        </td>
        <td class="sts_pesan">
            <span class="error"></span>
            <span class="valid"><img src="<?php echo base_url(); ?>css/images/icon/oke.jpg" height="20" /></span>
        </td>
    </tr>
    <tr>
        <td>Estimasi Byr</td>
        <td>:</td>
        <td>
            <input type="text" name="estimasi" id="estimasi" size="10" value="<?php echo $editan->estimasi_byr; ?>"/>
        </td>
        <td class="estimasi_pesan">
            <span class="error">maximal nominal 3000000 (optional)</span>
            <span class="valid"><img src="<?php echo base_url(); ?>css/images/icon/oke.jpg" height="20" /></span>
        </td>
    </tr>
    <tr>
        <td colspan="3" align="center">
            <input type="submit" name="simpan" value="simpan"/>
            <input type="reset" value="batal"/>
        </td>
    </tr>
</table>
<?php echo form_close(); ?>
</div>