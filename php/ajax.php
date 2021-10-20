<?php



function json_output($status=200, $msg = 'OK', $data = null){
    header('Content-Type: application/json');
    echo json_encode(['status' => $status,
                     'msg'=>$msg,
                     'data'=>$data]);
                     die;
}

//validamos la existencia del parametro del archivo
if (!isset($_FILES['file'])) {
    json_output(403,'Archivo no valido');
}
$file = $_FILES['file'];
$path = '../Archivos/';
if (!is_dir($path)) {
    mkdir($path);
}

$uploaded = move_uploaded_file($file['temp_name'],$path.$file['name']);
if (!$uploaded) {
    json_output(400,'Hubo un error al subir el archivo...');

}

json_output(200,'Archivo subido con exito', $path.$file['name']);
?>