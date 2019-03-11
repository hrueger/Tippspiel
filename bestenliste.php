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
   
		.tab-content {
    display: none;
}
.tab-content:target {
    display: block;
}
		
	   th {
		   text-align: center;
	   }
	   
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
			<li role="presentation" class=""><a href="./spielplan.php#tab1">Spielplan</a></li>
            <li role="presentation" class=""><a href="./weltmeister.php">Weltmeister</a></li>
			<?php } ?>
			<li role="presentation" class="active" ><a href="./bestenliste.php#tab4">Bestenliste</a></li>
            <li role="presentation"><a href="./regeln.php">Regeln</a></li>
          </ul>
        </nav>
        <!--<h3 class="text-muted">Projekt-Titel</h3>-->
		<img class="img img-responsive" src="./images/header.png">
      </div>

      <div class="jumbotron">
        <h1>Bestenliste</h1>
		<br>
			<ul class="menu nav nav-tabs">
				<li><a href="#tab1">Alle Schüler</a></li>
				<li><a href="#tab2">Alle Lehrer</a></li>
				<li><a href="#tab3">Alle Klassen (durchschnittlich)</a></li>
				<li><a href="#tab4">Bestenliste (alle Teilnehmer)</a></li>
			</ul>
		  	
		  	<h5><b><?php echo "Stand: ".strftime("%A").", ".date('d.m.o \u\m H:i:s')." Uhr"; ?></b></h5>
			<div class="tab-folder">
			<div id="tab1" class="tab-content">
				<h3>Alle Schüler</h3>
				<?php
					createBestenliste("SELECT * FROM users WHERE grade NOT IN ('Lehrer/in', 'Studienseminar 17/19', 'Studienseminar 18/20') AND `checked`!=-1  ORDER BY `points` DESC", false);
				?>
			</div>
			<div id="tab2" class="tab-content">
			<h3>Alle Lehrer</h3>
				<?php
					createBestenliste("SELECT * FROM users WHERE grade IN ('Lehrer/in', 'Studienseminar 17/19', 'Studienseminar 18/20') AND `checked`!=-1 ORDER BY `points` DESC", false);
				?>
			</div>
			<div id="tab3" class="tab-content">
			<h3>Alle Klassen (durchschnittlich)</h3>
				<?php
					createBestenliste("grades", false);
				?>
			</div>
			<div id="tab4" class="tab-content">
			<h3>Bestenliste (alle Teilnehmer)</h3>
				<?php
					if (isset($_SESSION["userid"])) {
						createBestenliste("SELECT * FROM users WHERE `checked`!=-1 ORDER BY `points` DESC", true);
					} else {
						createBestenliste("SELECT * FROM users  WHERE `checked`!=-1 ORDER BY `points` DESC", false);
					}
				?>
			</div>
		</div>
		
		
		<div class="clearfix">&nbsp;</div>
		
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
