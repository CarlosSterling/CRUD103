<?php
// Incluir archivo de conexión a la base de datos
require_once 'conexion.php';
// Clase para eliminar registros de la base de datos
class EliminarRegistros
{
    // Propiedad privada para manejar la conexión a la base de datos
    private $conexionDB;
    // Constructor que se ejecuta al crear un objeto de esta clase y establece la conexión
    public function __construct()
    {
        $this->conexionDB = new Conexion();
    }
    // Método para eliminar un registro específico por su ID
    public function eliminarRegistroId($id)
    {
        try {
            $sql = ("DELETE FROM datos WHERE id = :id");
            // Preparar la consulta SQL para eliminar un registro por ID
            $stmt = $this->conexionDB->conect->prepare($sql);
            // Enlazar el parámetro :id con el valor del ID recibido
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            // Ejecutar la consulta
            $stmt->execute();

            // Verificar si se eliminó algún registro
            if ($stmt->rowCount() > 0) {
                // Redirigir a la página de listado con un estado de éxito
                header("Location: read.php?status=deleted");
            } else {
                // Redirigir con un estado de error si no se encontró el ID
                header("Location: read.php?status=notfound");
            }
            exit();
        } catch (PDOException $e) {
            // Mostrar un mensaje de error si ocurre un problema al eliminar el registro
            echo "Error al eliminar los datos" . $e->getMessage();
        }
    }
}
// Verificar si se recibió un ID válido por la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])&& (int)$_GET['id'] > 0) {
    // Capturar el ID del registro a eliminar
    $id = (int)$_GET['id'];

    // Crear una nueva instancia de la clase EliminarRegistros y llamar al método eliminarRegistroId
    $eliminarRegistros = new EliminarRegistros();
    $eliminarRegistros->eliminarRegistroId($id);
} else {
    // Redirigir a la página de listado con un estado de error si el ID no es válido
    header("Location: read.php?status=invalid_id");
    exit();
}