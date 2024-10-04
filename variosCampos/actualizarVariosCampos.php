<?php
require_once 'conexionVariosCampos.php';
class ActualizarRegistros
{

    private $conexionDB;

    public function __construct()
    {
        $this->conexionDB = new Conexion();
    }

    public function obtenerDatos()
    {
        try {
            $stmt = $this->conexionDB->conect->prepare("SELECT * FROM datosAprendiz WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al actualizar información" . $e->getMessage();
        }
    }

    public function actualizarDatos()
    {
        try {
            $stmt = $this->conexionDB->conect->prepare("UPDATE datosAprendiz SET identificacion = :identificacion");
        } catch (PDOException $e) {
            echo "Error al actualizar datos:" . $e->getMessage();
        }
    }
}
