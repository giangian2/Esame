<?php
try {
    $hostname = "localhost";
    $dbname = "hybrid_working";
    $user = "spesagian";
    $pass = "apetuning1";
    $db = new PDO ("mysql:host=$hostname;dbname=$dbname", $user, $pass);
} catch (PDOException $e) {
    echo "Errore: " . $e->getMessage();
    die();
}
?>