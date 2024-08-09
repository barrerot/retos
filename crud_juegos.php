<?php
session_start();
include 'config.php';

if (!isset($_SESSION['jugador_id']) || $_SESSION['tipo'] != 'administrador') {
    header("Location: login.php");
    exit();
}

$editMode = false;

// Lógica para actualizar un juego existente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_game'])) {
    $juego_id = $_POST['juego_id'];
    $nombre = $_POST['nombre'];
    $imagen = $_POST['imagen'];
    $niveles = $_POST['niveles'];

    $sql = "UPDATE juegos SET nombre='$nombre', imagen='$imagen', niveles='$niveles' WHERE id='$juego_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Juego actualizado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Lógica para insertar un nuevo juego
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_game'])) {
    $nombre = $_POST['nombre'];
    $imagen = $_POST['imagen'];
    $niveles = $_POST['niveles'];

    $sql = "INSERT INTO juegos (nombre, imagen, niveles) VALUES ('$nombre', '$imagen', '$niveles')";
    if ($conn->query($sql) === TRUE) {
        echo "Juego añadido exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Lógica para eliminar un juego
if (isset($_GET['delete'])) {
    $juego_id = $_GET['delete'];
    $sql = "DELETE FROM juegos WHERE id='$juego_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Juego eliminado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obtener los datos del juego para la edición
if (isset($_GET['edit'])) {
    $editMode = true;
    $juego_id = $_GET['edit'];
    $sql = "SELECT * FROM juegos WHERE id='$juego_id'";
    $result = $conn->query($sql);
    $juego = $result->fetch_assoc();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestionar Juegos</title>
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

        h2 {
            margin: 20px;
        }

        form {
            margin: 20px;
        }

        table {
            width: 100%;
            margin: 20px;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table img {
            max-width: 100%;
            height: auto;
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

            table, form {
                margin: 10px;
            }

            table th, table td {
                padding: 5px;
            }

            table img {
                width: 50px;
                height: 50px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Gestionar Juegos</h2>
        <div>
            <a href="logout.php">Cerrar Sesión</a>
        </div>
    </div>

    <form action="crud_juegos.php" method="post">
        <input type="hidden" name="<?php echo $editMode ? 'edit_game' : 'add_game'; ?>" value="1">
        <?php if ($editMode): ?>
            <input type="hidden" name="juego_id" value="<?php echo $juego['id']; ?>">
        <?php endif; ?>
        <label for="nombre">Nombre del Juego:</label><br>
        <input type="text" id="nombre" name="nombre" value="<?php echo $editMode ? $juego['nombre'] : ''; ?>" required><br>
        <label for="imagen">URL de la Imagen:</label><br>
        <input type="text" id="imagen" name="imagen" value="<?php echo $editMode ? $juego['imagen'] : ''; ?>" required><br>
        <label for="niveles">Número de Niveles:</label><br>
        <input type="number" id="niveles" name="niveles" value="<?php echo $editMode ? $juego['niveles'] : ''; ?>" required><br><br>
        <input type="submit" value="<?php echo $editMode ? 'Actualizar Juego' : 'Añadir Juego'; ?>">
    </form>

    <h2>Listado de Juegos</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Imagen</th>
            <th>Niveles</th>
            <th>Acciones</th>
        </tr>
        <?php
        $sql = "SELECT * FROM juegos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>".$row["id"]."</td>
                    <td>".$row["nombre"]."</td>
                    <td><img src='".$row["imagen"]."' alt='".$row["nombre"]."' style='width: 50px; height: 50px;'></td>
                    <td>".$row["niveles"]."</td>
                    <td>
                        <a href='crud_juegos.php?edit=".$row['id']."'>Editar</a> | 
                        <a href='crud_juegos.php?delete=".$row['id']."' onclick=\"return confirm('¿Estás seguro de que quieres eliminar este juego?');\">Eliminar</a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No hay juegos registrados</td></tr>";
        }
        ?>
    </table>
</body>
</html>
