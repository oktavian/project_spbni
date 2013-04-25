<?php

class M_laporan extends CI_Model {
    
     function pilih_last_id(){
        $query = $this->db->query("SELECT LAST_INSERT_ID() AS id");
        return $query->row();
     }
    
    
    function ambil_total_margin(){
        $query = $this->db->query("SELECT SUM((jml_margin*pembayaran_ke)) AS total_margin FROM tbl_pinjaman");
        return $query->row();
    }
    
    
    function ambil_total_mudharabah(){
        $query = $this->db->query("SELECT SUM(s.nilai) AS total_simpanan_mdh 
                                   FROM tbl_simpanan_rutin s 
                                   WHERE s.jenis_simpanan='simpanan mudharabah'
                                   AND s.status_tunggu=1
                                   AND s.status_lunas=1
                                   ");
        return $query->row();
    }
    
    function ambil_total_wajib(){
        $query = $this->db->query("SELECT SUM(s.nilai) AS total_simpanan_wjb 
                                   FROM tbl_simpanan_rutin s
                                   WHERE s.jenis_simpanan='simpanan wajib'
                                   AND s.status_tunggu=1
                                   AND s.status_lunas=1
                                  ");
        
        return $query->row();
    }
    
    function ambil_total_pendapatan(){
        $query = $this->db->query("SELECT SUM(kredit) AS total_pendapatan FROM jurnal_umum
                                   WHERE kode_akun='7.10'
                                  ");
        
        return $query->row();
    }
    
    function tampilkan_jurnal($awal,$ahkir){
        $query = $this->db->query("SELECT t.tanggal AS tgl_jurnal, a.nama AS nama,j.keterangan AS ket, j.urutan_akun AS urutan,
                                   j.debet AS debet, j.kredit AS kredit
                                   FROM jurnal_umum j, akun a, tbl_transaksi t
                                   WHERE t.tanggal>='$awal'
                                   AND t.tanggal<='$ahkir'
                                   AND j.kode_akun = a.kode_akun
                                   AND j.id_transaksi = t.id_transaksi
                                   ORDER by t.tanggal,id_jurnal, urutan_akun ASC  
                                  ");
        return $query;
    }
    
    function ambil_akun(){
        $query = $this->db->query("SELECT*FROM akun");
        return $query;
    }
    
    function cari_nama_akun($akun){
        $query = $this->db->query("SELECT kode_akun, nama FROM akun WHERE kode_akun='$akun'");
        return $query->row();
    }
    
    function ambil_dari_jurnal($akun,$bulan,$tahun){
        $query = $this->db->query("SELECT t.tanggal AS tgl_jurnal, j.keterangan AS nama_transaksi, j.debet AS debet, j.kredit AS kredit
                                    FROM jurnal_umum j, tbl_transaksi t
                                    WHERE j.kode_akun = '$akun'
                                    AND YEAR(t.tanggal)=$tahun AND MONTH(t.tanggal)=$bulan
                                    AND j.id_transaksi = t.id_transaksi
                                  ");
        return $query;
    }
    
    function ambil_laporan_simpanan($bln_simpan,$thn_simpan){
        $query = $this->db->query("SELECT a.nama_anggota AS nama_anggota,
                                   s.wajib AS wajib, s.mdh AS mdh, s.per_total AS per_total
                                   FROM (
                                        SELECT id_anggota,
                                        id_transaksi,
                                        SUM(IF(jenis_simpanan='simpanan wajib',nilai,0)) as wajib,
                                        SUM(IF(jenis_simpanan='simpanan mudharabah',nilai,0)) as mdh,
                                        SUM(nilai) AS per_total
                                        FROM tbl_simpanan_rutin
                                        GROUP BY id_anggota
                                    ) as s, tbl_transaksi as t, tbl_anggota as a
                                    WHERE MONTH(t.tanggal) = $bln_simpan
                                    AND YEAR(t.tanggal) = $thn_simpan
                                    AND s.id_transaksi = t.id_transaksi
                                    AND s.id_anggota = a.id_anggota
                                  ");
        return $query;
    }
    
    function ambil_laporan_pinjaman($bln_pinjam,$thn_pinjam){
        $query = $this->db->query("SELECT agt.nama_anggota AS nama_anggota, a.sisa_jml_bayar AS saldo
                                   FROM tbl_anggota agt, tbl_angsuran_rutin a, tbl_transaksi t, tbl_pinjaman p
                                   WHERE YEAR(t.tanggal) = $thn_pinjam
                                   AND MONTH(t.tanggal) = $bln_pinjam
                                   AND a.id_transaksi = t.id_transaksi
                                   AND a.id_pinjaman = p.id_pinjaman
                                   AND p.id_anggota = agt.id_anggota
                                   ");
        
        return $query;
    }

    
    function saldo_debet_jurnal($akun,$bulan,$tahun){
        $query = $this->db->query("SELECT SUM(j.debet) AS saldo_d FROM jurnal_umum j, tbl_transaksi t
                                   WHERE j.kode_akun = '$akun'
                                   AND YEAR(t.tanggal)=$tahun AND MONTH(t.tanggal)=$bulan
                                   AND j.id_transaksi = t.id_transaksi
                                  ");
        return $query->row();
    }
    
    function saldo_kredit_jurnal($akun,$bulan,$tahun){
        $query = $this->db->query("SELECT SUM(j.kredit) AS saldo_k FROM jurnal_umum j, tbl_transaksi t
                                   WHERE j.kode_akun = '$akun'
                                   AND YEAR(t.tanggal)=$tahun AND MONTH(t.tanggal)=$bulan
                                   AND j.id_transaksi = t.id_transaksi
                                  ");
        return $query->row();
    }
    
    function masukan_transaksi($nama_trans,$tgl_trans){
        $query = $this->db->query("INSERT INTO tbl_transaksi(nama_transaksi,tanggal) VALUES('$nama_trans','$tgl_trans')");
        return $query;
    }
    
    function masukan_kas($id,$pend_basil){
        $query = $this->db->query("INSERT into jurnal_umum(kode_akun,id_transaksi,urutan_akun,keterangan,debet,kredit)
                                   VALUES('1.110',$id,1,'kas dari penerimaan pendapatan',$pend_basil,0)
                                  ");
        return $query;
    }
    
    function masukan_pendapatan($id,$pend_basil){
        $query = $this->db->query("INSERT into jurnal_umum(kode_akun,id_transaksi,urutan_akun,keterangan,debet,kredit)
                                   VALUES('7.10',$id,2,'pendapatan yang belum dibagikan',0,$pend_basil)
                                  ");
        return $query;
    }
    
    function masuk_ke_beban($id,$masing_bag,$id_anggota){
        $query = $this->db->query("INSERT into jurnal_umum(kode_akun,id_transaksi,urutan_akun,keterangan,debet,kredit)
                                   VALUES('6.10',$id,1,'$id_anggota',$masing_bag,0)
                                  ");
        return $query;
    }
    
    function masuk_ke_utang($id,$masing_bag,$id_anggota){
        $query = $this->db->query("INSERT into jurnal_umum(kode_akun,id_transaksi,urutan_akun,keterangan,debet,kredit)
                                   VALUES('4.1.1',$id,2,'$id_anggota',0,$masing_bag)
                                  ");
    }
    
    function masuk_beban_koperasi($id,$bag_kop){
        $query = $this->db->query("INSERT into jurnal_umum(kode_akun, id_transaksi, urutan_akun,keterangan,debet,kredit)
                                   VALUES('6.10',$id,1,'beban dari perhitungan bagi hasil koperasi',$bag_kop,0)
                                  ");
        return $query;
    }
    
    function masuk_utang_koperasi($id,$bag_kop){
        $query = $this->db->query("INSERT into jurnal_umum(kode_akun,id_transaksi,urutan_akun,keterangan,debet,kredit)
                                   VALUES('4.1.1',$id,2,'utang dari perhitungan bagi hasil koperasi',0,$bag_kop)
                                  ");
        return $query;
    }
    
    
    function beban_anggota($id,$keterangan,$basil){
        $query = $this->db->query("INSERT into jurnal_umum(kode_akun,id_transaksi,urutan_akun,keterangan,debet,kredit)
                                   VALUES('6.10',$id,1,'$keterangan',$basil,0)
                                  ");
        return $query;
    }
    
    function utang_anggota($id,$keterangan,$basil){
        $query = $this->db->query("INSERT into jurnal_umum(kode_akun,id_transaksi,urutan_akun,keterangan,debet,kredit)
                                   VALUES('4.1.1',$id,2,'$keterangan',0,$basil)
                                  ");
        return $query;
    }
    
    function ambil_jml_anggota(){
        $query = $this->db->query("SELECT*from tbl_anggota");
        return $query;
    }
    
    function ambil_simpanan_anggota($id_anggota,$tahun){
        $query = $this->db->query("SELECT SUM(s.nilai) AS total_simpan 
                                   FROM tbl_simpanan_rutin s, tbl_transaksi t 
                                   WHERE s.id_anggota='$id_anggota'
                                   AND YEAR(t.tanggal)=$tahun
                                   AND s.id_transaksi = t.id_transaksi
                                 ");
        return $query->row();
    }
    
    function ambil_pinjaman_anggota($id_anggota,$tahun){
        $query = $this->db->query("SELECT SUM(p.jml_margin) AS total_margin 
                                   FROM tbl_pinjaman p, tbl_transaksi t
                                   WHERE p.id_anggota = '$id_anggota' 
                                   AND YEAR(t.tanggal) = $tahun
                                   AND p.id_transaksi = t.id_transaksi
                                  ");
        return $query->row();
    }
    
    
    function cari_pendapatan($tahun){
        $query = $this->db->query("SELECT SUM(j.kredit) AS pendapatan
                                   FROM jurnal_umum j, tbl_transaksi t 
                                   WHERE j.kode_akun = '7.10' 
                                   AND YEAR(t.tanggal) = $tahun
                                   AND j.id_transaksi = t.id_transaksi
                                  ");
        return $query->row();
    }
    
    function buku_simpanan($id,$tgl_awal,$tgl_ahkir){
        $query = $this->db->query("SELECT t.tanggal AS tanggal,s.wjb AS wajib,s.mdh AS mdh,s.total AS total
                                   FROM (
                                      SELECT id_transaksi, 
                                      SUM(IF(jenis_simpanan='simpanan wajib',nilai,0)) AS wjb,
                                      SUM(IF(jenis_simpanan='simpanan mudharabah',nilai,0)) AS mdh,
                                      SUM(nilai) AS total
                                      FROM tbl_simpanan_rutin
                                      WHERE id_anggota = '$id'
                                      AND id_transaksi IS NOT NULL
                                      AND status_tunggu = 1
                                      AND status_lunas = 1
                                      GROUP BY id_transaksi
                                    ) AS s, tbl_transaksi t
                                    WHERE t.tanggal >='$tgl_awal'
                                    AND t.tanggal <='$tgl_ahkir'
                                    AND s.id_transaksi = t.id_transaksi
                                  ");
        return $query;
        
    }
    
    function total_simpan_anggota($id,$tgl_awal,$tgl_ahkir){
        $query = $this->db->query("SELECT SUM(s.nilai) AS total_all
                                   FROM tbl_simpanan_rutin s, tbl_transaksi t
                                   WHERE s.id_anggota='$id' 
                                   AND t.tanggal>='$tgl_awal'
                                   AND t.tanggal<='$tgl_ahkir'
                                   AND s.id_transaksi = t.id_transaksi
                                  ");
        return $query->row();
    }
    
    function total_simpan_wjb($id,$tgl_awal,$tgl_ahkir){
        $query = $this->db->query("SELECT SUM(s.nilai) AS total_wjb
                                   FROM tbl_simpanan_rutin s, tbl_transaksi t
                                   WHERE s.id_anggota='$id'
                                   AND jenis_simpanan='simpanan wajib'
                                   AND t.tanggal>='$tgl_awal'
                                   AND t.tanggal<='$tgl_ahkir'
                                   AND s.id_transaksi = t.id_transaksi
                                  ");
        return $query->row();
    }
    
    function total_simpan_mdh($id,$tgl_awal,$tgl_ahkir){
        $query = $this->db->query("SELECT SUM(s.nilai) AS total_mdh
                                   FROM tbl_simpanan_rutin s, tbl_transaksi t
                                   WHERE s.id_anggota='$id'
                                   AND jenis_simpanan='simpanan mudharabah'
                                   AND t.tanggal>='$tgl_awal'
                                   AND t.tanggal<='$tgl_ahkir'
                                   AND s.id_transaksi = t.id_transaksi
                                  ");
        return $query->row();
    }
    
    function simpanan_by_tahun($tahun){
        $query = $this->db->query("SELECT SUM(s.nilai) AS tot_simp 
                                   FROM tbl_simpanan_rutin s, tbl_transaksi t
                                   WHERE YEAR(t.tanggal) = $tahun
                                   AND s.id_transaksi = t.id_transaksi
                                   ");
        return $query->row();
    }
    
    function margin_by_tahun($tahun){
        $query = $this->db->query("SELECT SUM(p.jml_margin) AS tot_margin
                                   FROM tbl_pinjaman p, tbl_transaksi t
                                   WHERE YEAR(t.tanggal) = $tahun
                                   AND p.id_transaksi = t.id_transaksi
                                  ");
        return $query->row();
    }
    
    function ambil_ket_pinjaman($idpinjam,$id){
        $query = $this->db->query("SELECT p.id_anggota AS id_anggota, a.nama_anggota AS nama_anggota,t.tanggal AS tgl_pinjam, 
                                   p.id_pinjaman AS id_pinjaman,p.nominal_pinjaman AS jml_pinjam, p.status_pembayaran AS status, 
                                   p.jml_angsuran  AS jumlah_angsur,
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
    
    function basil_by_anggota($keterangan,$tahun){
        $query = $this->db->query("SELECT SUM(j.debet) AS basil
                                   FROM jurnal_umum j, tbl_transaksi t
                                   WHERE YEAR(t.tanggal) = $tahun
                                   AND j.keterangan = '$keterangan'
                                   AND j.id_transaksi = t.id_transaksi
                                  ");
        return $query->row();
    }
    
    function pilih_pinjaman($autocari){
        $query = $this->db->query("SELECT CONCAT(p.id_pinjaman,'_',t.tanggal) AS pilihan
                                   FROM tbl_pinjaman p, tbl_transaksi t
                                   WHERE CONCAT(p.id_pinjaman,'_',t.tanggal) LIKE '%$autocari%'
                                   AND p.id_transaksi = t.id_transaksi
                                  ");
        return $query;
    }

    
    
    
    
    
}

?>
