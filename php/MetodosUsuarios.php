<?php

class MetodosUsuarios
{
  public function Consulta_situacion($id_obj)
  {
    include_once 'sesion.php';
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT DISTINCT [Id_situación ],Situacion FROM Situaciones WHERE id_objeto=$id_obj ORDER BY Situacion ASC";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $fila[] = $row;
      }
      if (isset($fila)) {
        return $fila;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }
  public function consulta_admin()
  {
    include_once 'sesion.php';
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT * FROM Administracion WHERE estatus = 'A' ORDER BY nombre_admin ASC";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $fila[] = $row;
      }
      if (isset($fila)) {
        return $fila;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }
  public function Consulta_etapa($id_situacion)
  {
 
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT DISTINCT Id_situación , Clave_etapa, Nombre_de_etapa FROM Situaciones WHERE Id_situación = $id_situacion ORDER BY Nombre_de_etapa ASC";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $fila[] = $row;
      }
      if (isset($fila)) {
        return $fila;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }
  public function ConsultaAsistenciasHoy($id_admin)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = " SELECT DISTINCT
      Emp.nombre_empleado
      ,(SELECT rfc_corto FROM Empleado WHERE nombre_empleado = Emp.nombre_empleado ) AS RFC
      ,(SELECT TOP (1) MIN(Fecha_ini) FROM Registro_session WHERE id_empleado = Emp.id_empleado AND DAY(Fecha_ini)= DAY(GETDATE()) ) AS Fecha_Ini  
      ,(SELECT TOP (1) MAX(Fecha_fin) FROM Registro_session WHERE id_empleado = Emp.id_empleado AND DAY(Fecha_fin)= DAY(GETDATE()) ) AS Fecha_fin 
      ,ip_recep_ini
      FROM Registro_session Reg
      INNER JOIN Empleado Emp ON Reg.id_empleado = Emp.id_empleado
       WHERE DAY(Fecha_ini)= DAY(GETDATE()) AND Emp.id_admin =$id_admin";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      //SE DISPONE LA CONSULTA COMO UN ARREGLO
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $em = $row["nombre_empleado"];
        $rfc = $row["RFC"];
        $fecha_ini = ($row["Fecha_Ini"] == null) ?  "-" : $row["Fecha_Ini"]->format("Y/m/d H:i:s");
        $fecha_fin = ($row["Fecha_fin"] == null) ? "-" : $row["Fecha_fin"]->format("Y/m/d H:i:s");

