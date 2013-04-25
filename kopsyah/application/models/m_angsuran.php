<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_angsuran
 *
 * @author benny
 */
class M_angsuran extends CI_Model{
    
    function masuk_kas($id_trans,$keterangan,$angsur_all){
        $query = $this->db->query("INSERT into jurnal_umum(kode_akun,id_transaksi,urutan_akun,keterangan,debet,kredit)
                                   VALUES('1.110',$id_trans,1,'$keterangan',$angsur_all,0)
                                  ");
        return $query;
    }
    
    function masuk_piutang($id_trans,$keterangan,$pokok){
        $query = $this->db->query("INSERT into jurnal_umum(kode_akun,id_transaksi,urutan_akun,keterangan,debet,kredit)
                                   VALUES('1.140',$id_trans,2,'$keterangan',0,$pokok)
                                  ");
        return $query;
    }
    
    function masuk_pendapatan_margin($id_trans,$keterangan,$margin){
        $query = $this->db->query("INSERT into jurnal_umum(kode_akun,id_transaksi,urutan_akun,keterangan,debet,kredit)
                                   VALUES('7.20',$id_trans,3,'$keterangan',0,$margin)
                                  ");
        return $query;
    }
    
    function tgl_tgh_skrng(){
        $query = $this->db->query("SELECT max(tgl_buat) as tgl_buat 
                                   FROM tbl_angsuran_rutin
                                   WHERE sts_tunggu = 1 
                                   AND sts_lunas = 0");
        
        return $query->row();  
    }
    
     function tgl_tgh_pernah(){
        $query = $this->db->query("SELECT max(tgl_buat) as tgl_buat_now 
                                   FROM tbl_angsuran_rutin");
        
        return $query->row();  
    }
    
    
    function maxidtrans(){
         $query = $this->db->query("SELECT LAST_INSERT_ID() AS id");
         return $query->row();
    }
    
    function ambil_max_tambah($idpinjaman){
        $query = $this->db->query("SELECT max(id_angsuran) AS maxid from tbl_angsuran_rutin WHERE id_pinjaman='$idpinjaman'");
    }
    
    
    function ambil_tbl_pinjaman(){
        $query = $this->db->query("SELECT*from tbl_pinjaman WHERE acc=1 AND status_pembayaran='belum lunas'");
        return $query;
    }
        
    function daftar_angsuran($idpinjaman,$tglbuat,$jml_pembayaran,$sisa_pembayaran,$sisa_ulang){
        $query = $this->db->query("INSERT into tbl_angsuran_rutin(id_pinjaman,tgl_buat,jumlah_bayar,sisa_jml_bayar,sisa_byr_ulang,
                                   sts_tunggu,sts_lunas) VALUE('$idpinjaman','$tglbuat',$jml_pembayaran,$sisa_pembayaran,$sisa_ulang,0,0)");
        return $query;
    }
    

    
    function ambil_daftar_angsuran(){
        $query = $this->db->query("SELECT p.id_pinjaman AS id_pinjaman, ang.id_angsuran AS id_angsuran, p.id_anggota AS id_anggota,
                                   ang.tgl_buat AS tgl_pembuatan, p.pembayaran_ke AS pembayaran_ke, ang.sisa_byr_ulang AS sisa_byr_ulang,
                                   ang.jumlah_bayar AS jumlah_bayar, ang.sisa_jml_bayar AS sisa_jml_bayar, ang.sts_tunggu AS sts_tunggu
                                   FROM tbl_pinjaman p, tbl_angsuran_rutin ang
                                   WHERE ang.sts_lunas = 0
                                   AND ang.id_transaksi IS NULL
                                   AND ang.id_pinjaman = p.id_pinjaman 
                                   ORDER BY ang.tgl_buat DESC
                                  ");
        
        return $query;
    }
    
    function ambil_daftar_sebelumnya($tgl_tagih_skrng){
        $query = $this->db->query("SELECT p.id_pinjaman AS id_pinjaman, ang.id_angsuran AS id_angsuran, p.id_anggota AS id_anggota, 
                                   a.nama_anggota AS nama_anggota, ang.tgl_buat AS tgl_pembuatan, p.pembayaran_ke AS pembayaran_ke, 
                                   ang.sisa_byr_ulang AS sisa_byr_ulang, ang.jumlah_bayar AS jumlah_bayar, ang.sisa_jml_bayar AS sisa_jml_bayar, 
                                   ang.sts_tunggu AS sts_tunggu
                                   FROM tbl_pinjaman p, tbl_angsuran_rutin ang, tbl_anggota a
                                   WHERE ang.sts_lunas = 0
                                   AND ang.sts_tunggu = 1
                                   AND ang.tgl_buat <='$tgl_tagih_skrng->tgl_buat'
                                   AND ang.id_transaksi IS NOT NULL
                                   AND ang.id_pinjaman = p.id_pinjaman
                                   AND p.id_anggota = a.id_anggota
                                  ");
        
        return $query;
    }
    
    function ubah_status_tunggu1($idangsuran){
        $query = $this->db->query("UPDATE tbl_angsuran_rutin SET sts_tunggu=0 
                                   WHERE id_angsuran = $idangsuran
                                  ");
        return $query;
    }
    
    function ubah_status_tunggu2($idangsuran){
        $query = $this->db->query("UPDATE tbl_angsuran_rutin SET sts_tunggu=1 
                                   WHERE id_angsuran = $idangsuran
                                  ");
        return $query;
    }
    
    function tambah_transaksi_angsur($tgl_transaksi){
        $query = $this->db->query("INSERT into tbl_transaksi(tanggal,nama_transaksi) values('$tgl_transaksi','pembayaran angsuran')");
        return $query;
    }
    
    function simpan_transaksi_angsuran($id){
        $query = $this->db->query("UPDATE tbl_angsuran_rutin 
                                   SET id_transaksi='$id'
                                   WHERE sts_tunggu=1
                                   AND sts_lunas=0
                                   AND id_transaksi IS NULL");
        return $query;
    }
    
    function ambil_status_angsur_belum_lunas(){
        $query = $this->db->query("SELECT a.id_angsuran AS id_angsuran, a.id_pinjaman AS id_pinjaman, t.tanggal AS tanggal_transaksi,
                                   a.tgl_buat AS tgl_buat, a.jumlah_bayar AS jml_byr, a.sisa_jml_bayar AS sisa, a.sisa_byr_ulang AS sisa_byr,
                                   p.id_anggota, agt.nama_anggota AS nama_anggota, a.sts_lunas AS status_lunas
                                   FROM tbl_anggota agt, tbl_pinjaman p, tbl_angsuran_rutin a, tbl_transaksi t
                                    WHERE a.sts_lunas = 0
                                    AND a.sts_tunggu = 1
                                    AND a.id_transaksi IS NOT NULL
                                    AND a.id_transaksi = t.id_transaksi
                                    AND a.id_pinjaman = p.id_pinjaman
                                    AND p.id_anggota = agt.id_anggota
                                  ");
        return $query; 
    } 
    
    function ambil_angsuran_lunas($idangsur){
        $query = $this->db->query("SELECT a.id_transaksi AS id_transaksi,t.tanggal AS tanggal, a.jumlah_bayar AS jumlah_bayar, 
                                   p.nominal_angsuran AS nominal_angsuran,agt.nama_anggota
                                   FROM tbl_angsuran_rutin a, tbl_transaksi t, tbl_pinjaman p, tbl_anggota agt
                                   WHERE a.id_angsuran=$idangsur
                                   AND a.id_transaksi = t.id_transaksi
                                   AND a.id_pinjaman = p.id_pinjaman
                                   AND p.id_anggota = agt.id_anggota
                                   ");
        return $query->row();
    }
    
    function ambil_transaksi_angsuran($tgl_awal,$tgl_ahkir){
        $query = $this->db->query("SELECT a.id_pinjaman AS id_pinjaman, a.id_angsuran AS id_angsuran, p.id_anggota, 
                                   agt.nama_anggota AS nama_anggota, a.tgl_buat AS tgl_buat, t.tanggal AS tanggal_transaksi,
                                   a.jumlah_bayar AS jumlah_bayar, a.sisa_jml_bayar AS sisa_bayar, a.sisa_byr_ulang AS sisa
                                   FROM tbl_anggota agt, tbl_pinjaman p, tbl_angsuran_rutin a, tbl_transaksi t
                                   WHERE a.sts_lunas = 1
                                   AND t.tanggal>='$tgl_awal'
                                   AND t.tanggal<='$tgl_ahkir'
                                   AND a.id_transaksi = t.id_transaksi
                                   AND a.id_pinjaman = p.id_pinjaman
                                   AND p.id_anggota = agt.id_anggota
                                  ");
        return $query;
    }
    
    function update_lunas_angsuran($idangsur){
        $query = $this->db->query("UPDATE tbl_angsuran_rutin SET sts_lunas=1
                                   WHERE id_angsuran=$idangsur
                                   AND id_transaksi IS NOT NULL
                                  ");
        return $query;
    }
    
    function pilih_pinjaman($idpinjam){
        $query = $this->db->query("SELECT*FROM tbl_pinjaman WHERE id_pinjaman='$idpinjam'");
        return $query->row();
    }
 
    function pilih_angsuran($idpinjam){
        $query = $this->db->query("SELECT sisa_byr_ulang AS sisa_jml
                                   FROM tbl_angsuran_rutin
                                   WHERE sts_lunas =1
                                   AND id_transaksi IS NOT NULL
                                   AND sts_tunggu =1
                                   AND id_pinjaman = '$idpinjam'
                                  ");
        return $query;
    }
    
    function update_jml_pembayaran_ke($idpinjam,$pembayaran_ke){
        $query = $this->db->query("UPDATE tbl_pinjaman SET pembayaran_ke=$pembayaran_ke,
                                   status_pembayaran='belum lunas' 
                                   WHERE id_pinjaman='$idpinjam'
                                  ");
        return $query;
    }
    
    function update_lunas_pinjaman($idpinjam,$pembayaran_ke){
        $query = $this->db->query("UPDATE tbl_pinjaman SET status_pembayaran='lunas',
                                   pembayaran_ke=$pembayaran_ke 	
                                   WHERE id_pinjaman='$idpinjam' 
                                  ");
        return $query;
    }
    
    function pilih_angsuran_ke($idpinjam){
        $query = $this->db->query("SELECT pembayaran_ke FROM tbl_pinjaman WHERE id_pinjaman ='$idpinjam'");
        return $query->row();
    }
     
    function max_angsuran($idpinjam){
        $query = $this->db->query("SELECT p.jml_angsuran AS jml_angsuran, a.jumlah_bayar AS jumlah_bayar, 
                                   a.sisa_jml_bayar AS sisa_bayar, a.sisa_byr_ulang AS sisa_jml, p.pembayaran_ke AS pembayaran_ke
                                   FROM tbl_angsuran_rutin a, tbl_pinjaman p
                                   WHERE a.sts_lunas = 0
                                   AND a.id_transaksi IS NULL
                                   AND a.id_pinjaman = '$idpinjam'
                                   AND a.id_pinjaman = p.id_pinjaman
                                  ");
    
        return $query;
    }
    
    function detail_angsur($idinclude){
        $query = $this->db->query("SELECT p.jml_angsuran AS jml_angsuran, a.jumlah_bayar AS jumlah_bayar, 
                                   p.status_pembayaran AS status_pembayaran, a.sisa_jml_bayar AS sisa_bayar, 
                                   a.sisa_byr_ulang AS sisa_jml, p.pembayaran_ke AS pembayaran_ke
                                   FROM tbl_angsuran_rutin a, tbl_pinjaman p
                                   WHERE a.id_angsuran = $idinclude
                                   AND a.id_pinjaman = p.id_pinjaman
                                  ");
    
        return $query;
    }
    
    function hapus_include($idinclude){
        $query = $this->db->query("DELETE FROM tbl_angsuran_rutin WHERE id_angsuran=$idinclude");
        return $query;
    }
    
    function hapus_angsur_tambah($idtambah){
        $query = $this->db->query("DELETE FROM tbl_angsuran_rutin WHERE id_angsuran='$idtambah'");
        return $query;
    }
    

    function masukan_daftar_tagih($idinclude,$sisa_pembayaran,$sisa_ulang){
        $query = $this->db->query("UPDATE tbl_angsuran_rutin SET sisa_jml_bayar=$sisa_pembayaran,sisa_byr_ulang=$sisa_ulang,
                                   id_transaksi=NULL,sts_tunggu=0
                                   WHERE id_angsuran=$idinclude
                                   ");
    
        return $query;
    }
    
    function list_angsuran($idpinjaman){
        $query = $this->db->query("SELECT*FROM tbl_angsuran_rutin 
                                   WHERE sts_lunas=0
                                   AND id_transaksi IS NULL
                                   AND id_pinjaman='$idpinjaman'
                                  ");
        return $query;
    }
    
    function list_angsuran2($idpinjaman){
        $query = $this->db->query("SELECT*FROM tbl_angsuran_rutin
                                   WHERE sts_lunas=1
                                   AND id_transaksi IS NULL
                                   AND id_pinjaman='$idpinjaman'
                                  ");
        return $query;
    }

}

?>
