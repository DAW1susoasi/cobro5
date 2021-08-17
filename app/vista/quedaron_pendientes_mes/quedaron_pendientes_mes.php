<?php
require_once(RUTA_APP . "/vista/includes/head.php");
?>
<script src="<?php echo RUTA_URL; ?>/scripts/quedaron_pendientes_mes.js"></script>
</head>
<body>
<?php
require_once(RUTA_APP . "/vista/includes/validacion.php");    
if(!isset($_SESSION["fecha"])){
    header("Location: " . RUTA_URL . "/usuarios_registrados/formulario_mes/quedaron_pendientes_mes");
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
                <li>
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
                        <li class="active">
                            <a href="<?php echo RUTA_URL; ?>/usuarios_registrados/formulario_mes/quedaron_pendientes_mes">Recibos pendientes en mes</a>
                        </li>
                        <li>
                            <a href="<?php echo RUTA_URL; ?>/usuarios_registrados/formulario_mes/recibos_mes">Recibos cargados en mes</a>
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
            <div class="table-responsive">
                <table id="dinamico" class="table table-bordered table-hover mx-auto w-auto"></table>
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