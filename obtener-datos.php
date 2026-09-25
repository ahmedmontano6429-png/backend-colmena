<?php
header('Content-Type: application/json');
$conexion = new mysqli("mysql-mumaa.alwaysdata.net", "mumaa_yael", "MUMA124", "mumaa_colmena");

if ($conexion->connect_error) {
    die(json_encode(["error" => "Error de conexión"]));
}

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

// Imprimimos los datos en formato JSON
echo json_encode([
    "fechas" => $fechas,
    "pesos" => $pesos,
    "temps" => $temps,
    "hums" => $hums,
    "peso_actual" => $peso_actual,
    "temp_actual" => $temp_actual,
    "hum_actual" => $hum_actual
]);
?>