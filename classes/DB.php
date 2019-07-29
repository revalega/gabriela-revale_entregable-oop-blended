<?php

	abstract class DB
	{
		/*
		agrego método para obtener todos los actores.
		recupero la información de la DB haciendo una consulta en la tabla actors (para traer toda la información de cada actor/actriz)
		con join a la tabla movies (para poder traer los títulos de las películas favoritas). ordeno por first_name y luego por last_name.
		Luego genero un array de objetos de tipo Actor, a través de un foreach que recorre el array obtenido de la consulta a DB y genera por cada actor, un objeto de tipo Actor.
		Nombre, apellido y rating, al estar definidos en el constructor de la clase actor, se definen en la misma creación de la instancia.
		Los otros atributos los asigno a través de setters.
		Retorno el array de objetos de tipo Actor.
		*/
		public static function getAllActors()
		{
			global $connection;

			$stmt = $connection->prepare("
				SELECT a.id AS 'actor_id', a.first_name, a.last_name, a.rating, a.favorite_movie_id, m.title
				FROM actors AS a
				LEFT JOIN movies AS m
				ON a.favorite_movie_id = m.id
				ORDER BY a.first_name, a.last_name;
			");

			$stmt->execute();

			$actors = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$actorsObject = [];

			foreach ($actors as $actor) {
				$finalActor = new Actor($actor['first_name'], $actor['last_name'], $actor['rating']);

				$finalActor->setActorId($actor['actor_id']);
				$finalActor->setFavoriteMovieId($actor['favorite_movie_id']);
				$finalActor->setFavoriteMovieTitle($actor['title']);

				$actorsObject[] = $finalActor;
			}

			return $actorsObject;
		}

		//corrección de la asignación del id de movie y id de género en la consulta SQL (debía traer el id del genero y no lo hacía) y en el foreach (se le estaba asignando al objeto nuevo como id de genero el id de la película y no se estaba seteando el id de película)
		public static function getAllMovies()
		{
			global $connection;

			$stmt = $connection->prepare("
				SELECT m.id AS 'movie_id', m.title, m.rating, m.awards, m.release_date, m.length, m.genre_id AS 'genre_id', g.name AS 'genre'
				FROM movies as m
				LEFT JOIN genres as g
				ON g.id = m.genre_id
				ORDER BY m.title
			");

			$stmt->execute();

			$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$moviesObject = [];

			foreach ($movies as $movie) {
				$finalMovie = new Movie($movie['title'], $movie['rating'], $movie['awards'], $movie['release_date']);

				$finalMovie->setId($movie['movie_id']);
				$finalMovie->setLength($movie['length']);
				$finalMovie->setGenreID($movie['genre_id']);
				$finalMovie->setGenreName($movie['genre']);

				$moviesObject[] = $finalMovie;
			}

			return $moviesObject;
		}

		public static function getAllGenres()
		{
			global $connection;

			$stmt = $connection->prepare(" SELECT id, name, ranking, active FROM genres");

			$stmt->execute();

			$genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$genresObject = [];

			foreach ($genres as $genre) {
				$finalGenre = new Genre($genre['name'], $genre['ranking'], $genre['active']);

				$finalGenre->setID($genre['id']);

				$genresObject[] = $finalGenre;
			}

			return $genresObject;
		}

		/*
		agrego método para crear un actor
		La función recibe un objeto de tipo de Actor como parámetro.
		Defino una consulta SQL para insertar una nueva fila/registro y los valores que envío los tomo del objeto que viene como parámetro, a través de getters.
		*/
		public static function saveActor(Actor $actor)
		{
			global $connection;

			try {
				$stmt = $connection->prepare("
					INSERT INTO actors (first_name, last_name, rating, favorite_movie_id)
					VALUES(:first_name, :last_name, :rating, :favorite_movie_id)
				");


				$stmt->bindValue(':first_name', $actor->getFirstName());
				$stmt->bindValue(':last_name', $actor->getLastName());
				$stmt->bindValue(':rating', $actor->getRating());
				$stmt->bindValue(':favorite_movie_id', $actor->getFavoriteMovieId());

				$stmt->execute();

				return true;
			} catch (PDOException $exception) {
				return false;
			}
		}


		public static function saveMovie(Movie $movie)
		{
			global $connection;

			try {
				$stmt = $connection->prepare("
					INSERT INTO movies (title, rating, awards, release_date, length, genre_id)
					VALUES(:title, :rating, :awards, :release_date, :length, :genre_id)
				");


				$stmt->bindValue(':title', $movie->getTitle());
				$stmt->bindValue(':rating', $movie->getRating());
				$stmt->bindValue(':awards', $movie->getAwards());
				$stmt->bindValue(':release_date', $movie->getReleaseDate());
				$stmt->bindValue(':length', $movie->getLength());
				$stmt->bindValue(':genre_id', $movie->getGenreID());

				$stmt->execute();

				return true;
			} catch (PDOException $exception) {
				return false;
			}
		}

		public static function saveGenre(Genre $genre)
		{
			global $connection;

			$genres = self::getAllGenres();

			$finalGenres = [];

			foreach ($genres as $oneGenre) {
				$finalGenres[] = $oneGenre->getName();
			}

			if (!in_array($genre->getName(), $finalGenres)) {
				$stmt = $connection->prepare("
					INSERT INTO genres (name, ranking, active)
					VALUES(:name, :ranking, :active)
				");

				$stmt->bindValue(':name', $genre->getName());
				$stmt->bindValue(':ranking', $genre->getRanking());
				$stmt->bindValue(':active', $genre->getActive());

				$stmt->execute();

				return true;
			} else {
				return false;
			}
		}
	}
