<?php
require_once 'vw_getuser.php';

$not_error = true; // Establecer como verdadero por defecto

$add_response = array(); // Crear un array para la respuesta


function ValidarCorreo($email){
    $email_filtrado = $email;
    
        $vista5 = new UsuarioVista();
        $resultado5 = $vista5->consultarEmail($email_filtrado);
        $total_resultado = true;
    
        if (!empty($resultado5['mensaje'])) {
            $total_resultado = false;
        }
    
        return $total_resultado;
}

    //Validaciones en servidor en caso de deshabilitación de javascript
    //Verificar que son obligatorios
    if($_POST['addnombre']==''){
        $add_response = array('success' => false, 'message' => 'El campo nombre debe ser obligatorio.');
        $not_error = false; // Hay error        
    }

    if($_POST['addapellido']==''){
        $add_response = array('success' => false, 'message' => 'El campo apellido debe ser obligatorio.');
        $not_error = false; // Hay error 
    }

    if($_POST['addtelefono']==''){
        $add_response = array('success' => false, 'message' => 'El campo telefono debe ser obligatorio.');
        $not_error = false; // Hay error 
    }  
    
    if($_POST['addemail']==''){
        $add_response = array('success' => false, 'message' => 'El campo correo debe ser obligatorio.');
        $not_error = false; // Hay error 
    } 
    
    //Verificar correo
    // Validar el formato del correo electrónico
    if (!filter_var($_POST['addemail'], FILTER_VALIDATE_EMAIL)) {
        $add_response = array('success' => false, 'message' => 'Formato de correo electrónico no válido.');
        $not_error = false; // Hay error 
    } 
    //Validar disponibilidad del correo (Si lo encuentra no permite avanzar)
    $valer_correo=ValidarCorreo($_POST['addemail']);
    if($valer_correo){
        $add_response = array('success' => false, 'message' => 'El correo ya esta registrado del sistema.');
        $not_error = false; // Hay error 
    }
    
    $patron_numérico = "/^\d{3,20}$/";
    //Verificar numero
    if (!preg_match($patron_numérico, $_POST['addtelefono'])){
        $add_response = array('success' => false, 'message' => 'El campo telefono sólo debe ir números teléfonicos.');
        $not_error = false; // Hay error        
    }

if($not_error){
    $add_response = array('success' => true, 'message' => 'Todos los datos se han diligenciado correctamente.');
}

    echo json_encode($add_response);
?>