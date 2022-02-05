<h1>Mis Datos</h1>

<?php if(isset($_SESSION['userMod']) && $_SESSION['userMod'] == 'complete'): ?>
	<strong class="alert_green">El suario se ha modificado correctamente</strong>
<?php elseif(isset($_SESSION['userMod']) && $_SESSION['userMod'] != 'complete'): ?>	
	<strong class="alert_red">El usuario NO se ha modificado correctamente</strong>
<?php endif; ?>
<?php Utils::deleteSession('userMod'); ?>
	
<div class="form_container">
	
	<form action="<?=base_url?>usuario/guardarcambios" method="POST" enctype="multipart/form-data">
        Nombre: <input type="text" name="nombre" value="<?= $usu->nombre ?>"/>
        Apellidos: <input type="text" name="apellidos" value="<?= $usu->apellidos ?>"/>
        Email: <input type="text" name="email" value="<?= $usu->email ?>"/>
		Direccion: <input type="text" name="direccion" value="<?= $usu->direccion ?>"/>
        Contraseña: <input type="password" name="password"/>
        Nueva Contraseña: <input type="password" name="passwordN1"/>
        Repite la Contraseña: <input type="password" name="passwordN2"/>
			
		<input type="submit" value="Guardar" />
	</form>
</div>