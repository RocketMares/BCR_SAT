<?php

class ConexionSQL
{
    public function ObtenerConexionBD()
    {
        $BD_NAME = 'ControlSAT';
        $USER = 'Analisis';
        $pass = 'Malitos20';
        $ServerName = 'DESKTOP-4Q2P8VT\SQLEXPRESS';
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
