<?php
    // Redireccionar a un archivo HTML
    $archivo_html = "./views/vw_listaUsuarios.html";
    header("Location: $archivo_html");
    exit();
?>