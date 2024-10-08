<?php
// Incluir archivo de conexión a la base de datos
require_once 'conexionVariosCampos.php';

// Clase para actualizar registros en la base de datos
class ActualizarRegistros
{
    // Propiedad privada para manejar la conexión a la base de datos
    private $conexionDB;

    // Constructor que se ejecuta al crear un objeto de esta clase y establece la conexión
    public function __construct()
    {
        $this->conexionDB = new Conexion();
    }

    // Método para obtener los datos de un registro específico por su ID
    public function obtenerDatos($id)
    {
        try {
            // Preparar la consulta SQL para seleccionar un registro por ID
            $stmt = $this->conexionDB->conect->prepare("SELECT * FROM datosAprendiz WHERE id = :id");
            // Enlazar el parámetro :id con el valor del ID recibido
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            // Ejecutar la consulta
            $stmt->execute();
            // Devolver el registro como un array asociativo
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Mostrar un mensaje de error si ocurre un problema al obtener los datos
            echo "Error al obtener información: " . $e->getMessage();
          // Devolver un array vacío en caso de errorsss
            return [];
        }
    }

    // Método para actualizar los datos de un registro
    public function actualizarDatos($datos)
    {
        try {
            // Preparar la consulta SQL para actualizar un registro por su ID
            $stmt = $this->conexionDB->conect->prepare("UPDATE datosAprendiz SET identificacion = :identificacion, nombre = :nombre, apellido = :apellido, programa = :programa, fechaingreso = :fechaingreso, fechasalida = :fechasalida WHERE id = :id");

            // Ejecutar la consulta y enlazar los datos con los marcadores
            $stmt->execute([
                ':identificacion' => $datos['identificacion'],
                ':nombre' => $datos['nombre'],
                ':apellido' => $datos['apellido'],
                ':programa' => $datos['programa'],
                ':fechaingreso' => $datos['fechaingreso'],
                ':fechasalida' => $datos['fechasalida'],
                ':id' => $datos['id']
            ]);

            // Redirigir a la página de listado si la actualización es exitosa
            header("Location: listarVariosCampos.php");
            exit();
        } catch (PDOException $e) {
            // Mostrar un mensaje de error si ocurre un problema al actualizar los datos
            echo "Error al actualizar datos: " . $e->getMessage();
        }
    }
}

// Verificar si se recibió un ID por la URL y es un valor numérico
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id']; // Convertir el ID a un valor entero
    // Crear una nueva instancia de la clase y obtener los datos del registro
    $actualizarDatos = new ActualizarRegistros();
    $mostrarRegistros = $actualizarDatos->obtenerDatos($id);
}

// Verificar si el formulario ha sido enviado con el método POST y contiene un ID
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Recopilar los datos enviados en el formulario
    $datos = [
        'id' => $_POST['id'],
        'identificacion' => $_POST['identificacion'],
        'nombre' => $_POST['nombre'],
        'apellido' => $_POST['apellido'],
        'programa' => $_POST['programa'],
        'fechaingreso' => $_POST['fechaingreso'],
        'fechasalida' => $_POST['fechasalida']
    ];

    // Crear una nueva instancia de la clase y llamar al método para actualizar los datos
    $actualizarDatos = new ActualizarRegistros();
    $actualizarDatos->actualizarDatos($datos);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Registros</title>
    <!-- Enlace a la hoja de estilos CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Actualizar Registros</h1>

    <!-- Verificar si los datos del registro se obtuvieron correctamente -->
    <?php if (isset($mostrarRegistros) && !empty($mostrarRegistros)): ?>
        <!-- Formulario para actualizar el registro -->
        <form action="actualizarVariosCampos.php?id=<?php echo htmlspecialchars($mostrarRegistros['id']); ?>" method="post">
            <!-- Campo oculto para mantener el ID del registro -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($mostrarRegistros['id']); ?>">
            
            <!-- Campos de entrada para cada atributo del registro -->
            <label for="identificacion">Identificación</label>
            <input type="text" name="identificacion" value="<?php echo htmlspecialchars($mostrarRegistros['identificacion']); ?>" placeholder="Ingrese su identificación" required> <br>
            
            <label for="nombre">Nombre(s)</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($mostrarRegistros['nombre']); ?>" placeholder="Ingrese su(s) nombre(s)" required> <br>
            
            <label for="apellido">Apellido(s)</label>
            <input type="text" name="apellido" value="<?php echo htmlspecialchars($mostrarRegistros['apellido']); ?>" placeholder="Ingrese su(s) apellido(s)" required> <br>
            
            <label for="programa">Programa</label>
            <input type="text" name="programa" value="<?php echo htmlspecialchars($mostrarRegistros['programa']); ?>" placeholder="Ingrese el programa al cual se encuentra vinculado" required> <br>
            
            <label for="fechaingreso">Fecha de ingreso</label>
            <input type="date" name="fechaingreso" value="<?php echo htmlspecialchars($mostrarRegistros['fechaingreso']); ?>" required> <br>
            
            <label for="fechasalida">Fecha de fin</label>
            <input type="date" name="fechasalida" value="<?php echo htmlspecialchars($mostrarRegistros['fechasalida']); ?>" required> <br>
            
            <!-- Botón para enviar el formulario -->
            <button type="submit">Actualizar</button>
        </form>
    <?php else: ?>
        <!-- Mostrar mensaje si no se encontró un registro con el ID especificado -->
        <p>No hay registros para actualizar</p>
    <?php endif; ?>
    
    <br>
    <!-- Enlace para volver a la lista de registros -->
    <a href="listarVariosCampos.php">Volver a la lista</a>
</body>

</html>
