<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">

    <title>Hello, world!</title>
  </head>
  <body>
    <h1>Hello, world!</h1>

    <div class="col-md-4 mb-3">
              <label for="validationServer01">Folio Gestor Web: <samp class="text-danger">*</samp></label>
              <input type="text" class="form-control " name="validationFolioGW" id="validationFolioGW"
                placeholder="Folio Gestor" data-inputmask="'Mask':'9999999999-9','autoUnmask' : true"  required>
            </div><div class="col-md-4 mb-3">
              <label for="validationServer01">Folio Gestor Web: <samp class="text-danger">*</samp></label>
              <input type="text" class="form-control " name="validationFolioGW" id="validationFolioGW"
                placeholder="Folio Gestor" data-inputmask="'Mask':'9999999999-9','autoUnmask' : true"  required>
            </div>


<button class="btn btn-primary" onclick="trae()"> trae el modal </button>

    <div class="modal fade" id="Detalle_of" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
      <div class="col-md-4 mb-3">
              <label for="validationServer01">Folio Gestor Web: <samp class="text-danger">*</samp></label>
              <input type="text" class="form-control " name="validationFolioGW" id="validationFolioGW"
                placeholder="Folio Gestor" data-inputmask="'Mask':'9999999999-9','autoUnmask' : true"  required>
            </div>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


<script>

function trae(){
  $('#Detalle_of').modal();
}

</script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.1.1.js" ></script>
    <script src="js/Popper.min.js" ></script>
    <script src="js/bootstrap.min.js"></script> 
    
    <script src="js/jquery.inputmask.js"></script> 
    <script src="js/inputmask.binding.js"></script>
    <!-- <script src="js/jquery-3_002.js"></script> 
    <script src="js/jquery.min.js"></script> -->


  </body>
</html>