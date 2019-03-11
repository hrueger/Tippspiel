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
   
		.spielplan {
			margin-left: auto;
			margin-right: auto;
			
			
		}
		
		td, th {
			padding: 5px;
			
		}
   
		table {
			overflow: hidden;
		}
   
   
		.logoNameLeft, .logoNameRight {
			width: 150px;
		}
		
		.result, .groupname {
			width: 95px !important;
		}
   
		.group {
			
			float: left;
			margin: 5px;
		}
		
		.group thead {
			background-color: #bababa;
		}	
		
		.group {
			margin: 10px;
		}
		
		.groupname {
			color: #FFFFFF;
			font-weight: bold;
		}
		
		.teamIcon {
			height: 32px;
			width: 32px;
			border-radius: 16px;
		}
		
		.logoNameLeft {
			text-align: left;
		}
		.logoNameRight {
			text-align: right;
			padding-left: 10px;
		}
		
		.match {
			cursor: pointer;
			padding: 5px;
		}
		.match:hover{
			background-color: #cccccc;
		}
		
		.match a {
			color: black;
			text-decoration: none;
			display: block;
		}
		
		.match span {
			color: green;
		}
		
		.centreBox {
			float: none;
			margin: auto;
			margin-bottom: 10px;
		}
		
		
		
		.centreBox thead {
			background-color: #bababa;
		}	
		
		.red thead {
			background-color: #ad6666;
		}	
		.blue thead {
			background-color: #69a2b2;
		}	
		.green thead {
			background-color: #6bb269;
		}	
		.yellow thead {
			background-color: #bfb963;
		}	
		
		.countdown {
			padding-left: 20px;
			border-left: 1px solid black;
		}
	   
	   .result b {
		   font-size: 1.5em;
	   }
	   
	   /* für die Tabs */
	   	.tab-content {
			display: none;
		}
		.tab-content:target {
			display: block;
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
			<li role="presentation" class="active"><a href="./spielplan.php#tab1">Spielplan</a></li>
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
        <h1>Spielplan</h1>
		<br>
		
		<?php
		  	if (isset($_GET["s"])) {
				alert("success", "Dein Tipp wurde erfolgreich gespeichert!");
			}
		  alert("info", "<b>Ein Rat</b>: Um keine Spiele zu versäumen, trage gleich jetzt deine Tipp-Ergebnisse aller angesetzten Spielpaarungen ein. Du kannst jedes Tipp-Ergebnis noch jederzeit (bis eine Minute vor dem Spiel) ändern!");
		  	date_default_timezone_set("Europe/Berlin");?>
		  
		  
		  <ul class="menu nav nav-tabs">
				<li><a href="#tab2">Geordnet nach Gruppen</a></li>
				<li><a href="#tab1">Geordnet nach Datum</a></li>
				
			</ul>
		  <br>
		  
		  <div id="tab2" class="tab-content">
		  <?php
		  	
		  	//echo "The time is " . date("h:i:sa");
			$db = connect();
			$db->query("SET NAMES utf8");
			$res = $db->query("SELECT * FROM settings")->fetch_all(MYSQLI_ASSOC)[0];
			if ($res["finale"]) {
				getSpielplan($db, "./tipps.php?s=", true, "finale");
			} 
			if ($res["platz3"]) {
				getSpielplan($db, "./tipps.php?s=", true, "platz3");
			} 
			if ($res["halb"]) {
				getSpielplan($db, "./tipps.php?s=", true, "halb");
			} 
			if ($res["viertel"]) {
				getSpielplan($db, "./tipps.php?s=", true, "viertel");
			} 
			if ($res["achtel"]) {
				getSpielplan($db, "./tipps.php?s=", true, "achtel");
			} 
			if ($res["gruppenphase"]) {
				getSpielplan($db, "./tipps.php?s=", true, "gruppen");
			}
			
		?>
		
		<div class="clearfix">&nbsp;</div>
		</div>
		  <div id="tab1" class="tab-content">
		  <?php
		  	
		  	//echo "The time is " . date("h:i:sa");
			  //alert("warning", "Bitte wundern Sie sich nicht über etwaige Fehler in dieser Spalte, da diese Seite gerade überarbeitet wird. Wir bedanken uns für Ihr Verständnis!");
			$db = connect();
			$db->query("SET NAMES utf8");
			$res = $db->query("SELECT * FROM settings")->fetch_all(MYSQLI_ASSOC)[0];
			  $what = [];
			if ($res["finale"]) {
				$what [] = "finale";
			} 
			if ($res["platz3"]) {
				$what [] = "platz3";
			} 
			if ($res["halb"]) {
				$what [] = "halb";
			} 
			if ($res["viertel"]) {
				$what [] = "viertel";
			} 
			if ($res["achtel"]) {
				$what [] = "achtel";
			} 
			if ($res["gruppenphase"]) {
				$what [] = "gruppen";
			}
			getSpielplanOrderByDate($db, "./tipps.php?s=", true, $what);
		?>
		
		<div class="clearfix">&nbsp;</div>
		</div>
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
