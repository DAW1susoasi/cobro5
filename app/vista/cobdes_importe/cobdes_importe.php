<?php
require_once(RUTA_APP . "/vista/includes/head.php");
?>
<script src="<?php echo RUTA_URL; ?>/scripts/cobdes_recibos_importe.js"></script>
</head>
<body>
<?php
require_once(RUTA_APP . "/vista/includes/validacion.php");  
if(!isset($_SESSION["semana"])){
    header("Location: " . RUTA_URL . "/usuarios_registrados/formulario_semana/cobdes_importe/");
}
?>
    <div class="d-flex align-items-stretch">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <ul class="list-unstyled components">
<?php
require(RUTA_APP . "/vista/includes/sidebarSueltos.php");
?>
                <li>
                    <a href="#cobrardescargar" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">Cobrar/Descargar</a>
                    <ul class="collapse show list-unstyled" id="cobrardescargar">
                        <li>
                            <a href="<?php echo RUTA_URL; ?>/usuarios_registrados/formulario_semana/cobdes/">General</a>
                        </li>
                        <li>
                            <a href="<?php echo RUTA_URL; ?>/usuarios_registrados/formulario_semana/cobdes_id/">Por id</a>
                        </li>
                        <li class="active">
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
            <form method="POST" action="">
                <div class="table-responsive">
                    <table id="dinamico" class="table table-bordered table-hover mx-auto w-auto"></table>
                </div>
            </form>
        </div>
    </div>
<script>
    document.getElementById('sidebarCollapse').addEventListener("click", function() {
      document.getElementById('sidebar').classList.toggle('contraer');
    });
</script>
</body>
</html>