function actualizar(){location.reload(true);}

var t=null;
function contadorInactividad() {
  t=setTimeout("actualizar()",900000);
}
window.onblur=window.onmousemove=function() {
  if(t) clearTimeout(t);
  contadorInactividad();
}
