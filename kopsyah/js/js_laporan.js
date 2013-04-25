$(document).ready(function(){    
    $('#anggota').autocomplete("http://localhost/kopsyah/c_pinjaman/auto_id_anggota",{
        width:350
    });
    
    $('#idpinjam').autocomplete("http://localhost/kopsyah/c_laporan/auto_id_pinjam",{
        width:200
    });
    
    $('.ket_basil tr').find('td:eq(2)').css("font","bold 16px gadget,sans-serif");
    
    $('.submit').click(function(e){
        var ag = $('#anggota').val();
        var awal = $('#tgl_awal').val();
        var ahkir = $('#tgl_ahkir').val();
        
        if((ag=="" && awal=="" && ahkir=="") || (ag=="" && ahkir=="" && awal!="") || (ahkir!="" && awal!="" && ag=="") 
            || (ag!="" && ahkir=="" && awal=="")){
            e.preventDefault();
            alert("inputkan dulu yang benar!");
        }
    });
    
    $('#tombol_basil').click(function(){
        $.ajax({
            type:"POST",
            url:"http://localhost/kopsyah/c_laporan/bagihasilkan",
            data:"i=1",
            success:function(data){
                if(data="sudah dibagi"){
                    alert("BAGI HASIL SUDAH DIHITUNG");
                }
            }
        });
    });
    

    

    
    
});