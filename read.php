<?php
// Incluir el archivo que contiene la clase de conexión a la base de datos.
require_once 'conexion.php';

class ListarRegistros
{
    // Propiedad para manejar la conexión a la base de datos
    private $conexionDB;

    public function __construct()
    {
        // Crear una instancia de la clase 'Conexion' para manejar la base de datos
        $this->conexionDB = new Conexion();
    }

    // Método para obtener todos los datos de la tabla 'datos'
    public function obtenerDatos()
    {
        try {
            $sql =("SELECT * FROM datos");
            // Preparar la consulta SQL para obtener todos los registros de la tabla 'datos'
            $stmt = $this->conexionDB->conect->prepare($sql);
            // Ejecutar la consulta
            $stmt->execute();
            // Retornar todos los resultados en un formato asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Si ocurre algún error durante la ejecución de la consulta, mostrar el mensaje de error
            echo "Error al obtener los datos: " . $e->getMessage();
            return [];
        }
    }
}

// Crear una instancia de la clase 'ListarRegistros'
$mostrarDatos = new ListarRegistros();
// Llamar al método 'obtenerDatos' y almacenar los resultados en la variable $datosPersonales
$datosPersonales = $mostrarDatos->obtenerDatos();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Registros</title>
</head>

<body>
    <h1>Registros</h1>

    <!-- Enlace para crear un nuevo registro -->
    <a href="create.php">Crear un nuevo registro</a>

    <!-- Tabla para mostrar los registros obtenidos -->
    <table border="1">
        <tr>
            <!-- Encabezados de la tabla -->
            <th>Id</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>

        <?php if (!empty($datosPersonales)): ?>
            <!-- Recorrer cada registro disponible en $datosPersonales -->
            <?php foreach ($datosPersonales as $datos): ?>
                <tr>
                    <!-- Mostrar el 'id' del registro de forma segura usando htmlspecialchars -->
                    <td><?php echo htmlspecialchars($datos['id']); ?></td>
                    <td><?php echo htmlspecialchars($datos['nombre']); ?></td>
                    <td>
                        <!-- Opciones para editar o eliminar el registro -->
                        <a href="update.php?id=<?php echo $datos['id']; ?>">Editar</a>
                        <a href="delete.php?id=<?php echo $datos['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este registro?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Mostrar un mensaje cuando no haya registros disponibles -->
            <tr>
                <td colspan="3">No hay registros disponibles.</td>
            </tr>
        <?php endif; ?>

    </table>

</body>

</html>