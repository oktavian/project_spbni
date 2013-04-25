<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of c_pinjaman
 *
 * @author benny
 */
class C_pinjaman extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model("m_pinjaman");
        $this->load->library('pagination');
        session_start();
    }
    
    function index(){
      if(isset($_SESSION['user']) || isset($_SESSION['bagian_umum'])){
        $kodepinjam = trim($this->uri->segment(3));
        $tgl_awal= $this->input->post('tgl_awal');
        $tgl_ahkir= $this->input->post('tgl_ahkir');

        $data['hasil'] = $this->m_pinjaman->ambil_transaksi_pinjaman($kodepinjam,$tgl_awal,$tgl_ahkir);
        $data['title']="PINJAMAN";
        $data['isi'] = "pinjaman/tbl_pinjaman";
        $data['js']="js_pinjaman";
        $this->load->view("template",$data);      
      }else{
          redirect("c_anggota/hak");
      }     
    }
    
    function form_pinjaman(){
       if($_SESSION['user']=="pengelola"){
            $data['title'] = "FORM PINJAMAN";
            $data['isi'] = "pinjaman/fmtambahpinjaman";
            $data['js']="js_pinjaman";
            $this->load->view("template",$data);   
       }else{
           redirect("c_anggota/hak");
       }
    }
    
    function auto_id_anggota(){
        $autocari = $this->input->get('q');
        if(!$autocari) return;
        $munculkan = $this->m_pinjaman->pilih_anggota($autocari);
        
        foreach($munculkan->result() as $data){
            echo $data->pilihan."\n";
        }  
    }
    
    function auto_peminjam(){
        $peminjam = $this->input->post('id');
        $pisah = explode("_", $peminjam);
        $id = $pisah[0];
     
        $cari = $this->m_pinjaman->cari_anggota($id);//1.
        //begin pemrosesan tanggal anggota ini masuk
        $tgl= $cari->row();
        $tgl_masuk = $tgl->tgl_masuk;
        $tgl_sekarang = date("Y-m-d");
        $tgl_hitung= abs(strtotime($tgl_sekarang) - strtotime($tgl_masuk));;    
        $tahun = floor($tgl_hitung / (365*60*60*24));
        $bulan = floor(($tgl_hitung - $tahun*365*60*60*24) / (30*60*60*24));
        $hari = floor(($tgl_hitung - $tahun*365*60*60*24 - $bulan*30*60*60*24) / (60*60*24));
        //end pemrosesan tanggal anggota ini masuk
        
        $totalsimpanan = $this->m_pinjaman->hitung_total_simpanan(); //2.
        $totalwajib = $this->m_pinjaman->hitung_total_wajib($id); //3. 
        $totalmdh = $this->m_pinjaman->hitung_total_mdh($id); //4. 
        
        $data['ketanggota'] = $cari;
        $data['ketmasuk'] = $hari." Hari ".$bulan." Bulan ".$tahun." Tahun ";
        $data['kettotsimp'] = $totalsimpanan;
        $data['kettotwjb'] = $totalwajib;
        $data['kettotmdh'] = $totalmdh;
        $this->load->view("pinjaman/keterangan_peminjam",$data);
    }
    
    function filter_nilai_pinjaman(){
        $idanggota=$this->input->post('id');
        $nilaipinjam = $this->input->post('n');
        $stspeg = $this->m_pinjaman->lihat_status_pegawai($idanggota);
        $status = $stspeg->status_pegawai;
        if($status=="outsourcing" && $nilaipinjam>10000000){
            echo "out";
        }elseif($status=="tetap" && $nilaipinjam>40000000){
            echo "tetap";
        }else{
            echo "kurang";
        }
    }
    
    function tambah_pinjaman(){
        $idanggota = $this->input->post('idanggota');
        $tglpinjam = $this->input->post('tgl_pinjam');
        $nominal = $this->input->post('hdnominal');
        $jmlangsur = $this->input->post('jmlangsur');
        //$angsuran = $this->input->post('hdjml_angsuran');

        //BUAT TRANSAKSI
        $buat_transaksi = $this->m_pinjaman->input_tgl_transaksi($tglpinjam);
        if($buat_transaksi){
            
        //masukan tabel pinjaman
        $idtrans = $this->m_pinjaman->maxidtrans();
        $id_transaksi = $idtrans->id;
            
        //BEGIN pembuatan KODE PINJAMAN
        $ambilid = $this->m_pinjaman->ambil_id_max();
        $id = $ambilid->row();
        $idpinjam = $id->max_id;
        $max = (int) substr("$idpinjam",4,4);
        $max++;
        $kodepinjam = "PJM-".sprintf("%04s", $max);
        //END pembuatan KODE PINJAMAN
         
        //BEGIN pembuatan margin & pokok pinjaman
   
        $pokok  = $nominal/$jmlangsur;
        $margin = $pokok*(1.5/100);
        
        //END pembuatan margin & pokok pinjaman
      
         $kirim = $this->m_pinjaman->masukan_data_pinjaman($kodepinjam,$id_transaksi,$idanggota,$nominal,$jmlangsur,$margin,$pokok);
            if($kirim){
                redirect("/c_pinjaman/index/$kodepinjam");
            }
        }  
    }
    
    function update_acc(){
        $idpinjam = $this->input->post('id');
        $status = $this->input->post('tx');
        if($status=="BELUM ACC"){
            $update = $this->m_pinjaman->update_status_blm_acc($idpinjam);
            if($update){
                $ambil_detail = $this->m_pinjaman->ambil_detail_pinjaman_acc($idpinjam);
                $id_trans     = $ambil_detail->id_transaksi;
                $tgl_trans    = $ambil_detail->tanggal;
                $nm_anggota   = $ambil_detail->nama_anggota;
                $keterangan   = $nm_anggota.", pemberian pinjaman qardhul hasan";
                $nominal      = $ambil_detail->nominal_pinjaman;
                //$urutan_masuk = 1;
                //lihat jurnal dulu
                //jika tanggal sama, lihat urutan masuk keberapa?
                //jika ada tambahkan 1 urutan setelah transaksi tanggal tersebut
                
                
                
                $masukan_piutang = $this->m_pinjaman->debet_piutang($id_trans,$keterangan,$nominal);
                $masukan_kas = $this->m_pinjaman->kredit_kas($id_trans,$keterangan,$nominal);
                if($masukan_piutang && $masukan_kas){
                    echo "ACC";
                }
            }
        }
    }
      
    
    
}

?>
