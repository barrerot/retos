<?php
session_start();
include 'config.php';

if (!isset($_SESSION['jugador_id']) || $_SESSION['tipo'] != 'jugador') {
    header("Location: login.php");
    exit();
}

$jugador_id = $_SESSION['jugador_id'];
$juego_id = $_GET['juego_id'];

// Obtener información del juego
$sql = "SELECT * FROM juegos WHERE id='$juego_id'";
$result = $conn->query($sql);
$juego = $result->fetch_assoc();

// Obtener información del jugador
$sql_jugador = "SELECT * FROM jugadores WHERE id='$jugador_id'";
$result_jugador = $conn->query($sql_jugador);
$jugador = $result_jugador->fetch_assoc();

// Lógica para actualizar el estado de los niveles
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nivel'])) {
    $nivel = $_POST['nivel'];

    // Verificar si el nivel ya está marcado como completado
    $sql_check = "SELECT * FROM niveles_superados WHERE jugador_id='$jugador_id' AND juego_id='$juego_id' AND nivel='$nivel'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        // Si está completado, eliminar el registro (marcar como pendiente)
        $sql = "DELETE FROM niveles_superados WHERE jugador_id='$jugador_id' AND juego_id='$juego_id' AND nivel='$nivel'";
    } else {
        // Si no está completado, insertarlo (marcar como completado)
        $sql = "INSERT INTO niveles_superados (jugador_id, juego_id, nivel, fecha_superado) 
                VALUES ('$jugador_id', '$juego_id', '$nivel', CURDATE())";
    }

    if ($conn->query($sql) === TRUE) {
        // Redirigir para evitar resubir el formulario al recargar
        header("Location: juego.php?juego_id=$juego_id");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obtener niveles superados por el jugador para este juego
$sql = "SELECT nivel FROM niveles_superados WHERE jugador_id='$jugador_id' AND juego_id='$juego_id'";
$result = $conn->query($sql);
$niveles_superados = [];
while ($row = $result->fetch_assoc()) {
    $niveles_superados[] = $row['nivel'];
}

// Función para generar un saludo basado en la hora del día
function generarSaludo($nombre, $apellido) {
    $hora = date('H');

    if ($hora < 12) {
        return "Buenos días, $nombre $apellido";
    } elseif ($hora < 18) {
        return "Buenas tardes, $nombre $apellido";
    } else {
        return "Buenas noches, $nombre $apellido";
    }
}

$saludo = generarSaludo($jugador['nombre'], $jugador['apellido']);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $juego['nombre']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #ddd;
        }

        .header a {
            margin-left: 15px;
        }

        .game-title {
            display: flex;
            align-items: center;
        }

        .game-title img {
            width: 50px;
            height: 50px;
            margin-left: 10px;
        }

        h2 {
            margin: 20px;
        }

        .game-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px;
        }

        .game-buttons form {
            margin: 5px;
        }

        .game-buttons button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        /* Media Query para pantallas más pequeñas */
        @media (max-width: 600px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .header a {
                margin-left: 0;
                margin-top: 5px;
            }

            .game-title {
                flex-direction: column;
                align-items: flex-start;
            }

            .game-title img {
                margin-left: 0;
                margin-top: 10px;
                width: 30px;
                height: 30px;
            }

            .game-buttons button {
                width: 100%;
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="game-title">
            <h2><?php echo $juego['nombre']; ?></h2>
            <img src="<?php echo $juego['imagen']; ?>" alt="<?php echo $juego['nombre']; ?>">
        </div>
        <div>
            <span class="saludo"><?php echo $saludo; ?></span>
            <a href="logout.php">Cerrar Sesión</a> |
            <a href="seleccion_juego.php">Cambiar de Juego</a>
        </div>
    </div>

    <div class="game-buttons">
        <?php for ($i = 1; $i <= $juego['niveles']; $i++): ?>
            <form action="juego.php?juego_id=<?php echo $juego_id; ?>" method="post">
                <input type="hidden" name="nivel" value="<?php echo $i; ?>">
                <button type="submit" <?php echo in_array($i, $niveles_superados) ? 'style="background-color: green;"' : ''; ?>>
                    Nivel <?php echo $i; ?> <?php echo in_array($i, $niveles_superados) ? '✔️' : '❌'; ?>
                </button>
            </form>
        <?php endfor; ?>
    </div>
</body>
</html>
