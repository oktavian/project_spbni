<div class="box_form" style="width: 600px;">
<h3>FORM TAMBAH ANGGOTA</h3>    
<?php 
$attribut = array("id"=>"formanggota");
echo form_open("c_anggota/proses_add_anggota",$attribut); ?>
<table class="tbl_fm">
    <tr>
        <td>No. Pegawai</td>
        <td>:</td>
        <td>
            <input type="text" name="ididentitas" id="ididentitas" size="8" />
        </td>
        <td class="ididentitas_pesan">
            <span class="error">tidak boleh kosong</span>
            <span class="valid"><img src="<?php echo base_url(); ?>css/images/icon/oke.jpg" height="20" /></span>
        </td>
    </tr>
    <tr>
        <td>Nama Anggota</td>
        <td>:</td>
        <td>
            <input type="text" name="nmanggota" id="nmanggota" />
        </td>
        <td class="nmanggota_pesan">
            <span class="error">tidak boleh kosong</span>
            <span class="valid"><img src="<?php echo base_url(); ?>css/images/icon/oke.jpg" height="20" /></span>
        </td>
    </tr>
    <tr>
        <td>Tgl Masuk</td>
        <td>:</td>
        <td>
            <input type="text" name="tglmasuk" id="tglmasuk" class="tgl" size="8" tidakvalid="yes" />
        </td>
        <td class="tglmasuk_pesan">
            <span class="error">tidak boleh kosong</span>
            <span class="valid"><img src="<?php echo base_url(); ?>css/images/icon/oke.jpg" height="20" /></span>
        </td>
    </tr>
    <tr>
        <td>Tgl Lahir</td>
        <td>:</td>
        <td>
            <input type="text" name="tgllahir" id="tgllahir" class="tgl" size="8" tidakvalid="yes" />
        </td>
        <td class="tgllahir_pesan">
            <span class="error">tidak boleh kosong</span>
            <span class="valid"><img src="<?php echo base_url(); ?>css/images/icon/oke.jpg" height="20" /></span>
        </td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>
            <textarea name="almt" id="almt"></textarea>
        </td>
        <td class="almt_pesan">
            <span class="error">tidak boleh kosong</span>
            <span class="valid"><img src="<?php echo base_url(); ?>css/images/icon/oke.jpg" height="20" /></span>
        </td>
    </tr>
    <tr>
        <td>No. telp</td>
        <td>:</td>
        <td>
            <input type="text" name="tlp" id="tlp" size="10" />
        </td>
        <td class="tlp_pesan">
            <span class="error">tidak boleh kosong</span>
            <span class="valid"><img src="<?php echo base_url(); ?>css/images/icon/oke.jpg" height="20" /></span>
        </td>
    </tr>
    <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td>
            <input type="text" name="jbt" id="jbt" />
        </td>
        <td class="jbt_pesan">
            <span class="error">tidak boleh kosong</span>
            <span class="valid"><img src="<?php echo base_url(); ?>css/images/icon/oke.jpg" height="20" /></span>
        </td>
    </tr>
    <tr>
        <td>Status Pegawai</td>
        <td>:</td>
        <td>
            <select name="sts" id="sts">
                <option value="">--pilih--</option>
                <option value="outsourcing">Outsourcing</option>
                <option value="tetap">Tetap</option>
            </select>
        </td>
        <td class="sts_pesan">
            <span class="error">harus dipilih</span>
            <span class="valid"><img src="<?php echo base_url(); ?>css/images/icon/oke.jpg" height="20" /></span>
        </td>
    </tr>
    <tr>
        <td>Estimasi Byr</td>
        <td>:</td>
        <td>
            <input type="text" name="estimasi" id="estimasi" size="10" value="-" />
        </td>
        <td class="estimasi_pesan">
            <span class="error">maximal nominal 3000000 (optional)</span>
            <span class="valid"><img src="<?php echo base_url(); ?>css/images/icon/oke.jpg" height="20" /></span>
        </td>
    </tr>
    <tr>
        <td colspan="3" align="center">
            <input type="submit" name="simpan" value="simpan" class="submit"/>
            <input type="reset" value="batal"/>
        </td>
    </tr>
</table>
<?php echo form_close(); ?>
</div>