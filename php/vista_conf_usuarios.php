<?php

class Conf_Users
{
    public function Vista_General()
    {
        include_once 'php/sesion.php';
        include_once 'php/MetodosUsuarios.php';
        include_once 'php/vistas_contribuyentes.php';
        $users = new MetodosUsuarios();
        $paginacion = new VistasContrib();

        $resultados_por_pagina = 50;
        $universo_datos = $users->Consulta_usuarios_pag_num($_SESSION["ses_id_admin_con"]);
        $paginas = $universo_datos / $resultados_por_pagina;
        $valor_redondeado = ceil($paginas);

        $pagina = $_GET['usuarios'];
        $nombre_pag =  "usuarios_boveda";
        $nombre_get = "usuarios";
        $datos_paginacion =
            array(
                'pag_anterior' => $pagina - 1,
                'pag_siguiente' => $pagina + 1,
                'ultima_pag' => $valor_redondeado,
                'primera_pag' => 1,
                'ultimas_pag' => $valor_redondeado - 10,
                'pagina_actual' => $pagina,
                'nombre_pag' => $nombre_pag,
                'nombre_get' => $nombre_get
            );


        $paginacion->paginacion_adaptable($datos_paginacion);

        if ($pagina == 1) {
            $inicio = 1;
            $valores = $users->Consulta_usuarios_pag($_SESSION["ses_id_admin_con"], $inicio);
        } else {
            $pagina = $pagina - $datos_paginacion['primera_pag'];
            $inicio = ($resultados_por_pagina * $pagina) + 1;
            $valores = $users->Consulta_usuarios_pag($_SESSION["ses_id_admin_con"], $inicio);
        }

        $html[] = null;

        $inactivos = "class='bg-dark text-white'";
        for ($i = 0; $i < count($valores); $i++) {
            if ($valores[$i]["estatus"] == "ACTIVO") {

                $html[$i] = "<tr>
                                <th>" . $valores[$i]["seq"] . "</th>
                                <td>" . $valores[$i]["rfc_corto"] . "</td>
                                <td>" . $valores[$i]["no_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_perfil"] . "</td>
                                <td>" . $valores[$i]["nombre_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_sub_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_depto"] . "</td>
                                <td>" . $valores[$i]["estatus"] . " <br> Responsiva: <br>" . $valores[$i]["responsiva"] . "</td>
                                <td>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Editar Usauario' onclick='ConsultarDatosUser(" . $valores[$i]["id_empleado"] . ")'><i class='fas fa-user-edit'></i></a>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title=' Responsiva' href='php/Resp.php?id_usuario=" . $valores[$i]["id_empleado"] . "' target='_blank'><i class='fas fa-envelope-open-text'></i></a>
                                </td>
                            </tr>";
            } else {
                $html[$i] = "<tr $inactivos>
                                <th>" . $valores[$i]["seq"] . "</th>
                                <td>" . $valores[$i]["rfc_corto"] . "</td>
                                <td>" . $valores[$i]["no_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_perfil"] . "</td>
                                <td>" . $valores[$i]["nombre_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_sub_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_depto"] . "</td>
                                <td>" . $valores[$i]["estatus"] . " <br> Responsiva: <br>" . $valores[$i]["responsiva"] . "</td>
                                <td>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Editar Usauario' onclick='ConsultarDatosUser(" . $valores[$i]["id_empleado"] . ")'><i class='fas fa-user-edit'></i></a>
                                    
                            </tr>";
            }
        }

        echo "
                <div class='table-responsive'>
                <table class='table table-striped table-sm'>
                <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>RFC Corto</th>
                        <th scope='col'>No. Empleado</th>
                        <th scope='col'>Nombre</th>
                        <th scope='col' >Perfil</th>
                        <th scope='col'>Administración</th>
                        <th scope='col'>Sub administración</th>
                        <th scope='col'>Departamento</th>
                        <th scope='col'>estatus</th>
                        <th scope='col'>Editar</th>
                    </tr>
                </thead>
                <tbody>";
        for ($i = 0; $i < count($html); $i++) {
            echo "$html[$i]";
        }

        echo "</tbody>
            </table>
            
            </div>";
    }

