<?php
include ("objects/sidebar.php");
include ("objects/db.php");
include ("objects/dipendente.php");
if(isset($_SESSION["user"])){
    $jsonDip=array("cf"=>null,"nome"=>null,"cognome"=>null,"telefono"=>null,"mail"=>null,"ruolo"=>null);
    $jsonDip=json_decode($_SESSION['user']);

    if($jsonDip->ruolo!="sviluppatore"){
        header("Location: login.php");
    }
}else{
    header("Location: login.php");
}
?>
<html>
    <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="scripts/sviluppatore.js" type="text/javascript"></script>
    <style>
    
    h2{color: white;}
    #page{background-color:rgb(0,56,101);} 



    </style>
   
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
                <h2 id="Info">Dati Personali</h2>
                <ol class="list-group list-group-numbered">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Mail</div>
                            <?php echo $jsonDip->mail; ?>
                        </div>
                        <span class="badge bg-primary rounded-pill">1</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Codice Fiscale</div>
                            <?php  echo "<div id='cf'>".$jsonDip->cf."</div>"; ?>
                        </div>
                        <span class="badge bg-primary rounded-pill">2</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                             <div class="fw-bold">Nome</div>
                             <?php  echo $jsonDip->nome; ?>
                        </div>
                        <span class="badge bg-primary rounded-pill">3</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                             <div class="fw-bold">Cognome</div>
                             <?php  echo $jsonDip->cognome; ?>
                        </div>
                        <span class="badge bg-primary rounded-pill">4</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                             <div class="fw-bold">Telefono</div>
                             <?php  echo $jsonDip->telefono; ?>
                        </div>
                        <span class="badge bg-primary rounded-pill">5</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                             <div class="fw-bold">Ruolo</div>
                             <?php   echo $jsonDip->ruolo;?>
                        </div>
                        <span class="badge bg-primary rounded-pill">6</span>
                    </li>
                </ol>
                <h2>Ore Lavorate</h2>
                <div class="card" >
                <div class="card-body">
                    <h5 class="card-title">Visualizza ore lavorate in sede</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Seleziona sede</h6>
                    <form name="input">
                    <select class="form-control" name="sede">
                        <?php
                        $stmt = $db->prepare("SELECT denominazione FROM sede");//two inputs and one output
                        $stmt->execute();                
                        while ($row = $stmt->fetch()) {
                            echo "<option value='".$row['denominazione']."'>".$row['denominazione']."</option>";
                        }                       
                        ?>
                        
                    </select>
                    <br>
                    <h6 class="card-subtitle mb-2 text-muted">Seleziona mese</h6>
                    <select class="form-control" name="mese">
                        <option value=01>Gennaio</option>
                        <option value=02>Febbraio</option>
                        <option value=03>Marzo</option>
                        <option value=04>Aprile</option>
                        <option value=05>Maggio</option>
                        <option value=06>Giugno</option>
                        <option value=07>Luglio</option>
                        <option value=08>Agosto</option>
                        <option value=09>Settembre</option>
                        <option value=10>Ottobre</option>
                        <option value=11>Novembre</option>
                        <option value=12>Dicembre</option>
                    </select>
                    <input class="btn btn-primary" type="button" value="Input" onclick="GetHours()">
                    <div class="alert alert-primary" role="alert" id="result">
                    </div>
                    </form>
                </div>
                
            </div>
            <h2>Prenotazioni</h2>
                <div class="card" >
                <div class="card-body">
                    <h5 class="card-title">Prenotazioni Postazioni</h5>
                    <h6 class="card-subtitle mb-2 text-muted">numero di prenotazioni per ciascun mese</h6>
                    <canvas id="myChart"></canvas>
                    <?php

                    ?>
                </div>
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
            function GetHours(){
                var mese=document.input.mese.value;
                var sede=document.input.sede.value;
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("result").innerHTML="Il totale di ore lavorate ammonta a: "+this.responseText;
                    }
                };
                xhttp.open("GET", "apis/apiHours.php?mese="+mese+"&sede="+sede+"&cf="+document.getElementById("cf").innerHTML, true);
                xhttp.send();
            }

            const labels = [
            'Gennaio',
            'Febbraio',
            'Marzo',
            'Aprile',
            'Maggio',
            'Giugno',
            'Luglio',
            'Agosto',
            'Settembre',
            'Ottobre',
            'Novembre',
            'Dicembre'
            ];
            const data = {
                labels: labels,
                datasets: [{
                    label: 'Prenotazioni x mese',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [
                    <?php
                    $c=0;
                    while($c<12){
                        $stmt = $db->prepare("SELECT COUNT(cf) FROM infoprenotazioni where cf='$jsonDip->cf' and mese=$c");//two inputs and one output
                        $stmt->execute();                
                        while ($row = $stmt->fetch()) {
                            echo $row[0].",";
                        }  
                        $c++;
                    }
                    ?>
                    ],
                }]
            };
            const config = {
                type: 'line',
                data,
                options: {}
            };
            var myChart = new Chart(
                document.getElementById('myChart'),
                config
            );
            </script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
    </body>
</html>