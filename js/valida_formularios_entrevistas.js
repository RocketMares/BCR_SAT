

    function registrar_datos_notif(id_ent) {
        if (($("#estatus_notif").val() < 1) || ($("#fecha_notif").val().length < 1) ) {
            alert('Los datos señalados con el asterisco no deben ser los dados por defecto o en blanco.')
        }else{
            var res_notf = $("#estatus_notif").val();
            var fecha_notif = $("#fecha_notif").val();
            var id_ent = id_ent;
            var datos = {
                id_ent: id_ent,
                res_n: res_notf,
                f_not: fecha_notif
            }
            var json = JSON.stringify(datos);

            $.post("php/valida_registros_ent.php", {datos_n:json},function (data) {
                    alert(data);
                    document.location.reload();
        
            });
        }
    }

    function registrar_fecha_pospuesta_ent(id_ent) { 
        if (($("#posponer_ent").val().length < 1) ) {
            alert('Los datos señalados con el asterisco no deben ser los dados por defecto o en blanco.')
        }else{
            var posp_ent = $("#posponer_ent").val();
            var id_ent = id_ent;
            var datos = {
                id_ent: id_ent,
                posponer: posp_ent
            }
            var json = JSON.stringify(datos);
            $.post("php/valida_registros_ent.php", {datos_ps:json},function (data) {
                    alert(data)
                    document.location.reload();
            });
        }
    }

    function registrar_datos_entrevistado(id_ent) {
        if (($("#fecha_ent").val().length < 1) || ($("#asistencia").val() < 1) || ($("#acuerdos_ent").val().length < 1)) {
            alert('Los datos señalados con el asterisco no deben ser los dados por defecto o en blanco.')
        }else{
            var f_en = $("#fecha_ent").val();
            var asis = $("#asistencia").val();
            var acuer = $("#acuerdos_ent").val();
            var id_ent = id_ent;
            var datos = {
                id_ent: id_ent,
                fecha_ent: f_en,
                asistencia: asis,
                acuerdos: acuer
            }
            var json = JSON.stringify(datos);
            $.post("php/valida_registros_ent.php", {datos_ent:json},function (data) {
                    alert(data)
                    document.location.reload();
            });   
        }
    }

    function registrar_motivos_ent(id_ent) {
        if (($("#cat_adeudo").val() < 1) || ($("#monto_aprox").val().length < 1)) {
            alert('Los datos señalados con el asterisco no deben ser los dados por defecto o en blanco.')
        }else{
            var cat_ad = $("#cat_adeudo").val();
            var monto = $("#monto_aprox").val();
            var id_ent = id_ent;
            var datos = {
                id_ent: id_ent,
                id_motivo: cat_ad,
                monto_aprox: monto
            }
            var json = JSON.stringify(datos);
            $.post("php/valida_registros_ent.php", {datos_mot:json},function (data) {
                    alert(data);
                    document.location.reload();
            });   
        }
    }

    function registrar_insumos_ent(id_ent) {
        if (($("#area_origen").val() == 0) || ($("#rol_edo").val() == 0) || ($("#insumo").val().length < 1)) {
            alert('Los datos señalados con el asterisco no deben ser los dados por defecto o en blanco.')
        }else{
            var area_o = $("#area_origen").val();
            var rol = $("#rol_edo").val();
            var insu = $("#insumo").val();
            var id_ent = id_ent;
            var datos = {
                id_ent: id_ent,
                area_origen: area_o,
                rol_edo: rol,
                insumo: insu
            }
            var json = JSON.stringify(datos);
            $.post("php/valida_registros_ent.php", {datos_in:json},function (data) {
                    alert(data);
                    document.location.reload();
            });   
        }
    }

    function modal_confirmacion() {
     $('#confrmar_desv').modal('toggle')
    }

    function modal_confirmacion_s() {
        $('#confrmar_solventacion').modal('toggle') //beto
    }

    function solventar_caso(id_ent) {
        if ( ($("#desc_solventado").val().length == 0) || ($("#fecha_sol").val().length == 0)) {
            alert('Los datos señalados con el asterisco no deben ser los dados por defecto o en blanco.');
        }else{
            var desc_sol = $("#desc_solventado").val();
            var fecha_solv = $("#fecha_sol").val();
            var id_ent = id_ent;
            var datos = {
                id_ent: id_ent,
                desc_sol:desc_sol,
                fecha_solv:fecha_solv
            }
            var json = JSON.stringify(datos);
            $.post("php/valida_registros_ent.php", {datos_solv:json},function (data) {
                    $("#res_sol").html(data);
            });   
        }
    }

    function modal_confirmacion_act_s() {
        $('#confrmar_solventacion_a').modal('toggle')
    }

    function act_solventar_caso(id_ent) {
        if (($("#solventar").val() == 0) || ($("#desc_solventado_a").val().length < 7) || ($("#fecha_sol_a").val().length < 1)) {
            alert('Los datos señalados con el asterisco no deben ser los dados por defecto o en blanco.')
        }else{
            var estatus_sol = $("#solventar").val();
            var desc_sol = $("#desc_solventado_a").val();
            var fecha_solv = $("#fecha_sol_a").val();
            var id_ent = id_ent;
            var datos = {
                id_ent: id_ent,
                estatus_sol:estatus_sol,
                desc_sol:desc_sol,
                fecha_solv:fecha_solv
            }
            var json = JSON.stringify(datos);
            $.post("php/valida_registros_ent.php", {datos_solv_a:json},function (data) {
                    $("#res_sol").html(data);
            });   
        }
    }

    function registrar_desvirtuo_ent(id_ent) {
        if (($("#desvirtuo").val() == 0) || ($("#desc_desvirtuo").val().length == 0)) {
            alert('Los datos señalados con el asterisco no deben ser los dados por defecto o en blanco.')
        }else{
            var estatus_desv = $("#desvirtuo").val();
            var desc_desv = $("#desc_desvirtuo").val();
            var id_ent = id_ent;
            var datos = {
                id_ent: id_ent,
                est_desv: estatus_desv,
                desc_des: desc_desv
            }
            var json = JSON.stringify(datos);
            $.post("php/valida_registros_ent.php", {datos_desv:json},function (data) {
                    alert(data);
                    document.location.reload();
            });   
        }
    }

    function actualizar_datos_notif(id_ent) {
        if (($("#estatus_notif_a").val() < 1) || ($("#fecha_notif_a").val().length < 1) ) {
            alert('Los datos señalados con el asterisco no deben ser los dados por defecto o en blanco.')
        }else{
            var res_notf = $("#estatus_notif_a").val();
            var fecha_notif = $("#fecha_notif_a").val();
            var id_ent = id_ent;
            var datos = {
                id_ent: id_ent,
                res_n: res_notf,
                f_not: fecha_notif
            }
            var json = JSON.stringify(datos);

            $.post("php/valida_registros_ent.php", {datos_n_a:json},function (data) {
                    alert(data)
                    document.location.reload();
            });
        }
    }

    function actualizar_fecha_pospuesta_ent(id_ent) { 
        if (($("#posponer_ent_a").val().length < 1) ) {
            alert('Los datos señalados con el asterisco no deben ser los dados por defecto o en blanco.')
        }else{
            var posp_ent = $("#posponer_ent_a").val();
            var id_ent = id_ent;
            var datos = {
                id_ent: id_ent,
                posponer: posp_ent
            }
            var json = JSON.stringify(datos);
            $.post("php/valida_registros_ent.php", {datos_ps_a:json},function (data) {
                    alert(data)
                    document.location.reload();
            });
        }
    }

    function actualizar_datos_entrevistado(id_ent) {
        if (($("#fecha_ent_a").val().length < 1) || ($("#asistencia_a").val() < 1) || ($("#acuerdos_ent_a").val().length < 1)) {
            alert('Los datos señalados con el asterisco no deben ser los dados por defecto o en blanco.')
        }else{
            var f_en = $("#fecha_ent_a").val();
            var asis = $("#asistencia_a").val();
            var acuer = $("#acuerdos_ent_a").val();
            var id_ent = id_ent;
            var datos = {
                id_ent: id_ent,
                fecha_ent: f_en,
                asistencia: asis,
                acuerdos: acuer
            }
            var json = JSON.stringify(datos);
            $.post("php/valida_registros_ent.php", {datos_ent_a:json},function (data) {
                    alert(data)
                    document.location.reload();
            });   
        }
    }

    function actualizar_motivos_ent(id_ent) {
        if (($("#cat_adeudo_a").val() < 1)) {
            alert('Los datos señalados con el asterisco no deben ser los dados por defecto o en blanco.')
        }else{
            var cat_ad = $("#cat_adeudo_a").val();
            var monto = ($("#monto_aprox_a").val() > 0 ) ? $("#monto_aprox_a").val() : null;
            var estatus_mot = ($("#estatus_mot").val() != 0 ) ? $("#estatus_mot").val() : null;
            var id_ent = id_ent;
            var datos = {
                id_ent: id_ent,
                id_motivo: cat_ad,
                monto_aprox: monto,
                estatus_mot: estatus_mot
            }
            var json = JSON.stringify(datos);
            $.post("php/valida_registros_ent.php", {datos_mot_a:json},function (data) {
                    alert(data);
                    document.location.reload();
            });   
        }
    }

    function modal_confirmacion_a() {
        $('#confrmar_desv_a').modal('toggle')
    }


    function actualizar_desvirtuo_ent(id_ent) {
        if (($("#desvirtuo_a").val() == 0) || ($("#desc_desvirtuo_a").val().length == 0)) {
            alert('Los datos señalados con el asterisco no deben ser los dados por defecto o en blanco.')
        }else{
            var estatus_desv = $("#desvirtuo").val();
            var desc_desv = $("#desc_desvirtuo").val();
            var id_ent = id_ent;
            var datos = {
                id_ent: id_ent,
                est_desv: estatus_desv,
                desc_des: desc_desv
            }
            var json = JSON.stringify(datos);
            $.post("php/valida_registros_ent.php", {datos_desv_a:json},function (data) {
                    alert(data);
                    document.location.reload();
            });   
        }
    }

    function actualizar_insumos_ent(id_ent) {
        if (($("#area_origen_a").val() == 0) || ($("#rol_edo_a").val() == 0) || ($("#insumo_a").val().length < 1)) {
            alert('Los datos señalados con el asterisco no deben ser los dados por defecto o en blanco.')
        }else{
            var area_o = $("#area_origen_a").val();
            var rol = $("#rol_edo_a").val();
            var insu = $("#insumo_a").val();
            var id_ent = id_ent;
            var datos = {
                id_ent: id_ent,
                area_origen: area_o,
                rol_edo: rol,
                insumo: insu
            }
            var json = JSON.stringify(datos);
            $.post("php/valida_registros_ent.php", {datos_in_a:json},function (data) {
                    alert(data);
                    document.location.reload();
            });   
        }
    }

    function actualizar_prioridad(id_ent) {
        if (($("#prioridad").val() == 0) ) {
            alert('Los datos señalados con el asterisco no deben ser los dados por defecto o en blanco.')
        }else{
            var prioridad = $("#prioridad").val();
            var id_ent = id_ent;
            var datos = {
                id_ent: id_ent,
                priori: prioridad,
            }
            var json = JSON.stringify(datos);
            $.post("php/valida_registros_ent.php", {datos_prioridad:json},function (data) {
                    alert(data);
                    document.location.reload();
            });   
        } 
    }

    /*
    * Dependiendo de la selección de opción de medida de ejemplaridad
    * este remueve lo que este dentro del div con id='formulario'
    * e inserta el codigo html que viene de obtener_formulario.phg
    */
   /*
   ejecutaba el modal de cmedida ejemplar
    $(document).ready(function() {
        $("#tipo_medida").change(function () {
        $("#formulario").find('h3').remove().end()
        $("#tipo_medida option:selected").each(function () {
            tipo_medida = $(this).val();
            $.post("php/obtener_formulario.php",{tipo:tipo_medida},function (data) {
            $("#formulario").html(data);
            })
        })
        })
    });*/

   /*
    * Manda a llamar el modal de confirmación de medida 
    * de ejemplaridad.
    */
    function confirmar_medida() { 
        $('#confirmar_medida').modal('toggle')
    }
    function confirmar_contri() { 
        $('#confirmar_contri').modal('toggle')
    }
    function confirmar_pago() { 
        $('#confirmar_pago').modal('toggle')
    }
    function confirmar_reasignacion() { 
        $('#confirmar_reasignacion').modal('toggle')
    }



    function Modal_cambio_numero_ofico() {
        var oficio = 1 
        $.post("php/inserta_actualizacion_medida.php", {num_oficio:oficio},function (data) {
            $("#insertar_cat").html(data);
        });
        $("#actualizar_cat").modal({backdrop: 'static', keyboard: false})
    }

    function cambiar_numero_oficio() { 
        if (($("#numero_oficio_a_c").val().lenght <= 14) ) {
            alert('Debe de ser un numero de oficio valido')
        }else{
            var numero = $("#numero_oficio_a_c").val();
            var numero_ter = numero+"-";
            var datos = {
                numero: numero
            }
            var json = JSON.stringify(datos);
            $.post("php/valida_registros_ent.php", {act_num_ofi:json},function (data) {
                    var respuesta = data;
                    if (respuesta == true) {
                        alert("Se registro el numero de oficio nuevo.\nYa se enncuentra disponible el determinante ahora para todos.")
                        $("#etiqueta_oficio").text(numero_ter);
                    } else {
                        alert(respuesta)
                        document.location.reload();
                    }
            });   
        }
    }

    function Actualizar_medida_ejemplar_cance(id_medida) {
        if ($("#detalles_medida_a").val().length < 10 || $("#estatus_bloq").val().length == 0) {
            alert('Error: Los campos marcados con asterico no pueden ser dejados en blanco y ser una opción valida.');
        }else{
            if($("#numero_oficio_a").val().length ==3){
                var num_nuevo = $("#numero_oficio_a").val();
            }
            else{
                var num_nuevo = $("#etiqueta_oficio").text()+$("#numero_oficio_a").val();
            }
            var detalles = $("#detalles_medida_a").val();
            var of_etiqueta=$("#etiqueta_oficio").text();
            var of_num=$("#numero_oficio_a").val();
            var elab_ofic = $("#elaboro_oficio").val();
            var elab_bloq = $("#elaboro_bloq").val();
            var SIFEN = $("#SIFEN").val();
            var SIREFE = $("#SIREFE").val();
            var fecha_despacho = $("#fecha_despacho").val();
            var buzon = $("#buzon").val();
            var ARCA = $("#ARCA").val();
            var fecha_oficialia = $("#fecha_oficialia").val();
            var fecha_notif = $("#fecha_notif_cance_a").val();
            var medio = $("#medio").val();
            var fecha_autentifica = $("#fecha_autentifica").val();
            var fecha_bloqueo = $("#fecha_bloq").val();
            var aclaracion = $("#aclaracion").val();
            var estatus = $("#estatus_medida").val();
            var estatus_bloq = $("#estatus_bloq").val();
            var defensa = $("#defensa").val();
            var detalle_defensa = $("#detalle_defensa").val();
                
          
                var datos = {

                    detalles: detalles,
                    num_nuevo: num_nuevo,
                    of_etiqueta:of_etiqueta,
                    of_num:of_num,            
                    elab_ofic:elab_ofic,
                    elab_bloq:elab_bloq,        
                    SIFEN:SIFEN,
                    SIREFE:SIREFE,
                    fecha_despacho:fecha_despacho,
                    buzon:buzon,
                    ARCA:ARCA,
                    fecha_oficialia:fecha_oficialia,
                    fecha_notif: fecha_notif,  
                    medio:medio,
                    fecha_autentifica:fecha_autentifica,
                    fecha_bloqueo: fecha_bloqueo,
                    aclaracion:aclaracion,
                    estatus: estatus,
                    estatus_bloq:estatus_bloq,
                    id_medida: id_medida,
                    defensa: defensa,
                    detalle_defensa: detalle_defensa
                };
         
           var json = JSON.stringify(datos);
            $.post("php/    ", {medida_cance:json},function (data) {
                alert(data);  
                document.location.reload();
            });
        }
    }

    function Confirmar_actualizar_fecha_notif() {
        $('#confirmar_medida_a').modal('show');
    }

    function Actualizar_fecha_notif_audi(id_medida) {
        if ($("#fecha_notif_audi_a").val().length < 5 ) {
            alert('Errorts: Los campos marcados con asterico no pueden ser dejados en blanco y ser una opción valida.');
        }else{
            var fecha_notif = $("#fecha_notif_audi_a").val();
                var datos = {
                    id_medida: id_medida,
                    fecha_notif: fecha_notif
                };
           var json = JSON.stringify(datos);
            $.post("php/valida_registros_ent.php", {act_fe_auto:json},function (data) {
                var resultado = data;
                if (resultado == true) {
                    alert('Fecha de notificación actualizada correctamente.');
                    location.reload();
                } else {
                    alert('Error:\n'+data);
                } 
            });
        }
    }

    function Confirmar_actualizar_fecha_cance_bloq() {
        $('#confirmar_medida_a').modal('show');
    }

    function Actualizar_fecha_cance_bloq(id_medida) {
        if ($("#fecha_cance_a").val().length < 5 ) {
            alert('Error: Los campos marcados con asterico no pueden ser dejados en blanco y ser una opción valida.');
        }else{
            var fecha_notif = $("#fecha_cance_a").val();
                var datos = {
                    id_medida: id_medida,
                    fecha_notif: fecha_notif
                };
           var json = JSON.stringify(datos);
            $.post("php/valida_registros_ent.php", {act_fe_auto:json},function (data) {
                var resultado = data;
                if (resultado == true) {
                    alert('Fecha de notificación actualizada correctamente.');
                    location.reload();
                } else {
                    alert('Error:\n'+data);
                } 
            });
        }
    }

   /*
    * Esta función valida los datos de los formularios
    * debido a que pueden variar los formularios
    * por la selección de medida de ejemplaridad
    */

    function registrar_medida_ejemplar(id_ent) {
        if (($("#detalles_medida").val().length < 10) || ($("#tipo_medida").val() == 0) ) {
            alert('Los datos señalados con el asterisco no deben ser los dados por defecto o en blanco.')
        }else{
          
            var detalle = $("#detalles_medida").val();
            var tipo = $("#tipo_medida").val();
            var id_ent = id_ent;
            var datos = {
                    id_ent: id_ent,
                    detalle_medida: detalle,
                    tipo_medida:tipo
                }         
                var json = JSON.stringify(datos);
           
                    $.post("php/valida_registros_ent.php", {datos_medida_audi:json},function (data) {
                    $("#result").html(data);

                }); 
            } 
        }
            
            /*
            if ($("#tipo_medida").val() == "AUDITORIA") {
                var detalle = $("#detalles_medida").val();
                var tipo = $("#tipo_medida").val();
                var nombre_des = $("#nombre_destinatario").val();
                var fecha_notif = $("#fecha_notif_audi").val();
                var id_ent = id_ent;
                if (fecha_notif.length < 1) {
                    alert('Los datos señalados con el asterisco no deben ser los dados por defecto o en blanco.')
                } else {
                    var datos = {
                        id_ent: id_ent,
                        detalle_medida: detalle,
                        tipo_medida: tipo,
                        persona_dirigida: nombre_des,
                        fecha_notif:fecha_notif
                    }
                    var json = JSON.stringify(datos);
                    $.post("php/valida_registros_ent.php", {datos_medida_audi:json},function (data) {
                        $("#result").html(data);
                    }); 
                }
                
            } else {
                var detalle = $("#detalles_medida").val();
                var tipo = $("#tipo_medida").val();
                var oficio = $("#oficio").val();
                var fecha_notif = $("#fecha_notif_c").val();
                var medio = $("#medio_notif").val();
                if (oficio ==  null || fecha_notif.length < 1 || medio == 0) {
                    alert('Los datos señalados con el asterisco no deben ser los dados por defecto o en blanco.')
                } else {
                    var datos = {
                        id_ent: id_ent,
                        detalle_medida: detalle,
                        tipo_medida: tipo,
                        num_oficio: oficio,
                        fecha_notif:fecha_notif,
                        medio_notif: medio
                    }
                    var json = JSON.stringify(datos);
                    $.post("php/valida_registros_ent.php", {datos_medida_c:json},function (data) {
                        $("#result").html(data);
                    });
                }
            }*/
     
    function Caraga_individual_contri() {
        if (($("#RFC").val().length < 4) || ($("#Rason_Social").val().length < 5)|| ($("#no_empleado").val().length < 5)|| ($("#Fecha_vig").val().length < 1) ) {
            alert('Los datos señalados con el asterisco no deben ser los dados por defecto o en blanco.')
        }else{
         
            var RFC = $("#RFC").val();
            var oficio = $("#oficio").val();
            var Razon_social = $("#Rason_Social").val();
            var F_Programada = $("#Fecha_Prog").val();
            var F_Vigencia = $("#Fecha_vig").val();
            var Prioridad = $("#Prioridad").val();
            var No_empleado = $("#no_empleado").val();
                var datos = {
                    RFC: RFC,
                    oficio:oficio,
                    Razon_social: Razon_social,
                    F_Programada: F_Programada,
                    F_Vigencia: F_Vigencia,
                    Prioridad: Prioridad,
                    No_empleado: No_empleado
                }
        

                var json = JSON.stringify(datos);
                $.post("php/valida_registros_ent.php", {datos_Carga_Contri:json},function (data) {
                    $("#result").html(data);
                });
            
        } 
    }
    function Caraga_individual_pago() {
       // alert($("#Periodo_Req").val());
        if (($("#RFC1").val().length < 4) || ($("#Periodo_Req").val() == 0)|| ($("#Ejercicio_Req").val().length < 4)|| ($("#Fecha_pago").val() == 0)|| ($("#Llave").val().length < 5)|| ($("#Renglon").val() == 0)|| ($("#Importe_Efectivo").val().length == 0) ) {
            alert('Los datos señalados con el asterisco no deben ser los dados por defecto o en blanco.')
        }else{
         
            var RFC = $("#RFC1").val();
            var Periodo= $("#Periodo_Req").val();
            var Ejercicio = $("#Ejercicio_Req").val();
            var Fecha_pago = $("#Fecha_pago").val();
            var Llave = $("#Llave").val();
            var Renglon = $("#Renglon").val();
            var Importe = $("#Importe_Efectivo").val();
            var Virtual = $("#Virtual").val();
           
                var datos = {
                    RFC: RFC,
                    Periodo: Periodo,
                    Ejercicio: Ejercicio,
                    Fecha_pago: Fecha_pago,
                    Llave: Llave,
                    Renglon: Renglon,
                    Importe: Importe,
                    Virtual: Virtual

                }
        

                var json = JSON.stringify(datos);
                $.post("php/valida_registros_ent.php", {datos_Carga_Pagos:json},function (data) {
                    $("#result").html(data);
                });
            
        } 
    }

    function reasignar() {
        // alert($("#Periodo_Req").val());
         if (($("#Entrevista").val().length < 4) || ($("#Analista").val().length < 4 ) ) {
             alert('Los datos señalados con el asterisco no deben ser los dados por defecto o en blanco.')
         }else{
          
             var Entrevista = $("#Entrevista").val();
             var Analista= $("#Analista").val()
            
                 var datos = {
                    Entrevista: Entrevista,
                     Analista: Analista,
                 }
         
                 var json = JSON.stringify(datos);
                 $.post("php/valida_registros_ent.php", {datos_reasignar:json},function (data) {
                     $("#result").html(data);
                 });
             
         } 
     }

   /*
    * Manda a llamar el modal para registrar la medida de ejemplaridad
    */
    function modal_medida() {
        $('#Registrar_medida_eje').modal({backdrop: 'static', keyboard: false})
    }
    function modal_confirma_medida() {
        $('#Confirmar_medida_eje').modal({backdrop: 'static', keyboard: false})
    }


    /*
    * Habilita el formulario para editar alguna medida de ejemplaridad
    * en el caso de las medidas de cancelación aplicadas
    */
    function Actualizar_medida(id_medida) {
        $.post("php/inserta_actualizacion_medida.php", {id_medida:id_medida},function (data) {
                $("#editar").html(data);
        });
        $("#Actualizar_medida_eje").modal({backdrop: 'static', keyboard: false})
    }

    function Actualizar_medida_auditor() {
        var audi = 1 
        $.post("php/inserta_actualizacion_medida.php", {auditor:audi},function (data) {
            $("#insertar_cat").html(data);
        });
        $("#actualizar_cat").modal({backdrop: 'static', keyboard: false})
    }

    function registrar_auditor() {
        if ($("#nombre_auditor_n").val().length < 5) {
            alert('Error: El nombre no puede ser tan corto ni tampoco puede dejarse en blanco.')
        } else {
            var nombre_audi = $("#nombre_auditor_n").val();
            var datos = {
                auditor: nombre_audi,
            };
            var json = JSON.stringify(datos);
            $.post("php/valida_registros_ent.php", {auditor_n:json},function (data) {
                alert(data);
                var html = "<input type='text' class='form-control' id='nombre_auditor_a' name='nombre_auditor_a' placeholder=''  value='"+nombre_audi+"' aria-describedby='button-addon1' readonly>"
                $("#input_audi").html(html);      
            });
            $('#actualizar_cat').modal('hide') 
        }
    }

    function select_auditor(){
        if (($("#select_audi").val() == null) ) {
            alert('Los datos señalados con el asterisco no deben ser los dados por defecto o en blanco.')
        }else{
           
   
                var nombre_audi = $("#select_audi").val();
                var datos = {
                    auditor: nombre_audi,
                };
                var json = JSON.stringify(datos);
                $.post("php/valida_registros_ent.php", {auditor_n2:json},function (data) {
                    alert(data);
                    var html = "<input type='text' class='form-control' id='nombre_auditor_a' name='nombre_auditor_a' placeholder=''  value='"+nombre_audi+"' aria-describedby='button-addon1' readonly>"
                    $("#input_audi").html(html);      
                });

                $('#actualizar_cat').modal('hide') 


        }
    }


    function Confirmar_actualizacion_medida_audi(id_medida) {
        if ($("#detalles_medida_a").val().length < 10 || $("#fecha_notif_audi_a").val().length < 3 || $("#fecha_notif_audi_a").val() == 0 ) {
            alert('Error: Los campos marcados con asterico no pueden ser dejados en blanco y ser una opción valida.');
        }else{
            var nombre_audi = $("#nombre_auditor_a").val();
            var detalles = $("#detalles_medida_a").val();
            var fecha_notif = $("#fecha_notif_audi_a").val();
            var estatus = $("#estatus").val();
            var datos = {
                id_medida: id_medida,
                nombre_auditor: nombre_audi,
                detalles: detalles,
                fecha_notif: fecha_notif,
                estatus: estatus
            };
            var json = JSON.stringify(datos);
            $.post("php/valida_registros_ent.php", {medida_audi:json},function (data) {
                alert(data);
                location.reload();    
            });
        }
    }

    function Modal_confirmar_actualizacion_medida_audi() {
        $('#confirmar_medida_a').modal('show')
    }
    function Ver_modal_doc_bloq(id_ent) {
        var id_entrevista=id_ent;
        $('#Modal_doc_bloq').modal('show')
    }


    function Ver_modal_seg() {
        $('#Modal_seguimiento').modal('show')
    }

    function confirmar_seg() {
        $('#confirmar_seguimiento').modal('show')
    }
    function confirmar_doc() {
        $('#confirmar_documento').modal('show')
    }


    function registrar_seguimiento() {
        if ($("#fecha_seg").val().length < 6 || $("#detalles_seg").val().lenght < 5 ) {
            alert('Error: Los campos marcados con asterico no pueden ser dejados en blanco y/o ser una opción valida.');
        }else{
            var form_data = new FormData();    
            form_data.append('archivo_seg', $('#archivo_seg')[0].files[0]);
            form_data.append('fecha_seg', $("#fecha_seg").val());
            form_data.append('detalles_seg', $("#detalles_seg").val());
            $.ajax({
                url: 'php/valida_registros_ent.php',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(respuesta){
                    $("#result_seg").html(respuesta);
                }
             });
        }
    }
    function registrar_doc() {
        if ($("#fecha_doc").val().length < 6 || $("#detalles_doc").val().lenght < 5 ) {
            alert('Error: Los campos marcados con asterico no pueden ser dejados en blanco y/o ser una opción valida.');
        }else{
            var form_data_doc = new FormData();    
            form_data_doc.append('archivo_doc', $('#archivo_doc')[0].files[0]);
            form_data_doc.append('fecha_doc', $("#fecha_doc").val());
            form_data_doc.append('detalles_doc', $("#detalles_doc").val());
            $.ajax({
                url: 'php/valida_registros_ent.php',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data_doc,                         
                type: 'post',
                success: function(respuesta){
                    $("#result_doc").html(respuesta);
                }
             });
        }
    }
    function documento_seguimiento(id_seg) {
        location.href = "php/descargar_docs.php?id_seguimiento="+id_seg
    }
    function documento_bloq(id_bloq) {
        location.href = "php/descargar_docs.php?id_Docuemtno="+id_bloq
    }

    /*
    * Una vez que se cierra la ventana del formulario de retroalimentación
    * este metodo renueva la ventana para que el usuario pueda ver
    * las afectaciones del sistema.
    */
    $(document).ready(function () {
        $("#ventana").click(function (e) { 
            e.preventDefault();
            location.reload();
        });
    });

    

    /*
    * Les da la opción de desplegar un calendario a los id's 
    * mecionados y a las clases mencionadas también.
    * Algo adicional es que para elementos html generados despues
    * de cargar la vista no podran usarlos.
    * Se recomienda mandar a llamar tambien las funciones una vez
    * creados los elementos nuevos.
    */

    $(document).ready(function () {
        $('.fecha_end').datepicker({
            endDate: "today",
            autoclose: true,
            daysOfWeekDisabled: [0, 6],
            todayHighlight: true,
            format: "yyyy/mm/dd",
            toggleActive: true,
            language: 'es'
        });

        $('.fecha_det').datepicker({
            endDate: "today",
            autoclose: true,
            daysOfWeekDisabled: [0, 6],
            todayHighlight: true,
            format: "yyyy/mm/dd",
            toggleActive: true,
            language: 'es'
        });
        
        $('.fecha_start').datepicker({
            startDate: "today",
            autoclose: true,
            daysOfWeekDisabled: [0, 6],
            todayHighlight: true,
            format: "yyyy/mm/dd",
            toggleActive: true,
            language: "es"
        });
        
        $('.fecha').datepicker({
            autoclose: true,
            daysOfWeekDisabled: [0, 6],
            todayHighlight: true,
            format: "yyyy/mm/dd",
            toggleActive: true,
            language: "es"
        });
        
        $('#fecha_notif').datepicker({
            endDate: "today",
            autoclose: true,
            daysOfWeekDisabled: [0, 6],
            todayHighlight: true,
            format: "yyyy/mm/dd",
            toggleActive: true,
            language: "es"
        });

        $('#fecha_notif_m').datepicker({
            endDate: "today",
            autoclose: true,
            daysOfWeekDisabled: [0, 6],
            todayHighlight: true,
            format: "yyyy/mm/dd",
            toggleActive: true,
            language: "es"
        });
        
        $('#posponer_ent').datepicker({
           // startDate: "today",
            autoclose: true,
            daysOfWeekDisabled: [0, 6],
            todayHighlight: true,
            format: "yyyy/mm/dd",
            toggleActive: true,
            language: "es"
        });
        
        $('#fecha_ent').datepicker({
          //  startDate: "today",
            autoclose: true,
            daysOfWeekDisabled: [0, 6],
            todayHighlight: true,
            format: "yyyy/mm/dd",
            toggleActive: true,
            language: "es"
        });
        
        $('#Fecha_Prog').datepicker({
           // endDate: "today",
            autoclose: true,
            daysOfWeekDisabled: [0, 6],
            todayHighlight: true,
            format: "yyyy/mm/dd",
            toggleActive: true,
            language: "es"
        });
        $('#Fecha_vig').datepicker({
            //endDate: "today",
            autoclose: true,
            daysOfWeekDisabled: [0, 6],
            todayHighlight: true,
            format: "yyyy/mm/dd",
            toggleActive: true,
            language: "es"
        });
        $('#Fecha_pago').datepicker({ 
            endDate: "today",
            autoclose: true,
            daysOfWeekDisabled: [0, 6],
            todayHighlight: true,
            format: "yyyy/mm/dd",
            toggleActive: true,
            language: "es"
        });
         $('#Fecha_notif_retro').datepicker({ 
            endDate: "today",
            autoclose: true,
            daysOfWeekDisabled: [0, 6],
            todayHighlight: true,
            format: "yyyy/mm/dd",
            toggleActive: true,
            language: "es"
        });
    });




