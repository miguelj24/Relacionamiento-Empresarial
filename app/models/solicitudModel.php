<?php

namespace App\Models;

use PDO;
use PDOException;

require_once MAIN_APP_ROUTE . "../models/BaseModel.php";

class SolicitudModel extends BaseModel
{
    public function __construct(
        ?int $idSolicitud = null,
        ?string $Descripcion = null,
        ?string $FechaSolicitud = null,
        ?int $IdCliente = null,
        ?int $IdServicio = null,
        ?int $IdEstado = null
    ) {
        $this->table = "requests";
        parent::__construct();
    }

    public function getAll(): array
    {
        try {
            $sql = 'SELECT s.*, c."NameClient", sv."service", sv."color" AS "service_color", e."State", e."color" AS "state_color"
                FROM "requests" s
                JOIN "clients" c ON s."FKclients" = c."id"
                JOIN "servicetypes" ts ON s."FKservicetypes" = ts."id"
                JOIN "services" sv ON ts."FKservices" = sv."id"
                JOIN "states" e ON s."FKstates" = e."id"
                WHERE s."archive_status" = 0';
        ; // Solo NO archivadas
            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            throw new PDOException("Error al obtener solicitudes: " . $e->getMessage());
        }
    }

    public function saveSolicitud($Descripcion, $FechaSolicitud, $IdCliente, $IdServicio, $IdEstado, $IdUsuario, $Lugar, $Municipio)
    {
        try {
           $sql = 'INSERT INTO "requests" ("needDescription", "eventDate", "createdAt", "FKclients", "FKservicetypes", "FKstates", "FKeventtypes", "FKusers", "requestMethod", "location", "municipality", "updatedAt") 
                   VALUES (:Descripcion, :FechaSolicitud, NOW(), :IdCliente, :IdServicio, :IdEstado, 1, :IdUsuario, \'Web\', :Lugar, :Municipio, NOW())';
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":Descripcion", $Descripcion, PDO::PARAM_STR);
            $statement->bindParam(":FechaSolicitud", $FechaSolicitud, PDO::PARAM_STR);
            $statement->bindParam(":IdCliente", $IdCliente, PDO::PARAM_INT);
            $statement->bindParam(":IdServicio", $IdServicio, PDO::PARAM_INT);
            $statement->bindParam(":IdEstado", $IdEstado, PDO::PARAM_INT);
            $statement->bindParam(":IdUsuario", $IdUsuario, PDO::PARAM_INT);
            $statement->bindParam(":Lugar", $Lugar, PDO::PARAM_STR);
            $statement->bindParam(":Municipio", $Municipio, PDO::PARAM_STR);
            return $statement->execute();
        } catch (PDOException $ex) {
            throw new PDOException("Error al guardar la solicitud: " . $ex->getMessage());
        }
    }

