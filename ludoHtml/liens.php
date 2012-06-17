<?php					session_start();
						if (!isset($_SESSION['connexion']))
/* ajout du 01/06/2012*/ {	echo "vous n'etes pas (ou plus) connecté : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
						else
/* ajout du 02/06/2012*/ {	if ($_SESSION['usr_droit9']!=1)
							{	echo "vous n'avez pas les privilèges pour cette page : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
							else
							{
								$_SESSION['page'] = 'liens';	// mise en cache du num de page pour onglet coloré
								include_once("include/htmlhead.inc.php");
								headhtml("liens","liens");
?>
	<body class="bodystyle"><br/>
<!------------------- MENU ------------------------>
<?php include("include/menu.inc.php"); ?>
<!------TITRE DU DOCUMENT -->
		<div class='titre'><h5>Gestion Ludo - Liens</h5>
		</div><!-- FIN DU TITRE DU DOCUMENT -->
<!------DEBUT DU CORPS DE LA PAGE-----------------------------------------------------------	-->	
		<div class="zoneCorpsDoc">
			<h3>L'association REEL</h3>
				<p class="liens"><a href="http://www.reelasso.fr/">le site web</a>
				<span style="text-decoration:none">&nbsp; &nbsp;</span>
				<a href="http://reelasso.fr/forum/">le forum</a></p></br>
			<h3>Liste de logiciels intéressants</h3>
				<p>les ERP (tout intégré)</p>
					<p class="liens"><a href="http://www.dolibarr.fr/">Dolibarr,</a><br/>
					<a href="http://www.openerp.com/">OpenErp.</a></p><br/>
			<p>Gestions de collections</p>
				<p class="liens"><a href="http://www.gcstar.org/">GCStar,</a><br/>
				<a href="http://www.pmbservices.fr/nouveau_site/pmbservices.html">Php My Bibli,</a><br/>
				<a href="http://www.koha-fr.org/">Koha.</a></p><br/>
			<p>Gestions de ludothèque</p>
				<p class="liens"><a href="http://ludopret.free.fr/site/index.htm">ludopret.</a></p><br/>
			<h3>Liens de sites intéressants</h3>
				<p>Sites de gestion de ludothèque ou de jeux</p>
					<p class="liens"><a href="http://ldvldv.free.fr/nos_soirees_jeux.php">Site de Carla,</a><br/>
					<a href="http://www.decmoon.net/jeux/plateau/">Site de DecMoon.</a></p><br/>
			<p>Pour les programmeurs</p>
				<p class="liens"><a href="http://www.php.net/">php.net,</a><br/>
				<a href="http://www.pmbservices.fr/nouveau_site/pmbservices.html">php My Bibli,</a><br/>
				<a href="http://www.siteduzero.com/">siteduzero.com.</a></p><br/><br/>
		</div>
<!--	------------------------------CORPS DE LA PAGE-----------------------------------------------------------	-->			<div class="zoneBasPage">
		</div>
	</body>
</html>
<?php
/* ajout pbo 01/06/2012 */		} // fin if ($_SESSION['connexion'] != 4)
						} // fin test connexion
?>