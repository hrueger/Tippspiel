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
	
	.regeln {
		text-decoration:none;
		font-size: 1.2em !important;
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
            <li role="presentation" ><a href="./index.php">Home</a></li>
			<?php if (!$loggedin) { ?>
            <li role="presentation"><a href="./login.php">Einloggen</a></li>
            <li role="presentation"><a href="./neuer_benutzer.php">Registrieren</a></li>
			<?php } else { ?>
			<li role="presentation"><a href="./logout.php">Abmelden</a></li>
			<li role="presentation"><a href="./spielplan.php#tab1">Spielplan</a></li>
            <li role="presentation" class=""><a href="./weltmeister.php">Weltmeister</a></li>
			<?php } ?>
			<li role="presentation"><a href="./bestenliste.php#tab4">Bestenliste</a></li>
            <li role="presentation" class="active"><a href="./regeln.php">Regeln</a></li>
          </ul>
        </nav>
        <!--<h3 class="text-muted">Projekt-Titel</h3>-->
		<img class="img img-responsive" src="./images/header.png">
      </div>

      <div class="">
        <!--<h1>Das AG tippt`s!</h1>-->
		<img class="img img-responsive" src="./images/logo_big.jpg"><br>
        
		<h2>Regeln zum AG-Tippspiel</h2>
		
		<p class="text-left regeln">

Liebe fußballbegeisterte Schülerinnen und Schüler, Lehrerinnen und Lehrer,<br>
<br>
willkommen beim WM-Tippspiel der Schulhomepage unseres Gymnasiums. <br>

Zunächst ein paar Regeln:<br>
<br>

	<div class="well">Bitte melde Dich zunächst an (<i>„Registrieren“</i>). Außer Deinem Namen und Deiner Klasse musst Du keine personenbezogenen Daten angeben. Diese werden absolut vertraulich behandelt und nach dem Tippspiel wieder gelöscht. Bitte notiere Dir Deine angegebenen Zugangsdaten. Bei Verlust dieser Daten müsstest Du Dich neu anmelden und würdest so bereits erreichte Punkte verlieren.</div>
	<div class="well">Die Teilnahme an diesem Tippspiel ist natürlich kostenlos.</div>
	<div class="well">Neben der Freude, zu den besten Fußball-Experten der AG-Schulfamilie zu gehören, warten auf die drei Sieger des Tippspiels kleine Preise.</div>
	<div class="well">Du kannst einen Tipp bis eine Minute vor dem offiziellen Beginn des Spiels abgeben und (vor dem Spiel) so oft ändern, wie Du möchtest.<br><br>
	(Rat: Damit Du nicht einzelne Spieltage versäumst, tippst Du bereits zu Beginn alle Spiele der Vorrunde. Du kannst ja nachträglich alle Tipps auch kurzfristig abändern.)</div>
	<div class="well">Es gilt die sog. 9-er-Punkteregel:<br>
		<div class="table-responsive"><table class="table table-striped table-hover">
			<thead>
				<th></th>
				<th>Tendenz</th>
				<th>Tordifferenz</th>
				<th>Ergebnis</th>
			</thead>
			<tbody>
				<tr>
					<td>Sieg</td>
					<td>10</td>
					<td>20</td>
					<td>30</td>
				</tr>
				<tr>
					<td>Unentschieden</td>
					<td>10</td>
					<td>-</td>
					<td>30</td>
				</tr>
			</tbody>
		</table></div>
		
	Beispiele:
		<ul>
			<li>Ergebnis: <b>2:1</b> - Tipp: <b>1:2</b> -> 0 Punkte (falsche Tendenz)</li>
			<li>Ergebnis: <b>2:1</b> - Tipp: <b>1:1</b> -> 0 Punkte (falsche Tendenz)</li>
			<li>Ergebnis: <b>1:3</b> - Tipp: <b>0:1</b> -> 10 Punkt (richtige Tendenz) </li>
			<li>Ergebnis: <b>2:1</b> - Tipp: <b>1:0</b> -> 20 Punkte (Sieg, Tordifferenz)</li>
			<li>Ergebnis: <b>1:1</b> - Tipp: <b>0:0</b> -> 10 Punkt (Unentschieden, Tendenz)</li>
			<li>Ergebnis: <b>2:2</b> - Tipp: <b>2:2</b> -> 30 Punkte (Unentschieden, Ergebnis)</li>
			<li>Ergebnis: <b>1:2</b> - Tipp: <b>1:2</b> -> 30 Punkte (Sieg, Ergebnis)</li>
		</ul>
	
	
	</div>
	



	<div class="well">Ab dem Achtefinale wird die Entscheidung nötigenfalls im Elfmeterschießen erzwungen.<br>
	Es wird <b>nach Elfmeterschießen</b> getippt.<br>
	Also ein <b>6:5</b> ist ab dem Achtelfinale ein realistisches Ergebnis; dagegen macht es keinen Sinn, ein Unentschieden zu tippen.</div>
	<div class="well table-responsive">Um die Spiele ab dem Achtelfinale aufzuwerten, werden die erzielten Punktzahlen noch mit einem Faktor multipliziert:
		<table class="table table-striped table-hover">
			<thead>
				<th>Spiel</th>
				<th>Faktor</th>
				
			</thead>
			<tbody>
				<tr>
					<td>Achtelfinale</td>
					<td>1,5</td>
				</tr>
				<tr>
					<td>Viertelfinale</td>
					<td>2,0</td>
				</tr>
				<tr>
					<td>Halbfinale</td>
					<td>2,5</td>
				</tr>
				<tr>
					<td>Spiel um Platz 3</td>
					<td>3,0</td>
				</tr><tr>
					<td>Finale</td>
					<td>4,0</td>
				</tr>
				
			</tbody>
		</table>
	</div>
	<div class="well">Zusätzlich erhältst Du 80 Punkte, wenn Du auf den richtigen Weltmeister getippt hast. 
	Tippschluss für den Weltmeister-Tipp: <b>Donnerstag, 14.06.2018, 16:59 Uhr</b>. („Weltmeister“)</div>
	<div class="well">Unter „Bestenliste“ kannst Du jederzeit nachsehen, wie viele Punkte Du bisher erhalten hast und auf welchem Platz Du momentan stehst.</div>
	<div class="well">Die drei Sieger des Tippspiels werden dann benachrichtigt.</div>

Viel Spaß beim Tippen und Mitfiebern!<br>
<hr>
Die AG-Multimedia des Allgäu-Gymnasium<br>
<br>
<b>Technische Realisierung:</b><br>
Hannes Rüger (8a)
<br><br>
<b>Spielleitung:</b><br>
Andreas Herz, StD</p>


		
      </div>
	

      <footer class="footer">
        <p>&copy; AG-Multimedia des Allgäu-Gymnasiums 2018. Alle Rechte vorbehalten. </p>
      </footer>

    </div> <!-- /container -->


    <!-- IE10-Anzeigefenster-Hack für Fehler auf Surface und Desktop-Windows-8 -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
