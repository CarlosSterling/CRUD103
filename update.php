<?php
// Incluir el archivo que contiene la clase de conexión a la base de datos
require_once 'conexion.php';
// Clase para actualizar los registros en la base de datos
class ActualizarRegistros
{
    // Propiedad para manejar la conexión a la base de datos
    private $conexionDB;
    // Constructor de la clase que inicializa la conexión
    public function __construct()
    {
        // Crear una instancia de la clase 'Conexion' para conectarse a la base de datos
        $this->conexionDB = new Conexion();
    }

    // Método para obtener un registro específico por su ID
    public function obtenerRegistro($id)
    {

        // Preparar la consulta SQL para seleccionar un registro por su ID
        $stmt = $this->conexionDB->conect->prepare("SELECT * FROM datos WHERE id = :id");
        // Asociar el valor de la variable $id con el parámetro :id de la consulta
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        // Ejecutar la consulta
        $stmt->execute();
        // Retornar el resultado de la consulta como un arreglo asociativo
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para actualizar un registro en la base de datos
    public function actualizarDatos($id, $nombre)
    {

        // Preparar la consulta SQL para actualizar el campo 'nombre' de un registro específico
        $stmt = $this->conexionDB->conect->prepare("UPDATE datos SET nombre = :nombre WHERE id = :id");
        // Asociar los valores de $id y $nombre con los parámetros :id y :nombre de la consulta
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        // Ejecutar la consulta para actualizar el registro
        $stmt->execute();
        // Redirigir al archivo 'read.php' para mostrar los registros actualizados

    }
}

// Crear una instancia de la clase 'ActualizarRegistro'
$actualizarRegistro = new ActualizarRegistros();
// Verificar si se ha pasado un ID a través del método GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Obtener el registro con el ID proporcionado
    $registro = $actualizarRegistro->obtenerRegistro($id);

    // Si se envía el formulario a través de POST, procesar la actualización
    if ($_POST) {
        // Obtener el valor del nombre del formulario
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        // Llamar al método 'actualizarDatos' para actualizar el registro en la base de datos
        $registro->actualizarDatos($id, $nombre);
        header("Location: read.php");
        exit();
    }
} else {
    // Si no se ha proporcionado un ID, redirigir a 'read.php'
    header("Location: read.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Registro</title>
    <link rel="stylesheet" href="style.css">

<body>
    <h1>Editar Registro</h1>
    <form method="POST" action="update.php">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($registro['id'], ENT_QUOTES); ?>">
        <label for="nombre"><strong>Nombre:</strong></label>
        <input type="text" name="nombre" placeholder="Ingrese el nombre" value="<?php echo $registro['nombre']; ?>" required>
        <button type="submit" class="btn">Actualizar</button>
    </form>
    <br>
    <a href="read.php" class="btn">Volver</a>
</body>

</html>