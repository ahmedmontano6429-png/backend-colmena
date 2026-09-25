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
    interaction: { mode: 'index', intersect: false }
};

// Configurar gráficas con efecto de desvanecimiento (Gradient)
const ctxTemp = document.getElementById('graficaTemp').getContext('2d');
let gradienteTemp = ctxTemp.createLinearGradient(0, 0, 0, 300);
gradienteTemp.addColorStop(0, 'rgba(239, 68, 68, 0.4)');
gradienteTemp.addColorStop(1, 'rgba(239, 68, 68, 0.0)');

new Chart(ctxTemp, {
    type: 'line',
    data: { labels: etiquetasHora, datasets: [{ data: datosTemperatura, borderColor: '#ef4444', backgroundColor: gradienteTemp, fill: true, tension: 0.4, borderWidth: 2 }] },
    options: opcionesBase
});

const ctxHum = document.getElementById('graficaHum').getContext('2d');
let gradienteHum = ctxHum.createLinearGradient(0, 0, 0, 300);
gradienteHum.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
gradienteHum.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

new Chart(ctxHum, {
    type: 'line',
    data: { labels: etiquetasHora, datasets: [{ data: datosHumedad, borderColor: '#3b82f6', backgroundColor: gradienteHum, fill: true, tension: 0.4, borderWidth: 2 }] },
    options: opcionesBase
});

// Medidor circular de peso moderno
new Chart(document.getElementById('graficaPeso'), {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [peso, Math.max(0, 30 - peso)], // Ajustado para un peso maximo de 30kg
            backgroundColor: ['#f59e0b', '#334155'], 
            borderWidth: 0,
            borderRadius: [8, 0] // Puntas redondeadas
        }]
    },
    options: { 
        responsive: true, maintainAspectRatio: false,
        circumference: 260, rotation: 230, cutout: '85%', 
        plugins: { tooltip: { enabled: false } } 
    }
});