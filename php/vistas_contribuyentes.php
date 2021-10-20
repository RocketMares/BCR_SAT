<?php

class VistasContrib
{
    public function Consulta_Local()
    {
        include_once("php/conexion.php");
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI?N
        //SE MANDA A LLAMAR LA CONEXI?N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "SELECT * FROM Administracion WHERE estatus = 'A' ORDER BY nombre_admin ASC";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI?N
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = $rows;
            }
            sqlsrv_close($con);

            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }
    public function Crear_VistaContrib($id_empleado)
    {

        include_once 'php/ConsultaContribuyentes.php';
        $consulta = new ConsultaContribuyentes();
        $datos = $consulta->ConsultaContribuyentes_Asignados($id_empleado);
        $consecutivo = 1;
        if ($datos != null) {
            for ($i = 0; $i < count($datos); $i++) {
                $fecha_vig = ($datos[$i]["fecha_vigencia"] != null) ? $datos[$i]["fecha_vigencia"]->format('d/m/Y') : null;
                if ($datos[$i]["noti"]->format('d/m/Y') == '01/01/1900') {
                    $noti = 'SIN NOTIFICAR';
                } else {
                    $noti = $datos[$i]["noti"]->format('d/m/Y');
                }


                $html[$i] = "<tr>
                          <th scope='row'>$consecutivo</th>
                          <td><a class='' style='' href='#' onclick='BuscarDatosContrib(" . $datos[$i]["id_contribuyente"] . ")'>" . $datos[$i]["rfc"] . "</a></td>
                          <td>" . $datos[$i]["razon_social"] . "</td>
                          <td>" . $datos[$i]["fecha_programada"]->format('d/m/Y') . "</td>
                          <td>" . $datos[$i]["prioridad"] . "</td>
                          <td>$fecha_vig</td>
                          <td>" . $noti . "</td>
                          <td>" . $datos[$i]["estatus"] . "</td>
                      </tr>";
                $consecutivo++;
            }
        }
        if (isset($datos)) {
            if (count($datos) < 12) {
                $class = "class='vh-100 table-responsive'";
            }
        } else {
            $class = "class='table-responsive'";
        }



        echo "
        <div class>
        <table class='table table-sm table-striped shadow p-1 bg-white rounded'>
        <thead>
          <tr>
            <th scope='col'>#</th>
            <th scope='col'>RFC</th>
            <th scope='col'>Razón social</th>
            <th scope='col'>Fecha programada</th>
            <th scope='col'>Prioridad</th>
            <th scope='col'>Fecha vigencia</th>
            <th scope='col'>Notificacion</th>
            <th scope='col'>estatus</th>
          </tr>
        </thead>
        <tbody>
       ";
        if (isset($html)) {
            for ($i = 0; $i < count($html); $i++) {
                echo $html[$i];
            }
        } else {
            echo "Sin contribuyentes asignados por el momento.";
        }
        echo "</tbody>
        </table>
        </div>
        ";
    }


    public function Listado_de_analistas_asig($id_empleado)
    {
        include_once 'php/ConsultaContribuyentes.php';
        $consulta = new ConsultaContribuyentes();
        $datos = $consulta->Analistas_asignados($id_empleado);
        $consecutivo = 1;
        if ($datos != null) {
            for ($i = 0; $i < count($datos); $i++) {
                if ($datos[$i]["nombre_perfil"] == "Analista") {
                    $html[$i] = "<tr>
                          <th scope='row'>$consecutivo</th>
                          <td><a class='' style='' href='#' onclick='BuscarContribuyentes(" . $datos[$i]["id_empleado"] . ")'>" . $datos[$i]["nombre_empleado"] . "</a></td>
                          <td>" . $datos[$i]["nombre_puesto"] . "</td>
                          <td>" . $datos[$i]["nombre_perfil"] . "</td>
                          <td>" . $datos[$i]["operativos"] . "</td>
                          <td>" . $datos[$i]["entrevistas"] . "</td>
                      </tr>";
                    $consecutivo++;
                } else {
                    $html[$i] = "<tr>
                          <th scope='row'>$consecutivo</th>
                          <td><a class='' style='' href='#' onclick='BuscarContribuyentesA(" . $datos[$i]["id_empleado"] . ")'>" . $datos[$i]["nombre_empleado"] . "</a></td>
                          <td>" . $datos[$i]["nombre_puesto"] . "</td>
                          <td>" . $datos[$i]["nombre_perfil"] . "</td>
                          <td>" . $datos[$i]["operativos"] . "</td>
                          <td>" . $datos[$i]["entrevistas"] . "</td>
                      </tr>";
                    $consecutivo++;
                }
            }
        }

        echo "
        <div class='vh-100 table-responsive'>
        <table class='table table-sm table-striped shadow p-1 bg-white rounded'>
        <thead>
          <tr>
            <th scope='col'>#</th>
            <th scope='col'>Nombre del empleado</th>
            <th scope='col'>Puesto</th>
            <th scope='col'>Perfil</th>
            <th scope='col'>No. Operativos</th>
            <th scope='col'>No. Entrevistas</th>
          </tr>
        </thead>
        <tbody>";
        if (isset($html)) {
            for ($i = 0; $i < count($html); $i++) {
                echo $html[$i];
            }
        } else {
            echo "Sin analistas a su cargo por el momento.";
        }

        echo "</tbody>
        </table>
        </div>
        ";
    }

    public function Listado_de_operativos_asig($id_empleado)
    {
        include_once 'php/ConsultaContribuyentes.php';
        $consulta = new ConsultaContribuyentes();
        $datos = $consulta->Operativos_asignados($id_empleado);
        $consecutivo = 1;
        if ($datos != null) {
            for ($i = 0; $i < count($datos); $i++) {
                $html[$i] = "<tr>
                          <th scope='row'>$consecutivo</th>
                          <td><a class='' style='' href='#' onclick='BuscarContribuyentes(" . $datos[$i]["id_empleado"] . ")'>" . $datos[$i]["nombre_empleado"] . "</a></td>
                          <td>" . $datos[$i]["nombre_puesto"] . "</td>
                          <td>" . $datos[$i]["nombre_perfil"] . "</td>
                          <td>" . $datos[$i]["entrevistas"] . "</td>
                      </tr>";
                $consecutivo++;
            }
        }
        echo "
        <div class='vh-100 table-responsive'>
        <table class='table table-sm table-striped shadow p-1 bg-white rounded'>
        <thead>
          <tr>
            <th scope='col'>#</th>
            <th scope='col'>Nombre del empleado</th>
            <th scope='col'>Puesto</th>
            <th scope='col'>Perfil</th>
            <th scope='col'>No. Entrevistas</th>
          </tr>
        </thead>
        <tbody>";
        if (isset($html)) {
            for ($i = 0; $i < count($html); $i++) {
                echo $html[$i];
            }
        } else {
            echo "Sin analistas a su cargo por el momento.";
        }

        echo "</tbody>
        </table>
        </div>
        ";
    }


    public function Listado_de_jefes_asig($id_empleado)
    {
        include_once 'php/ConsultaContribuyentes.php';
        $consulta = new ConsultaContribuyentes();
        $datos = $consulta->Jefes_asignados($id_empleado);
        $consecutivo = 1;
        if ($datos != null) {
            for ($i = 0; $i < count($datos); $i++) {
                if ($datos[$i]["nombre_perfil"] == "Analista") {
                    $html[$i] = "<tr>
                          <th scope='row'>$consecutivo</th>
                          <td><a class='' style='' href='#' onclick='BuscarContribuyentes(" . $datos[$i]["id_empleado"] . ")'>" . $datos[$i]["nombre_empleado"] . "</a></td>
                          <td>" . $datos[$i]["nombre_puesto"] . "</td>
                          <td>" . $datos[$i]["nombre_perfil"] . "</td>
                          <td>" . $datos[$i]["analistas"] . "</td>
                          <td>" . $datos[$i]["operativos"] . "</td>
                          <td>" . $datos[$i]["entrevistas"] . "</td>
                      </tr>";
                    $consecutivo++;
                } else {
                    $html[$i] = "<tr>
                          <th scope='row'>$consecutivo</th>
                          <td><a class='' style='' href='#' onclick='Buscar_analistas(" . $datos[$i]["id_empleado"] . ")'>" . $datos[$i]["nombre_empleado"] . "</a></td>
                          <td>" . $datos[$i]["nombre_puesto"] . "</td>
                          <td>" . $datos[$i]["nombre_perfil"] . "</td>
                          <td>" . $datos[$i]["analistas"] . "</td>
                          <td>" . $datos[$i]["operativos"] . "</td>
                          <td>" . $datos[$i]["entrevistas"] . "</td>
                      </tr>";
                    $consecutivo++;
                }
            }
        }
        echo "
        <div class='vh-100 table-responsive'>
        <table class='table table-sm table-striped shadow p-1 bg-white rounded'>
        <thead>
          <tr>
            <th scope='col'>#</th>
            <th scope='col'>Nombre del empleado</th>
            <th scope='col'>Puesto</th>
            <th scope='col'>Perfil</th>
            <th scope='col'>Asignados directos</th>
            <th scope='col'>No. Operativos</th>
            <th scope='col'>No. Entrevistas</th>
          </tr>
        </thead>
        <tbody>";
        if (isset($html)) {
            for ($i = 0; $i < count($html); $i++) {
                echo $html[$i];
            }
        } else {
            echo "Sin analistas a su cargo por el momento.";
        }

        echo "</tbody>
        </table>
        </div>
        ";
    }

    public function Listado_de_sub($id_admin)
    {
        include_once 'php/ConsultaContribuyentes.php';
        $consulta = new ConsultaContribuyentes();
        $datos = $consulta->Listado_subs($id_admin);
        $consecutivo = 1;
        if ($datos != null) {
            for ($i = 0; $i < count($datos); $i++) {
                $html[$i] = "<tr>
                        <th scope='row'>$consecutivo</th>
                        <td><a class='' style='' href='#' onclick='Buscar_jefes(" . $datos[$i]["id_empleado"] . ")'>" . $datos[$i]["nombre_empleado"] . "</a></td>
                        <td>" . $datos[$i]["nombre_puesto"] . "</td>
                        <td>" . $datos[$i]["nombre_perfil"] . "</td>
                        <td>" . $datos[$i]["jefe_depto"] . "</td>
                        <td>" . $datos[$i]["Cordinador"] . "</td>
                        <td>" . $datos[$i]["Analistas"] . "</td>
                        <td>" . $datos[$i]["entrevistas"] . "</td>
                      </tr>";
                $consecutivo++;
            }
        }
        echo "
        <div class='vh-100 table-responsive'>
        <table class='table table-sm table-striped shadow p-1 bg-white rounded'>
        <thead>
          <tr>
            <th scope='col'>#</th>
            <th scope='col'>Nombre del empleado</th>
            <th scope='col'>Puesto</th>
            <th scope='col'>Perfil</th>
            <th scope='col'>No. Jefes</th>
            <th scope='col'>No. Analistas</th>
            <th scope='col'>No. Operativos</th>
            <th scope='col'>No. Entrevistas</th>
          </tr>
        </thead>
        <tbody>";
        if (isset($html)) {
            for ($i = 0; $i < count($html); $i++) {
                echo $html[$i];
            }
        } else {
            echo "Sin analistas a su cargo por el momento.";
        }

        echo "</tbody>
        </table>
        </div>
        ";
    }


    public function Listado_entrevistas_contrib($id_cont)
    {
        include_once "php/ConsultaContribuyentes.php";
        $consulta = new ConsultaContribuyentes();
        $datos = $consulta->Consulta_Entrevistas_Cont($id_cont);
        $consecutivo = 1;
        if ($datos != null) {
            for ($i = 0; $i < count($datos); $i++) {
                $html[$i] = "<tr>
                          <th scope='row'>$consecutivo</th>
                          <td><a class='' style='' href='#' onclick='DetalleEntrevista(" . $datos[$i]["id_entrevista"] . ")'>" . $datos[$i]["id_entrevista"] . "</a></td>
                          <td>" . $datos[$i]["estatus_notif"] . "</td>
                          <td>" . $datos[$i]["estatus_regula"] . "</td>
                          <td>" . $datos[$i]["estatus_desvirtuo"] . "</td>
                          <td>" . $datos[$i]["nombre_empleado"] . "</td>
                          <td>" . $datos[$i]["tiempo_regs"] . "</td>
                          <td>" . $datos[$i]["estatus_ent"] . "</td>
                      </tr>";
                $consecutivo++;
            }
            $clases = (count($html) > 3) ? "pagos overflow-auto" : "table-responsive";
        } else {
            $clases = "table-responsive";
        }

        echo "
        <ul>
          <li class='h2'>
            <p>Entrevistas registradas al contribuyente.</p>
          </li>
        </ul>
        <div class='py-1 table-responsive $clases'>
        <table class='table table-sm table-striped shadow p-1 bg-white rounded'>
        <thead>
          <tr>
            <th scope='col'>#</th>
            <th scope='col'>ID. Ent.</th>
            <th scope='col'>estatus Notificación</th>
            <th scope='col'>estatus Regularizado</th>
            <th scope='col'>estatus Desvirtuo</th>
            <th scope='col'>Nombre Analista</th>
            <th scope='col'>Periodo actual</th>
            <th scope='col'>estatus Entrevista</th>
          </tr>
        </thead>
        <tbody>";
        if (isset($html)) {
            for ($i = 0; $i < count($html); $i++) {
                echo $html[$i];
            }
        } else {
            echo "<tr class='text-center'>
                  <td colspan='7' >
                    Sin entrevistas registradas por el momento.
                  </td>
              </tr>";
        }

        echo "</tbody>
        </table>
        </div>
        ";
    }




    public function Listado_pagos_contrib($id_cont)
    {
        include_once "php/ConsultaContribuyentes.php";
        $consulta = new ConsultaContribuyentes();
        $datos = $consulta->Consulta_Pagos_Cont($id_cont);
        $consecutivo = 1;
        if ($datos != null) {
            for ($i = 0; $i < count($datos); $i++) {
                $html[$i] = "<tr>
                          <th scope='row'>$consecutivo</th>
                          <td><a class='' style='' href='#' onclick='DetalleEntrevista(" . $datos[$i]["id_entrevista"] . ")'>" . $datos[$i]["id_entrevista"] . "</a></td>
                          <td>" . $datos[$i]["periodo_pago"] . "</td>
                          <td>" . $consulta->formato_moneda($datos[$i]["monto_pago"]) . "</td>
                          <td>" . $consulta->formato_moneda($datos[$i]["pago_virtual"]) . "</td>
                          <td>" . $datos[$i]["desc_renglon"] . "</td>
                          <td>" . $datos[$i]["analista_reg"] . "</td>
                          <td>" . $datos[$i]["estatus_ent"] . "</td>
                      </tr>";
                $consecutivo++;
            }
            $clases = (count($html) > 3) ? "pagos overflow-auto" : "table-responsive";
        } else {
            $clases = "table-responsive";
        }

        echo "
        <ul>
          <li class='h2'>
            <p >Pagos registrados del contribuyente.</p>
          </li>
        </ul>
        <div class='py-1 $clases'>
        <table class='table table-sm table-striped shadow p-1 bg-white rounded'>
        <thead>
          <tr>
            <th scope='col'>#</th>
            <th scope='col'>ID. Ent.</th>
            <th scope='col'>Periodo de pago</th>
            <th scope='col'>Pago efectivo</th>
            <th scope='col'>Pago virtual</th>
            <th scope='col'>Último motivo de pago</th>
            <th scope='col'>Analista captura</th>
            <th scope='col'>estatus Entrevista</th>
          </tr>
        </thead>
        <tbody>";
        if (isset($html)) {
            for ($i = 0; $i < count($html); $i++) {
                echo $html[$i];
            }
        } else {
            echo "<tr class='text-center'>
                  <td colspan='8' >
                    Sin pagos registrados por el momento.
                  </td>
              </tr>";
        }

        echo "</tbody>
        </table>
        </div>
        ";
    }

    public function Listado_medidas_eje_contrib($id_cont)
    {
        include_once "php/ConsultaContribuyentes.php";
        $consulta = new ConsultaContribuyentes();
        $datos = $consulta->Consulta_Medidas_eje_Cont($id_cont);
        $consecutivo = 1;
        if ($datos !=  null) {
            for ($i = 0; $i < count($datos); $i++) {
                $html[$i] = "<tr>
                          <th scope='row'>$consecutivo</th>
                          <td><a class='' style='' href='#' onclick='DetalleEntrevista(" . $datos[$i]["id_entrevista"] . ")'>" . $datos[$i]["id_entrevista"] . "</a></td>
                          <td>" . $datos[$i]["tipo_medida"] . "</td>
                          <td>" . $datos[$i]["fecha_notif"]->format('d/m/Y') . "</td>
                          <td>" . $datos[$i]["periodo_aplicado"] . "</td>
                          <td>" . $datos[$i]["nombre_empleado"] . "</td>
                          <td>" . $datos[$i]["estatus_ent"] . "</td>
                      </tr>";
                $consecutivo++;
            }
            $clases = (count($html) > 3) ? "pagos overflow-auto" : "table-responsive";
        } else {
            $clases = "table-responsive";
        }
        echo "
        <ul>
          <li class='h2'>
            <p >Medidas de ejemplaridad registradas.</p>
          </li>
        </ul>
        <div class='py-1 table-responsive $clases'>
        <table class='table table-sm table-striped shadow p-1 bg-white rounded'>
        <thead>
          <tr>
            <th scope='col'>#</th>
            <th scope='col'>ID. Ent.</th>
            <th scope='col'>Tipo de medida</th>
            <th scope='col'>Fecha de Notificado</th>
            <th scope='col'>Periodo que Aplico</th>
            <th scope='col'>Usuario que aplico</th>
            <th scope='col'>estatus Entrevista</th>
          </tr>
        </thead>
        <tbody>";
        if (isset($html)) {
            for ($i = 0; $i < count($html); $i++) {
                echo $html[$i];
            }
        } else {
            echo "<tr class='text-center'>
                  <td colspan='7'>
                    Sin medidas de ejemplaridad registradas por el momento.
                  </td>
              </tr>";
        }

        echo "</tbody>
        </table>
        </div>
        ";
    }

    public function Lista_movitos_entrevista($id_ent)
    {
        include_once "php/ConsultaContribuyentes.php";
        $consulta = new ConsultaContribuyentes();
        $datos = $consulta->movitos_entrevista($id_ent);
        if ($datos != null) {
            $c = 1;
            for ($i = 0; $i < count($datos); $i++) {
                setlocale(LC_MONETARY, "en_US");
                $monto = ($datos[$i]["monto_aprox"] != null) ?  $consulta->formato_moneda($datos[$i]["monto_aprox"]) : "$0.00";
                $html[$i] = "<tr>
                            <td>
                            $c)
                            </td>
                            <td>
                                " . $datos[$i]["desc_motivo"] . "
                            </td>
                            <td>
                                " . $monto . "
                            </td>
                        </tr>";
                $c++;
            }
            $valores = array_column($datos, 'monto_aprox');
            $suma  = array_sum($valores);
            $format_suma = $consulta->formato_moneda($suma);
            $total = "<tr>
                        <td>
                        </td>
                        <td>
                            Total de adeudo:
                        </td>
                        <td>
                        $format_suma 
                        </td>
                    </tr>";
            $cuenta = count($html);
            $html[$cuenta] = $total;
            return $html;
        } else {
            $html[] = "<tr class='text-center'>
                        <td colspan='3'>
                        Sin motivos registrados por el momento.
                        </td>
                    </tr>";
            return $html;
        }
    }



    public function Listado_seguimientos_entrevista($id_entrevista)
    {
        include_once "php/ConsultaContribuyentes.php";
        $consulta = new ConsultaContribuyentes();
        $datos = $consulta->Consulta_Seguimientos_Ent($id_entrevista);
        $consecutivo = 1;
        if ($datos != null) {
            for ($i = 0; $i < count($datos); $i++) {
                $archivo = ($datos[$i]["nombre_doc"] != null) ? "<button class='btn btn-info' onclick='documento_seguimiento(" . $datos[$i]["id_seguimiento"] . ")'>Ver documento.</button>" : "Sin documento adjunto.";
                $html[$i] = "<tr>
                          <th scope='row'>$consecutivo</th>
                          <td><a class='' style='' href='#' onclick='Actualizar_seguimiento(" . $datos[$i]["id_seguimiento"] . ")'>" . $datos[$i]["id_seguimiento"] . "</a></td>
                          <td>" . $datos[$i]["fecha_seg"]->format('d/m/Y') . "</td>
                          <td class='text-justify'>" . $datos[$i]["detalle_seg"] . "</td>
                          <td>" . $archivo . "</td>
                          <td>" . $datos[$i]["analista_captura"] . "</td>
                      </tr>";
                $consecutivo++;
            }
            $clases = (count($html) > 3) ? "pagos overflow-auto" : "table-responsive";
        } else {
            $clases = "table-responsive";
        }

        echo "
        <div class='py-1 container-fluid '>
        <ul>
          <li class='h2'>
            <p>Seguimientos de entrevista.</p>
          </li>
        </ul>
        <div class='table-responsive text-center $clases'>
        <table class='table table-sm table-striped shadow p-1 bg-white rounded'>
        <thead>
          <tr>
            <th scope='col'>#</th>
            <th scope='col'>ID. Seguimiento.</th>
            <th scope='col'>Fecha</th>
            <th scope='col'>Detalle del seguimiento</th>
            <th scope='col'>Archivo asociado.</th>
            <th scope='col'>Analista captura.</th>
          </tr>
        </thead>
        <tbody>";
        if (isset($html)) {
            for ($i = 0; $i < count($html); $i++) {
                echo $html[$i];
            }
        } else {
            echo "<tr class='text-center'>
                  <td colspan='6'>
                    Sin seguimientos registrados por el momento.
                  </td>
              </tr>";
        }

        echo "</tbody>
        </table>
        </div>
        </div>
        ";
    }

    public function Listado_pagos_entrevista($id_entrevista)
    {
        include_once "php/ConsultaContribuyentes.php";
        $consulta = new ConsultaContribuyentes();
        $datos = $consulta->Consulta_Pagos_Ent($id_entrevista);
        $consecutivo = 1;
        if ($datos != null) {
            for ($i = 0; $i < count($datos); $i++) {
                $html[$i] = "<tr>
                          <th scope='row'>$consecutivo</th>
                          <td>" . $datos[$i]["Fecha_pago"]->format('d/m/Y') . "</td>
                          <td>" . $datos[$i]["periodo_pago"] . "</td>
                          <td>" . $datos[$i]["llave_transaccion"] . "</td>
                          <td>" . $datos[$i]["ejercicio_req"] . "</td>
                          <td>" . $datos[$i]["periodo_req"] . "</td>
                          <td>" . $consulta->formato_moneda($datos[$i]["monto_pago"]) . "</td>
                          <td>" . $consulta->formato_moneda($datos[$i]["pago_virtual"]) . "</td>
                          <td>" . $datos[$i]["desc_renglon"] . "</td>
                          <td>" . $datos[$i]["analista_reg"] . "</td>
                      </tr>";
                $consecutivo++;
            }
            $clases = (count($html) > 3) ? "pagos overflow-auto" : "table-responsive";
            $suma_pagos = array_sum(array_column($datos, 'monto_pago'));
            $suma_pagos_v = array_sum(array_column($datos, 'pago_virtual'));
            $formato_suma = $consulta->formato_moneda($suma_pagos);
            $formato_suma_v = $consulta->formato_moneda($suma_pagos_v);
            $suma_total = $suma_pagos + $suma_pagos_v;
            $formato_suma_t = $consulta->formato_moneda($suma_total);
        } else {
            $clases =  "table-responsive";
            $suma_pagos = 0;
            $formato_suma = $consulta->formato_moneda($suma_pagos);
            $suma_pagos_v = 0;
            $formato_suma = $consulta->formato_moneda($suma_pagos);
            $formato_suma_v = $consulta->formato_moneda($suma_pagos_v);
            $suma_total = $suma_pagos + $suma_pagos_v;
            $formato_suma_t = $consulta->formato_moneda($suma_total);
        }




        echo "
        <ul>
          <li class='h2'>
            <p>Pagos registrados del contribuyente. <br><small class='text-muted'>Total aportado: $formato_suma_t</small></p>
          </li>
        </ul>
        <div class='py-1 container-fluid $clases'>
        <table class='table table-sm table-striped shadow p-1 bg-white rounded' >
        <thead>
          <tr>
            <th scope='col'>#</th>
            <th scope='col' class='mb-2'>Fecha de Pago</th>
            <th scope='col' class='mb-2'>Periodo de pago</th>
            <th scope='col' class='mb-2'>Llave de transacción</th>
            <th scope='col' class='mb-2'>Ejercicio</th>
            <th scope='col' class='mb-2'>Periodo requerido</th>
            <th scope='col'>Pago efectivo <br><small class='text-muted'>Total efectiivo: $formato_suma</small></th>
            <th scope='col'>Pago virtual <br><small class='text-muted'>Total virtual: $formato_suma_v</small></th>
            <th scope='col' class='mb-2'>Motivo de pago</th>
            <th scope='col' class='mb-2'>Analista captura</th>
          </tr>
        </thead>
        <tbody>";
        if (isset($html)) {
            for ($i = 0; $i < count($html); $i++) {
                echo $html[$i];
            }
        } else {
            echo "<tr class='text-center'>
                  <td colspan='10' >
                    Sin pagos registrados por el momento.
                  </td>
              </tr>";
        }

        echo "</tbody>
        </table>
        </div>
        ";
    }

    public function Listado_medidas_emeplares_entrevista($id_entrevista)
    {
        include_once "php/ConsultaContribuyentes.php";
        $consulta = new ConsultaContribuyentes();
        $datos = $consulta->Consulta_Medidas_eje_Ent($id_entrevista);
        $consecutivo = 1;
        if ($datos != null) {
            for ($i = 0; $i < count($datos); $i++) {
                $html[$i] = "<tr>
                          <th scope='row'>$consecutivo</th>
                          <td><a class='' style='' href='#' onclick='Actualizar_medida(" . $datos[$i]["id_medida_eje"] . ")'>" . $datos[$i]["id_medida_eje"] . "</a></td>
                          <td>" . $datos[$i]["tipo_medida"] . "</td>
                          <td>" . $datos[$i]["fecha_notif"]->format('d/m/Y') . "</td>
                          <td>" . $datos[$i]["periodo_aplicado"] . "</td>
                          <td>" . $datos[$i]["desc_aplicacion"] . "</td>
                          <td>" . $datos[$i]["oficio_aplicado"] . "</td>
                          <td>" . $datos[$i]["nombre_empleado"] . "</td>
                      </tr>";
                $consecutivo++;
            }
        }



        echo "
        <div class='py-1 container-fluid '>
        <ul>
          <li class='h2'>
            <p>Medidas de ejemplaridad registradas.</p>
          </li>
        </ul>
        <div class='table-responsive text-center '>
        <table class='table table-sm table-striped shadow p-1 bg-white rounded'>
        <thead>
          <tr>
            <th scope='col'>#</th>
            <th scope='col'>ID. Medida.</th>
            <th scope='col'>Tipo de medida</th>
            <th scope='col'>Fecha de Notificado</th>
            <th scope='col'>Periodo que Aplico</th>
            <th scope='col'>Detalle de Aplicación</th>
            <th scope='col'>No. de Oficio</th>
            <th scope='col'>Usuario que aplico</th>
          </tr>
        </thead>
        <tbody>";
        if (isset($html)) {
            for ($i = 0; $i < count($html); $i++) {
                echo $html[$i];
            }
        } else {
            echo "<tr class='text-center'>
                  <td colspan='8'>
                    Sin medidas de ejemplaridad registradas por el momento.
                  </td>
              </tr>";
        }

        echo "</tbody>
        </table>
        </div>
        </div>
        ";
    }

    public function preparando_cat_adeudos()
    {
        include_once "ConsultaContribuyentes.php";
        $consulta = new ConsultaContribuyentes();
        $datos = $consulta->catalogo_motivos_adeudos();
        for ($i = 0; $i < count($datos); $i++) {
            $html[] = "<option value='" . $datos[$i]["id_motivo"] . "'>" . $datos[$i]["desc_motivo"] . "</option>";
        }
        return $html;
    }

    public function Actualizar_user_priviligeado($cat_adeudo, $id_ent)
    {
        echo "<div class='modal fade' id='modal_retro' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true' style='overflow-y: scroll;'>
      <div class='modal-dialog modal-lg' role='document'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title' id='exampleModalLabel'>Retroalimentación de la Entrevista</h5>
            <button type='button' id='ventana' class='close' data-dismiss='modal' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>
          <div class='modal-body'>
          <nav>
            <div class='nav nav-tabs' id='nav-tab' role='tablist'>
                <a class='nav-item nav-link active' id='registrar-tab' data-toggle='tab' href='#registrar' role='tab' aria-controls='registrar' aria-selected='true'>Registrar</a>
                <a class='nav-item nav-link' id='actualizar-tab' data-toggle='tab' href='#actualizar' role='tab' aria-controls='actualizar' aria-selected='false'>Actualizar</a>
            </div>
          </nav>
          <div class='tab-content' id='nav-tabContent'>
              <div class='tab-pane fade show active' id='registrar' role='tabpanel' aria-labelledby='registrar-tab'>
                    <ul>
                      <li class='h5'>
                        <p>Notificación de entrevista.</p>
                      </li>
                    </ul>
                    <div class='form-row'>
                    <div class='form-group col-md-6'>
                        <label for='estatus_notif'>estatus de notificación:<samp class='text-danger'>*</samp></label>
                        <select class='custom-select' id='estatus_notif' name='estatus_notif' >
                            <option value='0'>Seleccionar estatus</option>
                            <option value='1'>Localizado</option>
                            <option value='2'>No localizado</option>
                        </select>
                      </div>
                      <div class='form-group col-md-6'>
                          <label for='fecha_notif'>Fecha de notificación:<samp class='text-danger'>*</samp></label>
                          <input type='text' class='form-control' id='fecha_notif' name='fecha_notif' placeholder='dd/mm/yyy'>
                      </div>
                    </div>
                    <button type='button' class='btn btn-outline-success' onclick='registrar_datos_notif($id_ent)'>Registrar</button>
                    <hr>
                    <ul>
                      <li class='h5'>
                        <p>Posponer entrevista.</p>
                      </li>
                    </ul>
                    <div class='form-row'>
                      <div class='form-group col-md-6'>
                        <label for='posponer_ent'>Fecha pospuesta:<samp class='text-danger'>*</samp></label>
                        <input type=' text' class='form-control letras' id='posponer_ent' name='posponer_ent' placeholder='dd/mm/yyyy'>
                      </div>
                    </div>
                    <button type='button' class='btn btn-outline-success' onclick='registrar_fecha_pospuesta_ent($id_ent)'>Registrar</button>
                    <hr>
                    <ul>
                      <li class='h5'>
                        <p>Entrevista.</p>
                      </li>
                    </ul>
                    <div class='form-row'>
                      <div class='form-group col-md-6'>
                      <label for='asistencia'>¿Asistió a la entrevista?:<samp class='text-danger'>*</samp></label>
                      <select class='custom-select' id='asistencia' name='asistencia' >
                          <option value='0'>Seleccionar opción</option>
                          <option value='1'>Asistió</option>
                          <option value='2'>No asistió</option>
                      </select>
                      </div>
                      <div class='form-group col-md-6'>
                        <label for='fecha_ent'>Fecha de entrevista:<samp class='text-danger'>*</samp></label>
                        <input type=' text' class='form-control' id='fecha_ent' name='fecha_ent' placeholder='dd/mm/yyyy'>
                      </div>
                      <div class='form-group col-md-12'>
                        <label for='acuerdos_ent'>Acuerdos o detalles de la entrevista:<samp class='text-danger'>*</samp></label>
                        <textarea type=' text' class='form-control letras' id='acuerdos_ent' name='acuerdos_ent' placeholder='Detalles de los acuerdos de la entrevista.'></textarea>
                      </div>
                    </div>
                    <button type='button' class='btn btn-outline-success' onclick='registrar_datos_entrevistado($id_ent)'>Registrar</button>
                    <hr>
                    <ul>
                      <li class='h5'>
                        <p>Insumos.</p>
                      </li>
                    </ul>
                    <div class='form-row'>
                      <div class='form-group col-md-6'>
                      <label for='area_origen'>Origen del Insumo:<samp class='text-danger'>*</samp></label>
                      <select class='custom-select' id='area_origen' name='area_origen' >
                          <option value='0'>Seleccionar opción</option>
                          <option value='LOCAL'>LOCAL</option>
                          <option value='ADR'>ADR</option>
                          <option value='CENTRAL'>CENTRAL</option>
                      </select>
                      </div>
                      <div class='form-group col-md-6'>
                      <label for='rol_edo'>Rol EDO:<samp class='text-danger'>*</samp></label>
                      <select class='custom-select' id='rol_edo' name='rol_edo' >
                          <option value='0'>Seleccionar opción</option>
                          <option value='SI'>Si</option>
                          <option value='NO'>No</option>
                      </select>
                      </div>
                      <div class='form-group col-md-12'>
                        <label for='insumo'>Isumo:<samp class='text-danger'>*</samp></label>
                        <textarea type=' text' class='form-control letras' id='insumo' name='insumo' placeholder='Detalles del insumo.'></textarea>
                      </div>
                    </div>
                    <button type='button' class='btn btn-outline-success' onclick='registrar_insumos_ent($id_ent)'>Registrar</button>
                    <hr>
                    <ul>
                      <li class='h5'>
                        <p>Motivos de adeudos.</p>
                      </li>
                    </ul>
                    <div class='form-row'>
                    <div class='form-group col-md-6'>
                        <label for='cat_adeudo'>Catalogo de adeudos:<samp class='text-danger'>*</samp></label>
                        <select class='custom-select' id='cat_adeudo' name='cat_adeudo' >
                            <option value='0'>Seleccionar opción</option>";
        for ($i = 0; $i < count($cat_adeudo); $i++) {
            echo $cat_adeudo[$i];
        }
        echo "</select>
                      </div>
                      <div class='form-group col-md-6'>
                          <label for='monto_aprox'>Monto aproximado de adeduo:<samp class='text-danger'>*</samp></label>
                          <div class='input-group mb-3'>
                            <div class='input-group-prepend'>
                              <span class='input-group-text'>$</span>
                            </div>
                            <input type='text' class='form-control numeros' id='monto_aprox' name='monto_aprox' aria-label='Monto aprox (pesos)'>
                            <div class='input-group-append'>
                              <span class='input-group-text'>.00</span>
                            </div>
                          </div>
                      </div>
                    </div>
                    <button type='button' class='btn btn-outline-success' onclick='registrar_motivos_ent($id_ent)'>Registrar</button>
                    <hr>
                    <ul>
                      <li class='h5'>
                        <p>Desvirtuar contribuyente.</p>
                      </li>
                    </ul>
                    <div class='form-row'>
                      <div class='form-group col-md-6'>
                      <label for='desvirtuo'>¿Desvirtuar contribuyente?:<samp class='text-danger'>*</samp></label>
                      <select class='custom-select' id='desvirtuo' name='desvirtuo' >
                          <option value='0'>Seleccionar opción</option>
                          <option value='1'>Si desvirtuo</option>
                          <option value='2'>No desvirtuo</option>
                      </select>
                      </div>
                      <div class='form-group col-md-6'>
                        <label for='desc_desvirtuo'>Detalles del desvirtúo:<samp class='text-danger'>*</samp></label>
                        <textarea type=' text' class='form-control letras' id='desc_desvirtuo' name='desc_desvirtuo' placeholder='Detalles del motivo de desvirtúo.'></textarea>
                      </div>
                    </div>
                    <button type='button' class='btn btn-outline-success' onclick='modal_confirmacion()'>Registrar</button>
                    <hr>
                    <ul>
                      <li class='h5'>
                        <p>Regulariza contribuyente.</p>
                      </li>
                    </ul>
                    <div class='form-row'>
                      <div class='form-group col-md-6'>
                        <label for='desc_solventado'>Detalles de Regularización:<samp class='text-danger'>*</samp></label>
                        <textarea type=' text' class='form-control letras' id='desc_solventado' name='desc_solventado' placeholder='Detalles del motivo de regularización.'></textarea>
                      </div>
                      <div class='form-group col-md-6'>
                        <label for='fecha_sol'>Fecha de solventación:<samp class='text-danger'>*</samp></label>
                        <input type=' text' class='form-control fecha_end' id='fecha_sol' name='fecha_sol' placeholder='dd/mm/yyyy'>
                      </div>
                    </div>
                    <button type='button' class='btn btn-outline-success' onclick='modal_confirmacion_s()'>Registrar</button>
              </div>

              <div class='tab-pane fade show' id='actualizar' role='tabpanel' aria-labelledby='actualizar-tab'>
                    <ul>
                      <li class='h5'>
                        <p>Actualizar: Notificación de entrevista.</p>
                      </li>
                    </ul>
                    <div class='form-row'>
                    <div class='form-group col-md-6'>
                        <label for='estatus_notif_a'>estatus de notificación:<samp class='text-danger'>*</samp></label>
                        <select class='custom-select' id='estatus_notif_a' name='estatus_notif_a' >
                            <option value='0'>Seleccionar estatus</option>
                            <option value='1'>Localizado</option>
                            <option value='2'>No localizado</option>
                        </select>
                      </div>
                      <div class='form-group col-md-6'>
                          <label for='fecha_notif_a'>Fecha de notificación:<samp class='text-danger'>*</samp></label>
                          <input type='text' class='form-control fecha_end' id='fecha_notif_a' name='fecha_notif_a' placeholder='dd/mm/yyy'>
                      </div>
                    </div>
                    <button type='button' class='btn btn-outline-success' onclick='actualizar_datos_notif($id_ent)'>Registrar</button>
                    <hr>
                    <ul>
                      <li class='h5'>
                        <p>Actualizar: Posponer entrevista.</p>
                      </li>
                    </ul>
                    <div class='form-row'>
                      <div class='form-group col-md-6'>
                        <label for='posponer_ent_a'>Fecha pospuesta:<samp class='text-danger'>*</samp></label>
                        <input type=' text' class='form-control fecha' id='posponer_ent_a' name='posponer_ent_a' placeholder='dd/mm/yyyy'>
                      </div>
                    </div>
                    <button type='button' class='btn btn-outline-success' onclick='actualizar_fecha_pospuesta_ent($id_ent)'>Registrar</button>
                    <hr>
                    <ul>
                      <li class='h5'>
                        <p>Actualizar: Entrevista.</p>
                      </li>
                    </ul>
                    <div class='form-row'>
                      <div class='form-group col-md-6'>
                      <label for='asistencia_a'>¿Asistió a la entrevista?:<samp class='text-danger'>*</samp></label>
                      <select class='custom-select' id='asistencia_a' name='asistencia_a' >
                          <option value='0'>Seleccionar opción</option>
                          <option value='1'>Asistió</option>
                          <option value='2'>No asistió</option>
                      </select>
                      </div>
                      <div class='form-group col-md-6'>
                        <label for='fecha_ent_a'>Fecha de entrevista:<samp class='text-danger'>*</samp></label>
                        <input type=' text' class='form-control fecha_end' id='fecha_ent_a' name='fecha_ent_a' placeholder='dd/mm/yyyy'>
                      </div>
                      <div class='form-group col-md-12'>
                        <label for='acuerdos_ent_a'>Acuerdos o detalles de la entrevista:<samp class='text-danger'>*</samp></label>
                        <textarea type=' text' class='form-control letras' id='acuerdos_ent_a' name='acuerdos_ent_a' placeholder='Detalles de los acuerdos de la entrevista.'></textarea>
                      </div>
                    </div>
                    <button type='button' class='btn btn-outline-success' onclick='actualizar_datos_entrevistado($id_ent)'>Registrar</button>
                    <hr>
                    <ul>
                      <li class='h5'>
                        <p>Actualizar: Insumos.</p>
                      </li>
                    </ul>
                    <div class='form-row'>
                      <div class='form-group col-md-6'>
                      <label for='area_origen_a'>Origen del Insumo:<samp class='text-danger'>*</samp></label>
                      <select class='custom-select' id='area_origen_a' name='area_origen_a' >
                          <option value='0'>Seleccionar opción</option>
                          <option value='LOCAL'>LOCAL</option>
                          <option value='ADR'>ADR</option>
                          <option value='CENTRAL'>CENTRAL</option>
                      </select>
                      </div>
                      <div class='form-group col-md-6'>
                      <label for='rol_edo_a'>Rol EDO:<samp class='text-danger'>*</samp></label>
                      <select class='custom-select' id='rol_edo_a' name='rol_edo_a' >
                          <option value='0'>Seleccionar opción</option>
                          <option value='SI'>Si</option>
                          <option value='NO'>No</option>
                      </select>
                      </div>
                      <div class='form-group col-md-12'>
                        <label for='insumo_a'>Isumo:<samp class='text-danger'>*</samp></label>
                        <textarea type=' text' class='form-control letras' id='insumo_a' name='insumo_a' placeholder='Detalles del insumo.'></textarea>
                      </div>
                    </div>
                    <button type='button' class='btn btn-outline-success' onclick='actualizar_insumos_ent($id_ent)'>Registrar</button>
                    <hr>
                    <ul>
                      <li class='h5'>
                        <p>Actualizar: Motivos de adeudos.</p>
                      </li>
                    </ul>
                    <div class='form-row'>
                    <div class='form-group col-md-6'>
                        <label for='cat_adeudo_a'>Catalogo de adeudos:<samp class='text-danger'>*</samp></label>
                        <select class='custom-select' id='cat_adeudo_a' name='cat_adeudo_a' >
                            <option value='0'>Seleccionar opción</option>";
        for ($i = 0; $i < count($cat_adeudo); $i++) {
            echo $cat_adeudo[$i];
        }
        echo "</select>
                      </div>
                      <div class='form-group col-md-6'>
                          <label for='monto_aprox_a'>Monto aproximado de adeduo:</label>
                          <div class='input-group mb-3'>
                            <div class='input-group-prepend'>
                              <span class='input-group-text'>$</span>
                            </div>
                            <input type='text' class='form-control numeros' id='monto_aprox_a' name='monto_aprox_a' aria-label='Monto aprox (pesos)'>
                            <div class='input-group-append'>
                              <span class='input-group-text'>.00</span>
                            </div>
                          </div>
                      </div>
                      <div class='form-group col-md-8'>
                      <label for='estatus_mot'>estatus motivo:</label>
                      <select class='custom-select' id='estatus_mot' name='estatus_mot' >
                          <option value='0'>Seleccionar opción</option>
                          <option value='A'>Motivo vigente</option>
                          <option value='N'>Motivo no vigente</option>
                      </select>
                      </div>
                    </div>
                    <button type='button' class='btn btn-outline-success' onclick='actualizar_motivos_ent($id_ent)'>Registrar</button>
                    <hr>
                    <ul>
                      <li class='h5'>
                        <p>Actualizar: Desvirtuar contribuyente.</p>
                      </li>
                    </ul>
                    <div class='form-row'>
                      <div class='form-group col-md-6'>
                      <label for='desvirtuo'>¿Desvirtuar contribuyente?:<samp class='text-danger'>*</samp></label>
                      <select class='custom-select' id='desvirtuo_a' name='desvirtuo_a' >
                          <option value='0'>Seleccionar opción</option>
                          <option value='1'>Si desvirtuo</option>
                          <option value='2'>No desvirtuo</option>
                      </select>
                      </div>
                      <div class='form-group col-md-6'>
                        <label for='desc_desvirtuo'>Detalles del desvirtúo:<samp class='text-danger'>*</samp></label>
                        <textarea type=' text' class='form-control letras' id='desc_desvirtuo_a' name='desc_desvirtuo_a' placeholder='Detalles del motivo de desvirtúo.'></textarea>
                      </div>
                    </div>
                    <button type='button' class='btn btn-outline-success' onclick='modal_confirmacion_a()'>Registrar</button>
                    <hr>
                    <ul>
                      <li class='h5'>
                        <p>Actualizar: Prioridad del caso con el contribuyente.</p>
                      </li>
                    </ul>
                    <div class='form-row'>
                      <div class='form-group col-md-6'>
                      <label for='prioridad'>Prioridad:<samp class='text-danger'>*</samp></label>
                      <select class='custom-select' id='prioridad' name='prioridad' >
                          <option value='0'>Seleccionar opción</option>
                          <option value='NORMAL'>NORMAL</option>
                          <option value='URGENTE'>URGENTE</option>
                          <option value='EXTRAURGENTE'>EXTRAURGENTE</option>
                      </select>
                      </div>
                    </div>
                    <button type='button' class='btn btn-outline-success' onclick='actualizar_prioridad($id_ent)'>Registrar</button>
                    <hr>
                    <ul>
                      <li class='h5'>
                        <p>Actualizar: Regulariza contribuyente.</p>
                      </li>
                    </ul>
                    <div class='form-row'>
                      <div class='form-group col-md-6'>
                      <label for='solventar'>¿Se regularizo el contribuyente?:<samp class='text-danger'>*</samp></label>
                      <select class='custom-select' id='solventar' name='solventar' >
                          <option value='0'>Seleccionar opción</option>
                          <option value='1'>Si se regularizo</option>
                          <option value='2'>No se regularizo</option>
                      </select>
                      </div>
                      <div class='form-group col-md-6'>
                        <label for='desc_solventado_a'>Detalles de Regularización:<samp class='text-danger'>*</samp></label>
                        <textarea type=' text' class='form-control letras' id='desc_solventado_a' name='desc_solventado_a' placeholder='Detalles del motivo de regularización.'></textarea>
                      </div>
                      <div class='form-group col-md-6'>
                        <label for='fecha_sol'>Fecha de solventación:<samp class='text-danger'>*</samp></label>
                        <input type=' text' class='form-control fecha_end' id='fecha_sol_a' name='fecha_sol_a' placeholder='dd/mm/yyyy'>
                      </div>
                    </div>
                    <button type='button' class='btn btn-outline-success' onclick='modal_confirmacion_act_s()'>Registrar</button>
              </div>
            </div>
        </div>
          <div class='modal-footer justify-content-center'>
            <p class='font-italic'>La información debe ser certera y retroalimentada en tiempo para un seguimiento preciso.</p>
          </div>
        </div>
      </div>
      </div>
      
      <div class='modal fade' id='confrmar_desv' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
          <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title' id='exampleModalLabel'>Confirmar desvirtúo</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>
                ¿Seguro que desea confirmar la sitiación del contribuyente?
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                <button type='button' class='btn btn-outline-success' onclick='registrar_desvirtuo_ent($id_ent)'>Confirmar cambio</button>
              </div>
            </div>
          </div>
        </div>

        <div class='modal fade' id='confrmar_desv_a' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
          <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title' id='exampleModalLabel'>Confirmar desvirtúo</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>
                ¿Seguro que desea confirmar la sitiación del contribuyente?
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                <button type='button' class='btn btn-outline-success' onclick='actualizar_desvirtuo_ent($id_ent)'>Confirmar cambio</button>
              </div>
            </div>
          </div>
        </div>

        <div class='modal fade' id='confrmar_solventacion' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
          <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title' id='exampleModalLabel'>Confirmar desvirtúo</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>
                ¿Seguro que desea confirmar la sitiación del contribuyente?
              </div>
              <div id='res_sol'>
              
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                <button type='button' class='btn btn-outline-success' onclick='solventar_caso($id_ent)'>Confirmar cambio</button>
              </div>
            </div>
          </div>
        </div>

        <div class='modal fade' id='confrmar_solventacion_a' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
          <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title' id='exampleModalLabel'>Confirmar desvirtúo</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>
                ¿Seguro que desea confirmar la sitiación del contribuyente?
              </div>
              <div id='res_sol'>
              
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                <button type='button' class='btn btn-outline-success' onclick='act_solventar_caso($id_ent)'>Confirmar cambio</button>
              </div>
            </div>
          </div>
        </div>
        
        ";
    }

    public function priviliegios_medios($cat_adeudo, $id_ent)
    {
        echo "
      
      <div class='modal fade' id='modal_retro' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true' style='overflow-y: scroll;'>
      <div class='modal-dialog modal-lg' role='document'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title' id='exampleModalLabel'>Retroalimentación de la Entrevista</h5>
            <button type='button' id='ventana' class='close' data-dismiss='modal' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>
          <div class='modal-body'>
                <ul>
                  <li class='h5'>
                    <p>Notificación de entrevista.</p>
                  </li>
                </ul>
                <div class='form-row'>
                <div class='form-group col-md-6'>
                    <label for='estatus_notif'>estatus de notificación:<samp class='text-danger'>*</samp></label>
                    <select class='custom-select' id='estatus_notif' name='estatus_notif' >
                        <option value='0'>Seleccionar estatus</option>
                        <option value='1'>Localizado</option>
                        <option value='2'>No localizado</option>
                    </select>
                  </div>
                  <div class='form-group col-md-6'>
                      <label for='fecha_notif'>Fecha de notificación:<samp class='text-danger'>*</samp></label>
                      <input type='text' class='form-control' id='fecha_notif' name='fecha_notif' placeholder='dd/mm/yyy'>
                  </div>
                </div>
                <button type='button' class='btn btn-outline-success' onclick='registrar_datos_notif($id_ent)'>Registrar</button>
                <hr>
                <ul>
                  <li class='h5'>
                    <p>Posponer entrevista.</p>
                  </li>
                </ul>
                <div class='form-row'>
                  <div class='form-group col-md-6'>
                    <label for='posponer_ent'>Fecha pospuesta:<samp class='text-danger'>*</samp></label>
                    <input type=' text' class='form-control letras' id='posponer_ent' name='posponer_ent' placeholder='dd/mm/yyyy'>
                  </div>
                </div>
                <button type='button' class='btn btn-outline-success' onclick='registrar_fecha_pospuesta_ent($id_ent)'>Registrar</button>
                <hr>
                <ul>
                  <li class='h5'>
                    <p>Entrevista.</p>
                  </li>
                </ul>
                <div class='form-row'>
                  <div class='form-group col-md-6'>
                  <label for='asistencia'>¿Asistió a la entrevista?:<samp class='text-danger'>*</samp></label>
                  <select class='custom-select' id='asistencia' name='asistencia' >
                      <option value='0'>Seleccionar opción</option>
                      <option value='1'>Asistió</option>
                      <option value='2'>No asistió</option>
                  </select>
                  </div>
                  <div class='form-group col-md-6'>
                    <label for='fecha_ent'>Fecha de entrevista:<samp class='text-danger'>*</samp></label>
                    <input type=' text' class='form-control' id='fecha_ent' name='fecha_ent' placeholder='dd/mm/yyyy'>
                  </div>
                  <div class='form-group col-md-12'>
                    <label for='acuerdos_ent'>Acuerdos o detalles de la entrevista:<samp class='text-danger'>*</samp></label>
                    <textarea type=' text' class='form-control letras' id='acuerdos_ent' name='acuerdos_ent' placeholder='Detalles de los acuerdos de la entrevista.'></textarea>
                  </div>
                </div>
                <button type='button' class='btn btn-outline-success' onclick='registrar_datos_entrevistado($id_ent)'>Registrar</button>
                <hr>
                <ul>
                  <li class='h5'>
                    <p>Insumos.</p>
                  </li>
                </ul>
                <div class='form-row'>
                  <div class='form-group col-md-6'>
                  <label for='area_origen'>Origen del Insumo:<samp class='text-danger'>*</samp></label>
                  <select class='custom-select' id='area_origen' name='area_origen' >
                      <option value='0'>Seleccionar opción</option>
                      <option value='LOCAL'>LOCAL</option>
                      <option value='ADR'>ADR</option>
                      <option value='CENTRAL'>CENTRAL</option>
                  </select>
                  </div>
                  <div class='form-group col-md-6'>
                  <label for='rol_edo'>Rol EDO:<samp class='text-danger'>*</samp></label>
                  <select class='custom-select' id='rol_edo' name='rol_edo' >
                      <option value='0'>Seleccionar opción</option>
                      <option value='SI'>Si</option>
                      <option value='NO'>No</option>
                  </select>
                  </div>
                  <div class='form-group col-md-12'>
                    <label for='insumo'>Isumo:<samp class='text-danger'>*</samp></label>
                    <textarea type=' text' class='form-control letras' id='insumo' name='insumo' placeholder='Detalles del insumo.'></textarea>
                  </div>
                </div>
                <button type='button' class='btn btn-outline-success' onclick='registrar_insumos_ent($id_ent)'>Registrar</button>
                <hr>
                <ul>
                  <li class='h5'>
                    <p>Motivos de adeudos.</p>
                  </li>
                </ul>
                <div class='form-row'>
                <div class='form-group col-md-6'>
                    <label for='cat_adeudo'>Catalogo de adeudos:<samp class='text-danger'>*</samp></label>
                    <select class='custom-select' id='cat_adeudo' name='cat_adeudo' >
                        <option value='0'>Seleccionar opción</option>";
        for ($i = 0; $i < count($cat_adeudo); $i++) {
            echo $cat_adeudo[$i];
        }
        echo "</select>
                  </div>
                  <div class='form-group col-md-6'>
                      <label for='monto_aprox'>Monto aproximado de adeduo:<samp class='text-danger'>*</samp></label>
                      <div class='input-group mb-3'>
                        <div class='input-group-prepend'>
                          <span class='input-group-text'>$</span>
                        </div>
                        <input type='text' class='form-control numeros' id='monto_aprox' name='monto_aprox' aria-label='Monto aprox (pesos)'>
                        <div class='input-group-append'>
                          <span class='input-group-text'>.00</span>
                        </div>
                      </div>
                  </div>
                </div>
                <button type='button' class='btn btn-outline-success' onclick='registrar_motivos_ent($id_ent)'>Registrar</button>
                <hr>
                <ul>
                  <li class='h5'>
                    <p>Desvirtuar contribuyente.</p>
                  </li>
                </ul>
                <div class='form-row'>
                  <div class='form-group col-md-6'>
                  <label for='desvirtuo'>¿Desvirtuar contribuyente?:<samp class='text-danger'>*</samp></label>
                  <select class='custom-select' id='desvirtuo' name='desvirtuo' >
                      <option value='0'>Seleccionar opción</option>
                      <option value='1'>Si desvirtuo</option>
                      <option value='2'>No desvirtuo</option>
                  </select>
                  </div>
                  <div class='form-group col-md-6'>
                    <label for='desc_desvirtuo'>Detalles del desvirtúo:<samp class='text-danger'>*</samp></label>
                    <textarea type=' text' class='form-control letras' id='desc_desvirtuo' name='desc_desvirtuo' placeholder='Detalles del motivo de desvirtúo.'></textarea>
                  </div>
                </div>
                <button type='button' class='btn btn-outline-success' onclick='modal_confirmacion()'>Registrar</button>
                <ul>
                <li class='h5'>
                  <p>Regulariza contribuyente.</p>
                </li>
              </ul>
              <div class='form-row'>
                <div class='form-group col-md-6'>
                  <label for='desc_solventado'>Detalles de Regularización:<samp class='text-danger'>*</samp></label>
                  <textarea type=' text' class='form-control letras' id='desc_solventado' name='desc_solventado' placeholder='Detalles del motivo de regularización.'></textarea>
                </div>
                <div class='form-group col-md-6'>
                  <label for='fecha_sol'>Fecha de solventación:<samp class='text-danger'>*</samp></label>
                  <input type=' text' class='form-control fecha_end' id='fecha_sol' name='fecha_sol' placeholder='dd/mm/yyyy'>
                </div>
              </div>
              <button type='button' class='btn btn-outline-success' onclick='modal_confirmacion_s()'>Registrar</button>
          </div>
          <div class='modal-footer justify-content-center'>
            <p class='font-italic'>La información debe ser certera y retroalimentada en tiempo para un seguimiento preciso.</p>
          </div>
        </div>
      </div>
      </div>
      
      <div class='modal fade' id='confrmar_desv' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
          <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title' id='exampleModalLabel'>Confirmar desvirtúo</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>
                ¿Seguro que desea confirmar la sitiación del contribuyente?
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                <button type='button' class='btn btn-outline-success' onclick='registrar_desvirtuo_ent($id_ent)'>Confirmar cambio</button>
              </div>
            </div>
          </div>
        </div>

        <div class='modal fade' id='confrmar_solventacion' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
          <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title' id='exampleModalLabel'>Confirmar desvirtúo</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>
                ¿Seguro que desea confirmar la sitiación del contribuyente?
              </div>
              <div id='res_sol'>
              
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                <button type='button' class='btn btn-outline-success' onclick='solventar_caso($id_ent)'>Confirmar cambio</button>
              </div>
            </div>
          </div>
        </div>
      ";
    }
    public function Listado_de_bloqueo()
    {
        include_once 'php/ConsultaContribuyentes.php';
        $consulta = new ConsultaContribuyentes();
        $datos = $consulta->ConsultaContribuyentes_bloq();
        $consecutivo = 1;
        if ($datos != null) {
            for ($i = 0; $i < count($datos); $i++) {
                $html[$i] = "<tr>
                          <th scope='row'>$consecutivo</th>
                          <td><a class='' style='' href='#' onclick='BuscarDatosContrib(" . $datos[$i]["id_contribuyente"] . ")'>" . $datos[$i]["id_contribuyente"] . "</a></td>
                          <td>" . $datos[$i]["razon_social"] . "</td>
                          <td>" . $datos[$i]["desc_proceso"] . "</td>
                      </tr>";
                $consecutivo++;
            }
        }

        if (isset($datos)) {
            if (count($datos) < 12) {
                $class = "class='vh-100 table-responsive'";
            }
        } else {
            $class = "class='table-responsive'";
        }



        echo "
        <div class>
        <table class='table table-sm table-striped shadow p-1 bg-white rounded'>
        <thead>
          <tr>
            <th scope='col'>#</th>
            <th scope='col'>RFC</th>
            <th scope='col'>Razón social</th>
            <th scope='col'>Estatus</th>
          </tr>
        </thead>
        <tbody>
       ";
        if (isset($html)) {
            for ($i = 0; $i < count($html); $i++) {
                echo $html[$i];
            }
        } else {
            echo "Sin contribuyentes asignados por el momento.";
        }
        echo "</tbody>
        </table>
        </div>
        ";
    }


    public function Privilegio_escritura_entrevista($id_empleado)
    {
        include_once 'sesion.php';
        $cat_adeudo = self::preparando_cat_adeudos();
        $id_ent = $_COOKIE["id_ent"];
        $id_perfil = $_SESSION["ses_id_perfil"];
        $id_user = $_SESSION["ses_id_usuario"];
        // echo "<script>alert($id_perfil);</script>";
        switch ($id_perfil) {
            case 2:
                self::Actualizar_user_priviligeado($cat_adeudo, $id_ent);
                self::Registrar_medida($id_ent);
                self::Actualzar_medida_Privilegiado();
                self::Registrar_seguimiento($id_ent);
                break;
            case 4:
                self::Actualizar_user_priviligeado($cat_adeudo, $id_ent);
                self::Registrar_medida($id_ent);
                self::Actualzar_medida_Privilegiado();
                break;
            case 5:
                self::Actualizar_user_priviligeado($cat_adeudo, $id_ent);
                self::Registrar_medida($id_ent);
                self::Actualzar_medida_Privilegiado();
                break;
            case 6:
                self::Actualizar_user_priviligeado($cat_adeudo, $id_ent);
                self::Registrar_medida($id_ent);
                self::Actualzar_medida_Privilegiado();
                self::Registrar_seguimiento($id_ent);
                break;
            case 7:
                self::Actualizar_user_priviligeado($cat_adeudo, $id_ent);
                self::Registrar_medida($id_ent);
                self::Actualzar_medida_Privilegiado();
                break;
            case 3:
                if ($id_empleado == $id_user) {
                    self::priviliegios_medios($cat_adeudo, $id_ent);
                    self::Registrar_medida($id_ent);
                    self::Actualzar_medida_Privilegiado();
                } else {
                    echo "<!-- Usuario sin privilegios de escritura. -->";
                }
                break;
        }
    }

    public function Registrar_medida($id_ent)
    {
        echo " 
      <div class='modal fade' id='Registrar_medida_eje' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true' style='overflow-y: scroll;'>
        <div class='modal-dialog modal-dialog-centered modal-lg' role='document'>
          <div class='modal-content'>
            <div class='modal-header'>
              <h5 class='modal-title' id='exampleModalLabel'>Medida de Ejemplaridad.</h5>
              <button type='button' id='ventana' class='close' data-dismiss='modal' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>
            <div class='modal-body'>
            <ul>
            <li class='h5'>
              <p>Registrar medida ejemplar.</p>
            </li>
            </ul>
              <div class='form-row'>
                <div class='form-group col-md-12'>
                  <label for='detalles_medida'>Detalles del motivo de aplicación de la medida de ejemplaridad:<samp class='text-danger'>*</samp></label>
                  <textarea type=' text' class='form-control letras' id='detalles_medida' name='detalles_medida' placeholder='Detalles del motivo de la aplicación de la medida de ejemplaridad.'></textarea>
                </div>
                <div class='form-group col-md-6'>
                <label for='tipo_medida'>Tipo de medida ejmplear a aplicar:<samp class='text-danger'>*</samp></label>
                <select class='custom-select' id='tipo_medida' name='tipo_medida' >
                    <option value='0'>Seleccionar opción</option>
                    <option value='AUDITORIA'>Solicitud de Auditoria</option>
                    <option value='CANCELACIÓN'>Solicitud de Cancelación de CFDI</option>
                </select>
                </div>
              </div>
              <div id='formulario'>
                
              </div>
              <div id='result'>

              </div>
          </div>
            <div class='modal-footer'>
              <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
              <button type='button' class='btn btn-outline-success' id='btn_confirmar' onclick='confirmar_medida()'>Confirmar aplicación</button>
            </div>
          </div>
        </div>
      </div>

      <div class='modal fade' id='confirmar_medida' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
          <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title' id='exampleModalLabel'>Confirmar Medida de ejemplaridad</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>
                ¿Seguro que desea aplicar la medida de ejemplaridad al contribuyente?
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                <button type='button' class='btn btn-outline-success' onclick='registrar_medida_ejemplar($id_ent)'>Aplicar medida.</button>
              </div>
            </div>
          </div>
        </div>
      
      ";
    }

    public function Registrar_seguimiento($id_entrevista)
    {
        echo " 
      <div class='modal fade' id='Modal_seguimiento' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true' style='overflow-y: scroll;'>
        <div class='modal-dialog modal-dialog-centered modal-lg' role='document'>
          <div class='modal-content'>
            <div class='modal-header'>
              <h5 class='modal-title' id='exampleModalLabel'>Registro de seguimientos.</h5>
              <button type='button' id='ventana' class='close' data-dismiss='modal' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>
            <div class='modal-body'>
            <ul>
            <li class='h5'>
              <p>Registrar seguimiento de entrevista.</p>
            </li>
            </ul>
              <form id='formulario_seg' method='post' enctype='multipart/form-data'>
                  <div class='form-row'>
                  <div class='form-group col-md-6'>
                    <label for='fecha_seg'>Fecha del seguimiento:<samp class='text-danger'>*</samp></label>
                    <input type=' text' class='form-control fecha_end' id='fecha_seg' name='fecha_seg' placeholder='dd/mm/yyyy'>
                  </div>
                  <div class='form-group col-md-6'>
                  <label for='archivo_seg'>Archivo a agregar como parte del segumiento:</label>
                    <div class='custom-file'>
                      <input type='file' class=' custom-file-input' id='archivo_seg' name='archivo_seg'>
                      <label class='custom-file-label' for='archivo_seg'>Extensiones: xlsx, pdf, doc, msg y zip </label>
                    </div>
                  </div>
                  <div class='form-group col-md-12'>
                    <label for='detalles_seg'>Detalles del seguimiento:<samp class='text-danger'>*</samp></label>
                    <textarea type=' text' class='form-control letras' id='detalles_seg' name='detalles_seg' placeholder='Detalles del seguimiento en la entrevista.'></textarea>
                  </div>
                </div>
              </form>
          </div>
            <div class='modal-footer'>
              <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
              <button type='button' class='btn btn-outline-success' id='btn_confirmar' onclick='confirmar_seg()' >Confirmar seguimiento</button>
            </div>
          </div>
        </div>
      </div>

      <div class='modal fade' id='confirmar_seguimiento' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
          <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title' id='exampleModalLabel'>Confirmar registro del seguimiento.</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>
                ¿Desea registrar el seguimiento?
                <div id='result_seg'>

                </div>
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                <button type='button' class='btn btn-outline-success' onclick='registrar_seguimiento()' >Registrar segumiento.</button>
              </div>
            </div>
          </div>
        </div>
      
      ";
    }

    public function Actualzar_medida_Privilegiado()
    {
        echo " 
      <div class='modal fade' id='Actualizar_medida_eje' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true' style='overflow-y: scroll;'>
        <div class='modal-dialog modal-dialog-centered modal-lg' role='document'>
          <div class='modal-content'>
            <div class='modal-header'>
              <h5 class='modal-title' id='exampleModalLabel'>Medida de Ejemplaridad.</h5>
              <button type='button' id='ventana' class='close' data-dismiss='modal' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>
            <div class='modal-body' id='editar'>

    
            </div>
            <div class='modal-footer'>
              <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
              <button type='button' class='btn btn-outline-success' id='btn_confirmar_a' onclick='Modal_confirmar_actualizacion_medida_audi()'>Confirmar aplicación</button>
            </div>
          </div>
        </div>
      </div>

        <div class='modal fade' id='actualizar_cat' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
          <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title' id='exampleModalLabel'>Cambios de catalogos.</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body' id='insertar_cat'>
              </div>
              <div class='modal-footer'>
              </div>
            </div>
          </div>
        </div>

        <div class='modal fade' id='confirmar_medida_a' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
          <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title' id='exampleModalLabel'>Confirmar Medida de ejemplaridad</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>
                ¿Seguro que desea aplicar la actialización de medida ejemplar al contribuyente?
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                <button type='button' class='btn btn-outline-success' id='btn_confirmar_medida_a' disable>Aplicar medida.</button>
              </div>
            </div>
          </div>
        </div>
      ";
    }

    public function Form_Actualiza_auditor()
    {
        $html = "<ul>
              <li class='h5'>
                <p>Agregar un Auditor nuevo.</p>
              </li>
            </ul>
            <div class='form-group col-md-12'>
                    <label for='nombre_auditor_n'>Nombre del Auditor:<samp class='text-danger'>*</samp></label>
                    <input type=' text' class='form-control' id='nombre_auditor_n' name='nombre_auditor_n' placeholder='Lic. Auditor'>
            </div>
            <button type='button' class='btn btn-outline-success' onclick='registrar_auditor()'>Registrar.</button>
            ";
        return $html;
    }

    public function Form_Actualiza_numero_oficio()
    {
        $html = "<ul>
              <li class='h5'>
                <p>Agregar un Número de oficio.</p>
              </li>
            </ul>
            <div class='form-group col-md-12'>
                    <label for='numero_oficio_a_c'>Número de oficio nuevo:<samp class='text-danger'>*</samp></label>
                    <input type='text' class='form-control' id='numero_oficio_a_c' name='numero_oficio_a_c' placeholder='400-75-00-07-00' maxlength='15'>
            </div>
            <button type='button' class='btn btn-outline-success' onclick='cambiar_numero_oficio()'>Registrar.</button>
            ";
        return $html;
    }

    /*
   * Se comvierte a arreglo la cadena formada por el numero
   * de oficio y luego lo unico que se devuelve es el concecutivo
   * esto para poder editar ya sea solo todo el numero de oficio
   * o unicamente el número concecutivo. 
   */
    public function Extraer_numero_oficio($numero)
    {
        $arreglo_oficio = explode("-", $numero);
        $numero = $arreglo_oficio[6];
        return $numero;
    }

    public function Listado_pendientes_entrevista()
    {
        include_once "php/ConsultaContribuyentes.php";
        $consulta = new ConsultaContribuyentes();

        $condiciones = self::Condiones_query();
        $cantidad_datos = $consulta->Consulta_pendientes_entrevista_num($condiciones);

        $pagina_actual = $_GET['pendientes'];
        $total_de_datos = 10;
        $cantidad = $cantidad_datos;
        $paginas = ($cantidad / $total_de_datos);
        $valor_redondeado = round($paginas);
        $nombre_pag = "Accesos_directos";
        $nombre_get = "pendientes";

        if ($pagina_actual <= 1) {
            $inicio = 0;
            $datos = $consulta->Consulta_pendientes_entrevista($condiciones, $inicio);
        } else {
            $pagina = $pagina_actual - 1;
            $inicio = ($total_de_datos * $pagina);
            $datos = $consulta->Consulta_pendientes_entrevista($condiciones, $inicio);
        }

        $size = ($cantidad_datos > 5) ? "" :  "vh-100";

        $datos_paginacion =
            array(
                'pag_anterior' => $pagina_actual - 1,
                'pag_siguiente' => $pagina_actual + 1,
                'ultima_pag' => $valor_redondeado,
                'primera_pag' => 1,
                'ultimas_pag' => $valor_redondeado - 1,
                'pagina_actual' => $pagina_actual,
                'nombre_pag' => $nombre_pag,
                'nombre_get' => $nombre_get
            );

        $consecutivo = 1;
        if ($datos != null) {
            for ($i = 0; $i < count($datos); $i++) {
                $html[$i] = "<tr>
                              <th scope='row'>$consecutivo</th>
                              <td><a class='' style='' href='#' onclick='DetalleEntrevista(" . $datos[$i]["id_entrevista"] . ")'>" . $datos[$i]["rfc"] . "</a></td>
                              <td>" . $datos[$i]["razon_social"] . "</td>
                              <td>" . $datos[$i]["fecha_OF"]->format('d/m/Y') . "</td>
                              <td>" . $datos[$i]["nombre_empleado"] . "</td>
                              <td>" . $datos[$i]["Proceso"] . "</td>
                          </tr>";
                $consecutivo++;
            }
        }

        self::paginacion_adaptable($datos_paginacion);

        echo "<div class='py-1 container-fluid'>
          <ul>
            <li class='h2'>
              <p>Contribuyentes pendientes de entrevista</p>
            </li>
          </ul>
          <div class='$size table-responsive'>
          <table class='table table-sm table-striped'>
          <thead>
            <tr>
              <th scope='col'>#</th>
              <th scope='col'>RFC</th>
              <th scope='col'>Contribuyente</th>
              <th scope='col'>Fecha para entrevista</th>
              <th scope='col'>Analista asignado</th>
              <th scope='col'>estatus proceso</th>
            </tr>
          </thead>
          <tbody>";
        if (isset($html)) {
            for ($i = 0; $i < count($html); $i++) {
                echo $html[$i];
            }
        } else {
            echo "<tr class='text-center'>
                  <td colspan='8'>
                    Sin medidas de ejemplaridad registradas por el momento.
                  </td>
              </tr>";
        }
        echo "</tbody>
            </table>
            </div>
          </div>
        ";
    }

    public function Listado_plazo_10_directo()
    {
        include_once "php/ConsultaContribuyentes.php";
        $consulta = new ConsultaContribuyentes();

        $condiciones = self::Condiones_query();
        $cantidad_datos = $consulta->Consulta_plazos_10_num($condiciones);

        $pagina_actual = $_GET['plazos_10'];
        $total_de_datos = 10;
        $cantidad = $cantidad_datos;
        $paginas = ($cantidad / $total_de_datos);
        $valor_redondeado = round($paginas);
        $nombre_pag = "Accesos_directos";
        $nombre_get = "plazos_10";

        if ($pagina_actual <= 1) {
            $inicio = 0;
            $datos = $consulta->Consulta_entrevistas_plazos_10($condiciones, $inicio);
        } else {
            $pagina = $pagina_actual - 1;
            $inicio = ($total_de_datos * $pagina);
            $datos = $consulta->Consulta_entrevistas_plazos_10($condiciones, $inicio);
        }

        $size = ($cantidad_datos > 5) ? "" :  "vh-100";

        $datos_paginacion =
            array(
                'pag_anterior' => $pagina_actual - 1,
                'pag_siguiente' => $pagina_actual + 1,
                'ultima_pag' => $valor_redondeado,
                'primera_pag' => 1,
                'ultimas_pag' => $valor_redondeado - 1,
                'pagina_actual' => $pagina_actual,
                'nombre_pag' => $nombre_pag,
                'nombre_get' => $nombre_get
            );

        $consecutivo = 1;
        if ($datos != null) {
            for ($i = 0; $i < count($datos); $i++) {
                $fecha_ent = ($datos[$i]["fecha_OF"] != null) ? $datos[$i]["fecha_OF"]->format('d/m/Y') : "Sin entrevistar";
                $html[$i] = "<tr>
                              <th scope='row'>$consecutivo</th>
                              <td><a class='' style='' href='#' onclick='DetalleEntrevista(" . $datos[$i]["id_entrevista"] . ")'>" . $datos[$i]["rfc"] . "</a></td>
                              <td>" . $datos[$i]["razon_social"] . "</td>
                              <td>" . $fecha_ent . "</td>
                              <td>" . $datos[$i]["nombre_empleado"] . "</td>
                              <td>" . $datos[$i]["Proceso"] . "</td>
                          </tr>";
                $consecutivo++;
            }
        }

        self::paginacion_adaptable($datos_paginacion);

        echo "<div class='py-1 container-fluid'>
          <ul>
            <li class='h2'>
              <p>Contribuyentes que están en plazos 10</p>
            </li>
          </ul>
          <div class='$size table-responsive'>
          <table class='table table-sm table-striped'>
          <thead>
            <tr>
              <th scope='col'>#</th>
              <th scope='col'>RFC</th>
              <th scope='col'>Contribuyente</th>
              <th scope='col'>Fecha de entrevista</th>
              <th scope='col'>Analista asignado</th>
              <th scope='col'>estatus proceso</th>
            </tr>
          </thead>
          <tbody>";
        if (isset($html)) {
            for ($i = 0; $i < count($html); $i++) {
                echo $html[$i];
            }
        } else {
            echo "<tr class='text-center'>
                  <td colspan='8'>
                    Sin medidas de ejemplaridad registradas por el momento.
                  </td>
              </tr>";
        }
        echo "</tbody>
            </table>
            </div>
          </div>
        ";
    }

    public function Listado_plazo_30_directo()
    {
        include_once "php/ConsultaContribuyentes.php";
        $consulta = new ConsultaContribuyentes();

        $condiciones = self::Condiones_query();
        $cantidad_datos = $consulta->Consulta_plazos_30_num($condiciones);

        $pagina_actual = $_GET['plazos_30'];
        $total_de_datos = 10;
        $cantidad = $cantidad_datos;
        $paginas = ($cantidad / $total_de_datos);
        $valor_redondeado = round($paginas);
        $nombre_pag = "Accesos_directos";
        $nombre_get = "plazos_30";

        if ($pagina_actual <= 1) {
            $inicio = 0;
            $datos = $consulta->Consulta_entrevistas_plazos_30($condiciones, $inicio);
        } else {
            $pagina = $pagina_actual - 1;
            $inicio = ($total_de_datos * $pagina);
            $datos = $consulta->Consulta_entrevistas_plazos_30($condiciones, $inicio);
        }

        $size = ($cantidad_datos > 5) ? "" :  "vh-100";

        $datos_paginacion =
            array(
                'pag_anterior' => $pagina_actual - 1,
                'pag_siguiente' => $pagina_actual + 1,
                'ultima_pag' => $valor_redondeado,
                'primera_pag' => 1,
                'ultimas_pag' => $valor_redondeado - 1,
                'pagina_actual' => $pagina_actual,
                'nombre_pag' => $nombre_pag,
                'nombre_get' => $nombre_get
            );

        $consecutivo = 1;
        if ($datos != null) {
            for ($i = 0; $i < count($datos); $i++) {
                $html[$i] = "<tr>
                              <th scope='row'>$consecutivo</th>
                              <td><a class='' style='' href='#' onclick='DetalleEntrevista(" . $datos[$i]["id_entrevista"] . ")'>" . $datos[$i]["rfc"] . "</a></td>
                              <td>" . $datos[$i]["razon_social"] . "</td>
                              <td>" . $datos[$i]["fecha_OF"]->format('d/m/Y') . "</td>
                              <td>" . $datos[$i]["nombre_empleado"] . "</td>
                              <td>" . $datos[$i]["Proceso"] . "</td>
                          </tr>";
                $consecutivo++;
            }
        }

        self::paginacion_adaptable($datos_paginacion);

        echo "<div class='py-1 container-fluid'>
          <ul>
            <li class='h2'>
              <p>Contribuyentes que están en plazos 30</p>
            </li>
          </ul>
          <div class='$size table-responsive'>
          <table class='table table-sm table-striped'>
          <thead>
            <tr>
              <th scope='col'>#</th>
              <th scope='col'>RFC</th>
              <th scope='col'>Contribuyente</th>
              <th scope='col'>Fecha de entrevista</th>
              <th scope='col'>Analista asignado</th>
              <th scope='col'>estatus proceso</th>
            </tr>
          </thead>
          <tbody>";
        if (isset($html)) {
            for ($i = 0; $i < count($html); $i++) {
                echo $html[$i];
            }
        } else {
            echo "<tr class='text-center'>
                  <td colspan='8'>
                    Sin medidas de ejemplaridad registradas por el momento.
                  </td>
              </tr>";
        }
        echo "</tbody>
            </table>
            </div>
          </div>
        ";
    }

    public function Listado_fuera_plazos_directo()
    {
        include_once "php/ConsultaContribuyentes.php";
        $consulta = new ConsultaContribuyentes();

        $condiciones = self::Condiones_query();
        $cantidad_datos = $consulta->Consulta_fuera_plazos_num($condiciones);

        $pagina_actual = $_GET['fuera_plazos'];
        $total_de_datos = 10;
        $cantidad = $cantidad_datos;
        $paginas = ($cantidad / $total_de_datos);
        $valor_redondeado = round($paginas);
        $nombre_pag = "Accesos_directos";
        $nombre_get = "fuera_plazos";

        if ($pagina_actual <= 1) {
            $inicio = 0;
            $datos = $consulta->Consulta_entrevistas_fuera_plazos($condiciones, $inicio);
        } else {
            $pagina = $pagina_actual - 1;
            $inicio = ($total_de_datos * $pagina);
            $datos = $consulta->Consulta_entrevistas_fuera_plazos($condiciones, $inicio);
        }

        $size = ($cantidad_datos > 5) ? "" :  "vh-100";

        $datos_paginacion =
            array(
                'pag_anterior' => $pagina_actual - 1,
                'pag_siguiente' => $pagina_actual + 1,
                'ultima_pag' => $valor_redondeado,
                'primera_pag' => 1,
                'ultimas_pag' => $valor_redondeado - 1,
                'pagina_actual' => $pagina_actual,
                'nombre_pag' => $nombre_pag,
                'nombre_get' => $nombre_get
            );

        $consecutivo = 1;
        if ($datos != null) {
            for ($i = 0; $i < count($datos); $i++) {
                $html[$i] = "<tr>
                              <th scope='row'>$consecutivo</th>
                              <td><a class='' style='' href='#' onclick='DetalleEntrevista(" . $datos[$i]["id_entrevista"] . ")'>" . $datos[$i]["rfc"] . "</a></td>
                              <td>" . $datos[$i]["razon_social"] . "</td>
                              <td>" . $datos[$i]["fecha_OF"]->format('d/m/Y') . "</td>
                              <td>" . $datos[$i]["nombre_empleado"] . "</td>
                              <td>" . $datos[$i]["Proceso"] . "</td>
                          </tr>";
                $consecutivo++;
            }
        }

        self::paginacion_adaptable($datos_paginacion);

        echo "<div class='py-1 container-fluid'>
          <ul>
            <li class='h2'>
              <p>Contribuyentes que están fuera de plazos</p>
            </li>
          </ul>
          <div class='$size table-responsive'>
          <table class='table table-sm table-striped'>
          <thead>
            <tr>
              <th scope='col'>#</th>
              <th scope='col'>RFC</th>
              <th scope='col'>Contribuyente</th>
              <th scope='col'>Fecha de entrevista</th>
              <th scope='col'>Analista asignado</th>
              <th scope='col'>estatus proceso</th>
            </tr>
          </thead>
          <tbody>";
        if (isset($html)) {
            for ($i = 0; $i < count($html); $i++) {
                echo $html[$i];
            }
        } else {
            echo "<tr class='text-center'>
                  <td colspan='8'>
                    Sin medidas de ejemplaridad registradas por el momento.
                  </td>
              </tr>";
        }
        echo "</tbody>
            </table>
            </div>
          </div>
        ";
    }

    public function Listado_de_busquedas()
    {
        include_once "php/ConsultaContribuyentes.php";
        $consulta = new ConsultaContribuyentes();
        $busqueda = $_COOKIE["busqueda"];

        $cantidad_datos = $consulta->Consulta_busqueda_similares_num($busqueda);

        $pagina_actual = $_GET['busquedas'];
        $total_de_datos = 10;
        $cantidad = $cantidad_datos;
        $paginas = ($cantidad / $total_de_datos);
        $valor_redondeado = round($paginas);
        $nombre_pag = "Busquedas_relacionadas";
        $nombre_get = "busquedas";

        if ($pagina_actual <= 1) {
            $inicio = 0;
            $datos = $consulta->Consulta_busqueda_similares($busqueda, $inicio);
        } else {
            $pagina = $pagina_actual - 1;
            $inicio = ($total_de_datos * $pagina);
            $datos = $consulta->Consulta_busqueda_similares($busqueda, $inicio);
        }

        $size = ($cantidad_datos > 5) ? "" :  "vh-100";

        $datos_paginacion =
            array(
                'pag_anterior' => $pagina_actual - 1,
                'pag_siguiente' => $pagina_actual + 1,
                'ultima_pag' => $valor_redondeado,
                'primera_pag' => 1,
                'ultimas_pag' => $valor_redondeado - 1,
                'pagina_actual' => $pagina_actual,
                'nombre_pag' => $nombre_pag,
                'nombre_get' => $nombre_get
            );

        $consecutivo = 1;
        if ($datos != null) {
            for ($i = 0; $i < count($datos); $i++) {
                $html[$i] = "<tr>
                              <th scope='row'>$consecutivo</th>
                              <td><a class='' style='' href='#' onclick='BuscarDatosContrib(" . $datos[$i]["id_contribuyente"] . ")'>" . $datos[$i]["rfc"] . "</a></td>
                              <td>" . $datos[$i]["razon_social"] . "</td>
                        </tr>";
                $consecutivo++;
            }
        }

        self::paginacion_adaptable($datos_paginacion);

        echo "<div class='py-1 container-fluid'>
          <div class='$size table-responsive'>
          <table class='table table-sm table-striped'>
          <thead>
            <tr>
              <th scope='col'>#</th>
              <th scope='col'>RFC</th>
              <th scope='col'>Contribuyente</th>
            </tr>
          </thead>
          <tbody>";
        if (isset($html)) {
            for ($i = 0; $i < count($html); $i++) {
                echo $html[$i];
            }
        } else {
            echo "<tr class='text-center'>
                  <td colspan='8'>
                    Sin medidas de ejemplaridad registradas por el momento.
                  </td>
              </tr>";
        }
        echo "</tbody>
            </table>
            </div>
          </div>
        ";
    }


    public function Condiones_query()
    {
        include_once "sesion.php";
        $jefe_directo = $_SESSION["ses_jefe_directo"];
        $id_user = $_SESSION["ses_id_usuario"];
        $perfil = $_SESSION["ses_id_perfil"];
        $id_admin = $_SESSION["ses_id_admin"];

        switch ($perfil) {
            case 2:
                $condiciones = "";
                return $condiciones;
                break;

            case 3:
                $condiciones = "AND 
                            (ent.id_empleado = $id_user)";
                return $condiciones;
                break;

            case 4:
                $condiciones = "AND 
                            (ent.id_empleado = $id_user
                            OR ent.id_empleado IN (SELECT id_empleado FROM Empleado where jefe_directo = $jefe_directo and id_admin = $id_admin)
                            OR ent.id_empleado IN (SELECT id_empleado FROM Empleado where jefe_directo in (SELECT id_empleado FROM Empleado where jefe_directo = $jefe_directo ) and id_admin = $id_admin)
                            OR ent.id_empleado IN (SELECT id_empleado FROM Empleado where id_admin = $id_admin and jefe_directo in (SELECT id_empleado FROM Empleado where jefe_directo in (SELECT id_empleado FROM Empleado where jefe_directo = $jefe_directo))))
                            AND ent.fecha_entrevista IS NULL 
                            AND ent.estatus = 'A'";
                return $condiciones;
                break;

            case 5:
                $condiciones = "AND 
                            (ent.id_empleado = $id_user
                            OR ent.id_empleado IN (SELECT id_empleado FROM Empleado where jefe_directo = $jefe_directo and id_admin = $id_admin)
                            OR ent.id_empleado IN (SELECT id_empleado FROM Empleado where jefe_directo in (SELECT id_empleado FROM Empleado where jefe_directo = $jefe_directo ) and id_admin = $id_admin)
                            OR ent.id_empleado IN (SELECT id_empleado FROM Empleado where id_admin = $id_admin and jefe_directo in (SELECT id_empleado FROM Empleado where jefe_directo in (SELECT id_empleado FROM Empleado where jefe_directo = $jefe_directo))))
                            AND ent.fecha_entrevista IS NULL 
                            AND ent.estatus = 'A'";
                return $condiciones;
                break;

            case 6:
                $condiciones = "AND 
                            (ent.id_empleado = $id_user
                            OR ent.id_empleado IN (SELECT id_empleado FROM Empleado where jefe_directo = $jefe_directo and id_admin = $id_admin)
                            OR ent.id_empleado IN (SELECT id_empleado FROM Empleado where jefe_directo in (SELECT id_empleado FROM Empleado where jefe_directo = $jefe_directo ) and id_admin = $id_admin)
                            OR ent.id_empleado IN (SELECT id_empleado FROM Empleado where id_admin = $id_admin and jefe_directo in (SELECT id_empleado FROM Empleado where jefe_directo in (SELECT id_empleado FROM Empleado where jefe_directo = $jefe_directo))))
                            AND ent.fecha_entrevista IS NULL 
                            AND ent.estatus = 'A'";
                return $condiciones;
                break;

            case 7:
                $condiciones = "";
                return $condiciones;
                break;
        }
    }

    public function paginacion_adaptable($datos)
    {
        $URL_ = "99.85.26.227:8383";
        //$URL_ = "99.85.24.8:8282";
        
        //$URL_ = "localhost:8282";

        if ($datos["pagina_actual"] > $datos["ultima_pag"]) {
            echo "<script>
                    location.href='http://$URL_/BCR_SAT/" . $datos["nombre_pag"] . ".php?" . $datos["nombre_get"] . "=" . $datos["ultima_pag"] . "'
                    </script>";
        }

        echo "
        <div class='container'>
          <nav aria-label='Page navigation example'>
            <ul class='pagination justify-content-center pagination-sm'>";
        if ($datos["pagina_actual"] <= 1) {
            echo "<li class='page-item disabled'><a class='page-link' href='" . $datos["nombre_pag"] . ".php?" . $datos["nombre_get"] . "=" . $datos["primera_pag"] . "'>Primera</a></li>
                    <li class='page-item disabled'><a class='page-link' href='" . $datos["nombre_pag"] . ".php?" . $datos["nombre_get"] . "=" . $datos["pag_anterior"] . "'>Anterior</a></li>";
        } else {
            echo "<li class='page-item'><a class='page-link' href='" . $datos["nombre_pag"] . ".php?" . $datos["nombre_get"] . "=" . $datos["primera_pag"] . "'>Primera</a></li>
                  <li class='page-item'><a class='page-link' href='" . $datos["nombre_pag"] . ".php?" . $datos["nombre_get"] . "=" . $datos["pag_anterior"] . "'>Anterior</a></li>";
        }
        $j = 0;
        if ($datos["ultima_pag"] < 10) {
            for ($i = 0; $i < $datos["ultima_pag"]; $i++) {
                $j = $i + 1;
                if ($datos["pagina_actual"] == $j) {
                    echo "<li class='page-item active'><a class='page-link' href='" . $datos["nombre_pag"] . ".php?" . $datos["nombre_get"] . "=$j'>$j</a></li>";
                } else {
                    echo "<li class='page-item'><a class='page-link' href='" . $datos["nombre_pag"] . ".php?" . $datos["nombre_get"] . "=$j'>$j</a></li>";
                }
            }
        } else {
            if ($datos["ultima_pag"] > 10) {
                if ($datos["pagina_actual"] <= 10) {
                    for ($i = 0; $i < 10; $i++) {
                        $j = $i + 1;
                        if ($datos["pagina_actual"] == $j) {
                            echo "<li class='page-item active'><a class='page-link' href='" . $datos["nombre_pag"] . ".php?" . $datos["nombre_get"] . "=$j'>$j</a></li>";
                        } else {
                            echo "<li class='page-item'><a class='page-link' href='" . $datos["nombre_pag"] . ".php?" . $datos["nombre_get"] . "=$j'>$j</a></li>";
                        }
                    }
                    $j++;
                    echo "<li class='page-item'><a class='page-link' href='" . $datos["nombre_pag"] . ".php?" . $datos["nombre_get"] . "=$j'>...</a></li>";
                } elseif ($datos["pagina_actual"] > 10 && $datos["pagina_actual"] < $datos["ultimas_pag"]) {
                    for ($i = $datos["pagina_actual"]; $i < $datos["pagina_actual"] + 10; $i++) {
                        $j = $i;
                        if ($datos["pagina_actual"] == $j) {
                            echo "<li class='page-item active'><a class='page-link' href='" . $datos["nombre_pag"] . ".php?" . $datos["nombre_get"] . "=$j'>$j</a></li>";
                        } else {
                            echo "<li class='page-item'><a class='page-link' href='" . $datos["nombre_pag"] . ".php?" . $datos["nombre_get"] . "=$j'>$j</a></li>";
                        }
                    }
                    $j++;
                    echo "<li class='page-item'><a class='page-link' href='" . $datos["nombre_pag"] . ".php?" . $datos["nombre_get"] . "=$j'>...</a></li>";
                } elseif ($datos["pagina_actual"] >= $datos["ultimas_pag"]) {
                    $j = $datos["pagina_actual"] - 1;
                    echo "<li class='page-item'><a class='page-link' href='" . $datos["nombre_pag"] . ".php?" . $datos["nombre_get"] . "=$j'>...</a></li>";
                    $j + 2;
                    for ($i = $datos["ultimas_pag"]; $i <= $datos["ultima_pag"]; $i++) {
                        $j = $i;
                        if ($datos["pagina_actual"] == $j) {
                            echo "<li class='page-item active'><a class='page-link' href='" . $datos["nombre_pag"] . ".php?" . $datos["nombre_get"] . "=$j'>$j</a></li>";
                        } else {
                            echo "<li class='page-item'><a class='page-link' href='" . $datos["nombre_pag"] . ".php?" . $datos["nombre_get"] . "=$j'>$j</a></li>";
                        }
                    }
                }
            }
        }
        if ($datos["pagina_actual"] == $datos["ultima_pag"] || $datos["pagina_actual"] > $datos["ultima_pag"]) {
            echo "<li class='page-item disabled'><a class='page-link' href='" . $datos["nombre_pag"] . ".php?" . $datos["nombre_get"] . "=" . $datos["pag_siguiente"] . "'>Siguiente</a></li>
                <li class='page-item disabled'><a class='page-link' href='" . $datos["nombre_pag"] . ".php?" . $datos["nombre_get"] . "=" . $datos["ultima_pag"] . "'>Ultima</a></li>
              </ul>
            </nav>
          </div>";
        } else {
            echo " <li class='page-item'><a class='page-link' href='" . $datos["nombre_pag"] . ".php?" . $datos["nombre_get"] . "=" . $datos["pag_siguiente"] . "'>Siguiente</a></li>
            <li class='page-item'><a class='page-link' href='" . $datos["nombre_pag"] . ".php?" . $datos["nombre_get"] . "=" . $datos["ultima_pag"] . "'>Ultima</a></li>
            </ul>
          </nav>
        </div>";
        }
    }
}
