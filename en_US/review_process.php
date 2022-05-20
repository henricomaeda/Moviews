<?php
	// Inclue apenas uma vez os arquivos abaixo.
	require_once("../globals.php");
	require_once("../database.php");
	require_once("models/Movie.php");
	require_once("models/Review.php");
	require_once("models/Message.php");
	require_once("dao/UserDAO.php");
	require_once("dao/MovieDAO.php");
	require_once("dao/ReviewDAO.php");
	
	// Chama o construtor.
	$message = new Message($BASE_URL);
	$userDao = new UserDAO($conn, $BASE_URL);
	$movieDao = new MovieDAO($conn, $BASE_URL);
	$reviewDao = new ReviewDAO($conn, $BASE_URL);
	
	// Define a variável com o tipo do formulário.
	$type = filter_input(INPUT_POST, "type");
	
	// Verifica se o usuário está validado e retorna seus dados.
	$userData = $userDao -> verifyToken();
	
	// Verifica se o usuário está fazendo uma avaliação.
	if ($type === "create") {
		// Define as variáveis com os dados inseridos.
		$rating = filter_input(INPUT_POST, "rating");
		$review = filter_input(INPUT_POST, "review");
		$movies_id = filter_input(INPUT_POST, "movies_id");
		$users_id = $userData -> id;
		
		// Chama o construtor e cria uma nova avaliação.
		$reviewObject = new Review();
		$movieData = $movieDao -> findById($movies_id);
		
		// Valida se o filme existe.
		if ($movieData) {
			// Verifica se os dados estão inseridos.
			if (!empty($rating) && !empty($review) && !empty($movies_id)) {
				// Define os dados da nova avaliação.
				$reviewObject -> rating = $rating;
				$reviewObject -> review = $review;
				$reviewObject -> movies_id = $movies_id;
				$reviewObject -> users_id = $users_id;

				// Atualiza os dados da nova avaliação na database.
				$reviewDao -> create($reviewObject);
			} else $message -> setMessage("You need to enter your rating and comment!", "error", "back");
		} else $message -> setMessage("Invalid information!", "error", "index.php");
	} else $message -> setMessage("Invalid informations!", "error", "index.php");