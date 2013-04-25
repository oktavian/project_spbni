<?php

class M_pinjaman extends CI_Model {
    
    function debet_piutang($id_trans,$keterangan,$nominal){
        $query = $this->db->query("INSERT into jurnal_umum(kode_akun,id_transaksi,urutan_akun,keterangan,debet,kredit)
                                   VALUES('1.140',$id_trans,1,'$keterangan',$nominal,0)
                                  ");
        return $query;
    }
    
    function kredit_kas($id_trans,$keterangan,$nominal){
        $query = $this->db->query("INSERT into jurnal_umum(kode_akun,id_transaksi,urutan_akun,keterangan,debet,kredit)
                                   VALUES('1.110',$id_trans,2,'$keterangan',0,$nominal)
                                  ");
        return $query;
    }
    
    function pilih_anggota($autocari){
        $query = $this->db->query("SELECT CONCAT(id_anggota,'_',nama_anggota) AS pilihan
                                   FROM tbl_anggota 
                                   WHERE CONCAT(id_anggota,'_',nama_anggota) LIKE '%$autocari%'");
    
        return $query;
    }
    
    function cari_anggota($id){
        $query = $this->db->query("SELECT*FROM tbl_anggota WHERE id_anggota='$id'");
        return $query;
    }
    
    function hitung_total_simpanan(){
        $query = $this->db->query("SELECT SUM(nilai) as total FROM tbl_simpanan_rutin
                                   WHERE id_transaksi IS NOT NULL
                                   AND status_lunas = 1");
        return $query;
    }
    
    function hitung_total_wajib($id){
        $query = $this->db->query("SELECT SUM(nilai) AS tot_wajib FROM tbl_simpanan_rutin
                                   WHERE id_transaksi IS NOT NULL 
                                   AND status_lunas = 1
                                   AND jenis_simpanan = 'simpanan wajib'
                                   AND id_anggota = '$id' 
                                   GROUP BY id_anggota
                                  ");
        return $query;
    }
    
    function hitung_total_mdh($id){
        $query = $this->db->query("SELECT SUM(nilai) AS tot_mdh FROM tbl_simpanan_rutin
                                   WHERE id_transaksi IS NOT NULL 
                                   AND status_lunas = 1
                                   AND jenis_simpanan = 'simpanan mudharabah'
                                   AND id_anggota = '$id' 
                                   GROUP BY id_anggota
                                  ");
        return $query;
    }
    
    function ambil_id_max(){
        $query = $this->db->query("SELECT max(id_pinjaman) AS max_id FROM tbl_pinjaman");
        return $query;
    }
    
    function lihat_status_pegawai($idanggota){
        $query = $this->db->query("SELECT status_pegawai FROM tbl_anggota
                                   WHERE id_anggota = '$idanggota'
                                  ");
        
        return $query->row();
    }
    
    function input_tgl_transaksi($tglpinjam){
        $query = $this->db->query("INSERT into tbl_transaksi(nama_transaksi,tanggal)
                                   values('pemberian pinjaman','$tglpinjam')
                                  ");
        return $query;
    }
    
    function maxidtrans(){
         $query = $this->db->query("SELECT LAST_INSERT_ID() AS id");
         return $query->row();
    }
    
    function masukan_data_pinjaman($kodepinjam,$id_transaksi,$idanggota,$nominal,$jmlangsur,$margin,$pokok){
        $query = $this->db->query("INSERT into tbl_pinjaman(id_pinjaman,id_transaksi,id_anggota,nominal_pinjaman,jml_angsuran,jml_margin,nominal_angsuran,acc,status_pembayaran)
                                   VALUES('$kodepinjam','$id_transaksi','$idanggota',$nominal,$jmlangsur,'$margin',$pokok,0,'belum lunas')
                                   ");
        
        return $query;
    }
    
    function ambil_transaksi_pinjaman($kodepinjam,$tgl_awal,$tgl_ahkir){
        $query = $this->db->query("(SELECT p.id_pinjaman AS id_pinjaman, p.id_transaksi AS id_transaksi, p.id_anggota AS id_anggota,
                                   a.nama_anggota AS nama_anggota, t.tanggal AS tanggal_pinjam, p.nominal_pinjaman AS nominal_pinjaman,p.acc AS acc,
                                   p.jml_angsuran AS jml_angsuran,p.jml_margin AS jml_margin, p.nominal_angsuran AS nominal_angsuran,
                                   p.pembayaran_ke AS pembayaran_ke, p.status_pembayaran AS status_pembayaran
                                   FROM tbl_pinjaman p,tbl_transaksi t, tbl_anggota a
                                   WHERE t.tanggal >='$tgl_awal' 
                                   AND t.tanggal <='$tgl_ahkir'
                                   AND p.id_anggota = a.id_anggota
                                   AND p.id_transaksi = t.id_transaksi)
                                   UNION 
                                   (SELECT p.id_pinjaman AS id_pinjaman, p.id_transaksi AS id_transaksi, p.id_anggota AS id_anggota,
                                   a.nama_anggota AS nama_anggota, t.tanggal AS tanggal_pinjam, p.nominal_pinjaman AS nominal_pinjaman,p.acc AS acc,
                                   p.jml_angsuran AS jml_angsuran,p.jml_margin AS jml_margin, p.nominal_angsuran AS nominal_angsuran,
                                   p.pembayaran_ke AS pembayaran_ke, p.status_pembayaran AS status_pembayaran
                                   FROM tbl_pinjaman p,tbl_transaksi t, tbl_anggota a
                                   WHERE p.id_pinjaman='$kodepinjam' 
                                   AND p.id_anggota = a.id_anggota
                                   AND p.id_transaksi = t.id_transaksi
                                   ORDER by p.id_anggota)
                                  ");
        return $query;
    }
    
    function ambil_detail_pinjaman_acc($idpinjam){
        $query = $this->db->query("SELECT p.id_transaksi  AS id_transaksi,t.tanggal AS tanggal, a.nama_anggota AS nama_anggota,
                                   p.nominal_pinjaman AS nominal_pinjaman
                                   FROM tbl_pinjaman p, tbl_transaksi t, tbl_anggota a
                                   WHERE p.id_pinjaman = '$idpinjam'
                                   AND p.id_transaksi = t.id_transaksi
                                   AND p.id_anggota = a.id_anggota 
                                  ");
        return $query->row();
    }
        
    function update_status_acc($idpinjam){
        $query = $this->db->query("UPDATE tbl_pinjaman SET acc=0 WHERE id_pinjaman='$idpinjam'");
        return $query;
    }
    
    function update_status_blm_acc($idpinjam){
        $query = $this->db->query("UPDATE tbl_pinjaman SET acc=1 WHERE id_pinjaman='$idpinjam'");
        return $query;
    }
    
    

    
}

?>
