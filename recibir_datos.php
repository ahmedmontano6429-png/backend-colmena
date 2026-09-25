<?php
// Credenciales de tu base de datos en Clever Cloud
$servername = "b6xibbccoplxhxf6btoh-mysql.services.clever-cloud.com";
$username = "utfweyhdg8uyflzi";
$password = "2nMxJYnr25BAE9WuCw79"; // <-- Reemplaza esto con tu contraseña real
$dbname = "b6xibbccoplxhxf6btoh";

// 1. Crear conexion
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Fallo en la conexión: " . $conn->connect_error);
}

// 2. RECEPCION Y VALIDACION DE DATOS
if(isset($_POST['peso']) && isset($_POST['temperatura']) && isset($_POST['humedad'])) {
    
    // Guardamos los datos que llegaron en variables
    $peso = $_POST['peso'];
    $temp = $_POST['temperatura'];
    $hum = $_POST['humedad'];

    // 3. INYECCIÓN SQL
    $sql = "INSERT INTO lecturas (peso, temperatura, humedad) VALUES ('$peso', '$temp', '$hum')";

    if ($conn->query($sql) === TRUE) {
        echo "Exito: Registro guardado en la nube";
    } else {
        echo "Error en base de datos: " . $conn->error;
    }

} else {
    // Si entras desde el navegador de tu computadora, veras este mensaje
    echo "Servidor nube activo y conectado a Clever Cloud. Esperando el POST del ESP32...";
}

$conn->close();
?>