<h1>Gestión de Usuarios General</h1>

<a href="<?=base_url?>usuario/crear" class="button button-small">
	Crear Usuario
</a>

<?php if(isset($_SESSION['registro']) && $_SESSION['registro'] == 'complete'): ?>
	<strong class="alert_green">El Usuario se ha creado correctamente</strong>
<?php elseif(isset($_SESSION['registro']) && $_SESSION['registro'] != 'complete'): ?>	
	<strong class="alert_red">El Usuario NO se ha creado correctamente</strong>
<?php endif; ?>
<?php Utils::deleteSession('registro'); ?>
	
<?php if(isset($_SESSION['delete']) && $_SESSION['delete'] == 'complete'): ?>
	<strong class="alert_green">El Usuario se ha borrado correctamente</strong>
<?php elseif(isset($_SESSION['delete']) && $_SESSION['delete'] != 'complete'): ?>	
	<strong class="alert_red">El Usuario NO se ha borrado correctamente</strong>
<?php endif; ?>
<?php Utils::deleteSession('delete'); ?>
	
<table>
	<tr>
		<th>ID</th>
		<th>NOMBRE</th>
		<th>APELLIDOS</th>
		<th>EMAIL</th>
		<th>ROL</th>
		<th>TOTAL</th>
		<th>PEDIDOS PENDIENTES</th>
	</tr>
	<?php while($user = $usuarios->fetch_object()): ?>
		<tr>
		<td><?=$user->id;?></td>
			<td><?=$user->nombre;?></td>
			<td><?=$user->apellidos;?></td>
			<td><?=$user->email;?></td>
			<td><?=$user->rol;?></td>
			<td><?= ($user->Coste_Pedidos == NULL)? 0 : $user->Coste_Pedidos ?> $</td>
			<td><?=$user->Pendientes;?></td>
			
			<td>
				<a href="<?=base_url?>usuario/editar&id=<?=$user->id?>" class="button button-gestion">Editar</a>
				<a href="<?=base_url?>usuario/eliminar&id=<?=$user->id?>" class="button button-gestion button-red">Eliminar</a>
			</td>
		</tr>
	<?php endwhile; ?>
</table>
