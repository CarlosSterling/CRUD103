<?php

class Conexion
{
    private $servidor = "localhost";
    private $usuario = "root";
    private $contrasenia = "";
    private $baseDatos = "CRUD103";
    public $conect;

    public function __construct()
    {
        try {

            $conexion = "mysql:host=" . $this->servidor . ";dbname=" . $this->baseDatos . ";charset =utf8";
            $this->conect = new PDO($conexion, $this->usuario, $this->contrasenia);
            $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Conexion exitosa";
        } catch (PDOException $error) {
            echo "No se logró la conexion con la base de datos: " . $error->getMessage();
        }
    }
}

//$conexionDB = new Conexion();

