    //----------------COMBOS---------------//FILTROS------------------

    $(document).ready(function(){

        $('#sub_admin').change(function() {
            $('#sub_admin option:selected').each(function(){
                sub = $(this).val();
                admin= $('#id_admin').val();
                datos={
                    admin:admin,
                    sub:sub
                }
                $.post("php/combos_oficios.php",{datos:datos},function(data){
                }).done(function(respuesta){
                    $('#depto').html(respuesta);
                })
            })
        })
    
        $('#filtra_estructura').on('click',function(){
            sub = $('#sub_admin').val();
            dep = $('#depto').val();

 

             if (sub != 0 && dep != 0 || dep != 0)  {
                  createCookie("sub",sub,1)
                  createCookie("dep",dep,1)
                  location.href="index.php?Estructura=1";
             }
             else{
               alert('No puedes dejar el campo de subadministracion o departamento vacio para activar este filtro');
          }
            
        })
        $('#filtra_oficio').on('click',function(){
            oficio = $('#FiltroOficio').val();
          
             if (oficio != '')  {
                  createCookie("oficio",oficio,1)
                  location.href="index.php?Oficio=1";
             }
             else{
                  alert('No puedes dejar el campo de oficio vacio para activar este filtro');
             }
            
        })
         $('#filtra_Gestor_wb').on('click',function(){
             gestor = $('#FiltroGestor').val();
             
   
              if (gestor != '')  {
                   createCookie("gestor",gestor,1)
                   location.href="index.php?Gestor=1";
                
              }
              else{
               alert('No puedes dejar el campo de folio de Gestor vacio para activar este filtro');
          }
            
         })
         
         $('#filtra_por_deter').on('click',function(){
             det = $('#FiltroDet').val();
              console.log(det)
              if (det != '')  {
                   createCookie("Deter",det,1)
                   location.href="index.php?det=1";
                 
              
              }
              else{
               alert('No puedes dejar el campo de Num. determinante vacio para activar este filtro');
          }
         })
         $('#filtra_por_prioridades').on('click',function(){
             prioridad = $('#prioridad').val();
           
              if (prioridad != 0)  {
                   createCookie("prioridad",prioridad,1)
                   location.href="index.php?Prioridad=1";
              } else{
               alert('Debes seleccionar una opcion en prioridad para activar este filtro');
          }
            
         })
    });

    
