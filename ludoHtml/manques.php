<?php						session_start();
									include_once("include/htmlhead.inc.php");
									headhtml("manques","manques");
							if (!isset($_SESSION['connexion']))
/* ajout du 01/06/2012*/ 	{	echo "vous n'etes pas (ou plus) connecté : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
							else
/* ajout du 02/06/2012*/ 	{	if ($_SESSION['usr_droit5']!=1)
								{	echo "vous n'avez pas les privilèges pour cette page : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
								else
								{
		
		$_SESSION['page'] = 'manques';	// mise en cache du num de page pour onglet coloré
?>
<body>
<div class="bodystyle"><br/>
<!------------------- MENU ------------------------>
<?php 								include("include/menu.inc.php");
?>
<!-- TITRE DU DOCUMENT -->
	<div class='titre'><h5>Gestion Ludo - Exemplaires complets ou incomplet ?</h5>
	</div><!-- FIN DU TITRE DU DOCUMENT -->
<!--DEBUT DU TEXTE DROITE------------------------------------------------>
	<div class='notice'><h6>Objectif de la page</h6>
		<h7>permettre au responsable de l'état des jeux de l'association REEL de :</h7>
			<ul>
				<li>enregistrer les jeux à rénover / compléter / renforder et remplacer,</li>
				<li>enregistrer les accessoires de jeux défectueux ou manquants (pions, cartes, figurines),</li>
				<li>enregistrer leur jouabilité (par rapport au manque de pions),</li>
				<li>modifier commentaire 'état' d'un jeu,</li>
				<li>enregister la remise en état d'un jeu.</li>
				<li>lister les propositions de jeux à acquérir.</li>
			</ul></br></br>
	</div><!-- ---------FIN DU TEXTE DROITE------------------------->

<!--	------------------------DEBUT DU CORPS DE LA PAGE-----------------------------------------------------------	-->	
	<div class="zoneCorpsDoc">

	</div><!--	-------FIN DU CORPS DE LA PAGE------------	-->
</div> <!--	----- FIN BODYSTYLE -->
</body>
</html>
<?php
/* ajout pbo 01/06/2012 */		} // fin if ($_SESSION['connexion'] != 4)
} // fin test connexion
?>