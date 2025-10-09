<?php
namespace App\Models;

use PDO;
use PDOException;

abstract class BaseModel {
    protected $dbConnection;
    protected $table;

    public function __construct() {
        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ];
          $dsn = DRIVER . ':host=' . HOST . ';port=' . PORT . ';dbname=' . DATABASE . ';sslmode=require;options=\'--client_encoding=UTF8\'';
            $this->dbConnection = new PDO($dsn, USERNAME_DB, PASSWORD_DB, $options);
        } catch (PDOException $ex) {
            echo 'Error en la conexión: '.$ex->getMessage();
            exit;
        }
    }

    public function getAll(): array {
        try {
            $sql = 'SELECT * FROM '.$this->table;
            $statement = $this->dbConnection->query($sql);
            return $statement->fetchAll();
        } catch (PDOException $ex) {
            echo 'Error al obtener registros: '.$ex->getMessage();
            return [];
        }
    }

    public function getById(int $id) {
        try {
           $sql = 'SELECT * FROM '.$this->table.' WHERE id = :id';
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch();
        } catch (PDOException $ex) {
            echo 'Error al obtener el registro: '.$ex->getMessage();
            return null;
        }
    }

    public function save(array $data): bool {
        try {
            $columns = implode(', ', array_keys($data));
            $placeholders = ':'.implode(', :', array_keys($data));
            $sql = 'INSERT INTO '.$this->table.' ('.$columns.') VALUES ('.$placeholders.')';
            $statement = $this->dbConnection->prepare($sql);
            return $statement->execute($data);
        } catch (PDOException $ex) {
            echo 'Error al guardar el registro: '.$ex->getMessage();
            return false;
        }
    }

    public function update(int $id, array $data): bool {
        try {
            $fields = '';
            foreach ($data as $key => $value) {
                $fields .= $key.' = :'.$key.', ';
            }
            $fields = rtrim($fields, ', ');
            $sql = 'UPDATE ' . $this->table . ' SET ' . $fields . ' WHERE id = :id';
            $statement = $this->dbConnection->prepare($sql);
            $data['id'] = $id;
            return $statement->execute($data);
        } catch (PDOException $ex) {
            echo 'Error al actualizar el registro: '.$ex->getMessage();
            return false;
        }
    }
        //delete
    public function delete(int $id): bool {
        try {
           $sql = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            return $statement->execute();
        } catch (PDOException $ex) {
            echo 'Error al eliminar el registro: '.$ex->getMessage();
            return false;
        }
    }
}
