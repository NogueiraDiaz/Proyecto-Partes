<?php
    session_start();
    include_once('./fragments/headers.php');
    if (isset($_SESSION["usuario_login"])) {
        include_once('./api/model/Reservas.php');
        include_once('./includes/functions.inc.php');
        $reservas = new Reservas();
        $todas = $reservas -> getByAutor($_SESSION["usuario_login"]['cod_usuario']);
?>
        <main class="container my-3">
            <h3 class="text-center">MIS RESERVAS</h3>
            <div class="row">
<?php
        if(count($todas) > 0){
?>
        <table id="misreservas" class="table table-striped table-bordered w-100 nowrap">
            <thead>
                <tr>
                    <th scope="col">Aula</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Inicio</th>
                    <th scope="col">Fin</th>
                    <th scope="col">Comentario</th>
                    <th scope="col" class="text-center">Acciones</th>
                </tr> 
            </thead>
            <tbody>
<?php
                foreach($todas as $r){
                    echo '<tr class="align-middle">';
                    echo '<td>'.$r['aula'].'</td>';
                    echo '<td>'.formatDate($r['fecha']).'</td>';
                    echo '<td>'.formatTime($r['inicio']).'</td>';
                    echo '<td>'.formatTime($r['fin']).'</td>';
                    echo '<td>'.$r['comentario'].'</td>';
?>
                    <td>
                        <div class="d-flex flex-row justify-content-center align-items-center">
                            <button type="button" class="btn btn-primary rounded-3 py-2 px-3 mx-2" data-bs-toggle="modal" data-bs-target="#editModal" data-action="editar" data-rid='<?php echo json_encode($r) ?>'>
                                <span class="d-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="height: 24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </span>
                            </button>
                            <button type="button" class="btn btn-danger rounded-3 py-2 px-3 mx-2" data-action="borrar" id="<?php echo $r['id'] ?>">
                                <span class="d-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="height: 24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </td>
                    </tr>
<?php
                }
            echo '</tbody></table>';
    } else {
        echo '<p class="text-center">No tienes reservas...</p>';
?>
        <div class="container text-center">
                <a class="btn btn-outline-secondary" href="./reservar">Haz una reserva</a>            
        </div>
        
<?php } ?>
        </div>
        <!-- Edit modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar reserva</h5>
                    </div>
                    <div class="modal-body">
                        <form id="editReservaForm">
                            <div class="input-group my-2">
                                <span class="input-group-text">ID</span>
                                <input type="number" class="form-control" id="rid" disabled readonly>
                            </div>
                            <div class="input-group my-2">
                                <span class="input-group-text">Aula</span>
                                <select class="form-control" id="aula">
                                <?php
                                    $data = file_get_contents('./static/aulas.json');
                                    $rooms = json_decode($data);
                                    foreach ($rooms as $rooms) {
                                        $room = ($rooms->nombre);
                                        echo '<option value="'.$room.'">'.$room.'</option>';
                                    }
                                ?>
                                </select>
                            </div>
                            <div class="input-group my-2">
                                <span class="input-group-text">Fecha</span>
                                <input id="date" class="form-control datepicker" readonly>
                            </div>
                            <div class="input-group my-2">
                                <span class="input-group-text">Hora / Periodo</span>
                                <select class="form-control" id="hora">
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
                            <div class="input-group my-2">
                                <span class="input-group-text">Comentario</span>
                                <textarea id="comment" class="form-control"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cancelBtn" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="confBtn" class="btn btn-primary" onclick="editarReserva()">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        let misreservas = null
        document.addEventListener('DOMContentLoaded', function () {
            misreservas = new DataTable('#misreservas', {
                responsive: true,
                language: {
                    url: './static/dataTables.es-ES.json',
                }
            });
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

        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var rid = button.data('rid')
            var modal = $(this)
            modal.find('#rid').val(rid.id)
            modal.find('#aula').val(rid.aula)
            modal.find('#date').val(rid.fecha)
            modal.find('#hora').val(rid.inicio.slice(0,-3))
            modal.find('#comment').val(rid.comentario)
        })

        function editarReserva(){
            if(confirm('¿Cambiar datos de la reserva?')){
                formData = getEditForm()
                $.ajax({
                    type: "POST",
                    data: formData,
                    url: "./api/reservas/editarReserva",
                    dataType: 'json',
                    success: function(r){
                        if(r.isok){
                            showToast(`Reserva eliminada correctamente (ID ${formData.rid})`,'success')
                            setTimeout(() => {
                                location.reload()
                            }, 1000);
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
        }

        function borrarReserva(rid,row){
            if(confirm('¿Estás seguro de eliminar esta reserva? No se podrá recuperar'))
                $.ajax({
                    type: "POST",
                    data: { rid: rid },
                    url: "./api/reservas/borrarReserva",
                    dataType: 'json',
                    success: function(r){
                        if(r.isok){
                            showToast(`Reserva eliminada correctamente (ID ${rid})`,'success')
                            misreservas.row(row).remove().draw()
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

        function getEditForm(){
            var formData = {
                rid: $('#rid').val(),
                room: $('#aula').val(),
                date: $('#date').val(),
                hora: $('#hora').val(),
                comment: $('#comment').val()
            }
            $('#editReservaForm').trigger('reset');
            $('#editModal').modal('hide');
            return formData
        }

        $('#misreservas tbody').on( 'click', 'button.btn', function () {
            rid = parseInt($(this).attr('id'))
            action = $(this).data('action')
            row = $(this).parents('tr')
            
            if (action == 'borrar') borrarReserva(rid, row)
        })
    </script>
<?php 
    } else {        
         header("location: ../index.php");
    }
    include_once('./fragments/footer.php');
?>