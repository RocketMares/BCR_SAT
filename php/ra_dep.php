<?php

if (isset($_POST["array"])) {
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $Metodos =  new ConsultaContribuyentes();
    $datos = $_POST['array'];
    $id_admin = $datos['admin'];
    $id_sub_admin = $datos['sub'];
    $nombre_dep = $datos["nombre_dep"];

    $Metodos->Crear_dep($id_admin,$id_sub_admin,$nombre_dep);
    if ($Metodos != true) {
        echo "Fallo la creacion del departamento ".$nombre_dep."";
    }
    else {
        echo "Se creo el departamento ".$nombre_dep."";
    }
       
}


?>