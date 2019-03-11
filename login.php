<?php 
	require_once("./include/lib.inc.php"); 
	require_once("./include/db.inc.php"); 

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
            <li role="presentation" class="active" ><a href="./login.php">Einloggen</a></li>
            <li role="presentation"><a href="./neuer_benutzer.php">Registrieren</a></li>
			<?php } else { ?>
			<li role="presentation"><a href="./logout.php">Abmelden</a></li>
			<li role="presentation"><a href="./spielplan.php#tab1">Spielplan</a></li>
            <li role="presentation" class=""><a href="./weltmeister.php">Weltmeister</a></li>
			<?php } ?>
			<li role="presentation"><a href="./bestenliste.php#tab4">Bestenliste</a></li>
            <li role="presentation"><a href="./regeln.php"> Regeln</a></li>
          </ul>
        </nav>
        <!--<h3 class="text-muted">Projekt-Titel</h3>-->
		<img class="img img-responsive" src="./images/header.png">
      </div>

      <div class="jumbotron">
        <h1>Das AG tippt`s!</h1> 
		<br>
		<?php
			//// ToDo: Nickname vorhanden check bei der Registrierung
			if (isset($_POST["nickname"]) &&
			isset($_POST["password"]) &&
			!empty(trim($_POST["nickname"])) &&
			!empty(trim($_POST["password"]))) {
				
				$db = connect();
				
				$nickname = $db->real_escape_string($_POST["nickname"]);
				$res = $db->query("SELECT * FROM users WHERE nickname='$nickname'");
				
				if (!$res) {
					alert("danger", "Bitte überprüfe deinen Nicknamen!");
				} else {
					$res = $res->fetch_all(MYSQLI_ASSOC);
					if (!$res) {
						alert("danger", "Bitte überprüfe deinen Nicknamen!");
					} else {
						$res = $res[0];
						if (!$res) {
							alert("danger", "Bitte überprüfe deinen Nicknamen!");
						} else {
							$password = $res["password"];
							$status = password_verify($_POST["password"], $password);
							
							if ($status) {
								// erfolgreich eingeloggt!!!
								if ($res["checked"] == -1) {
									alert("warning", "<b>Dein Account wurde leider blockiert.</b><br>Bitte registriere dich erneut mit deinem richtigen Namen und deiner echten Klasse.<br>Du kannst nur teilnehmen, wenn du Schüler oder Lehrer des Allgäu-Gymnasiums bist.");
									die();
								}
									
								
								
								$_SESSION["loggedin"] = true;
								$_SESSION["nickname"] = $res["nickname"];
								$_SESSION["userid"] = $res["id"];
								
								header("Location: index.php");
							} else {
								alert("danger", "Bitte überprüfe dein Passwort!");
							}
						}
						
					}
					
				}
			} else if (isset($_GET["password_lost"])) {
				alert("info", "<b>Ein neues Passwort muss persönlich bei Herr Herz abgegeben werden.</b><br>Dieser ist i.d.R. in der Pause im Lehrerzimmer oder im Seminarraum 419 zu erreichen.");
			}
			
			
			
			$nickname = (isset($_POST["nickname"])) ? $_POST["nickname"] : "";
			$password = (isset($_POST["password"])) ? $_POST["password"] : "";
			
			if (empty(trim($password)) XOR empty(trim($nickname))) {	
				alert("danger", "Bitte überprüfe deine Zugangsdaten!");
			}
			
			
			
			
			
			
			//echo "<pre>";
			//var_dump($_REQUEST);
			//echo "</pre>";
		?>
		
		<h3>Jetzt einloggen!</h3>
        <br>
		<form class="form-horizontal" method="post">
			
			
			
			<div class="form-group">
				<label for="nickname" class="col-sm-2 control-label">Nickname</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="nickname" required autofocus value="<?php echo $nickname; ?>" name="nickname" placeholder="Nickname">
				</div>
			</div>
			<div class="form-group">
				<label for="password" class="col-sm-2 control-label">Passwort</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" id="password" required name="password" placeholder="Passwort">
				</div>
			</div>
			
			
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" value="Einloggen" class="btn btn-primary"><br>
					<a href="login.php?password_lost">Passwort vergessen</a>
				</div>
			</div>
			
		</form>
        
		
			<?php  ?>
		
		
		
		
		
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
