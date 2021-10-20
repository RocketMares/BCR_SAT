<?php
if (isset($_POST['array'])) {
    $datos = json_decode($_POST["array"]) ;
    //$vis = json_encode($datos);
     include_once "ConsultaContribuyentes.php";
     $metodos = new ConsultaContribuyentes();
     $accion = $metodos->Registra_oficio($datos);
     echo $accion;

}
if (isset($_POST['array2'])) {
    $datos = json_decode($_POST["array2"]) ;
    // $vis = json_encode($datos);
     include_once "ConsultaContribuyentes.php";
     $metodos = new ConsultaContribuyentes();
     $accion = $metodos->Registra_oficio1($datos);
     echo $accion;

}
if (isset($_POST['Proc1'])) {
    $proc = $_POST['Proc1'];
    include_once "ConsultaContribuyentes.php";
     $metodos = new ConsultaContribuyentes();
     $vis = $metodos->Muestra_import_rec($proc);
     echo $vis;
}
if (isset($_POST['Proc2'])) {
    $proc = $_POST['Proc2'];
    include_once "ConsultaContribuyentes.php";
     $metodos = new ConsultaContribuyentes();
     $vis = $metodos->Muestra_import_rec2($proc);
     echo $vis;
}


if (isset($_POST['arrayRetro'])) {
$proc = $_POST['arrayRetro'];
$datos = json_decode($proc);
//$oficio = $datos->oficio;
include_once "sesion.php";
include_once "ConsultaContribuyentes.php";
$metodos = new ConsultaContribuyentes();
$accion = $metodos->Registra_oficioRetro_sencillo($datos);
echo $accion;


}

if (isset($_POST['registra_com'])) {
    $datos = $_POST['registra_com'];
    $com = $datos['com'];
    $oficio = $datos['oficio'];
    include_once "ConsultaContribuyentes.php";
     $metodos = new ConsultaContribuyentes();
     $vis = $metodos->Registra_comentario_por_oficios($oficio,$com);
      echo  $vis;
}
