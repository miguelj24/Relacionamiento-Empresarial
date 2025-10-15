<?php

namespace App\Models;

use PDO;
use PDOException;

require_once MAIN_APP_ROUTE . "../models/BaseModel.php";

class UsuarioModel extends BaseModel
{
    public function __construct(
        ?int $idUsuario = null,
        ?string $DocumentoUsuario = null,
        ?string $NombreUsuario = null,
        ?string $CorreoUsuario = null,
        ?string $TelefonoUsuario = null,
        ?string $ContraseñaUsuario = null,
        ?int $FKidRol = null,
        ?bool $Coordinador = false
    ) {
        $this->table = "users";
        parent::__construct();
    }



    public function saveUsuario($DocumentoUsuario, $NombreUsuario, $CorreoUsuario, $TelefonoUsuario, $ContraseñaUsuario, $FKidRol, $Coordinador = false)
    {
        try {
             $hashedPassword = password_hash($ContraseñaUsuario, PASSWORD_BCRYPT, ['cost' => 10]);
             $hashedPassword = str_replace('$2y$', '$2b$', $hashedPassword);

            $sql = 'INSERT INTO "users" ("documentUser", "nameUser", "emailUser", "telephoneUser", "passwordUser", "FKroles", "coordinator", "createdAt", "updatedAt")
            VALUES (:doc, :nombre, :correo, :telefono, :pass, :rol, :coordinador, NOW(), NOW())';

            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(':doc', $DocumentoUsuario);
            $statement->bindParam(':nombre', $NombreUsuario);
            $statement->bindParam(':correo', $CorreoUsuario);
            $statement->bindParam(':telefono', $TelefonoUsuario);
            $statement->bindParam(':pass', $hashedPassword);
            $statement->bindParam(':rol', $FKidRol);
            $statement->bindParam(':coordinador', $Coordinador, PDO::PARAM_BOOL);

            return $statement->execute();
        } catch (PDOException $ex) {
            error_log("Error al guardar el usuario: " . $ex->getMessage());
            return false;
        }
    }


    public function getUsuario($id)
    {
        try {
            $sql = 'SELECT u."id", u."documentUser", u."nameUser", u."emailUser", u."telephoneUser", u."passwordUser", u."FKroles", u."coordinator", u."createdAt", u."updatedAt",r."Role" AS "NombreRol"
                FROM "' . $this->table . '" u
                LEFT JOIN "roles" r ON u."FKroles" = r."id"
                WHERE u."id" = :id';


            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo "Error al obtener usuario: " . $ex->getMessage();
        }
    }

    public function editUsuario($id, $DocumentoUsuario, $NombreUsuario, $CorreoUsuario, $TelefonoUsuario, $FKidRol, $ContrasenaUsuario = null,  $Coordinador = false)
    {
        try {
            $actualizarContrasena = ($ContrasenaUsuario !== null && !empty(trim($ContrasenaUsuario)));
            
            if ($actualizarContrasena) {
                $sql = 'UPDATE "' . $this->table . '" 
                        SET "documentUser" = :DocumentoUsuario, 
                            "nameUser" = :NombreUsuario, 
                            "emailUser" = :CorreoUsuario, 
                            "telephoneUser" = :TelefonoUsuario, 
                            "passwordUser" = :ContrasenaUsuario, 
                            "FKroles" = :FKidRol,
                            "coordinator" = :Coordinador,
                            "updatedAt" = NOW()
                        WHERE "id" = :id';

            } else {
                $sql = 'UPDATE "' . $this->table . '" 
                        SET "documentUser" = :DocumentoUsuario, 
                            "nameUser" = :NombreUsuario, 
                            "emailUser" = :CorreoUsuario, 
                            "telephoneUser" = :TelefonoUsuario,
                            "FKroles" = :FKidRol,
                            "coordinator" = :Coordinador,
                            "updatedAt" = NOW()
                        WHERE "id" = :id';
            }

            $statement = $this->dbConnection->prepare($sql);
            
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->bindParam(":DocumentoUsuario", $DocumentoUsuario);
            $statement->bindParam(":NombreUsuario", $NombreUsuario);
            $statement->bindParam(":CorreoUsuario", $CorreoUsuario);
            $statement->bindParam(":TelefonoUsuario", $TelefonoUsuario);
            $statement->bindParam(":FKidRol", $FKidRol);
            $statement->bindParam(":Coordinador", $Coordinador, PDO::PARAM_BOOL);

            if ($actualizarContrasena) {
                $hashedPassword = password_hash($ContrasenaUsuario, PASSWORD_BCRYPT, ['cost' => 10]);
                $hashedPassword = str_replace('$2y$', '$2b$', $hashedPassword);
                $statement->bindParam(":ContrasenaUsuario", $hashedPassword);
            }

            return $statement->execute();
        } catch (PDOException $ex) {
            error_log("Error al editar usuario: " . $ex->getMessage());
            return false;
        }
    }


    public function deleteUsuario($id)
    {
        try {
            $sql = "DELETE FROM $this->table WHERE id = :id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            return $statement->execute();
        } catch (PDOException $ex) {
            echo "Error al eliminar usuario: " . $ex->getMessage();
        }
    }
    public function validarLogin($CorreoUsuario, $ContraseñaUsuario)
{
    try {
        // Preparar la consulta usando nombres exactos de columnas y tabla
        $sql = 'SELECT * FROM "users" WHERE "emailUser" = :CorreoUsuario';
        $statement = $this->dbConnection->prepare($sql);
        $statement->bindParam(":CorreoUsuario", $CorreoUsuario, PDO::PARAM_STR);
        $statement->execute();

        // Obtener el resultado
        $usuario = $statement->fetch(PDO::FETCH_OBJ);

        if ($usuario) {
            $hash = $usuario->passwordUser; // usar el nombre correcto de la columna
            if (password_verify($ContraseñaUsuario, $hash)) {
                // Contraseña correcta, inicializar sesión
                $_SESSION["idUsuario"] = $usuario->id;
                $_SESSION["nombre"] = $usuario->nameUser;
                $_SESSION["documento"] = $usuario->documentUser;
                $_SESSION["telefono"] = $usuario->telephoneUser;
                $_SESSION["correo"] = $usuario->emailUser;
                $_SESSION["rol"] = $usuario->FKroles;
                $_SESSION["timeOut"] = time();
                session_regenerate_id();
                return $usuario;
            }
        }

        return false; // Si no encuentra usuario o contraseña incorrecta
    } catch (PDOException $ex) {
        error_log("Error en validarLogin: " . $ex->getMessage());
        return false;
    }
}


    public function countUsuarios()
    {
        try {
            $sql = "SELECT COUNT(*) AS total_usuarios FROM $this->table";
            $statement = $this->dbConnection->prepare($sql);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return $row['total_usuarios'];
        } catch (PDOException $ex) {
            echo "Error al contar usuarios: " . $ex->getMessage();
        }
    }
}