        $filas[] = array(
          'Nombre' => $em,
          'rfc_corto' => $rfc,
          'Hora_inicio' => $fecha_ini,
          'Hora_Fin' => $fecha_fin,
          'IP_ubicación' => $row["ip_recep_ini"]
        );
        //$filas[] = array('Asistencia' => 1);
      }
      if (isset($filas)) {
        return $filas;
      } else {
        return null;
      }
      sqlsrv_close($con);
    } else {
      return sqlsrv_errors();
      sqlsrv_close($con);
    }
  }
  public function Reg_SES()
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    session_start();
    $empleado = $_SESSION["ses_id_usuario"];
    $query =
      "  Insert into Registro_session (
      [id_empleado]
      ,[Fecha_ini]
      ,[ip_recep_ini])
      values($empleado,
      GETDATE(),
      '" . $_SERVER['REMOTE_ADDR'] . "') 
       SELECT SCOPE_IDENTITY() as id_sess";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      sqlsrv_next_result($prepare);
      sqlsrv_fetch($prepare);
      $fila = array('id_sess' => sqlsrv_get_field($prepare, 0));
      if ($fila["id_sess"] != null) {
        return $fila;
      } else {
        return print_r(sqlsrv_errors(), true);
      }
    }
  }
  
  public function Registro_fin_sesion()
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    session_destroy();
    $id = $_SESSION["ses_id_sess"];
    $query = "update Registro_session set Fecha_fin=GETDATE() where id_session = $id ";
    // se ingresa la conexi�n, el query, y los parametros
    $rst = sqlsrv_query($con, $query);

    if ($rst === false) {
      return sqlsrv_errors();
    }
  }
  public function Consulta_User_Existe($rfc_corto)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT * FROM Empleado WHERE rfc_corto ='$rfc_corto' AND estatus = 'A'";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $fila = $row;
      }
      if (isset($fila)) {
        return $fila;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }
  public function Busca_RFC_corto($Emp_camb)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT * FROM Empleado WHERE nombre_empleado = '$Emp_camb'  AND estatus = 'A'";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $fila[] = $row;
      }
      if (isset($fila)) {
        return $fila;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }
  public function Busca_nombre_procesos_deptos($id_depto)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT  
    dep.nombre_depto
    FROM Departamento dep
    WHERE id_depto = $id_depto";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $fila[] = $row;
      }
      if (isset($fila)) {
        return $fila;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }
  public function Consulta_nombre_user($rfc_corto)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT nombre_empleado FROM Empleado WHERE rfc_corto ='$rfc_corto' AND estatus = 'A'";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $fila = $row['nombre_empleado'];
      }
      if (isset($fila)) {
        return $fila;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }
  public function Consulta_usuarios()
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT  DISTINCT
    det.id_empleado,
    emp.no_empleado,
    emp.rfc_corto,
    emp.nombre_empleado
    FROM Determinante det
    INNER JOIN Empleado emp ON det.id_empleado = emp.id_empleado 
    WHERE emp.estatus = 'A' Order By emp.nombre_empleado asc";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return $filas;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }
  public function Consulta_usuarios_2()
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT  DISTINCT *
    FROM [Empleado] emp
    WHERE emp.estatus = 'A'  Order By emp.nombre_empleado asc";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return $filas;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }
  public function Consulta_usuarios_BUSQ($nombre)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "  SELECT [id_empleado], [nombre_empleado] FROM [Empleado] WHERE nombre_empleado like '%$nombre%' AND estatus = 'A' Order By nombre_empleado asc";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return $filas;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }
  public function Consulta_nombre_puesto($rfc_corto)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT 
    p.nombre_puesto
    FROM Empleado Emp 
    INNER JOIN Puesto P ON Emp.id_puesto = p.id_puesto
    WHERE rfc_corto ='$rfc_corto' AND Emp.estatus = 'A'";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $fila = $row['nombre_empleado'];
      }
      if (isset($fila)) {
        return $fila;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }
  public function Consulta_Cat_Jefes($id_admin)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT * FROM Empleado 
                WHERE id_admin = " . $id_admin . " 
                AND id_puesto in (2,3,4,5) 
                AND estatus = 'A'";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $fila[] = $row;
      }
      if (isset($fila)) {
        return $fila;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }

  public function Consulta_Datos_Usere($id_usuario)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT *,
                  (SELECT nombre_empleado FROM Empleado where id_empleado = jefe_directo) as nombre_jefe
                  FROM Empleado 
                  WHERE id_empleado = $id_usuario ";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $fila = $row;
      }
      if (isset($fila)) {
        return $fila;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }

  public function Valida_Admin_Activo($id_admin)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT * FROM Administracion WHERE id_admin ='$id_admin' AND estatus = 'A'";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $fila = $row;
      }
      if (isset($fila)) {
        return true;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }
  public function Valida_Responsiva_firmada($emp)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT responsiva FROM Empleado WHERE id_empleado =$emp AND estatus = 'A'";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $fila = $row;
      }
      if (isset($fila)) {
        return true;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }
  public function Valida_Subadmin_Activo($id_sub_admin)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT * FROM SubAdmin WHERE id_sub_admin ='$id_sub_admin' AND estatus = 'A'";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $fila = $row;
      }
      if (isset($fila)) {
        return true;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }

  public function Consulta_Subadmin($id_admin)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT * FROM SubAdmin WHERE id_admin = $id_admin AND estatus = 'A'";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $fila[] = $row;
      }
      if (isset($fila)) {
        return $fila;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }

  public function Consulta_Depto($id_admin)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT * FROM Departamento WHERE id_admin = $id_admin AND estatus = 'A'";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $fila[] = $row;
      }
      if (isset($fila)) {
        return $fila;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }
  public function Consulta_Depto_oficio($id_admin,$sub)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT * FROM Departamento WHERE id_admin = $id_admin AND id_sub_admin = $sub AND estatus = 'A'";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $fila[] = $row;
      }
      if (isset($fila)) {
        return $fila;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }

  public function Consulta_Depto_sub($id_sub)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT * FROM Departamento 
        WHERE id_sub_admin = $id_sub AND estatus = 'A'
        ORDER BY nombre_depto";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $fila[] = $row;
      }
      if (isset($fila)) {
        return $fila;
        $conexion->CerrarConexion($con);
      } else {
        return print_r(sqlsrv_errors(), true);
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }

  public function Consulta_Puestos()
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT * FROM Puesto WHERE estatus = 'A'";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $fila[] = $row;
      }
      if (isset($fila)) {
        return $fila;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }

  public function Valida_Dep_Activo($id_depto)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT * FROM Departamento WHERE id_depto ='$id_depto' AND estatus = 'A'";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $fila = $row;
      }
      if (isset($fila)) {
        return true;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }

  public function Valida_Perfil_Activo($id_perfil)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT * FROM Perfil WHERE id_perfil ='$id_perfil' AND estatus = 'A'";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $fila = $row;
      }
      if (isset($fila)) {
        return true;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }

  public function Encriptado_Passwd($password)
  {
    $passwd = md5($password);
    return $passwd;
  }

  public function CambiarContrasenaUser($user, $pass)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();

    $query = "UPDATE Empleado SET passwd = '$pass' 
      WHERE no_empleado = $user";
    $con = $conexion->ObtenerConexionBD();
    $prepare = sqlsrv_query($con, $query);
    if ($prepare == false) {
      return false;
    }
  }

  public function CambiarContrasenaUser_ses($user, $pass)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();

    $query = "UPDATE Empleado SET passwd = '$pass' 
      WHERE id_empleado = $user";
    $con = $conexion->ObtenerConexionBD();
    $prepare = sqlsrv_query($con, $query);
    if ($prepare == false) {
      return false;
    }
  }

  public function Consulta_user_exist($no_empleado)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
    //SE CREA UN QUERY
    $query = "SELECT * FROM Empleado WHERE (no_empleado = $no_empleado)";
  //  $query = "SELECT * FROM Empleado WHERE (no_empleado = $no_empleado) AND (estatus = 'A') ";
    //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
    $con = $conexion->ObtenerConexionBD();
    //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas = array('id_empleado' => $row["id_empleado"]);
      }
      if (isset($filas)) {
        return $filas;
      } else {
        return false;
      }
      $conexion->CerrarConexion($con);
    } else {
      return false;
    }
  }

  public function Consulta_user_exist2($no_empleado)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
    //SE CREA UN QUERY
    $query = "SELECT * FROM Empleado WHERE (no_empleado = $no_empleado) AND (estatus = 'A') ";
    //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
    $con = $conexion->ObtenerConexionBD();
    //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas = array('id_empleado' => $row["id_empleado"]);
      }
      if (isset($filas)) {
        return true;
      } else {
        return false;
      }
      $conexion->CerrarConexion($con);
    } else {
      return false;
    }
  }
  public function Consulta_usuarios_pag_num($id_admin)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "		SELECT SUB.seq,
    sub.rfc_corto,
    sub.no_empleado,
    sub.nombre_empleado,
    sub.correo,
    sub.id_admin,
    lo.nombre_admin,
    sub.id_sub_admin,
    area.nombre_sub_admin,
    sub.id_depto,
    depa.nombre_depto,
    case 
      WHEN (sub.estatus = 'A') THEN 'ACTIVO'
      ELSE 'NO ACTIVO'
    END AS estatus,
    case 
      WHEN (sub.responsiva = 0) THEN 'PENDIENTE'
      ELSE 'FIRMADA'
    END AS responsiva
    FROM (SELECT ROW_NUMBER() OVER(ORDER BY (fecha_alta) DESC) AS seq,
      * FROM Empleado) AS sub 
      INNER JOIN Administracion lo on lo.id_admin = sub.id_admin
      INNER JOIN SubAdmin area on area.id_sub_admin = sub.id_sub_admin
      INNER JOIN Departamento depa on depa.id_depto = sub.id_depto
    WHERE sub.id_admin = $id_admin
    ORDER BY (sub.fecha_alta) DESC";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return count($filas);
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return sqlsrv_errors();
      $conexion->CerrarConexion($con);
    }
  }
  public function Consulta_empleado()
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT 
    sub.rfc_corto,
    sub.no_empleado,
    sub.nombre_empleado,
    sub.correo,
    sub.id_admin,
    lo.nombre_admin,
    sub.id_sub_admin,
    area.nombre_sub_admin,
    sub.id_depto,
    depa.nombre_depto
    FROM Empleado AS sub 
    INNER JOIN Administracion lo on lo.id_admin = sub.id_admin
    INNER JOIN SubAdmin area on area.id_sub_admin = sub.id_sub_admin
    INNER JOIN Departamento depa on depa.id_depto = sub.id_depto
    WHERE sub.estatus = 'A'
    ORDER BY (sub.fecha_alta) DESC";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return count($filas);
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return sqlsrv_errors();
      $conexion->CerrarConexion($con);
    }
  }
  public function Consulta_usuarios_pag($id_admin, $numero)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT TOP 50 
        SUB.seq,
        sub.id_empleado,
        sub.rfc_corto,
        sub.no_empleado,
        sub.nombre_empleado,
        sub.correo,
        sub.id_admin,
        lo.nombre_admin,
        sub.id_sub_admin,
        area.nombre_sub_admin,
        sub.id_depto,
        depa.nombre_depto,
        sub.id_perfil,
        per.nombre_perfil,
        pue.id_puesto,
        pue.nombre_puesto,
        case 
          WHEN (sub.estatus = 'A') THEN 'ACTIVO'
          ELSE 'NO ACTIVO'
        END AS estatus,
        case 
          WHEN (sub.responsiva = 0) THEN 'PENDIENTE'
          ELSE 'FIRMADA'
        END AS responsiva
        FROM (SELECT ROW_NUMBER() OVER(ORDER BY (fecha_alta) DESC) AS seq,
          * FROM Empleado) AS sub 
          INNER JOIN Administracion lo on lo.id_admin = sub.id_admin
          INNER JOIN SubAdmin area on area.id_sub_admin = sub.id_sub_admin
          INNER JOIN Departamento depa on depa.id_depto = sub.id_depto
		  INNER JOIN Puesto pue on pue.id_puesto = sub.id_puesto
          INNER JOIN Perfil per on per.id_perfil = sub.id_perfil
        WHERE sub.seq >= $numero
        AND sub.id_admin = $id_admin";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return $filas;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return sqlsrv_errors();
      $conexion->CerrarConexion($con);
    }
  }

  public function Consulta_Perfiles()
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
    //SE CREA UN QUERY
    $query = "SELECT * FROM Perfil ORDER BY nombre_perfil ASC";
    //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
    $con = $conexion->ObtenerConexionBD();
    //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
    $prepare = sqlsrv_query($con, $query);

    if ($prepare) {
      //SE DISPONE LA CONSULTA COMO UN ARREGLO
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      return $filas;
      sqlsrv_close($con);
    } else {
      print_r(sqlsrv_errors(), true);
      sqlsrv_close($con);
    }
  }

  public function Consulta_usuarios_nombre_pag_num($id_admin, $nombre)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT SUB.seq,
        sub.rfc_corto,
        sub.no_empleado,
        sub.nombre_empleado,
        sub.correo,
        sub.id_admin,
        lo.nombre_admin,
        sub.id_sub_admin,
        area.nombre_sub_admin,
        sub.id_depto,
        depa.nombre_depto,
        case 
          WHEN (sub.estatus = 'A') THEN 'ACTIVO'
          ELSE 'NO ACTIVO'
        END AS estatus,
        case 
          WHEN (sub.responsiva = 0) THEN 'PENDIENTE'
          ELSE 'FIRMADA'
        END AS responsiva
        FROM (SELECT ROW_NUMBER() OVER(ORDER BY (fecha_alta) DESC) AS seq,
          * FROM Empleado) AS sub 
          INNER JOIN Administracion lo on lo.id_admin = sub.id_admin
          INNER JOIN SubAdmin area on area.id_sub_admin = sub.id_sub_admin
          INNER JOIN Departamento depa on depa.id_depto = sub.id_depto
        WHERE sub.id_admin = $id_admin
        AND sub.nombre_empleado like '%$nombre%' COLLATE SQL_Latin1_General_CP1_CI_AI
        ORDER BY (sub.fecha_alta) DESC";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return count($filas);
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return sqlsrv_errors();
      $conexion->CerrarConexion($con);
    }
  }

  public function Consulta_usuarios_nombre_sub_pag_num($id_admin, $id_sub_admin, $nombre)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT SUB.seq,
        sub.rfc_corto,
        sub.no_empleado,
        sub.nombre_empleado,
        sub.correo,
        sub.id_admin,
        lo.nombre_admin,
        sub.id_sub_admin,
        area.nombre_sub_admin,
        sub.id_depto,
        depa.nombre_depto,
        case 
          WHEN (sub.estatus = 'A') THEN 'ACTIVO'
          ELSE 'NO ACTIVO'
        END AS estatus,
        case 
          WHEN (sub.responsiva = 0) THEN 'PENDIENTE'
          ELSE 'FIRMADA'
        END AS responsiva
        FROM (SELECT ROW_NUMBER() OVER(ORDER BY (fecha_alta) DESC) AS seq,
          * FROM Empleado) AS sub 
          INNER JOIN Administracion lo on lo.id_admin = sub.id_admin
          INNER JOIN SubAdmin area on area.id_sub_admin = sub.id_sub_admin
          INNER JOIN Departamento depa on depa.id_depto = sub.id_depto
        WHERE sub.id_admin = $id_admin
        and sub.id_sub_admin = $id_sub_admin
        AND sub.nombre_empleado like '%$nombre%' COLLATE SQL_Latin1_General_CP1_CI_AI
        ORDER BY (sub.fecha_alta) DESC";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return count($filas);
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return sqlsrv_errors();
      $conexion->CerrarConexion($con);
    }
  }

  public function Consulta_usuarios_nombre_sub_dep_pag_num($id_admin, $id_sub_admin, $id_depto, $nombre)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT SUB.seq,
        sub.rfc_corto,
        sub.no_empleado,
        sub.nombre_empleado,
        sub.correo,
        sub.id_admin,
        lo.nombre_admin,
        sub.id_sub_admin,
        area.nombre_sub_admin,
        sub.id_depto,
        depa.nombre_depto,
        case 
          WHEN (sub.estatus = 'A') THEN 'ACTIVO'
          ELSE 'NO ACTIVO'
        END AS estatus,
        case 
          WHEN (sub.responsiva = 0) THEN 'PENDIENTE'
          ELSE 'FIRMADA'
        END AS responsiva
        FROM (SELECT ROW_NUMBER() OVER(ORDER BY (fecha_alta) DESC) AS seq,
          * FROM Empleado) AS sub 
          INNER JOIN Administracion lo on lo.id_admin = sub.id_admin
          INNER JOIN SubAdmin area on area.id_sub_admin = sub.id_sub_admin
          INNER JOIN Departamento depa on depa.id_depto = sub.id_depto
        WHERE sub.id_admin = $id_admin
        AND sub.id_sub_admin = $id_sub_admin
        AND sub.id_depto = $id_depto
        AND sub.nombre_empleado like '%$nombre%' COLLATE SQL_Latin1_General_CP1_CI_AI
        ORDER BY (sub.fecha_alta) DESC";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return count($filas);
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return sqlsrv_errors();
      $conexion->CerrarConexion($con);
    }
  }

  public function Consulta_usuarios_nombre_sub_dep_per_pag_num($id_admin, $id_sub_admin, $id_depto, $id_perfil, $nombre)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT SUB.seq,
        sub.rfc_corto,
        sub.no_empleado,
        sub.nombre_empleado,
        sub.correo,
        sub.id_admin,
        lo.nombre_admin,
        sub.id_sub_admin,
        area.nombre_sub_admin,
        sub.id_depto,
        depa.nombre_depto,
        case 
          WHEN (sub.estatus = 'A') THEN 'ACTIVO'
          ELSE 'NO ACTIVO'
        END AS estatus,
        case 
          WHEN (sub.responsiva = 0) THEN 'PENDIENTE'
          ELSE 'FIRMADA'
        END AS responsiva
        FROM (SELECT ROW_NUMBER() OVER(ORDER BY (fecha_alta) DESC) AS seq,
          * FROM Empleado) AS sub 
          INNER JOIN Administracion lo on lo.id_admin = sub.id_admin
          INNER JOIN SubAdmin area on area.id_sub_admin = sub.id_sub_admin
          INNER JOIN Departamento depa on depa.id_depto = sub.id_depto
        WHERE sub.id_admin = $id_admin
        AND sub.id_sub_admin = $id_sub_admin
        AND sub.id_depto = $id_depto
        AND sub.id_perfil = $id_perfil
        AND sub.nombre_empleado like '%$nombre%' COLLATE SQL_Latin1_General_CP1_CI_AI
        ORDER BY (sub.fecha_alta) DESC";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return count($filas);
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return sqlsrv_errors();
      $conexion->CerrarConexion($con);
    }
  }

  public function Consulta_usuarios_sub_pag_num($id_sub_admin)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT SUB.seq,
        sub.rfc_corto,
        sub.no_empleado,
        sub.nombre_empleado,
        sub.correo,
        sub.id_admin,
        lo.nombre_admin,
        sub.id_sub_admin,
        area.nombre_sub_admin,
        sub.id_depto,
        depa.nombre_depto,
        case 
          WHEN (sub.estatus = 'A') THEN 'ACTIVO'
          ELSE 'NO ACTIVO'
        END AS estatus,
        case 
          WHEN (sub.responsiva = 0) THEN 'PENDIENTE'
          ELSE 'FIRMADA'
        END AS responsiva
        FROM (SELECT ROW_NUMBER() OVER(ORDER BY (fecha_alta) DESC) AS seq,
          * FROM Empleado) AS sub 
          INNER JOIN Administracion lo on lo.id_admin = sub.id_admin
          INNER JOIN SubAdmin area on area.id_sub_admin = sub.id_sub_admin
          INNER JOIN Departamento depa on depa.id_depto = sub.id_depto
        WHERE sub.id_sub_admin = $id_sub_admin
        ORDER BY (sub.fecha_alta) DESC";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return count($filas);
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return sqlsrv_errors();
      $conexion->CerrarConexion($con);
    }
  }

  public function Consulta_usuarios_perfil_pag_num($id_perfil)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT SUB.seq,
        sub.rfc_corto,
        sub.no_empleado,
        sub.nombre_empleado,
        sub.correo,
        sub.id_admin,
        lo.nombre_admin,
        sub.id_sub_admin,
        area.nombre_sub_admin,
        sub.id_depto,
        depa.nombre_depto,
        case 
          WHEN (sub.estatus = 'A') THEN 'ACTIVO'
          ELSE 'NO ACTIVO'
        END AS estatus,
        case 
          WHEN (sub.responsiva = 0) THEN 'PENDIENTE'
          ELSE 'FIRMADA'
        END AS responsiva
        FROM (SELECT ROW_NUMBER() OVER(ORDER BY (fecha_alta) DESC) AS seq,
          * FROM Empleado) AS sub 
          INNER JOIN Administracion lo on lo.id_admin = sub.id_admin
          INNER JOIN SubAdmin area on area.id_sub_admin = sub.id_sub_admin
          INNER JOIN Departamento depa on depa.id_depto = sub.id_depto
        WHERE sub.id_sub_admin = $id_perfil
        ORDER BY (sub.fecha_alta) DESC";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return count($filas);
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return sqlsrv_errors();
      $conexion->CerrarConexion($con);
    }
  }

  public function Consulta_usuarios_sub_dep_pag_num($id_sub_admin, $id_depto)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT SUB.seq,
        sub.rfc_corto,
        sub.no_empleado,
        sub.nombre_empleado,
        sub.correo,
        sub.id_admin,
        lo.nombre_admin,
        sub.id_sub_admin,
        area.nombre_sub_admin,
        sub.id_depto,
        depa.nombre_depto,
        case 
          WHEN (sub.estatus = 'A') THEN 'ACTIVO'
          ELSE 'NO ACTIVO'
        END AS estatus,
        case 
          WHEN (sub.responsiva = 0) THEN 'PENDIENTE'
          ELSE 'FIRMADA'
        END AS responsiva
        FROM (SELECT ROW_NUMBER() OVER(ORDER BY (fecha_alta) DESC) AS seq,
          * FROM Empleado) AS sub 
          INNER JOIN Administracion lo on lo.id_admin = sub.id_admin
          INNER JOIN SubAdmin area on area.id_sub_admin = sub.id_sub_admin
          INNER JOIN Departamento depa on depa.id_depto = sub.id_depto
        WHERE sub.id_sub_admin = $id_sub_admin
        AND sub.id_depto = $id_depto
        ORDER BY (sub.fecha_alta) DESC";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return count($filas);
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return sqlsrv_errors();
      $conexion->CerrarConexion($con);
    }
  }

  public function Consulta_usuarios_sub_dep_pag($id_sub_admin, $id_depto, $inicio)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT TOP 50 SUB.seq,
        sub.id_empleado,
        sub.rfc_corto,
        sub.no_empleado,
        sub.nombre_empleado,
        sub.correo,
        sub.id_admin,
        lo.nombre_admin,
        sub.id_sub_admin,
        area.nombre_sub_admin,
        sub.id_depto,
        depa.nombre_depto,
        sub.id_perfil,
        per.nombre_perfil,
		pue.id_puesto,
		pue.nombre_puesto,
    case 
          WHEN (sub.estatus = 'A') THEN 'ACTIVO'
          ELSE 'NO ACTIVO'
        END AS estatus,
        case 
          WHEN (sub.responsiva = 0) THEN 'PENDIENTE'
          ELSE 'FIRMADA'
        END AS responsiva
        FROM (SELECT ROW_NUMBER() OVER(ORDER BY (fecha_alta) DESC) AS seq,
          * FROM Empleado) AS sub 
          INNER JOIN Administracion lo on lo.id_admin = sub.id_admin
          INNER JOIN SubAdmin area on area.id_sub_admin = sub.id_sub_admin
          INNER JOIN Departamento depa on depa.id_depto = sub.id_depto
		    INNER JOIN Puesto pue on pue.id_puesto = sub.id_puesto
        INNER JOIN Perfil per on per.id_perfil = sub.id_perfil
        WHERE sub.seq >= $inicio
        AND sub.id_sub_admin = $id_sub_admin
        AND sub.id_depto = $id_depto
        ORDER BY (sub.fecha_alta) DESC";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return $filas;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return sqlsrv_errors();
      $conexion->CerrarConexion($con);
    }
  }

  public function Consulta_usuarios_perfil_pag($id_perfil, $inicio)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT TOP 50 SUB.seq,
        sub.id_empleado,
        sub.rfc_corto,
        sub.no_empleado,
        sub.nombre_empleado,
        sub.correo,
        sub.id_admin,
        lo.nombre_admin,
        sub.id_sub_admin,
        area.nombre_sub_admin,
        sub.id_depto,
        depa.nombre_depto,
        sub.id_perfil,
        per.nombre_perfil,
		pue.id_puesto,
		pue.nombre_puesto,
    case 
          WHEN (sub.estatus = 'A') THEN 'ACTIVO'
          ELSE 'NO ACTIVO'
        END AS estatus,
        case 
          WHEN (sub.responsiva = 0) THEN 'PENDIENTE'
          ELSE 'FIRMADA'
        END AS responsiva
        FROM (SELECT ROW_NUMBER() OVER(ORDER BY (fecha_alta) DESC) AS seq,
          * FROM Empleado) AS sub 
          INNER JOIN Administracion lo on lo.id_admin = sub.id_admin
          INNER JOIN SubAdmin area on area.id_sub_admin = sub.id_sub_admin
          INNER JOIN Departamento depa on depa.id_depto = sub.id_depto
		    INNER JOIN Puesto pue on pue.id_puesto = sub.id_puesto
        INNER JOIN Perfil per on per.id_perfil = sub.id_perfil
        WHERE sub.seq >= $inicio
        AND sub.id_perfil = $id_perfil
        ORDER BY (sub.fecha_alta) DESC";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return $filas;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return sqlsrv_errors();
      $conexion->CerrarConexion($con);
    }
  }

  public function Consulta_usuarios_nombre_pag($id_admin, $nombre, $numero)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT TOP 50 SUB.seq,
        sub.id_empleado,
        sub.rfc_corto,
        sub.no_empleado,
        sub.nombre_empleado,
        sub.correo,
        sub.id_admin,
        lo.nombre_admin,
        sub.id_sub_admin,
        area.nombre_sub_admin,
        sub.id_depto,
        depa.nombre_depto,
        sub.id_perfil,
        per.nombre_perfil,
		pue.id_puesto,
		pue.nombre_puesto,
    case 
          WHEN (sub.estatus = 'A') THEN 'ACTIVO'
          ELSE 'NO ACTIVO'
        END AS estatus,
        case 
          WHEN (sub.responsiva = 0) THEN 'PENDIENTE'
          ELSE 'FIRMADA'
        END AS responsiva
        FROM (SELECT ROW_NUMBER() OVER(ORDER BY (fecha_alta) DESC) AS seq,
          * FROM Empleado) AS sub 
          INNER JOIN Administracion lo on lo.id_admin = sub.id_admin
          INNER JOIN SubAdmin area on area.id_sub_admin = sub.id_sub_admin
          INNER JOIN Departamento depa on depa.id_depto = sub.id_depto
		    INNER JOIN Puesto pue on pue.id_puesto = sub.id_puesto
        INNER JOIN Perfil per on per.id_perfil = sub.id_perfil
        WHERE sub.seq >= $numero
        AND sub.id_admin = $id_admin
        AND sub.nombre_empleado like '%$nombre%' COLLATE SQL_Latin1_General_CP1_CI_AI
        ORDER BY (sub.fecha_alta) DESC";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return $filas;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return sqlsrv_errors();
      $conexion->CerrarConexion($con);
    }
  }

  public function Consulta_usuarios_sub_pag($id_sub_admin, $inicio)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT TOP 50 sub.seq,
        sub.id_empleado,
        sub.rfc_corto,
        sub.no_empleado,
        sub.nombre_empleado,
        sub.correo,
        sub.id_admin,
        lo.nombre_admin,
        sub.id_sub_admin,
        area.nombre_sub_admin,
        sub.id_depto,
        depa.nombre_depto,
        sub.id_perfil,
        per.nombre_perfil,
		    pue.id_puesto,
		    pue.nombre_puesto,
        case 
          WHEN (sub.estatus = 'A') THEN 'ACTIVO'
          ELSE 'NO ACTIVO'
        END AS estatus,
        case 
          WHEN (sub.responsiva = 0) THEN 'PENDIENTE'
          ELSE 'FIRMADA'
        END AS responsiva
        FROM (SELECT ROW_NUMBER() OVER(ORDER BY (fecha_alta) DESC) AS seq,
          * FROM Empleado) AS sub 
          INNER JOIN Administracion lo on lo.id_admin = sub.id_admin
          INNER JOIN SubAdmin area on area.id_sub_admin = sub.id_sub_admin
          INNER JOIN Departamento depa on depa.id_depto = sub.id_depto
		    INNER JOIN Puesto pue on pue.id_puesto = sub.id_puesto
        INNER JOIN Perfil per on per.id_perfil = sub.id_perfil
        WHERE sub.seq >= $inicio
        AND sub.id_sub_admin = $id_sub_admin
        ORDER BY (sub.fecha_alta) DESC";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return $filas;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return sqlsrv_errors();
      $conexion->CerrarConexion($con);
    }
  }

  public function Consulta_usuarios_nombre_sub_pag($id_admin, $id_sub_admin, $nombre, $numero)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT TOP 50 SUB.seq,
        sub.id_empleado,
        sub.rfc_corto,
        sub.no_empleado,
        sub.nombre_empleado,
        sub.correo,
        sub.id_admin,
        lo.nombre_admin,
        sub.id_sub_admin,
        area.nombre_sub_admin,
        sub.id_depto,
        depa.nombre_depto,
        sub.id_perfil,
        per.nombre_perfil,
		pue.id_puesto,
		pue.nombre_puesto,
    case 
          WHEN (sub.estatus = 'A') THEN 'ACTIVO'
          ELSE 'NO ACTIVO'
        END AS estatus,
        case 
          WHEN (sub.responsiva = 0) THEN 'PENDIENTE'
          ELSE 'FIRMADA'
        END AS responsiva
        FROM (SELECT ROW_NUMBER() OVER(ORDER BY (fecha_alta) DESC) AS seq,
          * FROM Empleado) AS sub 
          INNER JOIN Administracion lo on lo.id_admin = sub.id_admin
          INNER JOIN SubAdmin area on area.id_sub_admin = sub.id_sub_admin
          INNER JOIN Departamento depa on depa.id_depto = sub.id_depto
		  INNER JOIN Puesto pue on pue.id_puesto = sub.id_puesto
          INNER JOIN Perfil per on per.id_perfil = sub.id_perfil
        WHERE sub.seq >= $numero
        AND sub.id_admin = $id_admin
        AND sub.id_sub_admin = $id_sub_admin
        AND sub.nombre_empleado like '%$nombre%' COLLATE SQL_Latin1_General_CP1_CI_AI
        ORDER BY (sub.fecha_alta) DESC";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return $filas;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return sqlsrv_errors();
      $conexion->CerrarConexion($con);
    }
  }

  public function Consulta_usuarios_nombre_sub_dep_pag($id_admin, $id_sub_admin, $id_depto, $nombre, $numero)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT TOP 50 SUB.seq,
        sub.id_empleado,
        sub.rfc_corto,
        sub.no_empleado,
        sub.nombre_empleado,
        sub.correo,
        sub.id_admin,
        lo.nombre_admin,
        sub.id_sub_admin,
        area.nombre_sub_admin,
        sub.id_depto,
        depa.nombre_depto,
        sub.id_perfil,
        per.nombre_perfil,
		pue.id_puesto,
		pue.nombre_puesto,
    case 
          WHEN (sub.estatus = 'A') THEN 'ACTIVO'
          ELSE 'NO ACTIVO'
        END AS estatus,
        case 
          WHEN (sub.responsiva = 0) THEN 'PENDIENTE'
          ELSE 'FIRMADA'
        END AS responsiva
        FROM (SELECT ROW_NUMBER() OVER(ORDER BY (fecha_alta) DESC) AS seq,
          * FROM Empleado) AS sub 
          INNER JOIN Administracion lo on lo.id_admin = sub.id_admin
          INNER JOIN SubAdmin area on area.id_sub_admin = sub.id_sub_admin
          INNER JOIN Departamento depa on depa.id_depto = sub.id_depto
		  INNER JOIN Puesto pue on pue.id_puesto = sub.id_puesto
          INNER JOIN Perfil per on per.id_perfil = sub.id_perfil
        WHERE sub.seq >= $numero
        AND sub.id_admin = $id_admin
        AND sub.id_sub_admin = $id_sub_admin
        AND sub.id_depto = $id_depto
        AND sub.nombre_empleado like '%$nombre%' COLLATE SQL_Latin1_General_CP1_CI_AI
        ORDER BY (sub.fecha_alta) DESC";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return $filas;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return sqlsrv_errors();
      $conexion->CerrarConexion($con);
    }
  }

  public function Consulta_usuarios_nombre_sub_dep_per_pag($id_admin, $id_sub_admin, $id_depto, $id_perfil, $nombre, $numero)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT TOP 50 SUB.seq,
        sub.id_empleado,
        sub.rfc_corto,
        sub.no_empleado,
        sub.nombre_empleado,
        sub.correo,
        sub.id_admin,
        lo.nombre_admin,
        sub.id_sub_admin,
        area.nombre_sub_admin,
        sub.id_depto,
        depa.nombre_depto,
        sub.id_perfil,
        per.nombre_perfil,
		    pue.id_puesto,
		    pue.nombre_puesto,
        case 
          WHEN (sub.estatus = 'A') THEN 'ACTIVO'
          ELSE 'NO ACTIVO'
        END AS estatus,
        case 
          WHEN (sub.responsiva = 0) THEN 'PENDIENTE'
          ELSE 'FIRMADA'
        END AS responsiva
        FROM (SELECT ROW_NUMBER() OVER(ORDER BY (fecha_alta) DESC) AS seq,
          * FROM Empleado) AS sub 
          INNER JOIN Administracion lo on lo.id_admin = sub.id_admin
          INNER JOIN SubAdmin area on area.id_sub_admin = sub.id_sub_admin
          INNER JOIN Departamento depa on depa.id_depto = sub.id_depto
		      INNER JOIN Puesto pue on pue.id_puesto = sub.id_puesto
          INNER JOIN Perfil per on per.id_perfil = sub.id_perfil
          WHERE sub.seq >= $numero
          AND sub.id_admin = $id_admin
          AND sub.id_sub_admin = $id_sub_admin
          AND sub.id_depto = $id_depto
          AND sub.id_perfil = $id_perfil
          AND sub.nombre_empleado like '%$nombre%' COLLATE SQL_Latin1_General_CP1_CI_AI
          ORDER BY (sub.fecha_alta) DESC";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return $filas;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return sqlsrv_errors();
      $conexion->CerrarConexion($con);
    }
  }

  public function Valida_registro_user($datos)
  {
    if (self::Valida_usuario_activo($datos->rfc_corto) != true) {
      $resultado = self::Registrar_usuario($datos);
      return $resultado;
    } else {
      return "Error: El usuario a registrar, se encuentra activo en el sistema.";
    }
  }

  public function Registrar_usuario($datos)
  {
    include_once 'conexion.php';
    include_once 'sesion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $user = $_SESSION["ses_rfc_corto_con"];
    $query = "INSERT INTO Empleado
    (id_admin
    ,id_sub_admin
    ,id_depto
    ,id_puesto
    ,id_perfil
    ,rfc_corto
    ,no_empleado
    ,nombre_empleado
    ,correo
    ,passwd
    ,jefe_directo
    ,estatus
    ,user_alta
    ,fecha_alta
    ,responsiva)
    SELECT 
            " . $datos->id_admin . " as id_admin
           ," . $datos->id_sub_admin . " as id_sub_admin
           ," . $datos->id_depa . " as id_depto
           ," . $datos->puesto . " as id_puesto
           ," . $datos->perfil . " as id_perfil
           ,'" . $datos->rfc_corto . "' as rfc_corto
           ," . $datos->no_emp . " as no_empleado
           ,'" . $datos->nombre_u . "' as nombre
           ,'" . $datos->correo . "' as correo
           ,'e10adc3949ba59abbe56e057f20f883e' as passwd
           ," . $datos->jefe . " as jefe_directo
           ,'" . $datos->estatus . "' as estatus
           ,'$user' as rfc_corto
           ,GETDATE() as fecha_alta
           ,0 as responsiva";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare === false) {
      return "Error al intentar registrar el usuario: " . print_r(sqlsrv_errors(), true);
    } else {
      return "Registro exitoso.";
    }
  }

  public function Actualizar_usuario($datos)
  {
    include_once 'conexion.php';
    include_once 'sesion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $user = $_SESSION["ses_rfc_corto_con"];
    $usarui_update = $datos->id_empleado;
    $usarui_depto = $datos->id_empleado;
    $query = "UPDATE Empleado
                  SET  id_admin = " . $datos->id_admin . "
                      ,id_sub_admin =  " . $datos->id_sub_admin . "
                      ,id_depto = " . $datos->id_depa . "
                      ,id_puesto = " . $datos->puesto . "
                      ,id_perfil = " . $datos->perfil . "
                      ,rfc_corto = '" . $datos->rfc_corto . "'
                      ,no_empleado = '" . $datos->no_emp . "'
                      ,nombre_empleado = '" . $datos->nombre_u . "'
                      ,correo = '" . $datos->correo . "'
                      ,jefe_directo = " . $datos->jefe . "
                      ,estatus = '" . $datos->estatus . "'
                      ,user_mod = '$user'
                      ,fecha_mod = GETDATE()
                      ,responsiva = ".$datos->responsiva."
                WHERE id_empleado = " . $datos->id_empleado;
    $prepare = sqlsrv_query($con, $query);
    if ($prepare === false) {
      return "Error al intentar actualizar el usuario: " . print_r(sqlsrv_errors(), true);
    } else {
      return "Actualización exitosa.";
    }
 
  }
  public function Comprueba_tickets_cargados($usarui_update)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT 
    tik.id_tiket
    FROM Tikets tik
    INNER JOIN Empleado emp ON tik.user_mov = emp.rfc_corto 
    WHERE emp.id_empleado = $usarui_update AND (tik.id_proc = 2 OR tik.id_proc = 11 OR tik.id_proc = 7 OR tik.id_proc = 8 OR tik.id_proc = 5 OR tik.id_proc = 9)";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return true;
        $conexion->CerrarConexion($con);
      } else {
        return false;
        $conexion->CerrarConexion($con);
      }
    } else {
      return sqlsrv_errors();
      $conexion->CerrarConexion($con);
    }
  }
  public function Consulta_si_es_cambio_de_areas($usarui_update)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT 
    id_sub_admin,
    id_depto,
    nombre_empleado,
    rfc_corto
    FROM Empleado WHERE id_empleado = $usarui_update";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return true;
        $conexion->CerrarConexion($con);
      } else {
        return false;
        $conexion->CerrarConexion($con);
      }
    } else {
      return sqlsrv_errors();
      $conexion->CerrarConexion($con);
    }
  }

  public function Valida_usuario_activo($rfc_corto)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT rfc_corto FROM Empleado 
                  WHERE rfc_corto = '$rfc_corto'
                  AND estatus = 'A'";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return true;
        $conexion->CerrarConexion($con);
      } else {
        return false;
        $conexion->CerrarConexion($con);
      }
    } else {
      return sqlsrv_errors();
      $conexion->CerrarConexion($con);
    }
  }

  public function Consulta_por_perfil_sub_dep_pag_num($id_perfil, $id_sub_admin, $id_depto)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT SUB.seq,
        sub.id_empleado,
        sub.rfc_corto,
        sub.no_empleado,
        sub.nombre_empleado,
        sub.correo,
        sub.id_admin,
        lo.nombre_admin,
        sub.id_sub_admin,
        area.nombre_sub_admin,
        sub.id_depto,
        depa.nombre_depto,
        sub.id_perfil,
        per.nombre_perfil,
		pue.id_puesto,
		pue.nombre_puesto,
        case 
          WHEN (sub.estatus = 'A') THEN 'ACTIVO'
          ELSE 'NO ACTIVO'
        END AS estatus
        FROM (SELECT ROW_NUMBER() OVER(ORDER BY (fecha_alta) DESC) AS seq,
          * FROM Empleado) AS sub 
          INNER JOIN Administracion lo on lo.id_admin = sub.id_admin
          INNER JOIN SubAdmin area on area.id_sub_admin = sub.id_sub_admin
          INNER JOIN Departamento depa on depa.id_depto = sub.id_depto
		    INNER JOIN Puesto pue on pue.id_puesto = sub.id_puesto
        INNER JOIN Perfil per on per.id_perfil = sub.id_perfil
        WHERE sub.id_perfil = $id_perfil
        AND sub.id_sub_admin = $id_sub_admin
        AND sub.id_depto = $id_depto
        ORDER BY (sub.fecha_alta) DESC";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $filas[] = $row;
      }
      if (isset($filas)) {
        return $filas;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return sqlsrv_errors();
      $conexion->CerrarConexion($con);
    }
  }
  public function Para_responsiva1($id_empleado,$admin)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT 
    Emp.nombre_empleado,
    Emp.fecha_alta,
    Emp.rfc_corto,
    Emp.correo,
    Emp.user_alta,
    per.nombre_perfil,
    dep.nombre_depto,
    (select nombre_empleado from Empleado where id_perfil = 7 AND estatus = 'A' AND id_puesto = 2 AND id_admin = $admin) As jefe,
    (select correo from Empleado where id_perfil = 7 AND estatus = 'A' AND id_puesto = 2 AND id_admin = $admin) As correo_jefe,
    (select rfc_corto from Empleado where id_perfil = 7 AND estatus = 'A' AND id_puesto = 2 AND id_admin = $admin) As rfc_jefe
    FROM Empleado Emp
    INNER JOIN Puesto Pues ON Emp.id_puesto = Pues.id_puesto
    inner join Perfil per on Emp.id_perfil = per.id_perfil
    inner join Departamento dep on Emp.id_depto = dep.id_depto
    Where id_empleado = $id_empleado  And Emp.id_admin = $admin";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $fila = $row;
      }
      if (isset($fila)) {
        return $fila;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }
  public function Para_responsiva($id_empleado)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT 
    enp.nombre_empleado,
    enp.fecha_alta,
    enp.rfc_corto,
    enp.correo,
    enp.id_admin,
    enp.user_alta,
    per.nombre_perfil,
    dep.nombre_depto,
    (SELECT nombre_empleado FROM Empleado where id_empleado = enp.jefe_directo) as jefe,
    (SELECT rfc_corto FROM Empleado where id_empleado = enp.jefe_directo) as rfc_jefe,
    (SELECT correo FROM Empleado where id_empleado = enp.jefe_directo) as correo_jefe
        from 
        Empleado enp  
        inner join Perfil per on enp.id_perfil = per.id_perfil
        inner join Departamento dep on enp.id_depto = dep.id_depto
        where 
        enp.id_empleado= $id_empleado";
    $prepare = sqlsrv_query($con, $query);
    if ($prepare) {
      while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        $fila = $row;
      }
      if (isset($fila)) {
        return $fila;
        $conexion->CerrarConexion($con);
      } else {
        return null;
        $conexion->CerrarConexion($con);
      }
    } else {
      return print_r(sqlsrv_errors(), true);
      $conexion->CerrarConexion($con);
    }
  }
}
