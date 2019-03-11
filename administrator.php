<?php 
	require_once("./include/lib.inc.php"); 
	require_once("./include/db.inc.php"); 
	if (!isset($_SESSION["adminLoggedin"]) OR $_SESSION["adminLoggedin"] != true) {
		$loggedin = false;
	} else {
		$loggedin = true;
	}
	
	if (isset($_POST["submit"])) {
		
		if (isset($_POST["username"]) &&
		isset($_POST["password"]) &&
		!empty(trim($_POST["username"])) &&
		!empty(trim($_POST["password"]))) {
			//die("angekommen!!!");
			$db = connect();
			
			$username = $db->real_escape_string($_POST["username"]);
			$res = $db->query("SELECT * FROM admins WHERE username='$username'");
			
			if (!$res) {
				alert("danger", "Bitte überprüfe deinen Benutzernamen!");
			} else {
				$res = $res->fetch_all(MYSQLI_ASSOC);
				if (!$res) {
					alert("danger", "Bitte überprüfe deinen Benutzernamen!");
				} else {
					$res = $res[0];
					if (!$res) {
						alert("danger", "Bitte überprüfe deinen Benutzernamen!");
					} else {
						$password = $res["password"];
						$status = password_verify($_POST["password"], $password);
						
						if ($status) {
							// erfolgreich eingeloggt!!!
							$_SESSION["adminLoggedin"] = true;
							$_SESSION["adminusername"] = $res["username"];
							$_SESSION["adminuserid"] = $res["id"];
							$loggedin = true;
							//alert("success", "Erfolgreich eingeloggt!");
						} else {
							alert("danger", "Bitte überprüfe dein Passwort!");
						}
					}
					
				}
				
			}
		}
		
		
		
		$username = (isset($_POST["username"])) ? $_POST["username"] : "";
		$password = (isset($_POST["password"])) ? $_POST["password"] : "";
		
		if (empty(trim($password)) XOR empty(trim($username))) {	
			alert("danger", "Bitte überprüfe deine Zugangsdaten!");
		}	
	} else if (isset($_GET["v"])) {
		$db = connect();
		$user = $db->real_escape_string($_GET["v"]);
		
		$res = $db->query("UPDATE users SET checked=1 WHERE id=$user");
	} else if (isset($_POST["submitSettings"])) {
		$db = connect();
		$gruppen = (isset($_POST["gruppen"])) ? true : false;
		$achtel = (isset($_POST["achtel"])) ? true : false;
		$viertel = (isset($_POST["viertel"])) ? true : false;
		$halb = (isset($_POST["halb"])) ? true : false;
		$finale = (isset($_POST["finale"])) ? true : false;
		$platz3 = (isset($_POST["platz3"])) ? true : false;
		//var_dump($platz3);
		$db->query("UPDATE `settings` SET `gruppenphase` = '$gruppen', `achtel` = '$achtel', `viertel`='$viertel', `halb`='$halb', `finale`='$finale', `platz3`='$platz3'");
		
	
	} else if (isset($_GET["b"])) {
		$db = connect();
		$user = $db->real_escape_string($_GET["b"]);
		
		$res = $db->query("UPDATE users SET checked=-1 WHERE id=$user");
	}
	
	//echo "bhasjkdbnaskljdhsnadkjfhasokjdhskldbjchasdrukjhnsadiojsanhdfiousaderif".var_dump($loggedin);
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
    <link rel="icon" href="../../favicon.ico">

    <title>Administrator - AG-Tippspiel</title>

    <!-- Bootstrap-CSS -->
    <link href="./include/lib/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- Besondere Stile für diese Vorlage -->
    <link href="./styles/administrator.css" rel="stylesheet">

    <style>
	.header {
		margin-top: 4px;
		height: 45px;
	}
	
	</style>

    <!-- Unterstützung für Media Queries und HTML5-Elemente in IE8 über HTML5 shim und Respond.js -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
	<?php if ($loggedin) { ?>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="true" aria-controls="navbar">
            <span class="sr-only">Navigation ein-/ausblenden</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!--<a class="navbar-brand" href="#">Projekt-Titel</a>-->
		   <!--<h3 class="text-muted">Projekt-Titel</h3>-->
			<img class="header" src="./images/header.png">
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="./index.php" target="_blanc">Tippspiel</a></li>
            <li><a href="./administrator.php?a=logout">Ausloggen</a></li>
            
          </ul>
          
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><a href="./administrator.php?a=dashboard">Anleitung</a></li>
		  </ul>
          <ul class="nav nav-sidebar">
            <li><a href="./administrator.php?a=matches">Spielergebnisse eintragen</a></li>
            <li><a href="./administrator.php?a=koround">Mannschaften - K.O Runde eintragen</a></li>
            <li><a href="./administrator.php?a=settings">Anzeigeeinstellungen</a></li>
            <li><a href="./administrator.php?a=users">Benutzer</a></li>
            <li><a href="./administrator.php?a=points">Punkte aktualisieren</a></li>
		  </ul>
		  <ul class="nav nav-sidebar">
            <li><a href="./include/exportdb.php">Daten exportieren</a></li>
            <li><a href="./administrator.php?a=importData">Daten importieren</a></li>
     
          </ul>
          
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		
			<?php $action = (isset($_GET["a"])) ? $_GET["a"] : "dashboard";
			
			if ($action == "dashboard") { /////////////////////////////////////////////////////////////////////////////////////////////?>
		
		
			<h1 class="page-header">Bedienungsanleitung</h1>
			<ul>
				<li>Im Menüpunkt "Spielergebnisse" können Sie die Ergebnisse der einzelnen Spiele eingeben und auch nachträglich ändern.</li>
				<li>Bei "Mannschaften K.O. Runde" können Sie die Mannschaften der Achtel-, Viertel-, Halbfinal-, Finalspiele und des Spiels um Platz 3 eintragen. Bitte geben Sie nur die 3-Stelligen Kürzel an, die finden Sie nach einem Klick auf den Link, der Ihnen dort ebenfalls angezeigt wird. </li>
				<li>Bei "Anzeigeeinstellungen" können Sie auswählen, welche Teile des Spielplan angezeigt werden sollen. Ich würde empfehlen, die einzelnen Spiele dann freizuschalten, wenn die Mannschaften feststehen oder immer einen festen Zeitraum vor Spielbeginn, beispielsweise 2 Wochen. </li>
				<li>Im Reiter "Benutzer" sehen Sie 3 Tabellen. In der obersten Tabelle sind die neuen Benutzer aufgelistet. Wenn sie einen Benutzer verifizieren, hat das für diesen keine Auswirkungen, er wird nur im Backend nicht mehr als neuer Benutzer angezeigt. Wenn Sie ihn jedoch blockieren, kann er nicht mehr weiter spielen. Das ist beispielsweise für Leute gedacht, die nicht ihren echten Namen angeben.  </li>
				<li>Wenn Sie auf "Daten exportieren" klicken, bekommen Sie eine .sql Datei als Download. Diese eignen sich sehr gut als Backup. </li>
				<li>Um die Datei wieder einzuspielen, gehen Sie auf "Daten importieren" und laden die Datei hoch. Achtung: Alle Daten, die sich seit dem Download der sql Datei verändert haben, gehen bei einem Import verloren!!!. Deshalb sollten die Daten nur bei einem kompletten Verlust der Datenbank oder bei einem schwerwiegendem Fehler neu importiert werden. </li>
			</ul>
			<br>
			Viel Spaß mit dem Tippspiel!
          
			<?php } else if ($action == "settings") { ?>
			<h1 class="page-header">Anzeigeeinstellungen</h1>
			<form class="form-horizontal" method="post">
			<?php
			$db = connect();
			$res = $db->query("SELECT * FROM settings")->fetch_all(MYSQLI_ASSOC)[0];
			$gruppen = ($res["gruppenphase"]) ? true : false;
			$achtel = ($res["achtel"]) ? true : false;
			$viertel = ($res["viertel"]) ? true : false;
			$halb = ($res["halb"]) ? true : false;
			$finale = ($res["finale"]) ? true : false;
			$platz3 = ($res["platz3"]) ? true : false;
			//var_dump($platz3);
			
		
			
			?>
			
			
			
				<div class="checkbox">
					<label>
						<input type="checkbox" <?php if ($gruppen) echo "checked"; ?> name="gruppen">
						Zeige die Gruppenphase  
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" <?php if ($achtel) echo "checked"; ?> name="achtel">
						Zeige die Achtelfinale  
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" <?php if ($viertel) echo "checked"; ?> name="viertel">
						Zeige die Viertelfinale  
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" <?php if ($halb) echo "checked"; ?> name="halb">
						Zeige die Halbfinale 
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" <?php if ($finale) echo "checked"; ?> name="finale">
						Zeige das Finale  
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" <?php if ($platz3) echo "checked"; ?> name="platz3">
						Zeige das Spiel um Platz 3  
					</label>
				</div>
				<br>
				<input class="btn btn-primary" name="submitSettings" type="submit" value="Speichern">
			</form>
			<?php } else if (isset($_POST["updatePoints"])) {
		updatePoints();
		alert("success", "Die Punkte aller Spieler wurden aktualisiert!");
		} else if ($action == "points") { ?>
			<h1 class="page-header">Punkte der Spieler aktualisieren</h1>
			<form class="form-horizontal" method="post">
			
				<input class="btn btn-primary" name="updatePoints" type="submit" value="Punkte aktualisieren">
			</form>
			<?php } else if ($action == "users") { ///////////////////////////////////////////////////////////////////////////////////////////// ?>
			<h1 class="page-header">Benutzer</h1>
			
                <?php
					$db = connect();
					$res = $db->query("SELECT * FROM users ORDER BY grade");
					if (!$res) {
						alert("danger", "Keine Benutzer gefunden!");
					} else {
						$res = $res->fetch_all(MYSQLI_ASSOC);
						if (!$res) {
							alert("danger", "Keine Benutzer gefunden!");
						} else {
							$blockedUsers = array();
							$checkedUsers = array();
							$uncheckedUsers = array();

							foreach ($res as $user) {
								if ($user["checked"] == -1) {
									$blockedUsers[] = $user;
								} else if ($user["checked"] == 0) {
									$uncheckedUsers[] = $user;
								} else {
									$checkedUsers[] = $user;
								}
							}
							alert("success", "Es gibt ".count($uncheckedUsers)." neue Benutzer!");
							alert("info", "Es gibt ".count($checkedUsers)." verifizierte Benutzer!");
							alert("warning", "Es gibt ".count($blockedUsers)." blockierte Benutzer!");
							echo "<h3>Neue Benutzer</h3><div class='table-responsive'>
									<table class='table table-striped'>
									  <thead>
										<tr>
										  <th>Klasse</th>
										  <th>Nickname</th>
										  <th>Name</th>
										  <th>Verifizieren</th>
										  <th>Blockieren</th>
										</tr>
									  </thead>
									  <tbody>";
							foreach ($uncheckedUsers as $user) {
								echo "<tr>
										<td>".$user["grade"]."</td>
										<td>".$user["nickname"]."</td>
										<td>".$user["name"]."</td>
										<td><a href='./administrator.php?a=users&v=".$user["id"]."'>Verifizieren</a></td>
										<td><a href='./administrator.php?a=users&b=".$user["id"]."'>Blockieren</a></td>
									</tr>";
							}
							echo "</tbody></table></div>";
							/////
							echo "<h3>Verifizierte Benutzer</h3><div class='table-responsive'>
									<table class='table table-striped'>
									  <thead>
										<tr>
										  <th>Klasse</th>
										  <th>Nickname</th>
										  <th>Name</th>
										  
										</tr>
									  </thead>
									  <tbody>";
							foreach ($checkedUsers as $user) {
								echo "<tr>
										<td>".$user["grade"]."</td>
										<td>".$user["nickname"]."</td>
										<td>".$user["name"]."</td>
									</tr>";
							}
							echo "</tbody></table></div>";
							/////
							echo "<h3>Blockierte Benutzer</h3><div class='table-responsive'>
									<table class='table table-striped'>
									  <thead>
										<tr>
										  <th>Klasse</th>
										  <th>Nickname</th>
										  <th>Name</th>
										  
										</tr>
									  </thead>
									  <tbody>";
							foreach ($blockedUsers as $user) {
								echo "<tr>
										<td>".$user["grade"]."</td>
										<td>".$user["nickname"]."</td>
										<td>".$user["name"]."</td>
									</tr>";
							}
							echo "</tbody></table></div>";
						}
						
					}
				
				
				
				?>
                
              
			
			<?php } else if ($action == "matches") { /////////////////////////////////////////////////////////////////////////////////////////////?>
			<h1>Spielergebnisse eintragen</h1>
			<br>
		
		<?php
				alert("info", "Durch die Eingabe von <i>-1</i> können sie ein Spiel wieder in den Status ohne Ergebnis setzten.");
			$db = connect();
		
			
			getSpielplan($db, "./administrator.php?a=results&s=", false, "finale");		
			getSpielplan($db, "./administrator.php?a=results&s=", false, "platz3");		
			getSpielplan($db, "./administrator.php?a=results&s=", false, "halb");		
			getSpielplan($db, "./administrator.php?a=results&s=", false, "viertel");
			getSpielplan($db, "./administrator.php?a=results&s=", false, "achtel");
			getSpielplan($db, "./administrator.php?a=results&s=", false, "gruppen");
			
		?>
		
			<div class="clearfix">&nbsp;</div>
		
			</div>
		  <?php } else if ($action == "koround") { /////////////////////////////////////////////////////////////////////////////////////////////?>
			<h1>K.O.-Runden Mannschaften</h1>
			<br>
		
		<?php
			$db = connect();
			
			getSpielplan($db, "./administrator.php?a=koroundteams&s=", false, "finale");		
			getSpielplan($db, "./administrator.php?a=koroundteams&s=", false, "platz3");		
			getSpielplan($db, "./administrator.php?a=koroundteams&s=", false, "halb");		
			getSpielplan($db, "./administrator.php?a=koroundteams&s=", false, "viertel");
			getSpielplan($db, "./administrator.php?a=koroundteams&s=", false, "achtel");
			getSpielplan($db, "./administrator.php?a=koroundteams&s=", false, "gruppen");
			
		?>
		
			<div class="clearfix">&nbsp;</div>
		
			</div>
			<?php } else if ($action == "results") { /////////////////////////////////////////////////////////////////////////////////////////////?>
			<div class="jumbotron"><?php
		if (isset($_POST["submit"]) && isset($_POST["matchid"])) {
			if (isset($_POST["goalsTeam1"]) &&
			isset($_POST["goalsTeam2"]) &&
			trim($_POST["goalsTeam1"]) != "" &&
			trim($_POST["goalsTeam2"]) != "") {
				$tippTeam1 = intval($_POST["goalsTeam1"]);
				$tippTeam2 = intval($_POST["goalsTeam2"]);
				if (is_numeric($tippTeam1) &&
				is_numeric($tippTeam2) &&
				$tippTeam1 > -2 &&
				$tippTeam2 > -2 &&
				$tippTeam1 < 100 &&
				$tippTeam2 < 100) {
					$db = connect();
					
					$userid = $db->real_escape_string($_SESSION["adminuserid"]);
					$matchid = $db->real_escape_string($_POST["matchid"]);
					
					
					//var_dump($existing);
					
					$db->query("UPDATE matches SET goalsTeam1=$tippTeam1, goalsTeam2=$tippTeam2 WHERE id=$matchid");
					
					alert("success", "Das Ergebnis wurde erfolgreich gespeichert!");
					updatePoints();
					alert("success", "Die Punkte aller Spieler wurden aktualisiert!");
					echo "<br><a class='btn btn-primary' href='./administrator.php?a=matches'>Zurück zum Spielplan</a>";
					die();
				} else {
					alert("danger", "Du hast leider nicht alle Felder korrekt ausgefüllt.0002");
				}
			} else {
				alert("danger", "Du hast leider nicht alle Felder ausgefüllt.0001");
				
			}
			
		} else if (!isset($_GET["s"])) {
			//var_dump($_POST);
			//die();
			header("Location: administrator.php");
		}
		
		$db = connect();
		$id = $db->real_escape_string($_GET["s"]);
		//$uid = $db->real_escape_string($_SESSION["userid"]);
		
		
		
		
		
		
		$res = $db->query("SELECT * FROM `matches` WHERE id=$id");
		if (!$res) {
			alert("danger", "Es wurde kein Spiel gefunden!");
		} else {
			$res = $res->fetch_all(MYSQLI_ASSOC);
			if (!$res) {
				alert("danger", "Es wurde kein Spiel gefunden!");
			} else {
				$match = $res[0];
				
				$short1 = $db->real_escape_string($match["team1"]);
				$short2 = $db->real_escape_string($match["team2"]);
				$res = $db->query("SELECT * FROM teams WHERE short='$short1' or short='$short2'");
				if (!$res) {
					alert("danger", "Es wurden keine Teams gefunden!");
				} else {
					if (strlen($short1) != 3 or strlen($short1) != 3) {
						$team1 = $short1;
						$team2 = $short2;
					} else {
						$res = $res->fetch_all(MYSQLI_ASSOC);
						if ($res[0]["short"] == $match["team1"]) {
							$team1 = $res[0]["name"];
							$team2 = $res[1]["name"];
						} else {
							$team1 = $res[1]["name"];
							$team2 = $res[0]["name"];
						}
					}
					$monate = array(1=>"Januar",
						2=>"Februar",
						3=>"M&auml;rz",
						4=>"April",
						5=>"Mai",
						6=>"Juni",
						7=>"Juli",
						8=>"August",
						9=>"September",
						10=>"Oktober",
						11=>"November",
						12=>"Dezember");
					$tage = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
					$date = strtotime($match["date"]);
					$tag = date("j", $date);
					$monat = date("m", $date);
					$jahr = date("Y", $date);
					$uhr =  date("H:i", $date);
					$stadt = $match["place"];
					$wochentag = $tage[date("w", $date)];
					$goalsTeam1 = $match["goalsTeam1"];
					$goalsTeam2 = $match["goalsTeam2"];
					if ($goalsTeam1 < 0 AND $goalsTeam2 < 0) {
						$goalsTeam1 = "--";
						$goalsTeam2 = "--";
					}
					$id = $match["id"];
					
					$kuerzel1 = ($match["team1"] == "?" OR strlen($match["team1"]) != 3) ? "unknown" : $match["team1"];
					$kuerzel2 = ($match["team2"] == "?" OR strlen($match["team2"]) != 3) ? "unknown" : $match["team2"];
					
					echo "<h2><img class='teamIcon' src='./images/teams/$kuerzel1.jpg'>&nbsp;$team1 vs. $team2&nbsp;<img class='teamIcon' src='./images/teams/$kuerzel2.jpg'></h2>";	
					
					echo "<div class='infoblock'>";
					//var_dump($tipp);
					
					echo $wochentag.", $tag.$monat.$jahr um $uhr Uhr";
					echo "<br>in $stadt";
					if ($match["goalsTeam1"] < 0 AND $match["goalsTeam2"] < 0) {
						$buttonname = "Ergebnis speichern";
						$val1 = "";
						$val2 = "";
					} else {
						$buttonname = "Ergebnis ändern";
						$val1 = $match["goalsTeam1"];
						$val2 = $match["goalsTeam2"];
					}
					echo '</div><br><br><form class="form-inline" method="post">
						<input type="hidden" id="matchid" name="matchid" value="'.$_GET["s"].'">
						<div class="form-group">
							
							<input type="number" class="form-control" id="goalsTeam1" name="goalsTeam1" value='.$val1.' placeholder="'.$team1.'">
						</div>
						<b>&nbsp;:&nbsp;</b>
						<div class="form-group">
							
							<input type="number" class="form-control" id="goalsTeam2" name="goalsTeam2" value='.$val2.' placeholder="'.$team2.'">
						</div><br><br><br><br>
				<button name="submit" type="submit" class="btn btn-success">'.$buttonname.'</button>
					</form><br>';
					
					
					
					echo "<a class='btn btn-primary' href='./administrator.php?a=matches'>Abbrechen und zurück zum Spielplan</a>";
					
					
				}
				
				
			}
		}
		
		?>
		
		
		
      </div>
		<?php } else if ($action == "koroundteams") { /////////////////////////////////////////////////////////////////////////////////////////////?>
			<div class="jumbotron"><?php
				
		if (isset($_POST["submit"]) && isset($_POST["matchid"])) {
			if (isset($_POST["nameTeam1"]) &&
			isset($_POST["nameTeam2"]) &&
			trim($_POST["nameTeam1"]) != "" &&
			trim($_POST["nameTeam2"]) != "") {
				$nameTeam1 = $_POST["nameTeam1"];
				$nameTeam2 = $_POST["nameTeam2"];
				
				$db = connect();

				
				$matchid = $db->real_escape_string($_POST["matchid"]);


				//var_dump($existing);

				$db->query("UPDATE `matches` SET `team1` = '$nameTeam1', `team2` = '$nameTeam2' WHERE `matches`.`id` = $matchid ");
				echo $db->error;
				alert("success", "Die Mannschaften wurde erfolgreich gespeichert!");
				
				echo "<br><a class='btn btn-primary' href='./administrator.php?a=koround'>Zurück zum K.O.-Runden-Spielplan</a>";
				die();
				
			} else {
				alert("danger", "Du hast leider nicht alle Felder ausgefüllt.");
				
			}
			
		} else if (!isset($_GET["s"])) {
			//var_dump($_POST);
			//die();
			header("Location: administrator.php");
		}
		
		$db = connect();
		$id = $db->real_escape_string($_GET["s"]);
		
		alert("info", "Bitte gib hier die 3-stelligen Kürzel der Mannschaften ein! Du findest Sie unter <br><a target='_blanc' href='http://de.fifa.com/worldcup/teams/index.html'>http://de.fifa.com/worldcup/teams/index.html</a>");
		
		
		
		
		
		$res = $db->query("SELECT * FROM `matches` WHERE id=$id");
		if (!$res) {
			alert("danger", "Es wurde kein Spiel gefunden!");
		} else {
			$res = $res->fetch_all(MYSQLI_ASSOC);
			if (!$res) {
				alert("danger", "Es wurde kein Spiel gefunden!");
			} else {
				$match = $res[0];
				
				$short1 = $db->real_escape_string($match["team1"]);
				$short2 = $db->real_escape_string($match["team2"]);
				$res = $db->query("SELECT * FROM teams WHERE short='$short1' or short='$short2'");
				if (!$res) {
					alert("danger", "Es wurden keine Teams gefunden!");
				} else {
					if (strlen($short1) != 3 or strlen($short1) != 3) {
						$team1 = $short1;
						$team2 = $short2;
					} else {
						$res = $res->fetch_all(MYSQLI_ASSOC);
						if ($res[0]["short"] == $match["team1"]) {
							$team1 = $res[0]["name"];
							$team2 = $res[1]["name"];
						} else {
							$team1 = $res[1]["name"];
							$team2 = $res[0]["name"];
						}
					}
					$monate = array(1=>"Januar",
						2=>"Februar",
						3=>"M&auml;rz",
						4=>"April",
						5=>"Mai",
						6=>"Juni",
						7=>"Juli",
						8=>"August",
						9=>"September",
						10=>"Oktober",
						11=>"November",
						12=>"Dezember");
					$tage = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
					$date = strtotime($match["date"]);
					$tag = date("j", $date);
					$monat = date("m", $date);
					$jahr = date("Y", $date);
					$uhr =  date("H:i", $date);
					$stadt = $match["place"];
					$wochentag = $tage[date("w", $date)];
					$goalsTeam1 = $match["goalsTeam1"];
					$goalsTeam2 = $match["goalsTeam2"];
					if ($goalsTeam1 < 0 AND $goalsTeam2 < 0) {
						$goalsTeam1 = "--";
						$goalsTeam2 = "--";
					}
					$id = $match["id"];
					
					$kuerzel1 = ($match["team1"] == "?" OR strlen($match["team1"]) != 3) ? "unknown" : $match["team1"];
					$kuerzel2 = ($match["team2"] == "?" OR strlen($match["team2"]) != 3) ? "unknown" : $match["team2"];
					
					echo "<h2><img class='teamIcon' src='./images/teams/$kuerzel1.jpg'>&nbsp;$team1 vs. $team2&nbsp;<img class='teamIcon' src='./images/teams/$kuerzel2.jpg'></h2>";	
					
					echo "<div class='infoblock'>";
					//var_dump($tipp);
					
					echo $wochentag.", $tag.$monat.$jahr um $uhr Uhr";
					echo "<br>in $stadt";
					if (strlen($match["team1"]) > 3 AND strlen($match["team2"]) > 3) {
						$buttonname = "Mannschaften speichern";
						
					} else {
						$buttonname = "Mannschaften ändern";
						
					}
					$val1 = $match["team1"];
					$val2 = $match["team2"];
					//var_dump($match);
					echo '</div><br><br><form class="form-inline" method="post">
						<input type="hidden" id="matchid" name="matchid" value="'.$_GET["s"].'">
						<div class="form-group">
							
							<input type="text" class="form-control" id="nameTeam1" name="nameTeam1" value="'.$val1.'" placeholder="'.$team1.'">
						</div>
						<b>&nbsp;vs.&nbsp;</b>
						<div class="form-group">
							
							<input type="text" class="form-control" id="nameTeam2" name="nameTeam2" value="'.$val2.'" placeholder="'.$team2.'">
						</div><br><br><br><br>
				<button name="submit" type="submit" class="btn btn-success">'.$buttonname.'</button>
					</form><br>';
					
					
					
					echo "<a class='btn btn-primary' href='./administrator.php?a=koround'>Abbrechen und zurück zum K.O.-Runden-Spielplan</a>";
					
					
				}
				
				
			}
		}
		
		?>
		
		
		
      </div>
			<?php } else if ($action == "logout") { /////////////////////////////////////////////////////////////////////////////////////////////?>
			<h1>Das AG tippt`s!</h1> 
		<br>
		<?php
			
			if (isset($_POST["logout"])) {
				
				if (ini_get("session.use_cookies")) {
					$params = session_get_cookie_params();
					setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
				}

				// Zum Schluß, löschen der Session.
				session_destroy();
				alert("success", "Du wurdest erfolgreich ausgeloggt!");
				header("Location: ./administrator.php");
				
			} else if (isset($_POST["stay"])) {
				
				header("Location: ./administrator.php");
				
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
			<?php } else if ($action == "importData") { /////////////////////////////////////////////////////////////////////////////////////////////?>
			<h1>Daten importieren</h1>
			<br>
			<?php alert("warning", "<b>Achtung:</b> Alle Daten, die sich seit dem Download der sql Datei verändert haben, gehen bei einem Import verloren!!!. Deshalb sollten die Daten nur bei einem kompletten Verlust der Datenbank oder bei einem schwerwiegendem Fehler neu importiert werden. "); ?>
			Bitte lade die Datei hoch:
			<form enctype="multipart/form-data" method="post">
				<label class="btn btn-primary btn-file">
					Auswählen... <input type="file" name="dbfile" style="display: none;">
				</label><br><br>
				<input class="btn btn-success" type="submit" name="submitFile" value="Importieren"><br><br>
			</form>
			<?php } 
			if (isset($_POST["submitFile"]) ) {
		$target_dir = "./";
		$target_file = $target_dir . "database.sql";
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		
		
		
		// Check if file already exists
		if (file_exists($target_file)) {
			alert("danger", "Entschuldigung, die Datei existiert bereits. <a href='./include/importdb.php?del' class='btn btn-warning'>Hochgeladene Datei löschen</a>");
			$uploadOk = 0;
		}
		
		// Allow certain file formats
		if($imageFileType != "sql") {
			alert("danger", "Entschuldigung, es sind nur *.sql Dateien erlaubt.");
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			alert("danger", "Die Datei wurde nicht hochgeladen.");
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["dbfile"]["tmp_name"], $target_file)) {
				alert("success", "Die Datei ". basename( $_FILES["dbfile"]["name"]). " wurde erfolgreich hochgeladen.<a href='./include/importdb.php' class='btn btn-primary'>Gleich importieren</a>");
			} else {
				alert("danger", "Entschuldigung, die Datei wurde aufgrund eines Fehlers nicht hochgeladen.");
			}
		}
		
	}} else {///////////////////////////////////////////////////////////////////////////////////////////// ?>
	<div class="container">

      <form class="form-signin" method="post">
        <h2 class="form-signin-heading">Bitte melde dich an</h2>
        <label for="username" class="sr-only">Email-Adresse</label>
        <input type="text" id="username" name="username" class="form-control" placeholder="Benutzername" required autofocus>
        <label for="password" class="sr-only">Passwort</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Passwort" required>
        
        <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Anmelden</button>
      </form>

    </div> <!-- /container -->
	<?php } ?>
	
	
    <!-- Bootstrap-JavaScript
    ================================================== -->
    <!-- Am Ende des Dokuments platziert, damit Seiten schneller laden -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- Nur, um unsere Platzhalter-Bilder zum Laufen zu bringen. Die nächste Zeile nicht wirklich kopieren! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10-Anzeigefenster-Hack für Fehler auf Surface und Desktop-Windows-8 -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
