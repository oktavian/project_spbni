$(document).ready(function(){
//daftar tagih    
  var tabelku =  $('#filter_daftr_tagih').dataTable({
        "sPaginationType": "full_numbers",
        "fnDrawCallback":function(){
            $('.update_status_lunas').click(function(e){    
                e.preventDefault();
                var id_daftar = $(this).attr("idstatus");
                var sts_daftar = $(this).attr("statustagih");
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
     
            })
        },
        "aoColumns":[
            null,
            null,
            null,
            null,
            null,
            null,
            {"bSortable": false},
            {"bSortable": false}
        ]
    });
    tabelku.columnFilter({
        aoColumns:[
            null,
            null,
            null,
            null,
            null,
            {type:"select", value:["simpanan wajib","simpanan mudharabah"]},
            null,
            null
        ]
    });
//pelunasan tagihan simpanan
$('#filter_lunas_simpan').dataTable({
    "sPaginationType" : "full_numbers",
    "fnDrawCallback":function(){
        $('.ganti_status').click(function(){
            var idsimp = $(this).attr("idsimpanan");
            $.ajax({
                type:"POST",
                url:"http://localhost/kopsyah/c_simpanan/update_status_lunas",
                data:"idklik="+idsimp,
                success:function(data){
                    if(data=="lunas"){
                        location.reload();
                    }
                }
            });
        });
    },
    "aoColumns":[
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        {"bSortable": false},
        {"bSortable": false}
    ]
}).columnFilter({
    aoColumns:[
        null,
        null,
        null,
        null,
        null,
        null,
        {type:"select",value:["simpanan wajib","simpanan mudharabah"]},
        null,
        null
    ]
});

//tagihan sebelumnya
$('#filter_tagih_sebelumnya').dataTable({
    "sPaginationType":"full_numbers",
    "fnDrawCallback":function(){
        $('.campurkan').click(function(){
            createCookie("dftr1",'simpanan',1);
            var sebelumnya = $(this).attr("idsimpan");
            $.ajax({
                type:"POST",
                url:"http://localhost/kopsyah/c_simpanan/include_daftar_tagih",
                data:"idubah="+sebelumnya,
                success:function(data){
                    if(data=="masuk"){
                        location.reload();
                    }
                }
            });
        });
    },
    "aoColumns":[
        null,
        null,
        null,
        null,
        null,
        null,
        {"bSortable": false},
        {"bSortable": false}
    ]
}).columnFilter({
    aoColumns:[
        null,
        null,
        null,
        null,
        null,
        {type:"select",value:["simpanan wajib","simpanan mudharabah"]},
        null,
        null
    ]
});

//tabel transaksi
$('#filter_tbl_transaksi').dataTable({
    "sPaginationType":"full_numbers",
    "fnDrawCallback":function(){
        $('.koreksi_transaksi').click(function(){
            var idkor = $(this).attr("idkoreksi");
            $.ajax({
                type:"POST",
                url:"http://localhost/kopsyah/c_simpanan/koreksi_tbl_transaksi",
                data:"id="+idkor,
                success:function(data){
                    if(data=="salah"){
                        location.reload();
                    }else{alert("salah");}
                }
            });
        });
    }, 
    "aoColumns":[
        null,
        null,
        null, 
        null,
        null,
        null,
        {"bSortable": false}
    ]
}).columnFilter({
    aoColumns:[
        null,
        null,
        null,
        null,
        null,
        {type:"select",value:["simpanan wajib","simpanan mudharabah"]},
        null,
        null
    ]
});
    
    //tombol tombol
    if(readCookie("dftr1")=="simpanan"){
        $('#box_dftr_simpan').show();
    }
    
    $('#buat_dftr_simpan').click(function(){
        $('#box_buat_simpan').toggle();
    });
    
    $('#dftr_simpan').click(function(){
        if($('#box_dftr_simpan').is(":visible")){
            $('#box_dftr_simpan').hide();
            eraseCookie("dftr1");
        }else{
           $('#box_dftr_simpan').show(); 
        }
        
    });
    
    $('#tombol_transaksi').click(function(){
        $('#box_transaksi_simpan').toggle();
        //$('#fmdftrtagih').hide();
        
    });
 
//1. filter pembuatan daftar tagih simpana 
    $('#idformdftr').submit(function(e){
        var tgldaftar = $('#buat_daftar').val();
        if(tgldaftar==""){
            e.preventDefault();
            alert("inputan tidak boleh kosong");
        }else{
             $.ajax({
                type:"POST",
                url:"http://localhost/kopsyah/c_simpanan/cek_tgl_daftar_simpanan",
                data:"tgl="+tgldaftar,
                success:function(data){
                    if(data.length > 0){
                        alert(data);
                    }else{
                        $("#idformdftr").unbind('submit');
                        $("#idformdftr").submit();
                    }
                }
            });
        e.preventDefault();
       }
    }); 
    
//2. filter transaksi simpanan
    $('#filter_transaksi_simpan').submit(function(e){
        var tgltrans = $('#id_trans').val();
        if(tgltrans==""){
            e.preventDefault();
            alert("inputan tidak boleh kosong");
        }else{
            $.ajax({
                type:"POST",
                url:"http://localhost/kopsyah/c_simpanan/transaksi_filter_ajax",
                data:"tgl="+tgltrans,
                    success:function(data){
                    if(data.length>0){
                        alert(data);
                    }else{
                        $("#filter_transaksi_simpan").unbind('submit');
                        $("#filter_transaksi_simpan").submit();
                    }  
                } 
            });
            e.preventDefault();
        }
    });
  
    
    

});