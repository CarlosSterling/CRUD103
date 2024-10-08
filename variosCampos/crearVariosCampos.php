<?php
require_once 'conexionVariosCampos.php';

class CrearRegistro
{
    // Propiedad privada para la conexión a la base de datos
    private $conexionDB;

    // Constructor que inicializa la conexión
    public function __construct()
    {
        $this->conexionDB = new Conexion();
    }

    // Método para insertar datos en la base de datos
    public function insertarDatos($datos)
    {
        try {
            // Preparar la consulta SQL usando marcadores de parámetros
            $stmt = $this->conexionDB->conect->prepare(
                "INSERT INTO datosAprendiz 
                (identificacion, nombre, apellido, programa, fechaingreso, fechasalida) VALUES (:identificacion, :nombre, :apellido, :programa, :fechaingreso, :fechasalida)"
            );
            // Ejecutar la consulta y enlazar los datos con los marcadores
            $stmt->execute([
                ':identificacion' => $datos['identificacion'],
                ':nombre' => $datos['nombre'],
                ':apellido' => $datos['apellido'],
                ':programa' => $datos['programa'],
                ':fechaingreso' => $datos['fechaingreso'],
                ':fechasalida' => $datos['fechasalida'],
            ]);
            // Redirigir a la página de listado si la inserción es exitosa
            header("Location: listarVariosCampos.php");
            exit();
        } catch (PDOException $error) {
            // Capturar y mostrar errores de la base de datos
            echo "Error al insertar datos: " . $error->getMessage();
        }
    }
}

// Verificar si el formulario ha sido enviado con todos los campos requeridos
if (isset($_POST['identificacion'], $_POST['nombre'], $_POST['apellido'], $_POST['programa'], $_POST['fechaingreso'], $_POST['fechasalida'])) {
    // Limpiar los datos recibidos con htmlspecialchars
    $datosPersonales = [
        'identificacion' => htmlspecialchars($_POST['identificacion']),
        'nombre' => htmlspecialchars($_POST['nombre']),
        'apellido' => htmlspecialchars($_POST['apellido']),
        'programa' => htmlspecialchars($_POST['programa']),
        'fechaingreso' => htmlspecialchars($_POST['fechaingreso']),
        'fechasalida' => htmlspecialchars($_POST['fechasalida'])
    ];

    // Crear una nueva instancia de CrearRegistro y llamar al método insertarDatos
    $nuevoUsuario = new CrearRegistro();
    $nuevoUsuario->insertarDatos($datosPersonales);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear usuario</title>
    <!-- Incluye tu hoja de estilos CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Crear nuevos usuarios</h1>
    <!-- Formulario para recolectar los datos del usuario -->
    <form action="crearVariosCampos.php" method="post">
        <label for="identificacion">Identificación</label>
        <input type="text" name="identificacion" placeholder="Ingrese su identificación" required><br>

        <label for="nombre">Nombre(s)</label>
        <input type="text" name="nombre" placeholder="Ingrese su nombre" required><br>

        <label for="apellido">Apellido(s)</label>
        <input type="text" name="apellido" placeholder="Ingrese su apellido" required><br>

        <label for="programa">Programa</label>
        <input type="text" name="programa" placeholder="Ingrese el programa" required><br>

        <label for="fechaingreso">Fecha de ingreso al programa:</label>
        <input type="date" name="fechaingreso" placeholder="Ingrese la fecha de inicio" required><br>

        <label for="fechasalida">Fecha de salida al programa:</label>
        <input type="date" name="fechasalida" placeholder="Ingrese la fecha de salida" required><br>

        <button type="submit">Guardar</button><br>
        <!-- Enlace para ver los registros guardados -->
        <a href="listarVariosCampos.php">Ver Registros</a>
    </form>
</body>

</html>