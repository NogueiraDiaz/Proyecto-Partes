<?php
session_start();
include_once('./fragments/headers.php');
if (isset($_SESSION['usuario_login'])) {
?>
    <main class="container my-3">
        <p class="display-6 text-center my-3">Nueva reserva</p>
        <nav>
            <div class="nav nav-tabs border-bottom border-primary" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-single-tab" data-bs-toggle="tab" data-bs-target="#tab-single" aria-controls="tab-single" aria-selected="true" type="button" role="tab">Reserva única</button>
                <button class="nav-link" id="nav-periodic-tab" data-bs-toggle="tab" data-bs-target="#tab-periodic" aria-controls="tab-periodic" aria-selected="false" type="button" role="tab">Reserva periódica</button>
                
            </div>
        </nav>
        <div class="tab-content">
            <div class="tab-pane fade show active shadow-sm rounded-bottom border border-primary" id="tab-single" role="tabpanel" aria-labelledby="nav-single-tab">
                <form id="formReserva" method="post" onsubmit="return getFormData()" class="p-4 mx-2 row">
                    <div class="form-group col-12 my-2">
                        <label for="room">Aula *</label>
                        <select name="room" id="room" class="form-control">
                            <?php
                            $data = file_get_contents('./static/aulas.json');
                            $rooms = json_decode($data);
                            foreach ($rooms as $rooms) {
                                $room = ($rooms->nombre);
                                echo '<option value="'.$room.'">'.$room.'</option>';
                            }
                            ?>
                        </select>
                        <p class="px-3"><small>Si estás perdido y no sabes qué aula está dónde, puedes revisar el <a class="fw-bold" href="./plano">plano del centro</a> :)</small></p> 
                    </div>
                    <div class="form-group col-12 my-2">
                        <div class="row">
                            <div class="col-12 col-md my-1">
                                <label for="date">Fecha (AAAA/MM/DD) *</label>
                                <input type="text" id="date" name="date" placeholder="Selecciona fecha" class="form-control datepicker" required readonly>
                            </div>
                            <div class="col-12 col-md my-1">
                                <label for="idate">Hora / Periodo *</label>
                                <select name="idate" id="idate" class="form-control">
                                <?php
                                    $data = file_get_contents('./static/periodos.json');
                                    $hours = json_decode($data);
                                    for($i = 0; $i < count($hours)-1; $i++) {
                                        $hour = $hours[$i];
										$hour2 = $hours[$i+1];
                                        echo '<option value="'.$hour->hora.'">'."$hour->nombre ($hour->hora - $hour2->hora)".'</option>';
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 my-2">
                        <label for="comment">Comentario (opcional)</label>
                        <textarea name="comment" id="comment" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group mt-4 text-center">
                        <button type="button" onclick="disponibilidad()" class="btn btn-secondary bg-gradient my-1">Comprobar disponibilidad</button>
						<button type="button" onclick="disponibilidadCompleta()" title="Comprobar disponibilidad para todas las aulas en la fecha y hora indicada" class="btn btn-info bg-gradient my-1">Comprobar disponibilidad Aulas</button>
                        <button type="button" onclick="reservaUnica()" class="btn btn-primary my-1">Reservar</button>
    
                    </div>
                    <small class="text-danger mt-3">* Campo obligatorio</small>
                </form>  
            </div>
            <!-- Reserva múltiple -->
            <div class="tab-pane fade shadow-sm rounded-bottom border border-primary" id="tab-periodic" role="tabpanel" aria-labelledby="nav-periodic-tab">
                <form id="formReserva" method="post" class="p-4 mx-2 row">
                    <p class="text-justify">Permite crear múltiples reservas rápidamente. Desde la fecha inicial, reservará el aula seleccionada todos los días de la semana marcados a la hora indicada hasta la fecha final. <strong>Ambas fechas incluidas.</strong></p>
                    <div class="form-group col-12 my-2">
                        <div class="row">
                            <div class="col-12 col-md my-1">
                                <label for="date_inicio">Fecha Inicio *</label>
                                <input type="text" id="date_inicio" name="date_inicio" placeholder="Selecciona fecha inicial" class="form-control datepicker" required readonly>
                            </div>
                            <div class="col-12 col-md my-1">
                                <label for="date_fin">Fecha Fin *</label>
                                <input type="text" id="date_fin" name="date_fin" placeholder="Selecciona fecha final" class="form-control datepicker" required readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 my-2">
                        <div class="row">
                            <div class="col-12 col-md-6 my-1">
                                <label for="periodo">Hora / Periodo *</label>
                                <select name="periodo" id="periodoMulti" class="form-control">
                                <?php
                                    $data = file_get_contents('./static/periodos.json');
                                    $hours = json_decode($data);
                                    for($i = 0; $i < count($hours)-1; $i++) {
                                        $hour = $hours[$i];
                                        $hour2 = $hours[$i+1];
                                        echo '<option value="'.$hour->hora.'">'."$hour->nombre ($hour->hora - $hour2->hora)".'</option>';
                                    }
                                ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 my-1">
                                <label class="mb">Días de la semana (mínimo 1) *</label><br>
                                <div class="d-flex flex-wrap gap-2 my-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="cb_lunes" value="monday">
                                        <label class="form-check-label" for="cb_lunes">Lunes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="cb_martes" value="tuesday">
                                        <label class="form-check-label" for="cb_martes">Martes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="cb_miercoles" value="wednesday">
                                        <label class="form-check-label" for="cb_miercoles">Miércoles</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="cb_jueves" value="thursday">
                                        <label class="form-check-label" for="cb_jueves">Jueves</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="cb_viernes" value="friday">
                                        <label class="form-check-label" for="cb_viernes">Viernes</label>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="form-group col-12 my-2">
                        <label for="room">Aula *</label>
                        <select name="room" id="roomMulti" class="form-control">
                            <?php
                            $data = file_get_contents('./static/aulas.json');
                            $rooms = json_decode($data);
                            foreach ($rooms as $rooms) {
                                $room = ($rooms->nombre);
                                echo '<option value="'.$room.'">'.$room.'</option>';
                            }
                            ?>
                        </select>
                        <p class="px-3"><small>Si estás perdido y no sábes qué aula está dónde, revisa el <a class="fw-bold" href="./plano">plano del centro</a> :)</small></p> 
                    </div>
                    <div class="form-group col-12 my-2">
                        <label for="commentMulti">Comentario (opcional)</label>
                        <textarea name="commentMulti" id="commentMulti" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group mt-4 text-center">
                        <!-- <input type="submit" value="Reservar" name="btn_reservar" class="btn btn-primary"> -->
                        <button type="button" onclick="reservaMulti()" class="btn btn-primary" id="btr">Reservar</button>
                    </div>
                    <small class="text-danger mt-3">* Campo obligatorio</small>
                </form>  
            </div>
            </div>

        </div>
        <!-- Modal disponibilidad -->
        <div class="modal fade" id="dispModal" tabindex="-1" role="dialog" aria-labelledby="dispModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Disponibilidad del aula <span id="dispAula">X</span></h5>
                    </div>
                    <div class="modal-body">
                        <p>Fecha: &nbsp; <strong id="dispFecha">X</strong></p>
                        <p>Hora: &nbsp; <strong id="dispHora">X</strong></p>
                        <table id="disponibilidad" class="table table-striped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>Periodos</th>
                                    <th>Disponibilidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center"> <td>08:30 - 09:25</td> <td id="08:30" class="bg-success bg-gradient p-2" style="--bs-bg-opacity: .25;">Libre</td> </tr>
                                <tr class="text-center"> <td>09:25 - 10:20</td> <td id="09:25" class="bg-success bg-gradient p-2" style="--bs-bg-opacity: .25;">Libre</td> </tr>
                                <tr class="text-center"> <td>10:20 - 11:15</td> <td id="10:20" class="bg-success bg-gradient p-2" style="--bs-bg-opacity: .25;">Libre</td> </tr>
                                <tr class="text-center"> <td>11:15 - 11:45</td> <td id="11:15" class="bg-success bg-gradient p-2" style="--bs-bg-opacity: .25;">Libre</td> </tr>
                                <tr class="text-center"> <td>11:45 - 12:40</td> <td id="11:45" class="bg-success bg-gradient p-2" style="--bs-bg-opacity: .25;">Libre</td> </tr>
                                <tr class="text-center"> <td>12:40 - 13:35</td> <td id="12:40" class="bg-success bg-gradient p-2" style="--bs-bg-opacity: .25;">Libre</td> </tr>
                                <tr class="text-center"> <td>13:35 - 14:30</td> <td id="13:35" class="bg-success bg-gradient p-2" style="--bs-bg-opacity: .25;">Libre</td> </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cancelBtn" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal disponibilidad completa -->
        <div class="modal fade" id="dispModalCompleta" tabindex="-1" role="dialog" aria-labelledby="dispModalCompleta" aria-hidden="true">
            <div class="modal-dialog" role="document" style="min-width: 50%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Disponibilidad de aulas</h5>
                    </div>
                    <div class="modal-body">
                        <p>Fecha: &nbsp; <strong id="dispFecha">X</strong></p>
                        <p>Hora: &nbsp; <strong id="dispHora">X</strong></p>
                        <table id="disponibilidad" class="table table-striped table-bordered" style="width: 100% !important">
                            <thead>
                                <tr>
                                    <th class="text-center">Aula</th>
                                    <th class="text-center">Disponibilidad</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cancelBtn" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
		
		const dt_options = {
            responsive: true,
            paging: true,
            language: { url: './static/dataTables.es-ES.json' }
        }

        let tabDispCompleta = null;
        document.addEventListener('DOMContentLoaded', function () {
            tabDispCompleta = new DataTable('#dispModalCompleta #disponibilidad', dt_options);
        });

        $('.datepicker').datepicker({
            autoclose: true,
            daysOfWeekHighlighted: "12345",
            daysOfWeekDisabled: "06",
            disableTouchKeyboard: true,
            language: 'es',
            format: 'yyyy-mm-dd',
            startDate: 'today',
            endDate: <?php if($_SESSION['usuario_login']['rol'] != '0') echo "'+15d'"; else echo "''"; ?>
        });

        function reservaUnica(){
            $.ajax({
                type: "POST",
                data: getFormSingle(),
                url: "./api/reservas/crearReserva",
                dataType: 'json',
                success: function(r){
                    if(r.isok){
                        if(parseInt(r.data) > 1) showToast(`Reservas creadas correctamente (${r.data})`,'success')
                        else showToast(`Reserva creada correctamente (${r.data})`,'success')
                    }
                    else {
                        // console.log('ERROR:',r);
                        showError(r.error, 15000)
                    }
                },
                error: function(e){
                    // console.log(e);
                    showToast(e.responseText,'danger', 25000)
                    showError('ERROR EN LA PETICIÓN<br>Si persiste, contacte con jefatura')
                }
            })
        }

        function reservaMulti(){
            $.ajax({
                type: "POST",
                data: getFormMulti(),
                url: "./api/reservas/crearReservaPeriodica",
                dataType: 'json',
                success: function(r){
                    if(r.isok){
                        if(r.data && r.fallos.length > 0){
                            // TODO: Abrir modal para mostrar las reservas fallidas
                            showToast(`Creadas ${r.data} reservas.<br><strong>Con fallos.</strong>`,'success')
                            showError(`Reservas fallidas: ${r.fallos.length}`, 15000)
                        } else {
                            showToast(`Creadas ${r.data} reservas.<br>Sin fallos.`,'success')
                        }
                    }
                    else if(r.error){
                        // console.log(r);
                        showError(r.error, 15000)
                    }
                },
                error: function(e){
                    // console.log(e);
                    showToast(e.responseText,'danger', 25000)
                    showError('ERROR EN LA PETICIÓN<br>Si persiste, contacte con jefatura')
                }
            })
        }

        function disponibilidad(){
            formData = getFormSingle()
            fecha = formData.date
            aula = formData.room
            $.ajax({
                type: "POST",
                data: {fecha: fecha, aula: aula},
                url: "./api/reservas/obtenerAulaFecha.php",
                dataType: 'json',
                success: function(r){
                    if(r.isok){
                        //showToast(`Obtenida disponibilidad del aula`,'success')
                        cargarDatos(r.data, fecha, aula, formData.hora)
                        $('#dispModal').modal('show')
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
		
		
        function cargarDatos(data, fecha, aula, hora){
            fecha = new Date(fecha);
            fecha = fecha.toLocaleDateString("es-ES", {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'})
            $('#dispAula').text(aula)
            $('#dispFecha').text(fecha)
            $('#dispHora').text(hora)
            body = $('#disponibilidad').find('tbody');
            body.empty()
            body.append(`
                <tr class="text-center"> <td>08:30 - 09:25</td> <td data-hora="08:30" class="bg-success bg-gradient p-2" style="--bs-bg-opacity: .25;">Libre</td> </tr>
                <tr class="text-center"> <td>09:25 - 10:20</td> <td data-hora="09:25" class="bg-success bg-gradient p-2" style="--bs-bg-opacity: .25;">Libre</td> </tr>
                <tr class="text-center"> <td>10:20 - 11:15</td> <td data-hora="10:20" class="bg-success bg-gradient p-2" style="--bs-bg-opacity: .25;">Libre</td> </tr>
                <tr class="text-center"> <td>11:15 - 11:45</td> <td data-hora="11:15" class="bg-success bg-gradient p-2" style="--bs-bg-opacity: .25;">Libre</td> </tr>
                <tr class="text-center"> <td>11:45 - 12:40</td> <td data-hora="11:45" class="bg-success bg-gradient p-2" style="--bs-bg-opacity: .25;">Libre</td> </tr>
                <tr class="text-center"> <td>12:40 - 13:35</td> <td data-hora="12:40" class="bg-success bg-gradient p-2" style="--bs-bg-opacity: .25;">Libre</td> </tr>
                <tr class="text-center"> <td>13:35 - 14:30</td> <td data-hora="13:35" class="bg-success bg-gradient p-2" style="--bs-bg-opacity: .25;">Libre</td> </tr>
            `)
            $(`[data-hora="${hora}"]`).parent().addClass('fw-bold border border-2 border-success')
            if(data.length > 0){
                for(row of data){
                    rowHora = row.inicio.slice(0,-3)
                    td = $(`[data-hora="${rowHora}"]`)
                    td.removeClass("bg-success").addClass("bg-danger")
                    if(rowHora === hora){
                        td.parent().removeClass("border-success").addClass("border-danger")
                    }
                    td.text('Ocupada')

                }  
            }  
        }
		
		function disponibilidadCompleta(){
            formData = getFormSingle()
            fecha = formData.date
            hora = formData.hora
            $.ajax({
                type: "POST",
                data: {fecha: fecha, hora: hora},
                url: "./api/reservas/obtenerAulaFecha.php",
                dataType: 'json',
                success: function(r){
                    if(r.isok){
                        //showToast(`Obtenida disponibilidad del aula`,'success')
                        cargarDatosCompleta(r.data, fecha, formData.hora)
                        //console.log(r.data);
                        $('#dispModalCompleta').modal('show')
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

        function cargarDatosCompleta(data, fecha, hora){
            fecha = new Date(fecha);
            fecha = fecha.toLocaleDateString("es-ES", {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'})
            let modal = $('#dispModalCompleta')
            modal.find('#dispFecha').text(fecha)
            modal.find('#dispHora').text(hora)

            let aulas = [
            <?php
                $data = file_get_contents('./static/aulas.json');
                $rooms = json_decode($data);
                for($i = 0; $i < count($rooms); $i++) {
                    $room = ($rooms[$i]->nombre);
                    echo "'".$room."'";
                    if($i+1 < count($rooms)){ echo ','; }
                }
                ?>
            ]
            tabDispCompleta.destroy();
            table = modal.find('table#disponibilidad')
            body = table.find('tbody');
            body.empty()
            for(aula of aulas){
                let disp = data.find(r => r.aula == aula) ? 'Ocupada' : 'Libre';
                if(disp === 'Libre')
                    body.append(`
                        <tr class="text-center">
                            <td>${aula}</td>
                            <td class="bg-${disp === 'Libre' ? 'success' : 'danger'} bg-gradient p-2" style="--bs-bg-opacity: .25;">${disp}</td>
                        </tr>`);
            }

            tabDispCompleta = new DataTable(table, dt_options);
        }

        function getFormSingle(){
            var formData = {
                autor: '<?php echo $_SESSION['usuario_login']['cod_usuario'] ?>',
                room: $('#room').val(),
                date: $('#date').val(),
                hora: $('#idate').val(),
                comment: $('#comment').val()
            }
            return formData
        }
        function getFormMulti(){
            dias = []
            for(let c of document.querySelectorAll('input[type=checkbox]')){
                if(c.checked) dias.push(c.value)
            }
            var formData = {
                autor: '<?php echo $_SESSION['usuario_login']['cod_usuario'] ?>',
                room: $('#roomMulti').val(),
                inicio: $('#date_inicio').val(),
                fin: $('#date_fin').val(),
                hora: $('#periodoMulti').val(),
                dias: dias.join(','),
                comment: $('#commentMulti').val()
            }
            return formData
        }
    </script>
<?php
} else {
    header("location: ../index.php");
}
include_once('./fragments/footer.php');
?>
