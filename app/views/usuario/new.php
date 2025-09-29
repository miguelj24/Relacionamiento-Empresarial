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
.button-group {
  display: flex;
  justify-content: center;
}

</style>

<div class="data-container">
    <form action="/usuario/create" method="post">
        <h2 class="form-title">Crear Usuario</h2>
        <div class="form-group">
            <label for="DocumentoUsuario">Documento</label>
            <input type="text" name="DocumentoUsuario" required maxlength="20" class="form-control">
        </div>
        <div class="form-group">
            <label for="NombreUsuario">Nombre</label>
            <input type="text" name="NombreUsuario" required maxlength="100" class="form-control">
        </div>
        <div class="form-group">
            <label for="CorreoUsuario">Correo</label>
            <input type="email" name="CorreoUsuario" required maxlength="100" class="form-control">
        </div>
        <div class="form-group">
            <label for="TelefonoUsuario">Teléfono</label>
            <input type="tel" name="TelefonoUsuario" required maxlength="10" class="form-control">
        </div>
        <div class="form-group">
            <label for="ContraseñaUsuario">Contraseña</label>
            <input type="password" name="ContraseñaUsuario" required class="form-control">
        </div>
        <div class="form-group">
            <label for="FKidRol">Rol</label>
            <select name="FKidRol" required class="form-control">
                <?php foreach($roles as $rol): ?>
                    <option value="<?php echo $rol->idRol ?>"><?php echo $rol->Rol ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="Coordinador">Coordinador</label>
            <select name="Coordinador" class="form-control">
                <option value="0" selected>No</option>
                <option value="1">Sí</option>
            </select>
        </div>
        <div class="form-group button-group">
            <button type="submit" class="btn">Guardar</button>
        </div>
    </form>
</div>