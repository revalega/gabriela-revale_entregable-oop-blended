<?php

//creo la página de creación de actores y actrices con la misma lógica y estructura que las de creado de películas y gêneros

	require_once 'autoload.php';

	//ejecuto la función que retorna todas las películas de la DB. Las necesitaremos para crear el listado a través del cual se seleccionará la película favorita del actor

	$movies = DB::getAllMovies();

	//si recibo información por POST voy a crear una nueva instacia de la clase Actor y ejecutar la función saveActor que hará un INSERT en la DB
	if ($_POST) {
		$actorToSave = new Actor($_POST['first_name'], $_POST['last_name'], $_POST['rating']);
		$actorToSave->setFavoriteMovieId($_POST['favorite_movie_id']);
		$saved = DB::saveActor($actorToSave);
	}

	$pageTitle = 'Crear actor/actriz';
	require_once 'partials/head.php';
	require_once 'partials/navbar.php';
?>

		<div class="container">
			<div class="row justify-content-center">
				<div class="col-10">
					<h2>Crear actor/actriz</h2>
					<!--creo un formulario con los campos Nombre, Apellido, Rating y un select de Película favorita-->
					<form method="post">
						<div class="row">
							<div class="col-6">
								<div class="form-group">
									<label>Nombre:</label>
									<input type="text" class="form-control" placeholder="Ej: Valeria" name="first_name">
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<label>Apellido:</label>
									<input type="text" class="form-control" placeholder="Ej: Bertuccelli" name="last_name">
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<label>Rating:</label>
									<input type="text" class="form-control" placeholder="Ej: 9.2" name="rating">
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<label>Película favorita:</label>
									<!--creo un select recorriendo el array de objetos de tipo Movie. A través de getters recupero su id para utilizar en el value y el title para que se visualice en el listado de opciones-->
									<select class="form-control" name="favorite_movie_id">
										<option value="">Elegí una película</option>
										<?php foreach ($movies as $movie): ?>
											<option value="<?php echo $movie->getId() ?>"><?php echo $movie->getTitle() ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-12 text-center">
								<button type="submit" class="btn btn-primary">GUARDAR</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<?php if (isset($saved)): ?>
				<div
					class="alert <?php echo $saved ? 'alert-success' : 'alert-danger'?>"
				>
					<?php echo $saved ? '¡Actor/Actriz guardade con éxito!' : '¡No se pudo guardar al actor/actriz!' ?>
				</div>
			<?php endif; ?>
		</div>
	</body>
</html>
