@extends('layouts.app')
@section('content')
    <h1 class="text-center">Reporte de Asistencias</h1>
    <div class="chart-container" style="position: relative; height:60vh; width:70vw; margin: auto;">
        <canvas id="asistenciaChart"></canvas>
    </div>

    <div class="text-center mt-4">
        <button id="downloadBtn" class="btn btn-success">
            Descargar <i class="ti ti-download"></i>
        </button>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fechas = @json($datos_asistencia->pluck('fecha'));
            const asistencias = @json($datos_asistencia->pluck('total_asistencias'));
            const inasistencias = @json($datos_asistencia->pluck('total_inasistencias'));

            const ctx = document.getElementById('asistenciaChart').getContext('2d');
            const asistenciaChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: fechas,
                    datasets: [{
                            label: 'Asistencias',
                            data: asistencias,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            borderRadius: 8,
                        },
                        {
                            label: 'Inasistencias',
                            data: inasistencias,
                            backgroundColor: 'rgba(255, 99, 132, 0.6)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            borderRadius: 8,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Reporte de Asistencias e Inasistencias por Fecha',
                            font: {
                                size: 15
                            },
                            color: '#333'
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: '#666',
                                font: {
                                    size: 14
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            titleFont: {
                                size: 16
                            },
                            bodyFont: {
                                size: 14
                            },
                            padding: 12,
                            cornerRadius: 8,
                            caretSize: 6,
                        },
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#666',
                                font: {
                                    size: 12
                                },
                                maxRotation: 45,
                                minRotation: 45,
                            },
                            grid: {
                                display: false
                            },
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#666',
                                font: {
                                    size: 12
                                },
                                stepSize: 1,
                            },
                            grid: {
                                color: 'rgba(200, 200, 200, 0.2)',
                            },
                        }
                    },
                    animation: {
                        duration: 1500,
                        easing: 'easeOutBounce'
                    }
                }
            });

            // Función para descargar el CSV
            document.getElementById('downloadBtn').addEventListener('click', function() {
                // Crear el contenido del CSV
                let csvContent = "data:text/csv;charset=utf-8," +
                    "Fecha,Total Asistencias,Total Inasistencias\n" // Encabezados
                    +
                    fechas.map((fecha, index) => `${fecha},${asistencias[index]},${inasistencias[index]}`)
                    .join("\n");

                // Crear un enlace temporal para la descarga
                const encodedUri = encodeURI(csvContent);
                const link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", "reporte_asistencias.csv");
                document.body.appendChild(link); // Necesario para Firefox

                link.click(); // Hacer clic en el enlace para descargar
                document.body.removeChild(link); // Limpiar
            });
        });
    </script>
@endsection
