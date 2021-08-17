<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
if(!isset($_SESSION["usuario"]) || !isset($_SESSION["token"]) || hash_equals($this->modelo->tokenUsuario($_SESSION["usuario"]), $_SESSION["token"]) === FALSE){ // si el usuario no ha iniciado sesion o el token de sesion no es igual al token del usuario en la base de datos
    header("Location: " . RUTA_URL);
}
?>