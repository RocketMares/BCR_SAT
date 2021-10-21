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


    /*
   * Se comvierte a arreglo la cadena formada por el numero
   * de oficio y luego lo unico que se devuelve es el concecutivo
   * esto para poder editar ya sea solo todo el numero de oficio
   * o unicamente el número concecutivo. 
   */

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
   
      
        $URL_ = "localhost:8282";

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
