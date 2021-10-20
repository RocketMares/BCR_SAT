<?php


if(!$_GET){
  header('Location:index.php?pagina=1');
}

include_once 'php/sesion.php';


?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" href="img\LOGO11.ico">
  <title>BCR SAT</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/css/all.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <script defer src="js/js/all.js"></script>
  <script src="js//jquery-3.1.1.js"></script>
  <link rel="stylesheet" href="css/bootstrap-table.min.css">
  <script src="js/bootstrap-table.min.js"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/main.js"></script>
  <script type="text/javascript" src="js/jquery-1.6.min.js"></script>

  <style>
    .box {
      color: rgb(0, 0, 0);
      /* padding: 50px; */
      display: none;
      /* margin-top: 10px; */
    }

    .red {
      background: #ffffff;
    }

    .green {
      background: #ffffff;
    }

    .blue {
      background: #ffffff;
    }
  </style>

</head>

<?php

      include_once 'php/menu_dinamico.php';
      $menu = new Menu();
      $ver = $menu->Crear_menu();


    ?>

<br>
<div class="mt-4 my-5">

</div>




<!-- <div class="container mt-5 pt-5">
  <center>
    <h1 class="display-4">Bitacora de condonaciones y reducciones. </h1>
  </center>
</div> -->

<!-- Button trigger modal -->
<!-- Espacio por caracteres al boton agregar oficio -->




<nav class="navbar navbar-expand-lg navbar-light bg-secondary">

  <label>      </label>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">

    <ul class="navbar-nav nav-pills mr-auto">
      <li class="nav-item active">
        <a class="nav-link nav-link bg-primary text-white" type="button" onclick="Muestra_modal_reg_of()">Agregar
          registro <span class="sr-only">(current)</span></a>
      </li>

      <label>            </label>
      <input type="button" id="botonocultamuestra" value="Ocultar Filtros"
        style="font-size:14px;cursor:pointer;margin:5px;padding:5px;" />
    </ul>
  </div>
</nav>

<div id="divocultamuestra">
  <div class="container py-1">
    <!-- <div class="text-center py-3">
       <button id="Ver_Filtro" class="btn btn-primary" type="button" name="button">Ocultar filtros</button>
  </div> -->


    <div class="row" name="Contenedor_Filtros" id="FILTROS">

    <div class="col-md-7 col-sm-12">

        <p class="h5"> Filtros de busqueda.</p>
        <div class="py-3 text-center flex-colun justify-content-center align-items-center">

          <select class="custom-select col-5" id="sub_admin">
            <option value="0" selected>Selecciona Subadmin</option>
            <?php 
					  include_once "php/MetodosUsuarios.php";
					  $metodo = new MetodosUsuarios();
					  $admin = $metodo->Consulta_Subadmin($_SESSION['ses_id_admin_con']);
					  for ($i=0; $i < count($admin) ; $i++) { 
						echo" <option value='".$admin[$i]['id_sub_admin']."'>".$admin[$i]['nombre_sub_admin']."</option>";
					  }
					 ?>
          </select>
          <select class="custom-select col-5" id="depto">
            <option value="0" selected>Selecciona Departamento</option>

          </select>

          <button type="button" class="btn btn-outline-dark" id="filtra_estructura">Buscar</button>


          <div class="row">
            <div class="input-group col-md-12">
              <div class="col-sm-3">
                <label class="input-group-text" for="inputGroupSelect01"> No. de Oficio:</label>
              </div>

              <input type="text" class="form-control col-8" id="FiltroOficio" placeholder="Ejemplo: 17852" maxlength="5"
                onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
              <button type="button" class="btn btn-outline-dark" id="filtra_oficio">Buscar </button>
            </div>
          </div>

          <div class="row">
            <div class="input-group col-md-12">
              <div class="col-sm-3">
                <label class="input-group-text" for="inputGroupSelect01"> Folio Gestor:</label>
              </div>

              <input type="text" class="form-control col-8" id="FiltroGestor" placeholder="Ejemplo: 2021001234-0"
              data-inputmask="'Mask':'9999999999-9'" required>
              <button type="button" class="btn btn-outline-dark" id="filtra_Gestor_wb">Buscar</button>
            </div>
          </div>

          <div class="row">
            <div class="input-group col-md-12">
              <div class="col-sm-4">
                <label class="input-group-text" for="inputGroupSelect01"> No. Determinante:</label>
              </div>

              <input type="text" class="form-control col-8" id="FiltroDet" placeholder="Ejemplo: COND11/2021"
                onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
              <button type="button" class="btn btn-outline-dark" id="filtra_por_deter">Buscar</button>
            </div>
          </div>

          <div class="row">
            <div class="input-group col-md-12">
              <div class="col-sm-4">
                <label class="input-group-text" for="inputGroupSelect01"> Por prioridad:</label>

              </div>
              <select class="custom-select" id="prioridad" name="prioridad">
                <option value='0'>Seleccionar Opción</option>
                <option value='1'>Mas de 4 dias sin ingresar la fecha notificación desde su alta.</option>
                <option value='2'>Mas de 16 dias sin ingresar la fecha notificacíon desde su alta.</option>
              </select>
              <button type="button" class="btn btn-outline-dark" id="filtra_por_prioridades">Buscar</button>
            </div>
          </div>


        </div>

      </div>

      <div class="col-md-5 col-sm-12">
  
        <div class="p-3 mb-2 table-danger text-dark">Mas de 4 días sin ingresar la fecha notificación.
        </div>
        <div class="p-3 mb-2 bg-secondary text-white">Mas de 16 días sin ingresar información complementaria.
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Modificación style="padding-top: 3rem !important -->

