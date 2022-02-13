<h1>Algunos de nuestros productos</h1>

<?php while ($product = $productos->fetch_object()) : ?>
	<div class="product container-fluid m-auto col-lg-4 col-sm-12">
		<a href="<?= base_url ?>producto/ver&id=<?= $product->id ?>">
			<?php if ($product->imagen != null) : ?>
				<img alt="<?= $product->nombre ?>" src="<?= base_url ?>uploads/images/<?= $product->imagen ?>" />
			<?php else : ?>
				<img alt="<?= $product->nombre ?>" src="<?= base_url ?>assets/img/camiseta.png" />
			<?php endif; ?>
			<h2><?= $product->nombre ?></h2>
		</a>

		<?php if ($product->stock > 0) : ?>
			<?php if ($product->oferta == "si") : ?>
				<!--Muestro si esta de oferta-->
				<p><span class="text-danger" style="text-decoration: line-through;"><?= ($product->precio) * 1.40 ?> €</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $product->precio ?> €
					<a href="<?= base_url ?>carrito/add&id=<?= $product->id ?>" class="btn btn-warning w-100">Oferta · Comprar</a>
				<?php else : ?>
				<p><?= $product->precio ?> €
					<a href="<?= base_url ?>carrito/add&id=<?= $product->id ?>" class="btn-success btn w-100">Comprar</a>
				<?php endif ?>
			<?php else : ?>
				<!--Cambio el boton cuando no hay stock-->
				<p><?= $product->precio ?> €
					<a href="" class="btn-danger btn w-100">Sin Stock</a>
				<?php endif ?>
				</p>
	</div>
<?php endwhile; ?>

<!--Paginacion-->

<nav>
	<div>
		<div class="col-xs-12 col-sm-6">
			<!-- <p>Mostrando <?= $productosPorPagina ?> de <?= $conteo ?> productos disponibles</p> -->
		</div>
		<div class="col-xs-12 col-sm-6">
			<p>Página <?= $pagina ?> de <?= $paginas ?>
		</div>
	</div>

	<div class="pagination">
		<table>
			<tr>
				<!-- Si la página actual es mayor a uno, mostramos el botón para ir una página atrás -->
				<?php if ($pagina > 1) { ?>
					<td>
						<a href="<?= base_url ?>?pagina=<?php echo $pagina - 1 ?>">
							<span aria-hidden="true">&laquo;</span>
						</a>
					</td>
				<?php } ?>


				<!-- Mostramos enlaces para ir a todas las páginas. Es un simple ciclo for-->
				<?php for ($x = 1; $x <= $paginas; $x++) { ?>
					<td class="<?php if ($x == $pagina) echo "active" ?>">
						<a href="<?= base_url ?>?pagina=<?php echo $x ?>">
							<?php echo $x ?></a>
					</td>
				<?php } ?>

				<!-- Si la página actual es menor al total de páginas, mostramos un botón para ir una página adelante -->
				<?php if ($pagina < $paginas) { ?>
					<td>
						<a href="<?= base_url ?>?pagina=<?php echo $pagina + 1 ?>">
							<span aria-hidden="true">&raquo;</span>
						</a>
					</td>
				<?php } ?>
			</tr>
		</table>
	</div>
</nav>