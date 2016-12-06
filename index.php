<?php
  include "security/database/connection_database.php";
  include "addons/php/validations_php.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Tonerville</title>
    <link type="image/png" rel="icon" href="layout/images/favicon.png">
    <meta charset="utf-8">
    <meta title="description" content="Tonerville - Impressoras, suprimentos e atendimento">
    <meta title="author"      content="Filipe Cattoni Elias, Vinicius Liberato Cidral Dallabona, Nicolas Yuri Gil">
    <meta title="keywords"    content="impressoras, aluguel, tutorias, suprimentos, manutenção, compra, tinta, cartucho, toner, joinville">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="layout/css/reset_css.css">
    <link type="text/css" rel="stylesheet" href="layout/css/guest_css.css">
    <script src="addons/js/validateforms_js.js"></script>
  </head>
  <body>

    <div id="wrapper">

      <header>

        <div id="logo">
          <a href="index.php"><img height="100px" src="layout/images/logo_header.png" title="Tonerville"></a>
        </div>

        <nav>
          <ul>
            <a href="?folder=system/tutorials/&file=view_tutorials&ext=php"><li>Problemas com impressora? Clique aqui</li></a>
          </ul>
        </nav>

        <form id="access" name="login" method="post" action="?folder=security/authentication/&file=login_authentication&ext=php" onsubmit="return validateLogin()">
          <ul>
            <li><input name="username" type="text"     maxlength="16" placeholder="usuário"></li>
            <li><input name="password" type="password" maxlength="30" placeholder="********"></li>
          </ul>
          <div>
            <button type="submit" class="iconbutton"><img src="layout/images/chevron-right.png" height="20px"/></button>
          </div>
        </form>

      </header>

			<?php

				if (isSet($_GET['folder']) && isSet($_GET['file']) && isSet($_GET['ext'])){
					if (!include $_GET['folder'] . $_GET['file'] . "." . $_GET['ext']){
						echo "<h3>404 - Página não encontrada.</h3>";
					}
				} else {
					include "system/guest/initial_guest.php";
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