    public function vista_por_nombre()
    {
        include_once 'php/sesion.php';
        include_once 'php/MetodosUsuarios.php';
        include_once 'php/vistas_contribuyentes.php';
        $users = new MetodosUsuarios();
        $paginacion = new VistasContrib();
        $resultados_por_pagina = 50;
        $nombre = $_COOKIE["nombre"];
        $universo_datos = $users->Consulta_usuarios_nombre_pag_num($_SESSION["ses_id_admin_con"], $nombre);
        $paginas = $universo_datos / $resultados_por_pagina;
        $valor_redondeado = ceil($paginas);

        $pagina = $_GET['por_nombre'];
        $nombre_pag =  "usuarios_boveda";
        $nombre_get = "por_nombre";
        $datos_paginacion =
            array(
                'pag_anterior' => $pagina - 1,
                'pag_siguiente' => $pagina + 1,
                'ultima_pag' => $valor_redondeado,
                'primera_pag' => 1,
                'ultimas_pag' => $valor_redondeado - 10,
                'pagina_actual' => $pagina,
                'nombre_pag' => $nombre_pag,
                'nombre_get' => $nombre_get
            );


        $paginacion->paginacion_adaptable($datos_paginacion);

        if ($pagina == 1) {
            $inicio = 1;
            $valores = $users->Consulta_usuarios_nombre_pag($_SESSION["ses_id_admin_con"], $nombre, $inicio);
        } else {
            $pagina = $pagina - $datos_paginacion['primera_pag'];
            $inicio = ($resultados_por_pagina * $pagina) + 1;
            $valores = $users->Consulta_usuarios_nombre_pag($_SESSION["ses_id_admin_con"], $nombre, $inicio);
        }

        $html[] = null;
        if(isset($valores)){
            $inactivos = "class='bg-dark text-white'";
            for ($i = 0; $i < count($valores); $i++) {
                if ($valores[$i]["estatus"] == "ACTIVO") {
    
                    $html[$i] = "<tr>
                                    <th>" . $valores[$i]["seq"] . "</th>
                                    <td>" . $valores[$i]["rfc_corto"] . "</td>
                                    <td>" . $valores[$i]["no_empleado"] . "</td>
                                    <td>" . $valores[$i]["nombre_empleado"] . "</td>
                                    <td>" . $valores[$i]["nombre_perfil"] . "</td>
                                    <td>" . $valores[$i]["nombre_admin"] . "</td>
                                    <td>" . $valores[$i]["nombre_sub_admin"] . "</td>
                                    <td>" . $valores[$i]["nombre_depto"] . "</td>
                                    <td>" . $valores[$i]["estatus"] . " <br> Responsiva: <br>" . $valores[$i]["responsiva"] . "</td>
                                    <td>
                                        <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Editar Usauario' onclick='ConsultarDatosUser(" . $valores[$i]["id_empleado"] . ")'><i class='fas fa-user-edit'></i></a>
                                        <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Imprimir Responsiva' href='php/Resp.php?id_usuario=" . $valores[$i]["id_empleado"] . "' target='_blank'><i class='fas fa-envelope-open-text'></i></a>
                                    </td>
                                </tr>";
                } else {
                    $html[$i] = "<tr $inactivos>
                                    <th>" . $valores[$i]["seq"] . "</th>
                                    <td>" . $valores[$i]["rfc_corto"] . "</td>
                                    <td>" . $valores[$i]["no_empleado"] . "</td>
                                    <td>" . $valores[$i]["nombre_empleado"] . "</td>
                                    <td>" . $valores[$i]["nombre_perfil"] . "</td>
                                    <td>" . $valores[$i]["nombre_admin"] . "</td>
                                    <td>" . $valores[$i]["nombre_sub_admin"] . "</td>
                                    <td>" . $valores[$i]["nombre_depto"] . "</td>
                                    <td>" . $valores[$i]["estatus"] . " <br> Responsiva: <br>" . $valores[$i]["responsiva"] . "</td>
                                    <td>
                                        <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Editar Usauario' onclick='ConsultarDatosUser(" . $valores[$i]["id_empleado"] . ")'><i class='fas fa-user-edit'></i></a>
                                        
                                </tr>";
                }
            }
        } else{
            echo"No hay resultados";
        }
       

        echo "
                <div class='table-responsive'>
                <table class='table table-striped table-sm'>
                <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>RFC Corto</th>
                        <th scope='col'>No. Empleado</th>
                        <th scope='col'>Nombre</th>
                        <th scope='col' >Perfil</th>
                        <th scope='col'>Administración</th>
                        <th scope='col'>Sub administración</th>
                        <th scope='col'>Departamento</th>
                        <th scope='col'>estatus</th>
                        <th scope='col'>Editar</th>
                    </tr>
                </thead>
                <tbody>";
        for ($i = 0; $i < count($html); $i++) {
            echo "$html[$i]";
        }

        echo "</tbody>
            </table>
            
            </div>";
    }


