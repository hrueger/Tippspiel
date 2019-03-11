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
			<li role="presentation"><a href="./logout.php">Abmelden</a></li>
			<li role="presentation"><a href="./spielplan.php#tab1">Spielplan</a></li>
			<li role="presentation" class="active"><a href="./weltmeister.php">Weltmeister</a></li>
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
        
		<?php 
			if (isset($_POST["submit"])) {
				if (isset($_POST["team"])) {
					
					$db = connect();
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
								$wc = $db->real_escape_string($_POST["team"]);
								$userid = $db->real_escape_string($_SESSION["userid"]);
								$db->query("UPDATE users SET worldchampion='$wc' WHERE id=$userid");
								alert("success", "Dein neuer Weltmeister wurde erfolgreich gespeichert!");
								echo "<br><a class='btn btn-primary' href='./spielplan.php'>Zurück zum Spielplan</a>";
							} else {
								alert("danger", "Da das erste Spiel schon begonnen hat, kannst du deinen Weltmeister nicht mehr ändern!");
								echo "<br><a class='btn btn-primary' href='./spielplan.php'>Zurück zum Spielplan</a>";
							}
						}
					}
					
					
					
					
				} else {
					alert("danger", "Bitte gebe alle Daten an!");
				}
			} else {
			
				$db = connect();
				$userid = $db->real_escape_string($_SESSION["userid"]);
				$res = $db->query("SELECT worldchampion FROM users WHERE id=$userid");
				if (!$res) {
					$team = "RUS";
				} else {
					$res = $res->fetch_all(MYSQLI_ASSOC)[0];
					if (!$res) {
						$team = "RUS";
					} else {
						
						$team = $res["worldchampion"];
					}
				}
			
		?>
		<h2>Wähle den Weltmeister!</h2>
		
		
		
		
		<p class="">Bis eine Minute vor Beginn des ersten Spiels, also bis <b>Donnerstag, 14.06.2018, um 16:59 Uhr</b>, kannst du den Weltmeister tippen.</p>
		
		<form class="form-horizontal" method="post">
				
			<div class="form-group">
				<label for="worldchampion" class="col-sm-3 control-label">Weltmeister wird:</label>
				<div class="col-sm-9">
					<select name="team" required class="form-control" id="team">
	
						<optgroup label="Gruppe A">
							<option name="team" <?php if ($team == "RUS") echo " selected "; ?>value="RUS">Russland</option>
							<option name="team" <?php if ($team == "KSA") echo " selected "; ?>value="KSA">Saudi-Arabien</option>
							<option name="team" <?php if ($team == "URU") echo " selected "; ?>value="URU">Uruguay</option>
							<option name="team" <?php if ($team == "EGY") echo " selected "; ?>value="EGY">Ägypten</option>
						</optgroup>
						<optgroup label="Gruppe B">
							<option name="team" <?php if ($team == "MAR") echo " selected "; ?>value="MAR">Marokko</option>
							<option name="team" <?php if ($team == "IRN") echo " selected "; ?>value="IRN">Iran</option>
							<option name="team" <?php if ($team == "POR") echo " selected "; ?>value="POR">Portugal</option>
							<option name="team" <?php if ($team == "ESP") echo " selected "; ?>value="ESP">Spanien</option>
						</optgroup>
						<optgroup label="Gruppe C">
							<option name="team" <?php if ($team == "FRA") echo " selected "; ?>value="FRA">Frankreich</option>
							<option name="team" <?php if ($team == "AUS") echo " selected "; ?>value="AUS">Australien</option>
							<option name="team" <?php if ($team == "PER") echo " selected "; ?>value="PER">Peru</option>
							<option name="team" <?php if ($team == "DEN") echo " selected "; ?>value="DEN">Dänemark</option>
						</optgroup>

						<optgroup label="Gruppe D">
							<option name="team" <?php if ($team == "ISL") echo " selected "; ?>value="ISL">Island</option>
							<option name="team" <?php if ($team == "ARG") echo " selected "; ?>value="ARG">Argentinien</option>
							<option name="team" <?php if ($team == "CRO") echo " selected "; ?>value="CRO">Kroatien</option>
							<option name="team" <?php if ($team == "NGA") echo " selected "; ?>value="NGA">Nigeria</option>
						</optgroup>
						<optgroup label="Gruppe E">
							<option name="team" <?php if ($team == "CRC") echo " selected "; ?>value="CRC">Costa-Rica</option>
							<option name="team" <?php if ($team == "SRB") echo " selected "; ?>value="SRB">Serbien</option>
							<option name="team" <?php if ($team == "BRA") echo " selected "; ?>value="BRA">Brasilien</option>
							<option name="team" <?php if ($team == "SUI") echo " selected "; ?>value="SUI">Schweiz</option>
						</optgroup>	
						<optgroup label="Gruppe F">
						
							<option name="team" <?php if ($team == "GER") echo " selected "; ?>value="GER">Deutschland</option>
							<option name="team" <?php if ($team == "MEX") echo " selected "; ?>value="MEX">Mexiko</option>
							<option name="team" <?php if ($team == "SWE") echo " selected "; ?>value="SWE">Schweden</option>
							<option name="team" <?php if ($team == "KOR") echo " selected "; ?>value="KOR">Korea</option>
						</optgroup>
						<optgroup label="Gruppe G">
							<option name="team" <?php if ($team == "BEL") echo " selected "; ?>value="BEL">Belgien</option>
							<option name="team" <?php if ($team == "PAN") echo " selected "; ?>value="PAN">Panama</option>
							<option name="team" <?php if ($team == "TUN") echo " selected "; ?>value="TUN">Tunesien</option>
							<option name="team" <?php if ($team == "ENG") echo " selected "; ?>value="ENG">England</option>
						</optgroup>
						<optgroup label="Gruppe H">
							<option name="team" <?php if ($team == "POL") echo " selected "; ?>value="POL">Polen</option>
							<option name="team" <?php if ($team == "SEN") echo " selected "; ?>value="SEN">Senegal</option>
							<option name="team" <?php if ($team == "COL") echo " selected "; ?>value="COL">Kolumbien</option>
							<option name="team" <?php if ($team == "JPN") echo " selected "; ?>value="JPN">Japan</option>
						</optgroup>
					</select>
				</div>
			</div>
			
			<?php
			
			$db = connect();
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
						echo '<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" name="submit" value="Speichern" class="btn btn-success">
				</div>
			</div>';
					} else {
						echo '<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" name="submit" disabled value="Leider zu spät..." class="btn btn-success">
				</div>
			</div>';
					}
				}
			}
			
			
			?>
			
			
			
		</form>
        
			<?php } ?>
		
		
		
		
			
      </div>
	

      <footer class="footer">
        <p>&copy; AG-Multimedia des Allgäu-Gymnasiums 2018. Alle Rechte vorbehalten. </p>
      </footer>

    </div> <!-- /container -->


    <!-- IE10-Anzeigefenster-Hack für Fehler auf Surface und Desktop-Windows-8 -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
