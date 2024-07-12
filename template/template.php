<?php

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet" />
    <!--=============== Bootstrap 5.2 ===============-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!--=============== BoxIcons ===============-->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <!--=============== Google Fonts ===============-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <!--=============== Datatables ===============-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon-16x16.png">
    <link rel="manifest" href="../images/site.webmanifest">
    <title>SURAT TAWARAN PENGAJIAN DIPLOMA VOKASIONAL MALAYSIA KOLEJ VOKASIONAL KUALA SELANGOR <?php echo $info['full_name']; ?></title>
</head>
<style>
    #kvks {
        width: 160px;
    }

    /* p {
        font-size: 14px;
    } */

    /* tr , td{
        font-size:0.83rem;
    }  */
</style>

<body style="font-family: 'Arial', sans-serif;">
    <!-- letterhead -->
    <div class="container">
        <table cellpadding="3" class="table">
            <tr>
                <td style="width: 20%;">
                    <img src="<?php echo __DIR__ . '/../images/logoKPM.png'; ?>" alt="JataNegara" style="width:100%;object-fit: cover" id="jataKPM">
                </td>
                <td style="width: 61%;">
                    <p>
                        <b style="font-size:17px;">KOLEJ VOKASIONAL KUALA SELANGOR</b><br>
                    <p>45600 BESTARI JAYA,</p>
                    <p>SELANGOR DARUL EHSAN</p>
                    </p>
                </td>
                <td style="width: 35%;">
                    <img src="<?php echo __DIR__ . '/../images/KVKS.png'; ?>" alt="LogoKVKS" id="kvks">
                    <p style="font-size:10px; font-weight:bold;">
                        Tel : +60332718370 &nbsp;&nbsp;&nbsp; Faks : +60332718371<br>
                        Portal : kvkualaselangor.moe.edu.my<br>
                        Email : BHA3001@moe.edu.my<br>

                    </p>
                </td>
            </tr>
        </table>
        <hr>

        <p style="margin-left:480px; font-size:14px;">Ruj. Kami : KVKS.700-2/1/4( )</p>
                            <?php
                        setlocale(LC_TIME, 'ms_MY');
                    ?>
        <p style="margin-left:480px; margin-top:-10px; font-size:14px;">Tarikh : <?php echo strftime("%e %B %Y", strtotime($format['date_issued'])); ?></p>

        <table style="font-size:14px;">
            <tr>
                <td>NAMA PELAJAR</td>
                <td>:</td>
                <td><b><?php echo $info['full_name']; ?></b></td>
            </tr>
            <tr>
                <td>NO KAD PENGENALAN</td>
                <td>:</td>
                <td><b><?php echo $info['nokp']; ?></b></td>
            </tr>
        </table>

        <p style="font-size:14px;">Tuan,</p>

        <h4 style="text-align:justify;font-size:0.95rem">TAWARAN KEMASUKAN KE PROGRAM DIPLOMA VOKASIONAL MALAYSIA SESI 2023/2024</h4>

        <p style="font-size:14px;">Sukacita dimaklumkan bahawa anda telah ditawarkan mengikuti program berikut :</p>

        <table style="font-size:14px;" class="table" cellpadding="3">
            <tr>
                <td><b>NAMA INSTITUSI</b></td>
                <td>:</td>
                <td><b>Kolej Vokasional Kuala Selangor</b></td>
            </tr>
            <tr>
                <td><b>ALAMAT</b></td>
                <td>:</td>
                <td>
                    <b>Kolej Vokasional Kuala Selangor</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><b>45600 Bestari Jaya<br>Selangor Darul Ehsan</b></td>
            </tr>
            <tr>
                <td><b>PROGRAM</b></td>
                <td>:</td>
                <td><b><?php echo $programme['programme_name']; ?></b></td>
            </tr>

            <?php
            if ($info['residence'] == "KOLEJ KEDIAMAN") {   ?>

                <tr>
                    <td><b>TEMPOH PENGAJIAN</b></td>
                    <td>:</td>
                    <td><b><?php echo $programme['period']; ?></b></td>
                </tr>
                <tr>
                    <td><b>TARIKH LAPOR DIRI</b></td>
                    <td>:</td>
                    <?php
                        setlocale(LC_TIME, 'ms_MY');
                    ?>
                    <td><b><?php echo strftime("%e %B %Y", strtotime($format['reportD_asrama'])); ?></b></td>
                </tr>
                <tr>
                    <td><b>TEMPAT LAPOR DIRI</b></td>
                    <td>:</td>
                    <td><b><?php echo $format['reportP_asrama'] ?></b></td>
                </tr>
                <tr>
                    <td><b>MASA</b></td>
                    <td>:</td>
                    <td><b>
                    <?php 
                        $masa_asrama = date('H.i', strtotime($format['reportT_asrama']));
                        echo date('h.i', strtotime($format['reportT_asrama']));
                        
                        if ($masa_asrama >= 0 && $masa_asrama < 12) {
                            echo " pagi";
                        } elseif ($masa_asrama >= 12 && $masa_asrama < 18) {
                            echo " petang";
                        } else {
                            echo " malam";
                        }
                    ?>
                    - 
                    <?php 
                        $masa_asrama = date('H.i', strtotime($format['reportT2_asrama']));
                        echo date('h.i', strtotime($format['reportT2_asrama']));
                        
                        if ($masa_asrama >= 0 && $masa_asrama < 12) {
                            echo " pagi";
                        } elseif ($masa_asrama >= 12 && $masa_asrama < 18) {
                            echo " petang";
                        } else {
                            echo " malam";
                        }
                    ?></b></td>
                </tr>
                <tr>
                    <td><b>PENGINAPAN</b></td>
                    <td>:</td>
                    <td><b>Asrama</b></td>
                </tr>
            <?php } else { ?>

                <tr>
                    <td><b>TEMPOH PENGAJIAN</b></td>
                    <td>:</td>
                    <td><b><?php echo $programme['period']; ?></b></td>
                </tr>
                <tr>
                    <td><b>TARIKH LAPOR DIRI</b></td>
                    <td>:</td>
                    <?php
                        setlocale(LC_TIME, 'ms_MY');
                    ?>
                    <td><b><?php echo strftime("%e %B %Y", strtotime($format['reportD_outsider'])); ?></b></td>
                </tr>
                <tr>
                    <td><b>TEMPAT LAPOR DIRI</b></td>
                    <td>:</td>
                    <td><b><?php echo $format['reportP_outsider'] ?></b></td>
                </tr>
                <tr>
                    <td><b>MASA</b></td>
                    <td>:</td>
                    <td><b>
                    <?php 
                        $masa_asrama = date('H.i', strtotime($format['reportT_outsider']));
                        echo date('h.i', strtotime($format['reportT_outsider']));
                        
                        if ($masa_asrama >= 0 && $masa_asrama < 12) {
                            echo " pagi";
                        } elseif ($masa_asrama >= 12 && $masa_asrama < 18) {
                            echo " petang";
                        } else {
                            echo " malam";
                        }
                    ?>
                    </b></td>
                </tr>
                <tr>
                    <td><b>PENGINAPAN</b></td>
                    <td>:</td>
                    <td><b>Tiada Asrama</b></td>
                </tr>

            <?php }; ?>


        </table>
        <p style="font-size:14px;text-align:justify;">2. &nbsp; &nbsp; &nbsp; Sekiranya saudara/i didapati memberi maklumat salah/tidak benar/memanipulasi maklumat dan tidak memenuhi syarat kemasukan, pihak kolej berhak menarik balik tawaran kemasukan saudara/i dengan serta merta walaupun setelah ditawarkan tempat.</p>
        <p style="font-size:14px;text-align:justify;">3. &nbsp; &nbsp; &nbsp; Tawaran ini adalah muktamad dan saudara/i tidak dibenarkan menukar program pengajian atau menangguh kemasukan. Menangguh kemasukan dianggap menolak tawaran.</p>
        <p style="font-size:14px;"></p>
        <p style="font-size:14px;">Sekian dimaklumkan, terima kasih.</p>
        <p style="font-size:14px;"><b>"MALAYSIA MADANI"</b></p>
        <p style="font-size:14px;"><b>"BERKHIDMAT UNTUK NEGARA"</b></p>
        <p style="font-size:14px;">Saya yang menjalankan amanah,</p>
        <img src="<?php echo __DIR__ . '/../images/sign_en_daud.png'; ?>" alt="sign en daud" style="width:110px;object-fit: cover" id="sign">
        <div style="margin-top:-20px;font-size:14px;">
            <p>(<b>MOHD DAUD BIN ISMAIL</b>)<br>
                Pengarah<br>
                Kolej Vokasional Kuala Selangor<br>
                45600 Bestari Jaya<br>
                Selangor Darul Ehsan</p>
        </div>

    </div>
    <!--=============== Bootstrap 5.2 ===============-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!--=============== jQuery ===============-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!--=============== Datatables ===============-->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <!--=============== SweetAlert2 ===============-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.js"></script>
</body>

</html>