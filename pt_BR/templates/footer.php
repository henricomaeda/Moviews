		<?php
			// Verifica se o usuário está validado e retorna seus dados.
			$userData = $userDao -> verifyToken(false);
		?>
		<footer id="footer">
			<div id="social-container">
				<ul>
					<li>
						<!-- Exibe o ícone do Facebook -->
						<i class="fab fa-facebook-square"></i>
					</li>
					<li>
						<!-- Exibe o ícone do Instagram -->
						<i class="fab fa-instagram"></i>
					</li>
					<li>
						<!-- Exibe o ícone do YouTube -->
						<i class="fab fa-youtube"></i>
					</li>
				</ul>
			</div>
			<div id="footer-links-container">
				<ul>
					<!-- Exibe o botão de Fale Conosco -->
					<li><a href="contact_us.php"> Fale conosco </a></li>

					<!-- Verifica se o usuário está validado -->
					<?php if($userData): ?>
						<li class="nav-item">
							<a href="<?= $BASE_URL ?>editprofile.php" class="nav-link bold">
								<?= $userData -> name ?>
							</a>
						</li>
					<!-- Caso o usuário está esteja validado -->
					<?php else: ?>
						<li class="nav-item">
							<a href="<?= $BASE_URL ?>auth.php" class="nav-link bold">
								Conectar | Cadastrar
							</a>
						</li>
					<?php endif; ?>
					<!-- Exibe o botão de exibir os filmes do usuário -->
					<li><a href="dashboard.php"> Meus filmes </a></li>
				</ul>
			</div>
			<div id="footer-links-container">
				<p>
					&copy; 2022 Moviews
				</p>
			</div>
		</footer>
		
		<!-- Chama os BOOTSTRAP JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.js" integrity="sha512-KCgUnRzizZDFYoNEYmnqlo0PRE6rQkek9dE/oyIiCExStQ72O7GwIFfmPdkzk4OvZ/sbHKSLVeR4Gl3s7s679g==" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.css"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</body>
</html>