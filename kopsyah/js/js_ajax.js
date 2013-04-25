$(document).ready(function(){
    
    $('.tabel_selingan1 tr:odd').css("background","rgb(211, 214, 255)");

//SIMPANAN
    $('.update_status_lunas').click(function(e){
        
        e.preventDefault();
        var id_daftar = $(this).attr("idstatus");
        var sts_daftar = $(this).attr("statustagih");
        //alert(sts_daftar);
       
        $.ajax({
            type:"POST",
            url:"http://localhost/kopsyah/c_simpanan/update_status_tagih",
            data:"idsts="+id_daftar+"&sts="+sts_daftar,
            dataType:"json",
            success:function(data){
                //alert(data.stat);
                $('#id_'+data.idgmbr).html(data.gmbr);
                $('#id_'+data.idgmbr).attr("statustagih",data.stat);
            }           
        });
     });
     
//ANGGOTA
    $('.hover_anggota').click(function(e){
    var top = e.clientY-200;
    var left = e.clientX-200;
    //var right = e.cl
    e.preventDefault();
        var idanggota = $(this).attr("hoveranggota");
        $.ajax({
            type:"POST",
            url:"http://localhost/kopsyah/c_anggota/detail_ajax_anggota",
            data:"idgt="+idanggota,
            success:function(data){
                //alert(data);
                $('#tbl_detail_anggota').html(data).toggle().css("margin-left",left).css("margin-top",top);
                $('.box_keterangan').toggle();
            }           
        }); 
    });
    
//PINJAMAN
$('#ya').click(function(){
    $('#konfirm').slideUp("slow");
    $('#tgl_pinjam, #nominal, .tombol_pinjam, .btl_tombol').removeAttr("disabled").removeClass("ngeblur");
    $('#tgl_pinjam').next().show();
});

$('#tidak').click(function(){
   $('#ket_peminjam').slideUp("slow");
});

    
});