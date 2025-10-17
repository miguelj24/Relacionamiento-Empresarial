/* ESTADISTICAS PARA ADMINISTRADOR */

// Función para detectar el modo oscuro
function isDarkMode() {
    return document.body.classList.contains('dark-mode') || 
           document.documentElement.classList.contains('dark-mode') ||
           document.body.getAttribute('data-theme') === 'dark' ||
           document.documentElement.getAttribute('data-theme') === 'dark';
}

// Función para obtener el color de texto según el tema
function getChartTextColor() {
    return isDarkMode() ? '#ffffff' : '#666';
}

// Función para obtener el color de borde según el tema
function getChartBorderColor() {
    return isDarkMode() ? '#444' : '#fff';
}

// Función para obtener configuración de grid
function getChartGridColor() {
    return isDarkMode() ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.1)';
}

/* EJEMPLO  # SOLICITUD POR MES*/
var canvas = document.getElementById('myChart');
// Solo crea la gráfica si el canvas existe en la página

document.addEventListener('DOMContentLoaded', function () {
  const canvas = document.getElementById('myChart');
  if (!canvas) {
    console.error('No se encontró el canvas con id="myChart"');
    return;
  }

  const ctx = canvas.getContext('2d');

  if (window.myChart instanceof Chart) {
    window.myChart.destroy();
  }

  const textColor = getChartTextColor();
  const gridColor = getChartGridColor();

  window.myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labelsData,
      datasets: [{
        label: 'Solicitudes',
        data: valuesData,
        backgroundColor: 'rgba(57,169,0,0.35)',
        borderColor: 'rgba(57,169,0,1)',
        borderWidth: 1,
        borderRadius: 6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: { 
          beginAtZero: true,
          ticks: { color: textColor },
          grid: { color: gridColor }
        },
        x: {
          ticks: { color: textColor },
          grid: { color: gridColor }
        }
      },
      plugins: {
        legend: { display: false },
        tooltip: { mode: 'index', intersect: false }
      }
    }
  });
});




/* SOLICITUDES EN PROCESO /EJECUTADAS */

var canvasLine = document.getElementById('requestinprocess');
if (canvasLine) {
    fetch('/solicitud/solicitudesPorMesAPI')
        .then(response => {
            if (!response.ok) throw new Error('No se pudo obtener los datos');
            return response.json();
        })
        .then(data => {
            if (!Array.isArray(data) || data.length === 0) {
                canvasLine.parentNode.innerHTML = "<p style='text-align:center;color:#888;'>No hay datos para mostrar.</p>";
                return;
            }

            const meses = data.map(item => item.mes);
            const enProceso = data.map(item => item.en_proceso);
            const ejecutadas = data.map(item => item.ejecutadas);

            const textColor = getChartTextColor();
            const gridColor = getChartGridColor();

            var ctxLine = canvasLine.getContext('2d');
            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: meses,
                    datasets: [
                        {
                            label: 'En Proceso',
                            data: enProceso,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.1)',
                            fill: false,
                            tension: 0.3
                        },
                        {
                            label: 'Ejecutadas',
                            data: ejecutadas,
                            borderColor: 'rgba(39, 169, 0, 1)',
                            backgroundColor: 'rgba(39, 169, 0, 0.1)',
                            fill: false,
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { labels: { color: textColor } },
                        title: { 
                            display: true, 
                            text: 'Solicitudes En Proceso y Ejecutadas por Mes',
                            color: textColor
                        }
                    },
                    scales: {
                        x: { 
                            ticks: { color: textColor },
                            grid: { color: gridColor }
                        },
                        y: { 
                            beginAtZero: true, 
                            ticks: { color: textColor },
                            grid: { color: gridColor }
                        }
                    }
                }
            });
        })
        .catch(error => {
            canvasLine.parentNode.innerHTML = "<p style='text-align:center;color:#c00;'>Error cargando la gráfica.</p>";
            console.error(error);
        });
}


/* SERVICIOS MÁS PEDIDOS - Pie/Doughnut Chart */
const serviciosLabels = [
    'Tecnólogo',
    'Técnico',
    'Cursos Cortos',
    'Sennova',
    'Emprendimiento'
];

const serviciosData = [25, 40, 15, 10, 20];

const serviciosColors = [
    'rgba(54, 162, 235, 0.7)',
    'rgba(39, 169, 0, 0.7)',
    'rgba(255, 206, 86, 0.7)',
    'rgba(153, 102, 255, 0.7)',
    'rgba(255, 99, 132, 0.7)'
];

