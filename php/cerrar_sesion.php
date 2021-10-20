<?php
include_once 'sesion.php';
if(session_destroy()){
    require_once 'MetodosUsuarios.php';
    $users = new MetodosUsuarios();
    $registro= $users->Registro_fin_sesion();
    header('location:../login.php');

}

?>