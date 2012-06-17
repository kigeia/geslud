<?php
				$con = mysql_connect('localhost', 'philippe', 'ludo') or die ('erreur de connexion');
						// mysql_connect("localhost", "philippe", "ludo");
				// $con = mysql_connect('localhost', 'philippe', 'ludo') or die ('erreur de connexion');
				// $con = mysql_connect('mysql8.000webhost.com', 'a7331707_phil', 'phil-500') or die ('erreur de connexion');

						// echo '<br/>'.$con.'<br/>';

				$sel = mysql_select_db('geslud') or die ('erreur de selection de BDD');
				// mysql_select_db("geslud");
				// $sel = mysql_select_db('geslud') or die ('erreur de selection de BDD');
				// $sel = mysql_select_db('a7331707_geslud') or die ('erreur de selection de BDD');

						//echo '<br/>'.$sel.'<br/>';
?>
