<?php
	// Inclue apenas uma vez os arquivos abaixo.
	require_once("../globals.php");
	require_once("../database.php");
	require_once("models/User.php");
	require_once("models/Message.php");
	require_once("dao/UserDAO.php");
	
	// Chama o construtor.
	$message = new Message($BASE_URL);
	$userDao = new UserDAO($conn, $BASE_URL);

	// Define a variável com o tipo de formulário e erro de mensagem.
	$type = filter_input(INPUT_POST, "type");
	$errorMessage = "Please fill in all fields.";
	
	// Verifica se o usuário escolhou cadastrar um usuário.
	if ($type === "register") {
		// Define as variáveis com com os dados inseridos.
		$name = filter_input(INPUT_POST, "name");
		$lastname = filter_input(INPUT_POST, "lastname");
		$email = filter_input(INPUT_POST, "email");
		$password = filter_input(INPUT_POST, "password");
		$confirmpassword = filter_input(INPUT_POST, "confirmpassword");
		
		// Verifica se os dados das variáveis estão inseridos.
		if ($name && $email && $password) {

			// Verifica se a senha e a confirmada são as mesmas.
			if ($password === $confirmpassword) {

				// Chama o construtor e define a variável com a classe.
				$user = new User();
				$stmt = $conn -> prepare("select use_email from users");
				$stmt -> execute();

				// Verifica se há usuários criados.
				if ($stmt -> rowCount() == 0) {

					// Cria o usuário Administrador, caso não exista.
					$stmt = $conn -> prepare("insert into users (use_name, use_lastname, use_email, use_password, use_image, use_token, use_bio) VALUES ('Administrador', null, 'admin@etec.sp.gov.br', :use_password, null, null, null)");
					$stmt -> bindParam(":use_password", $user -> generatePassword("000000"));
					$stmt -> execute();
				}
				
				// Verifica se o usuário com esse e-mail não existe.
				if ($userDao -> findByEmail($email) === false) {
					
					// Valida o usuário, gerando um token.
					$userToken = $user -> generateToken();
					
					// Criptografa a senha.
					$finalPassword = $user -> generatePassword($password);
					
					// Define os dados do usuário.
					$user -> name = $name;
					if ($lastname === "") $user -> lastname = null;
					else $user -> lastname = $lastname;
					$user -> email = $email;
					$user -> password = $finalPassword;
					$user -> token = $userToken;
					$auth = true;
					
					// Atualiza os dados do novo usuário na database.
					$userDao -> create($user, $auth);
				} else $message -> setMessage("User already registered, try another email.", "error", "back");
			} else $message -> setMessage("The passwords are not the same.", "error", "back");
		} else $message -> setMessage($errorMessage, "error", "back");
	// Verifica se o usuário escolhou se conectar.
	} else if ($type === "login") {

		// Define as variáveis dos dados inseridos.
		$email = filter_input(INPUT_POST, "email");
		$password = filter_input(INPUT_POST, "password");
		
		// Verifica os dados inseridos estão definidos.
		if ($email && $password)
			// Autentica, validando, o usuário.
			if ($userDao -> authenticateUser($email, $password)) $message -> setMessage("Seja bem-vindo!", "success", "editprofile.php");
			else $message -> setMessage("Incorrect username and/or password.", "error", "back");
		else $message -> setMessage($errorMessage, "error", "back");
	} else $message -> setMessage("Invalid information!", "error", "index.php");