    public function vista_por_nombre_sub()
    {
        include_once 'php/sesion.php';
        include_once 'php/MetodosUsuarios.php';
        include_once 'php/vistas_contribuyentes.php';
        $users = new MetodosUsuarios();
        $paginacion = new VistasContrib();
        $resultados_por_pagina = 50;
        $nombre = $_COOKIE["nombre"];
        $sub = $_COOKIE["subadmin"];
        $universo_datos = $users->Consulta_usuarios_nombre_sub_pag_num($_SESSION["ses_id_admin_con"], $sub, $nombre);
        $paginas = $universo_datos / $resultados_por_pagina;
        $valor_redondeado = ceil($paginas);

        $pagina = $_GET['por_nomb_sub'];
        $nombre_pag =  "usuarios_boveda";
        $nombre_get = "por_nomb_sub";
        $datos_paginacion =
            array(
                'pag_anterior' => $pagina - 1,
                'pag_siguiente' => $pagina + 1,
                'ultima_pag' => $valor_redondeado,
                'primera_pag' => 1,
                'ultimas_pag' => $valor_redondeado - 10,
                'pagina_actual' => $pagina,
                'nombre_pag' => $nombre_pag,
                'nombre_get' => $nombre_get
            );

        $paginacion->paginacion_adaptable($datos_paginacion);

        if ($pagina == 1) {
            $inicio = 1;
            $valores = $users->Consulta_usuarios_nombre_sub_pag($_SESSION["ses_id_admin_con"], $sub, $nombre, $inicio);
        } else {
            $pagina = $pagina - $datos_paginacion['primera_pag'];
            $inicio = ($resultados_por_pagina * $pagina) + 1;
            $valores = $users->Consulta_usuarios_nombre_sub_pag($_SESSION["ses_id_admin_con"], $sub, $nombre, $inicio);
        }

        $html[] = null;

        $inactivos = "class='bg-dark text-white'";
        for ($i = 0; $i < count($valores); $i++) {
            if ($valores[$i]["estatus"] == "ACTIVO") {

                $html[$i] = "<tr>
                                <th>" . $valores[$i]["seq"] . "</th>
                                <td>" . $valores[$i]["rfc_corto"] . "</td>
                                <td>" . $valores[$i]["no_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_perfil"] . "</td>
                                <td>" . $valores[$i]["nombre_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_sub_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_depto"] . "</td>
                                <td>" . $valores[$i]["estatus"] . " <br> Responsiva: <br>" . $valores[$i]["responsiva"] . "</td>
                                <td>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Editar Usauario' onclick='ConsultarDatosUser(" . $valores[$i]["id_empleado"] . ")'><i class='fas fa-user-edit'></i></a>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Imprimir Responsiva' href='php/Resp.php?id_usuario=" . $valores[$i]["id_empleado"] . "' target='_blank'><i class='fas fa-envelope-open-text'></i></a>
                                </td>
                            </tr>";
            } else {
                $html[$i] = "<tr $inactivos>
                                <th>" . $valores[$i]["seq"] . "</th>
                                <td>" . $valores[$i]["rfc_corto"] . "</td>
                                <td>" . $valores[$i]["no_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_perfil"] . "</td>
                                <td>" . $valores[$i]["nombre_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_sub_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_depto"] . "</td>
                                <td>" . $valores[$i]["estatus"] . " <br> Responsiva: <br>" . $valores[$i]["responsiva"] . "</td>
                                <td>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Editar Usauario' onclick='ConsultarDatosUser(" . $valores[$i]["id_empleado"] . ")'><i class='fas fa-user-edit'></i></a>
                                    
                            </tr>";
            }
        }

        echo "<div class='table-responsive'>
              <table class='table table-striped table-sm'>
                <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>RFC Corto</th>
                        <th scope='col'>No. Empleado</th>
                        <th scope='col'>Nombre</th>
                        <th scope='col' >Perfil</th>
                        <th scope='col'>Administración</th>
                        <th scope='col'>Sub administración</th>
                        <th scope='col'>Departamento</th>
                        <th scope='col'>estatus</th>
                        <th scope='col'>Editar</th>
                    </tr>
                </thead>
                <tbody>";
        for ($i = 0; $i < count($html); $i++) {
            echo "$html[$i]";
        }

        echo "</tbody>
            </table>
            </div>";
    }


