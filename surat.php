<?php
setlocale(LC_TIME, 'ms_MY.utf8');
strftime('%B', time());
require 'vendor/autoload.php';

include 'database/config.php';
if (isset($_REQUEST['nokp'])) {
    $id = $_REQUEST['nokp'];
    $retrieveData = "SELECT * FROM student WHERE nokp = '$id'";
    $execRetreive = mysqli_query($con, $retrieveData);
    $info = mysqli_fetch_array($execRetreive);

    $getProgramme = mysqli_query($con, "SELECT * FROM programme WHERE id_program = ".$info['programme']."");
    $programme = mysqli_fetch_array($getProgramme);

    $documentFormat = mysqli_query($con, "SELECT * FROM document WHERE id = '1'");
    $format = mysqli_fetch_array($documentFormat);
}


// Include the Dompdf namespace
use Dompdf\Dompdf;

ob_start();
$dompdf = new Dompdf([
    "chroot" => __DIR__
]);

// html template
require("template/template.php");

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
