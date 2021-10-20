<?php

if (isset($_POST["array"])) {
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $Metodos =  new ConsultaContribuyentes();
    $datos = $_POST['array'];
    $nombre_admin = $datos['nom_admin'];
    $nombre_admin_cort = $datos['nom_admin_cort'];
    $Metodos->Crear_Admin($nombre_admin,$nombre_admin_cort);
    if ($Metodos != true) {
        return "<script> alert('Fallo la creacion de la subadministración.') </script>";
    }
    else {
        return "<script> alert('Se creo la Subadministracíon satisfactoriamente.') </script>";
    }
       
}


?>