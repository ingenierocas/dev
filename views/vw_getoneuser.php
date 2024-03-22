<?php
require_once 'vw_getuser.php';

$idusuarioespecifico = $_GET['id'];

$vista4 = new UsuarioVista();
$resultado4 = $vista4->obtenerUnUsuario($idusuarioespecifico);
echo $resultado4;
?>