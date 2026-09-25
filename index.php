<?php
// 1. Abrimos la conexión con tus credenciales de Alwaysdata.
// (Recuerda cambiar "TU_CONTRASEÑA" por tu contraseña real).
$conexion = new mysqli("mysql-mumaa.alwaysdata.net", "mumaa_yael", "MUMA124", "mumaa_colmena");

// 2. Buscamos los últimos 15 datos registrados y los ordenamos cronologicamente.
$sql = "SELECT * FROM (SELECT fecha, peso, temperatura, humedad FROM lecturas ORDER BY id DESC LIMIT 15) sub ORDER BY fecha ASC";
$resultado = $conexion->query($sql);

// 3. Creamos "cajas" (arreglos) vacias en la memoria para organizar la informacion.
$fechas = []; $pesos = []; $temps = []; $hums = [];
$peso_actual = 0; $temp_actual = 0; $hum_actual = 0;

// 4. Llenamos las cajas extrayendo los datos fila por fila desde MySQL.
if ($resultado && $resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        // Recortamos la fecha completa para guardar solo la hora (ej. 14:30)
        $fechas[] = date("H:i", strtotime($fila["fecha"])); 
        $pesos[] = $fila["peso"];
        $temps[] = $fila["temperatura"];
        $hums[] = $fila["humedad"];
        
        // Al terminar de dar vueltas, estas variables conservaran el ultimo dato (el mas reciente).
        $peso_actual = $fila["peso"];
        $temp_actual = $fila["temperatura"];
        $hum_actual = $fila["humedad"];
    }
}
$conexion->close(); // Cerramos la base de datos para no consumir recursos del servidor.
?>