<?php
// ruta de la aplicación
define("RUTA_APP", dirname(__FILE__));
// ruta url
define("RUTA_URL", "http://localhost/cobro5");
//define("RUTA_URL", "https://cobro.herokuapp.com");

// conexion bbdd

define("CONEXION", array(
    "host" => "mysql:host=localhost;dbname=cobro",
    "user" => "root",
    "password" => ""
));

/*
define("CONEXION", array(
    "host" => "mysql:host=remotemysql.com;dbname=bbdd",
    "user" => "usuario",
    "password" => "contraseña"
));
*/
// autocarga de archivos
spl_autoload_register(function($nombreClase){
    require_once("librerias/" . $nombreClase . ".php");
});
/*
require_once("librerias/ControladorPrincipal.php");
require_once("librerias/Core.php");
*/
?>