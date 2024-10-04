<?php
require_once 'conexionVariosCampos.php';
class EliminarRegistros
{
    private $conexionDB;

    public function __construct()
    {
        $this->conexionDB = new Conexion();
    }

    public function eliminarDatos($id)
    {
        try {
            $stmt = $this->conexionDB->conect->prepare("DELETE FROM datosAprendiz WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            header("Location: listarVariosCampos.php?status=deleted");
            exit();
        } catch (PDOException $e) {
            echo "Error al eliminar información" . $e->getMessage();
        }
    }
}

if ($_GET['id']) {
    $id = $_GET['id'];

    $eliminarRegistro = new EliminarRegistros();
    $eliminarRegistro->eliminarDatos($id);
    header("Location: listarVariosCampos.php");
    exit();
}