var canvasServicios = document.getElementById('serviciospedidos');
if (canvasServicios) {
    fetch('/solicitud/serviciosMasSolicitadosAPI')
        .then(response => {
            if (!response.ok) throw new Error('No se pudo obtener los datos');
            return response.json();
        })
        .then(data => {
            if (!Array.isArray(data) || data.length === 0) {
                canvasServicios.parentNode.innerHTML = "<p style='text-align:center;color:#888;'>No hay datos para mostrar.</p>";
                return;
            }

            const labels = data.map(item => item.Servicio);
            const cantidades = data.map(item => parseInt(item.cantidad));
            const colors = data.map(item => item.Color || '#cccccc');

            const textColor = getChartTextColor();
            const borderColor = getChartBorderColor();

            var ctxServicios = canvasServicios.getContext('2d');
            new Chart(ctxServicios, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: cantidades,
                        backgroundColor: colors,
                        borderColor: borderColor,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: textColor
                            }
                        },
                        title: {
                            display: true,
                            text: 'Servicios más Solicitados',
                            color: textColor
                        }
                    }
                }
            });
        })
        .catch(error => {
            canvasServicios.parentNode.innerHTML = "<p style='text-align:center;color:#c00;'>Error cargando la gráfica.</p>";
            console.error(error);
        });
}

// MUNICIPIOS CON MÁS SOLICITUDES
var canvasMunicipios = document.getElementById('topMunicipios');
if (canvasMunicipios) {
    function generateColors(total) {
        const colors = [];
        for(let i = 0; i < total; i++) {
            const hue = (i * 360 / total) % 360;
            colors.push(`hsla(${hue}, 70%, 60%, 0.7)`);
        }
        return colors;
    }

    async function loadMunicipiosData() {
        try {
            const statsResponse = await fetch('/solicitud/municipiosMasSolicitudesAPI');
            if (!statsResponse.ok) throw new Error('Error obteniendo estadísticas');
            const solicitudesData = await statsResponse.json();

            const datasetFinal = solicitudesData
                .filter(item => item.cantidad > 0)
                .sort((a, b) => b.cantidad - a.cantidad);

            return datasetFinal;

        } catch (error) {
            console.error("Error:", error);
            throw error;
        }
    }

    loadMunicipiosData().then(data => {
        if (data.length === 0) {
            canvasMunicipios.parentNode.innerHTML = "<p style='text-align:center;color:#888;'>No hay solicitudes registradas en ningún municipio.</p>";
            return;
        }

        const municipiosLabels = data.map(item => item.Municipio);
        const municipiosData = data.map(item => item.cantidad);
        const municipiosColors = generateColors(data.length);

        canvasMunicipios.height = Math.max(300, municipiosLabels.length * 25);

        const textColor = getChartTextColor();
        const borderColor = getChartBorderColor();
        const gridColor = getChartGridColor();

        var ctxMunicipios = canvasMunicipios.getContext('2d');
        var municipiosChart = new Chart(ctxMunicipios, {
            type: 'bar',
            data: {
                labels: municipiosLabels,
                datasets: [{
                    label: 'Solicitudes',
                    data: municipiosData,
                    backgroundColor: municipiosColors,
                    borderColor: borderColor,
                    borderWidth: 2
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: 'Solicitudes por Municipio',
                        color: textColor
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: { color: textColor },
                        grid: { color: gridColor }
                    },
                    y: {
                        ticks: { 
                            color: textColor,
                            callback: function(value) {
                                const label = this.getLabelForValue(value);
                                return label.length > 15 ? label.substr(0, 12) + '...' : label;
                            }
                        },
                        grid: { color: gridColor }
                    }
                }
            }
        });
    }).catch(error => {
        canvasMunicipios.parentNode.innerHTML = "<p style='text-align:center;color:#c00;'>Error cargando la gráfica.</p>";
        console.error(error);
    });
}

// Estadística: Solicitudes por Estado (Gráfica de Torta/Pie Chart)

const estadosLabels = [
    'Pendiente',
    'Resuelto',
    'En proceso',
    'Ejecutado',
    'Asignado',
    'Cerrado'
];

const estadosData = [12, 8, 15, 10, 7, 5];

const estadosColors = [
    'rgba(255, 206, 86, 0.7)',
    'rgba(39, 169, 0, 0.7)',
    'rgba(54, 162, 235, 0.7)',
    'rgba(153, 102, 255, 0.7)',
    'rgba(255, 99, 132, 0.7)',
    'rgba(100, 100, 100, 0.7)'
];

var canvasEstados = document.getElementById('solicitudesPorEstado');
if (canvasEstados) {
    fetch('/solicitud/solicitudesPorEstadoAPI')
        .then(response => {
            if (!response.ok) throw new Error('No se pudo obtener los datos');
            return response.json();
        })
        .then(data => {
            if (!Array.isArray(data) || data.length === 0) {
                canvasEstados.parentNode.innerHTML = "<p style='text-align:center;color:#888;'>No hay datos para mostrar.</p>";
                return;
            }
            const labels = data.map(item => item.Estado);
            const cantidades = data.map(item => parseInt(item.cantidad));
            const colors = data.map(item => item.Color || '#ccc');

            const textColor = getChartTextColor();
            const borderColor = getChartBorderColor();

            var ctxEstados = canvasEstados.getContext('2d');
            new Chart(ctxEstados, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: cantidades,
                        backgroundColor: colors,
                        borderColor: borderColor,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: textColor
                            }
                        },
                        title: {
                            display: true,
                            text: 'Solicitudes por Estado',
                            color: textColor
                        }
                    }
                }
            });
        })
        .catch(error => {
            canvasEstados.parentNode.innerHTML = "<p style='text-align:center;color:#c00;'>Error cargando la gráfica.</p>";
            console.error(error);
        });
}