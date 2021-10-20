<?php

//$URL_ = "99.85.24.8:8282";
//$URL_ = "localhost:8282";
$URL_ = "99.85.26.227:8383";


	session_start();//valida si esta activa la seci?n, sino, no le deja seguir viendo la data y lo regresa a loginDEj.php
	if (isset($_SESSION["ses_id_usuario_con"]) 
	&& isset($_SESSION["ses_rfc_corto_con"]) 
	&& isset($_SESSION["ses_correo_con"]) 
	&& isset($_SESSION["ses_nombre_con"]) 
	&& isset($_SESSION["ses_id_perfil_con"]) 
	&& isset($_SESSION['tiempo']) 
	&& isset($_SESSION["ses_id_admin_con"]) 
	|| isset($_SESSION["ses_jefe_directo_con"]) 
	|| isset($_SESSION["estatus_ent_con"])) {
		# code...
		if($_SESSION["ses_id_perfil_con"] != 1){
			$inactivo = 840;
			$vida_session = time() - $_SESSION['tiempo'];
			if ($vida_session > $inactivo) {
				require_once 'MetodosUsuarios.php';
				$user = new MetodosUsuarios;
				$registro=$user->Registro_fin_sesion();
				//Removemos sesi�n.
				session_unset();
				//Destruimos sesi�n.
				session_destroy(); 
				//Redirigimos pagina.
				header("Location: http://$URL_/BCR_SAT/login.php?error=8");

				die();
			}

			$_SESSION['tiempo'] = time();
		}
	} else {
		require_once 'MetodosUsuarios.php';
		$user = new MetodosUsuarios;
		$registro=$user->Registro_fin_sesion();
		header("location:http://$URL_/BCR_SAT/login.php?error=7");
		exit();
	}





?>

   
