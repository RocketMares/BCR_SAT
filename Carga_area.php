<?php

include_once 'php/sesion.php';

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="img\LOGO11.ico">
    <title>VCR SAT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.css">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/css/all.css">
    <script defer src="js/js/all.js"></script>
    <script src="js//jquery-3.1.1.js"></script>
    <!--otros--->
    <link rel="stylesheet" href="css/bootstrap-table.min.css">
    <script src="js/bootstrap-table.min.js"></script>

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>

    <script type="text/javascript" src="js/jquery-1.6.min.js"></script>
    <script type="text/javascript" src="js/renueva.js"></script>

</head>

<?php
require_once 'php/menu_dinamico.php';
$menu = new Menu();
?>

<body>
    <?php
    $menu->Crear_menu();
    ?>


    <div class="container mt-5 pt-5">
        <center>
            <h1>Mantenimiento de Administraciónes</h1>
        </center>
    </div>
    <div class="container pt-4">
        <H1 class="display-4">Registro de Administración: </H1>
        <form method="POST">
           
            <div class="form-group row">
                <label for="inputState" class="col-sm-2 col-form-label">Nombre de la Administración</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nombre_area" name="nombre_area" placeholder=" Ejem: Administracion Desconcentrada de Recaudacion de la CDMX 4" name="nombre_area">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputState" class="col-sm-2 col-form-label">Nombre corto de la Administración</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nombre_area_corto" name="nombre_area_corto" placeholder=" Ejem: ADR4 DF4" name="nombre_area_corto">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="button" class="btn btn-primary" onclick="Registrar_Administracion()">Registrar</button>
                </div>
            </div>
        </form>
    </div>
    <div class="container pt-4">
    <H1 class="display-4">Actualizar Administración: </H1>
    <form action="php/ra_area.php" method="POST">
           
            <div class="form-group row">
                <label for="inputState" class="col-sm-2 col-form-label">Administracion Asociada: </label>
                <div class="col-sm-10">
                    <select class="custom-select line" id="id_admin" name="id_admin">
                        <option value='0'>Seleccionar Administración</option>
                        <?php
                 include_once 'php/ConsultaContribuyentes.php';
                 $consulta = new ConsultaContribuyentes();
                 $rows_area = $consulta->Consulta_Local($_SESSION["ses_id_admin"]);
                 for ($i = 0; $i < count($rows_area); $i++) {
                     if ($rows_area[$i]["estatus"] == "A") {
                         echo "<option value='" . $rows_area[$i]["id_admin"] . "'>" . $rows_area[$i]["nombre_admin"] . "</option>";
                     }
                 }
                 ?>

                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"> Cambio de Nombre : </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nombre_admin_cam" name="Nombre_sub_act">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputState" class="col-sm-2 col-form-label">Cambio de nombre corto de la Administración</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nombre_cort_admin_cam"
                        placeholder=" Ejem: ADR4 DF4" name="nombre_area" required>
                </div>
            </div>
            <fieldset class="form-group">
                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Estatus</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="Estatus" id="Estatus_activo" value="A"
                                checked>
                            <label class="form-check-label" for="Estatus_activo">
                                Activa
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="Estatus" id="Estatus_inactivo" value="N">
                            <label class="form-check-label" for="Estatus_inactivo">
                                Inactiva
                            </label>
                        </div>

                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="button" class="btn btn-primary" onclick="Actualiza_Administracion()">Actualizar</button>
                    </div>
                </div>
        </form>
    </div>

    <?php
    // se imprime footer
    $menu->Footer();
    ?>
          <script src='js/scripts_user.js'></script>
</body>

</html>