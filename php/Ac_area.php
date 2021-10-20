<?php
if (isset($_POST["array2"])) {
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $Metodos =  new ConsultaContribuyentes();
    $datos = $_POST["array2"];
    $admin = $datos["admin"];
    $sub_admin_asoc = $datos["sub_admin_asoc"];
    $nombre_sub = $datos["nombre_sub"];
    $estatus = $datos["estatus"];
    $resultado = $Metodos->Actualizar_datos_area($admin,$sub_admin_asoc,$nombre_sub,$estatus);
    if($resultado != true){
        return "<script>alert('No se actualizo la subadministración!')</script>";
    }
    else {
        return "<script>alert('Se actualizo satisfactoruamente la subadministración!')</script>";
    }
   
    
}