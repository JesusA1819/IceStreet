<?php
include 'conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptamos la contraseña

    $sql = "INSERT INTO usuarios (nombre, email, password) VALUES ('$nombre', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        $mensaje = "¡Registro exitoso! <a href='login.php'>Inicia Sesión aquí</a>";
    } else {
        $mensaje = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - ICE STREET</title>
    <style>
        body { background: #f4f4f4; font-family: 'Roboto Mono', monospace; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 40px; border-top: 5px solid #D6001C; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 300px; text-align: center; }
        h2 { font-family: 'Archivo Black'; color: #D6001C; text-transform: uppercase; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: black; color: white; border: none; font-weight: bold; cursor: pointer; }
        button:hover { background: #D6001C; }
        a { color: #888; text-decoration: none; font-size: 0.8rem; display: block; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Únete al Crew</h2>
        <form method="POST" action="">
            <input type="text" name="nombre" placeholder="Nombre Completo" required>
            <input type="email" name="email" placeholder="Correo Electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">REGISTRARSE</button>
        </form>
        <p style="color:green;"><?php echo $mensaje; ?></p>
        <a href="index.php">Volver a la tienda</a>
        <a href="login.php">¿Ya tienes cuenta? Entra aquí</a>
    </div>
</body>
</html>