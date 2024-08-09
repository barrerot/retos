<?php
session_start();
include 'config.php';

if (!isset($_SESSION['jugador_id']) || $_SESSION['tipo'] != 'jugador') {
    header("Location: login.php");
    exit();
}

$jugador_id = $_SESSION['jugador_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Selecciona un Juego</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .header {
            padding: 10px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #ddd;
        }

        h2 {
            text-align: center;
        }

        .game-card {
            display: inline-block;
            border: 1px solid #ddd;
            border-radius: 10px;
            width: 200px;
            margin: 10px;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            transition: 0.3s;
        }

        .game-card img {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .game-card h3 {
            margin: 10px 0;
            font-size: 18px;
        }

        .game-card a {
            display: block;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .game-card:hover {
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.4);
        }

        .container {
            text-align: center;
            padding: 20px;
        }

        /* Media Query para pantallas más pequeñas */
        @media (max-width: 600px) {
            .game-card {
                width: 100%;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="logout.php">Cerrar Sesión</a>
    </div>

    <h2>Selecciona un Juego</h2>
    <div class="container">
        <?php
        $sql = "SELECT * FROM juegos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                <div class='game-card'>
                    <img src='" . $row['imagen'] . "' alt='" . $row['nombre'] . "'>
                    <h3>" . $row['nombre'] . "</h3>
                    <a href='juego.php?juego_id=" . $row['id'] . "'>Seleccionar</a>
                </div>";
            }
        } else {
            echo "<p>No hay juegos disponibles.</p>";
        }
        ?>
    </div>
</body>
</html>
