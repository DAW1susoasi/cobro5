<?php
class Recibos_mes_dinamico extends ControladorPrincipal{
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
        $num_filas = $this->modelo->recibos_mes($_SESSION["usuario"], $_SESSION["fecha"]);
        $pagina = $_POST["pagina"];
        require(RUTA_APP . "/vista/includes/paginacion.php");
        $total_introducido = $this->modelo->total_recibos_mes($_SESSION["usuario"], $_SESSION["fecha"]) ? $this->modelo->total_recibos_mes($_SESSION["usuario"], $_SESSION["fecha"]) : 0;
    ?>
<thead class="thead-dark">
    <tr>
        <th class="text-center">Página</th>
        <th class="text-center">Importe</th>
        <th class="text-center">Id</th>
        <th class="text-center">Fecha</th>
        <th class="text-center">Sem.Cob.</th>
        <th class="text-center">Sem.Desc</th>
        <th class="text-center">Observaciones</th>
     </tr> 
</thead>
         <tr>
            <td class="text-center text-nowrap">
    <?php
    require(RUTA_APP . "/vista/includes/botones_paginacion.php");
    ?>

            </td>
            <td><input class="text-center" id="importe" name='importe' type='number' style="width:100px" pattern="[0-9]{2,5}" min="10" required/></td>
            <td><input class="text-center" id="id" name="id" type="text" style="width:125px" pattern="[0-9]{1,10}" readonly required/></td>
            <td class="text-center" id="fecha"></td>
            <td><input class="text-center" id="cobrado" name="cobrado" type="text" style="width:50px" pattern="[0-5]" required/></td>
            <td><input class="text-center" id="descargado" name="descargado" type="text" style="width:50px" pattern="[0-5]" required/></td>
            <td><input class="text-center" id="observaciones" name='observaciones' type='text'/></td>
            <input class="d-none" type='submit' name='enviar' value='Actualizar'/>
        </tr> 
        <tr>
            <td></td>
            <td class="text-center"><?php echo number_format($total_introducido, 2) . " €"; ?></td>
            <td class="text-center"><?php echo $num_filas . " recibos"; ?></td> 
            <td></td>
            <td></td>
            <td></td>
            <td></td>		
        </tr>
    <?php
    foreach($this->modelo->recibos_mes_busqueda($_SESSION["usuario"], $empezar_desde, $tamao_pagina, $_SESSION["fecha"]) as $r):
    ?>
        <tr>
            <td class="text-center text-nowrap">
                <button type="button" class="eliminar btn-xs btn-danger">
                    <i class="far fa-trash-alt"></i>
                </button>
                <button type="button" class="editar btn-xs btn-info">
                    <i class="far fa-edit"></i>
                </button>
            </td>
            <td class="text-center"><?php echo $r->importe; ?></td>
            <td class="text-center"><?php echo $r->id_recibo; ?></td>
            <td class="text-center text-nowrap"><?php echo $r->fecha; ?></td>
            <td class="text-center"><?php echo $r->semana_cobro > 0 ? $r->semana_cobro : ''; ?></td>
            <td class="text-center"><?php echo $r->semana_descargo > 0 ? $r->semana_descargo : ''; ?></td>
            <td class="text-center text-nowrap"><?php echo $r->observaciones; ?></td>
        </tr>    
    <?php
    endforeach;
    }

    public function eliminarReciboo(){
        if($this->modelo->existeRecibo($_POST["id"])){
            $this->modelo->eliminarRecibo($_POST['id']);
        }
    }

    public function submit(){
        if(isset($_POST["importe"]) && isset($_POST["id"]) && isset($_POST["cobrado"]) && isset($_POST["descargado"])){
            $id = trim(htmlentities($_POST["id"]));
            $importe = trim(htmlentities($_POST["importe"]));
            $cobrado = trim(htmlentities($_POST["cobrado"]));
            $descargado = trim(htmlentities($_POST["descargado"]));
            $observaciones = isset($_POST["observaciones"]) ? trim(htmlentities($_POST["observaciones"])) : NULL;
            if(ctype_digit($importe) && ctype_digit($id) && ctype_digit($cobrado) && ctype_digit($descargado)){
                if($importe >= 10 && $importe <= 99999 && $id > 0 && $id <= 9999999999){
                    if(
                           ($id > 0 && $id <= 9999999999)
                        && ($importe > 0 && $importe <= 99999) 
                        && (!$cobrado || !$descargado) 
                        && ($cobrado >= 0 && $cobrado < 6)
                        && ($descargado >= 0 && $descargado < 6)){
                        if($this->modelo->existeRecibo($id)){
                          $this->modelo->actualizarTodo($importe, $id, $observaciones, $cobrado, $descargado);
                        }
                    }
                }
            }
        }
    }
}
?>