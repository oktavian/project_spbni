$(document).ready(function(){
   
   $('#idformdftr').submit(function(e){
        var tgldaftar = $('#buat_daftar').val();
        if(tgldaftar==""){
            e.preventDefault();
            alert("inputan tidak boleh kosong");
        }else{
             $.ajax({
                type:"POST",
                url:"http://localhost/kopsyah/c_angsuran/cek_tgl_daftar_angsuran",
                data:"tgl="+tgldaftar,
                success:function(data){
                    if(data.length > 0){
                        alert(data);
                    }else{
                        $("#idformdftr").unbind('submit');
                        $("#idformdftr").submit();
                        //alert("yang dipilih ini");
                    }
                }
            });
        e.preventDefault();
       }
    });
    
 //update pelunasan angsuran   
    $('#filter_angsuran').dataTable({
        "sPaginationType":"full_numbers",
        "fnDrawCallback":function(){
            $('.update_angsur').click(function(){
                var id = $(this).attr("idangsur");
                var tx = $(this).attr("stat");
                $.ajax({
                    type:"POST",
                    url:"http://localhost/kopsyah/c_angsuran/update_status_tunggu",
                    data:"id="+id+"&teks="+tx,
                    success:function(data){
                        if(data=="SELESAI"){
                            $('#id_'+id).attr("stat",data);
                            $('#id_'+id).html("<img src='http://localhost/kopsyah/css/images/icon/valid-icon.jpg' width='20' title='selesai' />");
                        }else if(data=="PROSES"){
                            $('#id_'+id).attr("stat",data);
                            $('#id_'+id).html("<img src='http://localhost/kopsyah/css/images/icon/warning-icon.jpg' width='20' title='sedang diproses...' />");
                        }
                    }
                });
            });
        }
    });
    
    //tabel pelunasan angsur
    $('#filter_lunas_angsur').dataTable({
        "sPaginationType":"full_numbers",
        "fnDrawCallback":function(){
            $('.ganti_status').click(function(){
                var idsur = $(this).attr("idangsur");
                var idjam = $(this).attr("idpinjam");
                $.ajax({
                    type:"POST",
                    url:"http://localhost/kopsyah/c_angsuran/update_status_lunas",
                    data:"sur="+idsur+"&jam="+idjam,
                    success:function(data){
                      if(data=="update lunas"){
                        window.location.href = "http://localhost/kopsyah/c_pinjaman/index/"+idjam;
                      }else if(data=="lihat"){
                          window.location.href = "http://localhost/kopsyah/c_angsuran/tampil_daftar_angsuran/"+idjam;
                      }else if(data=="update belum"){
                         location.reload();
                      }
                    }
                });
            });
        }
    });
    
 //tabel transaksi
 $('#filter_tbl_transaksi').dataTable({
     "sPaginationType":"full_numbers"
 });
 
 //tabel daftar sebelumnya
 $('#filter_tagih_sebelumnya').dataTable({
     "sPaginationType":"full_numbers",
     "fnDrawCallback":function(){
         $('.include_angsur').click(function(){
            //createCookie("dftr2",'angsuran',1);
            var sebelumnya = $(this).attr("idangsur");
            var pjm = $(this).attr("idpjm");
            var jumlah = $(this).attr("jmlbrs");
            $.ajax({
                type:"POST",
                url:"http://localhost/kopsyah/c_angsuran/include_daftar_tagih",
                data:"idubah="+sebelumnya+"&pjm="+pjm+"&jml="+jumlah,
                success:function(data){
                    if(data=="masuk"){
                      location.reload();
                       //alert(data);
                    }else if(data=="lebih"){
                        alert("Penagihan yang melebihi batas otomatis akan dihapus!!");
                        location.reload();
                    }
                }
            });
        });
     }
 });
   
  //tombol-tombol transaki
  $('#tombol_transaksi').click(function(){
      $('#box_transaksi_angsur').toggle();
  });
  
  $('#buat_dftr_angsur').click(function(){
      $('#box_buat_angsur').toggle();
  });
  
  $('#dftr_angsur').click(function(){
      $('#box_dftr_angsur').toggle();
  });
  
  //filter transaksi angsur
   $('#filter_transaksi_angsur').submit(function(e){
        var tgltrans = $('#id_trans').val();
        if(tgltrans==""){
            e.preventDefault();
            alert("inputan tidak boleh kosong");
        }else{
            $.ajax({
                type:"POST",
                url:"http://localhost/kopsyah/c_angsuran/transaksi_filter_ajax",
                data:"tgl="+tgltrans,
                    success:function(data){
                    if(data.length>0){
                        alert(data);
                    }else{
                        $("#filter_transaksi_angsur").unbind('submit');
                        $("#filter_transaksi_angsur").submit();
                    }  
                } 
            });
            e.preventDefault();
        }
    });
  
  
  
  
  
});