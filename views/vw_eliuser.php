<?php
    require_once 'vw_getuser.php';
 
    $deid=$_POST['id'];

    $vista4 = new UsuarioVista();
    $carga4 = $vista4->quitarUsuario($deid);   
?>