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
   
		
		
		.teamIcon {
			height: 64px;
			width: 64px;
			border-radius: 32px;
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
            <li role="presentation" class="active" ><a href="./neuer_benutzer.php">Registrieren</a></li>
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

		<div class="jumbotron"><?php
		if (isset($_POST["submit"]) && isset($_POST["matchid"])) {
			if (isset($_POST["tippTeam1"]) &&
			isset($_POST["tippTeam2"]) &&
			trim($_POST["tippTeam1"]) != "" &&
			trim($_POST["tippTeam2"]) != "") {
				$tippTeam1 = intval($_POST["tippTeam1"]);
				$tippTeam2 = intval($_POST["tippTeam2"]);
				if (is_numeric($tippTeam1) &&
				is_numeric($tippTeam2) &&
				$tippTeam1 > -1 &&
				$tippTeam2 > -1 &&
				$tippTeam1 < 100 &&
				$tippTeam2 < 100) {
					$db = connect();
					
					$userid = $db->real_escape_string($_SESSION["userid"]);
					$matchid = $db->real_escape_string($_POST["matchid"]);
					
					$res = $db->query("SELECT * FROM tipps WHERE userid=$userid AND matchid=$matchid");
					//echo $db->error;
					if ($res) {
						$res = $res->fetch_all(MYSQLI_ASSOC);
						//var_dump($res);
						if ($res) {
							$res = $res[0];
							if ($res) {
								$existing = true;
							} else {
								$existing = false;
							}
						} else {
							$existing = false;
						}
					} else {
						$existing = false;
					}
					$res = $db->query("SELECT * FROM matches WHERE id=$matchid");
					//echo $db->error;
					if ($res) {
						$res = $res->fetch_all(MYSQLI_ASSOC);
						//var_dump($res);
						if ($res) {
							$res = $res[0];
							if ($res) {
								$match = $res;
							} else {
								alert("danger", "Spiel nicht gefunden!");
								die();
							}
						} else {
							alert("danger", "Spiel nicht gefunden!");
							die();
						}
					} else {
						alert("danger", "Spiel nicht gefunden!");
						die();
					}
					$now = new DateTime("NOW");
					$now->add(date_interval_create_from_date_string("1 minute"));
					if ($now > new DateTime("@".strtotime($match["date"]))) {
						$allow = false;
					} else {
						$allow = true;
					}
					//var_dump($existing);
					if ($allow) {
						if ($existing) {
							$db->query("UPDATE tipps SET tippTeam1=$tippTeam1, tippTeam2=$tippTeam2 WHERE userid=$userid AND matchid=$matchid");
						} else  {
							$db->query("INSERT INTO tipps (userid, matchid, tippTeam1, tippTeam2) VALUES ($userid, $matchid, $tippTeam1, $tippTeam2)");
						}
					} else {
						alert("warning", "Du bist leider zu spät dran, das Spiel beginnt in weniger als einer Minute, es hat bereits angefanngen oder es ist schon vorbei. Beeile dich beim nächsten mal!");
						die();
					}
					header("Location: ./spielplan.php?s#tab1");
					alert("success", "Dein Tipp wurde erfolgreich gespeichert!");
					echo "<br><a class='btn btn-primary' href='./spielplan.php'>Zurück zum Spielplan</a>";
					die();
				} else {
					alert("danger", "Du hast leider nicht alle Felder korrekt ausgefüllt.");
				}
			} else {
				alert("danger", "Du hast leider nicht alle Felder ausgefüllt.");
				
			}
			
		} else if (!isset($_GET["s"])) {
			//var_dump($_POST);
			//die();
			header("Location: spielplan.php");
		}
		
		$db = connect();
		$id = $db->real_escape_string($_GET["s"]);
		$uid = $db->real_escape_string($_SESSION["userid"]);
		
		$res = $db->query("SELECT * FROM tipps WHERE userid=$uid AND matchid=$id");
		if ($res) {
			$tipp = false;
			$res = $res->fetch_all(MYSQLI_ASSOC);
			if (!$res) {
				$tipp = false;
			} else {
				$tipp = $res;
			}
		} else {
			$tipp = false;
		}
		
		
		
		
		$res = $db->query("SELECT * FROM `matches` WHERE id=$id");
		if (!$res) {
			alert("danger", "Es wurde kein Spiel gefunden!");
		} else {
			$res = $res->fetch_all(MYSQLI_ASSOC);
			if (!$res) {
				alert("danger", "Es wurde kein Spiel gefunden!");
			} else {
				$match = $res[0];
				$now = new DateTime("NOW");
				$now->add(date_interval_create_from_date_string("1 minute"));
				if ($now > new DateTime("@".strtotime($match["date"]))) {
					$allow = false;
				} else {
					$allow = true;
				}
				//echo $now->diff(new DateTime("@".strtotime($match["date"])))->i;
				$short1 = $db->real_escape_string($match["team1"]);
				$short2 = $db->real_escape_string($match["team2"]);
				
				$res = $db->query("SELECT * FROM teams WHERE short='$short1' or short='$short2'");
				if (!$res) {
					alert("danger", "Es wurden keine Teams gefunden!");
				} else {
					if (strlen($short1) == 3 OR strlen($short2) == 3) {
						$res = $res->fetch_all(MYSQLI_ASSOC);
						if ($res[0]["short"] == $match["team1"]) {
							$team1 = $res[0]["name"];
							$team2 = $res[1]["name"];
						} else {
							$team1 = $res[1]["name"];
							$team2 = $res[0]["name"];
						}
					} else {
						$team1 = $short1;
						$team2 = $short2;
					}
					
					//var_dump($short1);
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
					$kuerzel1 = ($match["team1"] == "?" OR strlen($match["team1"]) != 3) ? "unknown" : $match["team1"];
					$kuerzel2 = ($match["team2"] == "?" OR strlen($match["team2"]) != 3) ? "unknown" : $match["team2"];
					
					//$id = $match["id"];
					echo "<h1><img class='teamIcon' src='./images/teams/$kuerzel1.jpg'>&nbsp;$team1 vs. $team2&nbsp;<img class='teamIcon' src='./images/teams/$kuerzel2.jpg'></h1>";	
					echo "<h1 class='goals'>$goalsTeam1 : $goalsTeam2</h1>";
					echo "<div class='infoblock'>";
					//var_dump($tipp);
					echo $wochentag.", $tag.$monat.$jahr um $uhr Uhr";
					echo "<br>in $stadt";
					if (empty($tipp)) {
						$buttonname = "Tipp abgeben";
						$val1 = "";
						$val2 = "";
					} else {
						$buttonname = "Tipp ändern";
						$val1 = $tipp[0]["tippTeam1"];
						$val2 = $tipp[0]["tippTeam2"];
					}
					
					echo '</div><br><br><form class="form-inline" method="post">
						<input type="hidden" id="matchid" name="matchid" value="'.$_GET["s"].'">
						<div class="form-group">
							
							<input type="number" class="form-control" id="tippTeam1" name="tippTeam1" value='.$val1.' placeholder="'.$team1.'">
						</div>
						<b>&nbsp;:&nbsp;</b>
						<div class="form-group">
							
							<input type="number" class="form-control" id="tippTeam2" name="tippTeam2" value='.$val2.' placeholder="'.$team2.'">
						</div><br><br><br><br>';
					if ($allow) {
						echo '<button name="submit" type="submit" class="btn btn-success">'.$buttonname.'</button>';
					} else {
						echo '<button class="btn btn-success disabled">Zu spät...</button>';
					}
					echo '</form><br>';
					
					
					
					echo "<a class='btn btn-primary' href='./spielplan.php#tab1'>Abbrechen und zurück zum Spielplan</a>";
					
					
				}
				
				
			}
		}
		
		?>
		
		
		
      </div>
	

      <footer class="footer">
        <p>&copy; AG-Multimedia des Allgäu-Gymnasiums 2018. Alle Rechte vorbehalten. </p>
      </footer>

    </div> <!-- /container -->


    <!-- IE10-Anzeigefenster-Hack für Fehler auf Surface und Desktop-Windows-8 -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
