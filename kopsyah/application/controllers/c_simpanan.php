<?php

class C_simpanan extends CI_Controller {
    
    
    function __construct() {
        parent::__construct();
        $this->load->model("m_simpanan");
        $this->load->library('pagination');
        session_start();
    }
    
    
    function index(){ 
        if(isset($_SESSION['user']) || isset($_SESSION['bagian_umum'])){
            $tgl_awal= $this->input->post('tgl_awal');
            $tgl_ahkir= $this->input->post('tgl_ahkir');
            //$jns_simp = $this->input->post('jns_simp');
            $data['title']="SIMPANAN";
            $data['isi'] = "simpanan/tbl_simpanan";
            $data['js']="js_simpanan";
            $data['hasil'] = $this->m_simpanan->ambil_transaksi_simpanan($tgl_awal,$tgl_ahkir);
            $this->load->view("template",$data);    
        }else{
            redirect("c_anggota/hak");
        }
        
    }
    
    function input_transaksi_simpanan(){
        $tgl_transaksi = $this->input->post('id_trans');
        $input_trans = $this->m_simpanan->tambah_transaksi_simpanan($tgl_transaksi);
        if($input_trans){
            $tgl_tagih_now = $this->m_simpanan->tgl_tgh_skrng();
            $id_trans = $this->m_simpanan->max_input_transaksi_simpanan();
            $simpan = $this->m_simpanan->simpan_transaksi_simpanan($tgl_tagih_now,$id_trans);
            if($simpan){
                redirect("/c_simpanan/tampil_tbl_lunas_simpanan");
            }else{
                echo "masih ada yang salah";
            }
        }
    }
    
    function transaksi_filter_ajax(){
        $tglfilter = $this->input->post("tgl");
        $tgldftarmax = $this->m_simpanan->tgl_tgh_skrng();
        $tglfilter2 = $tgldftarmax->tgl_buat;
        if($tglfilter<$tglfilter2){
            echo "tanggal transaksi tidak boleh kurang dari tanggal pembuatan daftar tagih";
        }else{
            echo "";
        }
    }
        
    function tambah_daftar_simpanan(){        
        $tglbuat = $this->input->post("buat_daftar");
        $dtanggota = $this->m_simpanan->ambil_tbl_anggota();
        foreach($dtanggota->result() as $dt){
        $idanggota = $dt->id_anggota;
        //1. simpanan mudharabah    
            $maxidwjb = $this->m_simpanan->ambilmaxwjb();
            $idwjb = $maxidwjb->row();
            $nourutwjb = (int) substr($idwjb->max_wjb, 7,4);
            $nourutwjb++;
            $kodewjb = "SIMWJB-".sprintf("%04s", $nourutwjb);
            $krmwjb = $this->m_simpanan->daftar_simpanan_wjb($kodewjb,$idanggota,$tglbuat);

         //2. simpanan mudharabah 
            $maxidmdh = $this->m_simpanan->ambilmaxmdh();
            $idmdh = $maxidmdh->row();
            $nourutmdh = (int) substr($idmdh->max_mdh, 7,4);
            $nourutmdh++;
            $kodemdh = "SIMMDH-".sprintf("%04s", $nourutmdh);
            $krmmdh = $this->m_simpanan->daftar_simpanan_mdh($kodemdh,$idanggota,$tglbuat); 
        }
        redirect("/c_simpanan/tampil_daftar_simpanan");
    }
    
    function tampil_daftar_simpanan(){
      if(isset($_SESSION['user']) || isset($_SESSION['bagian_umum'])){
          
        $tgl_tagih_skrng = $this->m_simpanan->tgl_tgh_skrng();
        $data['hasil'] = $this->m_simpanan->ambil_daftar_simpanan();
        $data["blm"] = $this->m_simpanan->ambil_daftar_sebelumnya($tgl_tagih_skrng);
        $tgldaftar = $this->m_simpanan->tgl_tgh_skrng2();
        if($tgldaftar->tgl_buat_now!=0){
        $pisah = explode("-", $tgldaftar->tgl_buat_now);
        $thn = $pisah[0];
        $bln = $pisah[1];
        $hr  = $pisah[2];
        
            switch($bln){
                case 1: $bulan = "JANUARY/".$thn; break;
                case 2: $bulan = "FEBRUARY/".$thn; break;
                case 3: $bulan = "MARET/".$thn; break;
                case 4: $bulan = "APRIL/".$thn; break;
                case 5: $bulan = "MEI/".$thn; break;
                case 6: $bulan = "JUNI/".$thn; break;
                case 7: $bulan = "JULI/".$thn; break;
                case 8: $bulan = "AGUSTUS/".$thn; break;
                case 9: $bulan = "SEPTEMBER/".$thn; break;
                case 10: $bulan = "OKTOBER/".$thn; break;
                case 11: $bulan = "NOVEMBER/".$thn; break;
                case 12: $bulan = "DESEMBER/".$thn; break;
            }
        }else{$bulan = "-";}
        $data['periode'] = $bulan;
        $data['title']="DFTR SIMPAN";
        $data['js']="js_simpanan";
        $data['isi']="simpanan/dftr_tgh_simpanan";
        $this->load->view("template",$data); 
          
      }else{
          redirect("c_anggota/hak");
      }  
    }
    
