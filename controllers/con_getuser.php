<?php
/*Archivo controlador*/
require_once '../models/db_dev_setting.php';

class UsuarioControlador {
    private $usuarioModelo;

    public function __construct() {
        $this->usuarioModelo = new UsuarioModelo();
    }

    public function listarUsuarios() {
        $usuarios = $this->usuarioModelo->obtenerUsuarios();
        // Aquí puedes aplicar cualquier lógica adicional si es necesario
        return $usuarios;
    }

    public function listarUnUsuario($id) {
        $usuarios1 = $this->usuarioModelo->obtenerUnUsuario($id);
        // Aquí puedes aplicar cualquier lógica adicional si es necesario
        return $usuarios1;
    }    

    public function insertarUsuario($nombre, $apellido, $telefono, $email) {
        return $this->usuarioModelo->insertarUsuario($nombre, $apellido, $telefono, $email);
    }
    public function actualizarUsuario($id, $nombre, $apellido, $telefono, $email) {
        return $this->usuarioModelo->actualizarUsuario($id, $nombre, $apellido, $telefono, $email);
    } 
    public function eliminarUsuario($id) {
        return $this->usuarioModelo->borrarUsuario($id);
    }    

    public function filtrarEmail($email) {
        return $this->usuarioModelo->buscarEmail($email);
    }   

    public function filtrarOtroEmail($id, $email) {
        return $this->usuarioModelo->buscarOtroEmail($id,$email);
    }       

}
?>