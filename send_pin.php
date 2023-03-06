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

if(isset($_POST['correoElectronico_U'])) {

	$correoElectronico_U = mysqli_real_escape_string($conexion, $_POST['correoElectronico_U']);

	$query = "SELECT documento_U FROM usuario WHERE correoElectronico_U = '$correoElectronico_U'";
	$resultado = mysqli_query($conexion, $query);
	if(mysqli_num_rows($resultado) == 1) {

		$pin = rand(100000, 999999);

		//$pin_hash = password_hash($pin, PASSWORD_DEFAULT);

		$receptor = $correoElectronico_U;
		$titulo = "PIN de recuperación de contraseña";
		$mensaje = "Su PIN de recuperación de contraseña es: $pin";
		$cabeceras = "From: arcafundacion10@outlook.com";
		$cabeceras .= "\r\nContent-Type: text/html; charset=UTF-8\r\n";

		if(mail($receptor, $titulo, $mensaje, $cabeceras)) {

			$query = "UPDATE usuario SET pin = '$pin' WHERE correoElectronico_U = '$correoElectronico_U'";
			mysqli_query($conexion, $query);

			header("Location: enter_pin.php?correoElectronico_U=$correoElectronico_U");
			exit;

		} else {
			error_log("Error al enviar el correo electrónico a: $receptor", 0);
            echo "Hubo un error al enviar el correo electrónico.";
		}

	} else {
		echo "El correo ingresado no está registrado en nuestra base de datos.";
	}

} else {
	header("Location: recovery_password.php");
	exit;
}
?>

</body>
</html>
