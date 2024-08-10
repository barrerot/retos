<!DOCTYPE html>
<html>
<head>
    <title>Inicio - Aplicación de Juegos de Lógica</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f4f4f4;
        }

        .header {
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 100%;
            height: auto;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .message {
            margin-bottom: 15px;
            color: red;
            font-size: 14px;
            text-align: center;
        }

        .success {
            color: green;
        }

        /* Media Query para pantallas más pequeñas */
        @media (max-width: 600px) {
            .container {
                margin: 20px;
                padding: 15px;
            }

            h1, h2 {
                font-size: 1.5em;
            }

            label, input {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="banner.png" alt="Banner de Aplicación de Juegos de Lógica">
    </div>

    <div class="container">
        <h1>Bienvenido a la Aplicación de Juegos de Lógica</h1>

        <!-- Formulario de Inicio de Sesión -->
        <h2>Iniciar Sesión</h2>
        <?php if (isset($login_error)) echo "<p class='message'>$login_error</p>"; ?>
        <form action="index.php" method="post">
            <input type="hidden" name="login" value="1">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>
            <input type="submit" value="Iniciar Sesión">
        </form>

        <!-- Formulario de Registro -->
        <h2>Registrarse</h2>
        <?php if (isset($register_success)) echo "<p class='message success'>$register_success</p>"; ?>
        <?php if (isset($register_error)) echo "<p class='message'>$register_error</p>"; ?>
        <form action="index.php" method="post">
            <input type="hidden" name="register" value="1">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>
            <input type="submit" value="Registrarse">
        </form>
    </div>
</body>
</html>
