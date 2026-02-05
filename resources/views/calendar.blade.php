<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario Académico</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css" rel="stylesheet">

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

        .fc-daygrid-day-number {
            color: #000;
            text-decoration: none;
        }
    </style>
</head>

<body class="bg-light">

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header header-personalizado">
            📅 Calendario Académico
        </div>

        <div class="card-body">
            <p class="text-muted">
                Registra tus tareas y recordatorios académicos por día.
            </p>

            <div id="calendar"></div>
        </div>
    </div>
</div>

<!-- MODAL CREAR EVENTO -->
<div class="modal fade" id="eventoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-personalizado">
                <h5 class="modal-title">Nuevo Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Título</label>
                    <input type="text" id="titulo" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Lugar</label>
                    <input type="text" id="lugar" class="form-control">
                </div>

                <input type="hidden" id="fecha_inicio">
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button id="btnGuardar" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDITAR -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Editar / Eliminar</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="edit_id">

                <div class="mb-3">
                    <label class="form-label">Título</label>
                    <input type="text" id="edit_titulo" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Lugar</label>
                    <input type="text" id="edit_lugar" class="form-control">
                </div>
            </div>

            <div class="modal-footer">
                <button id="btnEliminar" class="btn btn-danger">Eliminar</button>
                <button id="btnActualizar" class="btn btn-primary">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>

<!-- LOGOUT -->
<form method="POST" action="{{ route('logout') }}" class="mt-3 text-center">
    @csrf
    <button type="submit" class="btn btn-outline-danger btn-sm">Cerrar sesión</button>
</form>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/locales/es.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        firstDay: 1,
        height: 600,
        events: @json($events),

        dateClick(info) {
            document.getElementById('fecha_inicio').value = info.dateStr;
            new bootstrap.Modal(document.getElementById('eventoModal')).show();
        },

        eventClick(info) {
            document.getElementById('edit_id').value = info.event.id;
            document.getElementById('edit_titulo').value = info.event.title;
            document.getElementById('edit_lugar').value = info.event.extendedProps.lugar || '';
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }
    });

    calendar.render();

    // GUARDAR
    document.getElementById('btnGuardar').onclick = () => {
        fetch('/calendar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                title: document.getElementById('titulo').value,
                start: document.getElementById('fecha_inicio').value,
                lugar: document.getElementById('lugar').value
            })
        }).then(() => location.reload());
    };

    // ACTUALIZAR
    document.getElementById('btnActualizar').onclick = () => {
        const id = document.getElementById('edit_id').value;

        fetch(`/calendar/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                title: document.getElementById('edit_titulo').value,
                lugar: document.getElementById('edit_lugar').value
            })
        }).then(() => location.reload());
    };

    // ELIMINAR
    document.getElementById('btnEliminar').onclick = () => {
        if (!confirm('¿Eliminar evento?')) return;

        const id = document.getElementById('edit_id').value;

        fetch(`/calendar/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(() => location.reload());
    };

});
</script>

</body>
</html>