    public function vista_por_nombre_sub_dep()
    {
        include_once 'php/sesion.php';
        include_once 'php/MetodosUsuarios.php';
        include_once 'php/vistas_contribuyentes.php';
        $users = new MetodosUsuarios();
        $paginacion = new VistasContrib();
        $resultados_por_pagina = 50;
        $nombre = $_COOKIE["nombre"];
        $sub = $_COOKIE["subadmin"];
        $dep = $_COOKIE["deptos"];
        $universo_datos = $users->Consulta_usuarios_nombre_sub_dep_pag_num($_SESSION["ses_id_admin_con"], $sub, $dep, $nombre);
        $paginas = $universo_datos / $resultados_por_pagina;
        $valor_redondeado = ceil($paginas);

        $pagina = $_GET['por_nomb_sub_dep'];
        $nombre_pag =  "usuarios_boveda";
        $nombre_get = "por_nomb_sub_dep";
        $datos_paginacion =
            array(
                'pag_anterior' => $pagina - 1,
                'pag_siguiente' => $pagina + 1,
                'ultima_pag' => $valor_redondeado,
                'primera_pag' => 1,
                'ultimas_pag' => $valor_redondeado - 10,
                'pagina_actual' => $pagina,
                'nombre_pag' => $nombre_pag,
                'nombre_get' => $nombre_get
            );

        $paginacion->paginacion_adaptable($datos_paginacion);

        if ($pagina == 1) {
            $inicio = 1;
            $valores = $users->Consulta_usuarios_nombre_sub_dep_pag($_SESSION["ses_id_admin"], $sub, $dep, $nombre, $inicio);
        } else {
            $pagina = $pagina - $datos_paginacion['primera_pag'];
            $inicio = ($resultados_por_pagina * $pagina) + 1;
            $valores = $users->Consulta_usuarios_nombre_sub_dep_pag($_SESSION["ses_id_admin"], $sub, $dep, $nombre, $inicio);
        }

        $html[] = null;

        $inactivos = "class='bg-dark text-white'";
        for ($i = 0; $i < count($valores); $i++) {
            if ($valores[$i]["estatus"] == "ACTIVO") {

                $html[$i] = "<tr>
                                <th>" . $valores[$i]["seq"] . "</th>
                                <td>" . $valores[$i]["rfc_corto"] . "</td>
                                <td>" . $valores[$i]["no_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_perfil"] . "</td>
                                <td>" . $valores[$i]["nombre_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_sub_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_depto"] . "</td>
                                <td>" . $valores[$i]["estatus"] . " <br> Responsiva: <br>" . $valores[$i]["responsiva"] . "</td>
                                <td>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Editar Usauario' onclick='ConsultarDatosUser(" . $valores[$i]["id_empleado"] . ")'><i class='fas fa-user-edit'></i></a>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Imprimir Responsiva' href='php/Resp.php?id_usuario=" . $valores[$i]["id_empleado"] . "' target='_blank'><i class='fas fa-envelope-open-text'></i></a>
                                </td>
                            </tr>";
            } else {
                $html[$i] = "<tr $inactivos>
                                <th>" . $valores[$i]["seq"] . "</th>
                                <td>" . $valores[$i]["rfc_corto"] . "</td>
                                <td>" . $valores[$i]["no_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_perfil"] . "</td>
                                <td>" . $valores[$i]["nombre_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_sub_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_depto"] . "</td>
                                <td>" . $valores[$i]["estatus"] . " <br> Responsiva: <br>" . $valores[$i]["responsiva"] . "</td>
                                <td>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Editar Usauario' onclick='ConsultarDatosUser(" . $valores[$i]["id_empleado"] . ")'><i class='fas fa-user-edit'></i></a>
                                    
                            </tr>";
            }
        }

        echo "<div class='table-responsive'>
              <table class='table table-striped table-sm'>
                <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>RFC Corto</th>
                        <th scope='col'>No. Empleado</th>
                        <th scope='col'>Nombre</th>
                        <th scope='col' >Perfil</th>
                        <th scope='col'>Administración</th>
                        <th scope='col'>Sub administración</th>
                        <th scope='col'>Departamento</th>
                        <th scope='col'>Estatus</th>
                        <th scope='col'>Editar</th>
                    </tr>
                </thead>
                <tbody>";
        for ($i = 0; $i < count($html); $i++) {
            echo "$html[$i]";
        }

        echo "</tbody>
            </table>
            </div>";
    }

