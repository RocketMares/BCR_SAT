<?php

if (isset($_POST["array"])) {
    include_once 'MetodosUsuarios.php';
    $usuarios = new MetodosUsuarios();
    $datos = json_decode($_POST["array"]);
    $resultado = $usuarios->Valida_registro_user($datos);
    echo $resultado;
}else if(isset($_POST["objeto_user"])){
    include_once 'MetodosUsuarios.php';
    $usuarios = new MetodosUsuarios();
    $datos = json_decode($_POST["objeto_user"]);
    $resultado = $usuarios->Actualizar_usuario($datos);
    echo $resultado;
}
