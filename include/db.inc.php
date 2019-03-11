<?php
	function connect()  {
		$db = new mysqli("localhost", "allgymtipp", "rTBX5QdjKZfiWsU9k4w5LgEL", "allgymtipp1");

		if ($db->connect_errno) {
			alert("danger", "Verbindung fehlgeschlagen: " . $db->connect_error);
			die();
		}
		$db->query("SET NAMES utf8");
		return $db;
	}
<<<<<<< HEAD
	//echo "connected to database!";
=======
	//echo "connected to database!";    
>>>>>>> 28d6cb27d09f099648cd2e6a14972ded2a4f8b0a
?>