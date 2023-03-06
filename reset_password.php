<?php
$conexion = mysqli_connect('localhost', 'root', '', 'arca');

if(isset($_POST['pin'])) {

	$pin = mysqli_real_escape_string($conexion, $_POST['pin']);
	$claveU = mysqli_real_escape_string($conexion, $_POST['claveU']);
	$confirmar_contrasena = mysqli_real_escape_string($conexion, $_POST['confirmar_contrasena']);
	$correoElectronico_U = mysqli_real_escape_string($conexion, $_POST['correoElectronico_U']);

	$query = "SELECT documento_U FROM usuario WHERE correoElectronico_U = '$correoElectronico_U' AND pin = $pin";
	$resultado = mysqli_query($conexion, $query);
	if(mysqli_num_rows($resultado) == 1) {

        $hash = password_hash($confirmar_contrasena, PASSWORD_DEFAULT);
		$pin_expiration = time() + (2 * 60); // Tiempo de expiración de 2 minutos
		//$pin_hash = $pin_expiration.':'.password_hash($pin, PASSWORD_DEFAULT);

		if(password_verify($confirmar_contrasena, $hash)) {

			$query = "UPDATE usuario SET claveU = '$hash', pin = NULL WHERE correoElectronico_U = '$correoElectronico_U'";
			mysqli_query($conexion, $query);

			echo "Contraseña actualizada correctamente.";
            header("Location: pres_login.php");

		} else {
			echo "Las contraseñas no coinciden.";
		}

	} else {
		echo "El PIN ingresado no es válido.";
	}

} else {
	header("Location: recovery_password.php");
	exit;
}
?>
