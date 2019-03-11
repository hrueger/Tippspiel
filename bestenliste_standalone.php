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
      

      <div class="jumbotron">
        <h1>Bestenliste<br><small>des AG-Tippspiels</small></h1>
		<br>
			
		  	<?php if (isset($_GET["s"])) { ?>
				<h3>Die besten 10 Schüler</h3>
				<?php
					createBestenliste("SELECT * FROM users WHERE grade NOT IN ('Lehrer/in', 'Studienseminar 17/19', 'Studienseminar 18/20')  AND `checked`!=-1 ORDER BY `points` DESC LIMIT 10", false);
				 } else if (isset($_GET["l"])) { ?>
			<h3>Die besten 10 Lehrer</h3>
				<?php
					createBestenliste("SELECT * FROM users WHERE grade IN ('Lehrer/in', 'Studienseminar 17/19', 'Studienseminar 18/20')  AND `checked`!=-1 ORDER BY `points` DESC LIMIT 10", false);
				?>
			<?php } ?>
			
			
		
		
		
		<div class="clearfix">&nbsp;</div>
		
      </div>
		<br>
		  	<h4><?php echo "Stand: ".strftime("%A").", ".date('d.m.o \u\m H:i:s')." Uhr"; ?></h4>
	

      <footer class="footer">
        <p>&copy; AG-Multimedia des Allgäu-Gymnasiums 2018. Alle Rechte vorbehalten. </p>
      </footer>

    </div> <!-- /container -->


  </body>
</html>
