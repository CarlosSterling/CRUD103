<?php
// Incluir el archivo de conexión a la base de datos
require_once 'conexion.php';

// Incluir las clases de CRUD (se podrían incluir desde archivos separados si prefieres)
class RegistroCRUD {
    private $conexionDB;

    public function __construct() {
        $this->conexionDB = new Conexion();
    }

    // Obtener todos los registros
    public function obtenerTodos() {
        try {
            $stmt = $this->conexionDB->conect->prepare("SELECT * FROM datos");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener los datos: " . $e->getMessage();
            return [];
        }
    }

    // Obtener un registro por ID
    public function obtenerPorId($id) {
        try {
            $stmt = $this->conexionDB->conect->prepare("SELECT * FROM datos WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener el registro: " . $e->getMessage();
        }
    }

    // Crear un nuevo registro
    public function crear($nombre) {
        try {
            $stmt = $this->conexionDB->conect->prepare("INSERT INTO datos (nombre) VALUES (:nombre)");
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al crear el registro: " . $e->getMessage();
        }
    }

    // Actualizar un registro
    public function actualizar($id, $nombre) {
        try {
            $stmt = $this->conexionDB->conect->prepare("UPDATE datos SET nombre = :nombre WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al actualizar el registro: " . $e->getMessage();
        }
    }

    // Eliminar un registro
    public function eliminar($id) {
        try {
            $stmt = $this->conexionDB->conect->prepare("DELETE FROM datos WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al eliminar el registro: " . $e->getMessage();
        }
    }
}

// Crear instancia de la clase CRUD
$crud = new RegistroCRUD();

// Control de acciones basado en la URL
$action = isset($_GET['action']) ? $_GET['action'] : 'read';

// Procesamiento del formulario de crear o actualizar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($action == 'create') {
        $nombre = $_POST['nombre'];
        $crud->crear($nombre);
        header('Location: index.php');
        exit();
    } elseif ($action == 'update') {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $crud->actualizar($id, $nombre);
        header('Location: index.php');
        exit();
    }
}

// Procesamiento de eliminación
if ($action == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $crud->eliminar($id);
    header('Location: index.php');
    exit();
}

// Obtener datos para leer o actualizar
if ($action == 'update' && isset($_GET['id'])) {
    $registro = $crud->obtenerPorId($_GET['id']);
} else {
    $registro = null;
}

$datos = $crud->obtenerTodos(); // Obtener todos los registros para mostrarlos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD en un solo archivo</title>
</head>
<body>
    <h1>CRUD en un solo archivo</h1>

    <!-- Formulario para crear o actualizar -->
    <?php if ($action == 'create' || $action == 'update'): ?>
        <form action="index.php?action=<?php echo $action ?>" method="post">
            <?php if ($action == 'update'): ?>
                <input type="hidden" name="id" value="<?php echo $registro['id']; ?>">
            <?php endif; ?>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $registro ? htmlspecialchars($registro['nombre']) : ''; ?>" required>
            <button type="submit"><?php echo $action == 'create' ? 'Crear' : 'Actualizar'; ?></button>
        </form>
    <?php else: ?>
        <a href="index.php?action=create">Crear nuevo registro</a>
    <?php endif; ?>

    <!-- Listado de registros -->
    <h2>Lista de registros</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos as $dato): ?>
                <tr>
                    <td><?php echo htmlspecialchars($dato['id']); ?></td>
                    <td><?php echo htmlspecialchars($dato['nombre']); ?></td>
                    <td>
                        <a href="index.php?action=update&id=<?php echo $dato['id']; ?>">Editar</a>
                        <a href="index.php?action=delete&id=<?php echo $dato['id']; ?>" onclick="return confirm('¿Está seguro de eliminar este registro?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
