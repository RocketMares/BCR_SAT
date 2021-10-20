<?php

if (isset($_POST["id_usuario"])) {
    include_once 'MetodosUsuarios.php';
    $usuarios = new MetodosUsuarios();
    $id_usuario = $_POST["id_usuario"];
    $datos_user = $usuarios->Consulta_Datos_Usere($id_usuario);
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($datos_user);
}
