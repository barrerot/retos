<?php
session_start();
include 'config.php';

if (!isset($_SESSION['jugador_id'])) {
    header("Location: index.php");
    exit();
}

$jugador_id = $_SESSION['jugador_id'];

// Obtener nombre y apellido del jugador
$sql = "SELECT nombre, apellido FROM jugadores WHERE id = $jugador_id";
$result = $conn->query($sql);
$jugador = $result->fetch_assoc();
$nombre_completo = $jugador['nombre'] . ' ' . $jugador['apellido'];

// Obtener progreso del jugador
$sql_progreso = "SELECT COUNT(*) AS niveles_completados FROM niveles_superados WHERE jugador_id = $jugador_id";
$result_progreso = $conn->query($sql_progreso);
$progreso_jugador = $result_progreso->fetch_assoc()['niveles_completados'];

// Calcular el total de niveles
$sql_total_niveles = "SELECT SUM(niveles) AS total_niveles FROM juegos";
$result_total_niveles = $conn->query($sql_total_niveles);
$total_niveles = $result_total_niveles->fetch_assoc()['total_niveles'];

// Evitar división por cero
if ($total_niveles > 0) {
    $progreso_jugador_percent = ($progreso_jugador / $total_niveles) * 100;
} else {
    $progreso_jugador_percent = 0;
}

// Obtener el progreso por juego
$sql_juegos = "SELECT juegos.nombre, COUNT(niveles_superados.nivel) AS niveles_completados, juegos.niveles 
               FROM juegos 
               LEFT JOIN niveles_superados 
               ON juegos.id = niveles_superados.juego_id AND niveles_superados.jugador_id = $jugador_id
               GROUP BY juegos.id";
$result_juegos = $conn->query($sql_juegos);

// Obtener tiempo total jugado
$sql_tiempo = "SELECT SUM(TIMESTAMPDIFF(SECOND, '00:00:00', ADDTIME('00:00:00', ADDTIME('00:00:00', '01:00:00')))) AS tiempo_total FROM niveles_superados WHERE jugador_id = $jugador_id";
$result_tiempo = $conn->query($sql_tiempo);
$tiempo_total_segundos = $result_tiempo->fetch_assoc()['tiempo_total'];
$tiempo_total_horas = round($tiempo_total_segundos / 3600, 2);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Reto Lógico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .stats {
            margin-top: 20px;
        }

        .stat {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        .stat h2 {
            margin: 0 0 10px 0;
            font-size: 1.5em;
        }

        .progress-bar {
            width: 100%;
            background-color: #ddd;
            border-radius: 10px;
            margin-top: 10px;
        }

        .progress-bar-fill {
            display: block;
            height: 20px;
            background-color: #4CAF50;
            border-radius: 10px;
        }

        .progress-details {
            text-align: left;
            margin-top: 10px;
        }

        .progress-details h3 {
            font-size: 1.2em;
            margin-bottom: 5px;
        }

        .progress-details .bar {
            height: 15px;
            background-color: #4CAF50;
            margin-bottom: 10px;
            border-radius: 10px;
        }

        .time-played {
            font-size: 1.2em;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Hola, <?php echo $nombre_completo; ?>!</h1>
    
    <div class="stats">
        <div class="stat">
            <h2>Progreso General</h2>
            <div class="progress-bar">
                <span class="progress-bar-fill" style="width: <?php echo $progreso_jugador_percent; ?>%;"></span>
            </div>
            <p><?php echo round($progreso_jugador_percent, 2); ?>% completado (<?php echo $progreso_jugador; ?> niveles)</p>
            <p><?php echo $total_niveles - $progreso_jugador; ?> niveles restantes</p>
        </div>

        <div class="stat">
            <h2>Tiempo Total Jugado</h2>
            <p class="time-played"><?php echo $tiempo_total_horas; ?> horas</p>
        </div>

        <div class="stat">
            <h2>Progreso por Juego</h2>
            <div class="progress-details">
                <?php while ($juego = $result_juegos->fetch_assoc()) { 
                    $progreso_juego_percent = ($juego['niveles_completados'] / $juego['niveles']) * 100;
                ?>
                    <h3><?php echo $juego['nombre']; ?></h3>
                    <div class="progress-bar">
                        <span class="progress-bar-fill" style="width: <?php echo $progreso_juego_percent; ?>%;"></span>
                    </div>
                    <p><?php echo round($progreso_juego_percent, 2); ?>% completado (<?php echo $juego['niveles_completados']; ?> de <?php echo $juego['niveles']; ?> niveles)</p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>