    public function vista_por_nombre_sub_dep_per()
    {
        include_once 'php/sesion.php';
        include_once 'php/MetodosUsuarios.php';
        include_once 'php/vistas_contribuyentes.php';
        $users = new MetodosUsuarios();
        $paginacion = new VistasContrib();
        $resultados_por_pagina = 50;
        $nombre = $_COOKIE["nombre"];
        $sub = $_COOKIE["subadmin"];
        $dep = $_COOKIE["deptos"];
        $perfil = $_COOKIE["perfil"];
        $universo_datos = $users->Consulta_usuarios_nombre_sub_dep_per_pag_num($_SESSION["ses_id_admin"], $sub, $dep, $perfil, $nombre);
        $paginas = $universo_datos / $resultados_por_pagina;
        $valor_redondeado = ceil($paginas);

        $pagina = $_GET['por_nomb_sub_dep_per'];
        $nombre_pag =  "usuarios_boveda";
        $nombre_get = "por_nomb_sub_dep_per";
        $datos_paginacion =
            array(
                'pag_anterior' => $pagina - 1,
                'pag_siguiente' => $pagina + 1,
                'ultima_pag' => $valor_redondeado,
                'primera_pag' => 1,
                'ultimas_pag' => $valor_redondeado - 10,
                'pagina_actual' => $pagina,
                'nombre_pag' => $nombre_pag,
                'nombre_get' => $nombre_get
            );

        $paginacion->paginacion_adaptable($datos_paginacion);

        if ($pagina == 1) {
            $inicio = 1;
            $valores = $users->Consulta_usuarios_nombre_sub_dep_per_pag($_SESSION["ses_id_admin"], $sub, $dep, $perfil, $nombre, $inicio);
        } else {
            $pagina = $pagina - $datos_paginacion['primera_pag'];
            $inicio = ($resultados_por_pagina * $pagina) + 1;
            $valores = $users->Consulta_usuarios_nombre_sub_dep_per_pag($_SESSION["ses_id_admin"], $sub, $dep, $perfil, $nombre, $inicio);
        }

        $html[] = null;

        $inactivos = "class='bg-dark text-white'";
        for ($i = 0; $i < count($valores); $i++) {
            if ($valores[$i]["estatus"] == "ACTIVO") {

                $html[$i] = "<tr>
                                <th>" . $valores[$i]["seq"] . "</th>
                                <td>" . $valores[$i]["rfc_corto"] . "</td>
                                <td>" . $valores[$i]["no_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_perfil"] . "</td>
                                <td>" . $valores[$i]["nombre_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_sub_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_depto"] . "</td>
                                <td>" . $valores[$i]["estatus"] . " <br> Responsiva: <br>" . $valores[$i]["responsiva"] . "</td>
                                <td>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Editar Usauario' onclick='ConsultarDatosUser(" . $valores[$i]["id_empleado"] . ")'><i class='fas fa-user-edit'></i></a>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Imprimir Responsiva' href='php/Resp.php?id_usuario=" . $valores[$i]["id_empleado"] . "' target='_blank'><i class='fas fa-envelope-open-text'></i></a>
                                </td>
                            </tr>";
            } else {
                $html[$i] = "<tr $inactivos>
                                <th>" . $valores[$i]["seq"] . "</th>
                                <td>" . $valores[$i]["rfc_corto"] . "</td>
                                <td>" . $valores[$i]["no_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_perfil"] . "</td>
                                <td>" . $valores[$i]["nombre_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_sub_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_depto"] . "</td>
                                <td>" . $valores[$i]["estatus"] . " <br> Responsiva: <br>" . $valores[$i]["responsiva"] . "</td>
                                <td>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Editar Usauario' onclick='ConsultarDatosUser(" . $valores[$i]["id_empleado"] . ")'><i class='fas fa-user-edit'></i></a>
                                    
                            </tr>";
            }
        }

        echo "<div class='table-responsive'>
              <table class='table table-striped table-sm'>
                    <thead>
                        <tr>
                            <th scope='col'>#</th>
                            <th scope='col'>RFC Corto</th>
                            <th scope='col'>No. Empleado</th>
                            <th scope='col'>Nombre</th>
                            <th scope='col' >Perfil</th>
                            <th scope='col'>Administración</th>
                            <th scope='col'>Sub administración</th>
                            <th scope='col'>Departamento</th>
                            <th scope='col'>Estatus</th>
                            <th scope='col'>Editar</th>
                        </tr>
                    </thead>
                <tbody>";
        for ($i = 0; $i < count($html); $i++) {
            echo "$html[$i]";
        }

        echo "</tbody>
            </table>
            </div>";
    }

    public function vista_por_sub()
    {
        include_once 'php/sesion.php';
        include_once 'php/MetodosUsuarios.php';
        include_once 'php/vistas_contribuyentes.php';
        $users = new MetodosUsuarios();
        $paginacion = new VistasContrib();
        $resultados_por_pagina = 50;
        $sub = $_COOKIE["subadmin"];
        $universo_datos = $users->Consulta_usuarios_sub_pag_num($sub);
        $paginas = $universo_datos / $resultados_por_pagina;
        $valor_redondeado = ceil($paginas);

        $pagina = $_GET['por_sub'];
        $nombre_pag =  "usuarios_boveda";
        $nombre_get = "por_sub";
        $datos_paginacion =
            array(
                'pag_anterior' => $pagina - 1,
                'pag_siguiente' => $pagina + 1,
                'ultima_pag' => $valor_redondeado,
                'primera_pag' => 1,
                'ultimas_pag' => $valor_redondeado - 10,
                'pagina_actual' => $pagina,
                'nombre_pag' => $nombre_pag,
                'nombre_get' => $nombre_get
            );

        $paginacion->paginacion_adaptable($datos_paginacion);

        if ($pagina == 1) {
            $inicio = 1;
            $valores = $users->Consulta_usuarios_sub_pag($sub, $inicio);
        } else {
            $pagina = $pagina - $datos_paginacion['primera_pag'];
            $inicio = ($resultados_por_pagina * $pagina) + 1;
            $valores = $users->Consulta_usuarios_sub_pag($sub, $inicio);
        }

        $html[] = null;

        $inactivos = "class='bg-dark text-white'";
        for ($i = 0; $i < count($valores); $i++) {
            if ($valores[$i]["estatus"] == "ACTIVO") {

                $html[$i] = "<tr>
                                <th>" . $valores[$i]["seq"] . "</th>
                                <td>" . $valores[$i]["rfc_corto"] . "</td>
                                <td>" . $valores[$i]["no_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_perfil"] . "</td>
                                <td>" . $valores[$i]["nombre_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_sub_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_depto"] . "</td>
                                <td>" . $valores[$i]["estatus"] . " <br> Responsiva: <br>" . $valores[$i]["responsiva"] . "</td>
                                <td>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Editar Usauario' onclick='ConsultarDatosUser(" . $valores[$i]["id_empleado"] . ")'><i class='fas fa-user-edit'></i></a>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Imprimir Responsiva' href='php/Resp.php?id_usuario=" . $valores[$i]["id_empleado"] . "' target='_blank'><i class='fas fa-envelope-open-text'></i></a>
                                </td>
                            </tr>";
            } else {
                $html[$i] = "<tr $inactivos>
                                <th>" . $valores[$i]["seq"] . "</th>
                                <td>" . $valores[$i]["rfc_corto"] . "</td>
                                <td>" . $valores[$i]["no_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_perfil"] . "</td>
                                <td>" . $valores[$i]["nombre_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_sub_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_depto"] . "</td>
                                <td>" . $valores[$i]["estatus"] . " <br> Responsiva: <br>" . $valores[$i]["responsiva"] . "</td>
                                <td>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Editar Usauario' onclick='ConsultarDatosUser(" . $valores[$i]["id_empleado"] . ")'><i class='fas fa-user-edit'></i></a>
                                    
                            </tr>";
            }
        }

        echo "<table class='table'>
                <thead class='thead-dark'>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>RFC Corto</th>
                        <th scope='col'>No. Empleado</th>
                        <th scope='col'>Nombre</th>
                        <th scope='col' >Perfil</th>
                        <th scope='col'>Administración</th>
                        <th scope='col'>Sub administración</th>
                        <th scope='col'>Departamento</th>
                        <th scope='col'>Estatus</th>
                        <th scope='col'>Editar</th>
                    </tr>
                </thead>
                <tbody>";
        for ($i = 0; $i < count($html); $i++) {
            echo "$html[$i]";
        }

        echo "</tbody>
            </table>";
    }



