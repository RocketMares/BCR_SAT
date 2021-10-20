<?php

if (isset($_POST["id_admin"])) {
    include_once 'MetodosUsuarios.php';
    $resultado = new MetodosUsuarios();
    $id_admin = $_POST["id_admin"];
    $resultado_area = $resultado->Consulta_Subadmin($id_admin);
    $html[] = null;
    for ($i = 0; $i < count($resultado_area); $i++) {
        $contenido = "<option value='" . $resultado_area[$i]["id_sub_admin"] . "'>" . $resultado_area[$i]["nombre_sub_admin"] . "</option>";
        $html[$i] = $contenido;
    }
    echo "<option value='0'>Seleccionar Subadministración</option>";
    for ($i = 0; $i < count($html); $i++) {
      echo "$html[$i]";
    }
}elseif (isset($_POST["id_sub_admin"])) {
    include_once 'MetodosUsuarios.php';
    $resultado = new MetodosUsuarios();
    $id_sub_admin = $_POST["id_sub_admin"];
    $resultado_dep = $resultado->Consulta_Depto_sub($id_sub_admin);
    if (is_array($resultado_dep)) {
      $html[] = null;
      for ($i = 0; $i < count($resultado_dep); $i++) {
          $contenido = "<option value='" . $resultado_dep[$i]["id_depto"] . "'>" . $resultado_dep[$i]["nombre_depto"] . "</option>";
          $html[$i] = $contenido;
      }
      $opcions =  "<option value='0'>Seleccionar Departamento</option>";
      for ($i = 0; $i < count($html); $i++) {
        $opcions .=  $html[$i];
      }
      echo $opcions;
    } else {
      $opcions =  "<option value='0'>$resultado_dep</option>";
      echo $opcions;
    }
  }
  if (isset($_POST['id_sub_admin1'])) {
    include_once 'MetodosUsuarios.php';
    $resultado = new MetodosUsuarios();
    $id_sub_admin = $_POST["id_sub_admin1"];
    $resultado_dep = $resultado->Consulta_Depto_sub($id_sub_admin);
    return $resultado_dep['nombre_depto'];

  }
  if (isset($_POST['nom_dep'])) {
    include_once 'MetodosUsuarios.php';
    $resultado = new MetodosUsuarios();
    $nom_dep = $_POST["nom_dep"];
    $resultado_dep = $resultado->Consulta_Depto_sub($nom_dep);
    return "value= '".$resultado_dep['nombre_depto']."'";

  }
  if (isset($_POST['id_autoridad'])) {
    include_once 'php/ConsultaContribuyentes.php';
    $consulta = new ConsultaContribuyentes();
    $id_autoridad = $_POST["id_autoridad"];
    $resultado = $consulta->Consulta_Autoridad_especifica($id_autoridad);
    return $resultado['nombre_autoridad'];

  }
  if (isset($_POST['nombre_emp'])) {
    include_once 'MetodosUsuarios.php';
    $consulta = new MetodosUsuarios();
    $nombre = $_POST["nombre_emp"];
    $resultado = $consulta->Consulta_usuarios_BUSQ($nombre);
    for ($i=0; $i < count($resultado) ; $i++) { 
      $opciones[$i]=" <option value='".$resultado[$i]['rfc_corto']."'></option>";
    }
    
    echo $opciones;

  }

  if (isset($_POST["id_obj"])) {
    include_once 'MetodosUsuarios.php';
    $resultado = new MetodosUsuarios();
    $id_obj = $_POST["id_obj"];
    $resultado_area = $resultado->Consulta_situacion($id_obj);
    $html[] = null;
    for ($i = 0; $i < count($resultado_area); $i++) {
        $contenido = "<option value='" . $resultado_area[$i]["Id_situación"] . "'>" . $resultado_area[$i]["Situacion"] . "</option>";
        $html[$i] = $contenido;
    }
    echo "<option value='0'>Seleccionar Situacion</option>";
    for ($i = 0; $i < count($html); $i++) {
      echo $html[$i];
    }
}

if (isset($_POST["Etapa"])) {
  include_once 'MetodosUsuarios.php';
  $resultado = new MetodosUsuarios();
  $id_sub_admin = $_POST["Etapa"];
  $resultado_dep = $resultado->Consulta_etapa($id_sub_admin);
  if (is_array($resultado_dep)) {
    $html[] = null;
    for ($i = 0; $i < count($resultado_dep); $i++) {
        $contenido = "<option value='" . $resultado_dep[$i]["Clave_etapa"] . "'>" . $resultado_dep[$i]["Nombre_de_etapa"] . "</option>";
        $html[$i] = $contenido;
    }
    $opcions =  "<option value='0'>Seleccionar Etapa</option>";
    for ($i = 0; $i < count($html); $i++) {
      $opcions .=  $html[$i];
    }
    echo $opcions;
  } else {
    $opcions =  "<option value='0'>$resultado_dep</option>";
    echo $opcions;
  }
}


