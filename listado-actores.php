<?php
//creo la página de listado de actores y actrices con la misma lógica y estructura que el listado de películas

	require_once 'autoload.php';

//En este caso ejecuto la función que me traera el listado de actores.
	$actors = DB::getAllActors();

	$pageTitle = 'Listado de actores y actrices';
	require_once 'partials/head.php';
	require_once 'partials/navbar.php';
?>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<!--Defino una tabla de 4 columnas: nombre, apellido, rating, película favorita-->
					<table class="table table-striped">
						<thead class="thead-dark">
			    			<tr>
								<th scope="col">Nombre</th>
								<th scope="col">Apellido</th>
								<th scope="col">Rating</th>
								<th scope="col">Película Favorita</th>
			    			</tr>
			  			</thead>
			  			<tbody>
							<!--A través de un foreach realizo el listado de actores generando una fila por objeto y
							recuperando a través de los gettes, los atributos de cada instacia/objeto Actor-->
							<?php foreach ($actors as $actor): ?>
								<tr>
									<th scope="row">
									<?php echo $actor->getFirstName(); ?></th>
									<td><?php echo $actor->getLastName(); ?></td>
									<td><?php echo $actor->getRating(); ?></td>
									<td><?php echo $actor->getFavoriteMovieTitle(); ?></td>
								</tr>
							<?php endforeach; ?>
			  			</tbody>
					</table>
				</div>
			</div>
		</div>

	</body>
</html>
