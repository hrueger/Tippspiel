<?php 
	/*require_once("./include/lib.inc.php"); 
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
		
		.logoNameLeft {
			text-align: left;
		}
		.logoNameRight {
			text-align: right;
		}
		
	   span {
		   font-size: 3em;
		   color: green;
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
			<li role="presentation"><a href="./spielplan.php">Spielplan</a></li>
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
		if (!isset($_GET["s"])) {
			header("Location: spielplan.php");
		} else {
			$db = connect();
			$id = $db->real_escape_string($_GET["s"]);
		}
			
		// für das Anzeigen eines eventuellen bisherigen Tipps
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
			
		$tippTeam1 = (isset($tipp[0]["tippTeam1"])) ? $tipp[0]["tippTeam1"] : "";
		$tippTeam2 = (isset($tipp[0]["tippTeam2"])) ? $tipp[0]["tippTeam2"] : "";

		
		$tippHTML = "<span>".$tippTeam1." : ".$tippTeam2."</span>";
		// ende anzeigen des bisherigen Tipps	
			
			
		$res = $db->query("SELECT * FROM `matches` WHERE id=$id");
		if (!$res) {
			alert("danger", "Es wurde kein Spiel gefunden!");
		} else {
			$res = $res->fetch_all(MYSQLI_ASSOC);
			if (!$res) {
				alert("danger", "Es wurde kein Spiel gefunden!");
			} else {
				$match = $res[0];
				/// Darf man hier noch tippen?
			
				
				if (new DateTime("NOW") > new DateTime("@".strtotime($match["date"]))) {
					$allow = false;
				} else {
					$allow = true;
				}
				
				
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
					
					echo "<h1><img class='teamIcon' src='./images/teams/$kuerzel1.jpg'>&nbsp;$team1 vs. $team2&nbsp;<img class='teamIcon' src='./images/teams/$kuerzel2.jpg'></h1>";	
					echo "<h1 class='goals'>$goalsTeam1 : $goalsTeam2</h1>";
					echo $tippHTML;
					echo "<div class='infoblock'>";
					
					echo $wochentag.", $tag.$monat.$jahr um $uhr Uhr";
					echo "<br>in $stadt";
					echo "</div><br><br><br>";
					
					$id = $db->real_escape_string($_GET["s"]);
					$uid = $db->real_escape_string($_SESSION["userid"]);
					
					
					if (empty($tipp)) {
						$buttonname = "Tipp abgeben";
					} else {
						$buttonname = "Tipp ändern";
					}
					if ($allow) {
						echo "<a class='btn btn-success' href='./tipps.php?s=$id'>$buttonname</a><br><br>";
					} else {
						echo "<a class='btn disabled btn-success' href='#'>Zu spät...</a><br><br>";
					}
					echo "<a class='btn btn-primary' href='./spielplan.php'>Zurück zum Spielplan</a>";
					
				
					
						
						
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
<?php */ ?>
