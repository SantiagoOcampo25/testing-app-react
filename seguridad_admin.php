<?php
session_start();
if ($_SESSION["administrador"]!=1)
{
header("Location:salir.php");
}
include("./data_conexion.php");

$tdd = $_SESSION['tdd'];
$documento = $_SESSION['docu'];

$sql = "SELECT estado_U from usuario WHERE fk_pk_tipo_documentoU = '$tdd' AND documento_U = '$documento'";
$resultado = $db -> query($sql);

while($row = $resultado -> fetch_assoc()){
    $estado = $row['estado_U'];
    if($estado != 1){
        header("Location:salir.php");
    }
}
?>