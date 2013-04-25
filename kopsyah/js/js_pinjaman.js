$(document).ready(function(){
    
    $('#tgl_pinjam, #nominal, #jmlangsur, .tombol_pinjam, .btl_tombol').attr("disabled", "disabled").addClass("ngeblur");
    $('#tgl_pinjam').next().hide();
    
    //validasi anggota
    $('#anggota').autocomplete("http://localhost/kopsyah/c_pinjaman/auto_id_anggota",{
        width:350
    });
    
    $('#anggota').result(function(event,data,formatted){
        $.ajax({
                type:"POST",
                url:"http://localhost/kopsyah/c_pinjaman/auto_peminjam",
                data:"id="+formatted,
                success:function(data){
                    $('#ket_peminjam').html(data).show();
                },
                error:function(xhr,ajaxOptions,thrownError){
                    alert(ajaxOptions);
                }
        });
    });
    
    //anggota
    $('#anggota').keyup(function(){
        var aggt = $(this).val();
        var aggtlen = aggt.length;
        if(aggt!=""){
            $('#anggota_pesan .error').hide();
            $('#anggota_pesan .valid').show();
        }else{
            $('#anggota_pesan .error').show();
            $('#anggota_pesan .valid').hide();
        }  
    });
    
    
    //tanggal
    $('#tgl_pinjam').change(function(){
       var agt = $('#anggota').val();
       var tgl = $('#tgl_pinjam').val();
       //alert(agt);
       var pisah = agt.split("_");
       var id = pisah[0];
       $('#idanggota').val(id);
       $('#anggota').attr("disabled","disabled");
       
        if(tgl!=""){
            $('#tgl_pinjam_pesan .error').hide();
            $('#tgl_pinjam_pesan .valid').show();
            $('#tgl_pinjam').removeAttr("masiherror");
        }else{
            $('#tgl_pinjam_pesan .valid').hide();
            $('#tgl_pinjam_pesan .error').show();
            $('#tgl_pinjam').attr("masiherror","ya");
        }        
    });
    
    $('#tgl_pinjam').keyup(function(){
        alert("input tanggal jangan diketik");
        var ketik = $(this).val();
        if(ketik!=""){
            $('#tgl_pinjam_pesan .error').text("salah cara penginputan").show();
            $('#tgl_pinjam_pesan .valid').hide();
            $('#tgl_pinjam').attr("masiherror","ya");
        }else{
            $('#tgl_pinjam_pesan .error').text("tidak boleh kosong").show();
            $('#tgl_pinjam_pesan .valid').hide();
            $('#tgl_pinjam').attr("masiherror","ya");
        }
    });
    
 //nominal   
    $('#nominal').keyup(function(i){
        var idangot = $('#idanggota').val() 
        var nilai = $(this).val();
        var nilailen = nilai.length;
        var isian = nilai.charAt(i).charCodeAt(0);
        var lanjut = 0;
        if(isian<48 || isian>57){
           $('#nominal_pesan .error').text("isikan angka").show();
           $('#nominal_pesan .valid').hide();
           $('#nominal').attr("masiherror","ya");
        }else if(nilai=="" || nilai==0){
           $('#nominal_pesan .error').text("tidak boleh kosong").show();
           $('#nominal_pesan .valid').hide(); 
           $('#jmlangsur').attr("disabled","disabled").addClass("ngeblur");
        }
        else{
            $('#nominal_pesan .valid').show();
            $('#nominal_pesan .error').hide();
            $('#jmlangsur').removeAttr("disabled").removeClass("ngeblur");
            $('#nominal').removeAttr("masiherror","ya");
            lanjut = 1;
        }
        if(lanjut==1){    
            $.ajax({
                type:"POST",
                url:"http://localhost/kopsyah/c_pinjaman/filter_nilai_pinjaman",
                data:"id="+idangot+"&n="+nilai,
                success:function(data){
                    //alert(data);
                    if(data=="out"){
                        alert("nominal pinjaman untuk pegawai outsourcing melebih batas");
                    }else if(data=="tetap"){
                        alert("nominal pinjaman untuk pegawai tetap melebih batas");
                    }
                }
            }); 
        }
    });
    
//jml byr 
$('#jmlangsur').change(function(){
    /*
    var jml = $(this).val();
    var nom = $('#nominal').val();
    var angsur = nom/jml;
    var format = angsur.toFixed(3);
    */
   var jml = $(this).val();
   var nom = $('#nominal').val(); 
   
   var pokok  = parseFloat(nom)/jml;
   var margin = pokok*(1.5/100);
   var angsur = pokok+parseFloat(margin);
   
   var format = angsur.toFixed(2);
   
    if(jml!=""){
        $('#jmlangsur_pesan .valid').show();
        $('#jmlangsur_pesan .error').hide();
        $('#munculjml').show();
        $('#nominal').attr("disabled","disabled");
        $('#hdnominal').val(nom);
       
        $('#jml_angsuran').val(format).attr("disabled","disabled");
        $('#hdjml_angsuran').val(format);
        //alert("nominal angsur Rp. "+format);
       alert(format);
    }else{
        $('#nominal').removeAttr("disabled");
        $('#munculjml').hide();
        $('#jmlangsur_pesan .valid').hide();
        $('#jmlangsur_pesan .error').show();
    }
});

//submit
$('.tombol_pinjam').click(function(e){
    var valtgl = $('#tgl_pinjam').val();
    var valnom = $('#nominal').val();
    var jml = $('#jmlangsur').val();
    
    var tglattr = $('#tgl_pinjam').attr("masiherror");
    var nomattr = $('#nominal').attr("masiherror");
    
    if(valtgl=="" || valnom=="" || jml=="" || tglattr=="ya" || nomattr=="ya"){
        e.preventDefault();
        alert("inputan masih error!");
 }
 
 });
    
//reset    
$('.btl_tombol').click(function(){
    $('#ket_peminjam').hide();
    $('#munculjml').hide();
    $('#anggota').removeAttr("disabled");
    $('#tgl_pinjam, #nominal, #jmlangsur, .tombol_pinjam, .btl_tombol').attr("disabled", "disabled").addClass("ngeblur");
    $('#tgl_pinjam').next().hide();
    $('.error').text("tidak boleh kosong").show();
    $('.valid').hide();
});

//tabel pinjaman
$('#tabel_pinjam').dataTable({
    "sPaginationType":"full_numbers",
    "fnDrawCallback":function(){
         $('.acc_edit').click(function(){  
          var x = confirm("apakah anda yakin akan meng-acc pinjaman ini?");
          if(x==true){
              var idpinjm = $(this).attr("diacc");
              var teks = $(this).text();
                    $.ajax({
                        type:"POST",
                        url:"http://localhost/kopsyah/c_pinjaman/update_acc",
                        data:"id="+idpinjm+"&tx="+teks,
                        success:function(data){
                        $('#id_'+idpinjm).text("ACC");
                        $('#id_'+idpinjm).removeAttr("class");
                        }
            });
          } 
        });
    }
}).columnFilter({
    aoColumns:[
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        {type:"select",value:["lunas","belum lunas"]},
        null
    ]
});




});


