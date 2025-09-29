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
        $this->table = "solicitud";
        parent::__construct();
    }

    public function getAll(): array
    {
        try {
            $sql = "SELECT s.*, c.NombreCliente, sv.Servicio, sv.Color, e.Estado, e.Color AS ColorEstado
                    FROM solicitud s
                    JOIN cliente c ON s.FKcliente = c.idCliente
                    JOIN tiposervicio ts ON s.FKtipoServicio = ts.idTipoServicio
                    JOIN servicio sv ON ts.FKidServicio = sv.idServicio
                    JOIN estado e ON s.FKestado = e.idEstado
                    WHERE s.Archivado = 0"; // Solo NO archivadas
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
            $sql = "INSERT INTO {$this->table} 
                    (DescripcionNecesidad, FechaEvento, FechaCreacion, FKcliente, FKtipoServicio, FKestado, FKtipoEvento, FKusuario, MedioSolicitud, Lugar, Municipio) 
                    VALUES 
                    (:Descripcion, :FechaSolicitud, CURDATE(), :IdCliente, :IdServicio, :IdEstado, 1, :IdUsuario, 'Web', :Lugar, :Municipio)";
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
            $sql = "SELECT s.*, 
                       c.idCliente,
                       c.NombreCliente, 
                       c.CorreoCliente, 
                       c.TelefonoCliente,
                       c.DocumentoCliente,
                       ts.TipoServicio, 
                       sv.Servicio, 
                       e.Estado, 
                       e.Descripcion as EstadoDescripcion, 
                       u.NombreUsuario,
                       ua.NombreUsuario AS NombreUsuarioAsignado  -- Agrega esta línea
                FROM {$this->table} s
                JOIN cliente c ON s.FKcliente = c.idCliente
                JOIN tiposervicio ts ON s.FKtipoServicio = ts.idTipoServicio
                JOIN servicio sv ON ts.FKidServicio = sv.idServicio
                JOIN estado e ON s.FKestado = e.idEstado
                JOIN usuario u ON s.FKusuario = u.idUsuario
                LEFT JOIN usuario ua ON s.Asignacion = ua.idUsuario  -- Agrega esta línea
                WHERE s.idSolicitud = :id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            throw new PDOException("Error al obtener la solicitud: " . $ex->getMessage());
        }
    }

    public function editSolicitud($id, $Descripcion, $FechaSolicitud, $IdCliente, $IdTipoServicio, $IdEstado, $Lugar, $Municipio, $Comentarios, $Observaciones, $Asignacion = null)
    {
        try {
            $sql = "UPDATE {$this->table} 
                    SET DescripcionNecesidad = :Descripcion, 
                        FechaEvento = :FechaSolicitud, 
                        FKcliente = :IdCliente, 
                        FKtipoServicio = :IdTipoServicio, 
                        FKestado = :IdEstado,
                        Lugar = :Lugar,
                        Municipio = :Municipio,
                        Comentarios = :Comentarios,
                        Observaciones = :Observaciones";
            if ($Asignacion !== null) {
                $sql .= ", Asignacion = :Asignacion";
            }
            $sql .= " WHERE idSolicitud = :id";
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
            $sql = "DELETE FROM {$this->table} WHERE idSolicitud = :id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            return $statement->execute();
        } catch (PDOException $ex) {
            throw new PDOException("Error al eliminar la solicitud: " . $ex->getMessage());
        }
    }

    public function getByAsignacion($idUsuario)
    {
        $sql = "SELECT s.*, c.NombreCliente, sv.Servicio, sv.Color, e.Estado, e.Color AS ColorEstado
                FROM solicitud s
                JOIN cliente c ON s.FKcliente = c.idCliente
                JOIN tiposervicio ts ON s.FKtipoServicio = ts.idTipoServicio
                JOIN servicio sv ON ts.FKidServicio = sv.idServicio
                JOIN estado e ON s.FKestado = e.idEstado
                WHERE s.Asignacion = :idUsuario AND s.FKestado != 2";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getByUsuarioCreador($idUsuario)
{
    try {
        $sql = "SELECT s.*, 
                       c.NombreCliente, 
                       sv.Servicio, 
                       sv.Color, 
                       e.Estado, 
                       e.Color AS ColorEstado
                FROM solicitud s
                JOIN cliente c ON s.FKcliente = c.idCliente
                JOIN tiposervicio ts ON s.FKtipoServicio = ts.idTipoServicio
                JOIN servicio sv ON ts.FKidServicio = sv.idServicio
                JOIN estado e ON s.FKestado = e.idEstado
                WHERE s.FKusuario = :idUsuario
                ORDER BY s.FechaCreacion DESC";
        
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
            // Asumiendo que el estado "Pendiente" tiene idEstado = 3
            $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE FKestado = 3";
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
            $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE FKestado = 4";
            $result = $this->dbConnection->query($sql)->fetch(PDO::FETCH_OBJ);
            return $result->total;
        } catch (PDOException $e) {
            throw new PDOException("Error al obtener solicitudes resueltas: " . $e->getMessage());
        }
    }

    public function getSolicitudesEnProceso()
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM {$this->table} 
                WHERE FKestado IN (5)";
            $result = $this->dbConnection->query($sql)->fetch(PDO::FETCH_OBJ);
            return $result->total;
        } catch (PDOException $e) {
            throw new PDOException("Error al obtener solicitudes en proceso: " . $e->getMessage());
        }
    }

    public function getArchivadas()
    {
        $sql = "SELECT s.*, c.NombreCliente, sv.Servicio, sv.Color, e.Estado, e.Color AS ColorEstado
                FROM solicitud s
                JOIN cliente c ON s.FKcliente = c.idCliente
                JOIN tiposervicio ts ON s.FKtipoServicio = ts.idTipoServicio
                JOIN servicio sv ON ts.FKidServicio = sv.idServicio
                JOIN estado e ON s.FKestado = e.idEstado
                WHERE s.Archivado = 1"; // Solo archivadas
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getArchivadasByAsignacion($idUsuario)
    {
        $sql = "SELECT s.*, c.NombreCliente, sv.Servicio, sv.Color, e.Estado, e.Color AS ColorEstado
                FROM solicitud s
                JOIN cliente c ON s.FKcliente = c.idCliente
                JOIN tiposervicio ts ON s.FKtipoServicio = ts.idTipoServicio
                JOIN servicio sv ON ts.FKidServicio = sv.idServicio
                JOIN estado e ON s.FKestado = e.idEstado
                WHERE s.FKestado = 2 AND s.Asignacion = :idUsuario";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function archivar($idSolicitud)
    {
        $sql = "UPDATE solicitud SET Archivado = 1 WHERE idSolicitud = :idSolicitud";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':idSolicitud', $idSolicitud, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function desarchivar($idSolicitud)
    {
        $sql = "UPDATE solicitud SET Archivado = 0 WHERE idSolicitud = :idSolicitud";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':idSolicitud', $idSolicitud, \PDO::PARAM_INT);
        return $stmt->execute();
    }


    public function getSolicitudesPorEstado()
    {
        $sql = "SELECT e.Estado, COUNT(*) as cantidad, e.Color
                FROM solicitud s
                JOIN estado e ON s.FKestado = e.idEstado
                GROUP BY s.FKestado";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getServiciosMasSolicitados()
    {
        try {
            $sql = "SELECT sv.Servicio, COUNT(*) as cantidad, sv.Color
                    FROM solicitud s
                    JOIN tiposervicio ts ON s.FKtipoServicio = ts.idTipoServicio
                    JOIN servicio sv ON ts.FKidServicio = sv.idServicio
                    GROUP BY sv.idServicio, sv.Servicio, sv.Color
                    ORDER BY cantidad DESC
                    LIMIT 5";
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
            $sql = "SELECT 
                MONTH(FechaCreacion) as mes,
                SUM(CASE WHEN FKestado = 5 THEN 1 ELSE 0 END) as en_proceso,
                SUM(CASE WHEN FKestado = 6 THEN 1 ELSE 0 END) as ejecutadas
                FROM solicitud
                WHERE FechaCreacion >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                GROUP BY MONTH(FechaCreacion)
                ORDER BY FechaCreacion ASC";
            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Error al obtener solicitudes por mes: " . $e->getMessage());
        }
    }

    public function getMunicipiosMasSolicitudes()
    {
        try {
            $sql = "SELECT 
                COALESCE(Municipio, 'Sin Especificar') as Municipio,
                COUNT(*) as cantidad
                FROM solicitud
                WHERE Municipio IS NOT NULL AND Municipio != ''
                GROUP BY Municipio
                ORDER BY cantidad DESC";

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
            $sql = "SELECT 
                    s.idSolicitud,
                    u.NombreUsuario,
                    'Nueva Solicitud' as accion,
                    s.FechaCreacion as fecha
                    FROM solicitud s
                    JOIN usuario u ON s.FKusuario = u.idUsuario
                    ORDER BY s.FechaCreacion DESC
                    LIMIT :limit";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Error al obtener últimos movimientos: " . $e->getMessage());
        }
    }
}
