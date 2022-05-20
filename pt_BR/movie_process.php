<?php
	// Inclue apenas uma vez os arquivos abaixo.
	require_once("../globals.php");
	require_once("../database.php");
	require_once("models/Movie.php");
	require_once("models/Message.php");
	require_once("dao/UserDAO.php");
	require_once("dao/MovieDAO.php");
	
	// Chama o construtor e define o tipo de formulário.
	$message = new Message($BASE_URL);
	$userDao = new UserDAO($conn, $BASE_URL);
	$movieDao = new MovieDAO($conn, $BASE_URL);
	$type = filter_input(INPUT_POST, "type");
	
	// Verifica se o usuário está validado e retorna seus dados.
	$userData = $userDao -> verifyToken();
	
	// Verifica o usuário está incluindo um filme.
	if ($type === "create") {
		// Define as variáveis para os dados do novo filme.
		$title = filter_input(INPUT_POST, "title");
		$description = filter_input(INPUT_POST, "description");

		// Verifica se o link do trailer está válido.
		$trailer = filter_input(INPUT_POST, "trailer");
		if ($trailer) {
			if (!strpos($trailer, "embed")) {
				$trailer = str_replace("youtube.com/", "youtube.com/embed/", $trailer);
				$trailer = str_replace("youtu.be/", "youtube.com/embed/", $trailer);
				$trailer = str_replace("embed/watch?v=", "embed/", $trailer);
			}
		}

		$category = filter_input(INPUT_POST, "category");
		$length = filter_input(INPUT_POST, "length");

		// Chama o construtor e cria um novo filme.
		$movie = new Movie();
		
		// Verifica se os dados foram inseridos.
		if (!empty($title) && !empty($description) && !empty($category)) {

			// Define os dados do novo filme.
			$movie -> title = $title;
			$movie -> description = $description;
			$movie -> trailer = $trailer;
			$movie -> category = $category;
			if ($length) $movie -> length = $length;
			else $movie -> length = 0;
			$movie -> users_id = $userData -> id;
			
			// Verifica se o usuário inseriu uma imagem para o novo filme.
			if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
				$image = $_FILES["image"];
				$imageTypes = ["image/jpeg", "image/jpg", "image/png"];
				$jpgArray = ["image/jpeg", "image/jpg"];
			
				// Verifica se o formato de arquivo é o mesmo da array.
				if (in_array($image["type"], $imageTypes)) {
					if (in_array($image["type"], $jpgArray)) {
						// Cria uma nova imagem a partir do arquivo.
						$imageFile = imagecreatefromjpeg($image["tmp_name"]);
					} else $imageFile = imagecreatefrompng($image["tmp_name"]);
				
					// Define o nome do arquivo da imagem.
					$imageName = $movie -> imageGenerateName();

					// Cria o arquivo de imagem em formato jpeg no diretório.
					imagejpeg($imageFile, "../assets/movies/" . $imageName, 100);
					$movie -> image = $imageName;
				} else $message -> setMessage("Tipo inválido de imagem, insira com um formato de arquivo em png, jpeg ou jpg!", "error", "back");
			}
			
			// Atualiza os dados do novo filme na database.
			$movieDao -> create($movie);
		} else $message -> setMessage("Você precisa adicionar pelo menos: título, descrição e categoria!", "error", "back");
	// Verifica o usuário está removendo um filme.
	} else if ($type === "delete") {
		// Verifica e define os dados do filme.
		$id = filter_input(INPUT_POST, "id");
		$movie = $movieDao -> findById($id);
		
		// Verifica se o filme é validado.
		if ($movie) {
			// Verifica se o filme que será removido é o mesmo dos dados.
			if ($movie -> users_id === $userData -> id) {
				// Remove os dados do filme e da database.
				$movieDao -> destroy($movie -> id);
			} else $message -> setMessage("Informações inválidas!", "error", "index.php");
		} else $message -> setMessage("Informações inválidas!", "error", "index.php");
	// Verifica o usuário está alterando os dados de um filme.
	} else if ($type === "update") {
		// Define as variáveis para os novos dados do filme.
		$title = filter_input(INPUT_POST, "title");
		$description = filter_input(INPUT_POST, "description");
		
		// Verifica se o link do trailer está válido.
		$trailer = filter_input(INPUT_POST, "trailer");
		if ($trailer) {
			if (!strpos($trailer, "embed")) {
				$trailer = str_replace("youtube.com/", "youtube.com/embed/", $trailer);
				$trailer = str_replace("youtu.be/", "youtube.com/embed/", $trailer);
				$trailer = str_replace("embed/watch?v=", "embed/", $trailer);
			}
		}

		$category = filter_input(INPUT_POST, "category");
		$length = filter_input(INPUT_POST, "length");
		$id = filter_input(INPUT_POST, "id");

		// Encontra e define os dados do filme.
		$movieData = $movieDao -> findById($id);
		
		// Verifica se o filme é validado.
		if ($movieData) {
			// Verifica se o filme que será atualizado é o mesmo dos dados.
			if ($movieData -> users_id === $userData -> id) {
				if (!empty($title) && !empty($description) && !empty($category)) {
					// Atualiza os dados antigos para os novos.
					$movieData -> title = $title;
					$movieData -> description = $description;
					$movieData -> trailer = $trailer;
					$movieData -> category = $category;
					if ($length) $movieData -> length = $length;
					else $movieData -> length = 0;
					
					// Verifica se o usuário inseriu uma imagem para o filme.
					if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
						$image = $_FILES["image"];
						$imageTypes = ["image/jpeg", "image/jpg", "image/png"];
						$jpgArray = ["image/jpeg", "image/jpg"];
						
						// Verifica se o formato de arquivo é o mesmo da array.
						if (in_array($image["type"], $imageTypes)) {
							// Cria uma nova imagem a partir do arquivo se o formato for o mesmo.
							if (in_array($image["type"], $jpgArray)) $imageFile = imagecreatefromjpeg($image["tmp_name"]);
							else $imageFile = imagecreatefrompng($image["tmp_name"]);
							
							// Chama o construtor.
							$movie = new Movie();

							// Define o nome do arquivo da imagem.
							$imageName = $movie -> imageGenerateName();

							// Cria o arquivo de imagem em formato jpeg no diretório.
							imagejpeg($imageFile, "../assets/movies/" . $imageName, 100);
							$movieData -> image = $imageName;
						} else $message -> setMessage("Tipo inválido de imagem, insira png ou jpg!", "error", "back");
					}
					
					// Atualiza os dados na database.
					$movieDao -> update($movieData);
				} else $message -> setMessage("Você precisa adicionar pelo menos: título, descrição e categoria!", "error", "back");
			} else $message -> setMessage("Informações inválidas!", "error", "index.php");
		} else $message -> setMessage("Informações inválidas!", "error", "index.php");
	} else $message -> setMessage("Informações inválidas!", "error", "index.php");