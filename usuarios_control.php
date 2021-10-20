<?php

include_once 'php/sesion.php';

?>
<!DOCTYPE html>
<html>


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="img\LOGO11.ico">
    <title>BCR SAT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/css/all.css">
    <script defer src="js/js/all.js"></script>
    <script src="js//jquery-3.1.1.js"></script>

    <script type="text/javascript" src="js/jquery-1.6.min.js"></script>
    <script type="text/javascript" src="js/jquery.easyui.min.js"></script>

    <script type='text/javascript' src='js/libs/bootstrap-datepicker.min.js'></script>
    <script src='js/libs/locales/bootstrap-datepicker.es.js' charset='UTF-8'></script>
    <link rel="stylesheet" href="css/libs/bootstrap-datepicker3.min.css">
    <script type="text/javascript" src="js/renueva.js"></script>

</head>

<body>
    <?php
    require_once 'php/menu_dinamico.php';
    $menu = new Menu();
    $menu->Crear_menu();
    ?>

    <div id="main">

        <!-- contenedor general -->
        <div class="container-fluid" style="padding-top: 3rem !important;">
            <?php
            ?>
            <!-- Segundo elemento -->
            <div class="container-fluid" id="main">
                <div class="container text-center py-2">
                    <h1 class="display-4 mb-2">Administración de Usuarios</h1>
                </div>
                <?php
                include_once 'php/ConsultaContribuyentes.php';
                include_once 'php/MetodosUsuarios.php';
                $consulta = new ConsultaContribuyentes();
                $mu = new MetodosUsuarios();
                $rows_sub = $consulta->Consulta_Sub($_SESSION["ses_id_admin_con"]);
                $rows_administracion = $consulta->Consulta_Local();
                ?>

                <div class="form-inline justify-content-center mb-2">
                    <input type="text" class="form-control mr-sm-2 letras" id="nombre_b" name="nombre" placeholder="Nombre" required onkeyup="javascript:this.value=this.value.toUpperCase();">

                    <select class="custom-select" id="num_admin" name="num_admin">
                        <option value='0'>Seleccionar Administración</option>
                        <?php
                        for ($i = 0; $i < count($rows_administracion); $i++) {
                            if ($rows_administracion[$i]["estatus"] == "A") {
                                echo "<option value='" . $rows_administracion[$i]["id_admin"] . "'>" . $rows_administracion[$i]["nombre_admin"] . "</option>";
                            }
                        }
                        ?>
                    </select>
                    <select class="custom-select mr-sm-2 col-sm-3" id="id_sub_admin_b" name="id_sub_admin_b">
                        <option value='0'>Seleccionar subadministración</option>

                    </select>
                    <select class="custom-select mr-sm-2" id="deptos_f" name="deptos_f">
                        <option value='0'>Seleccionar departamento</option>

                    </select>
                    <select class="custom-select mr-sm-2" id="perfil_b" name="perfil_b">
                        <option value='0'>Seleccionar perfil</option>
                        <?php

                        $rows_perfil = $mu->Consulta_Perfiles();
                        for ($i = 0; $i < count($rows_perfil); $i++) {
                            if ($rows_perfil[$i]["estatus"] == "A") {
                                echo "<option value='" .  $rows_perfil[$i]["id_perfil"] . "'>" .  $rows_perfil[$i]["nombre_perfil"] . "</option>";
                            }
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-primary mr-sm-2" onclick="filtros_users()">Buscar</button>


                </div>


                <div id="tabla_uuarios" class="container-fluid">
                    <div class='card'>
                        <div class='card-header'>
                            <div class="d-flex bd-highlight">
                                <div class="mr-auto p-2 bd-highlight">
                                    <p class="lead">Listado de usuarios</p>
                                </div>
                                <div class="p-2 bd-highlight">
                                    <button type="submit" id="agregar_user" class="btn btn-primary"><i class="fas fa-user-plus"></i></button>
                                </div>
                            </div>

                        </div>
                        <div class='card-body'>
                            <?php
                            switch (isset($_GET)) {
                                case isset($_GET["usuarios"]):
                                    include_once 'php/vista_conf_usuarios.php';
                                    $vista_conf = new Conf_Users();
                                    $vista_conf->Vista_General();
                                    break;

                                case isset($_GET["por_nombre"]):
                                    include_once 'php/vista_conf_usuarios.php';
                                    $vista_conf = new Conf_Users();
                                    $vista_conf->vista_por_nombre();
                                    break;

                                case isset($_GET["por_nomb_sub"]):
                                    include_once 'php/vista_conf_usuarios.php';
                                    $vista_conf = new Conf_Users();
                                    $vista_conf->vista_por_nombre_sub();
                                    break;

                                case isset($_GET["por_nomb_sub_dep"]):
                                    include_once 'php/vista_conf_usuarios.php';
                                    $vista_conf = new Conf_Users();
                                    $vista_conf->vista_por_nombre_sub_dep();
                                    break;

                                case isset($_GET["por_nomb_sub_dep_per"]):
                                    include_once 'php/vista_conf_usuarios.php';
                                    $vista_conf = new Conf_Users();
                                    $vista_conf->vista_por_nombre_sub_dep_per();
                                    break;

                                case isset($_GET["por_sub"]):
                                    include_once 'php/vista_conf_usuarios.php';
                                    $vista_conf = new Conf_Users();
                                    $vista_conf->vista_por_sub();
                                    break;

                                case isset($_GET["por_sub_dep"]):
                                    include_once 'php/vista_conf_usuarios.php';
                                    $vista_conf = new Conf_Users();
                                    $vista_conf->vista_por_sub_dep();
                                    break;

                                case isset($_GET["por_perfil"]):
                                    include_once 'php/vista_conf_usuarios.php';
                                    $vista_conf = new Conf_Users();
                                    $vista_conf->vista_por_perfil();
                                    break;

                                default:
                                    echo "<script>
                                            location.href='usuarios_control.php?usuarios=1';
                                          </script>";
                                    break;
                            }



                            ?>
                        </div>
                    </div>

                </div>


            </div>


            <!-- Inicio Modals -->
            <?php

            $rows_local = $consulta->Consulta_Local();
            ?>
            <div class="modal fade" id="Modal_form_editar" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Datos del usuario.</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Contenido del modal aqui-->
                            <div class="form-row">
                                <div class="form-group col-md-6">

                                    <label for="RFC_CORTO_A">RFC Corto:<samp class="text-danger">*</samp></label>
                                    <input type="text" class="form-control" id="RFC_CORTO_A" name="RFC_CORTO_A" placeholder="XXXX4548" maxlength="8" min="8" required onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="NO_EMPLEADO_A">No. de Empleado:<samp class="text-danger">*</samp></label>
                                    <input type="text" class="form-control" id="NO_EMPLEADO_A" name="NO_EMPLEADO_A" placeholder="123265" maxlength="6">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="NOMBRE_A">Nombre:<samp class="text-danger">*</samp></label>
                                    <input type=" text" class="form-control letras" id="NOMBRE_A" name="NOMBRE_A" placeholder="Juan Pérez" required onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="CORREO_A">Correo:<samp class="text-danger">*</samp></label>
                                    <input type="email" class="form-control" id="CORREO_A" name="CORREO_A" placeholder="xxxx@dssat.sat.gob.mx">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="input-group-prepend">
                                        <label for="id_admin_A">Administración:<samp class="text-danger">*</samp></label>
                                    </div>
                                    <select class="custom-select" id="id_admin_A" name="id_admin_A">
                                        <option value='0'>Seleccionar Local</option>
                                        <?php
                                        for ($i = 0; $i < count($rows_local); $i++) {
                                            if ($rows_local[$i]["estatus"] == "A") {
                                                echo "<option value='" . $rows_local[$i]["id_admin"] . "'>" . $rows_local[$i]["nombre_admin"] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="id_sub_admin_A">Subadministración:<samp class="text-danger">*</samp></label>
                                    <select class="custom-select" id="id_sub_admin_A" name="id_sub_admin_A">
                                        <option value='0'>Seleccionar Subadministración</option>
                                        <?php
                                        $rows_sub = $mu->Consulta_Subadmin($_SESSION["ses_id_admin_con"]);
                                        for ($i = 0; $i < count($rows_sub); $i++) {
                                            echo "<option value='" .  $rows_sub[$i]["id_sub_admin"] . "'>" .  $rows_sub[$i]["nombre_sub_admin"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">

                                <div class="form-group col-md-6">
                                    <label for="ID_DEPA_A">Departamento:<samp class="text-danger">*</samp></label>
                                    <select class="custom-select" id="ID_DEPA_A" name="ID_DEPA_A">
                                        <option value='0'>Seleccionar Departamento</option>
                                        <?php
                                        $rows_depto = $mu->Consulta_Depto($_SESSION["ses_id_admin_con"]);
                                        for ($i = 0; $i < count($rows_depto); $i++) {
                                            echo "<option value='" .  $rows_depto[$i]["id_depto"] . "'>" .  $rows_depto[$i]["nombre_depto"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="RFC_JEFE_A">Jefe Directo:<samp class="text-danger">*</samp></label>
                                    <select class="custom-select" id="RFC_JEFE_A" name="RFC_JEFE_A">
                                        <option value='0'>Seleccionar Jefe directo</option>
                                        <?php
                                        $rows_jefes = $mu->Consulta_Cat_Jefes($_SESSION["ses_id_admin_con"]);
                                        for ($i = 0; $i < count($rows_jefes); $i++) {
                                            if ($rows_jefes[$i]["estatus"] == "A") {
                                                echo "<option value='" .  $rows_jefes[$i]["id_empleado"] . "'>" .  $rows_jefes[$i]["nombre_empleado"] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="estatus_A">Estatus de actividad:<samp class="text-danger">*</samp></label>
                                    <select class="custom-select" id="estatus_A" name="estatus_A">
                                        <option value='0'>Seleccionar estatus</option>
                                        <option value='A'>ACTIVO</option>
                                        <option value='N'>NO ACTIVO</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="input-group-prepend">
                                        <label for="ID_PERFIL_A">Perfil:<samp class="text-danger">*</samp></label>
                                    </div>
                                    <select class="custom-select" id="ID_PERFIL_A" name="ID_PERFIL_A">
                                        <option value='0'>Seleccionar Perfil</option>
                                        <?php
                                        for ($i = 0; $i < count($rows_perfil); $i++) {
                                            if ($rows_perfil[$i]["estatus"] == "A") {
                                                echo "<option value='" .  $rows_perfil[$i]["id_perfil"] . "'>" .  $rows_perfil[$i]["nombre_perfil"] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="input-group-prepend">
                                        <label for="ID_PUESTO_A">Puesto:<samp class="text-danger">*</samp></label>
                                    </div>
                                    <select class="custom-select" id="ID_PUESTO_A" name="ID_PUESTO_A">
                                        <option value='0'>Seleccionar Puesto</option>
                                        <?php
                                        $rows_puestos = $mu->Consulta_Puestos();
                                        for ($i = 0; $i < count($rows_puestos); $i++) {
                                            echo "<option value='" .  $rows_puestos[$i]["id_puesto"] . "'>" .  $rows_puestos[$i]["nombre_puesto"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="estatus_A">Estatus de responsiva:</label>
                                    <select class="custom-select" id="estatus_responsiva" name="estatus_responsiva">
                                        <option value='0'>Seleccionar estatus</option>
                                        <option value='0'>PENDIENTE</option>
                                        <option value='1'>FRIMADA</option>
                                    </select>
                                </div>
                            </div>
                            <button type="button" id="btn_RU_A" class="btn btn-block btn-primary">Actualizar usuario.</button>
                            <!-- Contenido del modal aqui-->
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="Modal_form_registrar" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar nuevo usuario.</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Contenido del modal aqui-->


                        <div class="form-row">
                            <div class="form-group col-md-6">

                                <label for="RFC_CORTO">RFC Corto:<samp class="text-danger">*</samp></label>
                                <input type="text" class="form-control" id="RFC_CORTO" name="RFC_CORTO" placeholder="XXXX4548" maxlength="8" min="8" required onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="NO_EMPLEADO">No. de Empleado:<samp class="text-danger">*</samp></label>
                                <input type="text" class="form-control" id="NO_EMPLEADO" name="NO_EMPLEADO" placeholder="123265" maxlength="6">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="NOMBRE">Nombre:<samp class="text-danger">*</samp></label>
                                <input type=" text" class="form-control letras" id="NOMBRE" name="NOMBRE" placeholder="Juan Pérez" required onkeyup="javascript:this.value=this.value.toUpperCase();">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="CORREO">Correo:<samp class="text-danger">*</samp></label>
                                <input type="email" class="form-control" id="CORREO" name="CORREO" placeholder="xxxx@dssat.sat.gob.mx">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <div class="input-group-prepend">
                                    <label for="id_admin">Administración:<samp class="text-danger">*</samp></label>
                                </div>
                                <select class="custom-select" id="id_admin" name="id_admin">
                                    <option value='0'>Seleccionar Local</option>
                                    <?php
                                    for ($i = 0; $i < count($rows_local); $i++) {
                                        if ($rows_local[$i]["estatus"] == "A") {
                                            echo "<option value='" . $rows_local[$i]["id_admin"] . "'>" . $rows_local[$i]["nombre_admin"] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="id_sub_admin">Subadministración:<samp class="text-danger">*</samp></label>
                                <select class="custom-select" id="id_sub_admin" name="id_sub_admin">
                                    <option value='0'>Seleccionar Subadministración</option>
                                    <?php
                                    $rows_sub = $mu->Consulta_Subadmin($_SESSION["ses_id_admin"]);
                                    for ($i = 0; $i < count($rows_sub); $i++) {
                                        echo "<option value='" .  $rows_sub[$i]["id_sub_admin"] . "'>" .  $rows_sub[$i]["nombre_sub_admin"] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="ID_DEPA">Departamento:<samp class="text-danger">*</samp></label>
                                <select class="custom-select" id="ID_DEPA" name="ID_DEPA">
                                    <option value='0'>Seleccionar Departamento</option>
                                    <?php
                                    $rows_depto = $mu->Consulta_Depto($_SESSION["ses_id_admin"]);
                                    for ($i = 0; $i < count($rows_depto); $i++) {
                                        echo "<option value='" .  $rows_depto[$i]["id_depto"] . "'>" .  $rows_depto[$i]["nombre_depto"] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="RFC_JEFE">Jefe Directo:<samp class="text-danger">*</samp></label>
                                <select class="custom-select" id="RFC_JEFE" name="RFC_JEFE">
                                    <option value='0'>Seleccionar Jefe directo</option>
                                    <?php
                                    $rows_jefes = $mu->Consulta_Cat_Jefes($_SESSION["ses_id_admin_con"]);
                                    for ($i = 0; $i < count($rows_jefes); $i++) {
                                        if ($rows_jefes[$i]["estatus"] == "A") {
                                            echo "<option value='" .  $rows_jefes[$i]["id_empleado"] . "'>" .  $rows_jefes[$i]["nombre_empleado"] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="estatus">estatus de actividad:<samp class="text-danger">*</samp></label>
                                <select class="custom-select" id="estatus" name="estatus">
                                    <option value='0'>Seleccionar estatus</option>
                                    <option value='A'>ACTIVO</option>
                                    <option value='N'>NO ACTIVO</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="input-group-prepend">
                                    <label for="ID_PERFIL">Perfil:<samp class="text-danger">*</samp></label>
                                </div>
                                <select class="custom-select" id="ID_PERFIL" name="ID_PERFIL">
                                    <option value='0'>Seleccionar Perfil</option>
                                    <?php
                                    for ($i = 0; $i < count($rows_perfil); $i++) {
                                        if ($rows_perfil[$i]["estatus"] == "A") {
                                            echo "<option value='" .  $rows_perfil[$i]["id_perfil"] . "'>" .  $rows_perfil[$i]["nombre_perfil"] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <div class="input-group-prepend">
                                    <label for="ID_PUESTO">Puesto:<samp class="text-danger">*</samp></label>
                                </div>
                                <select class="custom-select" id="ID_PUESTO" name="ID_PUESTO">
                                    <option value='0'>Seleccionar Puesto</option>
                                    <?php
                                    $rows_puestos = $mu->Consulta_Puestos();
                                    for ($i = 0; $i < count($rows_puestos); $i++) {
                                        echo "<option value='" .  $rows_puestos[$i]["id_puesto"] . "'>" .  $rows_puestos[$i]["nombre_puesto"] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <button type="button" id="btn_RU" class="btn btn-block btn-primary" onclick="valida_formulario_registro_user()">Registrar usuario.</button>
                        <!-- Contenido del modal aqui-->
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modals -->

   
    <?php

    $menu->Footer();

    if (isset($_GET["caso"])) {
        if ($_GET["caso"] == 1) {
            echo "<scirpt>
                    alert(\"El usuario se registro exitosamente, recuerde que la contraseña por defecto es: 123456.\")
                    </scirpt>";
        } else if ($_GET["caso"] == 2) {
            echo "<scirpt>
                    alert(\"El nombre de usuario ya existe vinculado a otro RFC corto.\")
                    </scirpt>";
        } else if ($_GET["caso"] == 3) {
            echo "<scirpt>
                    alert(\"El RFC Corto ya existe\")
                    </scirpt>";
        }
    }
    ?>
    <script type="text/javascript" src="js/scripts_user.js"></script>

</html>