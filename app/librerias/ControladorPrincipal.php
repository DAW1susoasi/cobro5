<?php
class ControladorPrincipal{
    public $modelo;
    public function setModelo(){
        require_once(RUTA_APP . "/modelo/Modelo.php");
        return new Modelo;
    }
    public function setVista($vista){
        require_once(RUTA_APP . "/vista/" . $vista . ".php");
    }
}
?>