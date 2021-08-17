<?php
class Usuarios_registrados extends ControladorPrincipal{
    public function __construct(){
        $this->modelo = $this->setModelo();
    }
    
    public function index(){
        define("NOMBRE_SITIO", "Usuarios registrados");
        $this->setVista("inicio/inicio");
    }
    
    public function cerrar_sesion(){
        require_once(RUTA_APP . "/vista/includes/validacion.php");
        $_SESSION = array(); // elimino todas las variables de sesión
        if (ini_get("session.use_cookies")) { // elimino la cookie de sesión
          $params = session_get_cookie_params();
          setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        session_destroy(); // destruyo la sesión
        header("location: " . RUTA_URL);
    }
    
    public function cambia_contra(){
        define("NOMBRE_SITIO", "Cambiar contraseña");
        $this->setVista("cambia_contra/cambia_contra");
    }
    
    public function crud(){
        define("NOMBRE_SITIO", "Crud");
        $this->setVista("crud/crud");
    }
    
    public function formulario_semana($despues = null){
        define("NOMBRE_SITIO", "Formulario semana");

require_once(RUTA_APP . "/vista/includes/head.php");
?>
</head>
<body>
<?php
require_once(RUTA_APP . "/vista/includes/validacion.php");
if(isset($_POST["semana"]) && ctype_digit($_POST["semana"])){
    if($_POST["semana"] > 0 && $_POST["semana"] < 6){
        $_SESSION["semana"] = $_POST["semana"];
        header("Location: " . RUTA_URL . "/usuarios_registrados/" . $despues[0]);
    }
}
?>
    <div class="d-flex align-items-stretch">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <ul class="list-unstyled components">
<?php
require(RUTA_APP . "/vista/includes/sidebarSueltos.php");
?>
                <li class="active">
                    <a href="#cobrardescargar" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">Cobrar/Descargar</a>
                    <ul class="collapse show list-unstyled" id="cobrardescargar">
                        <li>
                            <a href="<?php echo RUTA_URL; ?>/usuarios_registrados/formulario_semana/cobdes/">General</a>
                        </li>
                        <li>
                            <a href="<?php echo RUTA_URL; ?>/usuarios_registrados/formulario_semana/cobdes_id/">Por id</a>
                        </li>
                        <li>
                            <a href="<?php echo RUTA_URL; ?>/usuarios_registrados/formulario_semana/cobdes_importe/">Por importe</a>
                        </li>
                    </ul>
                </li>
<?php
require(RUTA_APP . "/vista/includes/sidebarInformes.php");
?>
            </ul>
<?php
require_once(RUTA_APP . "/vista/includes/footer.php");
?>
        </nav>
        <!-- Page Content  -->
        <div id="content">
            <button type="button" id="sidebarCollapse" class="btn btn-dark">
                <i class="fa fa-bars"></i>
            </button>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-6">
                        <div class="p-3 login-box">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="semana" class="text-info">Semana número</label>
                                    <input type="text" name="semana" class="form-control text-center" pattern="[1-5]" placeholder="1-5" autofocus required>
                                </div>
                                <div class="text-center">
                                    <input type="submit" name="enviar" class="btn btn-info btn-md" value="Enviar">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    document.getElementById('sidebarCollapse').addEventListener("click", function() {
      document.getElementById('sidebar').classList.toggle('contraer');
    });
</script>
</body>
</html>
<?php
    }
    
    public function cobdes(){
        define("NOMBRE_SITIO", "Cobrar/Descargar");
        $this->setVista("cobdes/cobdes");
    }
    
    public function cobdes_id(){
        define("NOMBRE_SITIO", "Cobrar/Descargar por id");
        $this->setVista("cobdes_id/cobdes_id");
    }
    
    public function cobdes_importe(){
        define("NOMBRE_SITIO", "Cobrar/Descargar por importe");
        $this->setVista("cobdes_importe/cobdes_importe");
    }
    
    public function cobrado_meses(){
        define("NOMBRE_SITIO", "Cobrado por meses/semanas");
        $this->setVista("cobrado_meses/cobrado_meses");
    }
    
    public function descargado_meses(){
        define("NOMBRE_SITIO", "Descargado por meses/semanas");
        $this->setVista("descargado_meses/descargado_meses");
    }
    
    public function cargado_meses(){
        define("NOMBRE_SITIO", "Cargado por meses");
        $this->setVista("cargado_meses/cargado_meses");
    }
    
    public function pendiente_meses(){
        define("NOMBRE_SITIO", "Pendiente por meses");
        $this->setVista("pendiente_meses/pendiente_meses");
    }
    
    public function formulario_mes($despues = null){
        define("NOMBRE_SITIO", "Formulario mes");

require_once(RUTA_APP . "/vista/includes/head.php");
?>
</head>
<body>
<?php
require_once(RUTA_APP . "/vista/includes/validacion.php");
if(isset($_POST["fecha"])){
   $valores = explode('-', $_POST["fecha"]);
   if(count($valores) == 2 && checkdate($valores[1], 01, $valores[0])){ // si es una fecha correcta
       $_SESSION["fecha"] = $_POST["fecha"];
       header("Location: " . RUTA_URL . "/usuarios_registrados/" . $despues[0]);
    }
}
?>
    <div class="d-flex align-items-stretch">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <ul class="list-unstyled components">
<?php
require(RUTA_APP . "/vista/includes/sidebarSueltos.php");
require(RUTA_APP . "/vista/includes/sidebarCobrar.php");
?>
                <li class="active">
                    <a href="#informes" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">Informes</a>
                    <ul class="collapse show list-unstyled" id="informes">
                        <li>
                            <a href="<?php echo RUTA_URL; ?>/usuarios_registrados/cobrado_meses">Cobrado por meses/semanas</a>
                        </li>
                        <li>
                            <a href="<?php echo RUTA_URL; ?>/usuarios_registrados/descargado_meses">Descargado por meses/semanas</a>
                        </li>
                        <li>
                            <a href="<?php echo RUTA_URL; ?>/usuarios_registrados/cargado_meses">Cargado por meses</a>
                        </li>
                        <li>
                            <a href="<?php echo RUTA_URL; ?>/usuarios_registrados/pendiente_meses">Pendiente por meses</a>
                        </li>
                        <li>
                            <a href="<?php echo RUTA_URL; ?>/usuarios_registrados/formulario_mes/quedaron_pendientes_mes">Recibos pendientes en mes</a>
                        </li>
                        <li>
                            <a href="<?php echo RUTA_URL; ?>/usuarios_registrados/formulario_mes/recibos_mes">Recibos en mes</a>
                        </li>
                    </ul>
                </li>
            </ul>
<?php
require_once(RUTA_APP . "/vista/includes/footer.php");
?>
        </nav>
        <!-- Page Content  -->
        <div id="content">
            <button type="button" id="sidebarCollapse" class="btn btn-dark">
                <i class="fa fa-bars"></i>
            </button>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-6">
                        <div class="p-3 login-box">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="fecha" class="text-info">Fecha</label>
                                    <input type="month" name="fecha" class="form-control text-center" max="<?php echo date("Y-m") ?>" step="1" pattern="[0-9]{4}-[0-9]{2}" placeholder="año-mes" autofocus required>
                                </div>
                                <div class="text-center">
                                    <input type="submit" name="enviar" class="btn btn-info btn-md" value="Enviar">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    document.getElementById('sidebarCollapse').addEventListener("click", function() {
      document.getElementById('sidebar').classList.toggle('contraer');
    });
</script>
</body>
</html>
<?php
    }    
    
    public function quedaron_pendientes_mes(){
        define("NOMBRE_SITIO", "Recibos pendientes en mes");
        $this->setVista("quedaron_pendientes_mes/quedaron_pendientes_mes");
    }
    
    public function recibos_mes(){
        define("NOMBRE_SITIO", "Recibos mes");
        $this->setVista("recibos_mes/recibos_mes");
    }
    
    public function cerrar_mes1(){
        require_once(RUTA_APP . "/vista/includes/validacion.php");
        $this->modelo->cerrarMes($_SESSION["usuario"], date("Y-m", strtotime($this->modelo->fechaUsuario($_SESSION["usuario"])."next month")));
        header("Location: " . RUTA_URL . "/usuarios_registrados/cerrar_mes");
    }
    
    public function cerrar_mes(){
        define("NOMBRE_SITIO", "Cerrar mes");
        $this->setVista("cerrar_mes/cerrar_mes");      
    }
}
?>