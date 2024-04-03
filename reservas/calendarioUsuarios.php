<?php
   
    session_start();
    include_once('./fragments/headers.php');
    if (!isset($_SESSION['usuario_login'])) {
        header("location: ../index.php");
    } else {

?>
    <main class="container my-3">
        <h4 class="text-center"> Vista de calendario </h4>
        <section class="container mx-auto my-4">
            <div class="row">
                <div class="input-group my-2 col-12 col-md">
                    <span class="input-group-text">Profesor</span>
                    <select class="form-control" id="evtUsuario">
                    <?php
                        include_once('./api/model/Usuarios.php');
                        include_once('./includes/functions.inc.php');
                        $usuarios = new Usuarios();
                        $todas = $usuarios -> getAllUsers();
                           foreach ($todas as $todas) {
                            echo '<option value="'.$todas['cod_usuario'].'">'.$todas['nombre']." ".$todas['apellidos'].'</option>';
                        }
                    ?>
                    </select>
                </div>
                <button class="btn btn-secondary col-12 my-2 col-md mx-1" onclick="refetchEvents()">Visualizar Reservas</button>
            </div>
            <div class="row align-middle my-3">
                <p>Leyenda de colores: 
                    <span title="Reserva creada durante la carga inicial a comienzo de curso" class="bg-gradient text-white px-2 py-1 rounded" style="background-color: #3788d8;">Reserva inicial</span> &nbsp;
                    <span title="Reserva creada por un usuario" class="bg-gradient bg-secondary text-white px-2 py-1 rounded">Reserva de usuario</span>
                </p>
            </div>
            <div id="calendar" class="h-100"></div>
        </section>
    </main>
    <!-- Toasts -->
    <div class="toast-container position-fixed top-0 end-0" style="z-index: 2000;">
        <div id="toast" class="toast align-items-center bg-secondary text-white border-0 w-100" style="z-index: 11" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <div id="e_toast" class="toast align-items-center bg-danger text-white border-0" style="z-index: 11" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    </section>
    <!-- Modal info evento -->
    <div class="modal fade" id="modalEvent" tabindex="-1" role="dialog" aria-labelledby="modalEvent" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Información de Reserva</h5>
                </div>
                <div class="modal-body">
                    <div class="rounded-3 border border-primary p-3">
                        <p>Aula: &nbsp; <span class="fw-bold" id="evAula"></span></p>
                        <p>Fecha: &nbsp; <span class="fw-bold" id="evFecha"></span></p>
                        <p>Hora inicio: &nbsp; <span class="fw-bold" id="evInicio"></span></p>
                        <p>Hora fin: &nbsp; <span class="fw-bold" id="evFin"></span></p>
                        <p>Autor: &nbsp; <span class="fw-bold" id="evAutor"></span></p>
                        <p>Comentario:</p>
                        <p class="px-2 text-justify" id="evComentario"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cancelBtn" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        let calendar = null;        
        document.addEventListener('DOMContentLoaded', cargarCalendario())

        function refetchEvents(){
            calendar.refetchEvents();
        }
        
        function cargarCalendario() {
            var calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'es',
                events: function(info, ok, fail){
                    usuario = encodeURI($('#evtUsuario').val());
                    start = encodeURI(info.startStr)
                    end = encodeURI(info.endStr)

                    if(usuario && usuario != ''){
                        $.ajax({
                            type: "POST",
                            data: {},
                            url: `./api/reservas/asCalendarEventsUsuarios.php?usuario=${usuario}&start=${start}&end=${end}`,
                            dataType: 'json',
                            success: function(r) {
                                ok(r)
                            },
                            error: function(e){

                                // console.log(e);
                                ok([])
                            }
                        })
                    }
                    else{
                        showError('Se debe seleccionar un profesor para mostrar sus reservas')
                        ok([])
                    }  
                },
                footerToolbar: {
                    center: 'timeGridDay,timeGridWeek,dayGridMonth' 
                },
                initialView: 'dayGridMonth',
                aspectRatio: 2,
                expandRows: 1,
                hiddenDays: [6,0],
                slotMinTime: '08:30',
                slotMaxTime: '15:00',
                slotLabelInterval: '00:30',
                slotLabelFormat: {hour: '2-digit', minute: '2-digit'},
                allDaySlot: false,
                navLinks: true,
                eventShortHeight: 45,
                eventClick: function(info){
                    $('#evAula').text(info.event.title)
                    $('#evFecha').text(new Date(info.event.start).toLocaleDateString("es-ES", {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'}))
                    $('#evInicio').text(new Date(info.event.start).toLocaleTimeString("es-ES", {hour: '2-digit', minute: '2-digit'}))
                    $('#evFin').text(new Date(info.event.end).toLocaleTimeString("es-ES", {hour: '2-digit', minute: '2-digit'}))
                    $('#evAutor').text(info.event.extendedProps.autor)
                    $('#evComentario').text(info.event.extendedProps.comentario)
                    $('#modalEvent').modal('show')
                },
            });
            calendar.render();
        }   
        
        function getEvents(usuario,start,end){
            $.ajax({
                type: "POST",
                data: {},
                url: `./api/reservas/asCalendarEventsUsuarios.php?usuario=${usuario}&start=${start}&end=${end}`,
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
    </script>
<?php } ?>

<?php include_once('./fragments/footer.php'); ?>