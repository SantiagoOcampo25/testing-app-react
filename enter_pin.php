<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
$conexion = mysqli_connect('localhost', 'root', '', 'arca');
$correoElectronico_U = mysqli_real_escape_string($conexion, $_GET['correoElectronico_U']);

$query = "SELECT pin FROM usuario WHERE correoElectronico_U = '$correoElectronico_U'";
$resultado = mysqli_query($conexion, $query);
if(mysqli_num_rows($resultado) == 1) {
    $fila = mysqli_fetch_assoc($resultado);
    $pin = $fila['pin'];

    if($pin && isset($_SESSION['date_create_pin'])) {
        $pin_caducidad = $_SESSION['date_create_pin'] + 120;
        if(time() < $pin_caducidad) {
            echo "<h2>Ingresar PIN</h2>
				<p>Se ha enviado un PIN de recuperación de contraseña a su correo electrónico:</p>
				<p>" . $_GET['correoElectronico_U'] . "</p>
					<form action='reset_password.php' method='POST'>
						<label>PIN:</label><br>
						<input type='text' name='pin'><br><label>Nueva contraseña:</label><br>
						<input type='password' name='claveU'><br>
						<label>Confirmar contraseña:</label><br>
						<input type='password' name='confirmar_contrasena'><br>
						<input type='hidden' name='correoElectronico_U' value='" . $_GET['correoElectronico_U'] . "'>
						<input type='submit' value='Restablecer contraseña'>
					</form>";

        } else {
            echo "El PIN ha expirado. Por favor, solicite otro PIN para recuperar su contraseña.";
			header("Location: recovery_password.php");
        }
	}
}
?>
</body>
</html>