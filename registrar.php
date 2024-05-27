<?php
// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si se han enviado los campos de usuario, contraseña y correo
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
        // Conexión a la base de datos (reemplaza los valores según tu configuración)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "registro";

        // Crea la conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Recibe los datos del formulario
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        // Prepara y ejecuta la consulta para insertar datos en la base de datos
        $sql = "INSERT INTO usuarios (username, password, email) VALUES ('$username', '$password', '$email')";
        if ($conn->query($sql) === TRUE) {
            echo "Registro exitoso";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Cierra la conexión
        $conn->close();
    } else {
        echo "Por favor, ingrese usuario, contraseña y correo.";
    }
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta</title>
    <link rel="stylesheet" href="stylerestri.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            background-color: #232121;
        }

        .box {
            width: 400px;
            height: 400px;
            padding: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            color: white;
            transform: translate(-50%,-50%);
            background: #191919;
            text-align: center;
            border-radius: 50%;
            box-shadow: 5px 5px 50px 50px rgba(252, 5, 5, 0.699);
            animation: animateBg 5s linear infinite;
        }

        @keyframes animateBg {
            100% {
                filter: hue-rotate(360deg);
            }
        }

        .box input {
            border: 0;
            display: block;
            background: none;
            margin: 0 auto 15px; /* Ajusta el margen inferior para los inputs */
            text-align: center;
            border: 3px solid #0399fd;
            padding: 14px 10px;
            width: 200px;
            outline: none;
            color: white;
            border-radius: 24px;
            transition: 0.25s;
        }

        .box input[type="text"]:focus,
        .box input[type="password"]:focus,
        .box input[type="email"]:focus {
            width: 280px;
            border-color: #04fb6b;
        }

        .box input[type="submit"],
        .box input[type="button"] {
            border: 0;
            display: block;
            background: none;
            margin: 5px auto;
            text-align: center;
            font-size: 100%;
            border: 3px solid #04fb6b;
            padding: 14px 40px;
            outline: none;
            color: white;
            border-radius: 24px;
            transition: 0.25s;
            cursor: pointer;
        }

        .box input[type="submit"]:hover,
        .box input[type="button"]:hover {
            background: #04fb6b;
        }
    </style>
</head>
<body>
    <div class="box">
        <h1>Crear cuenta</h1>
        <form class="register-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" id="username" name="username" placeholder="Usuario" required><br>
            <input type="password" id="password" name="password" placeholder="Contraseña" required><br>
            <input type="email" id="email" name="email" placeholder="Correo" required><br>
            <input type="submit" value="Registrar">
        </form>
        
    </div>
    <br>
    <a href="index.html" class="back-link">Volver a la página principal</a>
</body>
</html>

