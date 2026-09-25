<?php
$conexion = new mysqli("mysql-mumaa.alwaysdata.net", "mumaa_yael", "MUMA124", "mumaa_colmena");
$sql = "SELECT * FROM (SELECT fecha, peso, temperatura, humedad FROM lecturas ORDER BY id DESC LIMIT 15) sub ORDER BY fecha ASC";
$resultado = $conexion->query($sql);

$fechas = []; $pesos = []; $temps = []; $hums = [];
$peso_actual = 0; $temp_actual = 0; $hum_actual = 0;

if ($resultado && $resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        $fechas[] = date("H:i", strtotime($fila["fecha"])); 
        $pesos[] = $fila["peso"];
        $temps[] = $fila["temperatura"];
        $hums[] = $fila["humedad"];
        $peso_actual = $fila["peso"];
        $temp_actual = $fila["temperatura"];
        $hum_actual = $fila["humedad"];
    }
}
$conexion->close(); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="10"> 
    <title>Dashboard IOT - Colmena</title>
    <!-- Fuente profesional de Google -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="cabecera">
        <div class="titulo-contenedor">
            <h1><span style="font-size: 30px;">🐝</span> Monitoreo IoT Apícola</h1>
            <p>Ingeniería en Sistemas Computacionales</p>
        </div>
        <img src="logo_tec.png" class="logo-tec" alt="ITMA II" onerror="this.style.display='none'">
    </header>

    <main class="cuadricula">
        <!-- Tarjeta Temperatura -->
        <div class="tarjeta">
            <h2>🌡️ TENDENCIA TEMPERATURA</h2>
            <div class="grafica-contenedor"><canvas id="graficaTemp"></canvas></div>
        </div>

        <!-- Tarjeta Central (Peso) -->
        <div class="tarjeta">
            <h2 class="destacado">PESO DEL ENJAMBRE</h2>
            <div class="indicador-peso">
                <canvas id="graficaPeso"></canvas>
                <div class="valor-central">
                    <span class="numero"><?php echo $peso_actual; ?></span>
                    <span class="unidad">KILOGRAMOS</span>
                </div>
            </div>
            <div class="metricas-rapidas">
                <div class="metrica">
                    <span class="etiqueta">Temperatura</span>
                    <span class="valor rojo"><?php echo $temp_actual; ?>°C</span>
                </div>
                <div class="metrica">
                    <span class="etiqueta">Humedad</span>
                    <span class="valor azul"><?php echo $hum_actual; ?>%</span>
                </div>
            </div>
        </div>

        <!-- Tarjeta Humedad -->
        <div class="tarjeta">
            <h2>💧 TENDENCIA HUMEDAD</h2>
            <div class="grafica-contenedor"><canvas id="graficaHum"></canvas></div>
        </div>
    </main>

    <footer>
        Tecnológico de Milpa Alta II - Sistema de Monitoreo Remoto con ESP32
    </footer>
    
    <script>
        const etiquetasHora = <?php echo json_encode($fechas); ?>;
        const datosTemperatura = <?php echo json_encode($temps); ?>;
        const datosHumedad = <?php echo json_encode($hums); ?>;
        const peso = <?php echo $peso_actual; ?>;
    </script>
    <script src="app.js"></script>
</body>
</html>