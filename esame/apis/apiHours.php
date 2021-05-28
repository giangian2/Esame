<?php
include ("../objects/db.php");
$dipendente=null;
    $ruolo=null;
    $mese=$_GET['mese'];
    $sede=$_GET['sede'];
    $cf=$_GET['cf'];
    $stmt = $db->prepare("CALL GetHours(:mese,:sede)");//two inputs and one output
    $stmt->bindParam(":mese", $mese,PDO::PARAM_STR);
    $stmt->bindParam(":sede", $sede,PDO::PARAM_STR);
    $stmt->execute();
    
    while ($row = $stmt->fetch()) {
       if($row['cf']==$cf){
           echo $row['totOre'];
       }
    }
?>