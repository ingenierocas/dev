<?php
require_once 'vw_getuser.php'; // Corregir el nombre del archivo

// Recibir datos del formulario
$addfirst_name = $_POST['addnombre'];
$addlast_name = $_POST['addapellido'];
$addphone = $_POST['addtelefono'];
$addemail = $_POST['addemail'];

$vista2 = new UsuarioVista();
$vista2->agregarUsuario($addfirst_name, $addlast_name, $addphone, $addemail); // Corregir el nombre del método

?>