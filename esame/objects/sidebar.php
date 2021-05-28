<?php
include ("session.php");
?>


<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel"><img src="Images/logo.svg" class="small-image"/></h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div>
                    Benvenuto nel menu del sito, qui potrai usufruire dei servizi messi a disposizione delle varie aziende spare nel territorio.
                    Per poter prenotare acceddi o registrati.
                    </div>
                    <div class="dropdown mt-3">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                            Scegli operazione
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php
                            if(isset($_SESSION['user'])){
                                $dipendente=json_decode($_SESSION['user']);
                                if($dipendente->ruolo=="sviluppatore"){
                                    echo '<li><a class="dropdown-item" href="sviluppatore.php">Profilo</a></li>';
                                }else if($dipendente->ruolo=="amministratore"){
                                    echo '<li><a class="dropdown-item" href="index.php">Profilo</a></li>';
                                    echo '<li><a class="dropdown-item" href="#">Pannello di controllo</a></li>';
                                }else{
                                    echo '<li><a class="dropdown-item" href="index.php">Profilo</a></li>';
                                    echo '<li><a class="dropdown-item" href="#">Modifica dati</a></li>';
                                }
                            }else{
                                echo '<li><a class="dropdown-item" href="login.php">Login</a></li>';
                            }
                            ?>
                            
                            <li><a class="dropdown-item" href="prenotaPostazione.php">Prenota Postazione</a></li>
                            <li><a class="dropdown-item" href="#">Prenota mezzo</a></li>
                            <li><a class="dropdown-item" href="#">Prenota Posto Mensa</a></li>
                            
                        </ul>
                    </div>
                </div>
            </div>