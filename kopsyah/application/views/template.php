<html>
    <head>
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url()."css/css_config.css";?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url()."css/ui-lightness/jquery-ui-1.8.21.custom.css"?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.dataTables.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.autocomplete.css" />
        <script type="text/javascript" src="<?php echo base_url()."js/jquery-1.8.2.js";?>"></script>
        <script type="text/javascript" src="<?php echo base_url()."js/jquery-ui.js"?>"></script>
        <script type="text/javascript" src="<?php echo base_url()."js/datepicker-indo.js"?>"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/jquery.dataTables.columnFilter.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/jquery.autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/format_uang.js"></script>
        <script type="text/javascript" src="<?php echo base_url()."js/kokie.js";?>"></script>
        <script type="text/javascript" src="<?php echo base_url()."js/js_config.js"?>"></script>
        <script type="text/javascript" src="<?php echo base_url()."js/".$js.".js"?>"></script> 
    </head>   
    <body>  
      <?php 
        if(isset($_SESSION['anggota_id'])){
            $this->load->view("bagian_page/menu_page");
            $this->load->view($isi);
        }elseif(isset($_SESSION['user']) || isset($_SESSION['bagian_umum'])){    
      ?>    
            <?php $this->load->view("bagian_page/menu_page"); ?>
      <div id="outer">  
            <?php $this->load->view("bagian_page/navigasi");?>
        <div id="isi">
            <?php $this->load->view($isi); ?>
            <div class="clear"></div>
        </div>
         
        <div class="clear"></div>
     </div>
     <?php }else{$this->load->view($isi);} ?>
    </body>
</html>