<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario Academico</title>

    <!-- ================== ESTILOS ================== -->

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.css" rel="stylesheet">

    <!-- Estilos personalizados -->
    <style>
        .header-personalizado {
            background-color: #501010;
            color: white;
            font-size: 18px;
            font-weight: bold;
        }

        .fc .fc-col-header-cell-cushion {
            color: #000;
            font-weight: bold;
        }

        .fc .fc-col-header-cell.fc-day-sun .fc-col-header-cell-cushion {
            color: #dc3545;
        }

        .fc .fc-col-header-cell.fc-day-sat .fc-col-header-cell-cushion {
            color: #000;
        }

        .fc-daygrid-day-number,
        .fc-daygrid-day-number a {
            color: #000 !important;
            text-decoration: none;
        }

        .form-control:focus {
            border-color: #501010;
            box-shadow: 0 0 0 0.25 coldrem rgba(80, 16, 16, 0.25);
        }

        .modal-header {
            border-bottom: none;
        }

        .modal-footer {
            border-top: none;
        }
    </style>
</head>

<body class="bg-light">

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header header-personalizado">
            📅 Calendario Academico
        </div>

        <div class="card-body">
            <p class="text-muted">
                Registra tus tareas y recordatorios academicos por día.
            </p>

            <div id="calendar"></div>
        </div>
    </div>
</div>

<!-- crear nuevo evento con titulo y lugar -->
<div class="modal fade" id="eventoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-personalizado">
                <h5 class="modal-title">Nuevo Evento Académico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEvento">
                    <div class="mb-3">
                        <label class="form-label">Titulo de la actividad</label>
                        <input type="text" id="titulo" class="form-control" placeholder="Ej: Examen de Álgebra" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lugar / Aula</label>
                        <input type="text" id="lugar" class="form-control" placeholder="Ej: Aula 204">
                    </div>
                    <input type="hidden" id="fecha_inicio">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="btnGuardar" class="btn btn-primary" style="background-color: #501010; border: none;">Guardar Evento</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar o eliminar eventos -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Editar/Eliminar Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditar">
                    <input type="hidden" id="edit_id">
                    <div class="mb-3">
                        <label class="form-label">Titulo</label>
                        <input type="text" id="edit_titulo" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lugar</label>
                        <input type="text" id="edit_lugar" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnEliminar" class="btn btn-danger">Eliminar Evento</button>
                <button type="button" id="btnActualizar" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<!-- Boton de salida del Dashboard de Breeze -->

<form method="POST" action="{{ route('logout') }}" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-outline-danger btn-sm">Cerrar Sesion</button>
</form>

<!-- ================== SCRIPTS ================== -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/locales/es.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        firstDay: 1,
        height: 600,
        events: @json($events),
        buttonText: { today: 'Hoy'},

        // 👉 GUARDAR EVENTO
        dateClick: function(info) {
                document.getElementById('fecha_inicio').value = info.dateStr;
                let modalElement = document.getElementById('eventoModal');
                let myModal = new bootstrap.Modal(modalElement); // cambio de var a let por consistencia
                myModal.show();
            },

        // Editar evento, el calendarcontroller debe enviar el id y lugar
        eventClick: function(info) {
                // Rellenamos los campos del modal con la info del evento
                document.getElementById('edit_id').value = info.event.id;
                document.getElementById('edit_titulo').value = info.event.title;
                document.getElementById('edit_lugar').value = info.event.extendedProps.lugar || '';

                let editModal = new bootstrap.Modal(document.getElementById('editModal'));
                editModal.show();
            } 
        }); //Aqui hubo un error de cerrado antes de tiempo, puedes quitar comentario si quieres

        calendar.render();

     //Aqui hubo un error xq falto ese cerrado, puedes quitar comentario si quieres

        // 2. Logica para guardar cuando haces clic en el boton del Modal
    document.getElementById('btnGuardar').addEventListener('click', function() {
        let titulo = document.getElementById('titulo').value;
        let fecha = document.getElementById('fecha_inicio').value;
        let lugar = document.getElementById('lugar').value;

        if (!titulo) {
            alert("El título es obligatorio");
            return;
        }

        fetch('/calendar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                title: titulo,
                start: fecha,
                lugar: lugar // ¡Ahora enviamos el aula también!
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload(); // Recarga para ver el nuevo evento
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Botón Actualizar
    document.getElementById('btnActualizar').onclick = function() {
        let id = document.getElementById('edit_id').value;
        fetch(`/calendar/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({
                title: document.getElementById('edit_titulo').value,
                lugar: document.getElementById('edit_lugar').value
            })
        }).then(() => location.reload());
    };

    // Botón Eliminar
    document.getElementById('btnEliminar').onclick = function() {
        if(confirm("¿Seguro que quieres borrar este evento?")) {
                let id = document.getElementById('edit_id').value;
            fetch(`/calendar/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            }).then(() => location.reload());
        }
    };

    
    
});
</script>

</body>
</html>

