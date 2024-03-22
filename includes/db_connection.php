<?php
/*Archivo de conexión a la base de datos*/
class Conexion {
    private $host = 'localhost';
    private $usuario = 'root';
    private $contrasena = '';
    private $base_datos = 'dev_db';
    private $conexion;

    /*Conexión directa a la base de datos */
    public function __construct() {
        $this->conexion = new mysqli($this->host, $this->usuario, $this->contrasena, $this->base_datos);

        if ($this->conexion->connect_error) {
            die('Error de conexión: ' . $this->conexion->connect_error);
        }
    }

    public function getConexion() {
        return $this->conexion;
    }
}
?>
