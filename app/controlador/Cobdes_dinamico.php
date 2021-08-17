<?php
class Cobdes_dinamico extends ControladorPrincipal{
    //private $modelo;
    public function __construct(){
        $this->modelo = $this->setModelo();
        session_start();
        if(isset($_POST["function"])){
            $function = $_POST["function"];
            $this->$function();
        }
    }

    public function index(){
    }
    
    public function getRecibos(){
        $num_filas = $this->modelo->listarPendiente($_SESSION["usuario"]);
        $pagina = $_POST["pagina"];
        require(RUTA_APP . "/vista/includes/paginacion.php");
        $total_introducido = $this->modelo->saldoPendiente($_SESSION["usuario"]) ? $this->modelo->saldoPendiente($_SESSION["usuario"]) : 0;
    ?>
<thead class="thead-dark">
  <tr>
    <th class="text-center">Página</th>
    <th class="text-center">Importe</th>
    <th class="text-center">Id</th>
    <th class="text-center">Fecha</th>
    <th class="text-center" width="180">Observaciones</th>
  </tr>
</thead>
      <tr>
        <td class="text-center text-nowrap">

    <?php
    require(RUTA_APP . "/vista/includes/botones_paginacion.php");
    ?>

        </td>
        <td class="text-center text-nowrap"><?php echo number_format($total_introducido, 2) . " €"; ?></td>
        <td class="text-center"><?php echo $num_filas . " recibos"; ?></td>
        <td></td>
        <td></td>
      </tr>
    <?php

    foreach($this->modelo->recibosPendientes($_SESSION["usuario"], $empezar_desde, $tamao_pagina) as $r):
    ?>
      <tr>
       <td class="text-center text-nowrap">
            <input type='button' class="descargar" value='Descargar'/>
            <input type='button' class="cobrar" value='Cobrar'/>
       </td>
       <td class="text-center"><?php echo $r->importe; ?></td>
       <td class="text-center"><?php echo $r->id_recibo; ?></td>
       <td class="text-center text-nowrap"><?php echo $r->fecha_valor; ?></td>
       <td class="text-center text-nowrap"><?php echo $r->observaciones; ?></td>
      </tr>  
    <?php
    endforeach;
    }

    public function cobrarReciboo(){
        if($this->modelo->existeRecibo($_POST['id'])){
            $this->modelo->cobrarRecibo($_POST["id"], $_SESSION["semana"]);
        }
    }

    public function descargarReciboo(){
        if($this->modelo->existeRecibo($_POST['id'])){
            $this->modelo->descargarRecibo($_POST["id"], $_SESSION["semana"]);
        }
    }
}