<?php
class Crud_dinamico extends ControladorPrincipal{
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
        $num_filas = $this->modelo->listar($_SESSION["usuario"]);
        $pagina = $_POST["pagina"];
        require(RUTA_APP . "/vista/includes/paginacion.php");
        $total_introducido = $this->modelo->totalIntroducido($_SESSION["usuario"]) ? $this->modelo->totalIntroducido($_SESSION["usuario"]) : 0;
    ?>
    <thead class="thead-dark">
        <tr>
            <th class="text-center">Página</th>
            <th class="text-center">Id</th>
            <th class="text-center">Importe</th>       
         </tr>
    </thead>
         <tr>
            <td class="text-center">

    <?php
    require(RUTA_APP . "/vista/includes/botones_paginacion.php");
    ?>

            </td>
            <td><input class="text-center" id="id" name='id' type='text' style="width:125px" pattern="[0-9]{1,10}" required
                    <?php
                        $encontrado = FALSE;
                        while(!$encontrado){ 
                          $id = rand(1, 9999999999);
                          $encontrado = !$this->modelo->existeRecibo($id) ? TRUE : FALSE;
                        }
                        echo "value='$id'";
                    ?>/>
            </td>
            <td><input class="text-center" id="importe" name='importe' type='number' style="width:100px" pattern="[0-9]{2,5}" min="10" required	value="<?php echo rand(10, 99999); ?>" /></td>
            <input class="d-none" type='submit' name='enviar' value='Insertar/Actualizar'/>
          </tr> 
          <tr>
              <td class="text-center"><input type='button' id="eliminar_todos" value='Eliminar todos'/></td>
              <td class="text-center"><?php echo $num_filas . " recibos"; ?></td>
              <td class="text-center"><?php echo number_format($total_introducido, 2) . " €"; ?></td>
          </tr>
    <?php
      foreach($this->modelo->busqueda($_SESSION["usuario"], $empezar_desde, $tamao_pagina) as $r):
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
              <td class="text-center"><?php echo $r->id_recibo; ?></td>
              <td class="text-center"><?php echo $r->importe; ?></td>
          </tr>       
    <?php  
      endforeach; 
    }

    public function eliminarReciboo(){
        if($this->modelo->existeRecibo($_POST["id"])){
            $this->modelo->eliminarRecibo($_POST['id']);
        }
    }

    public function eliminarRecibosTemp(){
        $this->modelo->eliminarTodos_recibos_temp($_SESSION["usuario"]);
    }

    public function submit(){
        if(isset($_POST["importe"]) && isset($_POST["id"])){
            $id = trim(htmlentities($_POST["id"]));
            $importe = trim(htmlentities($_POST["importe"]));
            if(ctype_digit($importe) && ctype_digit($id)){
                if($importe >= 10 && $importe <= 99999 && $id > 0 && $id <= 9999999999){
                    if($this->modelo->existeRecibo($id)){
                      $this->modelo->actualizarImporte($importe, $id);
                    }
                    else{
                      $this->modelo->insertar($_SESSION["usuario"], $this->modelo->fechaUsuario($_SESSION["usuario"]), $id, $importe);
                    }
                }
            }
        }
    }    
}
?>