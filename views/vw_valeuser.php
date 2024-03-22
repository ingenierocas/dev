<?php
require_once 'vw_getuser.php';

$not_error_upd = true; // Establecer como verdadero por defecto

$upd_response = array(); // Crear un array para la respuesta


function ValidarOtroCorreo($id, $email){
    $email_filtrado = $email;
    
        $vista6 = new UsuarioVista();
        $resultado6 = $vista6->consultarOtroEmail($id, $email_filtrado);
        $total_resultado = true;
    
        if (!empty($resultado6['mensaje'])) {
            $total_resultado = false;
        }
    
        return $total_resultado;
}

    //Validaciones en servidor en caso de deshabilitación de javascript
    //Verificar que son obligatorios
    if(($_POST['editnombre']=='') || empty($_POST['editnombre'])){
        $upd_response = array('success' => false, 'message' => 'El campo nombre debe ser obligatorio.');
        $not_error_upd = false; // Hay error        
    }


    if(($_POST['editapellido']=='') || empty($_POST['editapellido'])){
        $upd_response = array('success' => false, 'message' => 'El campo apellido debe ser obligatorio.');
        $not_error_upd = false; // Hay error 
    }

    if(($_POST['edittelefono']=='') || empty($_POST['edittelefono'])){
        $upd_response = array('success' => false, 'message' => 'El campo telefono debe ser obligatorio.');
        $not_error_upd = false; // Hay error 
    }  

    //Validar campo correo
    if(($_POST['editemail']=='') || empty($_POST['editemail'])){
        $upd_response = array('success' => false, 'message' => 'El campo correo debe ser obligatorio.');
        $not_error_upd = false; // Hay error 
    } else if (!filter_var($_POST['editemail'], FILTER_VALIDATE_EMAIL)) {
        $upd_response = array('success' => false, 'message' => 'Formato de correo electrónico no válido.');
        $not_error_upd = false; // Hay error 
    }
      
    //Validar disponibilidad del correo (Si lo encuentra no permite avanzar)
    $valer_correo=ValidarOtroCorreo($_POST['editid'], $_POST['editemail']);
    if($valer_correo){
        $upd_response = array('success' => false, 'message' => 'El correo ya esta registrado del sistema.');
        $not_error_upd = false; // Hay error 
    }
    
    $patron_numerico_upd = "/^\d{3,20}$/";
    //Verificar numero
    if (!preg_match($patron_numerico_upd, $_POST['edittelefono'])){
        $upd_response = array('success' => false, 'message' => 'El campo telefono sólo debe ir números teléfonicos.');
        $not_error_upd = false; // Hay error        
    }


if($not_error_upd){
    $upd_response = array('success' => true, 'message' => 'Todos los datos se han diligenciado correctamente.');
}

    echo json_encode($upd_response);
?>