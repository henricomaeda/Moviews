<?php
	// Classe User (Usuário).
	class User {
		// Varíaveis públicas na classe Usuário.
		public $id;
		public $name;
		public $lastname;
		public $email;
		public $password;
		public $image;
		public $bio;
		public $token;
		
		// Função que retorna o nome completo do usuário.
		public function getFullName($user) {
			return $user -> name . " " . $user -> lastname;
		}
		
		// Função que retorna um token gerado a partir de um código hexadecimal de 50 bytes aleatórios.
		public function generateToken() {
			return bin2hex(random_bytes(50));
		}
		
		// Função que retorna uma senha criptograda a partir da senha do usuário.
		public function generatePassword($password) {
			return password_hash($password, PASSWORD_DEFAULT);
		}
		
		// Função que retorna um nome de imagem gerado a partir um código hexadecimal de 60 bytes aleatórios.
		public function imageGenerateName() {
			return bin2hex(random_bytes(60)) . ".jpg";
		}
	}
	
	// Interface UserDAOInterface.
	interface UserDAOInterface {
		
		// Funções públicas na UserDAOInterface.
		public function buildUser($data);
		public function create(User $user, $authUser = false);
		public function update(User $user, $redirect = true);
		public function verifyToken($protected = false);
		public function setTokenToSession($token, $redirect = true);
		public function authenticateUser($email, $password);
		public function findByEmail($email);
		public function findById($id);
		public function findByToken($token);
		public function destroyToken();
		public function changePassword(User $user);
	}