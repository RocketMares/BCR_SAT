<?php

if (isset($_POST["Password"]) && isset($_POST["Password_C"])) {
    include_once 'sesion.php';
    $pass = $_POST["Password"];
    $pass2 = $_POST["Password_C"];

    if ($pass == $pass2 && strlen($pass) >= 6) {

        include_once 'MetodosUsuarios.php';
        $usuarios = new MetodosUsuarios();

        $pass_enc = $usuarios->Encriptado_Passwd($pass);
        $actualizar = $usuarios->CambiarContrasenaUser_ses($_SESSION["ses_id_usuario"], $pass_enc);
                    $id_user = $_SESSION["ses_id_usuario_"];
                    $user = $_SESSION["ses_rfc_corto_"];
					$correo = $_SESSION["ses_correo_"];
					$nombre = $_SESSION["ses_nombre_"];
                    $id_perfil = $_SESSION["ses_id_perfil_"];
                    $id_admin = $_SESSION["ses_id_admin_"];
                    $tiempo = $_SESSION["tiempo"];
                    session_destroy();

                    session_start();
					$_SESSION["ses_id_usuario_"] = $id_user;
                    $_SESSION["ses_rfc_corto_"] = $user;
                    $_SESSION["ses_correo_"] = $correo;
                    $_SESSION["ses_nombre_"] = $nombre;
                    $_SESSION["ses_id_perfil_"] =$id_perfil;
                    $_SESSION["ses_id_admin_"] = $id_admin;
                    $_SESSION["tiempo"] = $tiempo;		
                    
        header("location:../index.php");
    
    }else if (strlen($pass) < 6 ) {
        header("location:../Cambio_pass.php?error=1"); 
    }else if ($pass != $pass2){
        header("location:../Cambio_pass.php?error=2");  
    }
}

?>