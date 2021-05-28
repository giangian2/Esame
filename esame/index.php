<?php
include ("objects/dipendente.php");
include ("objects/db.php");
include ("objects/sidebar.php");
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="scripts/index.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="css/index.css" />
        <link rel="stylesheet" type="text/css" href="https://csshake.surge.sh/csshake.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    </head>
    <body>
        <div class="container-xxl">
            
            <div class="header">
                <a href="#default" class="logo"><img src="Images/logo.svg" /></a>
                <div class="header-right">
                    <?php
                        
                        if(isset($_SESSION['user'])){
                            $dipendente=json_decode($_SESSION['user']);
                            if($dipendente->ruolo=="sviluppatore"){
                                echo "<a class='shake-slow active' href='sviluppatore.php'><img src='Images/logged.png' width='50px' height='50px'/></a>";
                            }
                        }else{
                            echo "<a class='shake-slow active' href='login.php'>Login</a>";
                        }
                    ?>
                    
                    <a href="#contact" class="shake-slow">Contact</a>
                    <a class="shake-slow" onclick="toggleSidebar()">Sidebar</a>
                </div>
                
            </div>
            <div class="container" id="image">
                <div class="testoCentrato">
                    GianTech developments software e network<br>
                    <div class="shake-slow btn btn-dark" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample" id="enjoy-button">JOIN</div><div class="shake-slow btn"><img class="small-image" src="Images/github.png" /></div>
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
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
       
    </body>
</html>
