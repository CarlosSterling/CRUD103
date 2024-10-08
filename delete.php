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
    public function eliminarregistro($id)
    {
        try {
            // Preparar la consulta SQL para eliminar un registro por ID
            $stmt = $this->conexionDB->conect->prepare("DELETE * FROM datos WHERE id = :id");
            // Enlazar el parámetro :id con el valor del ID recibido
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
             // Ejecutar la consulta
            $stmt->execute();
            // Redirigir a la página de listado con un parámetro de estado
            header("Location: read.php?status=deleted");
            exit();
        } catch (PDOException $e) {
             // Mostrar un mensaje de error si ocurre un problema al eliminar el registro
            echo "Error al eliminar los datos" . $e->getMessage();
        }
    }
}
// Verificar si se recibió un ID por la URL y es un valor numérico
if (isset($_GET['id'])&& is_numeric($_GET['id'])){
    // Capturar el ID del registro a eliminar
    $id = $_GET['id'];
// Crear una nueva instancia de la clase EliminarRegistros y llamar al método eliminarDatos
    $eliminarRegistro = new EliminarRegistros();
    $eliminarRegistro->eliminarDatos($id);
}