    public function vista_por_sub_dep()
    {
        include_once 'php/sesion.php';
        include_once 'php/MetodosUsuarios.php';
        include_once 'php/vistas_contribuyentes.php';
        $users = new MetodosUsuarios();
        $paginacion = new VistasContrib();
        $resultados_por_pagina = 50;
        $dep = $_COOKIE["deptos"];
        $sub = $_COOKIE["subadmin"];
        $universo_datos = $users->Consulta_usuarios_sub_dep_pag_num($sub, $dep);
        $paginas = $universo_datos / $resultados_por_pagina;
        $valor_redondeado = ceil($paginas);

        $pagina = $_GET['por_sub_dep'];
        $nombre_pag =  "usuarios_boveda";
        $nombre_get = "por_sub_dep";
        $datos_paginacion =
            array(
                'pag_anterior' => $pagina - 1,
                'pag_siguiente' => $pagina + 1,
                'ultima_pag' => $valor_redondeado,
                'primera_pag' => 1,
                'ultimas_pag' => $valor_redondeado - 10,
                'pagina_actual' => $pagina,
                'nombre_pag' => $nombre_pag,
                'nombre_get' => $nombre_get
            );

        $paginacion->paginacion_adaptable($datos_paginacion);

        if ($pagina == 1) {
            $inicio = 1;
            $valores = $users->Consulta_usuarios_sub_dep_pag($sub, $dep, $inicio);
        } else {
            $pagina = $pagina - $datos_paginacion['primera_pag'];
            $inicio = ($resultados_por_pagina * $pagina) + 1;
            $valores = $users->Consulta_usuarios_sub_dep_pag($sub, $dep, $inicio);
        }

        $html[] = null;

        $inactivos = "class='bg-dark text-white'";
        for ($i = 0; $i < count($valores); $i++) {
            if ($valores[$i]["estatus"] == "ACTIVO") {

                $html[$i] = "<tr>
                                <th>" . $valores[$i]["seq"] . "</th>
                                <td>" . $valores[$i]["rfc_corto"] . "</td>
                                <td>" . $valores[$i]["no_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_perfil"] . "</td>
                                <td>" . $valores[$i]["nombre_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_sub_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_depto"] . "</td>
                                <td>" . $valores[$i]["estatus"] . " <br> Responsiva: <br>" . $valores[$i]["responsiva"] . "</td>
                                <td>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Editar Usauario' onclick='ConsultarDatosUser(" . $valores[$i]["id_empleado"] . ")'><i class='fas fa-user-edit'></i></a>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Imprimir Responsiva' href='php/Resp.php?id_usuario=" . $valores[$i]["id_empleado"] . "' target='_blank'><i class='fas fa-envelope-open-text'></i></a>
                                </td>
                            </tr>";
            } else {
                $html[$i] = "<tr $inactivos>
                                <th>" . $valores[$i]["seq"] . "</th>
                                <td>" . $valores[$i]["rfc_corto"] . "</td>
                                <td>" . $valores[$i]["no_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_perfil"] . "</td>
                                <td>" . $valores[$i]["nombre_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_sub_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_depto"] . "</td>
                                <td>" . $valores[$i]["estatus"] . " <br> Responsiva: <br>" . $valores[$i]["responsiva"] . "</td>
                                <td>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Editar Usauario' onclick='ConsultarDatosUser(" . $valores[$i]["id_empleado"] . ")'><i class='fas fa-user-edit'></i></a>
                                    
                            </tr>";
            }
        }

        echo "<div class='table-responsive'>
                <table class='table table-striped table-sm'>
                  <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>RFC Corto</th>
                        <th scope='col'>No. Empleado</th>
                        <th scope='col'>Nombre</th>
                        <th scope='col' >Perfil</th>
                        <th scope='col'>Administración</th>
                        <th scope='col'>Sub administración</th>
                        <th scope='col'>Departamento</th>
                        <th scope='col'>Estatus</th>
                        <th scope='col'>Editar</th>
                    </tr>
                </thead>
                <tbody>";
        for ($i = 0; $i < count($html); $i++) {
            echo "$html[$i]";
        }

        echo "</tbody>
            </table>
            </div>";
    }


