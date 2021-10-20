<?php

class ConexionSQL
{
    public function ObtenerConexionBD()
    {
        $BD_NAME = 'ControlSAT';
        $USER = 'Analisis';
        $pass = 'Malitos20';
         $ServerName = '99.85.24.8';
        //$ServerName = 'M299MOCE7194C03';
        $connectionInfo = ['Database' => "$BD_NAME",
         'CharacterSet' => 'UTF-8', 'UID' => "$USER", 'PWD' => "$pass", ];
        //Se prepara la conexi�n
        $con = sqlsrv_connect($ServerName, $connectionInfo);

        return $con;
    }

    public function CerrarConexion($con)
    {
        sqlsrv_close($con);
    }
}
