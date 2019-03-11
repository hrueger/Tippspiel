<?php 
	require_once("./include/lib.inc.php"); 
	require_once("./include/db.inc.php"); 
	require_once("./include/login.inc.php"); 


?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Die 3 Meta-Tags oben *müssen* zuerst im head stehen; jeglicher sonstiger head-Inhalt muss *nach* diesen Tags kommen -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="./images/favicon.png">

    <title>AG-Tippspiel</title>

    <!-- Bootstrap-CSS -->
    <link href="./include/lib/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- Besondere Stile für diese Vorlage -->
    <link href="./styles/main.css" rel="stylesheet">

   <style>
	@media (min-width: 768px) {
		.container {
		max-width: 730px;
		}
	} 
	</style>

    <!-- Unterstützung für Media Queries und HTML5-Elemente in IE8 über HTML5 shim und Respond.js -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right" role="tablist">
            <li role="presentation"><a href="./index.php">Home</a></li>
            <?php if (!$loggedin) { ?>
            <li role="presentation"><a href="./login.php">Einloggen</a></li>
            <li role="presentation"><a href="./neuer_benutzer.php">Registrieren</a></li>
			<?php } else { ?>
			<li role="presentation" class="active" ><a href="./logout.php">Abmelden</a></li>
			<li role="presentation"><a href="./spielplan.php#tab1">Spielplan</a></li>
            <li role="presentation" class=""><a href="./weltmeister.php">Weltmeister</a></li>
			<?php } ?>
			<li role="presentation"><a href="./bestenliste.php#tab4">Bestenliste</a></li>
            <li role="presentation"><a href="./regeln.php">Regeln</a></li>
          </ul>
        </nav>
        <!--<h3 class="text-muted">Projekt-Titel</h3>-->
		<img class="img img-responsive" src="./images/header.png">
      </div>

      <div class="jumbotron">
        <h1>Das AG tippt`s!</h1> 
		<br>
		<?php
			
			if (isset($_POST["logout"])) {
				
				//if (ini_get("session.use_cookies")) {
				//	$params = session_get_cookie_params();
				//	setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
				//}

				// Zum Schluß, löschen der Session.
				//session_destroy();
				$_SESSION["loggedin"] = false;
				$_SESSION["userid"] = null;
				
				alert("success", "Du wurdest erfolgreich ausgeloggt!");
				
			} else if (isset($_POST["stay"])) {
				
				header("Location: index.php");
				
			} else {
			
			
			
			
			
			
			
			//echo "<pre>";
			//var_dump($_REQUEST);
			//echo "</pre>";
		?>
		
		
        <br>
		<form class="form-horizontal" method="post">
			
			
			
			<h3>Bist du sicher, dass du dich ausloggen möchtest?</h3>
			<div class="form-group">
				<div class="">
					<input type="submit" name="logout" value="Ja, ausloggen" class="btn btn-danger">
					<input type="submit" name="stay" value="Nein, hier bleiben" class="btn btn-success">
				</div>
			</div>
			
		</form>
        
		
			<?php  } ?>
		
		
		
		
		
      </div>
	<!--
      <div class="row marketing">
        <div class="col-lg-6">
          <h4>Unter-Überschrift</h4>
          <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>

          <h4>Unter-Überschrift</h4>
          <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>

          <h4>Unter-Überschrift</h4>
          <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
        </div>

        <div class="col-lg-6">
          <h4>Unter-Überschrift</h4>
          <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>

          <h4>Unter-Überschrift</h4>
          <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>

          <h4>Unter-Überschrift</h4>
          <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
        </div>
      </div>-->

      <footer class="footer">
        <p>&copy; AG-Multimedia des Allgäu-Gymnasiums 2018. Alle Rechte vorbehalten. </p>
      </footer>

    </div> <!-- /container -->


    <!-- IE10-Anzeigefenster-Hack für Fehler auf Surface und Desktop-Windows-8 -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
