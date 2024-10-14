<?php

//incluir la conexion.
require_once 'conexion.php';

//crear la clase par agregar los valore
class CrearRegistro
{

    private $conexionDB;

    // Constructor de la clase
    public function __construct()
    {
        // Crear una instancia de la clase Conexion para manejar la base de datos
        $this->conexionDB = new Conexion();
    }
    // metodo para registrar los datos ($nombre hace referencia al campo en el que se va a ingresar la información) 
    public function registrarDatos($nombre)
    {
        //Validar que el nombre no esté vacío o sea nulo
        if (empty(trim($nombre))) {
            throw new Exception("El nombre no puede estar vacío.");
        }
        //boque Try
        try {
            $sql = ("INSERT INTO datos (nombre) VALUES (:nombre)");
            // Preparar la consulta SQL con un parámetro (:nombre) que se reemplazará luego
            $stmt = $this->conexionDB->conect->prepare($sql);
            // Asociar el parámetro :nombre con el valor pasado ($nombre)
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            // Ejecutar la consulta SQL
            $stmt->execute();
            // Redirigir al archivo 'read.php' para mostrar los datos registrados
            header("Location: read.php");
            // Finalizar la ejecución del script después de redirigir
            exit();

            //bloque catch    
        } catch (PDOException $error) {
            // Si ocurre algún error durante la ejecución, se captura y se muestra el mensaje de error
            throw new Exception("Error al ingresar los datos" . $error->getMessage());
        }
    }
}

// Verifica si se ha enviado un formulario a través de POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Asignar el valor del campo 'nombre' del formulario a la variable $nombre, limpiando posibles caracteres especiales
    $nombre = htmlspecialchars($_POST['nombre']);

    // Intentar crear una nueva instancia de CrearRegistro y registrar los datos
    try {
        $nuevoRegistro = new CrearRegistro();
        $nuevoRegistro->registrarDatos($nombre);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Registro</title>
</head>

<body>
    <h1>Crear registro</h1>
    <!-- Formulario para crear un registro -->
    <form action="create.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" placeholder="Ingrese el nombre" required>
        <button type="submit">Guardar</button>
    </form>

    <!-- Enlace para regresar a 'read.php', donde se mostrarán los registros -->
    <a href="read.php">Volver</a>
</body>

</html>