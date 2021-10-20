<?php

if (isset($_POST["no_empleado"]) && isset($_POST["Password"]) && isset($_POST["Password_C"])) {
    $no_empleado = $_POST["no_empleado"];
    $pass = $_POST["Password"];
    $pass2 = $_POST["Password_C"];
    include_once 'MetodosUsuarios.php';

    
    $usuarios = new MetodosUsuarios();

    if($datos = $usuarios->Consulta_user_exist($no_empleado) == true){
        if ($pass == $pass2 && strlen($pass) >= 6) {           
            $pass_enc = $usuarios->Encriptado_Passwd($pass);
            $actualizar = $usuarios->CambiarContrasenaUser($no_empleado, $pass_enc);
            header("location:../login.php");
        }else if (strlen($pass) < 6 ) {
            header("location:../Olvido_pass.php?error=1"); 
        }else if ($pass != $pass2){
            header("location:../olvido_pass.php?error=2");  
        }
    }else {
        header("location:http:../olvido_pass.php?error=3");
    }
    
}

?>