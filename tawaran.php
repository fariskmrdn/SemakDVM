<?php
setlocale(LC_TIME, 'ms_MY.utf8');
strftime('%B', time());
require 'vendor/autoload.php';

include 'database/config.php';
if (isset($_REQUEST['nokp'])) {

    $id = mysqli_real_escape_string($con, $_REQUEST['nokp']);

    $retrieveData = "SELECT * FROM student WHERE nokp = ?";
    $stmt = mysqli_prepare($con, $retrieveData);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $info = mysqli_fetch_array($result);

    $retrieveOffer = "SELECT * FROM offer WHERE id_student = '$id'";

    $execRetreiveOffer = mysqli_query($con, $retrieveOffer);
    
    // Check if offer exists, but don't redirect if it doesn't
    if (mysqli_num_rows($execRetreiveOffer) > 0) {
        $offer = mysqli_fetch_array($execRetreiveOffer);
    } else {
        $offer = null; // or handle as needed
        header("Location: ./");
    }


    $getProgramme = mysqli_query($con, "SELECT * FROM programme WHERE id_program = ".$info['programme']."");
    $programme = mysqli_fetch_array($getProgramme);

    $documentFormat = mysqli_query($con, "SELECT * FROM document WHERE id = '1'");
    $format = mysqli_fetch_array($documentFormat);
}


// Include the Dompdf namespace
use Dompdf\Dompdf;

ob_start();
$dompdf = new Dompdf([
    "chroot" => __DIR__,
]);

// html template
require("template/template-tawaran.php");


$dompdf->loadHtml(ob_get_clean());

// Customization on pdf
$dompdf->setPaper('A4', 'portrait');
$font = 'template/ArialTh.ttf';
$dompdf->getOptions()->setFontDir('template/ArialTh.ttf');
$dompdf->getOptions()->setFontCache('template/ArialTh.ttf');
$dompdf->getOptions()->setIsFontSubsettingEnabled(true);
$dompdf->getOptions()->setDefaultFont('Arial');
$dompdf->getOptions()->setDpi(96);

// render the pdf (make sure ;GD Enabled)
$dompdf->render();

// Make it downloadable
$dompdf->stream("SURAT TAWARAN PENGAJIAN DIPLOMA VOKASIONAL MALAYSIA.pdf", ["Attachment" => false]);

