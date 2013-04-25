<div id="header">
        <div id="sub_header">
            <img src="<?php echo base_url(); ?>css/images/icon/arrow_down.png" height="20" panah="hijau" id="pencet"><span>Keluarkan Menu</span> |
            <a href="<?php echo base_url(); ?>c_anggota/keluar"><img src="<?php echo base_url(); ?>css/images/icon/logout.png" height="20" ><span>Logout</span></a> |
            <span style="font-weight: bold"> Selamat datang : <?php echo $_SESSION['nama_user']; ?>  </span> |&nbsp;&nbsp;&nbsp;
            <span>
                <?php 
                    if(isset($_SESSION['user'])){
                        echo "Hak Akses = ".$_SESSION['user'];
                    }
                ?>
            </span>
        </div>
        <?php if(isset($_SESSION['anggota_id'])){ ?>
        <div id="menu_utama" style="margin-left:550px;">
            <ul align="center">
                <li><a href="<?php echo base_url(); ?>c_anggota/home_anggota"><br>HOME</a></li>
                <li><a href="<?php echo base_url(); ?>c_anggota/buku_simpanan"><br>SIMPANAN</a></li>
                <li><a href="<?php echo base_url(); ?>c_anggota/buku_pinjaman"><br>PINJAMAN</a></li>
            </ul>
        </div>
        <?php }elseif(@$_SESSION['user']=="pengelola"){ ?>
        <div id="menu_utama" style="display: none;">
            <ul align="center">
                <li><a href="<?php echo base_url(); ?>c_anggota/home"><br>HOME</a></li>
                <li><a href="<?php echo base_url(); ?>c_anggota/tblanggota"><br>ANGGOTA</a></li>
                <li><a href="<?php echo base_url(); ?>c_simpanan/index"><br>SIMPANAN</a></li>
                <li><a href="<?php echo base_url(); ?>c_pinjaman/index"><br>PINJAMAN</a></li>
                <li><a href="<?php echo base_url(); ?>c_angsuran/index"><br>ANGSURAN</a></li>
                <li><a href="<?php echo base_url(); ?>c_laporan/index"><br>LAPORAN</a></li>
            </ul>
        </div>
        <?php  }elseif(isset($_SESSION['bagian_umum'])){ ?>
        <div id="menu_utama" style="display:none;">
            <ul align="center" class="rapikan">
                <li><a href="<?php echo base_url(); ?>c_anggota/home_bagumum"><br>HOME</a></li>
                <li><a href="<?php echo base_url(); ?>c_anggota/tblanggota"><br>ANGGOTA</a></li>
                <li><a href="<?php echo base_url(); ?>c_simpanan/index"><br>SIMPANAN</a></li>
                <li><a href="<?php echo base_url(); ?>c_pinjaman/index"><br>PINJAMAN</a></li>
                <li><a href="<?php echo base_url(); ?>c_angsuran/index"><br>ANGSURAN</a></li>
            </ul>
        </div>    
        <?php }elseif(@$_SESSION['user']=="ketua"){ ?>
        <div id="menu_utama" style="display: none;">
            <ul align="center">
                <li><a href="<?php echo base_url(); ?>c_anggota/home"><br>HOME</a></li>
                <li><a href="<?php echo base_url(); ?>c_anggota/tblanggota"><br>ANGGOTA</a></li>
                <li><a href="<?php echo base_url(); ?>c_simpanan/index"><br>SIMPANAN</a></li>
                <li><a href="<?php echo base_url(); ?>c_pinjaman/index"><br>PINJAMAN</a></li>
                <li><a href="<?php echo base_url(); ?>c_angsuran/index"><br>ANGSURAN</a></li>
                <li><a href="<?php echo base_url(); ?>c_laporan/index"><br>LAPORAN</a></li>
            </ul>
        </div>
        <?php } ?>
</div>