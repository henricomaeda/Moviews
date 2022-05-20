<?php
	// Inclue apenas uma vez os arquivos abaixo.
	require_once("../globals.php");
	require_once("../database.php");
	require_once("models/User.php");
	require_once("models/Message.php");
	require_once("dao/UserDAO.php");
	
	// Define as variáveis e chama o construtor.
	$message = new Message($BASE_URL);
	$userDao = new UserDAO($conn, $BASE_URL);
	$type = filter_input(INPUT_POST, "type");
	
	// Verifica se o usuário alterou seus dados.
	if ($type === "update") {
		
		// Verifica se o usuário está validado e retorna seus dados.
		$userData = $userDao -> verifyToken();
		
		// Define as variáveis com os novos dados inseridos.
		$name = filter_input(INPUT_POST, "name");
		$lastname = filter_input(INPUT_POST, "lastname");
		$email = filter_input(INPUT_POST, "email");
		$bio = filter_input(INPUT_POST, "bio");
		
		// Chama o construtor e cria um novo usuário.
		$user = new User();
		
		// Atualiza e define os novos dados do usuário.
		$userData -> name = $name;
		if ($lastname === "") $userData -> lastname = null;
		else $userData -> lastname = $lastname;
		$userData -> email = $email;
		if ($bio === "") $userData -> bio = null;
		else $userData -> bio = $bio;
		
		// Verifica se o usuário inseriu uma imagem para o mesmo.
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
				$imageName = $user -> imageGenerateName();

				// Cria o arquivo de imagem em formato jpeg no diretório.
				imagejpeg($imageFile, "../assets/users/" . $imageName, 100);
				$userData -> image = $imageName;
			} else $message -> setMessage("Invalid image type, please insert an png, jpeg or jpg file format!", "error", "back");
		}
		
		// Atualiza os novos dados do usuário na database.
		$userDao -> update($userData);
	// Verifica se o usuário alterou sua senha.
	} else if ($type === "changepassword") {
		// Define as variáveis com a nova senha inserida.
		$password = filter_input(INPUT_POST, "password");
		$confirmpassword = filter_input(INPUT_POST, "confirmpassword");

		// Verifica se o usuário está validado e retorna seus dados.
		$userData = $userDao -> verifyToken();
		$id = $userData -> id;
		
		// Verifica se os campos foram inseridos.
		if ($password && $confirmpassword) {
			// Verifica se a nova senha e a senha confirmada são as mesmas.
			if ($password == $confirmpassword) {
				$user = new User();
				
				// Criptografa a senha inserida.
				$finalPassword = $user -> generatePassword($password);

				// Atualiza a senha do usuário para a nova.
				$user -> password = $finalPassword;
				$user -> id = $id;
				$userDao -> changePassword($user);
			} else $message -> setMessage("The passwords are not the same!", "error", "back");
		} else $message -> setMessage("Please fill in all fields!", "error", "back");
	} else $message -> setMessage("Invalid information!", "error", "index.php");