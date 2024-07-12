<?php

$env = parse_ini_string(file_get_contents(__DIR__.'/.env'));
$hostname = $env['HOSTNAME'];
$username = $env['USERNAME'];
$dbname = $env['DBNAME'];
$password = $env['PASSWORD'];

$SERVER = "localhost";
$USER = "root";
$PSWD = "danialdev";
$DB = "kvkualas_hep";

$con = mysqli_connect($SERVER, $USER, $PSWD, $DB);