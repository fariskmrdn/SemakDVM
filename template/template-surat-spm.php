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
                        <b style="font-size:17px;">KOLEJ VOKASIONAL KUALA SELANGOR</b><br>45600 BESTARI JAYA,<br>SELANGOR DARUL EHSAN
                    </p>
                </td>
                <td style="width: 35%;">
                    <img src="<?php echo __DIR__ . '/../images/KVKS.png'; ?>" alt="LogoKVKS" id="kvks">
                    <p style="font-size:10px; font-weight:bold;">
                        Tel: 03-32718370 &nbsp;&nbsp;&nbsp; Faks: 03-32718371<br>
                        Portal : kvkualaselangor.moe.edu.my<br>
                        Email : BHA3001@moe.edu.my<br>

                    </p>
                </td>
            </tr>
        </table>
        <hr>

        <p style="margin-left:350px; padding-top:10px; font-size:14px;">Rujukan Kami : KPM.800-1/1/12 ( <?php echo $info['nokp']?> )</p>
        <?php
            /**
             * Function to format a date string into Malay (e.g., "29 Oktober 2025")
             * This method is reliable as it uses PHP's Intl extension, not server-dependent locales.
             */
            function formatMalayDate($dateString) {
                date_default_timezone_set('Asia/Kuala_Lumpur');

                // 1. Format the date with day of the week: "12 May 2026 (Tuesday)"
                // 'j F Y (l)' outputs: 12 May 2026 (Tuesday)
                $english_date = date("j F Y (l)", strtotime($dateString));

                // 2. Define English to Malay mapping for Months
                $english_months = array(
                    'January', 'February', 'March', 'April', 'May', 'June', 
                    'July', 'August', 'September', 'October', 'November', 'December'
                );
                $malay_months = array(
                    'Januari', 'Februari', 'Mac', 'April', 'Mei', 'Jun', 
                    'Julai', 'Ogos', 'September', 'Oktober', 'November', 'Disember'
                );

                // 3. Define English to Malay mapping for Days
                $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                $malay_days = array('Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat', 'Sabtu', 'Ahad');

                // 4. Replace Months first
                $malay_date = str_replace($english_months, $malay_months, $english_date);
                
                // 5. Replace Days
                $malay_date = str_replace($english_days, $malay_days, $malay_date);
                
                return $malay_date;
            }
        ?>

        <table style="font-size:14px;">
            <tr>
                <td><b><?php echo $info['full_name']; ?></b></td>
            </tr>
            <tr>
                <td><b><?php echo $info['nokp']; ?></b></td>
            </tr>
        </table>

        <p style="font-size:14px;">Tuan,</p>

        <h4 style="text-align:justify;font-size:0.95rem">TAWARAN KEMASUKAN KE PROGRAM DIPLOMA VOKASIONAL MALAYSIA SESI <?php echo $format['title'] ?></h4>

        <p style="font-size:14px;">Dimaklumkan bahawa permohonan anda telah berjaya dan maklumat penempatan anda adalah seperti berikut:  :</p>

        <table style="font-size:14px;" class="table" cellpadding="3">
            <tr>
                <td>NAMA INSTITUSI</td>
                <td>:</td>
                <td><b>KOLEJ VOKASIONAL KUALA SELANGOR</b></td>
            </tr>
            <tr>
                <td>ALAMAT</td>
                <td>:</td>
                <td><b>KOLEJ VOKASIONAL KUALA SELANGOR, 45600 BESTARI JAYA, <br>SELANGOR</b></td>
            </tr>
            <tr>
                <td>PROGRAM</td>
                <td>:</td>
                <td><b><?php echo strtoupper($programme['programme_name']); ?></b></td>
            </tr>

            <?php
            if ($info['residence'] == "KOLEJ KEDIAMAN") {   ?>

                <tr>
                    <td>TEMPOH PENGAJIAN</td>
                    <td>:</td>
                    <td><b><?php echo strtoupper($programme['period']); ?></b></td>
                </tr>
                <tr>
                    <td>TARIKH MELAPOR DIRI</td>
                    <td>:</td>
                    <?php
                        setlocale(LC_TIME, 'ms_MY');
                    ?>
                    <td><b><?php echo strtoupper(formatMalayDate($format['reportD_asrama'])); ?></b></td>
                </tr>
                <tr>
                    <td>MASA</td>
                    <td>:</td>
                    <td><b>
                    <?php 
                        $time_formatted = date('h.i', strtotime($format['reportT_asrama']));
                        $hour_check = date('H', strtotime($format['reportT_asrama']));
                        
                        if ($hour_check >= 0 && $hour_check < 12) {
                            $period = " pagi";
                        } elseif ($hour_check >= 12 && $hour_check < 18) {
                            $period = " petang";
                        } else {
                            $period = " malam";
                        }
                        echo strtoupper($time_formatted . $period);
                    ?>
                </tr>
                <tr>
                    <td>ASRAMA</td>
                    <td>:</td>
                    <td><b>DENGAN ASRAMA</b></td>
                </tr>
            <?php } else { ?>

                <tr>
                    <td>TEMPOH PENGAJIAN</td>
                    <td>:</td>
                    <td><b><?php echo strtoupper($programme['period']); ?></b></td>
                </tr>
                <tr>
                    <td>TARIKH MELAPOR DIRI</td>
                    <td>:</td>
                    <?php
                        setlocale(LC_TIME, 'ms_MY');
                    ?>
                    <td><b><?php echo strtoupper(formatMalayDate($format['reportD_asrama'])); ?></b></td>
                </tr>
                <tr>
                    <td>MASA</td>
                    <td>:</td>
                    <td><b>
                    <?php 
                        $time_formatted = date('h.i', strtotime($format['reportT_asrama']));
                        $hour_check = date('H', strtotime($format['reportT_asrama']));
                        
                        if ($hour_check >= 0 && $hour_check < 12) {
                            $period = " pagi";
                        } elseif ($hour_check >= 12 && $hour_check < 18) {
                            $period = " petang";
                        } else {
                            $period = " malam";
                        }
                        echo strtoupper($time_formatted . $period);
                    ?>
                </tr>
                <tr>
                    <td>ASRAMA</td>
                    <td>:</td>
                    <td><b>TANPA ASRAMA</b></td>
                </tr>

            <?php }; ?>


        </table>
        <p style="font-size:14px;text-align:justify;">2. &nbsp; &nbsp; &nbsp; 	Anda dikehendaki melapor diri di institusi berkenaan pada tarikh dan masa yang       ditetapkan. Semasa melapor diri, anda dikehendaki menyerahkan dokumen-dokumen berikut:. <br>

        <br>&nbsp; &nbsp; &nbsp; a) Salinan Kad Pengenalan
        <br>&nbsp; &nbsp; &nbsp; b) Salinan Keputusan Sijil Pelajaran Malaysia (SPM) Tahun 2025*
        <br>&nbsp; &nbsp; &nbsp; c) Buku Tawaran Kemasukan Pelajar ke Kolej Vokasional. <br>

        </p>

        <p style="font-size:10px;text-align:justify;"><i>*Salinan perlu disahkan dan sertakan <b>dokumen asal</b> semasa mendaftar. Dokumen asal akan dikembalikan selepas pendaftaran.</i></p>

        <p style="font-size:14px;text-align:justify;">3. &nbsp; &nbsp; &nbsp; 	Tawaran ini adalah <b>muktamad</b> dan berkuat kuasa pada <b>tarikh pendaftaran sahaja.</b> Calon yang didapati memberi maklumat salah / tidak benar / manipulasi maklumat semasa dan selepas memohon program ini akan diambil tindakan dengan penarikan balik tawaran. Maklumat calon akan disemak secara terperinci dari semasa ke semasa selama tempoh pengajian.</p>
        <p style="font-size:14px;">Sekian, terima kasih.</p>
        <p style="font-size:14px;"><b>"MALAYSIA MADANI"</b></p>
        <p style="font-size:14px;"><b>"BERKHIDMAT UNTUK NEGARA"</b></p>
        <p style="font-size:14px;">Saya yang menjalankan amanah,</p>
        <img src="<?php echo __DIR__ . '/../images/sign_en_daud.png'; ?>" alt="sign en daud" style="width:110px;object-fit: cover" id="sign">
        <div style="margin-top:-20px;font-size:14px;">
            <p>(<b>MOHD DAUD BIN ISMAIL</b>)<br>
                Pengarah<br>
                Kolej Vokasional Kuala Selangor<br>
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