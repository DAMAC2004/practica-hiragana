<?php
$host = 'localhost'; // El servidor de la base de datos
$user = 'Damac'; // El usuario de la base de datos
$password = '040904'; // La contraseña (por defecto no tiene contraseña en Laragon)
$dbname = 'hiragana_practice'; // El nombre de la base de datos

// Crear la conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Comprobar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
