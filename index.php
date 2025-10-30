<?php

include 'database/config.php';
$message = "";

date_default_timezone_set("Asia/Kuala_Lumpur");
$openTime = date('Y-m-d H:i:s', strtotime('2023-07-14 08:00:00'));
$today = date('Y-m-d H:i:s');

// Function to get files based on student status
function getFilesForStudent($con, $studentStatus) {
    $files = [];
    
    // Determine which file types to show based on student status
    // type_file: 1=both, 2=menerima only, 3=menolak only
    if ($studentStatus == 2) { // Menerima
        $type_condition = "type_file IN (1,2)";
    } elseif ($studentStatus == 3) { // Menolak
        $type_condition = "type_file IN (1,3)";
    } else {
        $type_condition = "type_file = 1"; // Default to both if no status
    }
    
    $query = "SELECT * FROM file WHERE $type_condition ORDER BY created_date DESC";
    $result = mysqli_query($con, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        while ($file = mysqli_fetch_assoc($result)) {
            $files[] = $file;
        }
    }
    
    return $files;
}

// Function to display files in a formatted way
function displayFiles($files, $studentStatus) {
    if (empty($files)) {
        return "<div class='alert alert-info mt-3'>Tiada fail untuk dipaparkan.</div>";
    }
    
    $statusText = ($studentStatus == 2) ? "Menerima" : "Menolak";
    $html = "<div class='mt-3'>
                <div class='row justify-content-center'>";
    
    foreach ($files as $file) {
        $fileName = htmlspecialchars($file['file_name']);
        $filePath = $file['path_file'];
        $uploadDate = date('d/m/Y H:i', strtotime($file['created_date']));
        
        // Get file icon based on extension
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $icon = getFileIcon($fileExt);
        
        $html .= "
        <div class='col-md-6 col-lg-4 mb-3'>
            <center>
            <a href='$filePath' class='btn btn-info bg-opacity-50' download>
                $fileName
            </a>
            </center>
        </div>";
    }
    
    $html .= "</div></div>";
    return $html;
}

// Function to get appropriate icon for file type
function getFileIcon($fileExt) {
    switch ($fileExt) {
        case 'pdf':
            return 'bi bi-file-earmark-pdf';
        case 'doc':
        case 'docx':
            return 'bi bi-file-earmark-word';
        case 'xls':
        case 'xlsx':
            return 'bi bi-file-earmark-excel';
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
            return 'bi bi-file-earmark-image';
        case 'zip':
        case 'rar':
            return 'bi bi-file-earmark-zip';
        default:
            return 'bi bi-file-earmark';
    }
}

