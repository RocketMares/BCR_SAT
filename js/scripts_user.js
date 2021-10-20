$("#ver").click(function (e) {
  openNav();
});
function valida_formulario_registro_user() {

  if ($("#RFC_CORTO").val().length < 4 || $("#NOMBRE").val().length < 10 || $("#NO_EMPLEADO").val().length < 3 || $("#CORREO").val().length < 20 || $("#id_admin").val() == 0 || $("#id_sub_admin").val() == 0 || $("#ID_DEPA").val() == 0 || $("#RFC_JEFE").val() == 0 || $("#ID_PERFIL").val() == 0 || $("#ID_PUESTO").val() == 0 || $("#estatus").val() == 0) {
    alert('Los datos marcados con el asterico no deben ser dejados en blanco y deben de cumplir con el tamño considerable.\n Para asistencia consulte con el administrador del sistema.');
  } else {
    Registrar_usuario();
  }
 }
 
 function Registrar_usuario() {
 
   var rfc = $("#RFC_CORTO").val();
   var nombre =   $("#NOMBRE").val();
   var no_empleado =  $("#NO_EMPLEADO").val();
   var correo =   $("#CORREO").val();
   var local =  $("#id_admin").val();
   var area =   $("#id_sub_admin").val();
   var depa =  $("#ID_DEPA").val();
   var rfc_jefe =  $("#RFC_JEFE").val();
   var id_perfil =  $("#ID_PERFIL").val();
   var id_puesto =  $("#ID_PUESTO").val();
   var estus =  $("#estatus").val();
 
   var datos = {
     rfc_corto: rfc,
     nombre_u: nombre,
     no_emp:no_empleado,
     correo: correo,
     id_admin:local,
     id_sub_admin: area,
     id_depa: depa,
     jefe: rfc_jefe,
     perfil: id_perfil,
     puesto: id_puesto,
     estatus: estus
   };
   
    var json = JSON.stringify(datos);
    $.post("php/Valida_R_User.php", {array:json}, function (data) {
      alert(data);
      location.reload();
    });
   
 }
function ConsultarDatosUser(id_usuario) {
  
  $.post("php/consulta_datos_user.php",{id_usuario: id_usuario}, function (data) {
      console.log(data);

      var id_usuario = [];
      var rfc = [];
      var nombre = [];
      var no_empleado = [];
      var id_perfil = [];
      var id_puesto = [];
      var correo = [];
      var local = [];
      var area = [];
      var depa = [];
      var jefe_directo = [];
      var estatus = [];

      for (var i in data) {
          id_usuario.push(data.id_empleado);
          rfc.push(data.rfc_corto);
          nombre.push(data.nombre_empleado);
          no_empleado.push(data.no_empleado);
          id_perfil.push(data.id_perfil);
          id_puesto.push(data.id_puesto);
          correo.push(data.correo);
          local.push(data.id_admin);
          area.push(data.id_sub_admin);
          depa.push(data.id_depto);
          jefe_directo.push(data.jefe_directo);
          estatus.push(data.estatus);
      }

      if(rfc != null){
                  $("#RFC_CORTO_A").val(rfc[0]);
                  $("#NOMBRE_A").val(nombre[0]);
                  $("#NO_EMPLEADO_A").val(no_empleado[0]);
                  $("#CORREO_A").val(correo[0]);
                  $("#id_admin_A option[value='"+local[0]+"']").attr("selected",true);
                  $("#id_sub_admin_A option[value='"+area[0]+"']").attr("selected",true);
                  $("#ID_DEPA_A option[value='"+depa[0]+"']").attr("selected",true);
                  $("#RFC_JEFE_A option[value='"+jefe_directo[0]+"']").attr("selected",true);
                  $("#ID_PERFIL_A option[value='"+id_perfil[0]+"']").attr("selected",true);
                  $("#ID_PUESTO_A option[value='"+id_puesto[0]+"']").attr("selected",true);
                  $("#estatus_A option[value='"+estatus[0]+"']").attr("selected",true);
                  $("#btn_RU_A").attr("onclick",'Actualizar_user('+id_usuario[0]+')');
                  $("#Modal_form_editar").modal(); 
      }else{
          alert('Los datos del usuario no estan disponibles.')
      }

      });

}