    function tampil_tbl_lunas_simpanan(){
        if($_SESSION['user']=="pengelola"){
            $data['title'] = "TBL PELUNASAN";
            $data['js'] = "js_simpanan";
            $data['hasil'] = $this->m_simpanan->ambil_status_simpan_belum_lunas();
            $data['isi'] = "simpanan/tbl_pelunasan_simpanan";
            $this->load->view("template",$data);
        }else{
            redirect("c_anggota/hak");
        }
    }
    
    function update_status_tagih(){
        $idsts = $this->input->post('idsts');
        $sts = $this->input->post('sts');
        $update = $this->m_simpanan->update_daftar($idsts,$sts);
        
        if($update=="diproses"){
            $data['idgmbr']= $idsts;
            $data['stat']=1;
            $data['gmbr'] = "<img src='".base_url()."css/images/icon/valid-icon.jpg' width='20' title='belum lunas' />";
            echo json_encode($data);
        }elseif($update=="belum diproses"){
            $data['idgmbr']= $idsts;
            $data['stat']=0;
            $data['gmbr'] = "<img src='".base_url()."css/images/icon/warning-icon.jpg' width='20' title='belum lunas' />";
            echo json_encode($data);
        }
            
    }
    
    function update_status_lunas(){
        $idblmlunas = $this->input->post("idklik");
        $lunas = $this->m_simpanan->update_lunas_simpanan($idblmlunas);
        if($lunas){
            $ambil      = $this->m_simpanan->ambil_nama_simpanan($idblmlunas);
            $idtrans    = $ambil->id_transaksi;
            $jenis_simp = $ambil->jenis_simpanan;
            $nm_agta    = $ambil->nama_anggota;
            $nm_trans   = $ambil->nama_transaksi;
            $nilai      = $ambil->nilai;

            if($jenis_simp=="simpanan wajib"){
                $kodesimp     = '5.110';
                $keterangan   = $nm_agta.", penambahan simpanan wajib";
                
                $masukan_kas  = $this->m_simpanan->jurnal_simp_kas($idtrans,$keterangan,$nilai);
                $masukan_simp = $this->m_simpanan->jurnal_simp($kodesimp,$idtrans,$keterangan,$nilai);

            }elseif($jenis_simp=="simpanan mudharabah"){
                $kodesimp     = '5.120';
                $keterangan   = $nm_agta.", penambahan simpanan mudharabah";
                
                $masukan_kas  = $this->m_simpanan->jurnal_simp_kas($idtrans,$keterangan,$nilai);
                $masukan_simp = $this->m_simpanan->jurnal_simp($kodesimp,$idtrans,$keterangan,$nilai);
            }
            
            echo "lunas";
            
        }
    }
    
    function include_daftar_tagih(){
        $idinclude = $this->input->post('idubah');
        $masukan = $this->m_simpanan->masukan_daftar_tagih($idinclude);
        if($masukan){
            echo "masuk";
        }
    }
    
 /*   
    function koreksi_tbl_transaksi(){
        $idsimp = $this->input->post('id');
        $koreksi = $this->m_simpanan->ubah_status_lunas($idsimp);
        if($koreksi){
            echo "salah";
        }else{
            echo "";
        }
    }
  * 
  */
     
 
    function ajax_filter($start_row=''){
        $jns = $this->input->post("jns");
        $tgl_tagih_skrng = $this->m_simpanan->tgl_tgh_skrng();
        
        if($jns=="wjb"){
            $jns_simpanan = "simpanan wajib";
            $data["hasil"] = $this->m_simpanan->jns_wjb($tgl_tagih_skrng,$jns_simpanan);
            $this->load->view("simpanan/ajax_filter_jns",$data);
        }elseif($jns=="mdh"){
            $jns_simpanan = "simpanan mudharabah";
            $data["hasil"] = $this->m_simpanan->jns_mdh($tgl_tagih_skrng,$jns_simpanan);
            $this->load->view("simpanan/ajax_filter_jns",$data);
        }    
    }
    
    function cek_tgl_daftar_simpanan(){
        $tglinputan = $this->input->post("tgl");
        $pisah = explode("-", $tglinputan);
        $thn = $pisah[0];
        $bln = $pisah[1];
        $hr  = $pisah[2];
        $tgl = $this->m_simpanan->tgl_tgh_skrng2();
        
        $tgltagihnow = $tgl->tgl_buat_now;
        if($tgltagihnow==NULL){
            echo "";
        }else{
            $pisahnow = explode("-", $tgltagihnow);
            $thnnow = $pisahnow[0];
            $blnnow = $pisahnow[1];
            $hrnow  = $pisahnow[2];
            
            if($thn<$thnnow && $bln<$blnnow || $tglinputan<$tgltagihnow){
                echo "Anda sudah pernah membuat tagihan bulan ini";
            }else{
                echo "";
            }
        }        
    }
    
    function print_daftar_tagihan(){
        
        $data["totalnya"] = $this->m_simpanan->total_tagihan();
        $data['hasil'] = $this->m_simpanan->ambil_print();
        $this->load->view("simpanan/lihat_print",$data);
    }
    
    function print_excel(){
        $data["totalnya"] = $this->m_simpanan->total_tagihan();
        $data['hasil'] = $this->m_simpanan->ambil_print();
        $this->load->view("simpanan/print_excell",$data);
    }
    
    
}
?>
