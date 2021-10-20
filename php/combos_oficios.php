<?php

if (isset($_POST['admin'])) {
    $id_admin = $_POST['admin'];
    include_once "MetodosUsuarios.php";
    $metodos = new MetodosUsuarios();
    $sub = $metodos->Consulta_Subadmin($id_admin);
    for ($i=0; $i < count($sub) ; $i++) { 
        echo" <option value='".$sub[$i]['id_sub_admin']."'>".$sub[$i]['nombre_sub_admin']."</option>";
    }

}
if (isset($_POST['datos'])) {
    include_once "sesion.php";
    $datos = $_POST['datos'];
    $admin = $_SESSION['ses_id_admin_con'];
    $sub = $datos['sub'];
    include_once "MetodosUsuarios.php";
    $metodos = new MetodosUsuarios();
    $sub = $metodos->Consulta_Depto_oficio($admin,$sub);
    for ($i=0; $i < count($sub) ; $i++) { 
        echo" <option value='".$sub[$i]['id_depto']."'>".$sub[$i]['nombre_depto']."</option>";
    }

}