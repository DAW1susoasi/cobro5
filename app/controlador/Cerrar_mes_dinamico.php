<?php
class Cerrar_mes_dinamico extends ControladorPrincipal{
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
        <th class="text-center">Observaciones</th>
     </tr>
</thead>
 <tr>
   <td class="text-center text-nowrap">
    <?php
    require(RUTA_APP . "/vista/includes/botones_paginacion.php");
    ?>
   </td>
   <td><input class="text-center" type="number" id="importe" name="importe" min="10" style="width:100px" readonly/></td>
   <td><input class="text-center" type="text" id="id" name="id" pattern="[0-9]{1,10}" style="width:125px" readonly/></td>
   <td class="text-center" id="fecha"></td>
   <td><input class="text-center" id="observaciones" name='observaciones' type='text'/></td>
   <input class="d-none" type='submit' name='enviar' value='Actualizar'/>
 </tr> 
 <tr>
   <td></td>
   <td class="text-center text-nowrap"><?php echo number_format($total_introducido, 2) . " €"; ?></td>
   <td class="text-center"><?php echo $num_filas . " recibos"; ?></td>
   <td></td>
   <td></td>
 </tr>
<?php
    foreach($this->modelo->recibosPendientes($_SESSION["usuario"], $empezar_desde, $tamao_pagina) as $r):
?>
<tr>
    <td class="text-center">
        <button type="button" class="editar btn-xs btn-info"><i class="far fa-edit"></i></button>
    </td>
    <td class="text-center"><?php echo $r->importe; ?></td>
    <td class="text-center"><?php echo $r->id_recibo; ?></td>
    <td class="text-center text-nowrap"><?php echo $r->fecha_valor; ?></td>
    <td class="text-center text-nowrap"><?php echo $r->observaciones; ?></td>
</tr>    
<?php
    endforeach;
    }

    public function submit(){
        if(isset($_POST["importe"]) && isset($_POST["id"])){
            $id = trim(htmlentities($_POST["id"]));
            $importe = trim(htmlentities($_POST["importe"]));
            $observaciones = isset($_POST["observaciones"]) ? trim(htmlentities($_POST["observaciones"])) : NULL;
            if(ctype_digit($importe) && ctype_digit($id)){
                if($importe >= 10 && $importe <= 99999 && $id > 0 && $id <= 9999999999){
                    if(
                       ($id > 0 && $id <= 9999999999)
                        && ($importe > 0 && $importe <= 99999)){
                        if($this->modelo->existeRecibo($id)){
                          $this->modelo->actualizarTodo($importe, $id, $observaciones, 0, 0);
                        }
                    }
                }
            }
        }
    }
}