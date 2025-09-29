<?php
namespace App\Models;
use PDO;
use PDOException;

require_once MAIN_APP_ROUTE."../models/BaseModel.php";

class RolModel extends BaseModel {
    public function __construct(
        ?int $idRol = null,
        ?string $Rol = null
    ) {
        $this->table = "rol";
        parent::__construct();
    }

    public function saveRol($Rol) {
        try {
            $sql = "INSERT INTO $this->table (Rol) VALUES (:Rol)";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":Rol", $Rol, PDO::PARAM_STR);
            $statement->execute();
        } catch (PDOException $ex) {
            echo "Error al guardar el rol: " . $ex->getMessage();
        }
    }

    public function getRol($id) {
        try {
            $sql = "SELECT * FROM $this->table WHERE idRol = :id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);
            return $result[0];
        } catch (PDOException $ex) {
            echo "Error al obtener rol: " . $ex->getMessage();
        }
    }

    public function editRol($id, $Rol) {
        try {
            $sql = "UPDATE {$this->table} SET Rol=:Rol WHERE idRol=:id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->bindParam(":Rol", $Rol, PDO::PARAM_STR);
            return $statement->execute();
        } catch (PDOException $ex) {
            echo "No se pudo editar el rol: " . $ex->getMessage();
        }
    }

    public function deleteRol($id){
        try {
            $sql = "DELETE FROM {$this->table} WHERE idRol=:id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();
        } catch (PDOException $ex) {
            echo "No se pudo eliminar el rol";
        }
    }
}