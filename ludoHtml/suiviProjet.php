<?php					session_start();
if (!isset($_SESSION['connexion']))
/* ajout du 01/06/2012*/ {	echo "vous n'etes pas (ou plus) connecté : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
						else
/* ajout du 02/06/2012*/ {	if ($_SESSION['usr_droit9']!=1)
							{	echo "vous n'avez pas les privilèges pour cette page : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
								else
								{
									$_SESSION['page'] = 'suiviProjet';	// mise en cache du num de page pour onglet coloré
										include_once("include/htmlhead.inc.php");
										headhtml("suiviProjet","suiviProjet");
?>
<body>
<div class="bodystyle">
<!--  ------------- MENU --------------------------->
<?php
									include("include/menu.inc.php");
?>
<!--TITRE DU DOCUMENT -->
	<br/><div class='titre'><h5>Gestion Ludo - Suivi du projet</h5>
	</div><!-- FIN DU TITRE DU DOCUMENT -->
<!--DEBUT DU TEXTE ------------------------------------------------>
	<div class='notice'><h6>Objectif de la page</h6>
		<h7>permettre aux membres de l'association REEL de</h7>
			<ul>
				<li>suivre l'avancement du projet.</li>
			</ul>
		</br></br>
	</div><!-- ------------------------------ FIN DU TEXTE ---->
<!--DEBUT DU CORPS DE LA PAGE-----------------------------------------------------------	-->	
	<div class="zoneCorpsDoc">
			<h3>Voici les principales dates de mise à jour des derniers documents de travail :</h3>	<br/>
	<table>
			<tr><td width='80px'>
					15/06/2012 :</td><td> Moteur de recherche rapide d'un jeu.</td></tr>
			<tr><td>09/06/2012 :</td><td> Ajout de notices simplifiées.</td></tr>
			<tr><td>25/05/2012 :</td><td> Création des requêtes et états du menu 'Ludothèque'.</td></tr>
			<tr><td>25/05/2012 :</td><td> Facilitation de répérage dans l'arborescence du site.</td></tr>
			<tr><td>20/05/2012 :</td><td> Transformation de l'infographie.</td></tr>
			<tr><td>25/03/2012 :</td><td> Prototypage du formulaires pour l'inventaire.</td></tr>
			<tr><td>24/03/2012 :</td><td> Mise à jour du planning de développement.</td></tr>
			<tr><td>13/03/2012 :</td><td> Validation de la structure de la base de données.</td></tr>
			<tr><td>21/02/2012 :</td><td> Prototypage de la saisie des infos d'un nouveau jeu.</td></tr>
			<tr><td>10/01/2012 :</td><td> descriptif du fonctionnement actuel pour la réalisation de nos inventaires et gestion de nouveaux jeux.</td></tr>
			<tr><td>08/01/2012 :</td><td> Liste des cas d'utilisation du logiciel.</td></tr>
			<tr><td>08/01/2012 :</td><td> Etablissement du profil des membres REEL.</td></tr>
			<tr><td>17/12/2011 :</td><td> Elaboration de la charte de programmation.</td></tr>
			<tr><td>13/12/2012 :</td><td> Validation du planning du projet (version 1.1).</td></tr>
			<tr><td>13/12/2011 :</td><td> Validation du cahier des Charges.</td></tr>
			<tr><td>05/12/2011 :</td><td> Elaboration du dictionnaire des données et du modèle de conceptuel des données.</td></tr>
	</table>
	</div><!-------FIN CORPS DE LA PAGE------------------------------------->
</div><!-------FIN BODYSTYLE------------------------------------->
</body>
</html>
<?php
/* ajout pbo 01/06/2012 */		} // fin if ($_SESSION['connexion'] != 4)
						} // fin test connexion
?>