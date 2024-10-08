<?php
// Incluir el archivo de conexión a la base de datos
require_once 'conexionVariosCampos.php';

// Clase para listar registros desde la base de datos
class ListarRegistros
{
    // Propiedad privada para manejar la conexión a la base de datos
    private $conexionDB;

    // Constructor que se ejecuta al crear un objeto de esta clase y establece la conexión
    public function __construct()
    {
        $this->conexionDB = new Conexion();
    }

    // Método para obtener todos los registros de la tabla 'datosAprendiz'
    public function obtenerDatos()
    {
        try {
            // Preparar la consulta SQL para seleccionar todos los registros de la tabla
            $stmt = $this->conexionDB->conect->prepare("SELECT * FROM datosAprendiz");

            // Ejecutar la consulta
            $stmt->execute();

            // Devolver todos los registros como un array asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Mostrar un mensaje de error si ocurre un problema al obtener los datos
            echo "Error al obtener la información: " . $e->getMessage();

            // Devolver un array vacío en caso de error
            return [];
        }
    }
}

// Crear una nueva instancia de la clase ListarRegistros
$nuevoRegistros = new ListarRegistros();

// Llamar al método obtenerDatos para obtener todos los registros de la base de datos
$mostrarRegistros = $nuevoRegistros->obtenerDatos();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Registros</title>
    <!-- Incluye el archivo CSS para los estilos -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Registros Creados</h1>

    <!-- Enlace para redirigir a la página de creación de un nuevo registro -->
    <a href="crearVariosCampos.php">Crear un nuevo registro</a><br><br>

    <!-- Tabla para mostrar todos los registros obtenidos de la base de datos -->
    <table border="1">
        <tr>
            <!-- Encabezados de la tabla -->
            <th>Id</th>
            <th>Identificación</th>
            <th>Nombre(s)</th>
            <th>Apellido(s)</th>
            <th>Programa</th>
            <th>Fecha de Ingreso</th>
            <th>Fecha de Salida</th>
            <th>Acción</th>
        </tr>

        <!-- Verificar si hay registros para mostrar -->
        <?php if (!empty($mostrarRegistros)): ?>
            <!-- Si hay registros, iterar sobre cada uno y mostrarlos en una fila de la tabla -->
            <?php foreach ($mostrarRegistros as $registro): ?>
                <tr>
                    <!-- Mostrar cada columna de datos del registro, escapando el contenido con htmlspecialchars para evitar XSS -->
                    <td><?php echo htmlspecialchars($registro['id']); ?></td>
                    <td><?php echo htmlspecialchars($registro['identificacion']); ?></td>
                    <td><?php echo htmlspecialchars($registro['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($registro['apellido']); ?></td>
                    <td><?php echo htmlspecialchars($registro['programa']); ?></td>
                    <td><?php echo htmlspecialchars($registro['fechaingreso']); ?></td>
                    <td><?php echo htmlspecialchars($registro['fechasalida']); ?></td>
                    <td>
                        <!-- Enlaces para actualizar o eliminar el registro -->
                        <a href="actualizarVariosCampos.php?id=<?php echo $registro['id']; ?>">Actualizar</a>
                        <a href="eliminarVariosCampos.php?id=<?php echo $registro['id']; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Si no hay registros, mostrar un mensaje en la tabla -->
            <tr>
                <td colspan="8">No se encontraron registros.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>

</html>