function Actualizar_user(id_empleado) {

if ($("#RFC_CORTO_A").val().length < 4 || $("#NOMBRE_A").val().length < 10 || $("#NO_EMPLEADO_A").val().length < 3 || $("#CORREO_A").val().length < 20 || $("#id_admin_A").val() == 0 || $("#id_sub_admin_A").val() == 0 || $("#ID_DEPA_A").val() == 0 || $("#RFC_JEFE_A").val() == 0 || $("#ID_PERFIL_A").val() == 0 || $("#ID_PUESTO_A").val() == 0 || $("#estatus_A").val() == 0) {
  alert('Los datos marcados con el asterico no deben ser dejados en blanco y deben de cumplir con el tamño considerable.\n Para asistencia consulte con el administrador del sistema.');
} else {
  var rfc = $("#RFC_CORTO_A").val();
    var nombre =   $("#NOMBRE_A").val();
    var no_empleado =  $("#NO_EMPLEADO_A").val();
    var correo =   $("#CORREO_A").val();
    var local =  $("#id_admin_A").val();
    var area =   $("#id_sub_admin_A").val();
    var depa =  $("#ID_DEPA_A").val();
    var rfc_jefe =  $("#RFC_JEFE_A").val();
    var id_perfil =  $("#ID_PERFIL_A").val();
    var id_puesto =  $("#ID_PUESTO_A").val();
    var estus =  $("#estatus_A").val();
    var responsiva =  $("#estatus_responsiva").val();

    var datos = {
        id_empleado:id_empleado,
        rfc_corto: rfc,
        nombre_u: nombre,
        no_emp:no_empleado,
        correo: correo,
        id_admin:local,
        id_sub_admin: area,
        id_depa: depa,
        jefe: rfc_jefe,
        perfil: id_perfil,
        puesto: id_puesto,
        estatus: estus,
        responsiva: responsiva
      };

      var json = JSON.stringify(datos);

      $.post("php/Valida_R_User.php", {objeto_user:json}, function (data) {
              alert(data);
              location.reload();
      });
}

    
}
//var moda = $("#Modal_pendientes").modal();


function BuscarDatosContrib(id_contrib) {
  var con = id_contrib
  createCookie('contribuyente', con, 1)
  location.href = "detalle_contribuyente.php";
}

function vermas() {
  $('#vermasdiv').toggle();
  $('#link_ver').toggle();
}

function renovar() {
  location.reload();
}



function vista_comentarios_vis(RDFDA) {

  $("#Registro_oficio").modal();
  buscar_datos_observaciones_vis(RDFDA)
 
}

function Manda_estatus(RDFDA) {
  var estatus = document.getElementById('Estatus_det_fin_tiket').value;
  var RDFDA = RDFDA;
  var datos = {
      RDFDA: RDFDA,
      estatus: estatus,
  };
  //alert(datos);
   $.post("php/Tiket_procesos_dev.php", {datos_cambio: datos}, function (data) {

     })
    .done(function (respuesta) {
        alert(respuesta);
        location.reload();
    })
    .fail(function () {
        console.log("error");
    });
}
function vista_comentarios_dev(RDFDA) {

  $("#Modal_vistas_ob_dev").modal();
  buscar_datos_observaciones_dev(RDFDA)
 
}
function vista_comentarios(tiket) {

  $("#Modal_vistas_ob").modal();
  buscar_datos_observaciones(tiket)
 
}
function buscar_datos_observaciones(tiket) {
  $.ajax({
          url: 'php/detalle_tiket_peticion.php',
          type: 'POST',
          dataType: 'html',
          data: {
          RDFDA_observacion: tiket
          },
      })
      .done(function (respuesta) {
          //alert(respuesta);
          $("#datosObservaciones").html(respuesta);
      })
      .fail(function () {
          console.log("error");
      });
}
function buscar_datos_observaciones_dev(tiket) {
  $.ajax({
          url: 'php/detalle_tiket_peticion.php',
          type: 'POST',
          dataType: 'html',
          data: {
          RDFDA_observacion_dev: tiket
          },
      })
      .done(function (respuesta) {
          //alert(respuesta);
          $("#datosObservaciones1").html(respuesta);
      })
      .fail(function () {
          console.log("error");
      });
}
function buscar_datos_observaciones_vis(RDFDA) {
  $.ajax({
          url: 'php/detalle_tiket_peticion.php',
          type: 'POST',
          dataType: 'html',
          data: {
              RDFDA_observacion_vis: RDFDA
          },
      })
      .done(function (respuesta) {
          //alert(respuesta);
          $("#datosObservaciones").html(respuesta);
      })
      .fail(function () {
          console.log("error");
      });
}
function agrega_observacion(RDFDA) {
  //alert(RDFDA);
 
  //var variable1 = '<%= Session["Variable1"] %>';
  $.ajax({
      url: 'php/detalle_tiket_peticion.php',
      type: 'POST',
      dataType: 'html',
      data: {
          RDFDA_ob: RDFDA
      },
  })
   $("#Modal_Comentario").modal();
 
}
function agrega_observacion_dev_1(RDFDA) {
 $("#Modal_Comentario_dev").modal();
 accion_agrega(RDFDA);
}
function accion_agrega(RDFDA){
$.ajax({
  url: 'php/detalle_tiket_peticion.php',
  type: 'POST',
  dataType: 'html',
  data: {
    RDFDA_ob_dev: RDFDA
  }
});
}
function valida_Observacion() {
  if ($("#Des").val().length < 1) {
    alert('Los datos marcados con el asterico no deben ser dejados en blanco.');
  } else {
      //alert('OK');
    Registrar_obs();
  }
}
function Registrar_obs() {

  var observa = $("#Observacion").val();
  var Des = $("#Des").val();
//  alert(observa);
   var datos = {
       observa: observa,
       Des:Des
   };
  
  //var json = JSON.stringify(datos);
   $.post("php/detalle_tiket_peticion.php", {datos_des:datos}, function (data) {
     alert(data);
     location.reload();
   });
  
}

