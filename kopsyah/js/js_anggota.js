$(document).ready(function(){
var agt_tabel = $('#tabelanggota').dataTable({ 
                "sPaginationType":"full_numbers",
                "fnDrawCallback":function(){
                 $("a.hover_anggota").click(function(e){
                    var top = e.clientY-200;
                    var left = e.clientX-200;
                    e.preventDefault();
                        var idanggota = $(this).attr("hoveranggota");
                        $.ajax({
                            type:"POST",
                            url:"http://localhost/kopsyah/c_anggota/detail_ajax_anggota",
                            data:"idgt="+idanggota,
                            success:function(data){
                                $('#tbl_detail_anggota').html(data).toggle().css("margin-left",left).css("margin-top",top);
                                $('.box_keterangan').toggle();
                            }           
                        }); 
                    });
                },
                "aoColumns":[
                    {"bSortable": false},
                    null,
                    null,
                    null,
                    {"bSortable": false},
                    {"bSortable": false},
                    {"bSortable": false}
                ]
            });
            
     //agt_tabel.fnSort([[0,'asc']]);

    //konfigurasi input pencarian 
    $('#cr').change(function(){
        var vl = $(this).val();
          if(vl=="id"){
            $('#crsil').show();
            //$('#sil').attr("size","8");
           }else if(vl=="nm"){
            $('#sil').removeAttr("size");   
            $('#crsil').show();   
          }else if(vl==""){
            $('#crsil').hide();
            $(this).attr("selected","selected");
          }
    });
    
    $('#sil').keyup(function(){
        var cara = $('#cr').val();
        if(cara=="id"){
            agt_tabel.fnFilter($(this).val(), 1);
        }else if(cara=="nm"){
            agt_tabel.fnFilter($(this).val(), 2);
        }
    });
    
/*    
    $('#sil').keyup(function(){
        var crby = $('#cr').val();
        var cr = $(this).val();
        var crleng = cr.length;
        
        if(crleng!=0){
            $.ajax({
                type:"POST",
                url:"http://localhost/kopsyah/c_anggota/cari_anggota",
                data:"pil="+crby+"&valcari="+cr,
                success:function(data){
                    //$('#tabelanggotaajax').show();
                    $('#tabelanggota').hide();
                    $('.halaman').hide();
                    $('.kanan').hide();
                    $('#hasil_ajax').html(data).show();
                }
             });
        }else if(crleng==0 || cr==""){
            $('#tabelanggota').show();
            $('.halaman').show();
            $('.kanan').show();
            $('#hasil_ajax').hide();
        }     
    }); 
 */  
    
    
    
    //Validasi Anggota
    //1.identitas pegawai
    $('#ididentitas').keyup(function(i){
        var iden = $(this).val();
        var pnjngiden = iden.length;
        //alert(pnjngiden);
            var c = iden.charAt(i).charCodeAt(0);
            if(c<48 || c>57){
                $('.ididentitas_pesan .error').text("isikan angka").show();
                $('#ididentitas').attr("tidakvalid", "yes");
                $('.ididentitas_pesan .valid').hide();
            }else if(pnjngiden==0){
                $('.ididentitas_pesan span.error').text("tidak boleh kosong").show();
                $('#ididentitas').attr("tidakvalid", "yes");
                $('.ididentitas_pesan .valid').hide();
            }else if(pnjngiden>8){
                $('.ididentitas_pesan span.error').text("maximal 8 digit karakter").show();
                $('#ididentitas').attr("tidakvalid", "yes");
                $('.ididentitas_pesan .valid').hide();
            }else{
                $('#ididentitas').removeAttr("tidakvalid");
                $('.ididentitas_pesan .error').hide();
                $('.ididentitas_pesan .valid').show();
            }

    });
    
    //2. nama anggota
    $('#nmanggota').keyup(function(i){
        var nmagta = $(this).val();
        var pnjngnm = nmagta.length;
        
        var c = nmagta.charAt(i).charCodeAt(0);
        if((c >=65 && c<=90) || (c>=97 && c<=122)){
            $('#nmanggota').removeAttr("tidakvalid");
            $('.nmanggota_pesan .error').hide();
            $('.nmanggota_pesan .valid').show();
        }else if(pnjngnm==0){
            $('.nmanggota_pesan span.error').text("tidak boleh kosong").show();
            $('#nmanggota').attr("tidakvalid", "yes");
            $('.nmanggota_pesan .valid').hide();
        }else if(pnjngnm>20){
            $('.nmanggota_pesan span.error').text("20 karakter saja").show();
            $('#nmanggota').attr("tidakvalid", "yes");
            $('.nmanggota_pesan .valid').hide();
        }else{
            $('.nmanggota_pesan .error').text("isikan huruf").show();
            $('#nmanggota').attr("tidakvalid", "yes");
            $('.nmanggota_pesan .valid').hide();
        } 
    });

//3. tgl-tgl form
    $('#tglmasuk').change(function(){
       var suk = $(this).val();
       var pnjngsuk = suk.length;
       if(pnjngsuk==0){
         $('.tglmasuk_pesan .error').text("tidak boleh kosong").show();
         $('#tglmasuk').attr("tidakvalid", "yes");
         $('.tglmasuk_pesan .valid').hide();  
       }else{
         $('#tglmasuk').removeAttr("tidakvalid");
         $('.tglmasuk_pesan .error').hide();
         $('.tglmasuk_pesan .valid').show();   
       } 
    });
//4. tgl-lahir
    $('#tgllahir').change(function(){
       var lhr = $(this).val();
       var pnjnglhr = lhr.length;
       if(pnjnglhr==0){
         $('.tgllahir_pesan .error').text("tidak boleh kosong").show();
         $('#tgllahir').attr("tidakvalid", "yes");
         $('.tgllahir_pesan .valid').hide();  
       }else{
         $('#tgllahir').removeAttr("tidakvalid");
         $('.tgllahir_pesan .error').hide();
         $('.tgllahir_pesan .valid').show();   
       } 
    });
 //5.alamat
    $('#almt').keyup(function(){
        var mat = $(this).val();
        var matleng = mat.length;
        
        if(matleng==0){
         $('.almt_pesan .error').text("tidak boleh kosong").show();
         $('#almt').attr("tidakvalid", "yes");
         $('.almt_pesan .valid').hide();  
        }else if(matleng>100){
         $('.almt_pesan .error').text("maximal 100 karakter").show();
         $('#almt').attr("tidakvalid", "yes");
         $('.almt_pesan .valid').hide();
        }else{
         $('#almt').removeAttr("tidakvalid");
         $('.almt_pesan .error').hide();
         $('.almt_pesan .valid').show();   
        }  
    });
//5. no telp
$('#tlp').keyup(function(i){
    var tl = $(this).val();
    var tlleng = tl.length;
    var c = tl.charAt(i).charCodeAt(0);
    if(c<48 || c>57){
        $('.tlp_pesan .error').text("isikan angka").show();
        $('#tlp').attr("tidakvalid", "yes");
        $('.tlp_pesan .valid').hide();
    }else if(tlleng==0){
        $('.tlp_pesan .error').text("tidak boleh kosong").show();
        $('#tlp').attr("tidakvalid", "yes");
        $('.tlp_pesan .valid').hide();
    }else if(tlleng>12){
        $('.tlp_pesan .error').text("no telp cukup 12 angka saja").show();
        $('#tlp').attr("tidakvalid", "yes");
        $('.tlp_pesan .valid').hide();
    }else{
        $('#tlp').removeAttr("tidakvalid");
        $('.tlp_pesan .error').hide();
        $('.tlp_pesan .valid').show();
    }  
});

//6 jabatan 
$('#jbt').keyup(function(i){
    var jb = $(this).val();
    var jbleng = jb.length;
    var c = jb.charAt(i).charCodeAt(0);
    if((c>=65 && c<=90) || (c>=97 && c<=122)){
       $('#jbt').removeAttr("tidakvalid");
       $('.jbt_pesan .error').hide();
       $('.jbt_pesan .valid').show(); 
    }else if(jbleng==0){
        $('.jbt_pesan .error').text("tidak boleh kosong").show();
        $('#jbt').attr("tidakvalid", "yes");
        $('.jbt_pesan .valid').hide();
    }else{
        $('.jbt_pesan .error').text("isikan huruf").show();
        $('#jbt').attr("tidakvalid", "yes");
        $('.jbt_pesan .valid').hide();
    }
    
});

//7 status
$('#sts').change(function(){
    var st = $(this).val();
    if(st==""){
       $('.sts_pesan .error').text("harus dipilih").show();
       $('#sts').attr("tidakvalid", "yes");
       $('.sts_pesan .valid').hide(); 
    }else{
       $('#sts').removeAttr("tidakvalid");
       $('.sts_pesan .error').hide();
       $('.sts_pesan .valid').show();
    }
});

//8 estimasi bayar
$('#estimasi').keyup(function(i){
    var esti = $(this).val();
    var estileng = esti.length;
    var c = esti.charAt(i).charCodeAt(0);
    var lanjut = 1;
    if(c<48 || c>57){
        $('.estimasi_pesan .error').text("isikan angka").show();
        $('#estimasi').attr("tidakvalid", "yes");
        $('.estimasi_pesan .valid').hide();
        lanjut = 0;
    }else if(estileng==0){
        $('.estimasi_pesan .error').text("maximal nominal 3000000 (optional)").show();
        $('#estimasi').removeAttr("tidakvalid");
        //$('#estimasi').attr("tidakvalid", "yes");
        $('.estimasi_pesan .valid').hide();
        lanjut = 0;
    }else{
        $('#estimasi').removeAttr("tidakvalid");
        $('.estimasi_pesan .error').hide();
        $('.estimasi_pesan .valid').show();
    }
    
    if(lanjut==1){
        if(esti>3000000){
           $('.estimasi_pesan .error').text("maximal nominal 3000000").show();
           $('#estimasi').attr("tidakvalid", "yes");
           $('.estimasi_pesan .valid').hide(); 
        }else{
           $('#estimasi').removeAttr("tidakvalid");
           $('.estimasi_pesan .error').hide();
           $('.estimasi_pesan .valid').show(); 
        }
    }
   
});

$('#formanggota .submit').click(function(e){
    var n_iden = $('#ididentitas').val();
    var n_nm = $('#nmanggota').val();
    var n_tglsuk = $('#tglmasuk').val();
    var n_tglhir = $('#tgllahir').val();
    var n_mat = $('#almt').val();
    var n_tlp = $('#tlp').val();
    var n_jbt = $('#jbt').val();
    var n_sts = $('#sts').val();
    var n_es = $('#estimasi').val();
    var n_iden2 = $('#ididentitas').attr("tidakvalid");
    var n_nm2 = $('#nmanggota').attr("tidakvalid");
    var n_tglsuk2 = $('#tglmasuk').attr("tidakvalid");
    var n_tglhir2 = $('#tgllahir').attr("tidakvalid");
    var n_mat2 = $('#almt').attr("tidakvalid");
    var n_tlp2 = $('#tlp').attr("tidakvalid");
    var n_jbt2 = $('#jbt').attr("tidakvalid");
    var n_sts2 = $('#sts').attr("tidakvalid");
    var n_es2 = $('#estimasi').attr("tidakvalid");
    
    if(n_iden=="" || n_nm=="" || n_tglsuk=="" || n_tglhir=="" || n_mat=="" || n_tlp=="" || n_jbt=="" || n_sts=="" || n_es==""
       || n_iden2=="yes" || n_nm2=="yes" || n_tglsuk2=="yes" || n_tglhir2=="yes" || n_mat2=="yes" || n_tlp2=="yes" || n_jbt2=="yes" || n_sts2=="yes" || n_es2=="yes")
    {
        e.preventDefault();
        alert("inputan masih belum valid");
    }    
});

$('#anggota').autocomplete("http://localhost/kopsyah/c_pinjaman/auto_id_anggota",{
        width:350
});

$('#bk_simpanan').dataTable({ 
                                "sPaginationType":"full_numbers"
                            });

});


