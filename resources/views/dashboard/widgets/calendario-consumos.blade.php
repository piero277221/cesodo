<div class="widget-container" data-widget-id="{{ $widget->widget_id }}">
    <div class="widget-header">
        <h6 class="widget-title mb-0">
            <i class="fas fa-calendar-alt me-2"></i>
            Calendario de Consumos
        </h6>
        <div class="widget-controls">
            <button class="btn btn-sm btn-outline-secondary widget-config" title="Configurar">
                <i class="fas fa-cog"></i>
            </button>
            <button class="btn btn-sm btn-outline-secondary widget-collapse" title="Minimizar">
                <i class="fas fa-minus"></i>
            </button>
            <button class="btn btn-sm btn-outline-danger widget-remove" title="Eliminar">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <div class="widget-content">
        <div class="calendar-header mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <button class="btn btn-sm btn-outline-secondary" id="prevMonth{{ $widget->widget_id }}">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <h6 class="calendar-title mb-0" id="currentMonth{{ $widget->widget_id }}">
                    {{ now()->locale('es')->translatedFormat('F Y') }}
                </h6>
                <button class="btn btn-sm btn-outline-secondary" id="nextMonth{{ $widget->widget_id }}">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <div class="mini-calendar">
            <div class="calendar-weekdays">
                <div class="weekday">Dom</div>
                <div class="weekday">Lun</div>
                <div class="weekday">Mar</div>
                <div class="weekday">Mié</div>
                <div class="weekday">Jue</div>
                <div class="weekday">Vie</div>
                <div class="weekday">Sáb</div>
            </div>
            <div class="calendar-days" id="calendarDays{{ $widget->widget_id }}">
                <!-- Los días se generarán dinámicamente -->
            </div>
        </div>

        <div class="calendar-legend mt-3">
            <div class="row g-2">
                <div class="col-6">
                    <div class="legend-item">
                        <span class="legend-dot high-activity"></span>
                        <span class="legend-text">Alta actividad (10+)</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="legend-item">
                        <span class="legend-dot medium-activity"></span>
                        <span class="legend-text">Media (5-9)</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="legend-item">
                        <span class="legend-dot low-activity"></span>
                        <span class="legend-text">Baja (1-4)</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="legend-item">
                        <span class="legend-dot no-activity"></span>
                        <span class="legend-text">Sin actividad</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="calendar-stats mt-3">
            <div class="row g-2 text-center">
                <div class="col-4">
                    <div class="stat-mini">
                        <div class="stat-number">{{ $data['consumos_mes'] ?? 0 }}</div>
                        <div class="stat-label">Este mes</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="stat-mini">
                        <div class="stat-number">{{ $data['promedio_diario'] ?? 0 }}</div>
                        <div class="stat-label">Promedio/día</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="stat-mini">
                        <div class="stat-number">{{ $data['dias_activos'] ?? 0 }}</div>
                        <div class="stat-label">Días activos</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="widget-footer mt-3">
            <a href="{{ route('reportes.consumos') }}" class="btn btn-sm btn-outline-primary w-100">
                <i class="fas fa-chart-line me-1"></i>
                Ver reporte completo
            </a>
        </div>
    </div>
</div>

<style>
.calendar-header {
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 0.75rem;
}

.calendar-title {
    color: #495057;
    font-weight: 600;
}

.mini-calendar {
    background: #fff;
    border-radius: 8px;
}

.calendar-weekdays {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 1px;
    background: #e9ecef;
    border-radius: 8px 8px 0 0;
    overflow: hidden;
}

.weekday {
    background: #f8f9fa;
    padding: 0.5rem 0.25rem;
    text-align: center;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6c757d;
}

.calendar-days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 1px;
    background: #e9ecef;
    border-radius: 0 0 8px 8px;
    overflow: hidden;
}

.calendar-day {
    background: #fff;
    padding: 0.5rem 0.25rem;
    text-align: center;
    font-size: 0.75rem;
    position: relative;
    cursor: pointer;
    transition: all 0.2s ease;
    min-height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.calendar-day:hover {
    background: #f8f9fa;
}

.calendar-day.other-month {
    color: #adb5bd;
    background: #f8f9fa;
}

.calendar-day.today {
    background: #007bff;
    color: white;
    font-weight: 600;
}

.calendar-day.has-activity::after {
    content: '';
    position: absolute;
    bottom: 2px;
    left: 50%;
    transform: translateX(-50%);
    width: 4px;
    height: 4px;
    border-radius: 50%;
}

.calendar-day.high-activity::after {
    background: #dc3545;
}

.calendar-day.medium-activity::after {
    background: #ffc107;
}

.calendar-day.low-activity::after {
    background: #28a745;
}

.calendar-legend {
    border-top: 1px solid #f1f1f1;
    padding-top: 0.75rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.25rem;
}

.legend-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}

