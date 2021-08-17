<?php
class Quedaron_pendientes_mes_dinamico extends ControladorPrincipal{
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
        $pagina = $_POST["pagina"];
        $num_filas = $this->modelo->cuantosPendientes($_SESSION["usuario"], $_SESSION["fecha"]);
        require(RUTA_APP . "/vista/includes/paginacion.php");
        $total_introducido = $this->modelo->cuantoPendiente($_SESSION["usuario"], $_SESSION["fecha"]) ? $this->modelo->cuantoPendiente($_SESSION["usuario"], $_SESSION["fecha"]) : 0;
    ?>
<thead class="thead-dark">
    <tr>
      <th class="text-center">Página</th>
      <th class="text-center">Importe</th>
      <th class="text-center">Id</th>
      <th class="text-center">Fecha</th>
      <th class="text-center">Sem.Cob.</th>
      <th class="text-center">Sem.Desc</th>
      <th class="text-center" width="180">Observaciones</th>
    </tr>
</thead>
        <tr>
          <td class="text-center text-nowrap">

    <?php require(RUTA_APP . "/vista/includes/botones_paginacion.php"); ?>

          </td>
          <td class="text-center text-nowrap"><?php echo number_format($total_introducido, 2) . " €"; ?></td>
          <td class="text-center"><?php echo $num_filas . " recibos"; ?></td>
          <td></td>
          <td></td>
        </tr>

    <?php  
    foreach($this->modelo->cuantosPendientesBusqueda($_SESSION["usuario"], $empezar_desde, $tamao_pagina, $_SESSION["fecha"]) as $r): 
    ?>
        <tr>
          <td></td>
          <td class="text-center"><?php echo($r->importe); ?></td>
          <td class="text-center"><?php echo($r->id_recibo); ?></td>
          <td class="text-center text-nowrap"><?php echo($r->fecha); ?></td>
          <td class="text-center"><?php echo $r->semana_cobro > 0 ? $r->semana_cobro : ''; ?></td>
          <td class="text-center"><?php echo $r->semana_descargo > 0 ? $r->semana_descargo : ''; ?></td>
          <td class="text-center text-nowrap"><?php echo($r->observaciones); ?></td>
        </tr>
    <?php   
    endforeach;
    }
}
?>  