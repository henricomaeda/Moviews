<?php
	// Inclue apenas uma vez os arquivos abaixo.
	require_once("models/User.php");
	require_once("models/Message.php");
	
	// Classe UserDAO, implementando a Interface UserDAOInterface.
	class UserDAO implements UserDAOInterface {
		public $conn;
		private $url;
		private $message;
		
		// Construtor público da classe.
		public function __construct(PDO $conn, $url) {
			$this -> conn = $conn;
			$this -> url = $url;
			$this -> message = new Message($url);
		}
		
		// Função que criará a estrutura de dados do usuário.
		public function buildUser($data) {
			$user = new User();
			
			// Define os parâmetros.
			$user -> id = $data["use_id"];
			$user -> name = $data["use_name"];
			$user -> lastname = $data["use_lastname"];
			$user -> email = $data["use_email"];
			$user -> password = $data["use_password"];
			$user -> image = $data["use_image"];
			$user -> bio = $data["use_bio"];
			$user -> token = $data["use_token"];
			
			// Retorna a estrutura de dados.
			return $user;
		}
		
		// Função que envia os dados do usuário na database.
		public function create(User $user, $authUser = false) {
			$stmt = $this -> conn -> prepare("insert into users (use_name, use_lastname, use_email, use_password, use_token) values (:use_name, :use_lastname, :use_email, :use_password, :use_token)");
			
			// Define os parâmetros.
			$stmt -> bindParam(":use_name", $user -> name);
			$stmt -> bindParam(":use_lastname", $user -> lastname);
			$stmt -> bindParam(":use_email", $user -> email);
			$stmt -> bindParam(":use_password", $user -> password);
			$stmt -> bindParam(":use_token", $user -> token);
			$stmt -> execute();
			
			// Valida o token do usuário.
			if ($authUser) $this -> setTokenToSession($user -> token);
		}
		
		// Função que atualiza os dados do usuário na database.
		public function update(User $user, $redirect = true) {
			$stmt = $this -> conn -> prepare("update users set
				use_name = :use_name,
				use_lastname = :use_lastname,
				use_email = :use_email,
				use_image = :use_image,
				use_bio = :use_bio,
				use_token = :use_token
				WHERE use_id = :use_id
			");
			
			// Define os parâmetros.
			$stmt -> bindParam(":use_name", $user -> name);
			$stmt -> bindParam(":use_lastname", $user -> lastname);
			$stmt -> bindParam(":use_email", $user -> email);
			$stmt -> bindParam(":use_image", $user -> image);
			$stmt -> bindParam(":use_bio", $user -> bio);
			$stmt -> bindParam(":use_token", $user -> token);
			$stmt -> bindParam(":use_id", $user -> id);
			$stmt -> execute();

			// Redireciona o usuário, recebendo mensagem de sucesso.
			if ($redirect) $this -> message -> setMessage("Data successfully updated!", "success", "editprofile.php");
		}
		
		// Função que verifica se o usuário é validado.
		public function verifyToken($protected = false) {
			// Verifica se o token do usuário é validado.
			if (!empty($_SESSION["use_token"])) {
				$token = $_SESSION["use_token"];

				// Procura o token do usuário.
				$user = $this -> findByToken($token);
				
				// Se for validado, retornará o usuário.
				if ($user) return $user;

				// Se o usuário não for válidado, retornará o usuário para a tela principal.
				else if ($protected) $this -> message -> setMessage("Authenticate to access this page!", "error", "index.php");
			} else if ($protected) $this -> message -> setMessage("Authenticate to access this page!", "error", "index.php");
		}
		
		// Função que valida o usuário.
		public function setTokenToSession($token, $redirect = true) {
			// Valida o usuário com seu token.
			$_SESSION["use_token"] = $token;
			
			// Redireciona o usuário para o seu perfil.
			if ($redirect) $this -> message -> setMessage("Be very welcome!", "success", "editprofile.php");
		}
		
		// Função que autentica o usuário.
		public function authenticateUser($email, $password) {
			
			// Procura se o e-mail inserido é validado.
			$user = $this -> findByEmail($email);
			
			// Verifica se o e-mail do usuário é validado.
			if ($user) {

				// Verifica se a senha inserida é validada.
				if (password_verify($password, $user -> password)) {
					$token = $user -> generateToken();

					// Valida o token do usuário.
					$this -> setTokenToSession($token, false);
					$user -> token = $token;
					$this -> update($user, false);
					
					return true;
				} else return false;
			} else return false;
		}
		
		// Função que busca pelo e-mail do usuário.
		public function findByEmail($email) {
			if ($email != "") {
				$stmt = $this -> conn -> prepare("select * from users where use_email = :use_email");
				
				$stmt -> bindParam(":use_email", $email);
				$stmt -> execute();
				
				// Verifica se há e-mails com o e-mail inserido.
				if ($stmt -> rowCount() > 0) {
					$data = $stmt -> fetch();

					// Define a estrutura de dados do usuário.
					$user = $this -> buildUser($data);
					
					// Retorna a estrutura de dados do usuário.
					return $user;
				} else return false;
			} else return false;
		}
		
		// Função que busca pelo ID do usuário.
		public function findById($id) {
			if ($id != "") {
				$stmt = $this -> conn -> prepare("select * from users where use_id = :use_id");
				
				$stmt -> bindParam(":use_id", $id);
				$stmt -> execute();
				
				// Verifica se há IDs com o ID inserido.
				if ($stmt -> rowCount() > 0) {
					$data = $stmt -> fetch();
					$user = $this -> buildUser($data);
					
					// Retorna a estrutura de dados do usuário.
					return $user;
				} else return false;
			} else return false;
		}
		
		// Função que busca pelo token do usuário.
		public function findByToken($token) {
			if ($token != "") {
				$stmt = $this -> conn -> prepare("select * from users where use_token = :use_token");
				
				$stmt -> bindParam(":use_token", $token);
				$stmt -> execute();
				
				// Verifica se há tokens com o token inserido.
				if ($stmt -> rowCount() > 0) {
					$data = $stmt -> fetch();
					$user = $this -> buildUser($data);
					
					// Retorna a estrutura de dados do usuário.
					return $user;
				} else return false;
			} else return false;
		}
		
		// Função que destrói o token do usuário, desvalidando o mesmo.
		public function destroyToken() {
			$_SESSION["use_token"] = "";
			
			// Redireciona o usuário para a tela principal.
			$this -> message -> setMessage("You have successfully logged out!", "success", "index.php");
		}
		
		// Função que atualiza a senha do usuário.
		public function changePassword(User $user) {
			$stmt = $this -> conn -> prepare("update users set use_password = :use_password where use_id = :use_id");
			
			$stmt -> bindParam(":use_password", $user -> password);
			$stmt -> bindParam(":use_id", $user -> id);
			$stmt -> execute();
			
			// Redireciona o usuário para o seu perfil.
			$this -> message -> setMessage("Password changed successfully!", "success", "editprofile.php");
		}
	}