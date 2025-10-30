<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Borang Setuju Terima Tawaran</title>
    <style>
        /* CSS for Dompdf is generally simpler and should be included inline or in a <style> block */
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            padding: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .title {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .ref-info {
            font-size: 10pt;
            text-align: right;
            margin-bottom: 20px;
        }
        .content-block {
            margin-bottom: 20px;
            line-height: 30px;
        }
        .field {
            display: inline-block;
            border-bottom: 1px solid #000;
            padding: 0 5px;
            min-width: 150px; /* Use min-width to ensure space for field */
            margin-bottom: -2px;
            text-align: center;
        }
        .option-box {
            display: inline-block;
            width: 15px;
            height: 15px;
            border: 1px solid #000;
            margin-right: 5px;
            vertical-align: middle;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 40px;
        }
        .signature-table td {
            width: 50%;
            padding-top: 20px;
            vertical-align: top;
        }
        .signature-line {
            border-bottom: 1px solid #000;
            height: 15px;
            margin-top: 40px;
            width: 80%;
        }
        .label {
            font-weight: bold;
            display: block;
            margin-top: 5px;
        }
        .border td{
            border:1px solid #000; 
            padding: 5px;
        }
        .info td:nth-child(2){
            border-bottom:1px dotted #000; 
        }

        .info td{
            padding: 5px;
            padding-top: 20px;
        }
    </style>
</head>
<body>

    <div class="ref-info">
        Lampiran 3 BKT-10/03<br>
        (Disi dalam 2 salinan)
    </div>

    <div class="header">
        <div class="title">
            BORANG SETUJU TERIMA TAWARAN KEMASUKAN<br>
            KE PROGRAM DIPLOMA VOKASIONAL MALAYSIA
        </div>
    </div>

    <br>
    <div class="content-block">
        <?php 
            if($offer['status_offer'] == 2){
                $statusOffer = "MENERIMA";
            }
            else{
                $statusOffer = "MENOLAK";
            }
        
        ?>
        Merujuk kepada surat tuan <span class="field">KVKS.700-2/1/4(<?php echo $info['id']?>)</span> mengenai perkara tersebut di atas, adalah dimaklumkan, saya
        <span class="field"><?php echo $info['full_name']; ?></span>,
        No. Kad Pengenalan: <span class="field"><?php echo $info['nokp']; ?></span>
        dengan ini bersetuju <b><?php echo $statusOffer?></b> di atas tarawan tersebut dan mematuhi syarat-syarat yang telah ditetapkan.
    </div>

    <table class="border" style="width: 100%; margin-top: 20px;border-collapse: collapse;">
        <tr>
            <td style="width: 30%;">Kolej:</td>
            <td style="border-bottom: 1px solid #000;">KOLEJ VOKASIONAL KUALA SELANGOR</td>
        </tr>
        <tr>
            <td>Program:</td>
            <td style="border-bottom: 1px solid #000;"><?php echo $programme['programme_name']; ?></td>
        </tr>
        <tr>
            <td>Tahun:</td>
            <td style="border-bottom: 1px solid #000;"><?php echo strftime("%Y", strtotime($format['date_issued'])); ?></td>
        </tr>
    </table>


    <br><br><br><br>
    <table class="info" style="width: 100%; margin-top: 20px;border-collapse: collapse;">
        <tr>
            <td style="width: 30%;">Tanda Tangan Pelajar:</td>
            <td style=""></td>
        </tr>
        <tr>
            <td>Nama Pelajar:</td>
            <td style=""><?php echo $info['full_name']; ?></td>
        </tr>
        <tr>
            <td>No Kad Pengenalan:</td>
            <td style=""><?php echo $info['nokp']; ?></td>
        </tr>

        <tr>
            <td>Disahkan Oleh:</td>
            <td style="border:none"></td>
            
        </tr>

        <tr>
            <td>Tanda Tangan Ibubapa / Penjaga:</td>
            <td style=""></td>
        </tr>

        <tr>
            <td>Nama Ibubapa / Penjaga:</td>
            <td style=""></td>
        </tr>

        <tr>
            <td>No. Kad Pengenalan:</td>
            <td style=""></td>
        </tr>
        <tr>
            <td>Tarikh</td>
            <td style=""></td>
        </tr>
    </table>

</body>
</html>