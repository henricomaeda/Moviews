<?php
	// Inclue apenas uma vez os arquivos abaixo.
	require_once("models/Review.php");
	require_once("models/Message.php");
	require_once("dao/UserDAO.php");
	
	// Classe ReviewDao, implementando a Interface ReviewDAOInterface.
	class ReviewDao implements ReviewDAOInterface {
		private $conn;
		private $url;
		private $message;
		
		// Construtor público da classe.
		public function __construct(PDO $conn, $url) {
			$this -> conn = $conn;
			$this -> url = $url;
			$this -> message = new Message($url);
		}
		
		// Função que criará a estrutura de dados da avaliação.
		public function buildReview($data) {
			$reviewObject = new Review();
			
			$reviewObject -> id = $data["rev_id"];
			$reviewObject -> rating = $data["rev_rating"];
			$reviewObject -> review = $data["rev_review"];
			$reviewObject -> users_id = $data["use_id"];
			$reviewObject -> movies_id = $data["mov_id"];
			
			// Retorna a estrutura com os dados
			return $reviewObject;
		}
		
		// Função que enviará os dados da avaliação na database.
		public function create(Review $review) {
			$stmt = $this -> conn -> prepare("insert into reviews (
				rev_rating, rev_review, mov_id, use_id
			) values (
				:rev_rating, :rev_review, :mov_id, :use_id
			)");
			
			$stmt -> bindParam(":rev_rating", $review -> rating);
			$stmt -> bindParam(":rev_review", $review -> review);
			$stmt -> bindParam(":mov_id", $review -> movies_id);
			$stmt -> bindParam(":use_id", $review -> users_id);
			$stmt -> execute();
			
			// Mensagem de sucesso por adicionar a avaliação.
			$this -> message -> setMessage("Your review has been added successfully!", "success", "index.php");
		}
		
		// Função que recebe os dados da avaliação.
		public function getMoviesReview($id) {
			$reviews = [];
			
			$stmt = $this -> conn -> prepare("select * from reviews where mov_id = :mov_id");
			$stmt -> bindParam(":mov_id", $id);
			$stmt -> execute();
			
			// Verifica se há avaliaçãos.
			if ($stmt -> rowCount() > 0) {
				$reviewsData = $stmt -> fetchAll();
				$userDao = new UserDao($this -> conn, $this -> url);
				
				foreach($reviewsData as $review) {
					$reviewObject = $this -> buildReview($review);
					
					// Chama os dados do usuário.
					$user = $userDao -> findById($reviewObject -> users_id);
					
					$reviewObject -> user = $user;
					$reviews[] = $reviewObject;
				}
			}
			
			// Retorna os dados da avaliação.
			return $reviews;
		}
		
		// Função que verifica se o usuário já fez uma avaliação.
		public function hasAlreadyReviewed($id, $userId) {
			$stmt = $this -> conn -> prepare("select mov_id, use_id from reviews where mov_id = :mov_id and use_id = :use_id");
			
			$stmt -> bindParam(":mov_id", $id);
			$stmt -> bindParam(":use_id", $userId);
			$stmt -> execute();
			
			// Verifica se o usuário fez avaliação, se sim, retornará verdadeiro.
			if ($stmt -> rowCount() > 0) return true;
			
			// Caso o usuário não tenha feito nenhuma avaliação, retornará falso.
			else return false;
		}
		
		// Função que pegará as avaliações e fará uma média.
		public function getRatings($id) {
			$stmt = $this -> conn -> prepare("select rev_rating from reviews where mov_id = :mov_id");
			$stmt -> bindParam(":mov_id", $id);
			$stmt -> execute();
			
			// Verifica se o filme possui avaliações.
			if ($stmt -> rowCount() > 0) {
				$rating = 0;
				$reviews = $stmt -> fetchAll();
				
				// Soma todas as avalições na variável $rating.
				foreach($reviews as $review) {
					$rating += $review["rev_rating"];
				}
				
				// Divide a soma de todas as avaliações pela sua quantidade.
				$rating = $rating / count($reviews);
			} else  $rating = "Not rated";
			
			// Retorna a média das avaliações.
			return $rating;
		}
	}