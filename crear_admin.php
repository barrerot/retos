<?php
include 'config.php'; // Asegúrate de que config.php tiene los datos correctos para conectar a la base de datos

// Datos del administrador
$nombre = 'Carlos';
$apellido = 'Barrero';
$email = 'barrerot@gmail.com';
$telefono = '699490161';
$contrasena = password_hash('12345', PASSWORD_BCRYPT); // Encripta la contraseña
$tipo = 'administrador';

// Consulta SQL para insertar el usuario administrador
$sql = "INSERT INTO jugadores (nombre, apellido, email, telefono, contrasena, tipo) 
        VALUES ('$nombre', '$apellido', '$email', '$telefono', '$contrasena', '$tipo')";

if ($conn->query($sql) === TRUE) {
    echo "Usuario administrador creado con éxito.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
