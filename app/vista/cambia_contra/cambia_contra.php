<?php
require_once(RUTA_APP . "/vista/includes/head.php");
?>
</head>
<body>
<?php
require_once(RUTA_APP . "/vista/includes/validacion.php");
if(isset($_POST["contrasena"]) && isset($_POST["repContra"])){
    if(trim(htmlentities($_POST["contrasena"])) === trim(htmlentities($_POST["repContra"]))){  
        $this->modelo->cambiaContra(password_hash(trim(htmlentities($_POST["contrasena"])), PASSWORD_DEFAULT), $_SESSION['usuario']);
        header("Location: " . RUTA_URL . "/usuarios_registrados");
    }
}
?>
    <div class="d-flex align-items-stretch">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <ul class="list-unstyled components">
                <li>
                    <a href="<?php echo RUTA_URL; ?>/usuarios_registrados/">Inicio</a>
                </li>
                <li>
                    <a href="<?php echo RUTA_URL; ?>/usuarios_registrados/cerrar_sesion/">Cerrar sesión</a>
                </li>
                <li class="active">
                    <a href="">Cambiar contraseña</a>
                </li>
                <li>
                    <a onclick="javascript:return confirm('Cerrar mes. ¿Continuar?');" href="<?php echo RUTA_URL; ?>/usuarios_registrados/cerrar_mes1">Cerrar mes</a>
                </li>
                <li>
                    <a href="<?php echo RUTA_URL; ?>/usuarios_registrados/crud">Insertar recibos</a>
                </li>
<?php
require(RUTA_APP . "/vista/includes/sidebarCobrar.php");
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
                                    <label for="contrasena" class="text-info">Nueva contaseña</label>
                                    <input type="text" name="contrasena" class="form-control text-center" autofocus required>
                                </div>
                                <div class="form-group">
                                    <label for="repContra" class="text-info">Repetir contraseña</label>
                                    <input type="text" name="repContra" class="form-control text-center" required>
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