<?php
class Inicio extends ControladorPrincipal{
    private $usuario;
    private $password;
    private $recordar;
    public function __construct(){
        $this->modelo = $this->setModelo();
    }
    
    public function verCookie(){
        if(isset($_COOKIE["usuario"])){ // si existe cookie inicializo los campos del formulario con la cookie
            $recibido = json_decode($_COOKIE["usuario"]);
            $this->usuario = $recibido->usuario;
            $this->password = $recibido->password;
            $this->recordar = $recibido->recordar;
        }
        else{
            $this->usuario = NULL;
            $this->password = NULL;
            $this->recordar = NULL;
        }
    }
    
    public function index(){
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Login</title>
<link href="<?php echo RUTA_URL; ?>/estilos/bootstrap_min_4.5.2.css" rel="stylesheet">
<link href="<?php echo RUTA_URL; ?>/estilos/estilos.css" rel="stylesheet">
</head>
<body>
<?php
        session_start();
        if(isset($_POST["usuario"]) && isset($_POST["password"])){ // si he hecho POST correctamente
          $this->usuario = trim(htmlentities($_POST["usuario"], ENT_QUOTES, "UTF-8"));
          $this->password = trim(htmlentities($_POST["password"], ENT_QUOTES, "UTF-8"));
              if(!password_verify($this->password, $this->modelo->contrasenaUsuario($this->usuario))){ // si el usuario no existe o el usuario existe pero la contraseña no es la suya
                    $this->verCookie(); // inicializo los campos del formulario
              }
              else{ // usuario registrado
                $_SESSION["usuario"] = $this->usuario;
                if(!$tokenUsuario = $this->modelo->tokenUsuario($this->usuario)){ // si es la primera vez que inicia sesión
                  $_SESSION["token"] = bin2hex(openssl_random_pseudo_bytes (24)); // generamos un token y lo asisnamos al token se sesión
                  $this->modelo->updateFechaUsuario($this->usuario, date("Y-m")); // actualizamos el campo fecha del usuario al año/mes actual
                  $this->modelo->updateTokenUsuario($this->usuario, $_SESSION["token"]); // actualizamos el campo token del usuario con el token de sesión generado
                  if(isset($_POST["recordar"])){
                    setcookie("usuario", json_encode($_POST), time() + 31536000, "/"); // creo la cookie; durante 1 año podrá loguearse con la cookie
                  }
                }
                else{ // si no es la primera vez que inicia sesión
                  $_SESSION["token"] = $tokenUsuario; // el token de sesión es el campo token del usuario
                  if(isset($_POST["recordar"])){
                    setcookie("usuario", json_encode($_POST), time() + 31536000, "/"); // durante 1 año podrá loguearse con la cookie
                  }
                  else if(isset($_COOKIE["usuario"])){ // si la cookie existe (antes deseaba recordar) pero ya no deseo recordar
                    setcookie("usuario", "", time() - 3600, "/"); // elimino la cookie
                  }
                }
                header("Location: " . RUTA_URL . "/usuarios_registrados");
              }
        }
        else{ // si no he hecho POST o no he rellenado todos los campos
            $this->verCookie(); // inicializo los campos del formulario
        }
?>
<form class="formulario" method="POST" action="">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6">
                    <div class="p-3 login-box">
                        <form class="form" action="" method="post">
                            <div class="form-group">
                                <label for="usuario" class="text-info">Usuario</label>
                                <input type="text" name="usuario" class="form-control text-center" pattern="[a-zA-Z0-9]+" value="<?php echo $this->usuario; ?>" autofocus required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Contraseña</label>
                                <input type="password" name="password" class="form-control text-center" value="<?php echo $this->password; ?>" required>
                            </div>
                            <div>
                                <label for="recordar" class="text-info">
                                    Recordar  
                                    <input name="recordar" type="checkbox" <?php echo $this->recordar == "on" ? 'checked' : ''; ?>>
                                </label>
                            </div>
                            <div class="text-center">
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="Log In">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</form>
<?php
require_once(RUTA_APP . "/vista/includes/footer.php");
    }
}
?>
</body>
</html>