<?php if (isset($gestion)): ?>
	<h1>Gestionar pedidos</h1>
<?php else: ?>
	<h1>Mis pedidos</h1>
<?php endif; ?>
<table>
	<tr>
		<th>Nº Pedido</th>
		<th>Id Usuario</th>
		<th>Coste</th>
		<th>Fecha</th>
		<th>Estado</th>
		<th>Acciones</th>
	</tr>
	<?php
	while ($ped = $pedidos->fetch_object()):
		?>

		<tr>
			<td>
				<a href="<?= base_url ?>pedido/detalle&id=<?= $ped->id ?>"><?= $ped->id ?></a>
			</td>
			<td>
				<?= $ped->usuario_id ?> 
			</td>
			<td>
				<?= $ped->coste ?> $
			</td>
			<td>
				<?= $ped->fecha ?>
			</td>
			<td>
				<?=Utils::showStatus($ped->estado)?>
			</td>
			<td>
			<a href="<?=base_url?>pedido/cancelar&id=<?= $ped->id ?>" class="button button-gestion button-red">Cancelar</a>
			</td>
		</tr>

	<?php endwhile; ?>
</table>