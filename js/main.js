        // Función para quitar el formulario de edición
        function QuitarFormularioEditar() {
            $('#un_usuario').empty();
        }

        function cargarFormulario(idUsuario) {
            $.ajax({
                url: 'vw_getoneuser.php',
                type: 'GET',
                data: { id: idUsuario },
                dataType: 'json',
                success: function(response) {
                    var html1 = '';
                    if (response.usuario) {
                        html1 += '<div id="editUserModal' + response.usuario[0].id + '" class="modal fade"><div class="modal-dialog"><div class="modal-content"><form id="editUserForm" autocomplete="off"><div class="modal-header"><h4 class="modal-title">Editar Usuario</h4><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></div><div class="modal-body"><div class="form-group"><label>Nombre</label>';
                        html1 += '<input type="text" id="editnombre" name="editnombre" class="form-control" value="' + response.usuario[0].nombre + '" required>';
                        html1 += '</div><div class="form-group"><label>Apellido</label><input type="text" id="editapellido" name="editapellido" class="form-control" value="' + response.usuario[0].apellido + '" required></div><div class="form-group"><label>Teléfono</label>';
                        html1 += '<input type="text" id="edittelefono" name="edittelefono" class="form-control" value="' + response.usuario[0].telefono + '" required>';    
                        html1 += '</div><div class="form-group"><label>Email</label>';
                        html1 += '<input type="email" id="editemail" name="editemail" class="form-control" value="' + response.usuario[0].email + '" required> <input type="hidden" id="editid" name="editid" readonly="readonly" value="' + response.usuario[0].id + '">';
                        html1 += '</div><div class="form-group" id="editmensaje"></div></div><div class="modal-footer"><input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar"  id="editEnvio"><input type="submit" class="btn btn-info" value="Guardar"></div></form></div></div></div>';                        
                    } else {
                        html1 = '<strong>No se encontró ningún usuario.</strong>';
                    }  
                    $('#un_usuario').html(html1).show(); // Mostrar el formulario de edición
                    $('#editUserModal' + response.usuario[0].id).modal('show');                  
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // Función para borrar un usuario
        function borrarUsuario(idUsuarioBor){
            var activa_borrar=false;
            var advertencia = '<div id="deleteUserModal'+idUsuarioBor+'" class="modal fade"><div class="modal-dialog"><div class="modal-content"><form><div class="modal-header"><h4 class="modal-title">Administrar Usuario</h4><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></div><div class="modal-body"><p>¿Estás seguro(a) de que quieres borrar este usuario?</p><p class="text-warning"><small>Si por alguna razon elimina por accidente contactese con el administrador.</small></p></div><div class="modal-footer"><input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar"><input type="submit" class="btn btn-danger" name="total_del'+idUsuarioBor+'" id="total_del'+idUsuarioBor+'" value="Eliminar"></div></form></div></div></div>'; 

            $('body').append(advertencia);

            $("#total_del"+idUsuarioBor).click(function(){
                activa_borrar = true;
                if (activa_borrar) { 
                                  
                        $.ajax({
                            url: 'vw_eliuser.php',
                            type: 'POST',
                            data: { id: idUsuarioBor },
                            success: function(response) {
                                cargarNuevaListaUsuarios();
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });                      
                }
            });  
            
        }

        function cargarNuevaListaUsuarios() {
            $.ajax({
                    url: 'vw_listuser.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var totalUsuarios = response.totalRegistros;
                        var html = '<div class="container"><div class="table-wrapper"><div class="table-title"><div class="row"><div class="col-sm-6"><h2>Administrar <b>Usuarios</b></h2></div><div class="col-sm-6"><a href="#addUserModal" class="btn btn-success" data-toggle="modal" id="agregarusuario"><i class="material-icons">&#xE147;</i> <span>Agregar Nuevo Usuario</span></a></div></div></div><table class="table table-striped table-hover"><thead><tr><th>Nombre y apellido</th><th>Correo</th><th>Fechas de registro</th><th>Teléfono</th><th>Acciones</th></tr></thead><tbody>';
                        if (totalUsuarios > 0) {
                            var usuarios = response.usuarios;
                                                          
                            for (var i = 0; i < usuarios.length; i++) {
                                html += '<tr>'; 
                                html += '<td>' + usuarios[i].nombre + ' ' + usuarios[i].apellido + '</td>';
                                html += '<td> ' + usuarios[i].email + '</td>';
                                html += '<td><strong>Fecha creación:</strong><br>' + usuarios[i].fecha_registro + '<br>';
                                html += '<strong>Fecha modificación:</strong><br>' + usuarios[i].fecha_modificacion + '</td>';                                 
                                html += '<td>' + usuarios[i].telefono + '</td>';
                                html += '<td><a class="ver_usuario" data-target="#editUserModal' + usuarios[i].id + '" data-toggle="modal" data-id="' + usuarios[i].id + '"><i class="edit material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a> ';
                                html += '<button class="delete_user" data-toggle="modal" data-target="#deleteUserModal' + usuarios[i].id + '" onclick="borrarUsuario(' + usuarios[i].id + ')"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></button></td>';
                                html += '</tr>';
                            }
                                                      
                            
                        } else {
                            html += '<tr><td colspan="5"><strong>' + response.mensaje + '</strong></td></tr>';
                        }
                        html += '</tbody></table><div class="clearfix"><div class="hint-text">Total de <b>' + totalUsuarios + '</b> Usuarios</div></div></div></div>';
                        $('#resultado_usuarios').html(html);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
        }        

        $(document).ready(function() {

            // Cargar lista de usuarios al cargar la página
            actualizarListaUsuarios();

            // Evento submit del formulario para agregar usuario
            $("#addUserForm").submit(function(e) {
                e.preventDefault();
                var addtelefono = $('#addtelefono').val();

                if (!/^\d{3,20}$/.test(addtelefono)) {
                    $('#addmensaje').removeClass().addClass('alert alert-warning').html('El campo telefono sólo debe ir números teléfonicos');
                    adderror = true;                    
                }    
                var adderror = false;

                $('#addmensaje').html('');
                var addnombre = $('#addnombre').val();
                var addapellido = $('#addapellido').val();

                var addemail = $('#addemail').val();
                var addregex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;                
                if(addnombre == '') {
                    $('#addmensaje').removeClass().addClass('alert alert-warning').html('El campo nombre debe ser obligatorio');
                    adderror = true;
                }
                if(addapellido == '') {
                    $('#addmensaje').removeClass().addClass('alert alert-warning').html('El campo apellido debe ser obligatorio');
                    adderror = true;
                }               
                if(addtelefono == '') {
                    $('#addmensaje').removeClass().addClass('alert alert-warning').html('El campo telefono debe ser obligatorio');
                    adderror = true;
                }
                if (!/^\d+$/.test(addtelefono)) {
                    $('#addmensaje').removeClass().addClass('alert alert-warning').html('Por favor, ingrese solo números en el campo telefono.');
                    adderror = true;                    
                } 
                if(addemail == '') {
                    $('#addmensaje').removeClass().addClass('alert alert-warning').html('El campo correo debe ser obligatorio');
                    adderror = true;
                }                                
                if (!addregex.test(addemail)) {
                    $('#addmensaje').removeClass().addClass('alert alert-warning').html('Por favor, ingrese su correo correctamente');
                    adderror = true;
                }
                
                var formData = $(this).serialize();
                var retornar_respuesta = false;

                if(!adderror){
                    $.ajax({
                        type: 'POST',
                        url: 'vw_valuser.php',
                        data: formData,
                        dataType: 'json',
                        success: function(response){
                            retornar_respuesta = response.success;
                            if(retornar_respuesta) {
                                $('#addmensaje').html('');
                                    $.ajax({
                                        type: "POST",
                                        url: "vw_adduser.php",
                                        data: formData,
                                        success: function(data) {
                                            actualizarListaUsuarios();
                                            //$("#formnuevousuario").hide(); // Ocultar el formulario después de agregar usuario 
                                            $('#addUserModal').modal('hide');
                                            $('#myConfModal').modal('show');                                                                  
                                        }
                                    });
                                $("#editUserForm input[type='text']").val('');
                                $("#editUserForm input[type='email']").val('');
                                $('#editmensaje').html('');
                            } else {
                                //Si hay error generado desde el servidor
                                $('#addmensaje').removeClass().addClass('alert alert-danger').html(response.message);
                            }
                        }
                    });
                }
                
            });

            // Evento submit del formulario para editar usuario
            $(document).on('submit', '#editUserForm', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var retornar_respuesta_upd = false;
                var upderror = false;
                var editid = $('#editid').val()
                var edittelefono = $('#edittelefono').val();

                if (!/^\d{3,20}$/.test(edittelefono)) {
                    $('#editmensaje').removeClass().addClass('alert alert-warning').html('El campo telefono sólo debe ir números teléfonicos');
                    upderror = true;                    
                }    
                var upderror = false;

                $('#editmensaje').html('');
                var editnombre = $('#editnombre').val();
                var editapellido = $('#editapellido').val();

                var editemail = $('#editemail').val();
                var editregex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;                
                if(editnombre == '') {
                    $('#editmensaje').removeClass().addClass('alert alert-warning').html('El campo nombre debe ser obligatorio');
                    upderror = true;
                }
                if(editapellido == '') {
                    $('#editmensaje').removeClass().addClass('alert alert-warning').html('El campo apellido debe ser obligatorio');
                    upderror = true;
                }               
                if(edittelefono == '') {
                    $('#editmensaje').removeClass().addClass('alert alert-warning').html('El campo telefono debe ser obligatorio');
                    upderror = true;
                }
                if (!/^\d+$/.test(edittelefono)) {
                    $('#editmensaje').removeClass().addClass('alert alert-warning').html('Por favor, ingrese solo números en el campo telefono.');
                    upderror = true;                    
                } 
                if(editemail == '') {
                    $('#editmensaje').removeClass().addClass('alert alert-warning').html('El campo correo debe ser obligatorio');
                    upderror = true;
                }                                
                if (!editregex.test(editemail)) {
                    $('#editmensaje').removeClass().addClass('alert alert-warning').html('Por favor, ingrese su correo correctamente');
                    upderror = true;
                }                

                if(!upderror)
                $.ajax({
                        type: 'POST',
                        url: 'vw_valeuser.php',
                        data: formData,
                        dataType: 'json',
                        success: function(response){
                            retornar_respuesta = response.success;
                            if(retornar_respuesta) {
                                $.ajax({
                                    type: "GET",
                                    url: "vw_moduser.php",
                                    data: formData,
                                    success: function(data) {
                                        actualizarListaUsuarios();
                                        $('#editUserModal'+editid).modal('hide');
                                        $('#myConfModal2').modal('show');                                         
                                    }
                                });
                                $("#formnuevousuario input[type='text']").val('');
                                $("#formnuevousuario input[type='email']").val('');
                                $('#addmensaje').html('');
                            }else{
                            $('#editmensaje').removeClass().addClass('alert alert-danger').html(response.message);
                            }
                        }
                    });

            });

            // Función para actualizar la lista de usuarios
            function actualizarListaUsuarios() {
                $.ajax({
                    url: 'vw_listuser.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var totalUsuarios = response.totalRegistros;
                        var html = '<div class="container"><div class="table-wrapper"><div class="table-title"><div class="row"><div class="col-sm-6"><h2>Administrar <b>Usuarios</b></h2></div><div class="col-sm-6"><a href="#addUserModal" class="btn btn-success" data-toggle="modal" id="agregarusuario"><i class="material-icons">&#xE147;</i> <span>Agregar Nuevo Usuario</span></a></div></div></div><table class="table table-striped table-hover"><thead><tr><th>Nombre y apellido</th><th>Correo</th><th>Fechas de registro</th><th>Teléfono</th><th>Acciones</th></tr></thead><tbody>';
                        if (totalUsuarios > 0) {
                            var usuarios = response.usuarios;
                                                           
                            for (var i = 0; i < usuarios.length; i++) {
                                html += '<tr>'; 
                                html += '<td>' + usuarios[i].nombre + ' ' + usuarios[i].apellido + '</td>';
                                html += '<td> ' + usuarios[i].email + '</td>';
                                html += '<td><strong>Fecha creación:</strong><br>' + usuarios[i].fecha_registro + '<br>';
                                html += '<strong>Fecha modificación:</strong><br>' + usuarios[i].fecha_modificacion + '</td>';                                 
                                html += '<td>' + usuarios[i].telefono + '</td>';
                                html += '<td><a class="ver_usuario" data-target="#editUserModal' + usuarios[i].id + '" data-toggle="modal" data-id="' + usuarios[i].id + '"><i class="edit material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a> ';
                                html += '<button class="delete_user" data-toggle="modal" data-target="#deleteUserModal' + usuarios[i].id + '" onclick="borrarUsuario(' + usuarios[i].id + ')"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></button>';
                                html += '</td>';
                                html += '</tr>';
                            }
                            
                        } else {
                            html += '<tr><td colspan="5"><strong>' + response.mensaje + '</strong></td></tr>';
                        }
                        html += '</tbody></table><div class="clearfix"><div class="hint-text">Total de <b>' + totalUsuarios + '</b> Usuarios</div></div></div></div>';
                        $('#resultado_usuarios').html(html);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            // Evento click para cargar el formulario de edición
            $(document).on("click", ".ver_usuario", function(event) {
                event.preventDefault();
                var idUsuario = $(this).data('id');
                cargarFormulario(idUsuario);
            });


          
        });