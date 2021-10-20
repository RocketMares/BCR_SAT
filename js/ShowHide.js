$(document).ready(function(){
    $("select").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $(".box").not("." + optionValue).hide();
                $("." + optionValue).show();
            } else{
                $(".box").hide();
            }
        });
    }).change();
  });

  // A las variables a continuación las bloquea para no permitir texto

$('input#validationNoOficio')
.keypress(function (event) {
  // El código del carácter 0 es 48
  // El código del carácter 9 es 57
  if (event.which < 48 || event.which > 57 || this.value.length === 12) {
    return false;
  }
});

$(document).ready(function () {
$('input#validationNoOficio')
  .keypress(function (event) {
    if (event.which < 48 || event.which > 57 || this.value.length === 12) {
      return false;
    }
  });
});

// Sigiente

$('input#validationFolioGW')
.keypress(function (event) {
  // El código del carácter 0 es 48
  // El código del carácter 9 es 57
  if (event.which < 48 || event.which > 57 || this.value.length === 12) {
    return false;
  }
});

$(document).ready(function () {
$('input#validationFolioGW')
  .keypress(function (event) {
    if (event.which < 48 || event.which > 57 || this.value.length === 12) {
      return false;
    }
  });
});


// Sigiente

$('input#FiltroOficio')
.keypress(function (event) {
  // El código del carácter 0 es 48
  // El código del carácter 9 es 57
  if (event.which < 48 || event.which > 57 || this.value.length === 12) {
    return false;
  }
});

$(document).ready(function () {
$('input#FiltroOficio')
  .keypress(function (event) {
    if (event.which < 48 || event.which > 57 || this.value.length === 12) {
      return false;
    }
  });
});


// Sigiente




// Boton ocultar
$(document).ready(function(){
  $("#botonocultamuestra").click(function(){
	 $("#divocultamuestra").each(function() {
	   displaying = $(this).css("display");
	   if(displaying == "block") {
		 $(this).fadeOut('slow',function() {
		  $(this).css("display","none");
		 });
	   } else {
		 $(this).fadeIn('slow',function() {
		   $(this).css("display","block");
		 });
	   }
	 });
   });
 });



