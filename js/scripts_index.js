
$("#ver").click(function (e) {
    openNav();
});

function detalle_muestra(oficio) {
    $("#Detalle_of").modal();
    detalle_oficio(oficio)
}

function Muestra_modal_reg_of() {
    $("#exampleModalScrollable").modal();

}

function detalle_oficio(oficio) {
    $.post("php/detalle_oficio.php", {
            oficio: oficio
        }, function (data) {
            //alert(data);

        })
        .done(function (respuesta) {
            $('#detalles').html(respuesta);
        }).fail(function () {
            alert("Algo salio mal");
        })
}

function valida_formulario_reg_oficio() {

    if ($("#RFC_contri").val().length < 4) {
        alert('El RFC del contribuyente no puede tener menos de 4 caracteres.');
    } else {
        if ($('#tip_tramite').val() == 0) {
            alert('Falta agregar el tipo de tramite.');
        } else {
            if ($("#validationFolioGW").val().length < 10) {
                alert('El folio de Gestor Web no puede tener menos de 10 caracteres.');
            } else {
                    if ($("#razon_social").val() == '') {
                        alert('No puede dejar en blanco la razón social');
                    } else {
                        if ($('#validationNoOficio').val() == '') {
                            alert('Debes agregar el número del oficio no mayor a 5 caracteres.');
                        } else {
                            if ($("#validationHistorico").val() == 0) {
                                alert('Debes agregar el importe historico');

                            } else {
                                if ($("#fecha_determinante").val() == "") {
                                    alert('Debes agregar la fecha de la determinante dictada por MAT');
                                }else {
                                   
                                    if($("#validationLinea").val() == '') {
                                        crear_folio1();
                                    }
                                    else{
                                        if ($("#validationLinea").val().length < 32) {
                                            alert('Debes agregar la liena de Captura a 32 posiciones.');
                                        }
                                        else{
                                            crear_folio1();
                                        }
                                    }
                                }

                            }
                        }
                        //  else {
                        //     crear_folio2();
                        // }
                    
                }
            }
        }
    }
}


function crear_folio1() {
    var tip_tramite = $('#tip_tramite').val();
    var validation_FolioGW = $('#validationFolioGW').val();
    var RFC_contri = $('#RFC_contri').val();
    var razon_social = $('#razon_social').val();
    var validation_No_Oficio = $('#validationNoOficio').val();
    var validation_Linea = $('#validationLinea').val();
    var validation_Historico = $('#validationHistorico').val();
    var fecha_determinante = $('#fecha_determinante').val();
    var validation_Recuperado = $('#validationRecuperado').val();
    var validation_Condonado = $('#validationCondonado').val();
    var fecha_det = $('#fecha_det').val();
    var fecha_nof = $('#fecha_notf').val();
    var datos = {
        tip_tramite: tip_tramite,
        validation_FolioGW: validation_FolioGW,
        RFC_contri: RFC_contri,
        razon_social: razon_social,
        validation_No_Oficio: validation_No_Oficio,
        validation_Linea: validation_Linea,
        fecha_determinante: fecha_determinante,
        validation_Historico: validation_Historico,
        validation_Recuperado: validation_Recuperado,
        validation_Condonado: validation_Condonado,
        fecha_det: fecha_det,
        fecha_nof: fecha_nof
    }
    var json = JSON.stringify(datos);
    // alert(json);
    $.post('php/Registro_oficio.php', {
        array: json
    }, function (data) {
        alert(data);
        location.reload();
    });

}
// $(document).ready(function(){
//     $('#validationFolioGW').val().length < 10
//     val='/'
// });

