<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario Académico</title>

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

<!-- ================== SCRIPTS ================== -->

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/locales/es.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        firstDay: 1,
        height: 500,

        buttonText: {
            today: 'Hoy'
        },

        // 👉 EVENTOS DESDE LA BASE DE DATOS
        events: @json($events),

        // 👉 GUARDAR EVENTO
        dateClick: function(info) {
            let title = prompt("¿Qué tienes que hacer este día?");

            if (title) {
                fetch('/calendar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        title: title,
                        start: info.dateStr
                    })
                }).then(() => location.reload());
            }
        }
    });

    calendar.render();
});
</script>

</body>
</html>