function valida_Observacion_dev() {
  if ($("#Des_dev").val().length < 1) {
    alert('Los datos marcados con el asterico no deben ser dejados en blanco.');
  } else {
      //alert('OK');
      Registrar_obs_dev();
  }
}
function Registrar_obs_dev() {

  var observa = $("#Observacion_dev").val();
  var Des = $("#Des_dev").val();
//  alert(observa);
   var datos = {
       observa: observa,
       Des:Des
   };
  
  //var json = JSON.stringify(datos);
   $.post("php/detalle_tiket_peticion.php", {datos_des_dev:datos}, function (data) {
     alert(data);
     location.reload();
   });
  
}
function createCookie(name, value, days) {
  var expires;
  if (days) {
      var date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      expires = "; expires=" + date.toGMTString();
  } else {
      expires = "";
  }
  document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}

function ConfirmarCargaAut(valor) {

  $.post("php/validar_carga_masiva.php", {
      constante: valor
  }, function (data) {
      $("#texto_result").html(data);
      $("#resultado_carga").modal({
          backdrop: 'static',
          keyboard: false
      });
  });
}

function ConfirmarCargaUSU(valor) {
  $.post("php/validar_carga_masiva.php", {
      USU: valor
  }, function (data) {
      $("#texto_result").html(data);
      $("#resultado_carga").modal({
          backdrop: 'static',
          keyboard: false
      });
  });
}

function ConfirmarCargaDet(valor) {
  $.post("php/validar_carga_masiva.php", {
      det: valor
  }, function (data) {
      $("#texto_result").html(data);
      $("#resultado_carga").modal({
          backdrop: 'static',
          keyboard: false
      });
  });
}

function BuscarContribuyentes(id_empleado) {
  var id_operativo = id_empleado
  createCookie('id_operativo', id_operativo, 1)
  location.href = "Contribuyentes_asig.php?operativo=1";
}

function BuscarContribuyentesA(id_empleado) {
  var id_analista = id_empleado
  createCookie('id_analista', id_analista, 1)
  location.href = "Contribuyentes_asig.php?analista=1";
}


function Buscar_analistas(id_empleado) {
  var id_jefe = id_empleado
  createCookie('id_jefe', id_jefe, 1)
  location.href = "Contribuyentes_asig.php?jefedepto=1";
}

function Buscar_jefes(id_empleado) {
  var id_sub = id_empleado
  createCookie('id_sub', id_sub, 1)
  location.href = "Contribuyentes_asig.php?id_sub=1";
}

function DetalleEntrevista(id_ent) {
  var id_ent = id_ent
  createCookie('id_ent', id_ent, 1)
  location.href = "Detalle_entrevista.php";
}

function ocultar_detalles() {
  $("#detalles_ent").toggle();
  $("#detalles_mot").toggle();
  $("#detalles_insumo").toggle();
}

function detalles_ent() {
  $("#detalles_ent").toggle('slow');
}

function detalles_insumo() {
  $("#detalles_insumo").toggle('slow');
}

function detalles_mot() {
  $("#detalles_mot").toggle('slow');
}

function modal_retro() {
  $('#modal_retro').modal({
      backdrop: 'static',
      keyboard: false
  })
}

function modal_detalle_calendario(fecha) {

  $.post("php/valida_dia_pendientes.php", {
      fechas: fecha
  }, function (data) {
      $("#contenido").html(data); //Carga los elementos al body/content del modal
      $('#detalle').modal('toggle'); // eManada a llamar el modal
  });
}

$('.numeros').on('input', function () {
  this.value = this.value.replace(/[^0-9]/g, '');
});


// $(document).ready(function () {
//   $('[data-toggle="tooltip"]').tooltip()
// });


function myTimer() {

  var hora = new Date();
  var myhora = hora.toLocaleTimeString();
  var dia_f = (hora.getDate() < 10) ? "0" + hora.getDate() : hora.getDate();
  var mes = hora.getMonth() + 1
  var mes_f = (mes < 10) ? "0" + mes : mes;
  var dia = (dia_f + "/" + mes_f + "/" + hora.getFullYear());
  var hora7 = hora.getHours();
  var min = hora.getMinutes();
  var sec = hora.getSeconds();

  if ((hora7 >= 13 && hora7 <= 15) && min >= 00 && sec >= 00) {
      $.post("php/valida_dia_pendientes.php", {
          fechas_alertas: dia
      }, function (data) {
          var res = data;
          if (res == 1) {

          } else {
              modal_detalle_calendario(dia);
          }
      });
  }
}



