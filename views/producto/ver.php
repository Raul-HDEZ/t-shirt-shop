<?php if (isset($product)): ?>
	<h1><?= $product->nombre ?></h1>
	<div id="detail-product">
		<div class="image">
			<?php if ($product->imagen != null): ?>
				<img src="<?= base_url ?>uploads/images/<?= $product->imagen ?>" />
			<?php else: ?>
				<img src="<?= base_url ?>assets/img/camiseta.png" />
			<?php endif; ?>
		</div>
		<div class="data">
			<p class="description"><?= $product->descripcion ?></p>
			<?php if ($product->stock > 0):?>
			<?php if ($product->oferta == "si"):?>
				<!--Muestro si esta de oferta-->
				<p style="text-decoration: line-through;"><?=($product->precio)*1.40?> $</p>
				<p><?=$product->precio?> $</p>
				<a href="<?= base_url ?>carrito/add&id=<?= $product->id ?>" class="orange button">Oferta - Comprar</a>
				<?php else :?>
					<p><?=$product->precio?> $
				<a href="<?= base_url ?>carrito/add&id=<?= $product->id ?>" class="button">Comprar</a>
			<?php endif ?>
		<?php else :?>
			<!--Cambio el boton cuando no hay stock-->
			<p><?=$product->precio?> $
			<a href="" class="button-red">Sin Stock</a>
		<?php endif ?>
			</p>
		</div>
	</div>
<?php else: ?>
	<h1>El producto no existe</h1>
<?php endif; ?>
