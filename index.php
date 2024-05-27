<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Productos</title>
    <link rel="stylesheet" href="stylephp.css">
</head>
<body>
    <?php
    // Mostrar errores en PHP
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Configuración de conexión
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "for";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Verificar si se envió el formulario para agregar producto
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
        // Recoger datos del formulario
        $presupuesto = $_POST['presupuesto'];
        $unidad = $_POST['unidad'];
        $producto = $_POST['producto'];
        $cantidad = $_POST['cantidad'];
        $valor_unitario = $_POST['valor_unitario'];
        $valor_total = $_POST['valor_total'];
        $fecha_adquisicion = $_POST['fecha_adquisicion'];
        $proveedor = $_POST['proveedor'];

        // Crear consulta SQL para insertar nuevo producto
        $sql = "INSERT INTO `formulario_bd`(`presupuesto`, `unidad`, `producto`, `cantidad`, `valor_unitario`, `valor_total`, `fecha_adquisicion`, `proveedor`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparar y ejecutar la consulta
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("dssiddss", $presupuesto, $unidad, $producto, $cantidad, $valor_unitario, $valor_total, $fecha_adquisicion, $proveedor);
            if ($stmt->execute()) {
                echo "Nuevo producto agregado correctamente";
            } else {
                echo "Error al ejecutar la consulta: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error al preparar la consulta: " . $conn->error;
        }
    }

    // Verificar si se envió el formulario para eliminar producto
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
        // Recoger el ID del producto a eliminar
        $id = $_POST['id'];

        // Crear consulta SQL para eliminar producto
        $sql = "DELETE FROM `formulario_bd` WHERE id = ?";

        // Preparar y ejecutar la consulta
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                echo "Producto eliminado correctamente";
            } else {
                echo "Error al ejecutar la consulta: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error al preparar la consulta: " . $conn->error;
        }
    }

    // Consultar todos los productos
    $sql = "SELECT * FROM `formulario_bd`";
    $result = $conn->query($sql);
    ?>

    <div class="container">
        <div class="form-content">
            <h2>Agregar Nuevo Producto</h2>
            <form id="product-form" action="" method="POST">
                <input type="hidden" name="action" value="add">
                <label for="presupuesto">Presupuesto:</label>
                <input type="number" id="presupuesto" name="presupuesto" required>
                
                <label for="unidad">Unidad:</label>
                <input type="text" id="unidad" name="unidad" required>
                
                <label for="producto">Producto:</label>
                <input type="text" id="producto" name="producto" required>
                
                <label for="cantidad">Cantidad:</label>
                <input type="number" id="cantidad" name="cantidad" required>
                
                <label for="valor_unitario">Valor Unitario:</label>
                <input type="number" id="valor_unitario" name="valor_unitario" required>
                
                <label for="valor_total">Valor Total:</label>
                <input type="number" id="valor_total" name="valor_total" required>
                
                <label for="fecha_adquisicion">Fecha de Adquisición:</label>
                <input type="date" id="fecha_adquisicion" name="fecha_adquisicion" required>
                
                <label for="proveedor">Proveedor:</label>
                <input type="text" id="proveedor" name="proveedor" required>
                
                <button type="submit" class="btn">Agregar Producto</button>
            </form>
            <br>
            <a href="index.html">Volver a la página principal</a>
        </div>

        <div class="table-container">
            <?php
            // Mostrar tabla con los productos
            if ($result->num_rows > 0) {
                echo "<h2>Productos Agregados</h2>";
                echo "<table>";
                echo "<tr><th>ID</th><th>Presupuesto</th><th>Unidad</th><th>Producto</th><th>Cantidad</th><th>Valor Unitario</th><th>Valor Total</th><th>Fecha Adquisición</th><th>Proveedor</th><th>Acciones</th></tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>".$row["id"]."</td><td>".$row["presupuesto"]."</td><td>".$row["unidad"]."</td><td>".$row["producto"]."</td><td>".$row["cantidad"]."</td><td>".$row["valor_unitario"]."</td><td>".$row["valor_total"]."</td><td>".$row["fecha_adquisicion"]."</td><td>".$row["proveedor"]."</td>";
                    echo "<td><form action='' method='POST' style='display:inline-block;'><input type='hidden' name='action' value='delete'><input type='hidden' name='id' value='".$row["id"]."'><button type='submit' class='btn'>Eliminar</button></form></td></tr>";
                }
                echo "</table>";
            } else {
                echo "No hay productos agregados.";
            }

            // Cerrar la conexión después de todas las consultas
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