<div class="container-fixed center my-2 mt-2 " style="padding-top: rem!important;">
  <?php 

      include_once "php/Vista_vitacora.php";
      $vistas = new Vista_vitacora();
      $tab = $vistas->vista_general();

?>
</div>

<!-- <button class="btn btn-primary" onclick="trae()"> trae el modal </button> -->


<!-- Modal detalle -->
<div class="modal fade" id="Detalle_of" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Detalle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container mt-2" id="detalles"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<script>
  function trae() {
    $('#Detalle_of').modal();
  }
</script>



<!-- Modal -->
<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Registro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <H1 class="display-8">Formulario: </H1>
        <form>

          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="validationTramite">Tipo de Tramite: <samp class="text-danger">*</samp></label>
              <select class="custom-select" id="tip_tramite">
                <option value="0" selected>Selecciona tipo de Tramite</option>
                <option value="C">Condonación</option>
                <option value="R">Reducción</option>
              </select>
            </div>

            <div class="col-md-4 mb-3">
              <label for="validationServer01">Folio Gestor Web: <samp class="text-danger">*</samp></label>
              <input type="text" class="form-control " name="validationFolioGW" id="validationFolioGW"
                placeholder="Folio Gestor" data-inputmask="'Mask':'9999999999-9','autoUnmask' : true" required>
            </div>

            <div class="col-md-4 mb-3">
              <label for="validationServer02">RFC del Contribuyente: <samp class="text-danger">*</samp></label>
              <input type="text" class="form-control " id="RFC_contri" name="RFC_contri" placeholder="RFC"
                onkeyup="javascript:this.value=this.value.toUpperCase();" required maxlength="13">
            </div>

          </div>

          <div class="form-row">


            <div class="col-md-8 mb-3">
              <label for="validationServerUsername">Nombre o Razón social: <samp class="text-danger">*</samp></label>
              <input type="text" class="form-control " id="razon_social" name="razon_social"
                placeholder="Nombre del Contribuyente" onkeyup="javascript:this.value=this.value.toUpperCase();"
                required>
            </div>

            <div class="col-md-4 mb-3">
              <label for="validationServer02">Número de Oficio: <samp class="text-danger">*</samp></label>
              <input type="text" class="form-control " id="validationNoOficio" placeholder="No. de Oficio" maxlength="5"
                onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required>
            </div>

          </div>

          <div class="form-row">


            <div class="col-md-4 mb-3">
              <label for='fecha_seg'>Fecha determinate:<samp class='text-danger'>*</samp></label>
              <input type=' text' class='form-control fecha_end' id='fecha_det' name='fecha_det'
                placeholder='yyyy/mm/dd' value="">
            </div>
            <div class="col-md-4 mb-3">
              <label for="validationServer02">Importe Historico: <samp class="text-danger">*</samp></label>
              <td style="width: 35px;text-align: center;"></td>
              <td><input class="form-control" name="validationHistorico" id="validationHistorico" value="$"
                  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                  style="text-align: right;" placeholder="$ 0.00"></td>
            </div>


            <div class="col-md-4 mb-3">
              <label for='validationServer01'>Linea de Captura: </label>
              <input type='text' class='form-control' name='validationLinea' id='validationLinea'
                placeholder='Captura linea de captura' required maxlength='32'>
            </div>

           


          </div>

          <div class="form-row">




            <div class="col-md-4 mb-3">
              <label for='validationServer02'>Importe Recuperado:
              <!-- <samp class='text-danger'>*</samp> -->
              </label>
              <input class='form-control' name='validationRecuperado' id='validationRecuperado' value='$'
                  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                  style='text-align: right;' placeholder='$ 0.00'>
            </div>

            <div class="col-md-4 mb-3">
              <label for='validationServer02'>Importe Condonado:
                <!-- <samp class='text-danger'>*</samp> -->
              </label>
              <input class='form-control' name='validationCondonado' id='validationCondonado' value='$'
                  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                  style='text-align: right;' placeholder='$ 0.00'>
            </div>

            <div class="col-md-4 mb-3">
              <label for='fecha_seg'>Fecha de notificación:</label>
              <input type='text' class='form-control fecha_end ' id='fecha_notf' name='fecha_notf'
                placeholder='yyyy/mm/dd' value="">
            </div>
           
          </div>


          </form>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      <button type="button" class="btn btn-primary" onclick="valida_formulario_reg_oficio()">Guardar registro</button>


    </div>
    
      </div>


     </div>

    
 
</div>
</div>



<?php
    // se imprime footer
    include_once 'php/menu_dinamico.php';
    $menu = new Menu();
    $menu->Footer();
    ?>



<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="js/jquery-3.1.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.inputmask.js"></script>
<script src="js/inputmask.binding.js"></script>
<script src="js/ShowHide.js"></script>
<!-- <script type='text/javascript' src='js/scripts_user.js'></script> -->
<script src="js/valida_formularios_entrevistas.js"></script>
<script src="js/filtros_oficios.js"></script>
<script type='text/javascript' src='js/libs/bootstrap-datepicker.min.js'></script>
<script src='js/libs/locales/bootstrap-datepicker.es.js' charset='UTF-8'></script>
<script src='js/libs/bootstrap-datepicker.js' charset='UTF-8'></script>
<link rel="stylesheet" href="css/libs/bootstrap-datepicker3.min.css">


</body>

</html>