<?php
//cracion de clase actor
	class Actor
	{
    private $id;
    private $first_name;
    private $last_name;
    private $rating;
    private $favorite_movie_id;
    private $favorite_movie_title;

//CONSTUCTOR. Se define un constructor con first_name, last_name y rating como parametros obligatorios para la creacion de una nueva instancia
    public function __construct($first_name, $last_name, $rating)
    {
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->rating = $rating;
    }

//GETTERS y SETTERS
    public function getActorId() {
      return $this->id;
    }

    public function setActorId($id) {
      $this->id = $id;
    }

    public function getFirstName() {
      return $this->first_name;
    }

    public function setFirstName($first_name) {
      $this->first_name = $first_name;
    }

    public function getLastName() {
      return $this->last_name;
    }

    public function setLastName($last_name) {
      $this->last_name = $last_name;
    }

    public function getRating() {
      return $this->rating;
    }

    public function setRating($rating) {
      $this->rating = $rating;
    }

    public function getFavoriteMovieId() {
      return $this->favorite_movie_id;
    }

    public function setFavoriteMovieId($favorite_movie_id) {
      $this->favorite_movie_id = $favorite_movie_id;
    }

//se define un metodo getter para obtener el titulo de la favorite_movie y que en caso de no estar seteada devuelva un mensaje generico 'No definida' para que no queden espacios vacios en la columna
    public function getFavoriteMovieTitle() {
  			if ($this->favorite_movie_title) {
  				return $this->favorite_movie_title;
  			}
  			return 'No definida';
    }

    public function setFavoriteMovieTitle($favorite_movie_title) {
      $this->favorite_movie_title = $favorite_movie_title;
    }
}