function myTimer_delay() { //jefes

  var hora = new Date();
  var myhora = hora.toLocaleTimeString();
  var dia_f = (hora.getDate() < 10) ? "0" + hora.getDate() : hora.getDate();
  var mes = hora.getMonth() + 1;
  var mes_f = (mes < 10) ? "0" + mes : mes;
  var dia = (dia_f + "/" + mes_f + "/" + hora.getFullYear());
  var hora7 = hora.getHours();
  var min = hora.getMinutes();
  var sec = hora.getSeconds();

  if ((hora7 >= 13 && hora7 <= 15)) {
      $.post("php/valida_dia_pendientes.php", {
          fechas_alertas: dia
      }, function (data) {
          var res = data;
          if (res == 1) {

          } else {
              modal_detalle_calendario(dia);
          }
      });
  }
}
$(document).ready(function () {
  $("#busquedas").keypress(function (event) {
      if (event.keyCode === 13) {
          Buscar_contribuyente();
      }
  });
});


function para_individual() {
  $('#Carga_contri').modal('toggle');
}


function para_individual_pagos() {
  $('#Carga_pago').modal('toggle');
}

function para_reasignar() {
  $('#Reasigna_analista').modal('toggle');
}

// ---------------- Busqueda-------------------------------

$(document).ready(function () {
  $("#agregar_peticion").click(function (e) {
      // alert('HOLIS');
      // ($("#Modal_nu").modal())
      ($("#Modal_form_peticion").modal())
  });
});


// function detalle_ti(tiket) {
//     //alert(tiket);
//     $("#Modal_detalle_tiket_pet").modal();
// }

function detalle_tiket_peticion(tiket) {
  //alert(tiket);
  $("#Modal_detalle_tiket_pet").modal();
  buscar_datos_tiket_peticion(tiket)
 
}
function Cambia_estatus(RDFDA) {

  $("#Modal_estatus_det").modal();
  buscar_det_estatus(RDFDA)
 
}

function detalle_tiket_pestamo(tiket) {
  //alert(tiket);
  $("#Modal_detalle_tiket_prestamo").modal();
  buscar_datos_tiket_prestamos(tiket)

}

function detalle_tiket_dev(tiket) {
  // alert(tiket);
  $("#Modal_detalle_tiket_dev").modal();
  buscar_datos_tiket_dev(tiket)

}

function buscar_datos_tiket_peticion(tiket) {
  $.ajax({
          url: 'php/detalle_tiket_peticion.php',
          type: 'POST',
          dataType: 'html',
          data: {
              tiket: tiket
          },
      })
      .done(function (respuesta) {
          //alert(respuesta);
          $("#datostiket").html(respuesta);
      })
      .fail(function () {
          console.log("error");
      });
}
function MandaTiketImpreso(tiket) {
  $.ajax({
          url: 'php/Crear_Bolante.php',
          type: 'POST',
          dataType: 'html',
          data: {
              tiket: tiket
          },
      })
      .done(function (respuesta) {
          //alert(respuesta);
          $("#datostiket").html(respuesta);
      })
      .fail(function () {
          console.log("error");
      });
}
function Estatus_disponible(tiket) {
  $.ajax({
          url: 'php/Estatus_disponible.php',
          type: 'POST',
          dataType: 'html',
          data: {
              tiket_en_busqueda: tiket
          },
      })
      .done(function (respuesta) {
          //alert(respuesta);
           $("#datostiket").html(respuesta);
      })
      .fail(function () {
          console.log("error");
      });
}

function buscar_datos_tiket_prestamos(tiket) {
  $.ajax({
          url: 'php/detalle_tiket_peticion.php',
          type: 'POST',
          dataType: 'html',
          data: {
              tiket_prestamo: tiket
          },
      })
      .done(function (respuesta) {
          //alert(respuesta);
          $("#datostiketprestamo").html(respuesta);
      })
      .fail(function () {
          console.log("error");
      });
}
function buscar_det_estatus(RDFDA) {
  $.ajax({
          url: 'php/detalle_tiket_peticion.php',
          type: 'POST',
          dataType: 'html',
          data: {
              estatus_det: RDFDA
          },
      })
      .done(function (respuesta) {
          //alert(respuesta);
          $("#selecciona_estatus").html(respuesta);
      })
      .fail(function () {
          console.log("error");
      });
}

function buscar_datos_tiket_dev(tiket) {
  $.ajax({
          url: 'php/detalle_tiket_peticion.php',
          type: 'POST',
          dataType: 'html',
          data: {
              tiket_dev: tiket
          },
      })
      .done(function (respuesta) {
          //alert(respuesta);
          $("#datostiketdev").html(respuesta);
      })
      .fail(function () {
          console.log("error");
      });
}

// function Buscar_contribuyente() {
//     var busqueda = $("#bus").val();
//     alert(busqueda);
//     $.post("php/resultados_busquedas.php", {
//         busqueda: busqueda
//     }, function (data) {});
// }

