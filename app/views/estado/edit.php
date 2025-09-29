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

.color-picker {
  height: 40px;
  padding: 2px;
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
  border-radius: 10px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn:hover {
  background-color: #00547d;
}

</style>

<div class="data-container">
    <form action="/estado/update" method="post">
        <h2 class="form-title">Editar Estado</h2>
        <input type="hidden" name="idEstado" value="<?php echo $estado->idEstado ?>">
        <div class="form-group">
            <label for="Estado">Nombre del estado</label>
            <input type="text" name="Estado" id="Estado" class="form-control" maxlength="45" required value="<?php echo $estado->Estado ?>">
        </div>
        <div class="form-group">
            <label for="Descripcion">Descripción del estado</label>
            <input type="text" name="Descripcion" id="Descripcion" class="form-control" maxlength="100" required value="<?php echo $estado->Descripcion ?>">
        </div>
        <!-- Nuevo campo de color -->
        <div class="form-group">
            <label for="Color">Color del Estado</label>
            <input type="color" name="Color" id="Color" required 
                   class="form-control color-picker" 
                   value="<?php echo isset($estado->Color) ? $estado->Color : '#4361ee' ?>">
        </div>
        <div class="form-group button-group">
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
    </form>
</div>
