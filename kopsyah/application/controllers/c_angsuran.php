<?php

class C_angsuran extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model("m_angsuran");
        $this->load->library('pagination');
        session_start();
    }
    
    function index(){
        if(isset($_SESSION['user']) || isset($_SESSION['bagian_umum'])){
            $tgl_awal= $this->input->post('tgl_awal');
            $tgl_ahkir= $this->input->post('tgl_ahkir');

            $data['title']="ANGSURAN";
            $data['isi'] = "angsuran/tbl_angsuran";
            $data['js']="js_angsuran";
            $data['hasil'] = $this->m_angsuran->ambil_transaksi_angsuran($tgl_awal,$tgl_ahkir);
            $this->load->view("template",$data);   
        }else{
            redirect("c_anggota/hak");
        }
    }
    
    function tampil_daftar_angsuran(){
      if(isset($_SESSION['user']) || isset($_SESSION['bagian_umum'])){
          $batas = trim($this->uri->segment(3));
        if($batas!=""){
            $data['ingat']='<script type="text/javascript">
                                       $(document).ready(function(){
                                            alert("quota penagihan untuk pinjaman '.$batas.' melebihi batas \n segera lakukan INCLUDE untuk menghapusnya secara otomatis!!");
                                       });
                            </script>';
                                        
         }
            $tgl_tagih_skrng = $this->m_angsuran->tgl_tgh_skrng();
            $data['hasil'] = $this->m_angsuran->ambil_daftar_angsuran();
            $data["blm"] = $this->m_angsuran->ambil_daftar_sebelumnya($tgl_tagih_skrng); 
            $tanggal = $this->m_angsuran-> tgl_tgh_pernah();
            $periode = $tanggal->tgl_buat_now;
        
        if(isset($periode)){
            $pisah = explode("-", $periode);
            $thn = $pisah[0];
            $bln = $pisah[1];
        
        switch ($bln) {
            case 1:$bulan="January";break;
            case 2:$bulan="February";break;
            case 3:$bulan="Maret";break;
            case 4:$bulan="April";break;
            case 5:$bulan="Mei";break;
            case 6:$bulan="Juni";break;
            case 7:$bulan="Juli";break;
            case 8:$bulan="Agustus";break;
            case 9:$bulan="September";break;
            case 10:$bulan="Oktober";break;
            case 11:$bulan="November";break;
            case 12:$bulan="Desember";break;  
        }
     
            $data['periode'] = $bulan." / ".$thn;
        
        }
            $data['title']="DFTR ANGSURAN";
            $data['js']="js_angsuran";
            $data['isi']="angsuran/dftr_tgh_angsuran";
            $this->load->view("template",$data);
          
          
      }else{
          redirect("c_anggota/hak");
      }  
    }
    
    function tampil_tbl_lunas_angsuran(){
        if($_SESSION['user']=="pengelola"){
            $data['hasil'] = $this->m_angsuran->ambil_status_angsur_belum_lunas();
            $data['title']="PELUNASAN ANGSURAN";
            $data['js']="js_angsuran";
            $data['isi']="angsuran/tbl_pelunasan_angsuran";
            $this->load->view("template",$data);   
        }else{
            redirect("c_anggota/hak");
        }
    }
    
    
    function include_daftar_tagih(){
        $idinclude = $this->input->post('idubah');
        $idpinjam = $this->input->post('pjm');
        $jmlbrs = $this->input->post('jml');
        
        //melihat jumlah angsuran yang berstatus blm lunas dan transaksi NULL
        $ambil_max = $this->m_angsuran->max_angsuran($idpinjam);
        $jml_tagih_proses = $ambil_max->num_rows(); //total tagihan yang masih harus diproses
        
        //melihat jml byr dari angsuran detail angsuran sekarang
        $ambil_max_angsur     = $this->m_angsuran->detail_angsur($idinclude);
        $detail_angsuran      = $ambil_max_angsur->row();
        $jml_byr              = $detail_angsuran->jumlah_bayar;  //dari angsuran
        
        //melihat detail pinjaman 
        $detail_pinjaman = $this->m_angsuran->pilih_pinjaman($idpinjam);
        $batas_include   = $detail_pinjaman->jml_angsuran;
        $ke              = $detail_pinjaman->pembayaran_ke;
        $lunas           = $detail_pinjaman->status_pembayaran;
        
        
        //perhitungan-perhitungan
        $total_tagih = $jml_tagih_proses+$ke;
        $quota = $batas_include-$total_tagih;
               
        if($total_tagih==$batas_include){
           $hapus = $this->m_angsuran->hapus_include($idinclude);
           echo "lebih";
        }elseif($ke!=0 && $total_tagih<$batas_include){
            $tot_bayar_tagih =  $quota*$jml_byr;
            $sisa_pembayaran = $tot_bayar_tagih-$jml_byr;
            $sisa_ulang = $quota-1;
            $masukan_ke_daftar = $this->m_angsuran->masukan_daftar_tagih($idinclude,$sisa_pembayaran,$sisa_ulang);
            echo "masuk";
        }
    }
    
    
   
    function tambah_daftar_angsuran(){
        $tglbuat = $this->input->post("buat_daftar"); 
        $dtpinjaman = $this->m_angsuran->ambil_tbl_pinjaman();
        $jml_baris = $dtpinjaman->num_rows();
        if($jml_baris!=0){
            foreach($dtpinjaman->result() as $data){
            
            $idpinjaman    = $data->id_pinjaman;
            $pokok         = (int) $data->nominal_angsuran;
            $margin        = (int) $data->jml_margin;
            $jml_byr_ulang = (int) $data->jml_angsuran;
            $jml_byr_ke    = (int) $data->pembayaran_ke;
            

                $margin_bulat = round($margin, -3);
                $pokok_bulat = round($pokok, -3);

            $jml_bayar   = $pokok_bulat+$margin_bulat;
            

            //1. perhitungan quota pembuatan untuk yang belum diproses sama sekali
            $ambil_list = $this->m_angsuran->list_angsuran($idpinjaman);
            $jml_list_angsur = $ambil_list->num_rows();
            
            $quota = $jml_byr_ulang-$jml_list_angsur;
            $pengkali = $jml_byr_ulang-$jml_byr_ke;
            $total_tagihan = $jml_list_angsur+$jml_byr_ke;

            //jika semuanya kosong taguhan ke berapa kosong && daftar list juga kosong
            if($jml_byr_ke==0 && $jml_list_angsur==0){
                $total_pinjaman_terahkir = $jml_byr_ulang*$jml_bayar;
                    $sisa = $total_pinjaman_terahkir-$jml_bayar;
                    $sisa_byr_ulang =$jml_byr_ulang-1;      
                $masukan = $this->m_angsuran->daftar_angsuran($idpinjaman,$tglbuat,$jml_bayar,$sisa,$sisa_byr_ulang);
            }elseif($jml_byr_ke==0 && $jml_list_angsur>0 && $jml_list_angsur<$jml_byr_ulang){
                $total_pinjaman_terahkir = $quota*$jml_bayar;
                    $sisa = $total_pinjaman_terahkir-$jml_bayar;
                    $sisa_byr_ulang =$quota-1;      
                $masukan = $this->m_angsuran->daftar_angsuran($idpinjaman,$tglbuat,$jml_bayar,$sisa,$sisa_byr_ulang);  
            }elseif($jml_byr_ke!=0 && $total_tagihan<$jml_byr_ulang){
                    $konstan = $jml_byr_ulang-$total_tagihan;
                    $total_pinjaman_terahkir = $konstan*$jml_bayar;
                    $sisa = $total_pinjaman_terahkir-$jml_bayar;
                    $sisa_byr_ulang = $konstan-1;
                $masukan = $this->m_angsuran->daftar_angsuran($idpinjaman,$tglbuat,$jml_bayar,$sisa,$sisa_byr_ulang);  
            }
          }  
        redirect("/c_angsuran/tampil_daftar_angsuran/");
        }else{
            redirect("/c_pinjaman/index");
        }    
    }
    
    
    function cek_tgl_daftar_angsuran(){
        $tglinputan = $this->input->post("tgl");
        $pisah = explode("-", $tglinputan);
        $thn = $pisah[0];
        $bln = $pisah[1];

        $tgl = $this->m_angsuran->tgl_tgh_pernah();
        $tgltagihnow = $tgl->tgl_buat_now;
        if($tgltagihnow==NULL){
            echo "";
        }else{
            $pisahnow = explode("-", $tgltagihnow);
            $thnnow = $pisahnow[0];
            $blnnow = $pisahnow[1];
            
            if($thn<$thnnow && $bln<$blnnow || $tglinputan<$tgltagihnow){
                echo "Anda sudah pernah membuat tagihan bulan ini";
            }else{
                echo "";
            }
            
        }
        
    }
    
    function transaksi_filter_ajax(){
        $tglfilter = $this->input->post("tgl");
        $tgldftarmax = $this->m_angsuran->tgl_tgh_skrng();
        $tglfilter2 = $tgldftarmax->tgl_buat;
        if($tglfilter<$tglfilter2){
            echo "tanggal transaksi tidak boleh kurang dari tanggal pembuatan daftar tagih";
        }else{
            echo "";
        }
    }
    
    
    function update_status_tunggu(){
        $idangsuran = $this->input->post('id');
        $teks = $this->input->post('teks');
        if($teks=="SELESAI"){
            $update = $this->m_angsuran->ubah_status_tunggu1($idangsuran);
            if($update){
                echo "PROSES";
            }
        }elseif($teks=="PROSES"){
            $update = $this->m_angsuran->ubah_status_tunggu2($idangsuran);
            if($update){
                echo "SELESAI";
            }
        }
        
    }
    
    function update_status_lunas(){
    $idangsur = $this->input->post('sur');
    $idpinjam = $this->input->post('jam');

    //cek tagihan yang belum lunas & id transaksi yang masih nul dari pinjaman 
    $ambil_angsuran = $this->m_angsuran->list_angsuran($idpinjam);
    $jml_list = $ambil_angsuran->num_rows();
    
    //mencari detail pinjaman (sudah pembayaran ke berapa sekarang)
    $detail = $this->m_angsuran->pilih_pinjaman($idpinjam);
    $ke = $detail->pembayaran_ke;
    $batas_update = $detail->jml_angsuran;
    
    $total_tagihan = $jml_list+$ke;
    
   if($total_tagihan<$batas_update){
        $update =  $this->m_angsuran->update_lunas_angsuran($idangsur);
        if($update){
            
         //BEGIN JURNAL UMUM 
         $ambil_detail = $this->m_angsuran->ambil_angsuran_lunas($idangsur);
         $id_trans     = $ambil_detail->id_transaksi;
         $tgl          = $ambil_detail->tanggal;
         $nm_agt       = $ambil_detail->nama_anggota;
         $keterangan   = $nm_agt." ,pembayaran angsuran";
         $angsur_all   = $ambil_detail->jumlah_bayar;
         $nom_angsur   = $ambil_detail->nominal_angsuran;
         
//         $ratusan = (int) substr($nom_angsur, -3);
//         if($ratusan<1000){
//             $nom_angsur_bulat = ($nom_angsur-$ratusan)+1000;
//             $pokok = round($nom_angsur_bulat, -3);
//         }elseif($ratusan==0){
             $pokok = round($nom_angsur, -3);
         //}
         
         $margin = $angsur_all-$pokok;
         
         $masukan_kas    = $this->m_angsuran->masuk_kas($id_trans,$keterangan,$angsur_all);
         $masukan_pokok  = $this->m_angsuran->masuk_piutang($id_trans,$keterangan,$pokok);
         $masukan_margin = $this->m_angsuran->masuk_pendapatan_margin($id_trans,$keterangan,$margin);
         
            
         //END JURNAL UMUM   
 
        //lihat jumlah pembyaran? sebelumnya
        $ambil_ke       = $this->m_angsuran->pilih_pinjaman($idpinjam); 
        $jml_angsuran   = (int) $ambil_ke->jml_angsuran;
    

        //lihat data angsuran, sudah byar berapa kali
        $ambil_sisa = $this->m_angsuran->pilih_angsuran($idpinjam);
        $pembayaran_ke = $ambil_sisa->num_rows();
        if($jml_angsuran==$pembayaran_ke){                
                $update_lunas = $this->m_angsuran->update_lunas_pinjaman($idpinjam,$pembayaran_ke);
                    echo "update lunas";    
                }else{
                    $update_ke = $this->m_angsuran->update_jml_pembayaran_ke($idpinjam,$pembayaran_ke);
                    echo "update belum";
                }
         }
    }else{
        echo "lihat";
    }
 }
    
    function input_transaksi_angsuran(){
        $tgl_transaksi = $this->input->post('id_trans');
        $input_trans = $this->m_angsuran->tambah_transaksi_angsur($tgl_transaksi);
        if($input_trans){
            $tgl_tagih_now = $this->m_angsuran->tgl_tgh_skrng();
            $id_trans = $this->m_angsuran->maxidtrans();
            $id = $id_trans->id;
            //$tgl = $tgl_tagih_now->tgl_buat;
            $simpan = $this->m_angsuran->simpan_transaksi_angsuran($id);
            if($simpan){
                redirect("/c_angsuran/tampil_tbl_lunas_angsuran");
            }
        }  
    }
    
    function koreksi_tbl_transaksi(){
        $a = 923076.938;
        $b = 13846.154;
        
        $c = (int) $a;
        $d = (int) $b;
        $e = round($c, -3)+1000;
        echo $e."<br>";
        $f = round($d, -3)+1000;
        echo $f."<br>";
        $tot = $e+$f;
        echo $tot;
    }
    
    
    
    
    
    
    
    
    
}

?>
