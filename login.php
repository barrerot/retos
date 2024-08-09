<?php
include 'config.php';
session_start();

// Verificar si hay algún usuario en la base de datos
$sql = "SELECT COUNT(*) as count FROM jugadores";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    // Redirigir a registro si no hay usuarios
    header("Location: register.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT * FROM jugadores WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($contrasena, $row['contrasena'])) {
            $_SESSION['jugador_id'] = $row['id'];
            $_SESSION['tipo'] = $row['tipo'];
            header("Location: index.php");
            exit();
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Email no registrado";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inicio de Sesión</title>
</head>
<body>
    <h2>Inicio de Sesión</h2>
    <form action="login.php" method="post">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br>
        <label for="contrasena">Contraseña:</label><br>
        <input type="password" id="contrasena" name="contrasena"><br><br>
        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>
