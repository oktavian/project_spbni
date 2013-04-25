<div class="box_form kiri" style="width: 450px;">
    <h3>FORM PINJAMAN</h3>
<?php echo form_open("c_pinjaman/tambah_pinjaman"); ?>    
    <table class="tbl_fm">
        <tr>
            <td>Anggota</td>
            <td>:</td>
            <td>
                <input type="text" name="anggota" id="anggota" />
                <input type="hidden" name="idanggota" id="idanggota"/>
            </td>
            <td id="anggota_pesan">
                <span class="error">tidak boleh kosong</span>
                <span class="valid"><img src="<?php echo base_url(); ?>css/images/icon/oke.jpg" height="20" /></span>
            </td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td><input type="text" name="tgl_pinjam" id="tgl_pinjam" class="tgl" size="8" /></td>
            <td id="tgl_pinjam_pesan">
                <span class="error">tidak boleh kosong</span>
                <span class="valid"><img src="<?php echo base_url(); ?>css/images/icon/oke.jpg" height="20" /></span>
            </td>
        </tr>
        <tr>
            <td>Nominal</td>
            <td>:</td>
            <td>
                <input type="text" name="nominal" id="nominal" size="10" />
                <input type="hidden" name="hdnominal" id="hdnominal" size="10" />
            </td>
            <td id="nominal_pesan">
                <span class="error">tidak boleh kosong</span>
                <span class="valid"><img src="<?php echo base_url(); ?>css/images/icon/oke.jpg" height="20" /></span>
            </td>
        </tr>
        <tr>
            <td>Jumlah Anggsuran</td>
            <td>:</td>
            <td>
                <select name="jmlangsur" id="jmlangsur">
                    <option value="">--pilih--</option>
                    <?php for($i=1; $i<=40; $i++){ echo "<option value='$i'>$i kali</option>";}?>
                </select>
            </td>
            <td id="jmlangsur_pesan">
                <span class="error">tidak boleh kosong</span>
                <span class="valid"><img src="<?php echo base_url(); ?>css/images/icon/oke.jpg" height="20" /></span>
            </td>
        </tr>
        <tr id="munculjml" style="display:none;">
            <td>Angsuran</td>
            <td>:</td>
            <td>
                <input type="text" name="jml_angsuran" id="jml_angsuran" size="20" />
                <input type="hidden" name="hdjml_angsuran" id="hdjml_angsuran" size="10" />
            </td>
        </tr>
        <tr>
            <td colspan="4" align="right">
                <input type="submit" value="simpan" class="tombol_pinjam" />
                <input type="reset" value="batal" class="btl_tombol" />
            </td>
        </tr>
    </table>
    <?php echo form_close(); ?>
</div>
<div id="ket_peminjam" style="margin-left:510px; width: 750px;"></div>
<div class="clear"></div>