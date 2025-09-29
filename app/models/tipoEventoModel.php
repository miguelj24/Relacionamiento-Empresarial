<?php
namespace App\Models;
use PDO;
use PDOException;

require_once MAIN_APP_ROUTE."../models/BaseModel.php";

class TipoEventoModel extends BaseModel {
    public function __construct(
        ?int $idTipoEvento = null,
        ?string $TipoEvento = null
    ) {
        $this->table = "tipoevento";
        parent::__construct();
    }

    public function getAll(): array {
        try {
            $sql = "SELECT * FROM $this->table";
            return $this->dbConnection->query($sql)->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            // throw lanza una excepcion cuando ocurre un error, osea si falla genera PDOException
            throw new PDOException("Error al obtener tipos de evento: " . $e->getMessage());
        }
    }

    public function saveTipoEvento($TipoEvento) {
        try {
            $sql = "INSERT INTO $this->table (TipoEvento) VALUES (:tipo)";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":tipo", $TipoEvento, PDO::PARAM_STR);
            return $statement->execute();
        } catch (PDOException $ex) {
            echo "Error al guardar el tipo de evento: " . $ex->getMessage();
        }
    }

    public function getTipoEvento($id) {
        try {
            $sql = "SELECT * FROM $this->table WHERE idTipoEvento = :id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo "Error al obtener tipo de evento: " . $ex->getMessage();
        }
    }

    public function editTipoEvento($id, $TipoEvento) {
        try {
            $sql = "UPDATE $this->table SET TipoEvento = :tipo WHERE idTipoEvento = :id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->bindParam(":tipo", $TipoEvento, PDO::PARAM_STR);
            return $statement->execute();
        } catch (PDOException $ex) {
            echo "Error al editar tipo de evento: " . $ex->getMessage();
        }
    }

    public function deleteTipoEvento($id) {
        try {
            $sql = "DELETE FROM $this->table WHERE idTipoEvento = :id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            return $statement->execute();
        } catch (PDOException $ex) {
            echo "Error al eliminar tipo de evento: " . $ex->getMessage();
        }
    }
}