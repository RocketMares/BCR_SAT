<?php

if (isset($_POST['oficio'])) {

 
    $oficio = $_POST['oficio'];
     include_once "ConsultaContribuyentes.php";
    $metodos = new ConsultaContribuyentes();
     $datos = $metodos->datos_tabla_oficios_indi($oficio);
    //  $vista = json_encode($datos);
    //  echo  $vista;

//  Parte de arriba;

     echo  ' <b>RFC</b>: ', $datos[0]['RFC'];
     echo  '<br /> <b>Razón social</b>: ', $datos[0]['razon_social'];
     echo  '<br /> <b>Número de Oficio</b>: ', $datos[0]['Oficio Autorización'];
     echo  '<br /> <b>Folio Gestor Web</b>: ', $datos[0]['folio_gestor'];
     echo  '<br /> <b>Tipo de tramite</b>: ', $datos[0]['tipo_tramite'];

     $importe_recuperado = $datos[0]['importe_recuperado'] != '' ? $datos[0]['importe_recuperado'] : "En espera de retroalimentación"  ;
     $importe_condonado = $datos[0]['importe_condonado'] != '' ? $datos[0]['importe_condonado']:"En espera de retroalimentación"  ;
     $fecha_retro = $datos[0]['fecha_mod'] != null ? $datos[0]['fecha_mod']->format('d-m-Y'):"En espera de retroalimentación";
     $linea_captura = $datos[0]['linea_captura'];
   
     $fecha_notif = $datos[0]['fecha_notif'] != null ? $datos[0]['fecha_notif']->format('d/m/Y') : null;
  //  Pestañas Detalle y Retroalimentar;
  //  Pestañas Detalle;
  
  echo "
  <ul class='nav nav-tabs' id='myTab' role='tablist'>
      <li class='nav-item'>
          <a class='nav-link active' id='home-tab' data-toggle='tab' href='#home' role='tab' aria-controls='home'
              aria-selected='true'>Detalle</a>
      </li>

      ";
  

  //  Pestañas Retroalimentar;
  if($datos[0]['fecha_notif'] == null or ($linea_captura == null) or ( $importe_recuperado == 'En espera de retroalimentación') or ( $importe_condonado == 'En espera de retroalimentación') ){
      echo "
      <li class='nav-item'>
          <a class='nav-link' id='profile-tab' data-toggle='tab' href='#profile' role='tab' aria-controls='profile'
              aria-selected='false'>Retroalimentar</a>
      </li>
  ";}
 echo "
 <li class='nav-item'>
 <a class='nav-link' id='comentario-tab' data-toggle='tab' href='#comentario' role='tab' aria-controls='comentario'
     aria-selected='false' onclick='muestra_comentarios($oficio)'>Comentarios</a>
</li>
</ul>";

  
  //  Inicio de la Primer pagina (Detalle);
  echo "
    <div class='tab-content' id='myTabContent'>
      <div class='tab-pane fade show active' id='home' role='tabpanel' aria-labelledby='home-tab'>

      <!---------------- Tabla de Linea de Captura ---------------->
      <table
      class='table table-responsive justify-content-center table-sm table-hover text-center vh-75 shadow p-1 bg-white rounded'>
      <table
          class='table  justify-content-center table-sm table-hover text-center vh-75 shadow p-1 bg-white rounded'>
          <thead class='thead-dark'>
              <tr>
    
                  <th scope='col'>Línea de Captura</th>
                  
              </tr>
    
    
              <tr>
                <td>".$linea_captura."</td>
                </tr>
    
      </table>
    
      </thead>

        <!--------------------- Tabla de Importes ---------------------->
          <table
              class='table table-responsive justify-content-center table-sm table-hover text-center vh-75 shadow p-1 bg-white rounded'>
              <table
                  class='table  justify-content-center table-sm table-hover text-center vh-75 shadow p-1 bg-white rounded'>
                  <thead class='thead-dark'>
                      <tr>
  
                          <th scope='col'>Importe Histórico</th>
                          <th scope='col'>Importe Recuperado</th>
                          <th scope='col'>Importe Condonado</th>
                      </tr>
  
  
                      <tr>
                          <td>".$datos[0]['importe_his']."</td>
                          <td>".$importe_recuperado."</td>
                          <td>".$importe_condonado."</td>
                      </tr>
  
              </table>
  
              </thead>";
  
            //   <!--------------------- Tabla de Fechas ---------------------->
              echo "
              <table
                  class='table  justify-content-center table-sm table-hover text-center vh-75 shadow p-1 bg-white rounded'>
                  <thead class='thead-dark'>
                      <tr>
  
                          <th scope='col'>Fecha de Alta</th>
                         
                          <th scope='col'>Fecha de retroalimentación</th>
                      </tr>";
                    
                     
                      echo" <tr>
                          <td>".$datos[0]['fecha_alta']->format('d-m-Y')."</td>
                          
                          <td>".$fecha_retro."</td>
                      </tr>
  
              </table>
  
              </thead>
      </div>

  
      <!--- Fin de la primera vista -->
  
      <!--- Comienzo de la segunda -->";

      echo"
      <div class='tab-pane fade' id='comentario' role='tabpanel' aria-labelledby='comentario-tab'>
      <h2>Agregar Comentarios</h2>
<div class='row container mt-2' >
<div class='input-group'>
<textarea class='form-control' id='text_com' aria-label='With textarea'></textarea>
<button type='button' class='btn btn-outline-primary' onclick='Agrega_comentario(\"$oficio\")' >Comentar</button>
</div>
</div>
<h2>Listado de comentarios</h2>
        <div id='respuesta_coment'></div>
  </div>
      <div class='tab-pane fade' id='profile' role='tabpanel' aria-labelledby='profile-tab'>";
     
    //   <!--------------------- Inician los datos de la segunda ---------------------->
    
   

    

    echo "
   
    <br />

<div class='container'>

<div class='row'> ";
  
if($datos[0]['fecha_notif'] == null){
                  echo "   
                  <div class='col-md-4'>
                      <label for='fecha_seg'>Fecha de notificación:</label>
                      <input type='text' class='form-control fecha_end ' id='Fecha_notif_retro' name='Fecha_notif_retro'
                          placeholder='yyyy/mm/dd' value=''>
                   </div> "; }
                   else {echo"";}
  if($datos[0]['linea_captura'] == null){
  echo "   
  <div class='col-md-4'>
      <label for='fecha_seg'>Linea de captura:</label>
      <input type='text' class='form-control' id='validationLinea' name='validationLinea'
          placeholder='Capura linea de captura' value='' required maxlength='32'>
    </div> "; }
    else {echo"";}


                   
                   if( $importe_recuperado !== 'En espera de retroalimentación'){echo"
                    <div class='col-md-4'>
                    <label ></label>
                    <label ></label>
                    
                 </div>
                    
                    
                    ";}
                   else {
                   echo "
                  <div class='col-md-4'>
                  <label for='validationServer02'>Importe Recuperado:<samp class='text-danger'></samp></label>
                  <input class='form-control' name='validationRecuperado2' id='validationRecuperado2' value='$'
                          data-inputmask-alias='numeric' data-inputmask-groupSeparator=',' data-inputmask-digits=2
                          data-inputmask-digitsOptional=false data-inputmask-prefix='$ '
                          data-inputmask-placeholder='0' placeholder='$ 0.00'>
              </div>";}

              if( $importe_condonado !== 'En espera de retroalimentación'){echo"
                <div class='col-md-4'>
                <label ></label>
                <label ></label>
              
             </div>";}
              else {
              echo "
              <div class='col-md-4'>
                  <label for='validationServer02'>Importe Condonado:<samp class='text-danger'></samp></label>
                 <input class='form-control' name='validationCondonado2' id='validationCondonado2' value='$'
                          data-inputmask-alias='numeric' data-inputmask-groupSeparator=',' data-inputmask-digits=2
                          data-inputmask-digitsOptional=false data-inputmask-prefix='$ '
                          data-inputmask-placeholder='0' placeholder='$ 0.00'>
              </div>

              </div>
             
              </div>
             
                "; }
            
            

             
             echo "
              ㅤ
             <br />
             <label >                                            
                                                                                              </label>            
             <button type='button' class='btn btn-primary' onclick='valida_retro(\"".$oficio."\")'>Actualizar registro</button>

               

  ";
   
          
         
echo"
  <script>
  
  $(document).ready(function(){
    $(\"#Fecha_notif_retro\").datepicker({ 
      endDate: 'today',
      autoclose: true,
      daysOfWeekDisabled: [0, 6],
      todayHighlight: true,
      format: 'yyyy/mm/dd',
      toggleActive: true,
      language: 'es'
  })
  });
  
  </script>
            
        ";

        

             
    }


if (isset($_POST['muestra_comentarios'])) {
//    echo "si llegas aqui 2 323432";
$ofi = $_POST['muestra_comentarios'];
include_once "ConsultaContribuyentes.php";
$metodos = new ConsultaContribuyentes();
$datos = $metodos->busca_comentarios_x_ofi($ofi);
echo"

<table class='table table-sm table-hover text-center vh-75 shadow p-1 bg-white rounded'>
<thead>
  <tr>
    <th scope='col'>#</th>
    <th scope='col'>Comentario</th>
    <th scope='col'>Analista</th>
    <th scope='col'>fecha</th>
  </tr>
</thead>
<tbody>";
$q = 1;
if (isset($datos)) {
    for ($i=0; $i < count($datos) ; $i++) { 
        echo" <tr>
        <th scope='row'>".$q++."</th>
        <td>".$datos[$i]['comentario']."</td>
        <td>".$datos[$i]['nombre_empleado']."</td>
        <td>".$datos[$i]['fecha_alta']->format('d-m-Y H:i')."</td>
      </tr>";
    }
}
else {
    echo" <tr>
        <th scope='row'></th>
        <td></td>
        <td></td>
        <td></td>
      </tr>";
}


 
echo"</tbody>
</table>";

}

        ?>

<script src="js/ShowHide.js"></script>
<script src="js/jquery.inputmask.js"></script>
<script src="js/inputmask.binding.js"></script>

