<?php
class Cobdes_importe_dinamico extends ControladorPrincipal{
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
?>
<thead class="thead-dark">
    <tr>
        <td></td>
        <th class="text-center">Id</th>
        <th class="text-center">Importe</th>
        <th class="text-center">Fecha</th>
        <th class="text-center" width="180">Observaciones</th>
    </tr>
</thead>
<tr>
    <td></td>
    <td></td>
    <td><input class="text-center" id="importe" name="importe" type="number" pattern="[0-9]{2,5}" min="10" required></td>
    <td></td>
    <td></td>
</tr>     
<?php  
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

    public function submit(){
?>
<thead class="thead-dark">
    <tr>
        <td></td>
        <th class="text-center">Id</th>
        <th class="text-center">Importe</th>
        <th class="text-center">Fecha</th>
        <th class="text-center" width="180">Observaciones</th>
    </tr>
</thead>
<tr>
    <td></td>
    <td></td>
    <td><input class="text-center" id="importe" name="importe" type="number" pattern="[0-9]{2,5}" min="10" required></td>
    <td></td>
    <td></td>
</tr>
<?php
    if(isset($_POST["importe"]) && $r = $this->modelo->recibosPendientesImporte($_SESSION["usuario"], $_POST["importe"])){
        foreach($this->modelo->recibosPendientesImporte($_SESSION["usuario"], $_POST["importe"]) as $r):
    ?>
<tr>
    <td class="text-center">
        <input type='button' class="descargar" value='Descargar'/>
        <input type='button' class="cobrar" value='Cobrar'/>
    </td>
     <td class="text-center"><?php echo $r->id_recibo; ?></td>
     <td class="text-center"><?php echo $r->importe; ?></td>
     <td class="text-center"><?php echo $r->fecha_valor; ?></td>
     <td class="text-center"><?php echo $r->observaciones; ?></td>
</tr>
<?php 
        endforeach;
        }
    }
}