$('#agregar').click(function(){
    
  var selected = '';	
  var RDFDA='';
  $('#form input[type=checkbox]').each(function(){
      if (this.checked) {
  
          RDFDA += $(this).val()+', ';
      }
  }); 
  if(RDFDA!=''){
     // alert('Has seleccionado: '+RDFDA); 
       $.post("php/Valida_solicitud.php", {agrega:RDFDA}, function (data) {
    alert(data);
   // location.reload();
    return false;
  });
  }
  else{
      alert('Debes seleccionar un expediente'); 
      return false;
  }
  //alert('Has seleccionado 2: '+RDFDA);  
});     

$('#cancela').click(function(){
  $.post("php/Valida_solicitud.php", {cancela:1}, function (data) {
      alert(data); }); 
      //location.reload();
  //alert('Has seleccionado 2: '+RDFDA);  
});       
$('#pedir').click(function(){
  var cod = document.getElementById("asunto").value;
   
if(cod != 0){
  $.post("php/Valida_solicitud.php", {pedir:cod}, function (data) {
     
      alert(data) ? "" : location.reload();
      }); 
    
} else {
  alert('Debes seleccionar un Asunto');
  return false;
}
});   

$('#Tiket_disponible').click(function () {
  var selected = '';
  var RDFDA = '';
  $('#form input[type=checkbox]').each(function () {
      if (this.checked) {

          RDFDA += $(this).val() + ', ';
      }
  });
   //alert('Has seleccionado: '+RDFDA); 
   if (RDFDA != '') {
       $.post("php/Estatus_disponible.php", {
           array: RDFDA
       }, function (data) {
           alert(data);
           location.reload();
           return false;
       });
   } else {
       alert('Debes seleccionar un expediente');
       return false;
   }
});
$('#Entrega_boveda').click(function () {
  var selected = '';
  var RDFDA = '';
  $('#form input[type=checkbox]').each(function () {
      if (this.checked) {

          RDFDA += $(this).val() + ', ';
      }
  });
   //alert('Has seleccionado: '+RDFDA); 
   if (RDFDA != '') {
       $.post("php/Cerrar_tiket.php", {
           array: RDFDA
       }, function (data) {
           alert(data);
           location.reload();
           return true;
       });
   } else {
       alert('Debes seleccionar un expediente');
       return false;
   }
});



$('#Entrega_boveda_Parcial').click(function () {
  
   var selected = '';
   var RDFDA = '';

   $('#form input[type=checkbox]').each(function () {
      if (this.checked) {

          RDFDA += $(this).val() + ', ';
          
      }
  });
        if (RDFDA != '') {
            $.post("php/Tiket_procesos_dev.php", {
               array: RDFDA,
               //estatus : cod
            }, function (data) {
                alert(data);
                location.reload();
                return true;
            });
        } else {
            alert('Debes seleccionar un expediente');
            return false;
        }
});

$('#pedir').click(function(){
  
   
if(cod != 0){
  $.post("php/Valida_solicitud.php", {pedir:cod}, function (data) {
     
      alert(data) ? "" : location.reload();
      }); 
    
} else {
  alert('Debes seleccionar un Asunto');
  return false;
}
});   
$('#Prestar_Tiket').click(function () {
  var selected = '';
  var RDFDA = '';
  $('#form input[type=checkbox]').each(function () {
      if (this.checked) {

          RDFDA += $(this).val() + ', ';
      }
  });
   //alert('Has seleccionado: '+RDFDA); 
   if (RDFDA != '') {
       $.post("php/Estatus_Prestamo_Boveda.php", {
           array: RDFDA
       }, function (data) {
           alert(data);
           location.reload();
           return false;
       });
   } else {
       alert('Debes seleccionar un expediente');
       return false;
   }
});
function Registrar_usuario() {

  var rfc = $("#RFC_CORTO").val();
  var nombre = $("#NOMBRE").val();
  var no_empleado = $("#NO_EMPLEADO").val();
  var correo = $("#CORREO").val();
  var local = $("#id_admin").val();
  var area = $("#id_sub_admin").val();
  var depa = $("#ID_DEPA").val();
  var rfc_jefe = $("#RFC_JEFE").val();
  var id_perfil = $("#ID_PERFIL").val();
  var id_puesto = $("#ID_PUESTO").val();
  var estus = $("#estatus").val();

  var datos = {
      rfc_corto: rfc,
      nombre_u: nombre,
      no_emp: no_empleado,
      correo: correo,
      id_admin: local,
      id_sub_admin: area,
      id_depa: depa,
      jefe: rfc_jefe,
      perfil: id_perfil,
      puesto: id_puesto,
      estatus: estus
  };

  var json = JSON.stringify(datos);
  $.post("php/Valida_R_User.php", {
      array: json
  }, function (data) {
      alert(data);
      location.reload();
  });

}

