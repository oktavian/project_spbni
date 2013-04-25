<html>
    <head>
        <title>LIHAT PRINT</title>
        <style type="text/css">
            table.t{
                border-collapse: collapse;
                width: 95%;
                background: white;
            }
            
            table tr.total{
                font : bold 16px solid black;
                height: 10%;
            }
            
            table.t tr td{
                border: 1px solid black;
                padding: 4px;
            }
            
            table.i{
                width: 100%;
                border-collapse: collapse;
            }
            
            table.i tr td{
                border: none;
            }
            

            caption{
                margin-bottom: 10px;
            }
            
            div{
                font: bold 16px gadget, sans-serif;
                text-align: right;
                padding-top: 10px;
                padding-right: 250px;
            }
        </style>
    </head>
    <body background="<?php echo base_url(); ?>css/images/bg-body.jpg">
        <table border="1" class="t">
            <caption>
                DAFTAR TAGIH SIMPANAN
                <p align="right">Tanggal : <?php echo DATE("d / m / Y"); ?></p>
            </caption>
            <tr>
                <th width=5%">NO.</th>
                <th width="10%">ID<br>ANGGOTA</th>
                <th width="20%">NAMA ANGGOTA</th>
                <th width="10%">STATUS<br>PEGAWAI</th>
                <th width="30%">
                    <table width="100%">
                        <tr>
                            <th colspan="2">JENIS SIMPANAN</th>
                        </tr>
                        <tr>
                            <td width="50%" align="center">WAJIB</td>
                            <td align="center">MDH</td>
                        </tr>
                    </table>
                </th>
                <th width="15%">TOTAL</th>
                <th width="5%">CEK</th>
            </tr>
<?php 
$no=1;
foreach ($hasil->result() as $data) { ?>            
            <tr>
                <td align="center"><?php echo $no++."."; ?></td>
                <td align="center"><?php echo $data->id_anggota; ?></td>
                <td><?php echo $data->nama_anggota; ?></td>
                <td align="center"><?php echo $data->status_pegawai; ?></td>
                <td>
                    <table class="i">
                        <tr>
                            <td>
                                <?php 
                                $wajib = $data->wajib; 
                                if($wajib!=0){
                                    $rupiah = number_format($wajib,"2",",",".");
                                    echo "Rp. ".$rupiah;
                                }else{
                                    echo "tidak ada tagihan";
                                }
                                ?>
                            </td>
                            <td width="50%">
                                <?php 
                                $mdh = $data->mdh;
                                if($mdh!=0){
                                    $rupiah = number_format($mdh,"2",",",".");
                                    echo "Rp. ".$rupiah;
                                }else{
                                    echo "tidak ada tagihan";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php if($wajib!=0){$cacah = $wajib/50000; echo "( ".$cacah."X tagih )"; } ?>
                            </td>
                            <td>
                                <?php if($mdh!=0){$cacah = $mdh/25000; echo "( ".$cacah."X tagih )";} ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <?php 
                    $total = $data->total; 
                    if($total!=0){
                        $rupiah = number_format($total, 2, ",", ".");
                        echo "Rp. ".$rupiah;
                    }else{
                        echo "tidak diketahui";
                    }
                    ?>
                </td>
                <td>&nbsp;</td>
            </tr>
<?php } ?> 
            <tr class="total">
                <td colspan="5" align="center">TOTAL SEMUA </td> 
                <td colspan="2"><?php echo $totalnya->total_all; ?></td>
            </tr>
    </table>
    </body>
</html>