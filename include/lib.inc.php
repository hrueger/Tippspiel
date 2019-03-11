<?php
	session_start();
	date_default_timezone_set("Europe/Berlin");
	setlocale(LC_TIME, "de_DE.utf8");
	//echo date_default_timezone_get();
	//echo phpinfo();
	$loggedin = (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) ? true : false;
	function alert($type, $message) {
		echo "	<div class='alert alert-$type'>
					$message
				</div>";
	}
	
	function getTimeObjBetween($startDate, $endDate) {
		$ONE_SECOND = 1000;
		$ONE_MINUTE = 60 * $ONE_SECOND;
		$ONE_HOUR = 60 * $ONE_MINUTE;
		$ONE_DAY = 24 * $ONE_HOUR;

		$resultObject = new stdClass();
		$resultObject->totalDays = 0;
		$resultObject->hours = 0;
		$resultObject->minutes = 0;
		$resultObject->seconds = 0;
			

		$timespan = $endDate - $startDate;

		$dayCount = $timespan / $ONE_DAY;
		$resultObject->totalDays = floor($dayCount);

		$hours = ($dayCount - $resultObject->totalDays) * 24;
		$resultObject->hours = floor($hours);

		$minutes = ($hours - $resultObject->hours) * 60;
		$resultObject->minutes = floor($minutes);

		$seconds = ($minutes - $resultObject->minutes) * 60;
		$resultObject->seconds = floor($seconds);

		return $resultObject;
	}

	function getSpielplan($db, $link, $showTipps, $round) {
		//echo $round;
		$oneHTML = "";
		$color = "";
		if ($round == "gruppen") {
			$query = 'SELECT *, TIMESTAMPDIFF(SECOND,CURRENT_TIMESTAMP(),`date`) AS timeleft FROM `matches` WHERE korunde=0 ORDER BY `group` ASC, `date` ASC';
			//echo "gruppen";
		} else {
			if ($round == "platz3") {
				$query = "SELECT *, TIMESTAMPDIFF(SECOND,CURRENT_TIMESTAMP(),`date`) AS timeleft FROM `matches` WHERE `group` = 'Spiel um Platz 3'";
				$oneHTML = "centreBox ";
				$color = "blue";
			} else if ($round != "finale") {
				$query = "SELECT *, TIMESTAMPDIFF(SECOND,CURRENT_TIMESTAMP(),`date`) AS timeleft FROM `matches` WHERE `group` LIKE '%$round"."finale%' ORDER BY `date` ASC";
				if ($round == "halb") {
					$color = "green";
				} else if ($round == "viertel") {
					$color = "red";
				} 
				//echo $query;
			} else {
				$query = "SELECT *, TIMESTAMPDIFF(SECOND,CURRENT_TIMESTAMP(),`date`) AS timeleft FROM `matches` WHERE `group` LIKE 'Finale'";
				$oneHTML = "centreBox ";
				$color = "yellow";
				
			}
		}
		$res = $db->query($query);
		//echo $db->error;
		if (!$res) {
			alert("danger", "Es wurden keine Spiele gefunden!");
		} else {
			$res = $res->fetch_all(MYSQLI_ASSOC);
			if (!$res) {
				alert("danger", "Es wurden keine Spiele gefunden!");
			} else {
				$matches = $res;
				//echo "<pre>";
				//var_dump($res);
				$res = $db->query("SELECT * FROM teams");
				$res = $res->fetch_all(MYSQLI_ASSOC);
				$names = array();
				foreach ($res as $team) {
					$names[$team["short"]] = $team["name"];
				}
				
				$groups = array();
				foreach ($matches as $match) {
					$groups[$match["group"]][] = $match;
					//echo $match["group"] . ": ".$match["team1"] . " vs " . $match["team2"]."<br>";
					
				}
				echo "<div class='spielplan clearfix'>";
				if ($showTipps) {
					$uid = $db->real_escape_string($_SESSION["userid"]);
					//echo $uid;
					$res = $db->query("SELECT * FROM tipps WHERE userid=$uid");
					if ($res) {
						$tipps = [];
						$res = $res->fetch_all(MYSQLI_ASSOC);
						if (!$res) {
							$tipps = [];
						} else {
							$tipps = $res;
						}
					} else {
						$tipps = [];
					}
					//echo "<pre>";
					//var_dump($res);
					$tippArray = array();
					foreach ($tipps as $tipp) {
						$tippArray[$tipp["matchid"]] = $tipp;
					}
				}
				
				
				//var_dump($groups);
				//echo "</pre>";
				
				
				
				;
				foreach ($groups as $name => $group) {
					$team = $name;
					$groupHTML = ($round != "gruppen") ? "" : "Gruppe ";
					$colorHTML = $color;
					echo "<table class='$colorHTML centreBox'><thead><tr><th>Team 1</th><th class='groupname'>$groupHTML$team</th><th>Team 2</th><th class='countdown'>Countdown</th></tr>"; /// class: $oneHTML group
					echo "<tbody>";
					foreach ($group as $match) {
						$gid = $match["id"];
						$goalsTeam1 = $match["goalsTeam1"];
						$goalsTeam2 = $match["goalsTeam2"];
						if ($goalsTeam1 < 0 AND $goalsTeam2 < 0) {
							$goalsTeam1 = "--";
							$goalsTeam2 = "--";
						}
						//var_dump($tippArray[$gid]);
						$tippTeam1 = (isset($tippArray[$gid]["tippTeam1"])) ? $tippArray[$gid]["tippTeam1"] : "";
						$tippTeam2 = (isset($tippArray[$gid]["tippTeam2"])) ? $tippArray[$gid]["tippTeam2"] : "";
						
						if ($showTipps == true) {
							$tippHTML = "<br><span>".$tippTeam1." : ".$tippTeam2."</span>";
						} else {
							$tippHTML = "";
						}
						
						if ($round != "gruppen") {
							$name1 = $match["team1"];
							$name2 = $match["team2"];
						} else {
							$name1 = $names[$match["team1"]];
							$name2 = $names[$match["team2"]];
						}
						
						$kuerzel1 = ($match["team1"] == "?" OR strlen($match["team1"]) != 3) ? "unknown" : $match["team1"];
						$kuerzel2 = ($match["team2"] == "?" OR strlen($match["team2"]) != 3) ? "unknown" : $match["team2"];
						
						//$match_time = date('\a\m d.m.Y \u\m H:i \U\h\r',strtotime($match["date"]));
						//echo "<pre>";
						$diff = $match["timeleft"]-60;
						$months = floor($diff/60/60/24/30);
						$diff = $diff-($months*60*60*24*30);
						$days = floor(($diff)/60/60/24);
						$diff = $diff-($days*60*60*24);
						$hours = floor(($diff)/60/60);
						$diff = $diff-($hours*60*60);
						$minutes = floor(($diff)/60);
						$seconds = $diff-($minutes*60);
						
						
						
						//echo "</pre>";
						//$match_start = strtotime($match["date"])-60;
						//$diff = $match_start-time();
						//echo $diff."<br>";
						//$start_date = new DateTime("@$date");
						//$now = new DateTime('NOW');
						//echo $start_date->format("Y-m-d H:i:s")."<br>";
						//echo "Haööp ksjdfasvdfmüapsfjvpsfvafvdfasefvfawavfw";
						//echo "<br>Time of $ now is ".$now->format('Y-m-d H:i:s');;
						//$now->add(date_interval_create_from_date_string('1 minute'));
						//$since_start = $start_date->diff($now); /// eine Minute abziehen
						//$date->sub(date_interval_create_from_date_string('1 minute'));
						//$difference = $start_date->getTimestamp() - time();
						//echo $difference."<br>";
						//$months = date('n', $diff) == 0;
						//$months = ($months == 0) ? $months : $months-1;
						//$days = date('j', $diff);
						//$days = ($days == 0) ? $days : $days-1;
						//$hours = date('G', $diff);
						//$hours = ($hours == 0) ? $hours : $hours-1;
						//$minutes = date('i', $diff);
						//$minutes = ($minutes == 0) ? $minutes : $minutes-1;
						$anstoss = "am ".strftime("%A", strtotime($match["date"])).", ".date('d.m.o \u\m H:i', strtotime($match["date"]))." Uhr";
						if ($match["timeleft"] < 60) {
							$vorbei = true;
							$countdown = "<b><span>Bereits vorbei!</span><b>";
						} else {
							$vorbei = false;
							if ($months <= 0) {
								if ($days <= 0) {
									if ($hours <= 0) {
										$countdown = "$minutes Minuten";
									} else {
										$countdown = "$hours Stunden und $minutes Minuten";
									}
								} else {
									$countdown = "$days Tage, $hours Stunden und $minutes Minuten";
								}
							} else {
								$countdown = "$months Monate, $days Tage, $hours Stunden und $minutes Minuten";
							}
							$countdown = $anstoss."<br><b>noch ".$countdown."</b>";
						}
						
						
						
						// $start_date->format("Y-m-d H:i:s").
						//$countdown .= " ID:".$match["id"];
						
						
						
						echo "<tr class='match'>";
						
							echo "<td class='logoNameLeft'>".(($vorbei && $showTipps) ? "" : "<a href='$link$gid'>")."<img class='teamIcon' src='./images/teams/".$kuerzel1.".jpg'>&nbsp;&nbsp;".$name1."".(($vorbei && $showTipps) ? "" : "</a>")."</td>";
							echo "<td class='result'>".(($vorbei && $showTipps) ? "" : "<a href='$link$gid'>")."<b>".$goalsTeam1." : ".$goalsTeam2."</b>$tippHTML".(($vorbei && $showTipps) ? "" : "</a>")."</td>";
							echo "<td class='logoNameRight'>".(($vorbei && $showTipps) ? "" : "<a href='$link$gid'>")."".$name2."&nbsp;&nbsp;<img class='teamIcon' src='./images/teams/".$kuerzel2.".jpg'>".(($vorbei && $showTipps) ? "" : "</a>")."</td>";
							//echo "<td class='countdown'><a href='$link$gid'>$match_time</a></td>";
							echo "<td class='countdown'>".(($vorbei && $showTipps) ? "" : "<a href='$link$gid'>")."$countdown".(($vorbei && $showTipps) ? "" : "</a>")."</td>";
							
						echo "</tr>";
					}
					echo "</tbody>";
					echo "</table>";
				}
				echo "</div><hr>";
			}
		}
	}
	
	function getSpielplanOrderByDate($db, $link, $showTipps, $what) {
		//echo "Nach Datum geordnet";
		//echo $round;
		$oneHTML = "";
		$color = "";
		
		$where = "";
		$round = "ko";
		if (in_array("gruppen", $what)) {
			$where = "WHERE korunde=0 ";
			$round = "gruppen";
		}
		if (in_array("achtel", $what)) {
			$where .= " OR `group` LIKE 'achtelfinale%' ";
		}
		if (in_array("viertel", $what)) {
			$where .= " OR `group` LIKE 'viertelfinale%' ";
		}
		if (in_array("halb", $what)) {
			$where .= " OR `group` LIKE 'halbfinale%' ";
		}
		if (in_array("finale", $what)) {
			$where .= " OR `group` LIKE 'finale' ";
		}
		if (in_array("platz3", $what)) {
			$where .= " OR `group` = 'Spiel um Platz 3' ";
		}
		
		$query = "SELECT *, TIMESTAMPDIFF(SECOND,CURRENT_TIMESTAMP(),`date`) AS timeleft FROM `matches` $where ORDER BY `date` ASC";
		
		$res = $db->query($query);
		echo $db->error;
		if (!$res) {
			alert("danger", "Es wurden keine Spiele gefunden!");
		} else {
			$res = $res->fetch_all(MYSQLI_ASSOC);
			if (!$res) {
				alert("danger", "Es wurden keine Spiele gefunden!");
			} else {
				$matches = $res;
				//echo "<pre>";
				//var_dump($res);
				$res = $db->query("SELECT * FROM teams");
				$res = $res->fetch_all(MYSQLI_ASSOC);
				$names = array();
				foreach ($res as $team) {
					$names[$team["short"]] = $team["name"];
				}
				
				$groups = array();
				foreach ($matches as $match) {
					$groups[][] = $match;
					//echo $match["group"] . ": ".$match["team1"] . " vs " . $match["team2"]."<br>";
					
				}
				echo "<div class='spielplan clearfix'>";
				if ($showTipps) {
					$uid = $db->real_escape_string($_SESSION["userid"]);
					//echo $uid;
					$res = $db->query("SELECT * FROM tipps WHERE userid=$uid");
					if ($res) {
						$tipps = [];
						$res = $res->fetch_all(MYSQLI_ASSOC);
						if (!$res) {
							$tipps = [];
						} else {
							$tipps = $res;
						}
					} else {
						$tipps = [];
					}
					//echo "<pre>";
					//var_dump($res);
					$tippArray = array();
					foreach ($tipps as $tipp) {
						$tippArray[$tipp["matchid"]] = $tipp;
					}
				}
				
				
				//var_dump($groups);
				//echo "</pre>";
				
				
				$schonVorbei = [];
				
				foreach ($groups as $name => $group) {
					$team = $name;
					
					$colorHTML = $color;
					/*echo "<table class='$colorHTML centreBox'><thead><tr><th>Team 1</th><th class='groupname'>$groupHTML$team</th><th>Team 2</th><th class='countdown'>Countdown</th></tr>"; /// class: $oneHTML group*/
					//echo "<tbody>";
					foreach ($group as $match) {
						$groupHTML = ($match["korunde"] == "1") ? $match["group"] : "Gruppe ".$match["group"];
						$gid = $match["id"];
						$goalsTeam1 = $match["goalsTeam1"];
						$goalsTeam2 = $match["goalsTeam2"];
						if ($goalsTeam1 < 0 AND $goalsTeam2 < 0) {
							$goalsTeam1 = "--";
							$goalsTeam2 = "--";
						}
						//var_dump($tippArray[$gid]);
						$tippTeam1 = (isset($tippArray[$gid]["tippTeam1"])) ? $tippArray[$gid]["tippTeam1"] : "";
						$tippTeam2 = (isset($tippArray[$gid]["tippTeam2"])) ? $tippArray[$gid]["tippTeam2"] : "";
						
						if ($showTipps == true) {
							$tippHTML = "<br><span>".$tippTeam1." : ".$tippTeam2."</span>";
						} else {
							$tippHTML = "";
						}
						
						if ($match["korunde"] == "1") {
							$name1 = $match["team1"];
							$name2 = $match["team2"];
						} else {
							$name1 = $names[$match["team1"]];
							$name2 = $names[$match["team2"]];
						}
						
						$kuerzel1 = ($match["team1"] == "?" OR strlen($match["team1"]) != 3) ? "unknown" : $match["team1"];
						$kuerzel2 = ($match["team2"] == "?" OR strlen($match["team2"]) != 3) ? "unknown" : $match["team2"];
						
						//$match_time = date('\a\m d.m.Y \u\m H:i \U\h\r',strtotime($match["date"]));
						//echo "<pre>";
						$diff = $match["timeleft"]-60;
						$months = floor($diff/60/60/24/30);
						$diff = $diff-($months*60*60*24*30);
						$days = floor(($diff)/60/60/24);
						$diff = $diff-($days*60*60*24);
						$hours = floor(($diff)/60/60);
						$diff = $diff-($hours*60*60);
						$minutes = floor(($diff)/60);
						$seconds = $diff-($minutes*60);
						
						
						
						//echo "</pre>";
						//$match_start = strtotime($match["date"])-60;
						//$diff = $match_start-time();
						//echo $diff."<br>";
						//$start_date = new DateTime("@$date");
						//$now = new DateTime('NOW');
						//echo $start_date->format("Y-m-d H:i:s")."<br>";
						//echo "Haööp ksjdfasvdfmüapsfjvpsfvafvdfasefvfawavfw";
						//echo "<br>Time of $ now is ".$now->format('Y-m-d H:i:s');;
						//$now->add(date_interval_create_from_date_string('1 minute'));
						//$since_start = $start_date->diff($now); /// eine Minute abziehen
						//$date->sub(date_interval_create_from_date_string('1 minute'));
						//$difference = $start_date->getTimestamp() - time();
						//echo $difference."<br>";
						//$months = date('n', $diff) == 0;
						//$months = ($months == 0) ? $months : $months-1;
						//$days = date('j', $diff);
						//$days = ($days == 0) ? $days : $days-1;
						//$hours = date('G', $diff);
						//$hours = ($hours == 0) ? $hours : $hours-1;
						//$minutes = date('i', $diff);
						//$minutes = ($minutes == 0) ? $minutes : $minutes-1;
						$anstoss = "am ".strftime("%A", strtotime($match["date"])).", ".date('d.m.o \u\m H:i', strtotime($match["date"]))." Uhr";
						if ($match["timeleft"] < 60) {
							$vorbei = true;
							$countdown = "<b><span>Bereits vorbei!</span><b>";
							
						} else {
							$vorbei = false;
							if ($months <= 0) {
								if ($days <= 0) {
									if ($hours <= 0) {
										$countdown = "$minutes Minuten";
									} else {
										$countdown = "$hours Stunden und $minutes Minuten";
									}
								} else {
									$countdown = "$days Tage, $hours Stunden und $minutes Minuten";
								}
							} else {
								$countdown = "$months Monate, $days Tage, $hours Stunden und $minutes Minuten";
							}
							$countdown = $anstoss."<br><b>noch ".$countdown."</b>";
						}
						
						
						
						// $start_date->format("Y-m-d H:i:s").
						//$countdown .= " ID:".$match["id"];
						
						
						
						$matchHTML = "<table class='$colorHTML centreBox'><thead><tr><th>Team 1</th><th class='groupname'>$groupHTML</th><th>Team 2</th><th class='countdown'>Countdown</th></tr><tbody><tr class='match'>";
						
							$matchHTML .=  "<td class='logoNameLeft'>".(($vorbei && $showTipps) ? "" : "<a href='$link$gid'>")."<img class='teamIcon' src='./images/teams/".$kuerzel1.".jpg'>&nbsp;&nbsp;".$name1."".(($vorbei && $showTipps) ? "" : "</a>")."</td>";
							$matchHTML .=   "<td class='result'>".(($vorbei && $showTipps) ? "" : "<a href='$link$gid'>")."<b>".$goalsTeam1." : ".$goalsTeam2."</b>$tippHTML".(($vorbei && $showTipps) ? "" : "</a>")."</td>";
							$matchHTML .=   "<td class='logoNameRight'>".(($vorbei && $showTipps) ? "" : "<a href='$link$gid'>")."".$name2."&nbsp;&nbsp;<img class='teamIcon' src='./images/teams/".$kuerzel2.".jpg'>".(($vorbei && $showTipps) ? "" : "</a>")."</td>";
							//echo "<td class='countdown'><a href='$link$gid'>$match_time</a></td>";
							$matchHTML .=   "<td class='countdown'>".(($vorbei && $showTipps) ? "" : "<a href='$link$gid'>")."$countdown".(($vorbei && $showTipps) ? "" : "</a>")."</td>";
							
						$matchHTML .=   "</tr>";
						$matchHTML .=   "</tbody>";
						$matchHTML .=   "</table>";
						if ($vorbei) {
							$schonVorbei[] = $matchHTML;
						} else {
							echo $matchHTML;
						}
						
					}
					
					
				}
				$schonVorbei = array_reverse($schonVorbei);
					foreach ($schonVorbei as $match) {
						echo $match;
					}
				echo "</div><hr>";
			}
		}
	}
	
	function updatePoints() {
		$db = connect();
		$res = $db->query("SELECT * FROM users");
		if (!$res) {
			alert("danger", "Es wurden keine Benutzer gefunden!");
			die();
		} else {
			$res = $res->fetch_all(MYSQLI_ASSOC);
			if (!$res) {
				alert("danger", "Es wurden keine Benutzer gefunden!");
				die();
			} else {
				$users = $res;
			}
		}
		
		$res = $db->query("SELECT * FROM matches");
		if (!$res) {
			alert("danger", "Es wurden keine Spiele gefunden!");
			die();
		} else {
			$res = $res->fetch_all(MYSQLI_ASSOC);
			if (!$res) {
				alert("danger", "Es wurden keine Spiele gefunden!");
				die();
			}
		}
		$matches = [];
		foreach ($res as $match) {
			$matches[$match["id"]] = $match;
		}
		
		$res = $db->query("SELECT * FROM tipps");
		if (!$res) {
			alert("danger", "Es wurden keine Tipps gefunden!");
			die();
		} else {
			$res = $res->fetch_all(MYSQLI_ASSOC);
			if (!$res) {
				alert("danger", "Es wurden keine Tipps gefunden!");
				die();
			} else {
				$tipps = $res;
			}
		}
		
		// Finde Weltmeister
		$res = $db->query("SELECT * FROM matches WHERE `group`='Finale'");
		if ($res) {
			$res = $res->fetch_all(MYSQLI_ASSOC);
			if ($res) {
				$res = $res[0];
				if ($res) {
					if ($res["goalsTeam1"] > $res["goalsTeam2"]) {
						$weltmeister = $res["team1"];
					} else {
						$weltmeister = $res["team2"];
					}
				} else {
					$weltmeister = false;
				}
			}else {
				$weltmeister = false;
			}
		}else {
			$weltmeister = false;
		}
		//var_dump($weltmeister);
		//echo $db->error;
		$userPoints = [];
		$champions = [];
		foreach ($users as $user) {
			$userpoints[$user["id"]] = 0;
			//echo "Der Benutzer ".$user["name"]." hat die ID ".$user["id"]."<br>";
			//$champions[$user["id"]] = $user["worldchampion"];
			if ($weltmeister) {
				if ($user["worldchampion"] == $weltmeister) {
					$userpoints[$user["id"]] += 80;
					//echo "points added!";
					//echo $user["id"]." hat 80 Punkte für den Weltmeister bekommen<br>";
				} else {
					//var_dump($tippedChampion);
					//var_dump($weltmeister);
				}
			} else {
				//echo "no wm<br>";
			}
		}
		echo "<br>";
		foreach ($tipps as $tipp) {
			//echo "tipp<br>";
			$userid = $tipp["userid"];
			$matchid = $tipp["matchid"];
			$tippTeam1 = $tipp["tippTeam1"];
			$tippTeam2 = $tipp["tippTeam2"];
			$goalsTeam1 = $matches[$matchid]["goalsTeam1"];
			$goalsTeam2 = $matches[$matchid]["goalsTeam2"];
			
			if (!is_numeric($goalsTeam1) || !is_numeric($goalsTeam2) || $goalsTeam1 < 0 || $goalsTeam2 < 0) {
				//echo $userid . " hat in Spiel $matchid von der Runde $matchtype keine Punkte erreicht, weil die Spieltore von Team1 oder Team2 nicht numerisch waren.<br>";
			} else {
				if ($matches[$matchid]["korunde"] == 0) {
					$matchtype = "gruppen";
					$faktor = 1;
				} elseif (strpos($matches[$matchid]["group"], 'Achtelfinale') !== false) {
					$matchtype = "achtel";
					$faktor = 1.5;
				} elseif (strpos($matches[$matchid]["group"], 'Viertelfinale') !== false) {
					$matchtype = "viertel";
					$faktor = 2;
				} elseif (strpos($matches[$matchid]["group"], 'Halbfinale') !== false) {
					$matchtype = "halb";
					$faktor = 2.5;
				} elseif (strpos($matches[$matchid]["group"], 'Finale') !== false) {
					$matchtype = "finale";
					$faktor = 4;
				} elseif (strpos($matches[$matchid]["group"], 'Spiel um Platz 3') !== false) {
					$matchtype = "platz3";
					$faktor = 3;
				} else {
					die("großer Fehler");
				}
				//echo "<pre>";
				//var_dump($matches[$matchid]);
				//echo "</pre>";

				$spielpunkte = 0;

				if ($goalsTeam1 != $goalsTeam2) {
					// kein Unentschieden
					if (($tippTeam1 == $goalsTeam1) && ($tippTeam2 == $goalsTeam2)) {
						//echo "ergebnis!<br>";
						$spielpunkte = 30;
						//echo $userid." hat 30 Punkte für das richtige Ergebnis bei keinem Unentschieden bekommen<br>";
						//echo $tippTeam1."=>".$goalsTeam1."<br>";
						//echo $tippTeam2."=>".$goalsTeam2."<br>";
					} else if (($tippTeam1 - $tippTeam2) === ($goalsTeam1 - $goalsTeam2)) {
						//echo "differenz!<br>";
						$spielpunkte = 20;
						//echo $userid." hat 20 Punkte für die richtige Differenz bei keinem Unentschieden bekommen<br>";
					} else if (($tippTeam1 < $tippTeam2) == ($goalsTeam1 < $goalsTeam2) && ($tippTeam1 != $tippTeam2)) {
						//echo "tendenz!<br>";
						$spielpunkte = 10;
						//echo $userid." hat 10 Punkte für die richtige Tendenz bei keinem Unentschieden bekommen<br>";
					}


				} else {
					// Unentschieden
					if (($tippTeam1 == $goalsTeam1) && ($tippTeam2 == $goalsTeam2)) {
						//echo "ergebnis!<br>";
						$spielpunkte = 30;

						//echo $userid." hat 30 Punkte für das richtige Ergebnis bei einem Unentschieden bekommen<br>";
					} else if (($tippTeam1 == $tippTeam2)) {
						//echo "tendenz!<br>";
						$spielpunkte = 10;
						//echo $userid." hat 10 Punkte für die richtige Tendenz bei einem Unentschieden bekommen<br>";
					}

				}
				//echo $userid . " hat in Spiel $matchid von der Runde $matchtype folgende Punkte erreicht: $spielpunkte, die noch mit $faktor multipliziert werden: ".$spielpunkte*$faktor."<br>";
				$userpoints[$userid] += $spielpunkte*$faktor;
				// Weltmeistercheck:

			}
			
			
			
			
		}
		//echo "<pre>";
		//var_dump($userpoints[16]);
		//echo "</pre>";
		
		foreach ($userpoints as $id => $points) {
			$id = $db->real_escape_string($id);
			$points = $db->real_escape_string($points);
			$db->query("UPDATE users SET points=$points WHERE id=$id");
			echo $db->error;
		}
	}
	
	function createBestenliste($query, $whereami) {
		$html = "";
		$db = connect();
		//updatePoints();
		
		if ($query != "grades") {
			$res = $db->query($query);
			//echo $db->error;
			if (!$res) {
				alert("danger", "Es wurden keine Benutzer gefunden!<br>Fehler: ".$db->error);
				
			} else {
				$res = $res->fetch_all(MYSQLI_ASSOC);
				if (!$res) {
					alert("warning", "Es haben noch keine Spieler am Tippspiel teilgenommen!");
				} else {
					$counter = 0;
					$html .= "<table class='table table-responsive table-striped table-hover'><thead><th>Rang</th><th>Punkte</th><th>Klasse</th><th>Nickname</th></thead><tbody>";
					$letztePunkte = -1;
					$gesamtcounter = 0;
					foreach ($res as $user) {
						$nickname = htmlspecialchars($user["nickname"]);
						$grade = htmlspecialchars($user["grade"]);
						$points = htmlspecialchars($user["points"]);
						
						if ($letztePunkte != (int) $user["points"]) {
							$counter ++;
							$letztePunkte = (int) $user["points"];
						}
						
						$html .= "<tr";
						if ($whereami == true and $user["id"] == $_SESSION["userid"]) {
							$meinplatz = $counter;
							$html .= " class='success' id='me'";
						}
						$html .= "><td>$counter</td><td>$points</td><td>$grade</td><td>$nickname</td></tr>";
						//echo $letztePunkte."---".$user["points"]."<br>";
						$gesamtcounter ++;
					}
					$html .= "</tbody></table>";
				}
			}
		} else {
			$res = $db->query("SELECT * FROM users");
			//echo $db->error;
			if (!$res) {
				alert("danger", "Es wurden keine Benutzer gefunden!<br>Fehler: ".$db->error);
				
			} else {
				$res = $res->fetch_all(MYSQLI_ASSOC);
				if (!$res) {
					alert("warning", "Es haben noch keine Spieler am Tippspiel teilgenommen!");
				} else {
					$grades = [];
					$letztePunkte = -1;
					foreach ($res as $user) {
						if (!isset($grades[$user["grade"]])) {
							
							$grades[$user["grade"]] = array();
							$grades[$user["grade"]]["count"] = 1;
							$grades[$user["grade"]]["points"] = intval($user["points"]);
						} else {
							$grades[$user["grade"]]["count"] += 1;
							$grades[$user["grade"]]["points"] += intval($user["points"]);
						}
						
					}
					
					foreach ($grades as $key => $grade) {
						$grades[$key] = round($grade["points"] / $grade["count"], 1);
						
						
					}
					
					arsort($grades);
					
					//echo "<pre>";
					//var_dump($grades);
					//echo "</pre>";

					$counter = 0;
					$html .= "<table class='table table-responsive table-striped table-hover'><thead><th>Rang</th><th>Durchschnittliche Punktzahl</th><th>Klasse</th></thead><tbody>";
					foreach ($grades as $name => $grade) {
						$gradename = ($name == "Lehrer/in") ? "Lehrer" : htmlspecialchars($name);
						$points = htmlspecialchars($grade);
						if ($letztePunkte != (int) $points) {
							$counter ++;
							$letztePunkte = (int) $points;
						}
						$html .= "<tr><td>$counter</td><td>$points</td><td>$gradename</td></tr>";
						//$counter ++;
						
					}
					$html .= "</tbody></table>";
				}
			}
			
			
		}
		if ($whereami) {
			echo "<br><br>";
			alert("info", "Du bist aktuell auf dem $meinplatz. Platz von $gesamtcounter Teilnehmern!");
		}
		echo $html;
	}

?>