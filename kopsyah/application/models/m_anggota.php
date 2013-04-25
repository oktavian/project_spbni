<?php
class M_anggota extends CI_Model {
    
    function hitungjmldata(){
        return $this->db->count_all('tbl_anggota');
    }
    
    function allanggota(){        
        $query = $this->db->query("SELECT*FROM tbl_anggota");
        return $query->result();
    }
    
    function select_anggota($akses,$password){
        $query = $this->db->query("SELECT*FROM tbl_anggota 
                                   WHERE id_anggota = '$akses' 
                                   AND id_identitas = '$password'");
        return $query;
    }
    
    function select_pengguna($akses,$password){
        $query = $this->db->query("SELECT*FROM pengguna 
                                   WHERE username = '$akses' 
                                   AND password = '$password'");
        return $query;
    }
    
    function iden_anggota($id){
        $query = $this->db->query("SELECT*FROM tbl_anggota WHERE id_anggota='$id'");
        return $query->row();
    }
    
    function simpananggota($id_anggota,$id_identitas,$nama_anggota,$tgl_masuk,$tgl_lahir,$almt_anggota,$no_telp,$jabatan,$status_peg,$estmasi_byr){
    
      
   
    //2 masukan inputan ke database
        $query = $this->db->query("insert into tbl_anggota(id_anggota,id_identitas,nama_anggota,tgl_masuk,tgl_lahir,alamat,no_telp,jabatan,status_pegawai,estimasi_byr,status_anggota)
                                    values('$id_anggota','$id_identitas','$nama_anggota','$tgl_masuk','$tgl_lahir','$almt_anggota','$no_telp','$jabatan','$status_peg','$estmasi_byr',1)
                                   ");
        
        return $query;     
    }
    
    function dptid(){
        $query = $this->db->query("SELECT max(id_anggota) as max_id FROM tbl_anggota WHERE id_anggota LIKE '%AKN-%'");
        $id = $query->row();

            $nourut = (int) substr($id->max_id, 4,4);
            $nourut++;
            $idanggota = "AKN-".sprintf("%04s", $nourut);
            return $idanggota;

    }

    function editanggota($id_anggota,$id_identitas,$nama_anggota,$tgl_masuk,$tgl_lahir,$almt_anggota,$no_telp,$jabatan,$status_peg,$estmasi_byr){
        
         $query = $this->db->query("UPDATE tbl_anggota SET id_identitas='$id_identitas',
                                     nama_anggota='$nama_anggota',
                                     tgl_masuk='$tgl_masuk',
                                     tgl_lahir='$tgl_lahir',
                                     alamat='$almt_anggota',
                                     no_telp='$no_telp',
                                     jabatan='$jabatan',
                                     status_pegawai='$status_peg',
                                     estimasi_byr='$estmasi_byr'
                                     WHERE id_anggota='$id_anggota'"
                                   );
         
         return $query;
        
    }
    
    function ambilbyid($idanggota){
        $query = $this->db->query("SELECT*from tbl_anggota WHERE id_anggota='$idanggota'");
        return $query->row(); //kembalikan hasilnya
    }
    
    function hapusanggota($idanggota){
        $query = $this->db->query("DELETE from tbl_anggota WHERE id_anggota='$idanggota'");
        return $query;
    }
    
    function ambil_detail_anggota($idanggota){
        $query = $this->db->query("SELECT*from tbl_anggota WHERE id_anggota='$idanggota'");
        return $query;
    }

    function ambil_pinjaman_anggota($id){
        $query = $this->db->query("SELECT p.id_pinjaman AS id_pinjaman, t.tanggal AS tanggal 
                                   FROM tbl_pinjaman p, tbl_transaksi t
                                   WHERE id_anggota = '$id' 
                                   AND p.id_transaksi = t.id_transaksi
                                  ");
        return $query;
    }
    
    function ambil_ket_pinjaman($idpinjam,$id){
        $query = $this->db->query("SELECT a.nama_anggota AS nama_anggota,t.tanggal AS tgl_pinjam, p.id_pinjaman AS id_pinjaman,
                                   p.nominal_pinjaman AS jml_pinjam, p.status_pembayaran AS status, p.jml_angsuran  AS jumlah_angsur,
                                   p.pembayaran_ke AS bayar_ke
                                   FROM tbl_pinjaman p, tbl_anggota a, tbl_transaksi t
                                   WHERE p.id_pinjaman='$idpinjam'
                                   AND p.id_anggota='$id'
                                   AND p.acc=1
                                   AND p.id_anggota=a.id_anggota
                                   AND p.id_transaksi = t.id_transaksi
                                   ");
        return $query->row();
    }
    
    function pinjaman_by_anggota($idpinjam,$id,$awal,$ahkir){
        $query = $this->db->query("SELECT t.tanggal AS tanggal, p.nominal_angsuran AS pokok, p.jml_margin AS margin,
                                   a.jumlah_bayar AS jumlah_bayar, a.sisa_jml_bayar AS sisa_bayar
                                   FROM tbl_angsuran_rutin a, tbl_pinjaman p, tbl_transaksi t
                                   WHERE p.id_anggota='$id' 
                                   AND a.id_pinjaman='$idpinjam'
                                   AND t.tanggal>='$awal'
                                   AND t.tanggal<='$ahkir'
                                   AND a.sts_tunggu = 1
                                   AND a.sts_lunas = 1
                                   AND a.id_transaksi = t.id_transaksi
                                   AND a.id_pinjaman = p.id_pinjaman
                                   ");
        return $query;
    }
    
    function simpanan_by_anggota($id,$awal,$ahkir){
        $query = $this->db->query("SELECT t.tanggal AS tanggal, s.wajib AS wajib, s.mdh AS mdh, s.total AS total
                                   FROM(
                                   SELECT id_transaksi,
                                        SUM(IF(jenis_simpanan='simpanan wajib',nilai,0)) AS wajib,
                                        SUM(IF(jenis_simpanan='simpanan mudharabah',nilai,0)) AS mdh,
                                        SUM(nilai) AS total
                                        FROM tbl_simpanan_rutin
                                        WHERE id_anggota='$id'
                                        AND id_transaksi IS NOT NULL
                                        AND status_tunggu = 1
                                        AND status_lunas = 1
                                        GROUP BY id_transaksi
                                    ) AS s, tbl_transaksi AS t
                                    WHERE t.tanggal>='$awal'
                                    AND t.tanggal<='$ahkir'
                                    AND s.id_transaksi = t.id_transaksi
                                  ");
        return $query;    
    }
    
    function total_simpan_anggota($id,$awal,$ahkir){
        $query = $this->db->query("SELECT SUM(s.nilai) AS total_all
                                   FROM tbl_simpanan_rutin s, tbl_transaksi t
                                   WHERE s.id_anggota='$id' 
                                   AND t.tanggal>='$awal'
                                   AND t.tanggal<='$ahkir'
                                   AND s.id_transaksi = t.id_transaksi
                                  ");
        return $query->row();
    }
    
    function total_simpan_wjb($id,$awal,$ahkir){
        $query = $this->db->query("SELECT SUM(s.nilai) AS total_wjb
                                   FROM tbl_simpanan_rutin s, tbl_transaksi t
                                   WHERE s.id_anggota='$id'
                                   AND jenis_simpanan='simpanan wajib'
                                   AND t.tanggal>='$awal'
                                   AND t.tanggal<='$ahkir'
                                   AND s.id_transaksi = t.id_transaksi
                                  ");
        return $query->row();
    }
    
    function total_simpan_mdh($id,$awal,$ahkir){
        $query = $this->db->query("SELECT SUM(s.nilai) AS total_mdh
                                   FROM tbl_simpanan_rutin s, tbl_transaksi t
                                   WHERE s.id_anggota='$id'
                                   AND jenis_simpanan='simpanan mudharabah'
                                   AND t.tanggal>='$awal'
                                   AND t.tanggal<='$ahkir'
                                   AND s.id_transaksi = t.id_transaksi
                                  ");
        return $query->row();
    }
    
    
    
    function ambil_nama_anggota($id){
        $query = $this->db->query("SELECT nama_anggota FROM tbl_anggota WHERE id_anggota='$id'");
        return $query->row();
    }


    function anggota_by_id($cr){
        $query = $this->db->query("SELECT*from tbl_anggota WHERE id_anggota like '%$cr%'");
        return $query;
    }
    
    function anggota_by_nm($cr){
        $query = $this->db->query("SELECT*from tbl_anggota WHERE nama_anggota like '%$cr%'");
        return $query;
    }
    
    function jmlout(){
        $query = $this->db->query("SELECT*FROM tbl_anggota WHERE status_pegawai='outsourcing'");
        return $query->num_rows();
    }
    
    function jmlttp(){
        $query = $this->db->query("SELECT*FROM tbl_anggota WHERE status_pegawai='tetap'");
        return $query->num_rows();
    }
    
    
}
?>
