<?php
// Me conecto a la base de datos usando el archivo de conexión
require_once "conexion.php";

// Compruebo si se ha enviado el formulario mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recojo y limito los datos enviados desde el formulario de inserción
    $localidad = trim($_POST['localidad']);
    $provincia = trim($_POST['provincia']);
    $direccion = trim($_POST['direccion']);
    $tipo_inmueble = trim($_POST['tipo_inmueble']);
    $metros_cuadrados = (int)$_POST['metros_cuadrados'];
    $num_dormitorios = (int)$_POST['num_dormitorios'];
    $num_banos = (int)$_POST['num_banos'];
    $precio_venta = (float)$_POST['precio_venta'];

    // Preparo la consulta SQL para insertar el nuevo inmueble de forma segura
    $sql = "INSERT INTO inmuebles (localidad, provincia, direccion, tipo_inmueble, metros_cuadrados, num_dormitorios, num_banos, precio_venta) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conexion->prepare($sql);
    
    if ($stmt) {
        // Asocio los parámetros a la consulta
        $stmt->bind_param("ssssiiid", $localidad, $provincia, $direccion, $tipo_inmueble, $metros_cuadrados, $num_dormitorios, $num_banos, $precio_venta);
        
        // Ejecuto la consulta e informo al usuario del resultado
        if ($stmt->execute()) {
            $mensaje = "¡Inmueble insertado correctamente!";
        } else {
            $mensaje = "Error al insertar el inmueble: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $mensaje = "Error en la preparación de la consulta: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Inmueble</title>
    <!-- Enlazo la hoja de estilos común -->
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    
    <!-- Cabecera de la página -->
    <header>
        <h1>Inmobiliaria S.L.</h1>
        <p>Registro de un nuevo inmueble</p>
    </header>

    <main>
        <h2>Formulario de Inserción</h2>

        <?php 
        // Si existe un mensaje de éxito o error, lo muestro en pantalla
        if (isset($mensaje)) {
            echo "<p><strong>$mensaje</strong></p>";
        } 
        ?>

        <!-- Formulario para introducir los datos del nuevo inmueble -->
        <form action="Inserta.php" method="POST">
            <label for="localidad">Localidad:</label><br>
            <input type="text" id="localidad" name="localidad" required><br><br>

            <label for="provincia">Provincia:</label><br>
            <input type="text" id="provincia" name="provincia" required><br><br>

            <label for="direccion">Dirección:</label><br>
            <input type="text" id="direccion" name="direccion" required><br><br>

            <label for="tipo_inmueble">Tipo de inmueble:</label><br>
            <input type="text" id="tipo_inmueble" name="tipo_inmueble" required><br><br>

            <label for="metros_cuadrados">Metros cuadrados:</label><br>
            <input type="number" id="metros_cuadrados" name="metros_cuadrados" required><br><br>

            <label for="num_dormitorios">Número de dormitorios:</label><br>
            <input type="number" id="num_dormitorios" name="num_dormitorios" required><br><br>

            <label for="num_banos">Número de baños:</label><br>
            <input type="number" id="num_banos" name="num_banos" required><br><br>

            <label for="precio_venta">Precio de venta (€):</label><br>
            <input type="number" step="0.01" id="precio_venta" name="precio_venta" required><br><br>

            <button type="submit">Guardar Inmueble</button>
        </form>

        <br>
        <!-- Enlace para volver al menú principal -->
        <a href="index.php">Volver al menú principal</a>
    </main>
    
</body>
</html>