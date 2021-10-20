<!DOCTYPE html>
<?php
include_once("php/sesion.php");
// redirecionar en caso de no contar con el perfil adecuado.
// valida que si son usuarios que no sean Super Admin no puedan acceder por medio de la URL.
if (isset($_GET['error'])) {
  if ($_GET['error'] == 1) {
    echo "<script>
      alert('La contraseña no debe tener menos de 6 caracteres.')
    </script>";
  }elseif ($_GET['error'] == 2) {
    echo "<script>
            alert('Las contraseñas ingresadas deben de ser iguales.')
          </script>";
  }
}
 ?>
<html lang="en" dir="ltr">
  <head>

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <meta charset="utf-8">
    <script type="text/javascript" src="js/renueva.js"></script>
    <title>BCR SAT</title>
  </head>
  <body>
    <!-- Inicio de la barra de navegación -->
    <?php
        require_once 'php/menu_dinamico.php';
        $menu = new Menu();
        $menu->Crear_menu();
          
    ?>
    <!-- maquetación de vista -->
<!-- Fin de la barra de navegación -->

<!-- Inicio de contenido -->
<div class="container-fluid py-5">
<div class="text-center py-4">
  <p class="h1">Cambio de contraseña.</p>
  <br>
  <div class="container">
  <p class="lead">Por ser la primera vez que ingresas al <strong>Bitacora de condonaciones y reducciones SAT</strong>, 
  te pedimos <strong>cambiar tu contraseña</strong> para asi garantizar la seguridad de tu cuenta y
   disfrutes mejor del contenido.</p>
   </div>

   <div class="container">
    <div class="row">
        <div class="col-md-6 d-flex justify-content-end align-items-center col-sm-12">
          <form id="formularioPass" method="post" action="php/validar_primer_cambio_pass.php">
            <div class="form-row">
              <div class="form-group">
                <label for="Password">Nueva contraseña:<samp class="text-danger">*</samp></label>
                <input type="password" class="form-control letras2" id="Password" name="Password"  maxlength="15" minlength="6" required  onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label for="Password_C">Confirmar contraseña:<samp class="text-danger">*</samp></label>
                <input type="password" class="form-control letras2" id="Password_C" name="Password_C" maxlength="15" minlength="6" required  onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>
            </div>
            <button type="submit" id="btn_CP" class="btn btn-block small btn-primary">Confirmar cambio</button>
          </form>
        </div>
        <div class="d-flex justify-content-start  col-md-6 col-sm-12">
          <img src="img/seguridad.png" class="img-fluid">
        </div>
    </div>
  </div>
</div>

</div>

<?php
//Footer
$menu->Footer();
?>


  

</html>
