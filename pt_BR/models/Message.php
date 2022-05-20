<?php
	// Classe Message (Mensagem).
	class Message {
		private $url;
		
		// Construtor público da classe.
		public function __construct($url) {
			$this -> url = $url;
		}
		
		// Função pública que define a mensagem e redireciona o usuário.
		public function setMessage($msg, $type, $redirect = "index.php") {
			$_SESSION["msg"] = $msg;
			$_SESSION["type"] = $type;
			
			if($redirect != "back") header("Location: $this->url" . $redirect);
			else header("Location: " . $_SERVER["HTTP_REFERER"]);
		}
		
		// Função pública que recebe a mensagem.
		public function getMessage() {
			if(!empty($_SESSION["msg"])) {
				return [
					"msg" => $_SESSION["msg"],
					"type" => $_SESSION["type"]
				];
			} else return false;
		}
		
		// Função pública que limpa a mensagem.
		public function clearMessage() {
			$_SESSION["msg"] = "";
			$_SESSION["type"] = "";
		}
	}