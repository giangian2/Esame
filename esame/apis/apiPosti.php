<?php
include ("../objects/db.php");
$data=$_GET['data'];
$oraInizio=$_GET['oraInizio'];
$oraFine=$_GET['oraFine'];
$area=$_GET['area'];
$yymmdd = explode("-", $data);
$stmt = $db->prepare("SELECT * from postazione where postazione.numero not in (select infoprenotazioni.numero from infoprenotazioni where infoprenotazioni.anno=? and infoprenotazioni.mese=? and infoprenotazioni.giorno=? and (('$oraInizio' >= infoprenotazioni.oraInizio and '$oraFine' <= infoprenotazioni.oraFine)or ('$oraInizio' >= infoprenotazioni.oraInizio and infoprenotazioni.oraFine >='$oraFine') or ('$oraInizio' <= infoprenotazioni.oraInizio and '$oraFine'<= infoprenotazioni.oraFine) or ('$oraInizio' <= infoprenotazioni.oraInizio and '$oraFine' >= infoprenotazioni.oraFine))) and postazione.area='$area' ");//two inputs and one output
    $stmt->bindParam(1, $yymmdd['0'],PDO::PARAM_STR);
    $stmt->bindParam(2, $yymmdd['1'],PDO::PARAM_STR);
    $stmt->bindParam(3, $yymmdd['2'],PDO::PARAM_STR);

    $stmt->execute();
    
    while ($row = $stmt->fetch()) {
       echo "<option value=".$row['numero'].">".$row['numero']."</option>";
    }
?>