<?php
namespace App\Models;
use PDO;
use PDOException;

require_once MAIN_APP_ROUTE."../models/BaseModel.php";

class tipoServicioModel extends BaseModel {
    public function __construct(
        ?int $idTipoServicio = null,
        ?string $TipoServicio = null,
        ?int $FKidServicio = null
    ) {
        $this->table = "tiposervicio";
        parent::__construct();
    }

    public function saveTipoServicio($TipoServicio, $FKidServicio) {
        try {
            $sql = "INSERT INTO $this->table (TipoServicio, FKidServicio) VALUES (:tipo, :servicio)";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":tipo", $TipoServicio, PDO::PARAM_STR);
            $statement->bindParam(":servicio", $FKidServicio, PDO::PARAM_INT);
            return $statement->execute();
        } catch (PDOException $e) { 
            echo "No se pudo guardar el tipo de servicio: " . $e->getMessage();        }
    }

    public function getTipoServicio($id) {
        try {
            $sql = "SELECT t.*, s.Servicio as NombreServicio 
                    FROM $this->table t 
                    LEFT JOIN servicio s ON t.FKidServicio = s.idServicio 
                    WHERE t.idTipoServicio = :id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "Error al obtener tipo de servicio: " . $e->getMessage();
        }
    }

    public function getAll(): array {
        try {
            $sql = "SELECT t.*, s.Servicio as NombreServicio 
                    FROM $this->table t 
                    LEFT JOIN servicio s ON t.FKidServicio = s.idServicio";
            return $this->dbConnection->query($sql)->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            // throw lanza una excepcion cuando ocurre un error, osea si falla genera PDOException
            throw new PDOException("Error al obtener tipos de servicio: " . $e->getMessage());
        }
    }

    public function getByServicio($idServicio): array {
        try {
            $sql = "SELECT * FROM tiposervicio WHERE FKidServicio = :idServicio";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":idServicio", $idServicio, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            throw new PDOException("Error al obtener tipos de servicio: " . $e->getMessage());
        }
    }

    public function editTipoServicio($id, $TipoServicio, $FKidServicio) {
        try {
            $sql = "UPDATE $this->table 
                    SET TipoServicio = :tipo, FKidServicio = :servicio 
                    WHERE idTipoServicio = :id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->bindParam(":tipo", $TipoServicio, PDO::PARAM_STR);
            $statement->bindParam(":servicio", $FKidServicio, PDO::PARAM_INT);
            return $statement->execute();
        } catch (PDOException $ex) {
            echo "Error al editar tipo de servicio: " . $ex->getMessage();
        }
    }

    public function deleteTipoServicio($id) {
        try {
            $sql = "DELETE FROM $this->table WHERE idTipoServicio = :id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            return $statement->execute();
        } catch (PDOException $ex) {
            echo "Error al eliminar tipo de servicio: " . $ex->getMessage();
        }
    }
}