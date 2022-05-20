<?php
	// Inclue apenas uma vez os arquivos abaixo.
	require_once("models/Movie.php");
	require_once("models/Message.php");
	require_once("dao/ReviewDAO.php");
	
	// Classe MovieDAO, implementando a Interface MovieDAOInterface.
	class MovieDAO implements MovieDAOInterface {
		private $conn;
		private $url;
		private $message;
		
		// Construtor público da classe.
		public function FindAll() {}
		public function __construct(PDO $conn, $url) {
			$this -> conn = $conn;
			$this -> url = $url;
			$this -> message = new Message($url);
		}
		
		// Função que criará a estrutura de dados do filme.
		public function buildMovie($data) {
			$movie = new Movie();
			
			$movie -> id = $data["mov_id"];
			$movie -> title = $data["mov_title"];
			$movie -> description = $data["mov_description"];
			$movie -> image = $data["mov_image"];
			$movie -> trailer = $data["mov_trailer"];
			$movie -> category = $data["cat_id"];
			$movie -> length = $data["mov_length"];
			$movie -> users_id = $data["use_id"];
			
			// Chama o construtor.
			$reviewDao = new ReviewDao($this -> conn, $this -> url);

			// Recebe as avaliações.
			$rating = $reviewDao -> getRatings($movie -> id);
			$movie -> rating = $rating;
			
			// Retorna a estrutura de dados do filme.
			return $movie;
		}
		
		// Função que recebe os últimos filmes lançados.
		public function getLatestMovies($roll = 0) {
			$movies = [];
			$roll_n = 0;
			
			$stmt = $this -> conn -> query("select * from movies order by mov_id desc limit 10");
			$stmt -> execute();
			
			// Verifica os últimos filmes lançados
			if ($stmt -> rowCount() > 0) {

				// Define a variável como array, recebendo as linhas do resultado buscado.
				$moviesArray = $stmt -> fetchAll();
				
				foreach($moviesArray as $movie) {
					$roll_n++;
					
					if ($roll == 1) {
						// Recebe 0 de 5 filmes encontrados.
						if ($roll_n <= 5) $movies[] = $this -> buildMovie($movie);
					} else if ($roll == 2) {
						// Recebe 5 de 10 filmes, ignorando os 5 primeiros.
						if ($roll_n >= 6) $movies[] = $this -> buildMovie($movie);
					}
				}
			}
			
			// Retorna a estrutura de dados dos filmes recebidos.
			return $movies;
		}

		// Função que recebe os filmes pela categoria buscada.
		public function getMoviesByCategory($category) {
			$movies = [];
			
			$stmt = $this -> conn -> prepare("select * from movies where cat_id = :cat_id order by mov_id desc");
			
			$stmt -> bindParam(":cat_id", $category);
			$stmt -> execute();
			
			// Verifica se há filmes com a categoria inserida.
			if ($stmt -> rowCount() > 0) {
				$moviesArray = $stmt -> fetchAll();
				
				foreach($moviesArray as $movie) {
					$movies[] = $this -> buildMovie($movie);
				}
			}

			// Retorna os filmes.
			return $movies;
		}

		// Função que recebe os filmes enviados pelo o usuário.
		public function getMoviesByUserId($id) {
			$movies = [];
			
			$stmt = $this -> conn -> prepare("select * from movies where use_id = :use_id");
			
			$stmt -> bindParam(":use_id", $id);
			$stmt -> execute();
			
			// Verifica se o usuário enviou filmes.
			if ($stmt -> rowCount() > 0) {
				$moviesArray = $stmt -> fetchAll();
				
				foreach($moviesArray as $movie) {
					$movies[] = $this -> buildMovie($movie);
				}
			}

			// Retorna os filmes.
			return $movies;
		}
		
		// Função que recebe o filme pelo o ID.
		public function findById($id) {
			$movie = [];
			
			$stmt = $this -> conn -> prepare("select * from movies where mov_id = :mov_id");
			
			$stmt -> bindParam(":mov_id", $id);
			$stmt -> execute();
			
			// Verifica se há filmes com o ID inserido.
			if ($stmt -> rowCount() > 0) {
				$movieData = $stmt -> fetch();

				// Retorna a estrutura de dados do filme.
				$movie = $this -> buildMovie($movieData);
				return $movie;
			} else return false;
		}
		
		// Função que busca filmes pelo título inserido.
		public function findByTitle($title) {
			$movies = [];
			
			$stmt = $this -> conn -> prepare("select * from movies where mov_title like :mov_title");
			
			$stmt -> bindValue(":mov_title", '%'.$title.'%');
			$stmt -> execute();
			
			// Verifica se há filmes com o título inserido.
			if ($stmt -> rowCount() > 0) {
				$moviesArray = $stmt -> fetchAll();

				foreach($moviesArray as $movie) $movies[] = $this -> buildMovie($movie);
			}
			
			// Retorna os filmes encontrados.
			return $movies;
		}
		
		// Função que procura a categoria pelo seu ID.
		public function findCategory($movie_category_id) {
			if ($movie_category_id != "") {
				$stmt = $this -> conn -> prepare("select cat_genre from categories where cat_id = :cat_id");
				
				$stmt -> bindParam(":cat_id", $movie_category_id);
				$stmt -> execute();
				
				// Verifica se há categoria com o ID inserido.
				if ($stmt -> rowCount() > 0) {
					$data_cat = $stmt -> fetch();
					
					// Retorna o gênero encontrado pelo ID.
					return $data_cat['cat_genre'];
				} else return "No category";
			} else return "No category";
		}
		
		// Função que cria o filme com os dados inseridos.
		public function create(Movie $movie) {
			$stmt = $this -> conn -> prepare("INSERT INTO movies (
				mov_title, mov_description, mov_image, mov_trailer, cat_id, mov_length, use_id
			) VALUES (
				:mov_title, :mov_description, :mov_image, :mov_trailer, :cat_id, :mov_length, :use_id
			)");
			
			// Define os parâmetros e insere os dados do novo filme na database.
			$stmt -> bindParam(":mov_title", $movie -> title);
			$stmt -> bindParam(":mov_description", $movie -> description);
			$stmt -> bindParam(":mov_image", $movie -> image);
			$stmt -> bindParam(":mov_trailer", $movie -> trailer);
			$stmt -> bindParam(":cat_id", $movie -> category);
			$stmt -> bindParam(":mov_length", $movie -> length);
			$stmt -> bindParam(":use_id", $movie -> users_id);
			$stmt -> execute();

			// Redireciona o usuário, com uma mensagem de sucesso.
			$this -> message -> setMessage("Movie added successfully!", "success", "index.php");
		}
		
		// Função que atualiza os dados do filme.
		public function update(Movie $movie) {
			$stmt = $this -> conn -> prepare("update movies set
				mov_title = :mov_title,
				mov_description = :mov_description,
				mov_image = :mov_image,
				cat_id = :cat_id,
				mov_trailer = :mov_trailer,
				mov_length = :mov_length
				where mov_id = :mov_id
			");
			
			// Define os parâmetros e insere os novos dados do filme na database.
			$stmt -> bindParam(":mov_title", $movie -> title);
			$stmt -> bindParam(":mov_description", $movie -> description);
			$stmt -> bindParam(":mov_image", $movie -> image);
			$stmt -> bindParam(":cat_id", $movie -> category);
			$stmt -> bindParam(":mov_trailer", $movie -> trailer);
			$stmt -> bindParam(":mov_length", $movie -> length);
			$stmt -> bindParam(":mov_id", $movie -> id);
			$stmt -> execute();
			
			// Redireciona o usuário, com uma mensagem de sucesso.
			$this -> message -> setMessage("Movie updated successfully!", "success", "dashboard.php");
		}
		
		// Função que remove o filme e as avaliaçãos do mesmo.
		public function destroy($id) {
			// Função FOR para remover as chaves estrangeiras primeiro.
			for ($i = 0; $i <= 2; $i++) {
				// Se $i for 1, remover as avaliaçãos do filme.
				if ($i == 1) $stmt = $this -> conn -> prepare("DELETE FROM reviews WHERE mov_id = :mov_id");

				// Se $i for 2, remover os dados do filme.
				else if ($i == 2) $stmt = $this -> conn -> prepare("DELETE FROM movies WHERE mov_id = :mov_id");
				
				if ($stmt) {
					$stmt -> bindParam(":mov_id", $id);
					$stmt -> execute();
				}
			}
			
			// Redireciona o usuário, com uma mensagem de sucesso.
			$this -> message -> setMessage("Film successfully deleted!", "success", "dashboard.php");
		}
	}