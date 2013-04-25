<?php

class M_simpanan extends CI_Model{
    
    
    function hitungjmldata(){
        return $this->db->count_all('tbl_anggota');
    }
    
    
    
    function tgl_tgh_skrng(){
        $query = $this->db->query("SELECT max(tgl_pembuatan) as tgl_buat 
                                   FROM tbl_simpanan_rutin
                                   WHERE status_tunggu = 1 
                                   AND status_lunas = 0");
        
        return $query->row();  
    }
    
    function tgl_tgh_skrng2(){
        $query = $this->db->query("SELECT max(tgl_pembuatan) as tgl_buat_now 
                                   FROM tbl_simpanan_rutin");
        
        return $query->row();  
    }
    
    
    function tambah_transaksi_simpanan($tgl_transaksi){
        $query = $this->db->query("insert into tbl_transaksi(nama_transaksi,tanggal) values('pembayaran simpanan','$tgl_transaksi')");
        return $query; 
    }
    
    function jurnal_simp_kas($idtrans,$keterangan,$nilai){
        $query = $this->db->query("INSERT into jurnal_umum(kode_akun,id_transaksi,urutan_akun,keterangan,debet,kredit)
                                   VALUES('1.110',$idtrans,1,'$keterangan',$nilai,0)
                                  ");
        return $query;
    }
    
    function jurnal_simp($kodesimp,$idtrans,$keterangan,$nilai){
        $query = $this->db->query("INSERT into jurnal_umum(kode_akun,id_transaksi,urutan_akun,keterangan,debet,kredit)
                                   VALUES ('$kodesimp',$idtrans,2,'$keterangan',0,$nilai)
                                  ");
        return $query;
    }
    
    
    function max_input_transaksi_simpanan(){
        $query = $this->db->query("SELECT max(id_transaksi) as id_max FROM tbl_transaksi");
        return $query->row();
    }
    
    function simpan_transaksi_simpanan($tgl_tagih_now,$id_trans){
        $query = $this->db->query("UPDATE tbl_simpanan_rutin SET id_transaksi='$id_trans->id_max'
                                   WHERE status_tunggu = 1
                                   AND status_lunas = 0
                                   AND id_transaksi IS NULL
                                  ");
        return $query;
    }
    
    function ambil_transaksi_simpanan($tgl_awal,$tgl_ahkir){
        $query = $this->db->query("SELECT s.id_simpanan AS id_simpanan, s.id_anggota AS id_anggota, a.nama_anggota AS nama_anggota,
                                   t.tanggal AS tgl_transaksi, s.jenis_simpanan AS jenis_simpanan, s.nilai AS nilai
                                   FROM tbl_simpanan_rutin s, tbl_anggota a, tbl_transaksi t
                                   WHERE s.status_tunggu = 1
                                   AND s.status_lunas = 1
                                   AND t.tanggal >= '$tgl_awal' 
                                   AND t.tanggal <='$tgl_ahkir' 
                                   AND s.id_transaksi IS NOT NULL
                                   AND s.id_anggota = a.id_anggota
                                   AND s.id_transaksi = t.id_transaksi
                                   ORDER by s.id_anggota
                                  ");
        return $query;
    }
  
    function ambil_daftar_simpanan(){
       $query = $this->db->query("SELECT s.id_simpanan AS id_simpanan, s.id_anggota AS id_anggota, a.nama_anggota AS nama_anggota,
                                  s.tgl_pembuatan AS tgl_pembuatan, s.jenis_simpanan AS jenis_simpanan, s.nilai AS nilai, 
                                  s.status_tunggu AS status
                                  FROM tbl_simpanan_rutin s, tbl_anggota a 
                                  WHERE s.status_lunas = 0
                                  AND s.id_transaksi IS NULL
                                  AND s.id_anggota = a.id_anggota  
                                  ");
       
       return $query;
       
    }
    
    
    
    function ambil_daftar_sebelumnya($tgl_tagih_skrng){
         $query = $this->db->query("SELECT s.id_simpanan AS id_simpanan, s.id_anggota AS id_anggota, a.nama_anggota AS nama_anggota,
                                  s.tgl_pembuatan AS tgl_pembuatan, s.jenis_simpanan AS jenis_simpanan, s.nilai AS nilai, 
                                  s.status_tunggu AS status
                                  FROM tbl_simpanan_rutin s, tbl_anggota a 
                                  WHERE s.status_tunggu = 1 
                                  AND s.status_lunas = 0
                                  AND s.id_transaksi IS NOT NULL
                                  AND s.tgl_pembuatan <= '$tgl_tagih_skrng->tgl_buat' 
                                  AND s.id_anggota = a.id_anggota   
                                  ");
       
       return $query;
    }
    
    function ambil_status_simpan_belum_lunas(){
        $query = $this->db->query("SELECT s.id_simpanan AS id_simpanan, s.id_anggota AS id_anggota, a.nama_anggota AS nama_anggota,
                                  s.tgl_pembuatan AS tgl_pembuatan, s.jenis_simpanan AS jenis_simpanan, s.nilai AS nilai, 
                                  s.status_lunas AS status, t.tanggal AS tgl_transaksi
                                  FROM tbl_simpanan_rutin s, tbl_anggota a, tbl_transaksi t 
                                  WHERE s.status_lunas = 0
                                  AND s.status_tunggu = 1
                                  AND s.id_transaksi IS NOT NULL
                                  AND s.id_anggota = a.id_anggota
                                  AND s.id_transaksi = t.id_transaksi
                                  ");
       
       return $query;
    }
    
    
    function ambil_print(){
        $query = $this->db->query("SELECT s.id_anggota AS id_anggota, a.nama_anggota AS nama_anggota, 
                                   a.status_pegawai AS status_pegawai,s.wajib AS wajib, s.mdh AS mdh, s.total AS total
                                   FROM (
                                        SELECT id_anggota, 
                                            SUM(IF(jenis_simpanan='simpanan wajib',nilai,0)) AS wajib,
                                            SUM(IF(jenis_simpanan='simpanan mudharabah',nilai,0)) AS mdh,
                                            SUM(nilai) AS total
                                            FROM tbl_simpanan_rutin
                                            WHERE id_transaksi IS NULL
                                            AND status_lunas=0
                                            AND status_tunggu=0
                                            GROUP by id_anggota
                                        ) AS s, tbl_anggota AS a
                                      WHERE s.id_anggota = a.id_anggota 
                                  ");
        return $query;
    }
    
    function total_tagihan(){
        $query = $this->db->query("SELECT SUM(nilai) AS total_all FROM tbl_simpanan_rutin
                                   WHERE id_transaksi IS NULL
                                   AND status_tunggu=0
                                   AND status_lunas=0
                                  ");
        return $query->row();
    }
    
    function ambil_tbl_anggota(){
        $query = $this->db->query("SELECT id_anggota FROM tbl_anggota");
        return $query; 
    }
    
    function ambilmaxmdh(){
       $query =  $this->db->query("SELECT max(id_simpanan) as max_mdh FROM tbl_simpanan_rutin WHERE id_simpanan LIKE '%SIMMDH-%'");
       return $query; 
    }
    
    function ambilmaxwjb(){
      $query = $this->db->query("SELECT max(id_simpanan) as max_wjb FROM tbl_simpanan_rutin WHERE id_simpanan LIKE '%SIMWJB-%'");  
      return $query;
    }
    
    function ambil_nama_simpanan($idblmlunas){
        $query = $this->db->query("SELECT s.id_transaksi AS id_transaksi, s.jenis_simpanan AS jenis_simpanan, s.nilai AS nilai, 
                                   t.tanggal AS tanggal, t.nama_transaksi AS nama_transaksi, a.nama_anggota AS nama_anggota 
                                   FROM tbl_simpanan_rutin s, tbl_transaksi t, tbl_anggota a  
                                   WHERE s.id_simpanan='$idblmlunas'
                                   AND s.id_transaksi = t.id_transaksi
                                   AND s.id_anggota = a.id_anggota
                                  ");
        return $query->row();
    }
   
    function daftar_simpanan_wjb($kodewjb,$idanggota,$tglbuat){
         $query = $this->db->query("INSERT into tbl_simpanan_rutin(id_simpanan,id_anggota,tgl_pembuatan,jenis_simpanan,nilai,status_tunggu,status_lunas)
                        values('$kodewjb','$idanggota','$tglbuat','simpanan wajib','50000','0','0')");
         
         return $query;
    }
    
    function daftar_simpanan_mdh($kodemdh,$idanggota,$tglbuat){
         $query = $this->db->query("INSERT into tbl_simpanan_rutin(id_simpanan,id_anggota,tgl_pembuatan,jenis_simpanan,nilai,status_tunggu,status_lunas)
                        values('$kodemdh','$idanggota','$tglbuat','simpanan mudharabah','25000','0','0')");
         
         return $query;
    }

    
    function update_daftar($idsts,$sts){
        
        if($sts==0){
            $query = $this->db->query("UPDATE tbl_simpanan_rutin SET status_tunggu=1
                                       WHERE id_simpanan='$idsts'
                                      ");
            
            $lunas = "diproses";
            return $lunas;
            
        }elseif($sts==1){
            $query = $this->db->query("UPDATE tbl_simpanan_rutin SET status_tunggu=0
                                       WHERE id_simpanan='$idsts'
                                      ");
        
            $lunas = "belum diproses";
            return $lunas;
        }
     
    }
    
    function update_lunas_simpanan($idblmlunas){
        $query = $this->db->query("UPDATE tbl_simpanan_rutin SET status_lunas=1
                                   WHERE id_simpanan = '$idblmlunas'
                                  ");
        return $query;
    }
    
    function ubah_status_lunas($idsimp){
        $query = $this->db->query("UPDATE tbl_simpanan_rutin SET status_lunas=0
                                   WHERE id_simpanan = '$idsimp'
                                  ");
        return $query;
    }
    
    function masukan_daftar_tagih($idinclude){
        $query = $this->db->query("UPDATE tbl_simpanan_rutin SET id_transaksi=NULL, status_tunggu=0
                                   WHERE id_simpanan = '$idinclude'
                                  ");
        return $query;
    }
    
    function jns_wjb($tgl_tagih_skrng,$jns_simpanan){
        $query = $this->db->query("SELECT s.id_simpanan AS id_simpanan, s.id_anggota AS id_anggota, a.nama_anggota AS nama_anggota,
                                  s.tgl_pembuatan AS tgl_pembuatan, s.jenis_simpanan AS jenis_simpanan, s.nilai AS nilai, 
                                  s.status AS status
                                  FROM tbl_simpanan_rutin s, tbl_anggota a 
                                  WHERE s.tgl_pembuatan = '$tgl_tagih_skrng->tgl_buat'
                                  AND s.jenis_simpanan LIKE '%simpanan wajib%'
                                  AND s.id_anggota = a.id_anggota");
    
        
        return $query;
        
    }
    
    function jns_mdh($tgl_tagih_skrng,$jns_simpanan){
        $query = $this->db->query("SELECT s.id_simpanan AS id_simpanan, s.id_anggota AS id_anggota, a.nama_anggota AS nama_anggota,
                                  s.tgl_pembuatan AS tgl_pembuatan, s.jenis_simpanan AS jenis_simpanan, s.nilai AS nilai, 
                                  s.status AS status
                                  FROM tbl_simpanan_rutin s, tbl_anggota a 
                                  WHERE s.tgl_pembuatan = '$tgl_tagih_skrng->tgl_buat'
                                  AND s.jenis_simpanan LIKE '%simpanan mudharabah%'
                                  AND s.id_anggota = a.id_anggota");
    
        
        return $query;
        
    }
    
    
    
    

    
}

?>
