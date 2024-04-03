<?php
session_start();
if (isset($_SESSION['usuario_login']) && $_SESSION['usuario_login']['cod_usuario'] == '0') {
    include_once('./fragments/headers.php');
?>

<main class="container mx-auto px-5 py-2">
    <h3 class="text-center my-2 p-2">PÁGINA DE PRUEBAS - DEBUG</h3>
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
        </tbody>
    </table>
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
            rowId: [6],
            language: {
                url: './static/dataTables.es-ES.json',
            },
        });
        cargarReservas();
    });

    function cargarReservas(){
        $.ajax({
            type: "POST",
            data: {},
            url: "./api/reservas/obtenerMisReservas",
            dataType: 'json',
            success: function(r){
                if(r.isok){
                    showToast(`Cargadas ${r.data.length} reservas`,'success',1000)
                    loadData(r.data)
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

    function loadData(data){
        for(row of data){
            misreservas.row.add({
                0: row.aula, 1: row.fecha, 2: row.inicio.slice(0,-3), 3: row.fin.slice(0,-3), 4: row.comentario,
                5: `<div class="d-flex flex-row justify-content-center align-items-center">
                        <button type="button" class="btn btn-primary rounded-3 py-2 px-3 mx-2" data-bs-toggle="modal" data-bs-target="#editModal" data-action="editar">
                                <svg xmlns="http://www.w3.org/2000/svg" style="height: 24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                        </button>
                        <button type="button" class="btn btn-danger rounded-3 py-2 px-3 mx-2" data-action="borrar">
                                <svg xmlns="http://www.w3.org/2000/svg" style="height: 24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                        </button>
                    </div>
                `, 6: row.id
            });
        }
        misreservas.draw()
    }

    // $('#editModal').on('show.bs.modal', function (event) {
    //         var button = $(event.relatedTarget)
    //         var rid = button.data('rid')
    //         var modal = $(this)
    //         modal.find('#rid').val(rid.id)
    //         modal.find('#aula').val(rid.aula)
    //         modal.find('#date').val(rid.fecha)
    //         modal.find('#hora').val(rid.inicio.slice(0,-3))
    //         modal.find('#comment').val(rid.comentario)
    //     })

    
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
                        showToast(`Reserva editada correctamente (ID ${r.data.id})`,'success')
                        row = misreservas.row(`#${r.data.id}`)
                        row.data()[0] = r.data.aula
                        row.data()[1] = r.data.fecha
                        row.data()[2] = r.data.inicio
                        row.data()[3] = r.data.fin
                        row.data()[4] = r.data.comentario
                        console.log(row.data())
                        row.draw()
                        misreservas.draw()
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
                        misreservas.row(row).remove()
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
            row = $(this).parents('tr')
            data = misreservas.row(row).data()
            action = $(this).data('action')
            if(action == 'editar'){
                rid = $(this).data('rid')
                modal = $('#editModal')
                modal.find('#rid').val(data[6])
                modal.find('#aula').val(data[0])
                modal.find('#date').val(data[1])
                modal.find('#hora').val(data[2])
                modal.find('#comment').val(data[4])
            }
            else borrarReserva(data[6], row)            
        })

</script>
<?php
    include_once('./fragments/footer.php');
} 
else header("location: ../index.php");
?>