$('#entregar').click(function () {
  var selected = '';
  var RDFDA = '';
  $('#form input[type=checkbox]').each(function () {
      if (this.checked) {

          RDFDA += $(this).val() + ', ';
      }
  });
  if (RDFDA != '') {
      // alert('Has seleccionado: '+RDFDA); 
      $.post("php/Valida_solicitud.php", {
          entrega: RDFDA
      }, function (data) {
          alert(data);
          location.reload();
          return false;
      });
  } else {
      alert('Debes seleccionar un expediente');
      return false;
  }
  //alert('Has seleccionado 2: '+RDFDA);  
});
$('#Entrega_prestamo_interno').click(function () {
  var selected = '';
  var RDFDA = '';
  $('#form input[type=checkbox]').each(function () {
      if (this.checked) {

          RDFDA += $(this).val() + ', ';
      }
  });
  if (RDFDA != '') {
        //alert('Has seleccionado: '+RDFDA); 
       $.post("php/Cerrar_tiket.php", {
           entrega_interna: RDFDA
       }, function (data) {
           alert(data);
           location.reload();
           return false;
       });
   } else {
       alert('Debes seleccionar un expediente');
       return false;
   }
  //alert('Has seleccionado 2: '+RDFDA);  
});
$('#Cancelar_Tiket').click(function () {
  var selected = '';
  var RDFDA = '';
  $('#form input[type=checkbox]').each(function () {
      if (this.checked) {

          RDFDA += $(this).val() + ', ';
      }
  });
  if (RDFDA != '') {
      $.post("php/Cancelar_solicitud.php", {
          array: RDFDA
      }, function (data) {
          alert(data);
          location.reload();
          return false;
      });
  } else {
      alert('Debes seleccionar un expediente');
      return false;
  }
  //alert('Has seleccionado 2: '+RDFDA);  
});


function Registrar_Sub_administracion() {

  var admin = $("#id_admin_1").val();
  var nombre_sub = $("#nombre_area").val();
  var datos = {
      admin: admin,
      nombre_sub: nombre_sub,
  };
  //  var json = JSON.stringify(datos);
  // alert('Si entra aqui' + json);
  if (nombre_sub != "") {
      $.post("php/ra_area.php", {
          array: datos
      }, function (data) {
          //alert(data);
           location.reload();
      });
  }
   else{
      alert('No puede dejar en blanco el nombre de la Sub Administración.')
   }
  //  //location.reload();

}


function Actualiza_Sub_administracion() {

  var admin = $("#num_admin").val();
  var sub_admin_asoc = $("#id_sub_admin_b").val();
  var nombre_sub = $("#nombre_area_1").val();
  var estatus = $('input:radio[name=Estatus_activo]:checked').val();

           var datos = {
               admin: admin,
               sub_admin_asoc: sub_admin_asoc,
               nombre_sub: nombre_sub,
               estatus: estatus,
              
           };
       // var json = JSON.stringify(datos);
       //alert('Si entra aqui' + json);    
       if (nombre_sub != "") {
          $.post("php/Ac_area.php", {
              array2: datos
         }, function (data) {
              alert(data);
               location.reload();
             
          });
       }
       else{
           alert('No puede dejar en blanco el nombre de la Sub Administración.')
       }
    

}
function Actualiza_autoridad() {

  var id_autoridad = $("#id_autoridad").val();
  var Nombre_autor = $("#Nombre_autor").val();
  var estatus = $('input:radio[name=estatus]:checked').val();

           var datos = {
              id_autoridad: id_autoridad,
              Nombre_autor: Nombre_autor,
               estatus: estatus
           };
  //  var json = JSON.stringify(datos);
  //  alert('Si entra aqui' + json);    
      if (Nombre_autor != "") {
          $.post("php/Ac_area.php", {
              autoridad: datos
      }, function (data) {
              alert(data);
              location.reload();
          
          });
      }
      else{
          alert('No puede dejar en blanco el nombre de la Sub Administración.');
      }

}

