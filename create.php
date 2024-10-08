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
        //boque Try
        try {
            // Preparar la consulta SQL con un parámetro (:nombre) que se reemplazará luego
            $stmt = $this->conexionDB->conect->prepare("INSERT INTO datos (nombre) VALUES (:nombre)");
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
            echo "Error al ingresar los datos" . $error->getMessage();
        }
    }
}

// Verifica si se ha enviado un formulario a través de POST
if ($_POST) {
    // Asigna el valor del campo 'nombre' del formulario a la variable $nombre
    $nombre = $_POST['nombre'];
    // Crea una instancia de la clase 'CrearRegistro'
    $nuevoRegistro = new CrearRegistro();
    // Llama al método 'registrarDatos' para insertar el nombre en la base de datos
    $nuevoRegistro->registrarDatos($nombre);
}
?>
<!DOCTYPE html>
<html lang="en">

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