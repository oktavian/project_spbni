<?php

class C_laporan extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model("m_laporan");
        session_start();
    }
    
    function index(){
      if(isset($_SESSION['user'])){
        $awal = $this->input->post('tgl_awal');
        $ahkir = $this->input->post('tgl_ahkir');
        $data['title']="JURNAL UMUM";
        $data['js']="js_laporan";
        $data['isi']="laporan/jurnal_umum";
        $data['hasil']=$this->m_laporan->tampilkan_jurnal($awal,$ahkir);
        $this->load->view("template",$data);   
      }else{
          redirect("c_anggota/hak");
      }  
    }
    
    function basil(){
      if(isset($_SESSION['user'])){
        $anggota = $this->input->post("anggota");
        $tahun   = $this->input->post("tahun_cari");
        
        $data['title']="BAGI HASIL";
        $data['js']="js_laporan";
        $data['isi']="laporan/bagi_hasil";
       //$data['hasil'] = $this->m_laporan->
        
       //cari basil 
        if($anggota!=""){
            $pisah = explode("_",$anggota);
            $id    = $pisah[0];
            $nm    = $pisah[1];
            $keterangan = "pembagian basil untuk_".$id;
            
            $data['idanggota'] = $id;
            $data['nama']      = $nm;
            $data['tahunnya']  = $tahun;
            $data['nilai']     = $this->m_laporan->basil_by_anggota($keterangan,$tahun);
        }
        //$data['total_margin']=$this->m_laporan->ambil_total_margin();
        $data['simpananan_mdh']=$this->m_laporan->ambil_total_mudharabah();
        $data['simpananan_wjb']=$this->m_laporan->ambil_total_wajib();
        $data['total_untung']=$this->m_laporan->ambil_total_pendapatan();
        $this->load->view("template",$data); 
      }else{
          redirect("c_anggota/hak");  
      }   
    }
    
    function bagikanbasil(){
        $tahun = $this->input->post("tahun");
        $cari_pendapatan_tahun = $this->m_laporan->cari_pendapatan($tahun);
        $untung = $cari_pendapatan_tahun->pendapatan;
        
        //hitung masing masing bagian (30:70)
        $bag_kop = $untung*(70/100);
        $bag_agt = $untung-$bag_kop;
        
        //cari simpanan tahun ini
        $simpanan     = $this->m_laporan->simpanan_by_tahun($tahun);
        $simp_per_thn = (int) $simpanan->tot_simp;
        
        //cari margin tahun ini
        $margin      = $this->m_laporan->margin_by_tahun($tahun);
        $mgn_per_thn = (int) $margin->tot_margin;
        
        $pembagi     =  $simp_per_thn+$mgn_per_thn;
        
        //dianggap sudah ahkir tahun
        //amabil anggota
        $tgl_trans = $tahun."-12-31";
        $nama_trans = "pembagian bagi hasil";
        $masuk_transaksi = $this->m_laporan->masukan_transaksi($nama_trans,$tgl_trans);
        if($masuk_transaksi){
            //perhitungan bagi hasil
            $last_id    = $this->m_laporan->pilih_last_id();
            $id         = $last_id->id;
           // echo $id;

            $ambil_agt = $this->m_laporan->ambil_jml_anggota();
            foreach($ambil_agt->result() as $dt){
                $id_anggota = $dt->id_anggota;
                //cari simpanan tiap anggota
                $simp_per_anggota = $this->m_laporan->ambil_simpanan_anggota($id_anggota,$tahun);
                $simpanan_anggota = (int) $simp_per_anggota->total_simpan; 
                //cari margin tiap anggota
                $mrgn_per_anggota = $this->m_laporan->ambil_pinjaman_anggota($id_anggota,$tahun);
                $margin_anggota   = (int) $mrgn_per_anggota->total_margin;
                
                $per_anggota  = ($simpanan_anggota+$margin_anggota)/$pembagi;
                $basil        = $per_anggota*$bag_agt; 
                $bagi_hasil   = (int) $basil;
             
                //echo $bagi_hasil."<br>";
                //jurnalkan
                $keterangan = "pembagian basil untuk_".$id_anggota; 
                $kirim = $this->m_laporan->beban_anggota($id,$keterangan,$basil);
                $this->m_laporan->utang_anggota($id,$keterangan,$basil);
            }
            
                redirect("c_laporan/basil");
       
        }
    }
    

    
    function gl(){
       if(isset($_SESSION['user'])){
            @$akun  = $this->input->post('akun');
            @$bulan = $this->input->post('bulan');
            @$tahun = $this->input->post('tahun');

            if(!empty($akun) && !empty($bulan) && !empty($tahun)){
                $data['hasil']=$this->m_laporan->ambil_dari_jurnal($akun,$bulan,$tahun);
                $data['saldo_debet'] = $this->m_laporan->saldo_debet_jurnal($akun,$bulan,$tahun);
                $data['saldo_kredit']=$this->m_laporan->saldo_kredit_jurnal($akun,$bulan,$tahun);

                $cari_akun = $this->m_laporan->cari_nama_akun($akun);
                $id_akun   = $cari_akun->kode_akun;
                $nama_akun = $cari_akun->nama;
                $data['kd_akun'] = $id_akun;
                $data['nm_akun'] = $nama_akun;

            switch ($bulan) {
                case 1:$bln="January";break;
                case 2:$bln="February";break;
                case 3:$bln="Maret";break;
                case 4:$bln="April";break;
                case 5:$bln="Mei";break;
                case 6:$bln="Juni";break;
                case 7:$bln="Juli";break;
                case 8:$bln="Agustus";break;
                case 9:$bln="September";break;
                case 10:$bln="Oktober";break;
                case 11:$bln="November";break;
                case 12:$bln="Desember";break;  
            }
                $data['ket_tgl'] = $bln." / ".$tahun;
            }

            $data['title']="BUKU BESAR";
            $data['js']="js_laporan";
            $data['isi']="laporan/buku_besar";
            $data['akun']=$this->m_laporan->ambil_akun();

            $this->load->view("template",$data);  
       }else{
           redirect("c_anggota/hak");
       } 
    }
    
    function jurnalkan_pendapatan_basil(){
        $tgl_trans  = $this->input->post("tgl_trans");
        $pend_basil = $this->input->post('pendapatan');
        $nama_trans = "pendapatan-".$pend_basil;
        $masuk_transaksi = $this->m_laporan->masukan_transaksi($nama_trans,$tgl_trans);
        if($masuk_transaksi){
            $id_trans = $this->m_laporan->pilih_last_id();
            $id = $id_trans->id;
            //ketika menerima pendapatan
            $masukan_kas = $this->m_laporan->masukan_kas($id,$pend_basil);
            $masukan_pendapatan = $this->m_laporan->masukan_pendapatan($id,$pend_basil);
            redirect("/c_laporan/basil");            
        }
    }

    function buku_simpanan(){
        $anggota   = $this->input->post('anggota');
        $tgl_awal  = $this->input->post('tgl_awal');
        $tgl_ahkir = $this->input->post('tgl_ahkir');
        
        $pisah = explode("_", $anggota);
        $id = $pisah[0]; 
        $data['hasil'] =$this->m_laporan->buku_simpanan($id,$tgl_awal,$tgl_ahkir);
        $data['all'] = $this->m_laporan->total_simpan_anggota($id,$tgl_awal,$tgl_ahkir);
        $data['tot_wjb'] = $this->m_laporan->total_simpan_wjb($id,$tgl_awal,$tgl_ahkir); 
        $data['tot_mdh'] = $this->m_laporan->total_simpan_mdh($id,$tgl_awal,$tgl_ahkir);
      
        $data['title']="BUKU SIMPANAN";
        $data['js']="js_laporan";
        $data['isi']="laporan/buku_anggota_simpanan";
        $this->load->view("template",$data);
    }
    
    function buku_pinjaman(){
        
        $anggota   = $this->input->post('anggota');
        $tgl_awal  = $this->input->post('tgl_awal');
        $tgl_ahkir = $this->input->post('tgl_ahkir');
        $pinjam    = $this->input->post('idpinjam');
        
        $pisah = explode("_", $anggota);
        $id    = $pisah[0];
        
        $pisah2   = explode("_",$pinjam);
        $idpinjam = $pisah2[0];
        
        //$data['pinjaman'] = $this->m_laporan->pinjman_by_id($id);
        
        $data['hasil']=$this->m_laporan->pinjaman_by_anggota($idpinjam,$id,$tgl_awal,$tgl_ahkir);
        $data['ket_pinjam'] = $this->m_laporan->ambil_ket_pinjaman($idpinjam,$id);
        $data['title']="BUKU PINJAMAN";
        $data['js']="js_laporan";
        $data['isi']="laporan/buku_anggota_pinjaman";
        
        
        $this->load->view("template",$data);
    }
    
    function laporan_simpanan(){
        if($this->input->post('bln_simp')!="" && $this->input->post("thn_simp")!=""){
            $bln_simpan = $this->input->post('bln_simp');
            $thn_simpan = $this->input->post("thn_simp");
                    
        switch ($bln_simpan) {
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

            $data['ket'] = $bulan." / ".$thn_simpan;
            $data['hasil'] = $this->m_laporan->ambil_laporan_simpanan($bln_simpan,$thn_simpan);
        }
        $data['title']="LAPORAN PINJAM";
        $data['js']="js_laporan";
        $data['isi'] = "laporan/laporan_simpanan";
        $this->load->view("template",$data);
    }
    
    function laporan_pinjaman(){
        if($this->input->post("bln_pjm")!="" && $this->input->post("thn_pjm")!=""){
            $bln_pinjam = $this->input->post("bln_pjm");
            $thn_pinjam = $this->input->post("thn_pjm");
   
          switch ($bln_pinjam){
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
        
        $data['ket'] = $bulan." / ".$thn_pinjam;
        $data['hasil']=$this->m_laporan->ambil_laporan_pinjaman($bln_pinjam,$thn_pinjam);
            
        }
        
        $data['title']="LAPORAN PINJAM";
        $data['js']="js_laporan";
        $data['isi'] = "laporan/laporan_pinjaman";
        $this->load->view("template",$data);
    }
    
    function auto_id_pinjam(){
        $autocari = $this->input->get('q');
        if(!$autocari) return;
        $munculkan = $this->m_laporan->pilih_pinjaman($autocari);
        
        foreach($munculkan->result() as $data){
            echo $data->pilihan."\n";
        }
    }
    
    

    
}

?>
