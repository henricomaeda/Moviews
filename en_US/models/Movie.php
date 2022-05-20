<?php
	// Classe Movie (Filmes).
	class Movie {
		public $id;
		public $title;
		public $description;
		public $image;
		public $trailer;
		public $category;
		public $length;
		public $users_id;
		
		// Função que retorna um nome de imagem gerado a partir um código hexadecimal de 60 bytes aleatórios.
		public function imageGenerateName() {
			return bin2hex(random_bytes(60)) . ".jpg";
		}
	}
	
	// Interface MovieDAOInterface.
	interface MovieDAOInterface {
		
		// Funções públicas na MovieDAOInterface.
		public function buildMovie($data);
		public function findAll();
		public function getLatestMovies();
		public function getMoviesByCategory($category);
		public function getMoviesByUserId($id);
		public function findById($id);
		public function findByTitle($title);
		public function create(Movie $movie);
		public function update(Movie $movie);
		public function destroy($id);
	}