if ($today >= $today) {
    if(isset($_POST['ic'])){

        if (isset($_POST['check']) || isset($_POST['terima']) || isset($_POST['tolak'])) {
            $ic = mysqli_real_escape_string($con, $_POST['ic']);
            $check = "SELECT * FROM student WHERE nokp LIKE '%$ic%'";
            $run = mysqli_query($con, $check);
            if (mysqli_num_rows($run) > 0) {
                $row = mysqli_fetch_array($run);
    
                $sesi_utama = "SELECT * FROM document WHERE id = '1'";
                $sql = mysqli_query($con, $sesi_utama);
                $sesi = mysqli_fetch_array($sql);
    
                if($row['year_s'] != $sesi['title']){
                    $message = "
                <div class='container mt-2 text-bg-warning text-center p-3'>
                <strong>
                Harap Maaf! Sesi Anda Telah Tamat
                </strong>
                </div>";
                } else {

                    // Check if student has already responded to offer
                    $checkOffer = "SELECT * FROM offer WHERE id_student = '" . $row['nokp'] . "'";
                    $offerRun = mysqli_query($con, $checkOffer);
                    $hasResponded = mysqli_num_rows($offerRun) > 0;
                    $offerStatus = 0;
                    
                    if ($hasResponded) {
                        $offerRow = mysqli_fetch_array($offerRun);
                        $offerStatus = $offerRow['status_offer'];
                    }
    
                    // Handle accept/reject actions
                    if (isset($_POST['terima'])) {
                        if (!$hasResponded) {
                            $insertOffer = "INSERT INTO offer (id_offer, id_student, created_date, status_offer) VALUES (NULL, '" . $row['nokp'] . "', NOW(), 2)";
                            mysqli_query($con, $insertOffer);
                            $hasResponded = true;
                            $offerStatus = 2;
                            $_POST['ic'] = NULL;
                        }
                    } elseif (isset($_POST['tolak'])) {
                        if (!$hasResponded) {
                            $insertOffer = "INSERT INTO offer (id_student, created_date, status_offer) VALUES ('" . $row['nokp'] . "', NOW(), 3)";
                            mysqli_query($con, $insertOffer);
                            $hasResponded = true;
                            $offerStatus = 3;
                        }
                    }
    
                    $checkProgramme = "SELECT * FROM programme WHERE id_program = " . $row['programme'] . "";
                    $exec = mysqli_query($con, $checkProgramme);
                    $program = mysqli_fetch_array($exec);
    
                    // Get files based on student status
                    $studentFiles = [];
                    $filesDisplay = "";
                    if ($hasResponded) {
                        $studentFiles = getFilesForStudent($con, $offerStatus);
                        $filesDisplay = displayFiles($studentFiles, $offerStatus);
                    }
    
                    // Build the message based on offer status
                    $actionButtons = "";
                    $additionalDocuments = "style='display:none'";
                    
                    if (!$hasResponded) {
                        // Student hasn't responded - show accept/reject buttons with modals
                        $actionButtons = "
                        <tr style='background-color:'>
                            <td colspan='2'>
                                <center>
                                    <button type='button' class='btn btn-success mt-2' data-bs-toggle='modal' data-bs-target='#terimaModal'>Terima Tawaran</button>
                                    <button type='button' class='btn btn-danger mt-2' data-bs-toggle='modal' data-bs-target='#tolakModal'>Tolak Tawaran</button>
                                </center>
                            </td>
                        </tr>";
                    } elseif ($offerStatus == 2) {
                        // Student accepted - show additional documents
                        $additionalDocuments = "";
                        $actionButtons = "
                        <tr style='background-color:'>
                            <td colspan='2'>
                                <center>
                                    <div class='p-3 text-success'>
                                        <strong>Anda telah menerima tawaran ini.</strong>
                                    </div>
                                </center>
                                <center style='display:flex; flex-wrap: wrap; justify-content: center;'>
                                    <div class='p-1'>
                                        <a href='tawaran.php?nokp=" . $row['nokp'] . "' class='btn btn-info bg-opacity-50' target='_blank'>Buku Tawaran Kemasukan Pelajar
                                        </a>
                                    </div>

                                </center>
                                
                            </td>
                        </tr>";
                    } elseif ($offerStatus == 3) {
                        // Student rejected - only show surat tawaran
                        $actionButtons = "
                        <tr style='background-color:'>
                            <td colspan='2'>
                                <center>
                                    <div class='p-3 text-danger'>
                                        <strong>Anda telah menolak tawaran ini.</strong>
                                    </div>
                                </center>
                                <center>
                                    <div class='p-1'>
                                        <a href='tawaran.php?nokp=" . $row['nokp'] . "' class='btn btn-info bg-opacity-50' target='_blank'>Buku Tawaran Kemasukan Pelajar
                                        </a>
                                    </div>
                                </center>
                            </td>
                        </tr>";
                    }
    
                    $message = "
                    <div class='container mt-2 text-bg-success text-dark bg-opacity-50 p-3'>
                    <strong>
                    <p class='text-center'>Tahniah! Anda Layak Melanjutkan Pengajian Ke Diploma Vokasional Malaysia.</p>
                    </strong>
                    <table class='table table-striped bg-light'>
                        <tr>
                            <td>Nama Pelajar :</td>
                            <td>" . $row['full_name'] . "</td>
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
                            <td>" . $row['year_s'] . "</td>
                        </tr>
    
                        <tr style='background-color:white'>
                            <td colspan='2'>
                                <center>
                                    <div class='p-1'>
                                        <a href='surat.php?nokp=" . $row['nokp'] . "' class='btn btn-info bg-opacity-50' target='_blank'>Muat Turun Surat Tawaran</a>
                                    </div>
                                </center>
                            </td>
                        </tr>
    
                        " . $actionButtons . "
    
                        <tr style='background-color:white'" . $additionalDocuments . ">
                            <td colspan='2'>
                                " . $filesDisplay . "
                            </td>
                        </tr>
                    </table>
                    </div>
                    ";
                } 
            } else {
                $message = "
                <div class='container mt-2 text-bg-warning text-center p-3'>
                <strong>
                Harap Maaf! Anda Tidak Ditawarkan / Tidak Layak Melanjutkan Pengajian Ke Diploma Vokasional Malaysia
                </strong>
                </div>";
            }
        }
        else {
            $message = "
            <div class='container mt-2 text-bg-warning text-center p-3'>
            <strong>
            Harap Maaf! Anda Tidak Ditawarkan / Tidak Layak Melanjutkan Pengajian Ke Diploma Vokasional Malaysia
            </strong>
            </div>";
        }
    }
    else{
        // $message = "No Ic";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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
    
    .card {
        transition: transform 0.2s;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
            <center><input type="text" name="ic" class="form-control w-75 text-center" placeholder="Masukkan No. Kad Pengenalan" minlength="12" required value="<?php echo isset($_POST['ic']) ? $_POST['ic'] : ''; ?>"></center>
            <button name="check" type="submit" class="btn btn-success mt-2">Semak Status</button>
        </form>
    </div>

    <?= $message ?>

    <!-- Confirmation Modals -->
    <!-- Terima Tawaran Modal -->
    <div class="modal fade" id="terimaModal" tabindex="-1" aria-labelledby="terimaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="terimaModalLabel">Sahkan Penerimaan Tawaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Adakah anda pasti ingin menerima tawaran ini?</p>
                    <p class="text-success"><strong>Dengan menerima tawaran, anda akan diberikan akses kepada semua dokumen yang diperlukan.</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="ic" value="<?php echo isset($_POST['ic']) ? $_POST['ic'] : ''; ?>">
                        <button type="submit" name="terima" class="btn btn-success">Ya, Terima Tawaran</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tolak Tawaran Modal -->
    <div class="modal fade" id="tolakModal" tabindex="-1" aria-labelledby="tolakModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tolakModalLabel">Sahkan Penolakan Tawaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Adakah anda pasti ingin menolak tawaran ini?</p>
                    <p class="text-danger"><strong>Tindakan ini tidak boleh dipadam.</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="ic" value="<?php echo isset($_POST['ic']) ? $_POST['ic'] : ''; ?>">
                        <button type="submit" name="tolak" class="btn btn-danger">Ya, Tolak Tawaran</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
</html>