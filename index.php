<?php

include 'database/config.php';
$message = "";

date_default_timezone_set("Asia/Kuala_Lumpur");
$openTime = date('Y-m-d H:i:s', strtotime('2023-07-14 08:00:00'));
$today = date('Y-m-d H:i:s');
if ($today >= $openTime) {
    if (isset($_POST['check'])) {
        $ic = mysqli_real_escape_string($con, $_POST['ic']);
        $check = "SELECT * FROM student WHERE nokp LIKE '%$ic%'";
        $run = mysqli_query($con, $check);

        if (mysqli_num_rows($run) > 0) {
            $student = mysqli_fetch_array($run);

            $checkProgramme = "SELECT * FROM programme WHERE id_program = " . $student['programme'] . "";
            $exec = mysqli_query($con, $checkProgramme);
            $program = mysqli_fetch_array($exec);

            $message = "
            <div class='container mt-2 text-bg-success text-dark bg-opacity-50 p-3'>
            <strong>
            <p class='text-center'>Tahniah! Anda Layak Melanjutkan Pengajian Ke Diploma Vokasional Malaysia.</p>
            </strong>
            <table class='table table-striped bg-light'>
                <tr>
                    <td>Nama Pelajar :</td>
                    <td>" . $student['full_name'] . "</td>
                </tr>
                <tr>
                    <td>Program Ditawarkan :</td>
                    <td>" . $program['programme_name'] . "</td>
                </tr>
                <tr>
                    <td>Tempoh Pengajian :</td>
                    <td>" . $program['period'] . "</td>
                </tr>
                <tr>
                    <td>Sesi Pengajian :</td>
                    <td>" . $student['year_s'] . "</td>
                </tr>
    
                <tr style='background-color:white'>
                    <td colspan='2' >
                        <div class='download-button'>
                            <div class='p-1' >
                                <a href='surat.php?nokp=" . $student['nokp'] . "' class='btn btn-info bg-opacity-50'>Muat Turun Surat Tawaran</a>
                            </div>
                            <div class='p-1'>
                                <a href='./documents/LAMPIRAN 1 SENARAI SEMAK.docx' class='btn btn-info bg-opacity-50' download>Senarai Semak Pendaftaran Pelajar Baharu
                                </a>
                            </div>
                            <div class='p-1'>
                                <a href='./documents/LAMPIRAN 3 BORANG SETUJU TERIMA TAWARAN.pdf' class='btn btn-info bg-opacity-50' download>Borang Penerimaan Tawaran Kemasukan
                                </a>
                            </div>
                            <div class='p-1'>
                                <a href='./documents/LAMPIRAN 2 PEMERIKSAAN KESIHATAN.docx' class='btn btn-info bg-opacity-50' download>Borang Pemeriksaan Kesihatan</a>
                            </div>
                        </div>
                    </td>
                </tr>
    
    
            </table>
            </div>
            ";
        } else {
            $message = "
            <div class='container mt-2 text-bg-warning text-center p-3'>
            <strong>
            Harap Maaf! Anda Tidak Ditawarkan / Tidak Layak Melanjutkan Pengajian Ke Diploma Vokasional Malaysia
            </strong>
            </div>";
        }
    }
} else {
    require_once 'maintenance.html';
    exit();
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Semak Kelayakan Untuk Melanjutkan Pengajian Ke Diploma Vokasional Malaysia, Kolej Vokasional Kuala Selangor, Bahagian Pendidikan dan Latihan Teknikal Vokasional, Kementerian Pendidikan Malaysia">
    <meta name="keywords" content="DVM,SemakDVM,KVKS,KV,Diploma Vokasional,Shine With Skills">
    <meta name="author" content="Kolej Vokasional Kuala Selangor">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    <link rel="manifest" href="images/site.webmanifest">
    <title>SemakDVM - Kolej Vokasional Kuala Selangor</title>
</head>

<style>
    body {
        display: flex;
        min-height: 100vh;
        flex-direction: column;
    }

    footer {
        margin-top: auto;
    }

    @media only screen and (min-width: 600px) {
        .download-button {
            display: flex;
            justify-content: center;
        }

    }
</style>

<body>
    <div class="container text-center mt-3 bg-light">
        <img src="images/kpmkvks.png" class="w-75">
        <h3 class="h3 p-3">SemakDVM - Sistem Semakan Kelayakan Pengajian Ke Diploma Vokasional Malaysia</h3>

    </div>

    <div class="container text-center mt-3 text-bg-primary p-3">
        <form method="post">
            <p class="h6">Masukkan No. Kad Pengenalan tanpa (-)</p>
            <center><input type="text" name="ic" class="form-control w-75 text-center" placeholder="Masukkan No. Kad Pengenalan" minlength="12" required></center>
            <button name="check" type="submit" class="btn btn-success mt-2">Semak Status</button>
        </form>
    </div>


    <?= $message ?>


    <footer class="bg-dark text-white">
        <div class="container py-3">
            <div class="row">
                <div class="col-md-6">
                    <h5>SemakDVM - Sistem Semakan Kelayakan DVM</h5>
                    <p>
                        Unit Teknologi Maklumat dengan kerjasama Jabatan Teknologi Maklumat<br>Kolej Vokasional Kuala Selangor
                    </p>
                </div>
                <div class="col-md-6">
                    <h5>Pautan Lain</h5>
                    <ul class="list-unstyled ">
                        <li><a style="text-decoration:none; color:white;" href="https://spksys.kvkualaselangor.com">Sistem Pendaftaran Kursus (SPKSys)</a></li>
                        <li><a style="text-decoration:none; color:white;" href="https://kvkualaselangor.edu.moe.my">Portal Rasmi Kolej Vokasional Kuala Selangor</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="bg-secondary text-center py-2">
            <p>Hak Cipta &copy <?php echo date("Y"); ?> <br>Kolej Vokasional Kuala Selangor</p>
        </div>
    </footer>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>

</html>