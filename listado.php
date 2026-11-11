<?php

// Me conecto a la base de datos usando el archivo de conexión
require_once "conexion.php";

// Preparo una orden SQL para seleccionar todos los inmuebles de la tabla
$sql = "SELECT * FROM inmuebles";
$resultado = $conexion->query($sql);

// Si ocurre un error al hacer la consulta, detengo la página y muestro el fallo
if (!$resultado){
    die("Error al consultar los inmuebles: " . $conexion->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de inmuebles</title>
    <!-- Enlazo la hoja de estilos para darle diseño a la página -->
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    
    <!-- Cabecera de la página -->
    <header>
        <h1>Inmobiliaria S.L.</h1>
        <p>Listado de inmuebles en venta</p>
    </header>

    <main>
        <h2>Inmuebles disponibles</h2>

        <?php
        // Compruebo si hay inmuebles guardados (si hay más de 0 filas)
        if($resultado->num_rows > 0){
        ?>
        <!-- Dibujo la tabla donde se van a mostrar los datos -->
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Localidad</th>
                    <th>Provincia</th>
                    <th>Dirección</th>
                    <th>Tipo</th>
                    <th>Metros cuadrados</th>
                    <th>Dormitorios</th>
                    <th>Baños</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Voy recorriendo cada inmueble uno a uno con un bucle
                while($inmueble = $resultado->fetch_assoc()){
                ?>
                    <tr>
                        <!-- Muestro cada dato del inmueble protegiéndolo con htmlspecialchars -->
                        <td><?php echo htmlspecialchars($inmueble['id']); ?></td> 
                        <td><?php echo htmlspecialchars($inmueble['localidad']); ?></td> 
                        <td><?php echo htmlspecialchars($inmueble['provincia']); ?></td> 
                        <td><?php echo htmlspecialchars($inmueble['direccion']); ?></td> 
                        <td><?php echo htmlspecialchars($inmueble['tipo_inmueble']); ?></td> 
                        <td><?php echo htmlspecialchars($inmueble['metros_cuadrados']); ?></td> 
                        <td><?php echo htmlspecialchars($inmueble['num_dormitorios']); ?></td> 
                        <td><?php echo htmlspecialchars($inmueble['num_banos']); ?></td> 
                        <td><?php echo htmlspecialchars($inmueble['precio_venta']); ?></td> 
                    </tr>
                <?php
                } // Aquí termina el bucle que lee los inmuebles
                ?>
            </tbody>
        </table>
        <?php
        } else {
            // Si la tabla está vacía, muestro este mensaje alternativo
        ?>
            <p>No hay inmuebles disponibles en este momento.</p>
        <?php
        }
        ?>

        <br>
        <!-- Enlace para volver a la página principal -->
        <a href="index.php">Volver al menú principal</a>
    </main>
    
</body>
</html>