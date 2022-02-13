<!DOCTYPE HTML>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<title>Tienda de Camisetas</title>
	<link rel="stylesheet" href="<?= base_url ?>assets/css/styles.css" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>

<body>
	<div id="container">
		<!-- CABECERA -->
		<header id="header">
			<div id="logo">
				<img src="<?= base_url ?>assets/img/camiseta.png" alt="Camiseta Logo" />
				<a href="<?= base_url ?>">
					Tienda de camisetas
				</a>
			</div>
		</header>
		<!-- MENU -->
		<?php $categorias = Utils::showCategorias(); ?>
		<div class="bg-light">
			<nav class="navbar navbar-expand-lg navbar-light bg-light border-3 border-bottom border-primary">
				<div class="container-fluid">
					<a href="<?= base_url ?>" class="navbar-brand">Inicio</a>

					<button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#MenuNavegacion">
						<span class="navbar-toggler-icon"></span>
					</button>
				</div>

				<div id="MenuNavegacion" class="collapse navbar-collapse">
					<ul class="navbar-nav ms-3">
						<?php while ($cat = $categorias->fetch_object()) : ?>
							<li class="nav-item">
								<a class="nav-link" href="<?= base_url ?>categoria/ver&id=<?= $cat->id ?>"><?= $cat->nombre ?></a>
							</li>
						<?php endwhile; ?>
					</ul>
				</div>
			</nav>
		</div>


		<div id="content">