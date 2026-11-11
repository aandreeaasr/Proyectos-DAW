<?php
// Me conecto al servidor MySQL como root (o administrador) para poder crear la base de datos y los usuarios
$servidor = "localhost";
$usuario_root = "root";
$password_root = ""; // Modifica esto si tu gestor de base de datos requiere contraseña en root
$puerto = 3307; // El puerto configurado en tu conexión

$conexion = new mysqli($servidor, $usuario_root, $password_root, "", $puerto);

// Compruebo si hay error de conexión inicial
if ($conexion->connect_error) {
    die("Error de conexión con el servidor MySQL: " . $conexion->connect_error);
}

// Configuro el juego de caracteres a UTF-8
$conexion->set_charset("utf8mb4");

// 1. Creo la base de datos Inmobiliaria si no existe
$sql_db = "CREATE DATABASE IF NOT EXISTS Inmobiliaria CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if ($conexion->query($sql_db) === TRUE) {
    echo "<p>Base de datos 'Inmobiliaria' creada correctamente (o ya existía).</p>";
} else {
    die("Error al crear la base de datos: " . $conexion->error);
}

// Selecciono la base de datos recién creada
$conexion->select_db("Inmobiliaria");

// 2. Creo la tabla 'inmuebles' con los campos mínimos exigidos
$sql_tabla = "CREATE TABLE IF NOT EXISTS inmuebles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    localidad VARCHAR(100) NOT NULL,
    provincia VARCHAR(100) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    tipo_inmueble VARCHAR(50) NOT NULL,
    metros_cuadrados INT NOT NULL,
    num_dormitorios INT NOT NULL,
    num_banos INT NOT NULL,
    precio_venta DECIMAL(10,2) NOT NULL,
    foto VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conexion->query($sql_tabla) === TRUE) {
    echo "<p>Tabla 'inmuebles' creada correctamente.</p>";
} else {
    die("Error al crear la tabla: " . $conexion->error);
}

// 3. Inserto al menos 10 registros iniciales de prueba
$resultado_check = $conexion->query("SELECT COUNT(*) as total FROM inmuebles");
$fila_check = $resultado_check->fetch_assoc();

if ($fila_check['total'] == 0) {
    $sql_datos = "INSERT INTO inmuebles (localidad, provincia, direccion, tipo_inmueble, metros_cuadrados, num_dormitorios, num_banos, precio_venta, foto) VALUES 
    ('Madrid', 'Madrid', 'Calle Gran Vía 28', 'Piso', 95, 3, 2, 350000.00, 'piso1.jpg'),
    ('Barcelona', 'Barcelona', 'Passeig de Gràcia 45', 'Piso', 120, 4, 2, 480000.00, 'piso2.jpg'),
    ('Valencia', 'Valencia', 'Avenida del Puerto 12', 'Piso', 85, 2, 1, 185000.00, 'piso3.jpg'),
    ('Sevilla', 'Sevilla', 'Calle Sierpes 14', 'Casa', 150, 4, 3, 290000.00, 'casa1.jpg'),
    ('Málaga', 'Málaga', 'Calle Larios 5', 'Piso', 90, 2, 2, 260000.00, 'piso4.jpg'),
    ('Zaragoza', 'Zaragoza', 'Paseo Independencia 8', 'Ático', 110, 3, 2, 240000.00, 'atico1.jpg'),
    ('Bilbao', 'Bilbao', 'Gran Vía 20', 'Piso', 100, 3, 2, 310000.00, 'piso5.jpg'),
    ('Granada', 'Granada', 'Calle Recogidas 15', 'Piso', 80, 2, 1, 150000.00, 'piso6.jpg'),
    ('Alicante', 'Alicante', 'Explanada de España 3', 'Adosado', 140, 3, 2, 220000.00, 'adosado1.jpg'),
    ('Valencia', 'Valencia', 'Calle Colón 22', 'Piso', 95, 3, 2, 210000.00, 'piso7.jpg');";

    if ($conexion->query($sql_datos) === TRUE) {
        echo "<p>Se han insertado los 10 registros iniciales correctamente.</p>";
    } else {
        echo "<p>Error al insertar los registros: " . $conexion->error . "</p>";
    }
} else {
    echo "<p>Los registros iniciales ya existían previamente en la base de datos.</p>";
}

// 4. Creación de usuarios y control de privilegios (admin y usuario)
$conexion->query("CREATE USER IF NOT EXISTS 'admin'@'localhost' IDENTIFIED BY 'admin'");
$conexion->query("GRANT ALL PRIVILEGES ON Inmobiliaria.* TO 'admin'@'localhost'");

$conexion->query("CREATE USER IF NOT EXISTS 'usuario'@'localhost' IDENTIFIED BY 'usuario'");
$conexion->query("GRANT SELECT ON Inmobiliaria.* TO 'usuario'@'localhost'");

$conexion->query("FLUSH PRIVILEGES");
echo "<p>Usuarios 'admin' y 'usuario' configurados correctamente.</p>";

echo "<br><hr><a href='index.php'><strong>Ir al menú principal de la aplicación</strong></a>";

$conexion->close();
?>