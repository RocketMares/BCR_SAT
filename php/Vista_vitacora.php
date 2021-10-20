<?php


class Vista_vitacora
{

public function vista_general(){
include_once "sesion.php";
include_once "ConsultaContribuyentes.php";
$metodos = new ConsultaContribuyentes();
$cabeceras = $metodos->Cabecera_vistas();

$universo_de_datos = $metodos->universo_oficio();
$resultado = $universo_de_datos[0]['TOTAL'] / 20;
$oficio_por_pagina = 20;
$paginas_por_vista = ceil($resultado);
switch ($_GET) {
        case isset($_GET['pagina']):
                $num = $_GET['pagina'];
        break;
        case isset($_GET['Estructura']):
                $num = $_GET['Estructura'];
        break;
        case isset($_GET['Oficio']):
                $num = $_GET['Oficio'];
        break;
        case isset($_GET['Gestor']):
                $num = $_GET['Gestor'];
        break;
        case isset($_GET['det']):
                $num = $_GET['det'];
        break;
        case isset($_GET['Prioridad']):
                $num = $_GET['Prioridad'];
        break;
}
        if ($num==1) {
        $inicio = 1;
        $datos = $metodos->datos_tabla_oficios($inicio);
        }
        else {
        $pagina = $num-1 ;
        $inicio = ($pagina * $oficio_por_pagina) + 1;
        $datos = $metodos->datos_tabla_oficios($inicio);
        }
if (isset($datos)) {
        $cabeceras;
        echo" <tbody>";

        for ($i=0; $i < count($datos) ; $i++) { 
                $fecha_notif = $datos[$i]['fecha_notif'] != null ? $datos[$i]['fecha_notif']->format('d/m/Y') :  $fecha_notif = "Falta retroalimentar";
                $importe_his = $datos[$i]['importe_his'];
                $importe_condonado = $datos[$i]['importe_condonado'];
                $importe_recuperado = $datos[$i]['importe_recuperado'];
                $linea_captura = $datos[$i]['linea_captura'];
                $dias_alta = $datos[$i]['diferencia'];
                $respuesta = $dias_alta -48;
                if ($respuesta < 0) {
                        $filtro = 0;
                 }
                 else {
                         $filtro = $respuesta;
                 }
     
                if (!$fecha_notif && $filtro = range(96,384) || !$importe_condonado && $filtro = range(96,384) || !$importe_recuperado && $filtro = range(96,384) || !$linea_captura && $filtro = range(96,384) || !$importe_his && $filtro = range(96,384)) {
                        $color = "bg-danger";  
                }
                if ( !$fecha_notif && $filtro > 384 || !$importe_condonado && $filtro > 384 || !$importe_recuperado && $filtro > 384 || !$linea_captura && $filtro > 384 || !$importe_his && $filtro > 384) {
                        $color = "bg-secondary"; 
                } else {
                        $color = "bg-light"; 
                }
                

         echo"<tr class='$color'>
            <th scope='row'>".$datos[$i]['seq']."</th>
            <td>".$datos[$i]['Número Determinante']."</td>
            <td>".$datos[$i]['fecha_det']->format('d/m/Y')."</td>
            <td>".$datos[$i]['RFC']."</td>
            <td>".$datos[$i]['razon_social']."</td>
            <td>".$datos[$i]['Oficio Autorización']."</td> ";

            $fecha_notif = $datos[$i]['fecha_notif'] != null ? $datos[$i]['fecha_notif']->format('d-m-Y'):"En espera de Retroalimentar";
           
           
        echo"
            <td>".$fecha_notif."</td>
            <td>".$datos[$i]['Usuario']."</td>
            <td>".$datos[$i]['Departamento']."</td>
            <td> <button class= 'btn btn-dark' onclick = 'detalle_muestra(\"".$datos[$i]['id_oficio']."\");'> Info </button> </td>
            
        </tr>";
        }
       



        
      
       echo" </tbody>
        </table>

        ";

        self::pagina_responsiva($paginas_por_vista);
}
else{
        $cabeceras;
        echo" </tbody>
        </table>

        ";
       echo "<h1 class='display-4 text-center'>No hay datos</h1>";
}


}

public function pagina_responsiva($paginas_por_vista){
        

switch ($_GET) {
        case isset($_GET['pagina']):
                $page =$_GET['pagina'];
                $nombre_get = "pagina";
        break;
        case isset($_GET['Estructura']):
                $page =$_GET['Estructura'];
                $nombre_get = "Estructura";
        break;
        case isset($_GET['Oficio']):
                $page =$_GET['Oficio'];
                $nombre_get = "Oficio";
        break;
        case isset($_GET['Gestor']):
                $page =$_GET['Gestor'];
                $nombre_get = "Gestor";
        break;
        case isset($_GET['det']):
                $page =$_GET['det'];
                $nombre_get = "det";
        break;
        case isset($_GET['Prioridad']):
                $page =$_GET['Prioridad'];
                $nombre_get = "Prioridad";
        break;
}
        $pagina_responsiva = $page +10;
        $anterior = $page - 1;
        $siguiente = $page + 1;

        if ($page == 1) {
                $condicion = "disabled";
        }
        else{
                $condicion = "";
        }
        echo "<nav aria-label='Page navigation example '>
        <ul class='pagination justify-content-center'>
        <li class='page-item $condicion'><a class='page-link' href='index.php?$nombre_get=1'>Inicio</a></li>
        <li class='page-item $condicion'><a class='page-link' href='index.php?$nombre_get=".$anterior."'>anterior</a></li>";
        $k = 1;
        $m = 1;
        if ($paginas_por_vista < 10) {
     
        for ($i=0; $i < $paginas_por_vista ; $i++) { 
                if ($page == $m) {
                        $active = 'active';
                  }
                  else {
                          $active = '';
                  }
                echo"<li class='page-item $active'><a class='page-link' href='index.php?$nombre_get=".$m++."'>".$k++."</a></li>";
        }
        }
        elseif ($paginas_por_vista > 10) {
        for ($i=$page; $i < $pagina_responsiva ; $i++) { 
                echo"<li class='page-item disabled'><a class='page-link' href='index.php?$nombre_get=".$i."'>".$i."</a></li>";
                
        }
        echo"<li class='page-item disabled'><a class='page-link' href='index.php?$nombre_get=".($i + 1)."'>...</a></li>";
        } 
        if ($page == $paginas_por_vista) {
                $condicion1 = "disabled";  
        }
        else{
                $condicion1 = "";
        }
         echo" <li class='page-item $condicion1'><a class='page-link' href='index.php?$nombre_get=".$siguiente."'>siguiente</a></li>
         <li class='page-item $condicion1'><a class='page-link' href='index.php?$nombre_get=".$paginas_por_vista."'>Final</a></li>
        </ul>
      </nav>";
}

} 

?>





