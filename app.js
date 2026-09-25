Chart.defaults.color = '#94a3b8';
Chart.defaults.font.family = "'Inter', sans-serif";

const opcionesBase = { 
    responsive: true, maintainAspectRatio: false,
    scales: { 
        x: { grid: { display: false } }, 
        y: { grid: { color: 'rgba(255, 255, 255, 0.05)' }, beginAtZero: false } 
    }, 
    plugins: { 
        legend: { display: false },
        tooltip: { backgroundColor: 'rgba(15, 22, 38, 0.9)', padding: 12, cornerRadius: 8, displayColors: false }
    }, 
    elements: { point: { radius: 2, hitRadius: 10, hoverRadius: 5 } },
    interaction: { mode: 'index', intersect: false },
    animation: { duration: 800 } // Animación fluida al actualizar
};

// 1. Gráfica de Temperatura
const ctxTemp = document.getElementById('graficaTemp').getContext('2d');
let gradienteTemp = ctxTemp.createLinearGradient(0, 0, 0, 300);
gradienteTemp.addColorStop(0, 'rgba(239, 68, 68, 0.4)');
gradienteTemp.addColorStop(1, 'rgba(239, 68, 68, 0.0)');

const chartTemp = new Chart(ctxTemp, {
    type: 'line',
    data: { labels: etiquetasHora, datasets: [{ data: datosTemperatura, borderColor: '#ef4444', backgroundColor: gradienteTemp, fill: true, tension: 0.4, borderWidth: 2 }] },
    options: opcionesBase
});

// 2. Gráfica de Humedad
const ctxHum = document.getElementById('graficaHum').getContext('2d');
let gradienteHum = ctxHum.createLinearGradient(0, 0, 0, 300);
gradienteHum.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
gradienteHum.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

const chartHum = new Chart(ctxHum, {
    type: 'line',
    data: { labels: etiquetasHora, datasets: [{ data: datosHumedad, borderColor: '#3b82f6', backgroundColor: gradienteHum, fill: true, tension: 0.4, borderWidth: 2 }] },
    options: opcionesBase
});

// 3. Medidor circular de peso
const chartPeso = new Chart(document.getElementById('graficaPeso'), {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [peso, Math.max(0, 30 - peso)], 
            backgroundColor: ['#f59e0b', '#334155'], 
            borderWidth: 0,
            borderRadius: [8, 0] 
        }]
    },
    options: { 
        responsive: true, maintainAspectRatio: false,
        circumference: 260, rotation: 230, cutout: '85%', 
        plugins: { tooltip: { enabled: false } },
        animation: { duration: 800 }
    }
});

// ==========================================
// MAGIA AJAX: Actualización invisible cada 10 segundos
// ==========================================
setInterval(function() {
    fetch('obtener_datos.php')
        .then(respuesta => respuesta.json())
        .then(datos => {
            // Actualizar los números de texto en pantalla
            document.getElementById('texto-peso').innerText = datos.peso_actual;
            document.getElementById('texto-temp').innerText = datos.temp_actual + '°C';
            document.getElementById('texto-hum').innerText = datos.hum_actual + '%';

            // Actualizar las líneas de las gráficas
            chartTemp.data.labels = datos.fechas;
            chartTemp.data.datasets[0].data = datos.temps;
            chartTemp.update();

            chartHum.data.labels = datos.fechas;
            chartHum.data.datasets[0].data = datos.hums;
            chartHum.update();

            // Actualizar la rosca de peso
            chartPeso.data.datasets[0].data = [datos.peso_actual, Math.max(0, 30 - datos.peso_actual)];
            chartPeso.update();
        })
        .catch(error => console.log("Error buscando nuevos datos: ", error));
}, 10000); // 10000 milisegundos = 10 segundos