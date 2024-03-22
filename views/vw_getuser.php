<?php
require_once '../controllers/con_getuser.php';

class UsuarioVista {
    private $usuarioControlador;

    public function __construct() {
        $this->usuarioControlador = new UsuarioControlador();
    }

    public function mostrarUsuarios() {
        $usuarios = $this->usuarioControlador->listarUsuarios();
    
        // Crear un array para almacenar los usuarios
        $usuariosArray = array();
    
        if($usuarios["totalRegistros"] > 0) {
            // Iterar sobre cada usuario y agregarlo al array
            foreach ($usuarios['usuarios'] as $usuario) {
                $usuarioArray = array(
                    'id' => $usuario['id_dev'],
                    'nombre' => $usuario['nombre'],
                    'apellido' => $usuario['apellido'],
                    'telefono' => $usuario['telefono'],
                    'email' => $usuario['email'],
                    'fecha_registro' => $usuario['fecha_registro'],
                    'fecha_modificacion' => $usuario['fecha_modificacion']
                );
                array_push($usuariosArray, $usuarioArray);
            }
    
            // Devolver el array de usuarios como JSON
            return json_encode(array(
                'totalRegistros' => $usuarios["totalRegistros"],
                'usuarios' => $usuariosArray
            ), JSON_UNESCAPED_UNICODE);
        } else {
            // Si no hay usuarios, devolver un mensaje JSON
            return json_encode(array(
                'totalRegistros' => 0,
                'mensaje' => 'No hay usuarios registrados por el momento'
            ));
        }
    }

    public function obtenerUnUsuario($iduser) {
        $usuario = $this->usuarioControlador->listarUnUsuario($iduser);
    
        // Crear un array para almacenar los usuarios
        $usuarioArray = array();
    

            // Iterar sobre cada usuario y agregarlo al array
            foreach ($usuario['usuario'] as $get_usuario) {
                $ob_usuarioArray = array(
                    'id' => $get_usuario['id_dev'],
                    'nombre' => $get_usuario['nombre'],
                    'apellido' => $get_usuario['apellido'],
                    'telefono' => $get_usuario['telefono'],
                    'email' => $get_usuario['email']
                );
                array_push($usuarioArray, $ob_usuarioArray);
            }
    
            // Devolver el array de usuarios como JSON
            return json_encode(array(
                'usuario' => $usuarioArray
            ), JSON_UNESCAPED_UNICODE);
        }

        public function consultarEmail($file_mail) {
            $email = $this->usuarioControlador->filtrarEmail($file_mail);
        
                // Devolver el array de usuarios como JSON
                return array(
                    'mensaje' => $email['mensaje'],
                    'mail' => $email['email'] // Devuelve directamente el resultado
                );
            }    
            
            public function consultarOtroEmail($id, $file_mail) {
                $email = $this->usuarioControlador->filtrarOtroEmail($id, $file_mail);
            
                    // Devolver el array de usuarios como JSON
                    return array(
                        'mensaje' => $email['mensaje'],
                        'mail' => $email['email'] // Devuelve directamente el resultado
                    );
                }                


    public function agregarUsuario($nombre, $apellido, $telefono, $email) {
        $resultado = $this->usuarioControlador->insertarUsuario($nombre, $apellido, $telefono, $email); // Corregir el nombre del método
        if ($resultado) {
            echo "Usuario agregado correctamente.";
        } else {
            echo "Error al agregar usuario.";
        }
    } 
    
    public function modificarUsuario($id, $nombre, $apellido, $telefono, $email) {
        $updaresultado = $this->usuarioControlador->actualizarUsuario($id, $nombre, $apellido, $telefono, $email); // Corregir el nombre del método
        if ($updaresultado) {
            echo "Usuario modificado correctamente.";
        } else {
            echo "Error al modificar usuario.";
        }
    } 
    
    public function quitarUsuario($id) {
        $delresultado = $this->usuarioControlador->eliminarUsuario($id); // Corregir el nombre del método
        if ($delresultado) {
            echo "Usuario eliminado correctamente.";
        } else {
            echo "Error al eliminar usuario.";
        }
    }     
}


?>
