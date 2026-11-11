<?php
// Me conecto a la base de datos usando el archivo de conexión
require_once "conexion.php";

// Compruebo si se ha enviado el formulario mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recojo y convierto a número entero el ID del inmueble que quiero borrar
    $id = (int)$_POST['id'];

    // Preparo la consulta SQL para eliminar el registro de forma segura usando un marcador ?
    $sql = "DELETE FROM inmuebles WHERE id = ?";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        // Asocio el parámetro ID como un número entero ("i")
        $stmt->bind_param("i", $id);
        
        // Ejecuto la consulta e informo del resultado
        if ($stmt->execute()) {
            $mensaje = "¡Inmueble borrado correctamente!";
        } else {
            $mensaje = "Error al borrar el inmueble: " . $stmt->error;
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
    <title>Borrar Inmueble</title>
    <!-- Enlazo la hoja de estilos común -->
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    
    <!-- Cabecera de la página -->
    <header>
        <h1>Inmobiliaria S.L.</h1>
        <p>Eliminar un inmueble del sistema</p>
    </header>

    <main>
        <h2>Formulario de Borrado</h2>

        <?php 
        // Si existe un mensaje de éxito o error, lo muestro en pantalla
        if (isset($mensaje)) {
            echo "<p><strong>$mensaje</strong></p>";
        } 
        ?>

        <!-- Formulario para introducir el ID del inmueble que se desea eliminar -->
        <form action="Borrar.php" method="POST">
            <label for="id">Introduce el ID del inmueble a borrar:</label><br>
            <input type="number" id="id" name="id" required><br><br>

            <!-- Añado una pequeña confirmación en JavaScript para evitar borrados accidentales -->
            <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este inmueble?');">Borrar Inmueble</button>
        </form>

        <br>
        <!-- Enlace para volver al menú principal -->
        <a href="index.php">Volver al menú principal</a>
    </main>
    
</body>
</html>