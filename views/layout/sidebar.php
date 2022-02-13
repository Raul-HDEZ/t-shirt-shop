<!-- BARRA LATERAL -->
<aside id="lateral">

	<div id="carrito" class="block_aside">
		<h3>Mi carrito</h3>
		<ul class="list-group">
			<?php $stats = Utils::statsCarrito(); ?>

			<li class="list-group-item d-flex justify-content-between align-items-center">
				<a href="<?= base_url ?>carrito/index">Productos</a>
				<span class="badge badge-pill bg-primary"><?= $stats['count'] ?></span>
			</li>
			<li class="list-group-item d-flex justify-content-between align-items-center">
				<a href="<?= base_url ?>carrito/index">Total: </a>
				<span class="badge badge-pill bg-primary"><?= $stats['total'] ?> €</span>
			</li>
		</ul>
	</div>

	<div id="login" class="block_aside">

		<?php if (!isset($_SESSION['identity'])) : ?>
			<h3>Entrar a la web</h3>
			<form action="<?= base_url ?>usuario/login" method="post">
				<label for="email">Email</label>
				<input type="email" id="email" name="email" placeholder="email" title="email" required />
				<label for="password">Contraseña</label>
				<input type="password" id="password" name="password" placeholder="password" title="password" required />
				<input type="submit" value="Enviar" />
			</form>
		<?php else : ?>
			<h3><?= $_SESSION['identity']->nombre ?> <?= $_SESSION['identity']->apellidos ?></h3>
		<?php endif; ?>

		<ul>
			<?php if (isset($_SESSION['admin'])) : ?>
				<!--Añado gestion de usuarios-->
				<li class="btn btn-link"><a href="<?= base_url ?>usuario/gestion">Gestionar usuarios</a></li>
				<li class="btn btn-link"><a href="<?= base_url ?>categoria/index">Gestionar categorias</a></li>
				<li class="btn btn-link"><a href="<?= base_url ?>producto/gestion">Gestionar productos</a></li>
				<li class="btn btn-link"><a href="<?= base_url ?>producto/dashboard">Datos de ventas</a></li>
				<li class="btn btn-link"><a href="<?= base_url ?>pedido/gestion">Gestionar pedidos</a></li>
			<?php endif; ?>

			<?php if (isset($_SESSION['identity'])) : ?>
				<li class="btn btn-link"><a href="<?= base_url ?>pedido/mis_pedidos">Mis pedidos</a></li>
				<!-- Muestro la opcion de gestionar mis datos solo a usuarios normales	-->
				<?php if (!isset($_SESSION['admin'])) : ?>
					<li class="btn btn-link"><a href="<?= base_url ?>usuario/editarUsuario">Gestionar mis Datos</a></li>
				<?php endif; ?>

				<li class="btn btn-link"><a href="<?= base_url ?>usuario/logout">Cerrar sesión</a></li>
			<?php else : ?>
				<li class="btn btn-link"><a href="<?= base_url ?>usuario/registro">Registrate aqui</a></li>
			<?php endif; ?>
		</ul>
	</div>

</aside>

<!-- CONTENIDO CENTRAL -->
<div id="central">