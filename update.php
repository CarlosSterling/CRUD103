<?php
require_once 'conexion.php';

// Clase ActualizarRegistro que encapsula la lógica de gestión de registros
class ActualizarRegistro
{
    private $conexionDB;

    // Constructor para inicializar la conexión a la base de datos
    public function __construct()
    {
        $this->conexionDB = new Conexion();
    }

    // Método para obtener un registro por ID
    public function obtenerRegistroPorId($id)
    {
        try {
            $stmt = $this->conexionDB->conect->prepare("SELECT * FROM datos WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Redirigir en caso de error al obtener el registro
            header("Location: read.php?status=error&message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    // Método para actualizar un registro
    public function actualizarRegistros($id, $nombre)
    {
        try {
            $stmt = $this->conexionDB->conect->prepare("UPDATE datos SET nombre = :nombre WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->execute();

            // Verificar si se realizó alguna modificación
            if ($stmt->rowCount() > 0) {
                header("Location: read.php?status=updated");
            } else {
                header("Location: read.php?status=no_changes");
            }
            exit();
        } catch (PDOException $e) {
            // Redirigir en caso de error al actualizar
            header("Location: read.php?status=error&message=" . urlencode($e->getMessage()));
            exit();
        }
    }
}

// Procesar el formulario si se recibe por GET o POST
$nuevoRegistro = new ActualizarRegistro();

// Si se recibe un ID por GET, se obtiene el registro
if (isset($_GET['id']) && is_numeric($_GET['id']) && (int)$_GET['id'] > 0) {
    $id = (int)$_GET['id'];
    $nuevoDato = $nuevoRegistro->obtenerRegistroPorId($id);

    // Si el registro no existe, redirigir
    if (!$nuevoDato) {
        header("Location: read.php?status=notfound");
        exit();
    }
} else {
    // Si no se ha proporcionado un ID válido, redirigir a 'read.php'
    header("Location: read.php?status=invalid_id");
    exit();
}

// Si se envía un formulario por POST, se actualiza el registro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && is_numeric($_POST['id']) && (int)$_POST['id'] > 0) {
    $id = (int)$_POST['id'];
    $nombre = trim($_POST['nombre']);

    if (!empty($nombre)) {
        $nuevoRegistro->actualizarRegistros($id, $nombre);
    } else {
        // Redirigir si el nombre está vacío
        header("Location: update.php?id=$id&status=empty_name");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
</head>

<body>
    <h1>Editar Registro</h1>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($nuevoDato['id']); ?>">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" placeholder="Ingrese el nombre" value="<?php echo htmlspecialchars($nuevoDato['nombre']); ?>" required>
        <button type="submit">Actualizar</button>
    </form>
    <br>
    <a href="read.php">Volver</a>
</body>

</html>
