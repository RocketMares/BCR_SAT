<?php
if (isset($_GET["id_usuario"])) {

    require_once 'fpdf.php';
    require_once 'MetodosUsuarios.php';
    $id_empleado = $_GET["id_usuario"];

    $usuario_1 = new MetodosUsuarios();
    $objUsuario = $usuario_1->Para_responsiva($id_empleado);
    $nombre = $objUsuario["nombre_empleado"];
    $rfc = $objUsuario["rfc_corto"];
    $fechaAut = $objUsuario["fecha_alta"]->format('d-m-Y');
    $rfcAut = $objUsuario["user_alta"];
    $correo = $objUsuario["correo"];
    $Perfil = $objUsuario["nombre_perfil"];
    $Departamento = $objUsuario["nombre_depto"];
    $admin = $objUsuario["id_admin"];
    $Aut = $usuario_1->Para_responsiva1($id_empleado,$admin);
    $nombreAut = $Aut["jefe"];
    $rfcAut = $Aut["rfc_jefe"];
    $CorreoAut = $Aut["correo_jefe"];


    //Constante del FPDF de donde jala la fuente
    define('FPDF_FONTPATH', 'font/');
    //Objeto FPDF
    $pdf = new FPDF();
    //Creamos un documento
    $pdf->AddPage();
    date_default_timezone_set('America/Mexico_City');
    $pdf->SetTitle('BCR SAT | Carta responsiva');

    $pdf->Image('../img/logo.png', 110, 5, 90, 17);
  
    $pdf->SetFont('Arial', '', 10);

    $pdf->Text(122, 32, utf8_decode('Administración Desconcentrada de Recaudación'));
    $pdf->Text(43, 36, utf8_decode('Administración Desconcentrada de Recaudación Distrito Federal "4" con sede en el Distrito Federal'));

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Text(12, 48, utf8_decode('CARTA RESPONSIVA PARA CUENTA DE ACCESO A LOS SISTEMAS'));
    $pdf->Text(12, 52, utf8_decode('INFORMÁTICOS Y/O SERVICIOS ELECTRÓNICOS DE INFORMACIÓN DEL'));
    $pdf->Text(12, 56, utf8_decode('SERVICIO DE ADMINISTRACIÓN TRIBUTARIA'));


    $pdf->SetFont('Arial', '', 12);
    $pdf->Text(40, 68, utf8_decode('Por este medio el (la) que suscribe '));
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Text(110, 68, utf8_decode($nombre));
    $pdf->SetFont('Arial', '', 12);
    $pdf->Text(12, 72, utf8_decode('declaro y acepto que desde el '));
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Text(70, 72, utf8_decode($fechaAut));
    $pdf->SetFont('Arial', '', 12);
    $pdf->Text(93, 72, utf8_decode('recibí la autorización que me permite ingresar al sistema'));
    $pdf->Text(12, 76, utf8_decode('informático denominado'));
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Text(58, 76, utf8_decode('BCR SAT'));
    $pdf->SetFont('Arial', '', 12);
    $pdf->Text(90, 76, utf8_decode(', mediante el acceso a la PC que tengo bajo mi resguardo,'));
    $pdf->Text(12, 80, utf8_decode('para lo cual se señalan los siguientes datos de referencia:'));

    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Text(15, 92, utf8_decode('DATOS DEL EMPLEADO'));
    $pdf->SetFont('Arial', '', 11);
    $pdf->Text(20, 96, utf8_decode('RFC corto:'));
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Text(40, 96, utf8_decode($rfc));
    $pdf->SetFont('Arial', '', 11);
    $pdf->Text(20, 100, utf8_decode('Correo electrónico:'));
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Text(54, 100, utf8_decode($correo));
    $pdf->SetFont('Arial', '', 11);
    $pdf->Text(20, 104, utf8_decode('Departamento:'));
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Text(47, 104, utf8_decode($Departamento));

    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Text(15, 112, utf8_decode('DATOS DE ACCESO AL SISTEMA'));
    $pdf->SetFont('Arial', '', 11);
    $pdf->Text(20, 116, utf8_decode('Usuario:'));
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Text(36, 116, utf8_decode($rfc));
    $pdf->SetFont('Arial', '', 11);
    $pdf->Text(20, 120, utf8_decode('Contraseña temporal:'));
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Text(58, 120, utf8_decode('123456'));
    $pdf->SetFont('Arial', '', 11);
    $pdf->Text(20, 124, utf8_decode('Privilegio otorgado:'));
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Text(54, 124, utf8_decode($Perfil));

    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Text(15, 131, utf8_decode('DATOS DEL AUTORIZADOR'));
    $pdf->SetFont('Arial', '', 11);
    $pdf->Text(20, 135, utf8_decode('Nombre completo:'));
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Text(52, 135, utf8_decode($nombreAut));
    $pdf->SetFont('Arial', '', 11);
    $pdf->Text(20, 139, utf8_decode('RFC corto:'));
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Text(40, 139, utf8_decode($rfcAut));
    $pdf->SetFont('Arial', '', 11);
    $pdf->Text(20, 143, utf8_decode('Correo electrónico:'));
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Text(54, 143, utf8_decode($CorreoAut));

    $pdf->SetFont('Arial', '', 9);
    $pdf->Ln(140);
    $pdf->MultiCell(195, 3, utf8_decode('Lo anterior, en virtud de las funciones que tengo conferidas como empleado del Servicio de Administración Tributaria y de conformidad con el Manual Administrativo de Aplicación General en Materia de Tecnologías de la Información y Comunicaciones vigente, así como de los de Operación en Materia de Seguridad de la Información (emitido mediante Oficio Circular 103-2011-146) que se encuentran disponibles en el Sistema único de Normatividad (SUN) accesibles en http://192.168.220.192/sun/drvisapi.dll, y son de mi entero conocimiento y dominio, de conformidad con lo dispuesto en el artículo 6 del Reglamento Interior del Servicio de Administración Tributaria en vigor. 
                            La contraseña que se otorga para mi cuenta de usuario es de manera temporal por lo que a partir de este momento sólo podrá ser utilizada para establecer una contraseña propia, dicha contraseña será de mi único y exclusivo conocimiento en el entendido de que el uso y manejo de la cuenta de usuario recibida y mi propia contraseña establecida, lo hará de conformidad con las políticas y procedimientos de Seguridad Informática vigentes en el Servicio de Administración Tributaria.
                            Por tal motivo, a partir de este momento mi cuenta de usuario y contraseña son confidenciales, personales e intransferibles, por lo que el préstamo, divulgación o mal uso de las mismas, me será imputable como usuario de las mismas. Asimismo, manifiesto tener conocimiento de que los activos de información a los que tenga acceso a través de la cuenta de usuario que me ha sido asignada en este acto son propiedad del Servicio de Administración Tributaria y que los privilegios de información me son otorgados para el desempeño exclusivo de las funciones que me han sido encomendadas, así como aquellas que sean designadas de forma directa por necesidades del servicio y forman parte de la reserva fiscal en términos del artículo 69 del Código Fiscal de la Federación y está clasificada como reservada de acuerdo a lo previsto en los artículos 13 fracción V y 14 fracciones I y II de la Ley Federal de Transparencia y Acceso a la Información Pública Gubernamental.
                            Por lo anterior, tengo conocimiento y entendimiento de la obligación de dar cumplimiento a la normatividad aplicable para el adecuado uso de la cuenta de usuario y contraseña así como de guardar absoluta y estricta confidencialidad sobre las mismas y de la documentación e información a la que tenga acceso con ellas, sabedor de las consecuencias legales que conforme a la legislación federal vigente en materia de responsabilidades administrativas y/o penales apliquen las autoridades competentes al incumplir con dichas obligaciones, así como al, modificar, copiar, utilizar o sustraer ilícita y/o indebidamente inutilizar, destruir o provocar pérdida de la información contenida en los sistemas o equipos de informática del Servicio de Administración Tributaria, violentando lo contenido en los artículos 7, 8 fracción V y 13 Administrativas de los Servidores Públicos; lo contenido en los artículos 210 y 211 BIS 1, 211 BIS 2, 211 BIS 3 y 214 del Código Penal Federal, así como de los demás delitos que puedan resultar por el uso de la información obtenida con la cuenta de usuario que me es otorgada por el Servicio de Administración Tributaria en este acto. En este mismo acto, asumo el compromiso del legal y buen uso de la cuenta de usuario y mi propia contraseña personalmente establecida y me obligo a no revelarlas bajo ningún concepto, declarándome responsable de su uso y de la información que con ellas se conozca, sustraiga, modifique o altere, de los sistemas y subsistemas informáticos que pertenecen al Servicio de Administración Tributaria.'), 0, 'J');

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Text(100, 255, utf8_decode('_______________________________'));
    $pdf->Text(130, 260, utf8_decode('FIRMA'));

    $pdf->Close();
    $pdf->Output();
}
