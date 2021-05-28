<?php
    session_start();
    if(isset($_SESSION['user'])){
        header("Location: index.php");
    }
?>
<html>
    <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="scripts/index.js" type="text/javascript"></script>
    <style>body{margin:0; padding:0;background-color:rgb(0,56,101);font: 16px/28px;font-family:sans-serif; background-size:cover;}</style>
    <link rel="stylesheet" type="text/css" href="css/login.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    </head>
    <body>
        <div id="containe" class="">
            <div id="login-box">
               <h1 class="animated bounceInDown">LogIn</h1> 
               <form method="post" action="testLogin.php">
                <div class="textbox" id="mail">
                    <i aria-hidden="true"><img id="icon1" src="Images/mail.png"></i>
                    <input type="text" placeholder="Email" name="email">
                </div>
                <div class="textbox" id="passw">
                    <i aria-hiddent="true"><img id="icon2" class="" src="Images/passw.png"></i>
                    <input type="password" placeholder="password" name="password">
                </div>   
                <button type="submit" class="btn btn-outline-dark" >LogIn</button>
                    <?php
                        if(isset($_SESSION['login'])){
                            echo "<h5 id='error'>".$_SESSION['login']."</h5>";
                        }
                    ?>
                </form>
                <a href="register.php">Non hai ancora un'account?Clicca qui</a>
            </div>
        </div>
    </body>
    <script>
            x=document.getElementById("mail");
            x.addEventListener("mouseover",function(){
                document.getElementById("icon1").setAttribute("class","animated flip");
            });
            x.addEventListener("mouseout",function(){
                document.getElementById("icon1").setAttribute("class","");
            });
            y=document.getElementById("passw");
            y.addEventListener("mouseover",function(){
                document.getElementById("icon2").setAttribute("class","animated flip");
            });
            y.addEventListener("mouseout",function(){
                document.getElementById("icon2").setAttribute("class","");
            });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
</html>
