<?php
if (isset($_POST["array"])) {
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $Metodos =  new ConsultaContribuyentes();
    $datos = $_POST["array"];
    $admin = $datos["admin_asoc"];
    $nombre_admin_cam = $datos["nombre_admin_cam"];
    $nombre_cort_admin_cam = $datos["nombre_cort_admin_cam"];
    $estatus = $datos["estatus"];
    $Metodos->Actualizar_datos_admin($admin,$nombre_admin_cam,$nombre_cort_admin_cam,$estatus);
    if($Metodos != true){
        return "<script>alert('No actualizo la administracíon !')</script>";
    }
    else {
        return "<script>alert('Se actualizo satisfactoruamente la administracíon!')</script>";
    }

    
}