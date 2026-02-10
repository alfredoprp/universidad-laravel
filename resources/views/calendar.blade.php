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
            background-color: #383a4f;
            color: white;
            font-size: 18px;
            font-weight: bold;
        }

        .fc .fc-col-header-cell-cushion {
            color: #6366f1;
            font-weight: bold;
        }

        .fc-daygrid-day-number {
            color: #ffffff;
            text-decoration: none;
        }

        .fc {
            background-color: #111827; /* El mismo gris oscuro de tu dashboard */
            color: #ffffff;
            padding: 15px;
            border-radius: 8px;
        }

        /* Color de los encabezados (lun, mar, etc.) */
        .fc-col-header-cell {
            background-color: #1f2937;
            color: #333355;
        }

        /* Cambiar el color de las celdas y bordes */
        .fc-theme-standard td, .fc-theme-standard th {
            border: 1px solid #374151 !important;
        }

        /* Cambiar el color del boton "Hoy" y las flechas para que sean como el boton "Aprender" */
        .fc-button-primary {
            background-color: #6366f1 !important; /* El morado de tu dashboard */
            border-color: #6366f1 !important;
        }

        /* Cambiar el fondo del dia actual */
        .fc .fc-daygrid-day.fc-day-today {
            background-color: rgba(99, 102, 241, 0.2) !important; /* Un morado muy transparente */
        }
    </style>
</head>

<body class="bg-light">

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Calendario Académico') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</x-app-layout>

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


<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/locales/es.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        eventColor: '#ffffff', 
        eventTextColor: '#4b83b8',
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
