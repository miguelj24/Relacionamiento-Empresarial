<?php
namespace App\Models;
use PDO;
use PDOException;

require_once MAIN_APP_ROUTE."../models/BaseModel.php";

class ClienteModel extends BaseModel{
    public function __construct(
        ?int $idCliente = null,
        ?string $DocumentoCliente = null,
        ?string $NombreCliente = null,
        ?string $CorreoCliente = null,
        ?string $TelefonoCliente = null
    )
    {
        $this->table = "cliente";
        //Se llama a el contructor de el padre
        parent::__construct();
    }

    public function saveCliente($documento, $nombre, $correo, $telefono) {
        try {
            $sql = "INSERT INTO cliente (DocumentoCliente, NombreCliente, CorreoCliente, TelefonoCliente) 
                    VALUES (:documento, :nombre, :correo, :telefono)";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":documento", $documento, PDO::PARAM_STR);
            $statement->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $statement->bindParam(":correo", $correo, PDO::PARAM_STR);
            $statement->bindParam(":telefono", $telefono, PDO::PARAM_STR);
            $statement->execute();
            return $this->dbConnection->lastInsertId();
        } catch (PDOException $e) {
            throw new PDOException("Error al guardar cliente: " . $e->getMessage());
        }
    }

    public function saveClienteByName($nombre) {
        try {
            $sql = "INSERT INTO cliente (NombreCliente) VALUES (:nombre)";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $statement->execute();
            return $this->dbConnection->lastInsertId();
        } catch (PDOException $e) {
            throw new PDOException("Error al guardar cliente: " . $e->getMessage());
        }
    }

    public function getCliente($id){
        try {
            $sql = "SELECT * FROM $this->table WHERE idCliente = :id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);
            return $result[0];
        } catch (PDOException $ex) {
            echo "Error al obtener cliente: ".$ex->getMessage();
        }
    }

    public function getClienteByDocumento($documento) {
        try {
            $sql = "SELECT * FROM cliente WHERE DocumentoCliente = :documento LIMIT 1";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":documento", $documento, PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            throw new PDOException("Error al buscar cliente: " . $e->getMessage());
        }
    }

    public function getClienteByName($nombre) {
        try {
            $sql = "SELECT * FROM cliente WHERE NombreCliente = :nombre LIMIT 1";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            throw new PDOException("Error al buscar cliente por nombre: " . $e->getMessage());
        }
    }

    public function editCliente($id, $DocumentoCliente, $NombreCliente, $CorreoCliente, $TelefonoCliente){
        try {
            $sql = "UPDATE {$this->table} SET DocumentoCliente=:DocumentoCliente, NombreCliente=:NombreCliente, CorreoCliente=:CorreoCliente, TelefonoCliente=:TelefonoCliente WHERE idCliente=:id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->bindParam(":DocumentoCliente", $DocumentoCliente, PDO::PARAM_STR);
            $statement->bindParam(":NombreCliente", $NombreCliente, PDO::PARAM_STR);
            $statement->bindParam(":CorreoCliente", $CorreoCliente, PDO::PARAM_STR);
            $statement->bindParam(":TelefonoCliente", $TelefonoCliente, PDO::PARAM_STR);
            $result = $statement->execute();
            return $result;
        } catch (PDOException $ex) {
            echo "No se pudo editar el cliente";
        }
    }

    public function deleteCliente($id){
        try {
            $sql = "DELETE FROM {$this->table} WHERE idCliente=:id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();
        } catch (PDOException $ex) {
            echo "No se pudo eliminar el cliente";
        }
    }
}