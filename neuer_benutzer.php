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
            <li role="presentation"><a href="./login.php">Einloggen</a></li>
            <li role="presentation" class="active" ><a href="./neuer_benutzer.php">Registrieren</a></li>
			<?php } else { ?>
			<li role="presentation"><a href="./logout.php">Abmelden</a></li>
			<li role="presentation"><a href="./wspielplan.php#tab1">Spielplan</a></li>
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
		<h3>Jetzt anmelden!</h3>
		<?php
			$ok = false;
		  	/*echo "<pre>";
		  	var_dump($_POST);
		  	echo "</pre>";*/
		  	if (isset($_POST["submit"])) {
				if (isset($_POST["name"]) &&
				isset($_POST["firstname"]) &&
				isset($_POST["grade"]) &&
				isset($_POST["nickname"]) &&
				isset($_POST["password"]) &&
				isset($_POST["password2"]) &&
				!empty(trim($_POST["name"])) &&
				!empty(trim($_POST["grade"])) &&
				!empty(trim($_POST["nickname"])) &&
				!empty(trim($_POST["password"])) &&
				!empty(trim($_POST["password2"]))) {
					$ok = true;
					if ($_POST["password"] == $_POST["password2"]) {
						$db = connect();
						$name = $db->real_escape_string(trim($_POST["firstname"]))." ".$db->real_escape_string(trim($_POST["name"]));
						$nickname = $db->real_escape_string($_POST["nickname"]);
						
						$grade = $db->real_escape_string($_POST["grade"]);
						
						$password = $_POST["password"];
						$res = $db->query("SELECT * FROM `users` WHERE `name` = '$name' OR `nickname` = '$nickname' AND `checked` != -1");
						//var_dump($res);
						//echo $db->error;
						////////////////////////////////////////////
						if ($res) {
							$res = $res->fetch_all(MYSQLI_ASSOC);

							if ($res) {
								$res = $res[0];
								if ($res) {
									if ($res["nickname"] == $nickname) {
										alert("warning", "Dieser Nickname existiert bereits. Bitte verwenden einen anderen!");
										$ok = false;
									}
									if ($res["name"] == $name) {
										alert("warning", "Dieser Spieler existiert bereits. Jede Person kann nur einmal spielen!");
										$ok = false;
									}
								} else {

								}

							}

						}

						if (!preg_match("/^\p{Lu}[\p{L} '&-]*[\p{L}]$/u", $name)) {
							alert("warning", "Bite gib deinen richtigen Namen an!");
							$ok = false;
						}

						if (strlen($password) < 5) {
							alert("warning", "Dein Passwort muss mindestens 5 Zeichen enthalten!");
							$ok = false;
						}
						elseif(!preg_match("#[0-9]+#",$password)) {
							alert("warning", "Dein Passwort muss mindestens 1 Zahl enthalten!");
							$ok = false;
						}
						elseif(!preg_match("#[A-Z]+#",$password)) {
							alert("warning", "Dein Passwort muss mindestens 1 Großbuchstaben enthalten!");
							$ok = false;
						}
						elseif(!preg_match("#[a-z]+#",$password)) {
							alert("warning", "Dein Passwort muss mindestens 1 Kleinbuchstaben enthalten!");
							$ok = false;
						}elseif (!preg_match("#^[a-zA-Z0-9äöüÄÖÜß \.\_]+$#", $nickname)) {
   							alert("warning", "Der Nickname darf nur Buchstaben, Umlaute, Zahlen, Leerzeichen, Punkte und Unterstriche enthalten!");
							$ok = false;
						}


						//alert("info", "Test bestanden!");
						////////////////////////////////////////////
						if ($ok) {
							$password = password_hash($db->real_escape_string($_POST["password"]), PASSWORD_DEFAULT);
							$res = $db->query("INSERT INTO `users` (`name`, `nickname`, `grade`, `password`, `checked`, `points`, `worldchampion`) VALUES ('$name', '$nickname', '$grade', '$password', '0', '0', '0')");
							if (!$res) {
								die("Fehler: ".$db->error);
							}

							alert("success", "Du bist nun erfolgreich angemeldet!<br><br><a href='./login.php' class='btn btn-primary'>Gleich einloggen</a>");
							$ok = true;
						}

					} else {

						alert("danger", "Die Passwörter stimmen nicht überein");
						$ok = false;
					}
				} else {
					alert("danger", "Du hast nicht alle Felder ausgefüllt!");
					$ok = false;
				}
			}
			
			
			if (!$ok) {
				$firstname = (isset($_POST["firstname"])) ? $_POST["firstname"] : "";
				$name = (isset($_POST["name"])) ? $_POST["name"] : "";
				$nickname = (isset($_POST["nickname"])) ? $_POST["nickname"] : "";
				$grade = (isset($_POST["grade"])) ? $_POST["grade"] : "";
			//echo "<pre>";
			//var_dump($_REQUEST);
			//echo "</pre>";
		?>
		
		
		  
        <br>
		<div class="alert alert-success" role="alert">Am Tippspiel können alle Schülerinnen und Schüler sowie alle Lehrerinnen und Lehrer des Allgäu-Gymnasiums teilnehmen.</div>
		<br>
		<form class="form-horizontal" method="post">
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">Vorname</label>
				<div class="col-sm-10">
					
					<input type="text" name="firstname" required autofocus class="form-control" id="firstname" value="<?php echo $firstname; ?>" placeholder="Vorname"><div class="alert alert-info text-left" role="alert">Bitte gib hier deinen echten Vornamen an, da dein Benutzer sonst blockiert wird und du nicht mehr mitspielen kannst.</div>
				</div>
			</div>
			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">Name</label>
				<div class="col-sm-10">
					
					<input type="text" name="name" required autofocus class="form-control" id="name" value="<?php echo $name; ?>" placeholder="Nachname"><div class="alert alert-info text-left" role="alert">Bitte gib hier deinen echten Nachnamen an, da dein Benutzer sonst blockiert wird und du nicht mehr mitspielen kannst.</div>
				</div>
			</div>
			<div class="form-group">
				<label for="grade" class="col-sm-2 control-label">Klasse</label>
				<div class="col-sm-10">
					<select name="grade" required class="form-control" id="grade">
						<optgroup label="Lehrer/in">
							<option name="grade" <?php if ($grade == "Lehrer/in") echo " selected "; ?>value="Lehrer/in">Lehrer/in</option>
							<option name="grade" <?php if ($grade == "Studienseminar 17/19") echo " selected "; ?>value="Studienseminar 17/19">Studienseminar 17/19</option>
							<option name="grade" <?php if ($grade == "Studienseminar 20/18") echo " selected "; ?>value="Studienseminar 18/20">Studienseminar 18/20</option>
							
						</optgroup>
						<optgroup label="Jahrgangsstufe 5">
							<option name="grade" <?php if ($grade == "5a" OR !$grade) echo " selected "; ?>value="5a">5a</option>
							<option name="grade" <?php if ($grade == "5b") echo " selected "; ?>value="5b">5b</option>
							<option name="grade" <?php if ($grade == "5c") echo " selected "; ?>value="5c">5c</option>
							<option name="grade" <?php if ($grade == "5d") echo " selected "; ?>value="5d">5d</option>
							<option name="grade" <?php if ($grade == "5e") echo " selected "; ?>value="5e">5e</option>
						</optgroup>
						<optgroup label="Jahrgangsstufe 6">
							<option name="grade" <?php if ($grade == "6a") echo " selected "; ?>value="6a">6a</option>
							<option name="grade" <?php if ($grade == "6b") echo " selected "; ?>value="6b">6b</option>
							<option name="grade" <?php if ($grade == "6c") echo " selected "; ?>value="6c">6c</option>
							<option name="grade" <?php if ($grade == "6d") echo " selected "; ?>value="6d">6d</option>
							<option name="grade" <?php if ($grade == "6e") echo " selected "; ?>value="6e">6e</option>
						</optgroup>
						<optgroup label="Jahrgangsstufe 7">
							<option name="grade" <?php if ($grade == "7a") echo " selected "; ?>value="7a">7a</option>
							<option name="grade" <?php if ($grade == "7b") echo " selected "; ?>value="7b">7b</option>
							<option name="grade" <?php if ($grade == "7c") echo " selected "; ?>value="7c">7c</option>
							<option name="grade" <?php if ($grade == "7d") echo " selected "; ?>value="7d">7d</option>
							<option name="grade" <?php if ($grade == "7e") echo " selected "; ?>value="7e">7e</option>
						</optgroup>

						<optgroup label="Jahrgangsstufe 8">
							<option name="grade" <?php if ($grade == "8a") echo " selected "; ?>value="8a">8a</option>
							<option name="grade" <?php if ($grade == "8b") echo " selected "; ?>value="8b">8b</option>
							<option name="grade" <?php if ($grade == "8c") echo " selected "; ?>value="8c">8c</option>
							<option name="grade" <?php if ($grade == "8d") echo " selected "; ?>value="8d">8d</option>
						</optgroup>
						<optgroup label="Jahrgangsstufe 9">
							<option name="grade" <?php if ($grade == "9a") echo " selected "; ?>value="9a">9a</option>
							<option name="grade" <?php if ($grade == "9b") echo " selected "; ?>value="9b">9b</option>
							<option name="grade" <?php if ($grade == "9c") echo " selected "; ?>value="9c">9c</option>
							<option name="grade" <?php if ($grade == "9d") echo " selected "; ?>value="9d">9d</option>
						<optgroup label="Jahrgangsstufe 10">
							<option name="grade" <?php if ($grade == "10a") echo " selected "; ?>value="10a">10a</option>
							<option name="grade" <?php if ($grade == "10b") echo " selected "; ?>value="10b">10b</option>
							<option name="grade" <?php if ($grade == "10c") echo " selected "; ?>value="10c">10c</option>
							<option name="grade" <?php if ($grade == "10d") echo " selected "; ?>value="10d">10d</option>
						</optgroup>
						<optgroup label="Jahrgangsstufe 11">
							<option name="grade" <?php if ($grade == "Q11") echo " selected "; ?>value="Q11">Q11</option>
						</optgroup>
						<optgroup label="Jahrgangsstufe 12">
							<option name="grade" <?php if ($grade == "Q12") echo " selected "; ?>value="Q12">Q12</option>
						</optgroup>
					</select>
					<div class="alert alert-info text-left" role="alert">Bitte gib hier deine richtige Klasse bzw. deinen Oberstufenjahrgang an, da dein Benutzer sonst blockiert wird und du nicht mehr mitspielen kannst.
						<br>Wenn Sie eine Lehrkraft sind, wählen Sie bitte <i>Lehrer/in</i> oder das entsprechende Studienseminar aus.</div>
						
				</div>
			</div>
			
			<div class="form-group">
				<label for="nickname" class="col-sm-2 control-label">Nickname</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" required id="nickname" value="<?php echo $nickname; ?>" name="nickname" placeholder="Nickname">
					<div class="alert alert-info text-left" role="alert">Dein Nickname soll ein erfundener Name sein, mit dem du in der Bestenliste auf der Schulhomepage angezeigt wirst, z.B. <i>Özil2</i>. Es sind nur Buchstaben, Umlaute, Zahlen, Lehrzeichen, Punkte und Unterstriche erlaubt!<br>Benutzer, deren Nicknamen eine Beleidigung enthalten oder gegen die Regeln der guten Sitten verstoßen, werden gelöscht.</div>
				</div>
			</div>
			<div class="form-group">
				<label for="password" class="col-sm-2 control-label">Passwort</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" required id="password" name="password" placeholder="Passwort">
					<div class="alert alert-info text-left" role="alert">Dein Passwort muss folgende Kriterien erfüllen:
						<ol>
							<li>mindestens 5 Zeichen</li>
							<li>mindestens 1 Kleinbuchstabe</li>
							<li>mindestens 1 Großbuchstabe</li>
							<li>mindestens 1 Zahl</li>
						</ol>
						Merke es dir gut und gib es nicht weiter!
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="password2" class="col-sm-2 control-label">Passwort wiederholen</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" required id="password2" name="password2" placeholder="Passwort wiederholen">
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" name="submit" value="Registrieren" class="btn btn-primary">
				</div>
			</div>
			
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
