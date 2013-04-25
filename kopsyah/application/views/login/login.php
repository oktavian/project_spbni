<div class="box_keterangan" style="margin: 250px auto; width: 300px;">
    <p class="phead">SILAHKAN LOGIN</p>
<?php echo form_open("c_anggota/index"); ?>    
    <table class="tbl_fm">
        <tr>
            <td>username</td>
            <td>:</td>
            <td><input type="text" name="username" id="username" /></td>
        </tr>
        <tr>
            <td>password</td>
            <td>:</td>
            <td><input type="password" name="pass" id="pass" /></td>
        </tr>
        <tr>
            <td colspan="3" align="right">
                <input type="submit" value="masuk" id="login" />
            </td>
        </tr>
    </table> 
<?php echo form_close(); ?>    
</div>