function Registrar_Administracion() {

  var nom_admin = $("#nombre_area").val();
  var nom_admin_cort = $("#nombre_area_corto").val();
  var datos = {
      nom_admin: nom_admin,
      nom_admin_cort: nom_admin_cort,
  };
  if (nom_admin_cort != '') {
    if (nom_admin != '') {
      $.post("php/ra_admin.php", {
        array: datos
    }, function (data) {
        //alert(data);
         location.reload();
    });
    }
    else{
      alert('No puedes dejar recuadros en blanco!');
    }
  }
  else{
    alert('No puedes dejar recuadros en blanco!');
  }

    
  //  //location.reload();

}
function Actualiza_Administracion() {

   var admin_asoc = $("#id_admin").val();
   var nombre_admin_cam = $("#nombre_admin_cam").val();
   var nombre_cort_admin_cam = $("#nombre_cort_admin_cam").val();
   var estatus = $('input:radio[name=Estatus]:checked').val();

            var datos = {
              admin_asoc: admin_asoc,
              nombre_admin_cam: nombre_admin_cam,
              nombre_cort_admin_cam: nombre_cort_admin_cam,
              estatus: estatus,
            };   
    if (nombre_admin_cam != '') {
      $.post("php/Ac_admin.php", {
        array: datos
   }, function (data) {
        alert(data);
         location.reload();
     
    });
    }
    else{
      alert('No puedes dejar este campo en blanco!.');
    }
        
    

}
function Registrar_departamento() {

   var admin = $("#id_admin").val();
   var sub = $("#id_sub_admin").val();
   var nombre_dep = $("#nombre_dep").val();
   var datos = {
       admin: admin,
       sub:sub,
       nombre_dep: nombre_dep,
   };

      $.post("php/ra_dep.php", {
          array: datos
      }, function (data) {
          alert(data);
           location.reload();
      
      });
    //  //location.reload();

}
function Actualiza_departamento() {

      var admin = $("#num_admin").val();
      var sub = $("#id_sub_admin_b").val();
      var dep_asoc = $("#deptos_f").val();
      var nombre_dep = $("#nombre_dep_cam").val();
      var estatus = $('input:radio[name=Estatus_activo]:checked').val();

            var datos = {
                admin: admin,
                sub: sub,
                nombre_dep: nombre_dep,
                dep_asoc: dep_asoc,
                estatus: estatus,
              
           };
           if (nombre_dep != "") {
              $.post("php/Ac_dep.php", {
                  array2: datos
             }, function (data) {
                  alert(data);
                   location.reload();
                
              });
           }else
           alert('No puede dejar en blanco el nombre del departamento a actualizar');
      //    var json = JSON.stringify(datos);
      //   alert('Si entra aqui' + json);    
        
    

}
function filtros_users() { 

  var nombre = $("#nombre_b").val();
  // var nombre = $("#num_admin").val();
  var area = $("#id_sub_admin_b").val();
  var dep = $("#deptos_f").val();
  var perfil = $("#perfil_b").val();

  console.log(nombre)
  console.log(area)
  console.log($(dep).val())
  console.log(perfil)

  if ( ($("#nombre_b").val().length > 1 ) && area == '0' && dep == '0' && perfil == '0')  {
      createCookie("nombre",nombre,1)
      location.href="usuarios_control.php?por_nombre=1";
  }else if(($("#nombre_b").val().length > 1 ) && area != '0' && dep == '0' && perfil == '0'){
      createCookie("nombre",nombre,1)
      createCookie("subadmin",area,1)
      location.href="usuarios_control.php?por_nomb_sub=1";
  }else if(($("#nombre_b").val().length > 1 ) && area != '0' && dep != '0' && perfil == '0'){
      createCookie("nombre",nombre,1)
      createCookie("subadmin",area,1)
      createCookie("deptos",dep,1)
      location.href="usuarios_control.php?por_nomb_sub_dep=1";
  }else if(($("#nombre_b").val().length > 1 ) && area != '0' && dep != '0' && perfil != '0'){
      createCookie("nombre",nombre,1)
      createCookie("subadmin",area,1)
      createCookie("deptos",dep,1)
      createCookie("perfil",perfil,1)
      location.href="usuarios_control.php?por_nomb_sub_dep_per=1";
  }else if ( ($("#nombre_b").val().length < 1 ||  $("#nombre_b").val() == " ") && area != '0' && dep == '0' && perfil == '0')  {
      createCookie("subadmin",area,1)
      location.href="usuarios_control.php?por_sub=1";
  }else if(($("#nombre_b").val().length < 1 ) && area != '0' && dep != '0' && perfil == '0'){
      createCookie("subadmin",area,1)
      createCookie("deptos",dep,1)
      location.href="usuarios_control.php?por_sub_dep=1";
  }else if(($("#nombre_b").val().length < 1 ) && area == '0' && dep == '0' && perfil != '0'){
      createCookie("perfil",perfil,1)
      location.href="usuarios_control.php?por_perfil=1";
  }else if(($("#nombre_b").val().length < 1 ) && area != '0' && dep != '0' && perfil != '0'){
      createCookie("perfil",perfil,1)
      createCookie("subadmin",area,1)
      createCookie("deptos",dep,1)
      location.href="usuarios_control.php?por_perfil_sub_dep=1";
  }else if(($("#nombre_b").val().length < 1 ) && area == '0' && dep == '0' && perfil == '0'){
      location.href="usuarios_control.php?usuarios=1";
  }
}

$(document).ready(function () {
   $("#agregar_user").click(function (e) { 
      $("#Modal_form_registrar").modal();
   });
});

$(document).ready(function() {
  $("#id_admin_A").change(function () {
    $("#ID_DEPA_A").find('option').remove().end().append(
      '<option value="whatever"></option>').val('whatever');
    $("#id_admin_A option:selected").each(function () {
         id_admin = $(this).val();
      $.post("Obtener_Combos.php",{id_admin:id_admin},function (data) {
        $("#id_sub_admin_A").html(data);
      })
    })
  })
});
$(document).ready(function() {
  $("#num_admin").change(function () {
    $("#id_sub_admin_b").find('option').remove().end().append(
      '<option value="whatever"></option>').val('whatever');
    $("#num_admin option:selected").each(function () {
         id_admin = $(this).val();
      $.post("Obtener_Combos.php",{id_admin:id_admin},function (data) {
        $("#id_sub_admin_b").html(data);
      })
    })
  })
});

