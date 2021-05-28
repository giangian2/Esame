<?php
include ("objects/db.php");
include ("objects/session.php");
$data=date("Y-m-g");
$dipendente=json_decode($_SESSION['user']);
$cfDipendente=$dipendente->cf;
$tipoAttivita=$_POST['tipoAttivita'];
$descAttivita=$_POST['descAttivita'];
$cfCliente=$_POST['cfCliente'];
$nomeCliente=$_POST['nomeCLiente'];
$cognomeCliente=$_POST['cognomeCLiente'];
$telCLiente=$_POST['telCliente'];
$mailCliente=$_POST['mailCliente'];
$dataInizio=$_POST['_date'];
$oraInizio=$_POST['oraInizio'];
$numero=$_POST['posti'];
$oraFine=$_POST['oraFine'];
$nslot= 6; 
$codice="PT".rand(100,1700);
$dataSplittata=explode("-",$dataInizio);
$giorno=$dataSplittata[2];
$mese=$dataSplittata[1];
$anno=$dataSplittata[0];

$stmt= $db->prepare("SET @p0='$numero'; SET @p1='$giorno'; SET @p2='$mese'; SET @p3='$anno'; SET @p4='$oraInizio'; SET @p5='$oraFine'; SET @p6=
'$cfDipendente'; SET @p7='$cfCliente'; SET @p8=
'$tipoAttivita'; SET @p9='$descAttivita'; SET @p10=
'$nomeCliente'; SET @p11='$cognomeCliente'; SET @p12='$telCLiente'; SET @p13='$mailCliente'; SET @p14='$codice'; SET @p15='$data'; SET @p16='$nslot'; CALL `PrenotaPostazione`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11, @p12, @p13, @p14, @p15, @p16)");


//$stmt = $db->prepare("CALL PrenotaPostazione($numero, $giorno, $mese, $anno, $oraInizio, $oraFine, $cfDipendente, $cfCliente, $tipoAttivita, $descAttivita, $nomeCliente, $cognomeCliente, $telCLiente, $mailCliente, $codice, $data, $nslot)");//two inputs and one output
$stmt->execute();

header ("Location: index.php");

?>