<?php

class Menu
{
    public function ConsultaMenu($id_perfil, $id_padre)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL();// SE INSTANCIA LA CLASE CONEXIÓN
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        $query = "SELECT * FROM Menu_app WHERE 
        id_perfil = $id_perfil and id_padre = $id_padre
        and estatus = 'A'
         ORDER BY orden ASC";
  
        $rst = sqlsrv_query($con, $query);
        $filas[] = null;
        if ($rst) {
            while ($rows = sqlsrv_fetch_array($rst, SQLSRV_FETCH_ASSOC)) {
                $filas[] = array('id_menu' => $rows['id_menu'],'id_padre' => $rows['id_padre'],
            'orden' => $rows['orden'],'nombre_menu' => $rows['nombre_menu'],'url_menu' => $rows['url_menu'],
          'estatus' => $rows['estatus'],'Funcion' => $rows['Funcion']);
            }
            return $filas;
            $conexion->CerrarConexion($con);
        }
    }
  
    public function ConsultaMenu_Encabezados($id_perfil)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL();// SE INSTANCIA LA CLASE CONEXIÓN
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        $query = "SELECT * FROM Menu_app WHERE id_perfil = $id_perfil AND id_padre = 0
        AND estatus = 'A' ORDER BY orden ASC";
  
        $rst = sqlsrv_query($con, $query);
        if ($rst) {
            $filas[] = null;
            while ($rows = sqlsrv_fetch_array($rst, SQLSRV_FETCH_ASSOC)) {
                $filas[] = array('id_menu' => $rows['id_menu'],'id_padre' => $rows['id_padre'],
            'orden' => $rows['orden'],'nombre_menu' => $rows['nombre_menu'],'url_menu' => $rows['url_menu'],
          'estatus' => $rows['estatus'],'Funcion' => $rows['Funcion']);
            }
            return $filas;
            $conexion->CerrarConexion($con);
        }
    }
  
    public function RenderMenu($id_perfil)
    {
        $menu = self::ConsultaMenu_Encabezados($id_perfil);
        $html[] = null;
        $posicion = 0;
        $html[$posicion] = "<ul class='navbar-nav mr-auto'>";
        for ($i = 0; $i <count($menu);$i++) {
            if ($menu[$i]["estatus"] == "A") {
                $posicion++;
                $html[$posicion] ="<li class='nav-item text-white'><a class='nav-link-sat' href='". $menu[$i]['url_menu']."'>". $menu[$i]['nombre_menu']."</a></li>";
                $submenu = self::ConsultaMenu($id_perfil, $menu[$i]["id_menu"]);
                if (count($submenu)-1 !=0) {
                    $html[$posicion] = "<li class='nav-item dropdown '><a class='nav-link-sat dropdown-toggle text-white' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' href='". $menu[$i]['url_menu']."'>".$menu[$i]['nombre_menu']."</a>
            <div class='dropdown-menu' aria-labelledby='navbarDropdown'>";
                    for ($j = 0; $j<count($submenu); $j++) {
                        if ($submenu[$j]["estatus"] == "A") {
                            $posicion++;
                            $html[$posicion] = "<a class='dropdown-item-sat' href='".$submenu[$j]['url_menu'] ."'>".$submenu[$j]['nombre_menu']."</a>";
                            $subopcion = self::ConsultaMenu($id_perfil, $submenu[$j]["id_menu"]);
                            if (count($subopcion)-1 !=0) {
                                $posicion++;
                                $html[$posicion] = "<div class='dropdown-divider'></div>";
                                for ($m=0; $m <count($subopcion) ; $m++) {
                                    if ($subopcion[$m]["estatus"] == "A") {
                                        $posicion++;
                                        $html[$posicion] = "<a class='dropdown-item-sat' href='".$subopcion[$m]['url_menu'] ."'onclick='".$subopcion[$m]['Funcion'] ."'>".$subopcion[$m]['nombre_menu']."</a>";
                                    }
                                }
                                $posicion++;
                                $html[$posicion] = "<div class='dropdown-divider'></div>";
                            }
                        }
                    }
                    $posicion++;
                    $html[$posicion] = "</div>
            </li>";
                }
            }
        }
        $c = count($html);
        $html[$c]= "</ul>";
        return $html;
    }

    public function Crear_menu()
    {
        // self::Carga_individuaL();
        // self::Carga_individuaL_pagos();
        // self::Reasignacion();

        echo "<nav class='navbar navbar-expand-lg text-white  navbar-sat fixed-top' style='background:#5d2690 ;'>
             <a class='navbar-brand text-white' style='font-size:25px;' style='cursor:pointer;' id='ver' href='index.php' >BCR <img src='img\LOGO11.ico' width='50' height='50' class=d-inline-block align-top alt=''></a>
              <button class='navbar-toggler' style='color:black;' type='button'  data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
              </button>
              <div class='collapse navbar-collapse ' id='navbarSupportedContent'>";
        $html = self::RenderMenu($_SESSION['ses_id_perfil_con']);
        for ($i = 0; $i < count($html); $i++) {
            echo $html[$i];
        }

        echo "
        <a class='navbar-brand text-white' style='font-size:25px;' style='cursor:pointer;'> Bitácora de condonaciones y reducciones. </a>

               
                <ul class='navbar-nav ml-auto'>
                    <li class='nav-item dropdown'>
                      <a class='nav-link-sat dropdown-toggle'id='cerrar' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                          ".$_SESSION['ses_nombre_con']."
                      </a>
                      <div class='dropdown-menu' aria-labelledby='cerrar'>
                      <a class='dropdown-item-sat' href='#' id='CerrarSesion' >Cerrar sesión</a>
                      </div>
                    </li>
                </ul>
              </div>
            </nav>";
    }

    public function Footer()
    {
        $arreglo_nombre = explode(" ", $_SESSION["ses_nombre_con"]); // SE COMVIERTE EN ARREGLO EL NOMBRE DELIMITADO POR ESPACIOS
      $nombre = $arreglo_nombre[0];  // SE CREA EL NOMBRE CONCATENADO CON LA PRIMERA LETRA DE LA POSICIÓN 1
      echo "
      <!-- Footer inicio -->
 
        <div class='w-100 feet-page' style='padding: none;position:relative;'>
        <footer class='container-fluid py-5  text-white' style='background:#080708;'>
                <p class='float-right'><a class='text-white' href='http://99.85.26.227:8181/Comunicados/login.html'>Comunicados</a></p>
                <p>&copy; SAT. &middot; <a class='text-white' href='https://intrasat2.sat.gob.mx/'>Intrasat</a>&middot;</p>
        </footer>
        </div>
            
        <!-- Footer fin -->

          </body>
          <script src='js/jquery-3.1.1.js' ></script>
           <script src='js/popper.min.js' ></script>
         
          <script src='js/bootstrap.js'></script>
          <script src='js/bootstrap.js'></script>
          <script src='js/scripts_index.js'></script>
          <script type='text/javascript'>
            $(document).ready(function() {
              $(\"#CerrarSesion\").click(function (e) { 
                e.preventDefault();
                alert('¡Vuelva pronto $nombre!')
                location.href=\"php/cerrar_sesion.php\";
                });
            });
            </script>";
    }

    public function Menu_deslizable_principales()
    {
        echo "<div id='mySidenav' class='sidenav lead'>
              <div class=' justify-content-end'>
              <a href='javascript:void(0)'  onclick='closeNav()'><i class='fas fa-times-circle'></i></a>
              </div>
              <a href='#'><i class='fas fa-angle-double-right'></i> Acceso directo a:</a>
              <ul>
                  <li><a href='#' onclick='Pendientes_entrevista()'><i class='fas fa-comments'></i> Pendientes de entrevista</a></li>
                  <li><a href='#' onclick='Entrevistas_plazos_10()'><i class='fas fa-grin-beam-sweat'></i> Plazos 10</a></li>
                  <li><a href='#' onclick='Entrevistas_plazos_30()'><i class='fas fa-frown'></i> Plazos 30</a></li>
                  <li><a href='#' onclick='Entrevistas_fuera_plazos()'><i class='fas fa-angry'></i> Fuera de plazos</a></li>
              </ul>
          </div>";
    }

    public function Menu_deslizable_secundario()
    {
        echo "<div id='mySidenav' class='sidenav lead'>
              <div class=' justify-content-end'>
              <a href='javascript:void(0)'  onclick='closeNav()'><i class='fas fa-times-circle'></i></a>
              </div>
              <a href='#'><i class='fas fa-angle-double-right'></i> Acceso directo a:</a>
              <ul>
                  <li><a href='#' onclick='Entrevistas_activas()'><i class='fas fa-comments'></i> Entrevistas activas</a></li>
                  <li><a href='#' onclick='Entrevistas_no_activas()'><i class='fas fa-comment-dots'></i> Entrevistas no activas</a></li>
              </ul>
            </div>";
    }
    public function Carga_individuaL()
    {
        echo "
        <div class='modal fade' id='Carga_contri' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true' style='overflow-y: scroll;'>
          <div class='modal-dialog modal-dialog-centered modal-lg' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title' id='exampleModalLabel'>Carga de Contribuyente.</h5>
                <button type='button' id='ventana' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>
                <ul>
                <li class='h5'>
                  <p>Registrar Contribuyente</p>
                </li>
                </ul>
                <div class='form-row'>
                  <div class='form-group col-md-4'>
                    <label for='RFC'>RFC :<samp class='text-danger'>*</samp></label>
                    <input type='text' class='form-control input-sm' id='RFC' name='RFC' placeholder='XXXX4548' maxlength='13'>
                  </div>
                  <div class='form-group col-md-4'>
                  <label for='RFC'>No. Oficio :<samp class='text-danger'>*</samp></label>
                  <input type='text' class='form-control input-sm' id='oficio' name='oficio' placeholder='' maxlength='20'>
                </div>
                  <div class='form-group col-md-4'>
                    <label for='Fecha_Prog'>Fecha Programada:<samp class='text-danger'>*</samp></label>
                    <input type='text' class='form-control' id='Fecha_Prog' name='Fecha_Prog' placeholder='dd/mm/yyy'>
                  </div>
                  <div class='form-group col-md-12'>
                    <label for='Razon_Social'>Razon Social :<samp class='text-danger'>*</samp></label>
                    <input type='text' class='form-control input-sm' id='Rason_Social' name='Razon_social' placeholder='NOMBRE´S S.A. de C.V.' maxlength='50'>
                  </div>
                  <div class='form-group col-md-4'>
                  <label for='Fecha_vig'>Fecha Vigencia:<samp class='text-danger'>*</samp></label>
                  <input type='text' class='form-control' id='Fecha_vig' name='Fecha_vig' placeholder='dd/mm/yyy'>
                </div>
                  <div class='form-group col-md-4'>
                    <label for='Prioridad'>Prioridad:<samp class='text-danger'>*</samp></label>
                    <select class='custom-select' id='Prioridad' name='Prioridad' >
                      <option value='0'>Seleccionar opción</option>
                      <option value='1'>NORMAL</option></option>
                      <option value='2'>URGENTE</option></option>
                      <option value='3'>EXTRAURGENTE</option></option>
                     </select>
                  </div>
                  <div class='form-group col-md-4'>
                  <label for='No_empleado'>No. Empleado :<samp class='text-danger'>*</samp></label>
                  <input type='text' class='form-control input-sm' id='no_empleado' name='No_empleado' placeholder='101822' maxlength='6'>
                </div>
                </div>

            </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                <button type='button' class='btn btn-outline-success' id='btn_confirmar1' onclick='confirmar_contri()'>Confirmar aplicación</button>
              </div>
            </div>
          </div>
        </div>
  
        <div class='modal fade' id='confirmar_contri' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered' role='document'>
              <div class='modal-content'>
                <div class='modal-header'>
                  <h5 class='modal-title' id='exampleModalLabel'>Confirmar Carga de Contribuyente</h5>
                  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                  </button>
                </div>
                <div class='modal-body'>
                  ¿Seguro que desea cargar al contribuyente?
                </div>
                <div class='modal-footer'>
                  <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                  <button type='button' class='btn btn-outline-success' onclick='Caraga_individual_contri()'>Confirmar aplicación</button>
                </div>
              </div>
            </div>
          </div>
        
        ";
    }

    // public function Carga_individuaL_pagos()
    // {
    //     include_once 'ConsultaContribuyentes.php';
    //     $busca= new ConsultaContribuyentes();
    //     $valores=$busca->Consulta_region();
      
    //     echo "
    //     <div class='modal fade' id='Carga_pago' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true' style='overflow-y: scroll;'>
    //       <div class='modal-dialog modal-dialog-centered modal-lg' role='document'>
    //         <div class='modal-content'>
    //           <div class='modal-header'>
    //             <h5 class='modal-title' id='exampleModalLabel'>Carga de Pagos.</h5>
    //             <button type='button' id='ventana' class='close' data-dismiss='modal' aria-label='Close'>
    //               <span aria-hidden='true'>&times;</span>
    //             </button>
    //           </div>
    //           <div class='modal-body'>
    //             <ul>
    //             <li class='h5'>
    //               <p>Registrar Pago</p>
    //             </li>
    //             </ul>
    //             <div class='form-row'>
    //               <div class='form-group col-md-4'>
    //                 <label for='RFC1'>RFC :<samp class='text-danger'>*</samp></label>
    //                 <input type='text' class='form-control input-sm' id='RFC1' name='RFC1' placeholder='XXXX4548' maxlength='13'>
    //               </div>                  
    //               <div class='form-group col-md-4'>
    //                 <label for='Periodo_Req'>Periodo Requerido :<samp class='text-danger'>*</samp></label>
    //                 <select class='custom-select' id='Periodo_Req' name='Periodo_Req' >
    //                   <option selected value='0'>Seleccionar opción</option>
    //                   <option value='1'>1<option></option>
    //                   <option value='2'>2<option></option>
    //                   <option value='3'>3<option></option>
    //                   <option value='4'>4<option></option>
    //                   <option value='5'>5<option></option>
    //                   <option value='6'>6<option></option>
    //                   <option value='7'>7<option></option>
    //                   <option value='8'>8<option></option>
    //                   <option value='9'>9<option></option>
    //                   <option value='10'>10<option></option>
    //                   <option value='11'>11<option></option>
    //                   <option value='12'>12<option></option>
    //                  </select>
    //               </div>

    //               <div class='form-group col-md-4'>
    //                 <label for='Ejercicio_Req'>Ejercicio Requerido :<samp class='text-danger'>*</samp></label>
    //                 <input type='text' class='form-control input-sm' id='Ejercicio_Req' name='Ejercicio_Req' placeholder='Ej 2019..' maxlength='50'>
    //               </div>
    //               <div class='form-group col-md-4'>
    //                 <label for='Fecha_pago'>Fecha de Presentación:<samp class='text-danger'>*</samp></label>
    //                 <input type='text' class='form-control' id='Fecha_pago' name='Fecha_pago' placeholder='dd/mm/yyy'>
    //               </div>
    //               <div class='form-group col-md-4'>
    //                 <label for='Llave'>Llave de transacción :<samp class='text-danger'>*</samp></label>
    //                 <input type='text' class='form-control input-sm' id='Llave' name='Llave' placeholder='40019-123456-1' maxlength='20'>
    //               </div>
                    
    //               <div class='form-group col-md-4'>
    //                 <label for='Renglon'>Renglón: <samp class='text-danger'>*</samp></label>
    //                 <select class='custom-select' id='Renglon' name='Renglon' value='0' >
    //                   <option selected value='0'>Seleccionar opción</option>
    //                   ";
    //     if ($valores != null) {
    //         for ($i=0; $i < count($valores) ; $i++) {
    //             echo "<option value='".$valores[$i]['id_renglon']."'>".$valores[$i]['desc_renglon']."</option>";
    //         }
    //         echo"</select>
    //               </div>
    //               <div class='form-group col-md-4'>
    //               <label for='Importe_Efectivo'>Importe Efectivo :<samp class='text-danger'>*</samp></label>
    //               <input type='text' class='form-control input-sm' id='Importe_Efectivo' name='Importe_Efectivo' placeholder='$00.00' maxlength='20'>
    //             </div>
    //             <div class='form-group col-md-4'>
    //             <label for='Virtual'>Virtual :<samp class='text-danger'></samp></label>
    //             <input type='text' class='form-control input-sm' id='Virtual' name='Virtual' placeholder='$00.00' maxlength='20' VALUE=0>
    //           </div>
    //             </div>

              




    //             <div id='result'>
  
    //             </div>
    //         </div>
    //           <div class='modal-footer'>
    //             <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
    //             <button type='button' class='btn btn-outline-success' id='btn_confirmar' onclick='confirmar_pago()'>Confirmar aplicación</button>
    //           </div>
    //         </div>
    //       </div>
    //     </div>
  
    //     <div class='modal fade' id='confirmar_pago' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    //         <div class='modal-dialog modal-dialog-centered' role='document'>
    //           <div class='modal-content'>
    //             <div class='modal-header'>
    //               <h5 class='modal-title' id='exampleModalLabel'>Confirmar Carga de Pago</h5>
    //               <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
    //                 <span aria-hidden='true'>&times;</span>
    //               </button>
    //             </div>
    //             <div class='modal-body'>
    //               ¿Seguro que desea registrar el pago?
    //             </div>
    //             <div class='modal-footer'>
    //               <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
    //               <button type='button' class='btn btn-outline-success' onclick='Caraga_individual_pago()'>Confirmar Pago</button>
    //             </div>
    //           </div>
    //         </div>
    //       </div>
        
    //     ";
    //     }
    // }
    // public function Reasignacion()
    // {
    //     echo "


    //     <div class='modal fade-long' id='Reasigna_analista' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true' style='overflow-y: scroll;'>
    //       <div class='modal-dialog modal-dialog-centered modal-lg' role='document'>
    //         <div class='modal-content'>
    //           <div class='modal-header'>
    //             <h5 class='modal-title' id='exampleModalLabel'>Reasignacion de Entrevista</h5>
    //             <button type='button' id='ventana' class='close' data-dismiss='modal' aria-label='Close'>
    //               <span aria-hidden='true'>&times;</span>
    //             </button>
    //           </div>
    //           <div class='modal-body'>

    //             <div class='row'>
    //               <div class='col-md-4'>
    //                 <label for='entrevista'>No. Entrevista :<samp class='text-danger'>*</samp></label>
    //                 <input type='number' class='form-control input-sm' id='Entrevista' name='entrevista' placeholder='No.Entrevista' maxlength='13'>
    //             </div>
    //             <div class='col-md-8 ml-auto'>
    //               <div id='res'></div>
    //               </div> 
    //             </div>

    //             <div class='row'>
    //               <div class='col-md-4'>
    //                 <label for='N_analista'>Nuevo Analista :<samp class='text-danger'>*</samp></label>
    //                 <input type='number' class='form-control input-sm' id='Analista' name='Analista' placeholder='No.Empleado' maxlength='13'>
    //             </div>
    //             <div class='col-md-8 ml-auto'>
    //               <div id='res2'></div>
    //               </div> 
    //             </div>
    //           </div>
    //           <div id='result'>
  
    //           </div>
    //           <div class='modal-footer'>
    //             <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
    //             <button type='button' class='btn btn-outline-success' id='btn_confirmar' onclick='confirmar_reasignacion()'>Confirmar Reasignacion</button>
    //           </div>
    //         </div>
    //       </div>
    //     </div>
    //     </div>
  
    //     <div class='modal fade' id='confirmar_reasignacion' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    //         <div class='modal-dialog modal-dialog-centered' role='document'>
    //           <div class='modal-content'>
    //             <div class='modal-header'>
    //               <h5 class='modal-title' id='exampleModalLabel'>Confirmar reasignacion</h5>
    //               <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
    //                 <span aria-hidden='true'>&times;</span>
    //               </button>
    //             </div>
    //             <div class='modal-body'>
    //               ¿Seguro que desea confirmar la reasignacion?
    //             </div>
    //             <div class='modal-footer'>
    //               <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
    //               <button type='button' class='btn btn-outline-success' onclick='reasignar()'>Confirmar Reasignacion</button>
    //             </div>
    //           </div>
    //         </div>
    //       </div>
        
    //     ";
    //     }
}
