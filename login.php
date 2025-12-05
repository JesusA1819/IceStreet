<?php
session_start();
include 'conexion.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, nombre, password FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Contraseña correcta: Iniciamos sesión
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];
            header("Location: index.php"); // Redirigir a la tienda
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "El usuario no existe.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - ICE STREET</title>
    <style>
        body { background: #000; font-family: 'Roboto Mono', monospace; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; color: white;}
        .card { background: #111; padding: 40px; border: 2px solid #D6001C; width: 300px; text-align: center; }
        h2 { font-family: 'Archivo Black'; color: white; text-transform: uppercase; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #333; background: black; color: white; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #D6001C; color: white; border: none; font-weight: bold; cursor: pointer; margin-top: 10px;}
        button:hover { background: white; color: black; }
        a { color: #888; text-decoration: none; font-size: 0.8rem; display: block; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Acceso ICE</h2>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Correo" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">ENTRAR</button>
        </form>
        <p style="color:red;"><?php echo $error; ?></p>
        <a href="registro.php">¿No tienes cuenta? Regístrate</a>
    </div>
</body>
</html>