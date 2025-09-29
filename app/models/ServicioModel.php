<?php
namespace App\Models;
use PDO;
use PDOException;

require_once MAIN_APP_ROUTE."../models/BaseModel.php";

class ServicioModel extends BaseModel {
    public function __construct(
        ?int $idServicio = null,
        ?string $Servicio = null
    ) {
        $this->table = "servicio";
        parent::__construct();
    }

    public function getAll(): array {
        try {
            $sql = "SELECT * FROM $this->table"; // Asegúrate de que la tabla `servicio` existe y tiene datos
            return $this->dbConnection->query($sql)->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            throw new PDOException("Error al obtener servicios: " . $e->getMessage());
        }
    }

    public function saveServicio($Servicio, $Color) {
        try {
            $sql = "INSERT INTO $this->table (Servicio, Color) VALUES (:servicio, :color)";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":servicio", $Servicio, PDO::PARAM_STR);
            $statement->bindParam(":color", $Color, PDO::PARAM_STR);
            return $statement->execute();
        } catch (PDOException $ex) {
            echo "Error al guardar el servicio: " . $ex->getMessage();
        }
    }

    public function getServicio($id) {
        try {
            $sql = "SELECT * FROM $this->table WHERE idServicio = :id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo "Error al obtener servicio: " . $ex->getMessage();
        }
    }

    public function editServicio($id, $Servicio, $Color) {
        try {
            $sql = "UPDATE $this->table SET Servicio = :servicio, Color = :color WHERE idServicio = :id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->bindParam(":servicio", $Servicio, PDO::PARAM_STR);
            $statement->bindParam(":color", $Color, PDO::PARAM_STR);
            return $statement->execute();
        } catch (PDOException $ex) {
            echo "Error al editar servicio: " . $ex->getMessage();
        }
    }

    public function deleteServicio($id) {
        try {
            $sql = "DELETE FROM $this->table WHERE idServicio = :id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            return $statement->execute();
        } catch (PDOException $ex) {
            echo "Error al eliminar servicio: " . $ex->getMessage();
        }
    }
}