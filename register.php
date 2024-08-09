<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Registro de Jugadores</title>
</head>
<body>
    <h2>Registro de Jugadores</h2>
    <form action="register.php" method="post">
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre"><br>
        <label for="apellido">Apellido:</label><br>
        <input type="text" id="apellido" name="apellido"><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br>
        <label for="telefono">Teléfono:</label><br>
        <input type="text" id="telefono" name="telefono"><br>
        <label for="contrasena">Contraseña:</label><br>
        <input type="password" id="contrasena" name="contrasena"><br><br>
        <input type="submit" value="Registrar">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO jugadores (nombre, apellido, email, telefono, contrasena, tipo) VALUES ('$nombre', '$apellido', '$email', '$telefono', '$contrasena', 'jugador')";

        if ($conn->query($sql) === TRUE) {
            echo "Jugador registrado exitosamente";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    ?>

</body>
</html>
