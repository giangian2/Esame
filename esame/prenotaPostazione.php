<?php
include ("objects/sidebar.php");
include ("objects/db.php");
include ("objects/dipendente.php");
if(!isset($_SESSION["user"])){
    header("Location: login.php");
}else{
    $jsonDip=json_decode($_SESSION['user']);
}
?>
<html>
    <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>#page{background-color:rgb(0,56,101);}</style>
    <link rel="stylesheet" type="text/css" href="css/sviluppatore.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    </head>
    <body>
    <div class="container-xxl">
            <div class="header">
                <a href="#default" class="logo"><img src="Images/logo.svg" /></a>
                <div class="header-right">
                    <a href="logout.php">LogOut</a>
                    <a href="index.php" class="shake-slow">Home</a>
                    <a class="shake-slow btn btn-dark" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample" id="enjoy-button">Sidebar</a>
                </div>
                
            </div>
            <div class="container" id="page">
            <div class="card" >
                <form name="input" method="POST" action="DoPrenotaPostazione.php">
                <div class="card-body">
                    <h5 class="card-title">Inserisci dati prenotazione</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Area</h6>
                    <select class="input-group" name="area" id="area">
                        <option value="project-managment">Project Managment</option>
                        <option value="sviluppo">Sviluppo</option>
                        <option value="amministratori">Amministratori</option>
                    </select>
                    <br>
                    <h6 class="card-subtitle mb-2 text-muted">Data</h6>
                    <input type="date" class="form-control" name="_date" id="data" onchange="SelectedDate()">
                    <br>
                    <h6 class="card-subtitle mb-2 text-muted">Ora Inizo</h6>
                    <select class="input-group" name="oraInizio" id="oraInizio" onchange="SelectedInizio()">
                        <option value="08:00:00">8:00</option>
                        <option value="08:30:00">8:30</option>
                        <option value="09:00:00">9:00</option>
                        <option value="09:30:00">9:30</option>
                        <option value="10:00:00">10:00</option>
                        <option value="10:30:00">10:30</option>
                        <option value="11:00:00">11:00</option>
                        <option value="11:30:00">11:30</option>
                        <option value="12:00:00">12:00</option>
                        <option value="12:30:00">12:30</option>
                        <option value="13:00:00">13:00</option>
                        <option value="15:00:00">15:00</option>
                        <option value="15:30:00">15:30</option>
                        <option value="16:00:00">16:00</option>
                        <option value="16:30:00">16:30</option>
                        <option value="17:00:00">17:00</option>
                        <option value="17:30:00">17:30</option>
                        <option value="18:00:00">18:00</option>
                    </select>
                    <br>
                    <h6 class="card-subtitle mb-2 text-muted">Ora Fine</h6>
                    <select class="input-group" name="oraFine" id="oraFine"  onchange="fetchPosti()">
                    <option value="08:00:00">8:00</option>
                        <option value="08:30:00">8:30</option>
                        <option value="09:00:00">9:00</option>
                        <option value="09:30:00">9:30</option>
                        <option value="10:00:00">10:00</option>
                        <option value="10:30:00">10:30</option>
                        <option value="11:00:00">11:00</option>
                        <option value="11:30:00">11:30</option>
                        <option value="12:00:00">12:00</option>
                        <option value="12:30:00">12:30</option>
                        <option value="13:00:00">13:00</option>
                        <option value="15:00:00">15:00</option>
                        <option value="15:30:00">15:30</option>
                        <option value="16:00:00">16:00</option>
                        <option value="16:30:00">16:30</option>
                        <option value="17:00:00">17:00</option>
                        <option value="17:30:00">17:30</option>
                        <option value="18:00:00">18:00</option>
                    </select>
                    
                    <br>
                    <h6 class="card-subtitle mb-2 text-muted">N Posto</h6>
                    <select class="input-group" name="posti" id="posti">
                    </select>
                    <br>
                    <h6 class="card-subtitle mb-2 text-muted">Tipo Attivita</h6>
                    <select class="input-group" name="tipoAttivita">
                        <option value="studio di fattibilita">studio di fattibilita</option>
                        <option value="analisi">analisi</option>
                        <option value="progetto">progetto</option>
                        <option value="test">test</option>
                        <option value="sviluppo">sviluppo</option>
                        <option value="presentazione">presentazione</option>
                        <option value="assistenza">assistenza</option>
                    </select>
                    <br>
                    <h6 class="card-subtitle mb-2 text-muted">Descrizione attivita</h6>
                    <div class="input-group">
                        <span class="input-group-text">Descrivi</span>
                        <textarea class="form-control" aria-label="With textarea" name="descAttivita"></textarea>
                    </div>
                    <br>
                    <h6 class="card-subtitle mb-2 text-muted">Cf cliente</h6>
                    <div class="input-group">
                        <span class="input-group-text">Cf</span>
                        <input type="text" class="form-control" name="cfCliente" aria-describedby="addon-wrapping">
                    </div>
                    <br>
                    <h6 class="card-subtitle mb-2 text-muted">Nome e cognome cliente</h6>
                    <div class="input-group">
                        <span class="input-group-text">Nome | Cognome</span>
                        <input type="text" aria-label="nome" class="form-control" name="nomeCLiente">
                        <input type="text" aria-label="cognome" class="form-control" name="cognomeCLiente">
                    </div>
                    <br>
                    <h6 class="card-subtitle mb-2 text-muted">NTelefono e mail cliente</h6>
                    <div class="input-group">
                        <span class="input-group-text">Telefono (+39) | Mail</span>
                        <input type="text" aria-label="nome" class="form-control" name="telCliente">
                        <input type="text" aria-label="cognome" class="form-control" name="mailCliente">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary btn-lg">Prenota</button>
                </div>
                </form>
            </div>
            </div>
            
            <div class="footer-on">
                <footer id="foot" class="bg-light text-center text-lg-start">
                <div class="container p-4">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                            <h5 class="text-uppercase">Contatti</h5>
                            <p>
                                Per eventuali problematiche o info, contattare il seguente indirizzo mail: 
                                gianluca.bianchi0899@gmail.com;
                                oppure rivolgersi al seguente numero telefonico: +3316515569
                            </p>
                        </div>
                        <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                            <h5 class="text-uppercase">Info</h5>
                                <p>
                                    Azienda tecnologica GianTech.srl , assistenza , sviluppo software e tanto altro!
                                    Contattaci per avere informazioni o prenotare un colloquio con i nostri dipendenti!
                                </p>
                        </div>

                    </div>

                </div>
                <div class="text-center p-3" >
                    © 2020 Copyright:
                    <a class="text-dark" href="https://mdbootstrap.com/">Gianluca Bianchi Cesena(FC)</a>
                </div>
                </footer>
            </div>  
            <script>
                document.addEventListener("DOMContentLoaded", function(){
                    document.getElementById("oraInizio").disabled=true;
                    document.getElementById("oraFine").disabled=true;
                });

                function SelectedDate(){
                    document.getElementById("oraInizio").disabled=false;
                }

                function SelectedInizio(){
                    document.getElementById("oraFine").disabled=false;
                }

                function fetchPosti(){
                    var data=document.input._date.value;
                    var oraInizio=document.input.oraInizio.value;
                    var oraFine=document.input.oraFine.value;
                    var area=document.input.area.value;
                    alert(data);
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("posti").innerHTML=this.responseText;
                        }
                    };
                    xhttp.open("GET", "apis/apiPosti.php?data="+data+"&oraInizio="+oraInizio+"&oraFine="+oraFine+"&area="+area, true);
                    xhttp.send();
                }
            </script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
    </body>
</html>