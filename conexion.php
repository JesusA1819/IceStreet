<?php
$servidor = "localhost";
$usuario = "root";
$password = ""; // En XAMPP por defecto es vacío
$base_datos = "ice_street";

$conn = new mysqli($servidor, $usuario, $password, $base_datos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>