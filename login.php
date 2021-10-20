
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="shortcut icon" href="img\LOGO11.ico">
    <title>BCR SAT</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg"  style='background:#5d2690;'>
        <a class="navbar-brand text-white" style="font-size:25px;" href="login.php" id="ver" >BCR <img src='img\LOGO11.ico' width='50' height='50' class=d-inline-block align-top alt=''></a>
</nav>

    <div class="container-fluid py-5">
        <?php
        if (isset($_GET["error"])) {
            switch ($_GET["error"]) {
                    case 1:
                        $error ="<div class='alert alert-danger' role='alert'>
                                El perfil esta inactivo.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button> 
                                </div>";
                        echo $error;
                    break;

                    case 2:
                        $error ="<div class='alert alert-danger' role='alert'>
                                El departamento esta inactivo.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>  
                                </div>";
                        echo $error;
                    break;
                    case 3:
                        $error ="<div class='alert alert-danger' role='alert'>
                                La subadminsitración esta inactivo.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button> 
                                </div>";
                        echo $error;
                    break;

                    case 4:
                        $error ="<div class='alert alert-danger' role='alert'>
                                La administración esta inactivo.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button> 
                                </div>";
                        echo $error;
                    break;

                    case 5:
                        $error ="<div class='alert alert-danger' role='alert'>
                                La contraseña no coincide con la registrada.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button> 
                                </div>";
                        echo $error;
                    break;
                    case 6:
                        $error ="<div class='alert alert-danger' role='alert'>
                                El usuario no existe.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button> 
                                </div>";
                        echo $error;
                    break;

                    case 7:
                        $error ="<div class='alert alert-danger' role='alert'>
                                No hay una sesion activa, debe iniciar sesión primero.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button> 
                                </div>";
                        echo $error;
                    break;

                    case 8:
                        $error ="<div class='alert alert-danger' role='alert'>
                                El timpo de sesión expiro por inactividad.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button> 
                                </div>";
                        echo $error;
                    break;
                    case 9:
                        $error ="<div class='alert alert-danger' role='alert'>
                        No ha firmado responsiva, comuniquese con su administrador para verificar el envio de su responsiva.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button> 
                                </div>";
                        echo $error;
                    break;
                
            }    
        }
                

        ?>
    
        <div class="container d-flex flex-column justify-content-around align-items-center">
        <h1 style="color:#378a57";><b> Ingreso de usuarios</b></h1>
            <form action="php/validar_acceso_user.php" method="post" >
                <div class="form-group">
                    <label for="ID_USER">Usuario:</label>
                    <input type="text" class="form-control" id="ID_USER" name="ID_USER" placeholder="RFC CORTO" maxlength="8" required onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
                <div class="form-group">
                    <label for="PASS_USER">Contraseña:</label>
                    <input type="password" class="form-control" id="PASS_USER" name="PASS_USER" placeholder="Contraseña" maxlength="15" required onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
                <div class="form-group">
                   
                   <a href="olvido_pass.php" class="text-dark" >¿Olvidaste tu contraseña? Da clic aquí.</a>
                </div>
                <div class="text-center">
                <button type="submit" class="btn btn-lg btn-default">Entrar</button>
                </div>
            </form>
        </div>
    </div>
    <?php



?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.1.1.js" ></script>
    <script src="js/Popper.min.js" ></script>
    <script src="js/bootstrap.js" ></script>
  </body>
</html>