.legend-dot.high-activity {
    background: #dc3545;
}

.legend-dot.medium-activity {
    background: #ffc107;
}

.legend-dot.low-activity {
    background: #28a745;
}

.legend-dot.no-activity {
    background: #dee2e6;
}

.legend-text {
    font-size: 0.7rem;
    color: #6c757d;
}

.calendar-stats {
    border-top: 1px solid #f1f1f1;
    padding-top: 0.75rem;
}

.stat-mini {
    padding: 0.5rem;
    background: #f8f9fa;
    border-radius: 6px;
}

.stat-mini .stat-number {
    font-size: 1rem;
    font-weight: 600;
    color: #495057;
}

.stat-mini .stat-label {
    font-size: 0.7rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

.widget-footer {
    border-top: 1px solid #e9ecef;
    padding-top: 1rem;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .calendar-day {
        min-height: 28px;
        font-size: 0.7rem;
    }

    .weekday {
        font-size: 0.7rem;
        padding: 0.375rem 0.125rem;
    }

    .legend-text {
        font-size: 0.65rem;
    }

    .stat-mini .stat-number {
        font-size: 0.9rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const widgetId = '{{ $widget->widget_id }}';
    let currentDate = new Date();

    // Datos de consumos del servidor
    const consumosData = @json($data['calendar_data'] ?? []);

    // Inicializar calendario
    generateCalendar(currentDate, consumosData, widgetId);

    // Navegación del calendario
    document.getElementById(`prevMonth${widgetId}`).addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        updateCalendar(currentDate, widgetId);
    });

    document.getElementById(`nextMonth${widgetId}`).addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        updateCalendar(currentDate, widgetId);
    });

    // Auto-refresh cada 10 minutos
    setInterval(() => {
        updateCalendarData(widgetId);
    }, 600000);
});

function generateCalendar(date, consumosData, widgetId) {
    const year = date.getFullYear();
    const month = date.getMonth();

    // Actualizar título
    const monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    document.getElementById(`currentMonth${widgetId}`).textContent = `${monthNames[month]} ${year}`;

    // Generar días
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const startDate = new Date(firstDay);
    startDate.setDate(startDate.getDate() - firstDay.getDay());

    const daysContainer = document.getElementById(`calendarDays${widgetId}`);
    daysContainer.innerHTML = '';

    for (let i = 0; i < 42; i++) { // 6 semanas x 7 días
        const currentDay = new Date(startDate);
        currentDay.setDate(startDate.getDate() + i);

        const dayElement = document.createElement('div');
        dayElement.className = 'calendar-day';
        dayElement.textContent = currentDay.getDate();

        // Clases adicionales
        if (currentDay.getMonth() !== month) {
            dayElement.classList.add('other-month');
        }

        if (isToday(currentDay)) {
            dayElement.classList.add('today');
        }

        // Añadir actividad si existe
        const dayKey = `${currentDay.getFullYear()}-${String(currentDay.getMonth() + 1).padStart(2, '0')}-${String(currentDay.getDate()).padStart(2, '0')}`;
        const activity = consumosData[dayKey];

        if (activity) {
            dayElement.classList.add('has-activity');
            if (activity >= 10) {
                dayElement.classList.add('high-activity');
            } else if (activity >= 5) {
                dayElement.classList.add('medium-activity');
            } else {
                dayElement.classList.add('low-activity');
            }
            dayElement.title = `${activity} consumos`;
        }

        daysContainer.appendChild(dayElement);
    }
}

function isToday(date) {
    const today = new Date();
    return date.getDate() === today.getDate() &&
           date.getMonth() === today.getMonth() &&
           date.getFullYear() === today.getFullYear();
}

function updateCalendar(date, widgetId) {
    // Actualizar calendario con nueva fecha
    fetch(`/dashboard/widgets/${widgetId}/calendar-data`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        },
        body: JSON.stringify({
            year: date.getFullYear(),
            month: date.getMonth() + 1
        })
    })
    .then(response => response.json())
    .then(data => {
        generateCalendar(date, data.calendar_data || {}, widgetId);
    })
    .catch(error => {
        console.error('Error updating calendar:', error);
        generateCalendar(date, {}, widgetId);
    });
}

function updateCalendarData(widgetId) {
    const widget = document.querySelector(`[data-widget-id="${widgetId}"]`);
    if (!widget) return;

    fetch(`/dashboard/widgets/${widgetId}/data`)
        .then(response => response.json())
        .then(data => {
            if (data.html) {
                widget.querySelector('.widget-content').innerHTML = data.html;
            }
        })
        .catch(error => console.error('Error updating calendar data:', error));
}
</script>
