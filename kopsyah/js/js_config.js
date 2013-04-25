$(document).ready(function(){
     $('.tabel_selingan1 tr:odd').css("background","rgb(211, 214, 255)");
     $('.tabel_selingan2 tr:odd').css("background","wheat");
     $('.tabel_selingan1 tr th').css("background","orange");
     
     $('.tabel_selingan1 tr').mouseenter(function(){
         $(this).css("background","activeborder");
     }).mouseout(function(){
         $('.tabel_selingan1 tr:odd').css("background","rgb(211, 214, 255)");
         $('.tabel_selingan1 tr:even').css("background","white");
     });
     
     $('.tabel_selingan2 tr').mouseenter(function(){
         $(this).css("background","activeborder");
     }).mouseout(function(){
         $('.tabel_selingan2 tr:odd').css("background","wheat");
         $('.tabel_selingan2 tr:even').css("background","white");
     });
     

    $('#pencet').click(function(){ 
        $('#menu_utama').slideToggle("slow");
    });
    
    
    /* konfigurasi menu navigasi */
    //untuk anggota
    if(readCookie("cooknav")=="anggota"){
        $('ul.navanggota').show();       
    }else if(readCookie("cooknav")=="simpanan"){
        $('ul.navsimpanan').show();
    }else if(readCookie("cooknav")=="pinjaman"){
        $('ul.navpinjaman').show();
    }else if(readCookie("cooknav")=="atk"){
        $('ul.navatk').show();
    }else if(readCookie("cooknav")=="laporan"){
        $('ul.navlaporan').show();
    }
    
    
    
    
    $('#menu_navigasi > h2.tutup').click(function(){
        var judulnav = $(this).text();
        //alert(judulnav);
        
        
          if($(this).next().is(':visible')==false){  //didepannya harus ul bukan h2.tutup
           $('#menu_navigasi ul').slideUp(300);
            
           }
           $(this).next().slideToggle(300);  
           
        //anggota   
           if(judulnav=="ANGGOTA" && $('ul.navanggota').is(':visible')){
               createCookie("cooknav",'anggota',1);   
           }else if(judulnav=="SIMPANAN" && $('ul.navsimpanan').is(':visible')){
               createCookie("cooknav",'simpanan',1);
           }else if(judulnav=="PINJAMAN" && $('ul.navpinjaman').is(':visible')){
               createCookie("cooknav",'pinjaman',1);
           }else if(judulnav=="ATK" && $('ul.navatk').is(':visible')){
               createCookie("cooknav",'atk',1);
           }else if(judulnav=="LAPORAN" && $('ul.navlaporan').is(':visible')){
               createCookie("cooknav",'laporan',1);
           }          
           //createCookie("cooknav");
    });
    
    $('#menu_navigasi > h2.tetap').click(function(){
        eraseCookie("cooknav");
    });

    $('.tgl').datepicker({
        dateFormat:'yy-mm-dd',
        changeMonth:true,
        changeYear:true,
        showOn:"button",
        buttonImage:"http://localhost/kopsyah/css/ui-lightness/images/calendar.gif",
        buttonImageOnly:true
    });

    

});