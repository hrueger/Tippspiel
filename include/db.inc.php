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
	//echo "connected to database!";
?>