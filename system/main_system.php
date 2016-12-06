<?php
	session_start();
	include "../security/setup_security.php";
	include "../security/database/connection_database.php";
	include "../addons/php/validations_php.php";
	include "../addons/php/safedelete_php.php";
	include "../addons/php/operationsdb_php.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Tonerville</title>
		<link type="image/png" rel="icon" href="../layout/images/favicon.png">
		<meta charset="utf-8">
		<meta title="description" content="Tonerville - Impressoras, suprimentos e atendimento">
		<meta title="author"      content="Filipe Cattoni Elias, Vinicius Liberato Cidral Dallabona, Nicolas Yuri Gil">
		<meta title="keywords"    content="impressoras, aluguel, tutorias, suprimentos, manutenção, compra, tinta, cartucho, toner, joinville">
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="../layout/css/reset_css.css">
		<link type="text/css" rel="stylesheet" href="../layout/css/guest_css.css">
		<link type="text/css" rel="stylesheet" href="../layout/css/jquery-ui.min.css">
		<!-- scripts -->
		<script src="../addons/js/jquery-3.1.1.min.js"></script>
		<script src="../addons/js/jquery-ui.min.js"></script>
		<script src="../addons/js/datepicker_js.js"></script>
		<script src="../addons/js/confirmdelete_js.js"></script>
		<script src="../addons/js/validateforms_js.js"></script>
		<script src="../addons/js/catchcontent_js.js"></script>
		<script src="../addons/js/jquery.mask.min.js"></script>
		<script src="../addons/js/defaultmasks_js.js"></script>
		<script>
			$(function(){
				$(".datepicker").datepicker({
					changeMonth: true,
					changeYear:  true
				});
			});
		</script>
	</head>
	<body>

		<div id="wrapper">

			<header id="backend_header">

				<div id="logo">
					<a href="?"><img height="100px" src="../layout/images/logo_header.png" title="Tonerville"></a>
				</div>
				
				<?php
					// Exibe o header correto baseado na permissão do cliente
					switch ($_SESSION['permission']) {
						case 0: // admin
							?>
							<nav>
								<ul>
						<span>
							<li>Registros
								<ul class="dropdown dropdown8">
									<a href="?folder=users/employees/&file=fmins_employees&ext=php">
										<li>Operacional</li>
									</a>
									<a href="?folder=users/admin/&file=fmins_admin&ext=php">
										<li>Administrador</li>
									</a>
									<a href="?folder=users/clients/&file=fmins_clients&ext=php">
										<li>Cliente</li>
									</a>
									<a href="?folder=brands/&file=fmins_brands&ext=php">
										<li>Marca</li>
									</a>
									<a href="?folder=models/&file=fmins_models&ext=php">
										<li>Modelo</li>
									</a>
									<a href="?folder=printers/&file=fmins_printers&ext=php">
										<li>Impressora</li>
									</a>
									<a href="?folder=categories/&file=fmins_categories&ext=php">
										<li>Categoria</li>
									</a>
									<a href="?folder=tutorials/&file=fmins_tutorials&ext=php">
										<li>Tutorial</li>
									</a>
								</ul>
							</li>
						</span>
						<span>
							<li>Solicitações
								<ul class="dropdown dropdown3">
									<a href="?folder=solicitations/&file=view_solicitations&ext=php">
										<li>Ativas</li>
									</a>
									<a href="?folder=solicitations/&file=history_solicitations&ext=php">
										<li>Histórico</li>
									</a>
									<a href="?folder=solicitations/shared/&file=change_permission_solicitations&ext=php">
										<li>Compartilhada</li>
									</a>
								</ul>
							</li>
						</span>
						<span>
							<li>Aluguéis
								<ul class="dropdown dropdown3">
									<a href="?folder=rentals/&file=fmins_rentals&ext=php">
										<li>Novo</li>
									</a>
									<a href="?folder=rentals/&file=admin_view_rentals&ext=php">
										<li>Ativos</li>
									</a>
									<a href="?folder=rentals/&file=history_rentals&ext=php">
										<li>Histórico</li>
									</a>
								</ul>
							</li>
						</span>
								</ul>
							</nav>
							<?php
							break;
						case 1: // operacional
							?>
							<nav>
								<ul>
						<span>
							<li>Registros
								<ul class="dropdown dropdown5">
									<a href="?folder=brands/&file=fmins_brands&ext=php">
										<li>Marca</li>
									</a>
									<a href="?folder=models/&file=fmins_models&ext=php">
										<li>Modelo</li>
									</a>
									<a href="?folder=printers/&file=fmins_printers&ext=php">
										<li>Impressora</li>
									</a>
									<a href="?folder=categories/&file=fmins_categories&ext=php">
										<li>Categoria</li>
									</a>
									<a href="?folder=tutorials/&file=fmins_tutorials&ext=php">
										<li>Tutorial</li>
									</a>
								</ul>
							</li>
						</span>
						<span>
							<li>Solicitações
								<ul class="dropdown dropdown3">
									<a href="?folder=solicitations/&file=view_solicitations&ext=php">
										<li>Ativas</li>
									</a>
									<a href="?folder=solicitations/&file=history_solicitations&ext=php">
										<li>Histórico</li>
									</a>
									<a href="?folder=solicitations/shared/&file=change_permission_solicitations&ext=php">
										<li>Compartilhada</li>
									</a>
								</ul>
							</li>
						</span>
						<span>
							<li>Aluguéis
								<ul class="dropdown dropdown2">
									<a href="?folder=rentals/&file=admin_view_rentals&ext=php">
										<li>Ativos</li>
									</a>
									<a href="?folder=rentals/&file=history_rentals&ext=php">
										<li>Histórico</li>
									</a>
								</ul>
							</li>
						</span>
								</ul>
							</nav>
							<?php
							break;
						case 2: // cliente
							?>
							<nav>
								<ul>
						<span>
							<li>Solicitações
								<ul class="dropdown dropdown2">
									<a href="?folder=solicitations/&file=fmins_solicitations&ext=php">
										<li>Ativas</li>
									</a>
									<a href="?folder=solicitations/&file=client_history_solicitations&ext=php">
										<li>Histórico</li>
									</a>
								</ul>
							</li>
						</span>
									<a href="?folder=rentals/&file=client_view_rentals&ext=php">
										<li>Aluguel</li>
									</a>
									<a href="?folder=tutorials/&file=view_tutorials&ext=php">
										<li>Tutoriais</li>
									</a>
								</ul>
							</nav>
							<?php
							break;
						case 3: // compartilhado
							?>
							<nav></nav>
							<?php
							break;
						default:
							header("Location: ../security/authentication/logout_authentication.php");
							break;
					}
				?>

				<form id="access">
					<ul>
						<li><?php
								if($_SESSION['permission'] != 3) {
									echo $_SESSION['username'];
								}else{
									echo "Compartilhada";
								}
							?></li>
						<li><a href="../security/authentication/logout_authentication.php">Sair</a></li>
					</ul>
				</form>

			</header>

			<?php

				if (@isSet($_GET['folder']) && isSet($_GET['file']) && isSet($_GET['ext'])) {
					if (@!include $_GET['folder'] . $_GET['file'] . "." . $_GET['ext']) {
						echo "<h4>404 - Página não encontrada.</h4>";
					}
				} else {
					?>
					<div class="center_box">
						<h1><?php echo isset($_GET['msg']) ? $_GET['msg'] : 'Bem vindo, ' . $_SESSION['username'] . '!' ?></h1>
					</div>
					<?php
				}

			?>

		</div>

		<footer>
			<ul>
				<li>Assistência Técnica | Toners | Outsourcing de Impressão - ©2016 Tonerville</li>
				<li>Ligue: 47 <b>3438 0202</b> | <b>9974 0270</b></li>
				<li>E-mail: <b>tonerville@tonerville.com.br</b></li>
			</ul>
		</footer>
	</body>
</html>
