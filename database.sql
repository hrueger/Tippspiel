

CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


INSERT INTO admins VALUES
("1","Andreas Herz","$2y$10$2QPgEPC.MdnFbFB20jVmwOGTTYIVkUFnyZuYm.5kCkoTldxElUbhS"),
("2","Gordian Hunecke","$2y$10$6wvOIBi9X11qjVTClOrTJ.SAMAQnEvI1YIcJ4vdRy38ppXmKkx55W");




CREATE TABLE `matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group` text COLLATE utf8_german2_ci NOT NULL,
  `date` datetime NOT NULL,
  `team1` text COLLATE utf8_german2_ci NOT NULL,
  `team2` text COLLATE utf8_german2_ci NOT NULL,
  `place` text COLLATE utf8_german2_ci NOT NULL,
  `goalsTeam1` int(11) NOT NULL,
  `goalsTeam2` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;


INSERT INTO matches VALUES
("2","A","2018-06-14 17:00:00","RUS","KSA","Moskau","1","2"),
("4","G","2018-06-18 17:00:00","BEL","PAN","Sotchi","-1","-1"),
("5","A","2018-06-15 14:00:00","EGY","URU","Jekateringburug","2","2"),
("6","E","2018-06-17 14:00:00","CRC","SRB","Samara","-1","-1"),
("7","G","2018-06-18 20:00:00","TUN","ENG","Wolgograd","-1","-1"),
("8","E","2018-06-17 20:00:00","BRA","SUI","Rostow am Don","-1","-1"),
("9","A","2018-06-19 20:00:00","RUS","EGY","Sankt Petersburg","-1","-1"),
("10","C","2018-06-16 12:00:00","FRA","AUS","Kasan","-1","-1"),
("11","D","2018-06-16 15:00:00","ARG","ISL","Moskau","-1","-1"),
("12","G","2018-06-23 14:00:00","BEL","TUN","Moskau","-1","-1"),
("13","A","2018-06-20 17:00:00","URU","KSA","Rostow am Don","4","2"),
("14","E","2018-06-22 14:00:00","BRA","CRC","Sankt Petersburg","-1","-1"),
("15","G","2018-06-24 14:00:00","ENG","PAN","Nischni Nowgorod","-1","-1"),
("16","A","2018-06-25 16:00:00","URU","RUS","Samara","2","3"),
("17","E","2018-06-27 20:00:00","SRB","SUI","Kaliningrad","-1","-1"),
("18","C","2018-06-16 18:00:00","PER","DEN","Saransk","-1","-1"),
("19","E","2018-06-27 20:00:00","SRB","BRA","Moskau","-1","-1"),
("20","D","2018-06-16 21:00:00","CRO","NGA","Kaliningrad","-1","-1"),
("21","G","2018-06-28 20:00:00","ENG","BEL","Kaliningrad","-1","-1"),
("22","A","2018-06-25 16:00:00","KSA","EGY","Wolgograd","-1","-1"),
("23","C","2018-06-21 17:00:00","FRA","PER","Jekaterinburg","-1","-1"),
("24","B","2018-06-15 17:00:00","MAR","IRN","Sankt Petersburg","-1","-1"),
("25","E","2018-06-27 20:00:00","SUI","CRC","Nischni Nowgorod","-1","-1"),
("26","F","2018-06-17 17:00:00","GER","MEX","Moskau","-1","-1"),
("27","C","2018-06-21 14:00:00","DEN","AUS","Samara","-1","-1"),
("28","D","2018-06-21 20:00:00","ARG","CRO","Nischini Nowgorod","-1","-1"),
("29","G","2018-06-28 20:00:00","PAN","TUN","Saransk","-1","-1"),
("30","B","2018-06-15 20:00:00","POR","ESP","Sotschi","-1","-1"),
("31","F","2018-06-18 17:00:00","SWE","KOR","Nischni Nowgorod","-1","-1"),
("32","B","2018-06-20 14:00:00","POR","MAR","Moskau","-1","-1"),
("33","H","2018-06-19 17:00:00","POL","SEN","Moskau","-1","-1"),
("34","F","2018-06-23 20:00:00","GER","SWE","Sotschi","-1","-1"),
("35","C","2018-06-26 16:00:00","DEN","FRA","Moskau","-1","-1"),
("36","B","2018-06-20 20:00:00","IRN","ESP","Kasan","-1","-1"),
("37","H","2018-06-19 14:00:00","JPN","COL","Saransk","-1","-1"),
("38","B","2018-06-25 20:00:00","ESP","MAR","Kaliningrad","-1","-1"),
("39","F","2018-06-23 17:00:00","KOR","MEX","Rostow am Don","-1","-1"),
("40","C","2018-06-26 16:00:00","AUS","PER","Sotschi","-1","-1"),
("41","H","2018-06-24 17:00:00","JPN","SEN","Jekaterinburg","-1","-1"),
("42","B","2018-06-25 20:00:00","IRN","POR","Saransk","-1","-1"),
("43","H","2018-06-24 20:00:00","POL","COL","Kasan","-1","-1"),
("45","F","2018-06-27 16:00:00","MEX","SWE","Jekaterinburg","-1","-1"),
("46","H","2018-06-28 16:00:00","SEN","COL","Samara","-1","-1"),
("47","F","2018-06-27 16:00:00","KOR","GER","Kasan","-1","-1"),
("48","H","2018-06-28 16:00:00","JPN","POL","Wolgograd","-1","-1"),
("49","D","2018-06-22 17:00:00","NGA","ISL","Wolgograd","-1","-1"),
("50","D","2018-06-26 20:00:00","ISL","CRO","Rostow am Dom","-1","-1"),
("51","D","2018-06-26 20:00:00","NGA","ARG","Sankt Petersburg","-1","-1");




