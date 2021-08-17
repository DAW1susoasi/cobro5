<?php
require_once(RUTA_APP . "/vista/includes/head.php");
?>
<script src="<?php echo RUTA_URL; ?>/scripts/crud.js"></script>
</head>
<body>
<?php
require_once(RUTA_APP . "/vista/includes/validacion.php");    
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
                <li>
                    <a href="<?php echo RUTA_URL; ?>/usuarios_registrados/cambia_contra/">Cambiar contraseña</a>
                </li>
                <li>
                    <a onclick="javascript:return confirm('Cerrar mes. ¿Continuar?');" href="<?php echo RUTA_URL; ?>/usuarios_registrados/cerrar_mes1">Cerrar mes</a>
                </li>
                <li class="active">
                    <a href="">Insertar recibos</a>
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