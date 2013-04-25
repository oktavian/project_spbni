<?php
class C_anggota extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model("m_anggota");
        $this->load->library('pagination');
        session_start();
    } 
    
    function index(){
        
     $akses = $this->input->post("username");
     $password = $this->input->post("pass");
         
     if(isset($akses) && isset($password)){
           $ambil_id       = $this->m_anggota->select_anggota($akses,$password);
           $jml            = $ambil_id->num_rows();
           $ambil_kolom    = $ambil_id->row();
           @$id_anggota    = $ambil_kolom->id_anggota;
           @$nama_anggota  = $ambil_kolom->nama_anggota;
             
           if($jml==1){
                $_SESSION['anggota_id']=$id_anggota;
                $_SESSION['nama_user']=$nama_anggota;
                redirect("c_anggota/home_anggota");
           }elseif($jml==0){
                $ambil_pengguna = $this->m_anggota->select_pengguna($akses,$password);
                $ambil          = $ambil_pengguna->row();
                @$user          = $ambil->username;
                @$nama          = $ambil->nama;
                $jml_pengguna   = $ambil_pengguna->num_rows();
                
                if($jml_pengguna==1 && $user=="pengelola"){
                    $_SESSION['user']      = $user;
                    $_SESSION['nama_user'] = $nama;
                    redirect("c_anggota/home");
                }elseif($jml_pengguna==1 && $user=="ketua"){
                    $_SESSION['user']      = $user;
                    $_SESSION['nama_user'] = $nama;
                    redirect("c_anggota/home");
                }elseif($jml_pengguna==1 && $user=="bagian umum"){
                    $_SESSION['bagian_umum']      = $user;
                    $_SESSION['nama_user']        = $nama;
                    redirect("c_anggota/home");
                }
           
          }
     }
       
        if(isset($_SESSION['anggota_id'])){
            redirect("c_anggota/home_anggota");
        }elseif(isset($_SESSION['bagian_umum'])){
            redirect("c_anggota/home_bagumum");
        }elseif(isset($_SESSION['user'])){
            redirect("c_anggota/home");
        }else{
          $data['title'] = "LOGIN"; 
          $data['isi'] = "login/login"; 
          $this->load->view("template",$data);  
        }
    }
  
    function home_anggota(){
        if(isset($_SESSION['anggota_id'])){
            $id = $_SESSION['anggota_id'];
            $data['title'] = "HOME ANGGOTA";
            $data['js'] = "js_anggota";
            $data['hasil'] = $this->m_anggota->iden_anggota($id);
            $data['isi'] = "anggota/aktif/buku_simpan_pinjam";
            $this->load->view("template",$data);
        }else{
            redirect("c_anggota/hak");
        }
    }
    

    
    function home(){
        if(isset($_SESSION['user']) || isset($_SESSION['bagian_umum'])){
           $data["title"] = "HOME";
           $data['js'] = "js_anggota";
           $data["isi"] = "home/home"; 
           $this->load->view("template",$data); 
        }else{
            redirect("c_anggota/hak");
        }
    }
    
    function tblanggota($start_row=''){
      if(isset($_SESSION['user']) || isset($_SESSION['bagian_umum'])){
       $data["title"] = "TBL ANGGOTA";
       $data['js'] = "js_anggota";
       $data["isi"] = "anggota/tblanggota";
       $data['hasil'] = $this->m_anggota->allanggota();
       $data['out'] = $this->m_anggota->jmlout();
       $data['ttp'] = $this->m_anggota->jmlttp();
       $this->load->view("template",$data);   
      }else{
          redirect("c_anggota/hak");
      }
    }
    
    function buku_simpanan(){
     if(isset($_SESSION['anggota_id'])){
        $id = $_SESSION['anggota_id'];
        $awal  = $this->input->post("tgl_awal");
        $ahkir = $this->input->post("tgl_ahkir");

        $data['title']="BUKU SIMPANAN";
        $data['js']="js_anggota";
        $data['isi']="anggota/aktif/buku_simpanan"; 
        $data['nama']=$this->m_anggota->ambil_nama_anggota($id);
        $data['hasil']=$this->m_anggota->simpanan_by_anggota($id,$awal,$ahkir);
        $data['tot'] = $this->m_anggota->total_simpan_anggota($id,$awal,$ahkir);
        $data['tot_wjb'] = $this->m_anggota->total_simpan_wjb($id,$awal,$ahkir);
        $data['tot_mdh'] = $this->m_anggota->total_simpan_mdh($id,$awal,$ahkir);
        
        $this->load->view("template",$data);
     }   
        
    }
    
    function buku_pinjaman(){
     if(isset($_SESSION['anggota_id'])){
        $id       = $_SESSION['anggota_id'];
        $idpinjam = $this->input->post("id_pinjam"); 
        $awal     = $this->input->post("tgl_awal");
        $ahkir    = $this->input->post("tgl_ahkir");
        
        $data['title']="BUKU PINJAMAN";
        $data['js']="js_anggota";
        $data['isi']="anggota/aktif/buku_pinjaman";
        $data['allpinjam'] = $this->m_anggota->ambil_pinjaman_anggota($id);
        $data['ket_pinjam'] = $this->m_anggota->ambil_ket_pinjaman($idpinjam,$id);
        $data['hasil']=$this->m_anggota->pinjaman_by_anggota($idpinjam,$id,$awal,$ahkir);
        $this->load->view("template",$data);
     }   
        
    }
    
    function fmaddanggota(){
      if($_SESSION['user']=="pengelola"){
          $data['title'] = "FM ANGGOTA";
          $data['js'] = "js_anggota";
          $data["isi"] = "anggota/fm_add_anggota"; 
          $this->load->view("template",$data);
       }else{
           redirect("c_anggota/hak");
       } 
    }
    
    function fmeditanggota($idanggota){
       if($_SESSION['user']=="pengelola"){
           $data['title'] = "FM ANGGOTA";
           $data['js'] = "js_anggota";
           $data["isi"] = "anggota/fm_edit_anggota";

           $data["editan"]=$this->m_anggota->ambilbyid($idanggota);
           $this->load->view("template",$data);
       }else{
         redirect("c_anggota/hak");  
       } 
    }
    
    function proses_add_anggota(){
        
        $id_identitas = $this->input->post('ididentitas');
        $nama_anggota = $this->input->post('nmanggota');
        $tgl_masuk = $this->input->post('tglmasuk');
        $tgl_lahir = $this->input->post('tgllahir');
        $almt_anggota = $this->input->post('almt');
        $no_telp = $this->input->post('tlp');
        $jabatan = $this->input->post('jbt');
        $status_peg = $this->input->post('sts');
        $estmasi_byr = $this->input->post('estimasi');

        $id_anggota = $this->m_anggota->dptid();
        $data =  $this->m_anggota->simpananggota($id_anggota, $id_identitas,$nama_anggota,$tgl_masuk,$tgl_lahir,$almt_anggota,$no_telp,$jabatan,$status_peg,$estmasi_byr);
        if($data==true){
            redirect("/c_anggota/tblanggota/","location");
        }else{
            echo "ada yang salah";
        }
    
       
    }
    
    function proses_edit_anggota(){
        
        $id_anggota = $this->input->post('idgta');
        $id_identitas = $this->input->post('ididentitas');
        $nama_anggota = $this->input->post('nmanggota');
        $tgl_masuk = $this->input->post('tglmasuk');
        $tgl_lahir = $this->input->post('tgllahir');
        $almt_anggota = $this->input->post('almt');
        $no_telp = $this->input->post('tlp');
        $jabatan = $this->input->post('jbt');
        $status_peg = $this->input->post('sts');
        $estmasi_byr = $this->input->post('estimasi');
        
        $data =  $this->m_anggota->editanggota($id_anggota, $id_identitas,$nama_anggota,$tgl_masuk,$tgl_lahir,$almt_anggota,$no_telp,$jabatan,$status_peg,$estmasi_byr);
        if($data==true){
            redirect("/c_anggota/tblanggota","location");
        }else{
            echo "ada yang salah";
        }
    }
  /*  
    function proses_hapus_anggota($idanggota){
        
        $data = $this->m_anggota->hapusanggota($idanggota);
        if($data==true){
            redirect("/c_anggota/tblanggota","location");
        }else{
            echo "ada yang salah";
        }
    }
   * 
   */
    
    
    function detail_ajax_anggota(){
        
        $idanggota = $this->input->post('idgt');
        $data['hasil']=$this->m_anggota->ambil_detail_anggota($idanggota);
        $this->load->view("anggota/detail_anggota",$data);
    }

/*    
    function cari_anggota(){
            $ajax_cari = $this->input->post('pil');
            $cr = $this->input->post('valcari');
            
            if($ajax_cari=="id"){
                $data['hasil']=$this->m_anggota->anggota_by_id($cr);
            }elseif($ajax_cari=="nm"){
                $data['hasil']=$this->m_anggota->anggota_by_nm($cr);
            }
            $this->load->view("anggota/cari_anggota_ajax",$data);
    }
 * 
 */
    
    function keluar(){
        session_destroy();
        redirect("c_anggota/index");
    }
    
    function hak(){
        $data['title'] = "NO ACCES!";
        $data['js'] = "js_anggota";
        $data['isi'] = "login/no_hak";
        $this->load->view("template",$data);
    }

}

?>
