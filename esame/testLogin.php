<?php
include ("objects/db.php");
include ("objects/dipendente.php");
include ("objects/session.php");

#begin
    $dipendente=null;
    $ruolo=null;
    $pass=md5($_POST['password']);
    $email=$_POST['email'];
    $stmt = $db->prepare("CALL Auth(:email,:paaswo)");//two inputs and one output
    $stmt->bindParam(":email", $email,PDO::PARAM_STR);
    $stmt->bindParam(":paaswo", $pass,PDO::PARAM_STR);
    $stmt->execute();
    
    while ($row = $stmt->fetch()) {
        $dipendente=new Dipendente($row['nome'], $row['cognome'], $row['telefono'], $row['cf'], $row['mail'], $row['ruolo']);
        $ruolo=$row['ruolo'];
    }
    
    if($ruolo==null){
        header("Location:login.php");
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
        }
        $_SESSION['login']="invalid email or password, retry";
    }else{  
        if(isset($_SESSION['login'])){
            unset($_SESSION['login']);
        }
        $jsonDip=array("cf"=>null,"nome"=>null,"cognome"=>null,"telefono"=>null,"mail"=>null,"ruolo"=>null);
        $jsonDip['cf']=$dipendente->getCf();
        $jsonDip['nome']=$dipendente->getNome();
        $jsonDip['cognome']=$dipendente->getCognome();
        $jsonDip['telefono']=$dipendente->getTelefono();
        $jsonDip['mail']=$dipendente->getMail();
        $jsonDip['ruolo']=$dipendente->getRuolo();
        $_SESSION['user']=json_encode($jsonDip);
        if($ruolo=="sviluppatore"){
            header("Location:sviluppatore.php");
        }
    }
#end

/* create procedure Auth(IN _mail varchar(50), IN _passw varchar(50), OUT _ruolo varchar(15)) BEGIN declare type varchar(15); SELECT ruolo INTO type FROM dipendente WHERE mail = _mail AND passw=_passw; IF type =null THEN set type="failed"; END IF; END
SET @p0='sede-cesena1'; SET @p1='05'; CALL `GetHours`(@p0, @p1);

create view specifichePrenotazioni as select prenotazione.cf_dipendente, prenotazione.codice, prenotazione.dataInizio, prenotazione.oraInizio, prenotazione.oraFine, prenotazione.tipo_attivita, prenotazione.descrizione_attivita,cliente.cf, cliente.nome,cliente.cognome,cliente.telefono,postazione.numero,postazione.descrizione,postazione.area,postazione.denominazione_sede from dipendente inner join (prenotazione inner join (prenotazione_postazione inner join postazione on prenotazione_postazione.numero_postazione=postazione.numero) on prenotazione.codice=prenotazione_postazione.codice_prenotazione) ON dipendente.cf=prenotazione.cf_dipendente*/
?>