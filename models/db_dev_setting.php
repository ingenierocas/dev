<?php
/*Archivo modelo*/

require_once '../includes/db_connection.php';

class UsuarioModelo {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Conexion())->getConexion();
    }

    public function obtenerUsuarios() {
        $query = "SELECT * FROM dev_usuario WHERE borrado ='v'";
        $resultado = $this->conexion->query($query);

        $usuarios = array();
        while ($fila = $resultado->fetch_assoc()) {
            $usuarios[] = $fila;
        }

        $totalRegistros = $resultado->num_rows;

        return array(
            'usuarios' => $usuarios,
            'totalRegistros' => $totalRegistros
        );
    }

    public function obtenerUnUsuario($getid) {
        $query1 = "SELECT * FROM dev_usuario WHERE id_dev = ".$getid;
        $resultado1 = $this->conexion->query($query1);

        $usuario1 = array();
        while ($fila1 = $resultado1->fetch_assoc()) {
            $usuario1[] = $fila1;
        }

        return array(
            'usuario' => $usuario1
        );
    }  
    
    public function buscarEmail($email) {
        $query2 = "SELECT email FROM dev_usuario WHERE email = '".$email."' LIMIT 1";
        $resultado2 = $this->conexion->query($query2);
        $mail_mensaje_error = '';

        $usuario2 = array();
        if ($resultado2 && $resultado2->num_rows > 0) {
            // Si se encontró un resultado, lo guardamos
            $usuario2 = $resultado2->fetch_assoc();
        } else {
            $mail_mensaje_error = 'Error en la búsqueda del e-mail';
        }

        return array(
            'mensaje'=> $mail_mensaje_error,
            'email' => $usuario2
        );
    }  
    
    public function buscarOtroEmail($id, $email) {
        $query3 = "SELECT email FROM dev_usuario WHERE id_dev<>{$id} AND email = '".$email."' LIMIT 1";
        $resultado3 = $this->conexion->query($query3);
        $mail_mensaje_error3 = '';

        $usuario3 = array();
        if ($resultado3 && $resultado3->num_rows > 0) {
            // Si se encontró un resultado, lo guardamos
            $usuario3 = $resultado3->fetch_assoc();
        } else {
            $mail_mensaje_error3 = 'Error en la búsqueda del e-mail';
        }

        return array(
            'mensaje'=> $mail_mensaje_error3,
            'email' => $usuario3
        );
    }      

    public function insertarUsuario($nombre, $apellido, $telefono, $email) {
        $nombre = $this->conexion->real_escape_string($nombre);
        $apellido = $this->conexion->real_escape_string($apellido);
        $email = $this->conexion->real_escape_string($email);
        $telefono = $this->conexion->real_escape_string($telefono);

        $query = "INSERT INTO dev_usuario (nombre, apellido, telefono, email, fecha_registro, fecha_modificacion, borrado, dev_admin_idev_admin) VALUES ('$nombre', '$apellido', '$telefono', '$email', NOW(), NOW(), 'v', 1)";
        $resultado = $this->conexion->query($query);

        return $resultado;
    }

    public function actualizarUsuario($uid, $unombre, $uapellido, $utelefono, $uemail) {
        $updnombre = $this->conexion->real_escape_string($unombre);
        $updapellido = $this->conexion->real_escape_string($uapellido);
        $updemail = $this->conexion->real_escape_string($uemail);
        $updtelefono = $this->conexion->real_escape_string($utelefono);

        $query = 'UPDATE dev_usuario SET nombre="'.$updnombre.'", apellido="'.$updapellido.'", telefono='.$updtelefono.', email="'.$updemail.'", fecha_modificacion=NOW() WHERE id_dev='.$uid;
        $uresultado = $this->conexion->query($query);

        return $uresultado;
    }

    public function borrarUsuario($did) {

        $query = 'UPDATE dev_usuario SET borrado="f", fecha_modificacion=NOW() WHERE id_dev='.$did;
        $dresultado = $this->conexion->query($query);

        return $dresultado;
    }    

}
?>