   public function getSolicitud($id)
{
    try {
        $sql = 'SELECT s.*, 
            c."id" AS "IdCliente",
            c."NameClient", 
            c."EmailClient", 
            c."TelephoneClient",
            c."DocumentClient",
            ts."serviceType", 
            ts."FKservices" AS "Fkservice",
            sv."service", 
            e."State", 
            e."Description" AS "EstadoDescripcion", 
            u."nameUser" AS "UsuarioCreador",
            ua."nameUser" AS "UsuarioAsignado"
        FROM "' . $this->table . '" s
        JOIN "clients" c ON s."FKclients" = c."id"
        JOIN "servicetypes" ts ON s."FKservicetypes" = ts."id"
        JOIN "services" sv ON ts."FKservices" = sv."id"
        JOIN "states" e ON s."FKstates" = e."id"
        JOIN "users" u ON s."FKusers" = u."id"
        LEFT JOIN "users" ua ON s."assignment" = ua."id"::text
        WHERE s.id = :id';

        $statement = $this->dbConnection->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_OBJ);

        if (!$result) {
            throw new PDOException("No se encontró la solicitud con id = $id");
        }

        return $result;

    } catch (PDOException $ex) {
        throw new PDOException("Error al obtener la solicitud: " . $ex->getMessage());
    }
}






    public function editSolicitud($id, $Descripcion, $FechaSolicitud, $IdCliente, $IdTipoServicio, $IdEstado, $Lugar, $Municipio, $Comentarios, $Observaciones, $Asignacion = null)
    {
        try {
            $sql = 'UPDATE "' . $this->table . '" 
                    SET "needDescription" = :Descripcion, 
                        "eventDate" = :FechaSolicitud, 
                        "FKclients" = :IdCliente, 
                        "FKservicetypes" = :IdTipoServicio, 
                        "FKstates" = :IdEstado,
                        "location" = :Lugar,
                        "municipality" = :Municipio,
                        "comments" = :Comentarios,
                        "observations" = :Observaciones';
            if ($Asignacion !== null) {
                $sql .= ', "assignment" = :Asignacion';
            }
            $sql .= ' WHERE "id" = :id';

            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->bindParam(":Descripcion", $Descripcion, PDO::PARAM_STR);
            $statement->bindParam(":FechaSolicitud", $FechaSolicitud, PDO::PARAM_STR);
            $statement->bindParam(":IdCliente", $IdCliente, PDO::PARAM_INT);
            $statement->bindParam(":IdTipoServicio", $IdTipoServicio, PDO::PARAM_INT);
            $statement->bindParam(":IdEstado", $IdEstado, PDO::PARAM_INT);
            $statement->bindParam(":Lugar", $Lugar, PDO::PARAM_STR);
            $statement->bindParam(":Municipio", $Municipio, PDO::PARAM_STR);
            $statement->bindParam(":Comentarios", $Comentarios, PDO::PARAM_STR);
            $statement->bindParam(":Observaciones", $Observaciones, PDO::PARAM_STR);
            if ($Asignacion !== null) {
                $statement->bindParam(":Asignacion", $Asignacion, PDO::PARAM_INT);
            }
            return $statement->execute();
        } catch (PDOException $ex) {
            throw new PDOException("Error al editar la solicitud: " . $ex->getMessage());
        }
    }

    public function deleteSolicitud($id)
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            return $statement->execute();
        } catch (PDOException $ex) {
            throw new PDOException("Error al eliminar la solicitud: " . $ex->getMessage());
        }
    }

    public function getByAsignacion($idUsuario)
    {
       $sql = 'SELECT s.*, c."NameClient", sv."service", sv."color" AS "service_color", e."State", e."color" AS "state_color"
        FROM "requests" s
        JOIN "clients" c ON s."FKclients" = c."id"
        JOIN "servicetypes" ts ON s."FKservicetypes" = ts."id"
        JOIN "services" sv ON ts."FKservices" = sv."id"
        JOIN "states" e ON s."FKstates" = e."id"
        WHERE s."assignment" = :idUsuario AND s."FKstates" != 2';
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getByUsuarioCreador($idUsuario)
{
    try {
       $sql = 'SELECT s.*, 
               c."NameClient", 
               sv."service", 
               sv."color" AS service_color, 
               e."State", 
               e."color" AS "state_color"
        FROM "requests" s
        JOIN "clients" c ON s."FKclients" = c."id"
        JOIN "servicetypes" ts ON s."FKservicetypes" = ts."id"
        JOIN "services" sv ON ts."FKservices" = sv."id"
        JOIN "states" e ON s."FKstates" = e."id"
        WHERE s."FKusers" = :idUsuario
        ORDER BY s."createdAt" DESC';

        
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    } catch (PDOException $e) {
        error_log("Error en getByUsuarioCreador: " . $e->getMessage());
        return [];
    }
}

    public function getSolicitudesPendientes()
    {
        try {
            // Asumiendo que el estado "Pendiente" tiene idEstado = 1
            $sql = 'SELECT COUNT(*) AS total FROM "' . $this->table . '" WHERE "FKstates" = 1';

            $result = $this->dbConnection->query($sql)->fetch(PDO::FETCH_OBJ);
            return $result->total;
        } catch (PDOException $e) {
            throw new PDOException("Error al obtener solicitudes pendientes: " . $e->getMessage());
        }
    }

    public function getSolicitudesResueltas()
    {
        try {
            // Necesitas verificar qué idEstado corresponde a "Resuelto/Finalizado" en tu BD
            // Asumiendo que podría ser idEstado = 6 o similar
            $sql = 'SELECT COUNT(*) AS total FROM "' . $this->table . '" WHERE "FKstates" = 6';
            $result = $this->dbConnection->query($sql)->fetch(PDO::FETCH_OBJ);
            return $result->total;
        } catch (PDOException $e) {
            throw new PDOException("Error al obtener solicitudes resueltas: " . $e->getMessage());
        }
    }

    public function getSolicitudesEnProceso()
    {
        try {
            $sql = 'SELECT COUNT(*) AS total FROM "' . $this->table . '" WHERE "FKstates" IN (4)';

            $result = $this->dbConnection->query($sql)->fetch(PDO::FETCH_OBJ);
            return $result->total;
        } catch (PDOException $e) {
            throw new PDOException("Error al obtener solicitudes en proceso: " . $e->getMessage());
        }
    }

    public function getArchivadas()
    {
        $sql = 'SELECT s.*, 
               c."NameClient", 
               sv."service", 
               sv."color" AS "service_color", 
               e."State", 
               e."color" AS "state_color"
        FROM "requests" s
        JOIN "clients" c ON s."FKclients" = c."id"
        JOIN "servicetypes" ts ON s."FKservicetypes" = ts."id"
        JOIN "services" sv ON ts."FKservices" = sv."id"
        JOIN "states" e ON s."FKstates" = e."id"
        WHERE s."archive_status" = 1';


        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getArchivadasByAsignacion($idUsuario)
    {
       $sql = 'SELECT s.*, c."NameClient", sv."service", sv."color", e."State", e."color" AS state_color
                FROM "requests" s
                JOIN "clients" c ON s."FKclients" = c."id"
                JOIN "servicetypes" ts ON s."FKservicetypes" = ts."id"
                JOIN "services" sv ON ts."FKservices" = sv."id"
                JOIN "states" e ON s."FKstates" = e."id"
                WHERE s."archive_status" = 1 AND s."assignment" = :id';

        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':id', $idUsuario, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function archivar($idSolicitud)
    {
        $sql = 'UPDATE "requests" SET "archive_status" = 1 WHERE "id" = :idsolicitud';
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':idSolicitud', $idSolicitud, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function desarchivar($idSolicitud)
    {
        $sql = 'UPDATE "requests" SET "archive_status" = 0 WHERE "id" = :idSolicitud';
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':idSolicitud', $idSolicitud, \PDO::PARAM_INT);
        return $stmt->execute();
    }


    public function getSolicitudesPorEstado()
    {
        $sql = 'SELECT "e"."State", COUNT(*) AS "cantidad", "e"."color"
        FROM "requests" AS "s"
        JOIN "State" AS "e" ON "s"."FKstates" = "e"."id"
        GROUP BY "s"."FKstates", "e"."State", "e"."color"';
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getServiciosMasSolicitados()
    {
        try {
            $sql = 'SELECT "sv"."service", COUNT(*) AS "cantidad", "sv"."color"
                    FROM "requests" AS "s"
                    JOIN "servicetypes" AS "ts" ON "s"."FKservicetypes" = "ts"."id"
                    JOIN "service" AS "sv" ON "ts"."FKservice" = "sv"."id"
                    GROUP BY "sv"."id", "sv"."service", "sv"."color"
                    ORDER BY "cantidad" DESC
                    LIMIT 5';

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Error al obtener servicios más solicitados: " . $e->getMessage());
        }
    }

    public function getSolicitudesPorMes()
{
    try {
        $sql = 'SELECT 
            TO_CHAR("createdAt", \'YYYY-MM\') AS "periodo",
            TO_CHAR("createdAt", \'TMMonth\') AS "mes",
            EXTRACT(YEAR FROM "createdAt") AS "anio",
            COUNT(*) AS "cantidad"
        FROM "requests"
        GROUP BY TO_CHAR("createdAt", \'YYYY-MM\'), TO_CHAR("createdAt", \'TMMonth\'), EXTRACT(YEAR FROM "createdAt")
        ORDER BY MIN("createdAt") ASC';

        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new PDOException("Error al obtener solicitudes por mes: " . $e->getMessage());
    }
}


    public function getMunicipiosMasSolicitudes()
    {
        try {
           $sql = 'SELECT 
            COALESCE("municipality", \'Sin Especificar\') AS "Municipio",
            COUNT(*) AS "cantidad"
        FROM "requests"
        WHERE "municipality" IS NOT NULL AND "municipality" <> \'\'
        GROUP BY "municipality"
        ORDER BY "cantidad" DESC';

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Error al obtener municipios: " . $e->getMessage());
        }
    }

    public function getUltimosMovimientos($limit = 5)
    {
        try {
           $sql = 'SELECT 
            s."id",
            u."nameUser",
            \'Nueva Solicitud\' AS "accion",
            s."createdAt" AS "fecha"
            FROM "requests" s
            JOIN "users" u ON s."FKusers" = u."id"
            ORDER BY s."createdAt" DESC
            LIMIT :limit';


            $stmt = $this->dbConnection->prepare($sql);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Error al obtener últimos movimientos: " . $e->getMessage());
        }
    }
}
