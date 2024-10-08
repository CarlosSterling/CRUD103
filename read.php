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
              // Preparar la consulta SQL para obtener todos los registros de la tabla 'datos'
            $stmt = $this->conexionDB->conect->prepare("SELECT * FROM datos");
            // Ejecutar la consulta
            $stmt->execute();
            // Retornar todos los resultados en un formato asociativo
            return $stmt->fetchAll(pdo::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Si ocurre algún error durante la ejecución de la consulta, mostrar el mensaje de error
            echo "Error al obtener los datos: " . $e->getMessage();
        }
    }
}
// Crear una instancia de la clase 'ListarRegistros'
$mostrarDAtos = new ListarRegistros();
// Llamar al método 'obtenerDatos' y almacenar los resultados en la variable $datosPersonales
$datosPersonales = $mostrarDAtos->obtenerDatos();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Registros</title>
</head>

<body>
    <h1>Resgistros</h1>
    <!-- Tabla para mostrar los registros obtenidos -->
    <table border 1>
        <!-- Enlace para crear un nuevo registro -->
        <a href="create.php">Crear un nuevo registro</a>
        <tr>
             <!-- Encabezados de la tabla -->
            <th>Id</th>
            <th>Nombre</th>
        </tr>
          <!-- Verificar si hay registros disponibles -->
        <?php if (!empty($datosPersonales)): ?>
             <!-- Recorrer cada registro disponible en $datosPersonales -->
            <?php foreach ($datosPersonales as $datosPersonalesCliente): ?>
                <tr>
                    <!-- Mostrar el 'id' del registro de forma segura usando htmlspecialchars -->
                    <td><?php echo htmlspecialchars($datosPersonalesCliente['id']); ?></td>
                    <!-- Mostrar el 'nombre' del registro de forma segura usando htmlspecialchars -->
                    <td><?php echo htmlspecialchars($datosPersonalesCliente['nombre']); ?></td>
                    <td>
                        <!-- Opciones para editar o eliminar el registro -->
                        <a href="update.php">Editar</a>
                        <a href="delete.php">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
             <!-- Si no hay registros disponibles, mostrar un mensaje -->
        <?php else: ?>
            <tr>
                <td colspan="2">No hay registros disponibles.</td>
            </tr>
        <?php endif; ?>
    </table>

</body>

</html>