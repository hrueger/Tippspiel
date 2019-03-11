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
            <li role="presentation" class="active"><a href="./index.php">Home</a></li>
			<?php if (!$loggedin) { ?>
            <li role="presentation"><a href="./login.php">Einloggen</a></li>
            <li role="presentation"><a href="./neuer_benutzer.php">Registrieren</a></li>
			<?php } else { ?>
			<li role="presentation"><a href="./logout.php">Abmelden</a></li>
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
        <!--<h1>Das AG tippt`s!</h1>-->
		<img class="img img-responsive" src="./images/logo_big.jpg"><br>
        
		<h1>&#1043;&#1086;&#1083;! &#1043;&#1086;&#1083;! &#1043;&#1086;&#1083;!</h1>
		
		<?php
		if ($loggedin) {
			$db = connect();
			$userid = $db->real_escape_string($_SESSION["userid"]);
			$res = $db->query("SELECT worldchampion FROM users WHERE id=$userid");
			$wm = "noch nicht getippt";
			$wmbanner = true;
			if ($res) {
				$res = $res->fetch_all(MYSQLI_ASSOC);
				if ($res) {
					$res = $res[0];
					if ($res) {
						//$wm = (isset($res["worldchampion"])) ? $res["worldchampion"] : "noch nicht getippt";
						if (isset($res["worldchampion"])) {
							$short = $db->real_escape_string($res["worldchampion"]);
							$res = $db->query("SELECT * FROM `teams` WHERE `short` = '$short'");
							echo $db->error;
							if ($res) {
								$res = $res->fetch_all(MYSQLI_ASSOC);
								if ($res) {
									$res = $res[0];
									if ($res) {
										if (isset($res["name"])) {
											$wm = $res["name"];
											$wmbanner = false;
											
											
											
										}
										
									} 
								}
							}
						}
					} 
				}
			}
		
			if ($wmbanner) {
				
				$res = $db->query("SELECT * FROM matches ORDER BY `date` ASC LIMIT 1");
				echo $db->error;
				if (!$res) {
					alert("danger", "Es wurden keine Spiele gefunden!");
				} else {
					$res = $res->fetch_all(MYSQLI_ASSOC);
					if (!$res) {
						alert("danger", "Es wurden keine Spiele gefunden!");
					} else {

						$start_date = new DateTime("@".strtotime($res[0]["date"]));
						if (new DateTime("NOW") < $start_date) {
							 $wmbanner = true;

						} else {
							$wmbanner = false;
						}
					}
				}
			}
				
		?>
		<h2>Willkommen <?php echo $_SESSION["nickname"]; ?></h2><br>
		<p class="lead">Du hast folgenden Weltmeister getippt: <i><?php echo $wm; ?></i></p>
		  <?php 
			if ($wmbanner) {
				alert("warning", "<h3>Du hast noch keinen Welmeister getippt!</h3><br>Klicke jetzt <a href='./weltmeister.php'>HIER</a> um noch auf eine Mannschaft als Weltmeister zu setzen und bei Erfolg noch mal <b>80 Punkte</b> dazu zu erhalten!");
			} 
		  ?>
		<p class="lead">Hier kannst du deine Tipps abgeben und die Ergebnisse ansehen:</p>
		<p><a class="btn btn-lg btn-primary" href="./spielplan.php#tab1" role="button">Spielplan ansehen</a></p>
		<p><a class="btn btn-lg btn-success" href="./bestenliste.php#tab4" role="button">Bestenliste ansehen</a></p>
        
		
		<?php } else { ?>
		
		<h2>Das AG tippt`s</h2>
		<p class="lead">Melde dich jetzt an, spiele mit und gewinne mit etwas Glück einen der vielen Preise!</p>
        <p><a class="btn btn-lg btn-primary" href="./login.php" role="button">Einloggen</a></p>
        <p><a class="btn btn-lg btn-success" href="./neuer_benutzer.php" role="button">Heute noch anmelden</a></p>
        
		
		<?php } ?>
		
		<br><br>
		<small>Das rein nicht-kommerzielle Tippspiel zur Fußball-Weltmeisterschaft des Allgäu-Gymnasiums</small>
      </div>
	

      <footer class="footer">
        <p>&copy; AG-Multimedia des Allgäu-Gymnasiums 2018. Alle Rechte vorbehalten. </p>
      </footer>

    </div> <!-- /container -->


    <!-- IE10-Anzeigefenster-Hack für Fehler auf Surface und Desktop-Windows-8 -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