$(document).ready(function() {
$("#id_sub_admin_A").change(function () {
  $("#id_sub_admin_A option:selected").each(function () {
       var id_sub_admin = $(this).val();
    $.post("php/Obtener_Combos.php",{id_sub_admin:id_sub_admin},function (data) {
      $("#ID_DEPA_A").html(data);
    })
  })
})
});

// $(document).ready(function() {
//  $("#subadmin_b").change(function () {
//    $("#subadmin_b option:selected").each(function () {
//         var id_sub_admin = $(this).val();
//      $.post("php/Obtener_Combos.php",{id_sub_admin:id_sub_admin},function (data) {
//        $("#deptos_b").html(data);
//      })
//    })
//  })
// });

$(document).ready(function() {
$("#id_sub_admin_b").change(function () {
  $("#deptos_b").find('option').remove().end().append(
    '<option value="whatever"></option>').val('whatever');
  $("#id_sub_admin_b option:selected").each(function () {
    var id_sub_admin = $(this).val();
    $.post("php/Obtener_Combos.php",{id_sub_admin:id_sub_admin},function (data) {
      $("#deptos_b").html(data);
    })
  })
})
});


$(document).ready(function() {
$("#id_admin").change(function () {
 $("#ID_DEPA").find('option').remove().end().append(
   '<option value="whatever"></option>').val('whatever');
 $("#id_admin option:selected").each(function () {
      id_admin = $(this).val();
   $.post("php/Obtener_Combos.php",{id_admin:id_admin},function (data) {
     $("#id_sub_admin").html(data);
   })
 })
})
});


$(document).ready(function() {
$("#id_admin_A").change(function () {
  $("#ID_DEPA_A").find('option').remove().end().append(
    '<option value="whatever"></option>').val('whatever');
  $("#id_admin_A option:selected").each(function () {
       id_admin = $(this).val();
    $.post("php/Obtener_Combos.php",{id_admin:id_admin},function (data) {
      $("#id_sub_admin_A").html(data);
    })
  })
})
});


$(document).ready(function() {
$("#id_sub_admin").change(function () {
$("#id_sub_admin option:selected").each(function () {
    id_sub_admin = $(this).val();
 $.post("php/Obtener_Combos.php",{id_sub_admin:id_sub_admin},function (data) {
   $("#ID_DEPA").html(data);
 })
})
})
});
$(document).ready(function() {
$("#num_admin").change(function () {
 $("#num_admin option:selected").each(function () {
      id_admin = $(this).val();
   $.post("php/Obtener_Combos.php",{id_admin:id_admin},function (data) {
     $("#id_sub_admin_b").html(data);
   })
 })
})
});
$(document).ready(function() {
$("#id_sub_admin_b").change(function () {
 $("#id_sub_admin_b option:selected").each(function () {
      id_sub_admin = $(this).val();
   $.post("php/Obtener_Combos.php",{id_sub_admin:id_sub_admin},function (data) {
     $("#deptos_f").html(data);
   })
 })
})
});

$(document).ready(function() {
$("#id_autoridad").change(function () {
  $("#id_autoridad option:selected").each(function () {
      id_sub_admin1 = $(this).val();
  $.post("php/Obtener_Combos.php",{id_autoridad:id_autoridad},function (data) {
      $("#Nombre_autor").text(data);
  })
  })
})
});

//// ESTOS SON LOS COMBOS DE LA PAGINA DE INTEGRACION

      $(document).ready(function () {
          $("#num_objeto").change(function () {
              $("#num_objeto option:selected").each(function () {
                  id_obj = $(this).val();
                  $.post("php/Obtener_Combos.php", {
                      id_obj: id_obj
                  }, function (data) {
                      $("#id_situacion").html(data);
                  })
              })
          })
          $("#id_situacion").change(function () {
              $("#id_situacion  option:selected").each(function () {
                  id_sit = $(this).val();
                  $.post("php/Obtener_Combos.php", {
                      Etapa: id_sit
                  }, function (data) {
                      $("#id_etapas_select").html(data);
                  })
              })
          })

      });

      // function cambio_etap() {
      //     var sit_id = $('#id_situacion').val();
      //     $.ajax({
      //         url: 'php/Obtener_Combos.php',
      //         type: 'POST',
      //         dataType: 'html',
      //         data: {
      //             Etapa: sit_id
      //         },
      //     })
      //     .done(function (respuesta) {
      //         //alert(respuesta);
      //         $("#id_etapas_select").html(respuesta);
      //     })
      //     .fail(function () {
      //         console.log("error");
      //     });
         
      // } 
         


    
    
  




          
