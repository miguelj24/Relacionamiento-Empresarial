<style>
   /* Contenedor principal */
.data-container {
  max-width: 500px;
  margin: 2rem auto;
  padding: 2rem;
  background-color: #f9f9f9;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Grupo de campos */
.form-group {
  margin-bottom: 1.5rem;
}

.form-title {
  text-align: center;
  color: #0b5fa4; /* azul moderno */
  font-size: 1.5rem;
  font-weight: 700;
  margin-bottom: 2rem;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}


/* Etiquetas */
.form-group label {
  display: block;
  font-weight: 600;
  margin-bottom: 0.5rem;
  color: #333;
}

/* Campos de entrada y select */
.form-control {
  width: 100%;
  padding: 0.6rem 1rem;
  border: 1px solid #ccc;
  border-radius: 10px;
  font-size: 1rem;
  box-sizing: border-box;
  transition: border-color 0.2s ease;
}

.form-control:focus {
  outline: none;
  border-color: #0b6e99;
}

/* Botón guardar */
.button-group {
  display: flex;
  justify-content: center;
}
.btn {
  width: 50%;
  background-color: #003b5c;
  color: white;
  padding: 0.7rem 1.2rem;
  font-size: 1rem;
  border: none;
  margin: auto;
  border-radius: 10px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn:hover {
  background-color: #00547d;
}


</style>

<div class="data-container">
    <form action="/tipoEvento/update" method="post">
        <h2 class="form-title">Editar Tipo de Evento</h2>
        <input type="hidden" name="idTipoEvento" value="<?php echo $tipoEvento->id ?>">
        <div class="form-group">
            <label for="TipoEvento">Nombre del Tipo de Evento</label>
            <input type="text" name="TipoEvento" value="<?php echo $tipoEvento->eventType ?>" required maxlength="50" class="form-control">
        </div>
        <div class="form-group button-group">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <!-- <a href="/tipoEvento/view" class="btn btn-secondary">Volver</a> -->
        </div>
    </form>
</div>