    public function vista_por_perfil()
    {
        include_once 'php/sesion.php';
        include_once 'php/MetodosUsuarios.php';
        include_once 'php/vistas_contribuyentes.php';
        $users = new MetodosUsuarios();
        $paginacion = new VistasContrib();
        $resultados_por_pagina = 50;
        $perfil = $_COOKIE["perfil"];
        $universo_datos = $users->Consulta_usuarios_perfil_pag_num($perfil);
        $paginas = $universo_datos / $resultados_por_pagina;
        $valor_redondeado = ceil($paginas);

        $pagina = $_GET['por_perfil'];
        $nombre_pag =  "usuarios_boveda";
        $nombre_get = "por_perfil";
        $datos_paginacion =
            array(
                'pag_anterior' => $pagina - 1,
                'pag_siguiente' => $pagina + 1,
                'ultima_pag' => $valor_redondeado,
                'primera_pag' => 1,
                'ultimas_pag' => $valor_redondeado - 10,
                'pagina_actual' => $pagina,
                'nombre_pag' => $nombre_pag,
                'nombre_get' => $nombre_get
            );

        $paginacion->paginacion_adaptable($datos_paginacion);

        if ($pagina == 1) {
            $inicio = 1;
            $valores = $users->Consulta_usuarios_perfil_pag($perfil, $inicio);
        } else {
             $pagina = $pagina - $datos_paginacion['primera_pag'];
             $inicio = ($resultados_por_pagina * $pagina) + 1;
             $valores = $users->Consulta_usuarios_perfil_pag($perfil, $inicio);
        }

        $html[] = null;
        $conteo = ($valores == null) ? 0:count($valores);
        $inactivos = "class='bg-dark text-white'";
        for ($i = 0; $i < $conteo; $i++) {
            if ($valores[$i]["estatus"] == "ACTIVO") {

                $html[$i] = "<tr>
                                <th>" . $valores[$i]["seq"] . "</th>
                                <td>" . $valores[$i]["rfc_corto"] . "</td>
                                <td>" . $valores[$i]["no_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_perfil"] . "</td>
                                <td>" . $valores[$i]["nombre_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_sub_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_depto"] . "</td>
                                <td>" . $valores[$i]["estatus"] . " <br> Responsiva: <br>" . $valores[$i]["responsiva"] . "</td>
                                <td>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Editar Usauario' onclick='ConsultarDatosUser(" . $valores[$i]["id_empleado"] . ")'><i class='fas fa-user-edit'></i></a>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Imprimir Responsiva' href='php/Resp.php?id_usuario=" . $valores[$i]["id_empleado"] . "' target='_blank'><i class='fas fa-envelope-open-text'></i></a>
                                </td>
                            </tr>";
            } else {
                $html[$i] = "<tr $inactivos>
                                <th>" . $valores[$i]["seq"] . "</th>
                                <td>" . $valores[$i]["rfc_corto"] . "</td>
                                <td>" . $valores[$i]["no_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_perfil"] . "</td>
                                <td>" . $valores[$i]["nombre_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_sub_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_depto"] . "</td>
                                <td>" . $valores[$i]["estatus"] . " <br> Responsiva: <br>" . $valores[$i]["responsiva"] . "</td>
                                <td>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Editar Usauario' onclick='ConsultarDatosUser(" . $valores[$i]["id_empleado"] . ")'><i class='fas fa-user-edit'></i></a>
                                    
                            </tr>";
            }
        }

        echo "<div class='table-responsive'>
                <table class='table table-striped table-sm'>
                  <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>RFC Corto</th>
                        <th scope='col'>No. Empleado</th>
                        <th scope='col'>Nombre</th>
                        <th scope='col' >Perfil</th>
                        <th scope='col'>Administración</th>
                        <th scope='col'>Sub administración</th>
                        <th scope='col'>Departamento</th>
                        <th scope='col'>Estatus</th>
                        <th scope='col'>Editar</th>
                    </tr>
                </thead>
                <tbody>";
        for ($i = 0; $i < count($html); $i++) {
            echo "$html[$i]";
        }

        echo "</tbody>
            </table>
            </div>";
    }

