<?php
namespace App\Models;
use PDO;
use PDOException;

require_once MAIN_APP_ROUTE."../models/BaseModel.php";

class EstadoModel extends BaseModel{
    public function __construct(
        ?int $idEstado = null,
        ?string $Estado = null,
        ?string $Descripcion = null
    )
    {
        $this->table = "states";
        //Se llama al constructor del padre
        parent::__construct();
    }

    public function saveEstado($Estado, $Descripcion){
        try {
            $sql = "INSERT INTO $this->table (\"State\", \"Description\", \"color\", \"createdAt\", \"updatedAt\") 
                    VALUES (:Estado, :Descripcion, :color, NOW(), NOW())";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":Estado", $Estado, PDO::PARAM_STR);
            $statement->bindParam(":Descripcion", $Descripcion, PDO::PARAM_STR);
            $statement->bindParam(":color", $Color, PDO::PARAM_STR);
            $statement->execute();
        } catch (PDOException $ex) {
            echo "Error al guardar el estado: ".$ex->getMessage();
        }
    }

    public function getEstado($id){
        try {
            $sql = "SELECT * FROM $this->table WHERE id = :id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);
            return $result[0];
        } catch (PDOException $ex) {
            echo "Error al obtener estado: ".$ex->getMessage();
        }
    }

    public function editEstado($id, $Estado, $Descripcion, $Color){
        try {
            $sql = "UPDATE {$this->table} SET \"State\"=:Estado, \"Description\"=:Descripcion, color=:Color, \"updatedAt\"=NOW()
                    WHERE id=:id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->bindParam(":Estado", $Estado, PDO::PARAM_STR);
            $statement->bindParam(":Descripcion", $Descripcion, PDO::PARAM_STR);
            $statement->bindParam(":Color", $Color, PDO::PARAM_STR);
            $result = $statement->execute();
            return $result;
        } catch (PDOException $ex) {
            echo "No se pudo editar el estado: ".$ex->getMessage();
        }
    }

    public function deleteEstado($id){
        try {
            $sql = "DELETE FROM {$this->table} WHERE id=:id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();
            return $statement->execute();   
        } catch (PDOException $ex) {
            echo "No se pudo eliminar el estado: ".$ex->getMessage();
        }
    }
}