CREATE TABLE `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `short` text COLLATE utf8_german2_ci NOT NULL,
  `name` text COLLATE utf8_german2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;


INSERT INTO teams VALUES
("1","GER","Deutschland"),
("2","KSA","Saudi-Arabien"),
("3","MAR","Marokko"),
("4","MEX","Mexiko"),
("5","NGA","Nigeria"),
("6","PAN","Panama"),
("7","EGY","Ägypten"),
("8","PER","Peru"),
("9","POL","Polen"),
("10","ARG","Argentinien"),
("11","AUS","Australien"),
("12","BEL","Belgien"),
("13","POR","Portugal"),
("14","RUS","Russland"),
("15","BRA","Brasilien"),
("16","CRC","Costa-Rica\n"),
("17","DEN","Dänemark"),
("18","SEN","Senegal"),
("19","SRB","Serbien"),
("20","ENG","England"),
("21","FRA","Frankreich"),
("22","SUI","Schweiz"),
("23","SWE","Schweden"),
("24","TUN","Tunesien"),
("25","URU","Uruguay"),
("26","IRN","Iran"),
("27","ISL","Island"),
("28","JPN","Japan"),
("29","COL","Kolumbien"),
("30","KOR","Korea"),
("31","CRO","Kroatien"),
("32","ESP","Spanien");




CREATE TABLE `tipps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `matchid` int(11) NOT NULL,
  `tippTeam1` int(11) NOT NULL,
  `tippTeam2` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;


INSERT INTO tipps VALUES
("3","14","2","13","13"),
("4","14","2","1","7"),
("5","10","6","4","7"),
("6","14","2","1","7"),
("7","14","2","1","5"),
("8","10","30","1","3"),
("9","14","2","1","2"),
("10","11","2","50","1"),
("11","10","16","3","3"),
("12","10","14","1","4"),
("13","14","2","1","21"),
("14","12","2","3","2"),
("15","12","5","1","2"),
("16","12","9","2","1"),
("17","12","13","2","3"),
("18","12","16","2","3"),
("19","12","22","2","1"),
("20","12","24","2","1"),
("21","12","30","1","3"),
("22","14","2","19","13"),
("23","14","2","1","2"),
("24","10","36","1","19"),
("25","10","36","1","19"),
("26","10","8","12","10"),
("27","14","16","2","3"),
("28","16","2","6","2"),
("29","16","2","6","2"),
("30","10","16","1","1"),
("31","10","5","1","1"),
("32","10","2","19","3"),
("33","10","9","0","0"),
("34","16","30","33","0"),
("35","16","16","2","3"),
("36","16","5","0","0"),
("37","16","5","1","0"),
("38","10","2","19","3"),
("39","10","2","19","3"),
("40","10","24","1","14"),
("41","10","24","1","14"),
("42","10","24","1","14"),
("43","10","24","1","14"),
("44","10","24","1","14"),
("45","10","32","14","4"),
("46","16","9","5","0"),
("47","16","7","99","0"),
("48","16","13","2","7"),
("49","16","22","25","75"),
("50","16","40","1","0"),
("51","14","24","4","1");




CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_german2_ci NOT NULL,
  `nickname` text COLLATE utf8_german2_ci NOT NULL,
  `grade` text COLLATE utf8_german2_ci NOT NULL,
  `password` text COLLATE utf8_german2_ci NOT NULL,
  `checked` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;


INSERT INTO users VALUES
("7","Gordian Hunecke","Jumagoro","10a","$2y$10$KGfBwN/fAi3VFCP92cPK..FrQ/XOb0nUY8VG6GTRY8JGbnm0yhex2","1"),
("10","Hannes Rüger","programmierer","8a","$2y$10$JVU5WXckGcKrpDWmQk24QOIPBA0minSxDlucdzwG4poWOR25raaa2","1"),
("11","Thomas Müller","Thomii","5a","$2y$10$cVGZeXIEqDeVjmFr8XORheJpKe2xA5YMhXJuQ4pOY.meV.3dSC3qe","-1"),
("12","Rohrer.Tobias","Joke","6e","$2y$10$9Wd.04WlOQEekq6tWU6/outhAhFuR/qVSHxnWwFakWuPFYQUirbYK","1"),
("13","Andreas Herz","Weißerpele","7c","$2y$10$AYibBmJji.NJxu41b/Ee4O.RoPDPg73uGU8pFjTOPoxlmLNVI6iZS","1"),
("14","Sebastian Bisle","Spastix","7b","$2y$10$lZee1lKrstSO7ECo0Dq5i.hZg5NGLfwzliNiWhZjJiuVt6lOmbXu2","1"),
("15","Andiii","AndreasEsBleibtAllesSoWieEsIst","Q12","$2y$10$2Exq7EDbs.RRsc5xxnXPPusrpyB8Qe0VQ2MwegCO1Xw5dI/5in8lC","-1"),
("16","lukas","lukaese","9c","$2y$10$WhCZHG4kqB6MsCntuwcViO2PGlIX3ns9nRwtK0gWHP27.4v0Nbcom","1"),
("17","Lukas","Lukaese","9c","$2y$10$eaFqXGpPzQgaE6GPefL4fePS5ImW7y36wme1tXxAzIWgBlYxOX7T.","1"),
("18","Lukas","Lukaese","9c","$2y$10$3w3FH4wQ5XKmiQ5IPQ1tz.lTHDEdxhTXHPoLPntdJOPr5l/dOUycq","1");