    public function vista_por_perfil_SUB_DEP()
    {
        include_once 'php/sesion.php';
        include_once 'php/MetodosUsuarios.php';
        include_once 'php/vistas_contribuyentes.php';
        $users = new MetodosUsuarios();
        $paginacion = new VistasContrib();
        $resultados_por_pagina = 50;
        $perfil = $_COOKIE["perfil"];
        $sub = $_COOKIE["subadmin"];
        $dep = $_COOKIE["deptos"];
        $universo_datos = $users->Consulta_por_perfil_sub_dep_pag_num($perfil, $sub, $dep);
        $paginas = $universo_datos / $resultados_por_pagina;
        $valor_redondeado = ceil($paginas);

        $pagina = $_GET['por_perfil_sub_dep'];
        $nombre_pag =  "usuarios_boveda";
        $nombre_get = "por_perfil_sub_dep";
        $datos_paginacion =
            array(
                'pag_anterior' => $pagina - 1,
                'pag_siguiente' => $pagina + 1,
                'ultima_pag' => $valor_redondeado,
                'primera_pag' => 1,
                'ultimas_pag' => $valor_redondeado - 10,
                'pagina_actual' => $pagina,
                'nombre_pag' => $nombre_pag,
                'nombre_get' => $nombre_get
            );

        $paginacion->paginacion_adaptable($datos_paginacion);

        if ($pagina == 1) {
            $inicio = 1;
            $valores = $users->Consulta_por_perfil_sub_dep_pag_num($_SESSION["ses_id_admin"], $perfil, $sub, $dep, $inicio);
        } else {
            $pagina = $pagina - $datos_paginacion['primera_pag'];
            $inicio = ($resultados_por_pagina * $pagina) + 1;
            $valores = $users->Consulta_por_perfil_sub_dep_pag_num($_SESSION["ses_id_admin"], $perfil, $sub, $dep, $inicio);
        }

        $html[] = null;

        $inactivos = "class='bg-dark text-white'";
        for ($i = 0; $i < count($valores); $i++) {
            if ($valores[$i]["estatus"] == "ACTIVO") {

                $html[$i] = "<tr>
                                <th>" . $valores[$i]["seq"] . "</th>
                                <td>" . $valores[$i]["rfc_corto"] . "</td>
                                <td>" . $valores[$i]["no_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_perfil"] . "</td>
                                <td>" . $valores[$i]["nombre_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_sub_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_depto"] . "</td>
                                <td>" . $valores[$i]["estatus"] . " <br> Responsiva: <br>" . $valores[$i]["responsiva"] . "</td>
                                <td>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Editar Usauario' onclick='ConsultarDatosUser(" . $valores[$i]["id_empleado"] . ")'><i class='fas fa-user-edit'></i></a>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Imprimir Responsiva' href='php/Resp.php?id_usuario=" . $valores[$i]["id_empleado"] . "' target='_blank'><i class='fas fa-envelope-open-text'></i></a>
                                </td>
                            </tr>";
            } else {
                $html[$i] = "<tr $inactivos>
                                <th>" . $valores[$i]["seq"] . "</th>
                                <td>" . $valores[$i]["rfc_corto"] . "</td>
                                <td>" . $valores[$i]["no_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_empleado"] . "</td>
                                <td>" . $valores[$i]["nombre_perfil"] . "</td>
                                <td>" . $valores[$i]["nombre_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_sub_admin"] . "</td>
                                <td>" . $valores[$i]["nombre_depto"] . "</td>
                                <td>" . $valores[$i]["estatus"] . " <br> Responsiva: <br>" . $valores[$i]["responsiva"] . "</td>
                                <td>
                                    <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='Editar Usauario' onclick='ConsultarDatosUser(" . $valores[$i]["id_empleado"] . ")'><i class='fas fa-user-edit'></i></a>
                                    
                            </tr>";
            }
        }

        echo "<div class='table-responsive'>
                <table class='table table-striped table-sm'>
                <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>RFC Corto</th>
                        <th scope='col'>No. Empleado</th>
                        <th scope='col'>Nombre</th>
                        <th scope='col' >Perfil</th>
                        <th scope='col'>Administración</th>
                        <th scope='col'>Sub administración</th>
                        <th scope='col'>Departamento</th>
                        <th scope='col'>Estatus</th>
                        <th scope='col'>Editar</th>
                    </tr>
                </thead>
                <tbody>";
        for ($i = 0; $i < count($html); $i++) {
            echo "$html[$i]";
        }

        echo "</tbody>
            </table>
            </div>";
    }
}
