<?php 
    require_once 'vw_getuser.php';

    $upid=$_GET['editid'];
    $upnombre=$_GET['editnombre'];
    $upapellido=$_GET['editapellido'];
    $uptelefono=$_GET['edittelefono'];
    $upemail=$_GET['editemail'];

    $vista3 = new UsuarioVista();
    $carga3 = $vista3->modificarUsuario($upid, $upnombre, $upapellido, $uptelefono, $upemail);
?>