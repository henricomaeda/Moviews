<?php
	// Inclue apenas uma vez os arquivos abaixo.
	require_once("templates/header.php");
	require_once("models/Message.php");
	require_once("models/User.php");
	require_once("dao/UserDAO.php");
	
	// Verifica se o usuário está validado e retorna seus dados.
	$userData = $userDao -> verifyToken(true);

	// Chama o construtor.
	$user = new User();
	
	// Chave de acesso da API.
	$access_key = "300857b4-146e-4bc0-af3f-a25f96e6e159";

	// Recebe na variável o nome completo e e-mail do usuário.
	$user_fullname = $user -> getFullName($userData);
	$user_email = $userData -> email;
?>

<div id="main-container" class="container-fluid">
	<div class="col-md-12">
		<div class="row" id="auth-row">
			<div class="col-md-4" id="contact-container">
				<h2> Contact us </h2>
				<!-- Envio de e-mail da API -->
				<form action="https://api.staticforms.xyz/submit" method="POST">
					<!-- Chave de acesso da API -->
					<input type="hidden" name="accessKey" value="<?= $access_key ?>">
					
					<!-- O assunto do e-mail -->
					<input type="hidden" name="subject" value="Moviews (Fale conosco)">
					
					<!-- Nome do usuário -->
					<input type="hidden" name="$usuário" value="<?= $user_fullname ?>">
					
					<!-- E-mail do usuário -->
					<input type="hidden" name="$">
					<input type="hidden" name="$e-mail" value="<?= $user_email ?>">
					
					<!-- A mensagem que será enviada -->
					<input type="hidden" name="$ ">
					<div class="form-group">
						<label for="message"> Message: </label>
						<textarea class="form-control message" id="message" name="$mensagem" rows="6" cols="33" placeholder="Enter your message. . ."></textarea>
					</div>
					
					<!-- O tipo de mensagem -->
					<input type="hidden" name="$  ">
					<div class="form-group">
						<label for="type_message"> My message is: </label>
						<select class="form-control" id="type_message" name="$observação">
							<option value="A mensagem é um comentário."> a Comment </option>
							<option value="A mensagem é uma reclamação."> a Complaint </option>
							<option value="A mensagem é uma sugestão."> a Suggestion </option>
							<option value="A mensagem não é um comentário, uma reclamação e nem uma sugestão."> None of the options </option>
						</select>
					</div>
					
					<!-- Página que vai acessar -->
					<input type="hidden" name="redirectTo" value="<?=$BASE_URL ?>contact_sucess.php">
					
					<!-- Botão para confirmar -->
					<input type="submit" class="btn card-btn" value="Send message">
				</form>
			</div>
		</div>
	</div>
</div>

<?php
	// Inclue apenas uma vez o footer.
	require_once("templates/footer.php");
?>