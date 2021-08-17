<?php
class Nuevo_cobrador extends ControladorPrincipal{
    public function __construct(){
        $this->modelo = $this->setModelo();
    }
    public function index(){
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Nuevo cobrador</title>
<link href="<?php echo RUTA_URL; ?>/estilos/bootstrap_min_4.5.2.css" rel="stylesheet">
<link href="<?php echo RUTA_URL; ?>/estilos/estilos.css" rel="stylesheet">
</head>
<body>
<?php
        if(isset($_POST["usuario"]) && isset($_POST["contrasena"])){
            $usuario = trim(htmlentities($_POST["usuario"], ENT_QUOTES, "UTF-8"));
            $contrasena = trim(htmlentities($_POST["contrasena"], ENT_QUOTES, "UTF-8"));
            $cifrado = password_hash($contrasena, PASSWORD_DEFAULT);
            $this->modelo->nuevoCobrador($usuario, $cifrado);
        }
?> 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="p-3 login-box">
                <form action="" method="post">
                    <h3 class="text-center text-info">NUEVO COBRADOR</h3>
                    <div class="form-group">
                        <label for="usuario" class="text-info">Usuario</label>
                        <input type="text" name="usuario" class="form-control text-center" autofocus required>
                    </div>
                    <div class="form-group">
                        <label for="contrasena" class="text-info">Contraseña</label>
                        <input type="text" name="contrasena" class="form-control text-center" required>
                    </div>
                    <div class="text-center">
                        <input type="submit" name="enviar" class="btn btn-info btn-md" value="Enviar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require_once(RUTA_APP . "/vista/includes/footer.php");
    }
}
?>
</body>
</html>