<?php
    session_start();
    if (!isset($_SESSION['usuario_login'])) {
        header("location: ../index.php");
    } else if ($_SESSION['usuario_login']['rol'] == '0'){
        include_once('./fragments/headers.php');

?>
    <main class="container">
        <h3 class="text-center pt-4">Zona de Administradores</h3>
        <nav>
            <div class="nav nav-tabs border-bottom border-primary" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-reservas-tab" data-bs-toggle="tab" data-bs-target="#tab-reservas" aria-controls="tab-reservas" aria-selected="true" type="button" role="tab" onclick="cargaHoy()">Reservas</button>
                <button class="nav-link" id="nav-db-tab" data-bs-toggle="tab" data-bs-target="#tab-db" aria-controls="tab-db" aria-selected="false" type="button" role="tab">BB.DD.</button>
                
            </div>
        </nav>

        <div class="tab-content">
            <!-- Gestión de reservas -->

            <?php include_once('./api/model/Reservas.php');
                    $reservasAPi = new Reservas();
            ?>
            <div class="tab-pane fade show active shadow active rounded-bottom border border-primary py-2 px-4" id="tab-reservas" role="tabpanel" aria-labelledby="nav-reservas-tab">
                <p class="text-center fw-bold">
                    <span class="fs-4">Gestión general de reservas</span><br>
                    <small>TOTAL RESERVAS: <?php echo $reservasAPi -> totalReservas(); ?></small>
                    
                </p>
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-4">
                        <div class="input-group my-2">
                            <span class="input-group-text">Filtrar por fecha</span>
                            <input id="filtroDate" class="form-control datepicker" readonly>
                            <button type="button" class="btn btn-primary" onclick="buscarFecha()">Cargar</button>
                        </div>
                    </div>
                </div>

                <table id="allReservas" class="table table-striped table-bordered w-100 nowrap">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Aula</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Inicio</th>
                            <th scope="col">Fin</th>
                            <th scope="col">Autor</th>
                            <th scope="col">Comentario</th>
                            <th scope="col" class="text-center">Acciones</th>
                        </tr> 
                    </thead>
                    <tbody>
                    </tbody>
                </table>

        <div class="container text-center">
                <a class="btn btn-outline-secondary" href="./reservar">Haz una reserva</a>            
        </div>
        
            </div>

            <!-- Gestión de la base de datos -->
            <div class="tab-pane fade shadow rounded-bottom border border-primary py-2 px-4" id="tab-db" role="tabpanel" aria-labelledby="nav-db-tab">
                <p class="text-center fw-bold fs-4">Funciones relacionadas con la base de datos</p>
                <div class="">
                    <button class="btn btn-warning" title="Crea un archivo de volcado de la tabla reservas" onclick="if(confirm('¿Seguro/a de realizar el volcado?')) reservasBackup()">Backup 'Reservas'</button>
                    <button class="btn btn-danger" title="Borra todos los registros de la tabla reservas" onclick="if(confirm('¿Estás seguro/a? Se creará un archivo de volcado y luego se vaciará la tabla por completo.')) clearReservas()">Borrar 'Reservas'</button>
                </div>
                <div class="col">
                    <div class="d-inline-flex mt-4">
                        <p class="fw-bold fs-5">Subir archivo XLS(X) (Horarios aulas libres)&nbsp;&nbsp;</p>
                    </div>
                    <div class="px-1">
                        <small>
                            El archivo debe contener los horarios con las aulas/espacios LIBRES por cada día de la semana y periodo. El formato requerido para la hoja de cálculo se puede encontrar en el manual de usuario o descargando este <a href="./static/Ejemplo_AulasLibres_ReservApp.xlsx" target="_blank" class="fw-bold">archivo de ejemplo.</a>
                            <br>Si la tabla reservas tiene algún registro se realizará un volcado y posterior borrado de la tabla.
                        </small>
                        </div>
                    <form id="sheetFileForm" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12 col-lg-10"><input type="file" name="file" id="file" class="form-control my-1" required></div>
                            <div class="col-12 col-lg-2"><button type="submit" name="fileUpload" id="fileUpload" class="btn btn-primary my-1 w-100">Subir</button></div>
                        </div>
                    </form>  
                </div>
            </div>
        </div>

        <div class="pt-4 right text-end">
            <a title="Ver toda la configuración de PHP" href="./debug"><small>Información de PHP</small></a>
        </div>
    </main>
    <!-- Modal confirmación -->
    <div class="modal fade" id="confModal" tabindex="-1" role="dialog" aria-labelledby="confModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar reinicialización</h5>
                </div>
                <div class="modal-body">
                    <p class="fw-bold text-justify">¿Confirmar subida de archivo inicial?</p>
                    <p>Esto reinicializará la tabla reservas por completo, cargando todas las reservas posibes, menos las de las aulas libres obtenidas del fichero subido.</p>
                    <p class="my-2">Como verificación, introduzca el siguiente texto:</p>
                    <em><p class="px-2 fw-bold" id="vText">TEXTO</p></em>
                    <input type="text" class="form-control" id="confText">
                    <p id="loadMsg" class="pt-2 text-center"><small>Este proceso suele tardar entre 8 y 20 segundos, no cierre la ventana.</small></p>
                    <div class="placeholder-wave px-3 pt-2">
                        <span class="placeholder col-12 bg-success rounded" id="loading"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cancelBtn" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" id="okBtn" class="btn btn-primary" onclick="sendFileForm()">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal confirmar admin -->
    <div class="modal fade" id="confModalAdmin" tabindex="-1" role="dialog" aria-labelledby="confModalAdmin" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar cambio de rol</h5>
                </div>
                <div class="modal-body">
                    <p class="fw-bold text-justify">¿Confirmar cambio de rol?</p>
                    <p>El rol de admin permite al usuario acceder a funciones que afectan directamente a la base de datos y control de usuarios. Revise que el usuario a modificar es el correcto.</p>
                    <p class="my-2">Como última verificación, introduzca el siguiente texto:</p>
                    <em><p class="px-2 fw-bold" id="vText"></p></em>
                    <input type="text" class="form-control" id="confText">
                </div>
                <div class="modal-footer">
                    <button type="button" id="cancelBtn" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" id="okBtn" class="btn btn-primary" onclick="">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        let allReservas = null;
        let toActivate = null;
        let usersTable = null;

        const dt_options = {
            responsive: true,
            language: { url: './static/dataTables.es-ES.json' }
        }

        document.addEventListener('DOMContentLoaded', function () {
            toActivate = new DataTable('#toactivateTable', dt_options);
            allReservas = new DataTable('#allReservas', dt_options);
            usersTable = new DataTable('#usersTable', dt_options);
            date = new Date();
        });

        function cargaHoy(){
            $('#filtroDate').val(`${date.getFullYear()}-${date.getMonth()}-${date.getDate()}`)
            buscarFecha(false)
        }

        // FUNCIONES PARA USUARIOS
        function activarUsuario(uid,row){
            if(confirm('¿Estás seguro/a de activar este usuario?'))
                $.ajax({
                    type: "POST",
                    data: { uid: uid },
                    url: "./api/users/verificarUser",
                    dataType: 'json',
                    success: function(r){
                        if(r.isok){
                            showToast(r.data,'success')
                            toActivate.row(row).remove().draw()
                        }
                        else {
                            console.log(r);
                            showError(r.error, 15000)
                        }
                    },
                    error: function(e){
                        console.log(e);
                        showError('ERROR EN LA PETICIÓN<br>Si persiste, contacte con jefatura')
                    }
                })
        }

        function eliminarUsuario(uid,row){
            if(confirm('¿Estás seguro/a de eliminar este usuario? Esto es irreversible'))
                $.ajax({
                    type: "POST",
                    data: { uid: uid },
                    url: "./api/users/borrarUser",
                    dataType: 'json',
                    success: function(r){
                        if(r.isok){
                            showToast(`Usuario eliminado correctamente`,'success')
                            toActivate.row(row).remove().draw()
                        }
                        else {
                            console.log(r);
                            showError(r.error, 15000)
                        }
                    },
                    error: function(e){
                        console.log(e);
                        showError('ERROR EN LA PETICIÓN<br>Si persiste, contacte con jefatura')
                    }
                })
        }

        function getUsuarios(toast = false){
            $.ajax({
                type: "POST",
                data: { },
                url: "./api/users/getAllUsers",
                dataType: 'json',
                success: function(r){
                    if(r.isok){
                        if(toast) showToast(`Encontradas ${r.data.length} reservas`,'success')
                        cargarDatosUsuarios(r.data)
                    }
                    else {
                        console.log(r);
                        showError(r.error, 15000)
                    }
                },
                error: function(e){
                    console.log(e);
                    showError('ERROR EN LA PETICIÓN<br>Si persiste, contacte con jefatura')
                }
            })
        }

        function modificarUsuario(uid, admin = false){
            pl = $('#confModalAdmin').find('#confText').attr('placeholder')
            txt = $('#confModalAdmin').find('#confText').val()
            $('#confModalAdmin').find('#confText').val('')
            if(pl === txt)
                $.ajax({
                    type: "POST",
                    data: {uid: uid, rol: admin ? 'Admin' : 'Profesor'},
                    url: "./api/users/modificarRol",
                    dataType: 'json',
                    success: function(r){
                        if(r.isok){
                            showToast(r.data,'success')
                            getUsuarios()
                            $('#confModalAdmin').modal('hide')
                        }
                        else {
                            console.log(r);
                            showError(r.error, 15000)
                        }
                    },
                    error: function(e){
                        console.log(e);
                        showError('ERROR EN LA PETICIÓN<br>Si persiste, contacte con jefatura')
                    }
                })
            else {
                showError('El valor de confirmación no coincide',5000)
            }
        }

        function cargarDatosUsuarios(data){
            usersTable.destroy()
            body = $('#usersTable').find('tbody');
            body.empty()
            for(row of data){
                if(row.id.toString() == '<?php echo $_SESSION['usuario_login']['cod_usuario']; ?>') continue;
                tr = document.createElement('tr');
                tr.classList.add('align-middle')
                inner = `<tr class="align-middle">
                    <td>${row.id}</td>
                    <td>${row.nombre} ${row.apellidos}</td>
                    <td>${row.email}</td>
                    <td>${row.rol}</td>
                    <td>
                        <div class="text-center">`
                inner += row.rol != '0' ?
                            `<button type="button" title="Cambiar rol a Admin" class="btn btn-primary rounded-3 py-2 px-3 mx-2" data-action="upgrade" id="${row.id}">
                                <svg xmlns="http://www.w3.org/2000/svg" style="height: 24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 11l7-7 7 7M5 19l7-7 7 7" />
                                </svg>
                            </button>` : 
                            `<button type="button" title="Cambiar rol a Profesor" class="btn btn-secondary rounded-3 py-2 px-3 mx-2" data-action="downgrade" id="${row.id}">
                                <svg xmlns="http://www.w3.org/2000/svg" style="height: 24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 13l-7 7-7-7m14-8l-7 7-7-7" />
                                </svg>
                            </button>`
                inner += `<button type="button" class="btn btn-danger rounded-3 py-2 px-3 mx-2" data-action="borrar" id="${row.id}">
                                <svg xmlns="http://www.w3.org/2000/svg" style="height: 24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>`
                tr.innerHTML = inner
                body.append(tr)
            }
            usersTable = new DataTable('#usersTable', dt_options)
        }

        $('#toactivateTable tbody').on( 'click', 'button.btn', function () {
            uid = parseInt($(this).attr('id'))
            action = $(this).data('action')
            row = $(this).parents('tr')
            if(action == 'activar') activarUsuario(uid,row)
            else if(action == 'borrar') eliminarUsuario(uid,row)
        })

        $('#usersTable tbody').on( 'click', 'button.btn', function () {
            uid = parseInt($(this).attr('id'))
            action = $(this).data('action')
            row = $(this).parents('tr')

            confModal = $('#confModalAdmin');

            if(action == 'borrar') eliminarUsuario(uid,row)
            else if(action == 'upgrade'){
                vText = 'Cambiar a Admin'
                confModal.find('#vText').text(vText)
                confModal.find('#confText').attr("placeholder", vText);
                confModal.find('#confText').val('')
                confModal.find('#okBtn').attr("onclick", `modificarUsuario('${uid}',true)`)
                confModal.modal('show')
            }
            else if(action == 'downgrade') {
                vText = 'Cambiar a Profesor'
                confModal.find('#vText').text(vText)
                confModal.find('#confText').attr("placeholder", vText);
                confModal.find('#confText').val('')
                confModal.find('#okBtn').attr("onclick", `modificarUsuario('${uid}')`)
                confModal.modal('show')
            }
        })

        // FUNCIONES PARA RESERVAS
        $('.datepicker').datepicker({
            autoclose: true,
            daysOfWeekHighlighted: "12345",
            daysOfWeekDisabled: "06",
            disableTouchKeyboard: true,
            language: 'es',
            format: 'yyyy-mm-dd',
        });

        function buscarFecha(toast = true){
            $.ajax({
                type: "POST",
                data: { fecha: $('#filtroDate').val() },
                url: "./api/reservas/obtenerReservas",
                dataType: 'json',
                success: function(r){
                    if(r.isok){
                        if(toast) showToast(`Encontradas ${r.data.length} reservas`,'success')
                        cargarDatosReservas(r.data)
                    }
                    else {
                        //console.log(r);
                        showError(r.error, 15000)
                    }
                },
                error: function(e){
                    //console.log(e);
                    showError(`ERROR EN LA PETICIÓN<br>Si persiste, contacte con jefatura ${JSON.stringify(e, null, 4)}`)
                }
            })
        }

        function cargarDatosReservas(data){
            allReservas.destroy()
            body = $('#allReservas').find('tbody');
            body.empty()
            for(row of data){
                tr = document.createElement('tr');
                tr.classList.add('align-middle')
                tr.innerHTML = `<tr class="align-middle">
                    <td>${row.id}</td>
                    <td>${row.aula}</td>
                    <td>${row.fecha}</td>
                    <td>${row.inicio.slice(0,-3)}</td>
                    <td>${row.fin.slice(0,-3)}</td>
                    <td>${row.autor}</td>
                    <td>${row.comentario ? row.comentario : ''}</td>
                    <td>
                        <div class="text-center">
                            <button class="btn btn-danger" id="${row.id}">Eliminar</button>
                        </div>
                    </td>
                `
                body.append(tr)
            }
            allReservas = new DataTable('#allReservas', dt_options)
        }

        function borrarReserva(rid, row){
            if(confirm(`¿Borrar de forma permanente la reserva con ID ${rid}? NO se podrá recuperar`))
                $.ajax({
                    type: "POST",
                    data: { rid: rid },
                    url: "./api/reservas/borrarReserva",
                    dataType: 'json',
                    success: function(r){
                        if(r.isok){
                            showToast(`Reserva eliminada correctamente (ID ${rid})`,'success')
                            allReservas.row(row).remove().draw()
                        }
                        else {
                            // console.log(r);
                            showError(r.error, 15000)
                        }
                    },
                    error: function(e){
                        // console.log(e);
                        showError('ERROR EN LA PETICIÓN<br>Si persiste, contacte con jefatura')
                    }
                })
        }


        // FUNCIONES BB.DD.
        $('#sheetFileForm').submit(function(ev){
            vText = 'Reinicializar reservas'
            ev.preventDefault();
            confModal = $('#confModal');
            confModal.find('#loading').hide()
            confModal.find('#loadMsg').hide()
            confModal.find('#vText').text(vText)
            confModal.find('#confText').attr("placeholder", vText);
            confModal.find('#confText').val('')
            
            confModal.modal('show')
        });

        function sendFileForm(){
            pl = $('#confModal').find('#confText').attr('placeholder')
            txt = $('#confModal').find('#confText').val()
            $('#confModal').find('#confText').val('')
            if(txt == pl){
                confModal.find('#loading').show()
                confModal.find('#loadMsg').show()
                formData = new FormData(document.querySelector('#sheetFileForm'))
                $.ajax({
                    url: "./api/uploadInitialFile.php",
                    type: "POST",
                    data: formData,
                    contentType : false,
                    processData: false,
                    dataType: 'json',
                    success: function(r){
                        if(r.isok){
                            showToast(r.data,'success')
                            $('#confModal').modal('hide')
                        }
                        else {
                            $('#confModal').find('#loading').hide()
                            $('#confModal').find('#loadMsg').hide()
                            console.log(r.error);
                            showError(r.error, 15000)
                        }
                    },
                    error: function(e){
                        console.log(e);
                        $('#confModal').find('#loading').hide()
                        $('#confModal').find('#loadMsg').hide()
                        showError('ERROR EN LA PETICIÓN<br>Si persiste, contacte con jefatura')
                    }
                });
            } else {
                showError('El valor de confirmación no coincide',5000)
            }

        }

        function clearReservas(){
            $.ajax({
                type: "POST",
                data: {},
                url: "./api/reservas/limpiarTabla",
                dataType: 'json',
                success: function(r){
                    if(r.isok){
                        showToast(`Tabla vaciada correctamente<br>Registros eliminados:  ${r.data}`,'success')
                    }
                    else {
                        // console.log(r);
                        showError(r.error, 15000)
                    }
                },
                error: function(e){
                    // console.log(e);
                    showError('ERROR EN LA PETICIÓN<br>Si persiste, contacte con jefatura')
                }
            })
        }

        function reservasBackup(){
            $.ajax({
                type: "POST",
                data: {},
                url: "./api/reservas/backupReservas",
                dataType: 'json',
                success: function(r){
                    if(r.isok){
                        showToast(`Volcado realizado correctamente`,'success')
                    }
                    else {
                        // console.log(r);
                        showError(r.error, 15000)
                    }
                },
                error: function(e){
                    // console.log(e);
                    showError('ERROR EN LA PETICIÓN<br>Si persiste, contacte con jefatura')
                }
            })
        }

        // GENERAL
        $('#allReservas tbody').on( 'click', 'button.btn-danger', function () {
            rid = parseInt($(this).attr('id'))
            row = $(this).parents('tr')
            borrarReserva(rid,row)
        })
    </script>
<?php
        include_once('./fragments/footer.php');
    } else {
        header('location: ./misreservas');
    }
?>