function crear_folio2() {
    var tip_tramite = $('#tip_tramite').val();
    var validation_Determinante = $('#validationDeterminante').val();
    var validation_FolioGW = $('#validationFolioGW').val();
    var RFC_contri = $('#RFC_contri').val();
    var razon_social = $('#razon_social').val();
    var validation_No_Oficio = $('#validationNoOficio').val();
    var validation_Historico = $('#validationHistorico').val();
    var fecha_determinante = $('#fecha_determinante').val();
    var Procede = $('#Procede').val();
    var fecha_det = $('#fecha_det').val();
    var fecha_nof = $('#fecha_notf').val();
    var datos = {
        tip_tramite: tip_tramite,
        validation_Determinante: validation_Determinante,
        validation_FolioGW: validation_FolioGW,
        RFC_contri: RFC_contri,
        razon_social: razon_social,
        validation_No_Oficio: validation_No_Oficio,
        fecha_determinante: fecha_determinante,
        validation_Historico: validation_Historico,
        Procede: Procede,
        fecha_det: fecha_det,
        fecha_nof: fecha_nof
    }
    var json = JSON.stringify(datos);
    // alert(json);
    $.post('php/Registro_oficio.php', {
        array2: json
    }, function (data) {
        alert(data);
        location.reload();
    });

}

function valida_retro(oficio) {
    
     if ($('#validationLinea').val()== '') {
        crear_folioRetro1(oficio)
     }
     else{
        if ($('#validationLinea').val().length < 32) {
            alert ('No puedes agregar una linea de captura con menos de 32 caracteres')
        }
        else{crear_folioRetro1(oficio)}
     }


                }
            
 
function crear_folioRetro1(oficio) {

   var Fecha_notif_retro = $('#Fecha_notif_retro').val();
   var validationRecuperado2 = $('#validationRecuperado2').val();
    var validationCondonado2 = $('#validationCondonado2').val();
    var validation_Linea = $('#validationLinea').val();
   var datos = {
       Fecha_notif_retro:Fecha_notif_retro,
       validationRecuperado2: validationRecuperado2,
       validationCondonado2: validationCondonado2,
       validation_Linea: validation_Linea,
       oficio:oficio}
        var jsondata = JSON.stringify(datos);
        // alert(datos);
         $.post('php/Registro_oficio.php', {
             arrayRetro: jsondata
         }, function (data) {
             alert(data);
             location.reload();
         }) ;

}


function crear_folioRetro(oficio) {


    var validationRecuperado2 = $('#validationRecuperado2').val();
    var validationCondonado2 = $('#validationCondonado2').val();
    var validationLinea2 = $('#validationLinea').val();
    var Fecha_notif_retro = $('#Fecha_notif_retro').val();
    
    var datos = {
        oficio: oficio,
        Fecha_notif_retro: Fecha_notif_retro,
        validationRecuperado2: validationRecuperado2,
        validationCondonado2: validationCondonado2,
        validationLinea2: validationLinea2,
    }

    var json = JSON.stringify(datos);
    // alert(json);
    $.post('php/Registro_oficio.php', {
        arrayRetro: json
    }, function (data) {
        alert(data);
        location.reload();
        //  alert(arrayRetro);
    });


}




function FormatCurrency(ctrl) {
    //Check if arrow keys are pressed - we want to allow navigation around textbox using arrow keys
    if (event.keyCode == 37 || event.keyCode == 38 || event.keyCode == 39 || event.keyCode == 40) {
        return;
    }
    var val = ctrl.value;
    val = val.replace(/,/g, "")
    ctrl.value = "";
    val += '';
    x = val.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    ctrl.value = x1 + x2;
}

function CheckNumeric() {
    return event.keyCode >= 48 && event.keyCode <= 57;
}






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

function numero(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
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

function ConfirmarCarga(valor) {
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

function ConfirmarCarga_pagos(valor) {
    $.post("php/validar_carga_masiva.php", {
        pagos: valor
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


//   $(document).ready(function () {
//     $('[data-toggle="tooltip"]').tooltip()
//   });


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




function Agrega_comentario(oficio) {
   var com =  $('#text_com').val();
   var datos = {com:com,
    oficio:oficio};
    if (com != '') {
        $.post("php/Registro_oficio.php", {registra_com:datos}, function (data) {
            muestra_comentarios(oficio);
        })
    }
    else{
        alert('no puedes mandar un comentario vacio')
    }

}

function muestra_comentarios(ofic){
    $.post("php/detalle_oficio.php", {muestra_comentarios:ofic}, function (data) {
      
    }).done(function(respuesta){
		$("#respuesta_coment").html(respuesta);
	})
	.fail(function(){
		console.log("error");
	});
}

