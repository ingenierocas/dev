<?php
    require_once 'vw_getuser.php';

    $vista1 = new UsuarioVista();
    $resultado1 = $vista1->mostrarUsuarios();
    echo $resultado1;
?>