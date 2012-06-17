<?php							session_start();
								if (!isset($_SESSION['connexion']))
								{	echo "vous n'etes pas (ou plus) connecté : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
								else
								{	if ($_SESSION['usr_droit9']!=1)
									{	echo "vous n'avez pas les privilèges pour cette page : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
									else
									{	$_SESSION['page'] = 'ludotheque';	// mise en cache du num de page pour onglet coloré
										$utilisateur_ID=$_SESSION['utilisateur_ID'];
										include_once("include/connexion1.php");
										include_once("include/htmlhead.inc.php");
										mysql_query("SET NAMES 'utf8'");
										headhtml("ludotheque","ludotheque");
?><body>
	<div class="bodystyle">
<?php	include("include/menu.inc.php");
?>
<!-- TITRE DU DOCUMENT -->
		<br/><div class='titre'><h5>Gestion Ludo - Recherches multiples</h5>
		</div>
<!-- FIN DU TITRE DU DOCUMENT -->

<!------DEBUT NOTICE DROITE------------------>
		<div class='notice'>
			<h6>Notice simplifiée</h6>
			<h7>Obtenir un état</h7>
			<ul><li>1. choix de la requête</li>
				<li>2. sélection éventuelle d'un paramètre</li>
				<li>3. clic sur bouton OK.</li>
			</ul></br>
		</div><!-- ---------FIN NOTICE DROITE--------------------------------->
<!------------DEBUT DU TEXTE DROITE------------------------------------------------>
	<div class='paragraphe'><h6>Objectif de la page</h6>
		<h7>permettre aux membres gérant la ludothèque de l'association de :</h7>
			<ul>
				<li>trouver le lieu et le carton d'un jeu particulier,</li>
				<li>afficher les statistiques de répartition des jeux de la ludothèque (par catégorie),</li>
				<li>repérer les erreurs de saisie lors de la création des articles, exemplaires, boites et cartons,</li>
				<li>lister les lieux de stockage et les jeux que l'on peut y trouver,</li>
				<li>rechercher un jeu particulier dans la liste et en affIcher les détails,</li>
				<li>comparer un inventaire entrant et sortant pour détecter les jeux perdus pendant une manifestation,</li>
				<li>lister les dernières mises à jour de la base de donnée,</li>
				<li>lister avec ou sans filtres : les jeux, leur nombre d'exemplaires, les jeux hors cartons, l'ensemble des cartons et leur contenu, les jeux d'un carton, les jeux abimés, les jeux perdus)</li>
			</ul>
		</br></br>
	</div>
<!-- -------- FIN DU TEXTE DROITE------------------------------------->

<!--	------------------------DEBUT DU CORPS DE LA PAGE-----------------------------------------------------------	-->	
<div class="zoneCorpsDoc">
	<form action="resultat_recherche.php" method="post">
			<div class='question gauche'>Pour information, d'autres requêtes sont en cours de création ou de fiabilisation.</div>

<?php									if ($_SESSION['usr_droit9']==1) {	?>
		<h3>Recherche rapide</h3> 
	<div class='question gauche'><!--X-->Des caractéristiques et du lieu où se trouve le jeu
	<input type='texte' name='jeu' id='jeu' size='42' maxlength='40' placeholder="Ex : Himalaya"></div>
	<input type="submit" name="X" value="ok" class='ok'/>
<?php																	}	?>

		<h3>Statistiques</h3>
<?php									if ($_SESSION['usr_droit9']==1) {	?>
			<div class='question gauche'><!--1-->A. Principales statistiques sur la Base de données</div>
			<input type="submit" name="A" value="ok" class='ok'/>
<?php																	}	?>

		<h3>Gestion des exemplaires de jeu</h3>
<?php									if ($_SESSION['usr_droit9']==1) {	?>
			<div class='question gauche'><!--1-->1. Articles sans exemplaire</div>
				<input type="submit" name="1" value="ok" class='ok'/>
<?php																	}	?>

<?php									if ($_SESSION['usr_droit9']==1) {	?>
			<div class='question gauche'><!--2-->2. Exemplaires sans boîte</div>
			<input type="submit" name="2" value="ok" class='ok'/>
<?php																	}	?>

<?php									if ($_SESSION['usr_droit9']==1) {	?>
			<div class='question gauche'><!--3-->3. Boîtes sans exemplaire</div>
			<input type="submit" name="3" value="ok" class='ok'/>
<?php																	}	?>

		<h3>Gestion des cartons</h3>
<?php									if ($_SESSION['usr_droit9']==1) {	?>
			<div class='question gauche'><!--4-->4. Boîtes sans carton</div>
			<input type="submit" name="4" value="ok" class='ok'/>
<?php																	}	?>

<?php									if ($_SESSION['usr_droit9']==1) {	?>
			<div class='question gauche'><!--5-->5. Cartons vides</div>
			<input type="submit" name="5" value="ok" class='ok'/>
<?php																	}	?>

<?php									if ($_SESSION['usr_droit9']==1) {	?>
			<div class='question gauche'><!--6-->6. Exemplaires du carton n°
					<select name="carton">
<?php									$demand=mysql_query("SELECT crt_LIB FROM te_carton_crt");
										while(list($crt_LIB)=mysql_fetch_array($demand))
										{
?>						<option value="<?php echo $crt_LIB;?>"><?php echo $crt_LIB;?></option>
<?php									}
?>					</select> (avec images)
			</div>
			<input type="submit" name="6" value="ok" class='ok'/>
<?php																	}	?>

<?php									if ($_SESSION['usr_droit9']==1) {	?>
			<div class='question gauche'><!--7-->7. Exemplaires de la boîte n°
					<select name="boite">
						<option value='Himalaya_B1'>Himalaya_B1</option>
<?php									$demand1=mysql_query("SELECT bte_LIB1 FROM te_boite2_bte WHERE bte_LIB1<>''");
										while(list($bte_LIB1)=mysql_fetch_array($demand1))
										{
?>						<option value="<?php echo $bte_LIB1;?>"><?php echo $bte_LIB1;?></option>
<?php									}
?>					</select>
			</div>
			<input type="submit" name="7" value="ok" class='ok'/>
<?php																	}	?>

<?php									if ($_SESSION['usr_droit9']==1) {	?>
			<div class='question gauche'><!--8-->8. Lieu des exemplaires liés au jeu de base
				<select name="article">
					<option value='Dune'>Dune</option>
<?php									$demand2=mysql_query("SELECT art_LIB FROM te_article_art WHERE art_LIB<>''");
										while(list($art_LIB)=mysql_fetch_array($demand2))
										{
?>					<option value="<?php echo $art_LIB;?>"><?php echo $art_LIB;?></option>
<?php									}
?>				</select>
			</div>
			<input type="submit" name="8" value="ok" class='ok'/>
<?php																	}	?>

<?php									if ($_SESSION['usr_droit9']==1) {	?>
			<div class='question gauche'><!--9-->9. Exemplaires liés à l'article
				<select name="exemp">
					<option value='Pit'>Pit</option>
<?php									$demand3=mysql_query("SELECT art_LIB FROM te_article_art WHERE art_LIB<>''");
										while(list($art_LIB)=mysql_fetch_array($demand3))
										{
?>					<option value="<?php echo $art_LIB;?>"><?php echo $art_LIB;?></option>
<?php									}
?>				</select>
			</div>
			<input type="submit" name="9" value="ok" class='ok'/>
<?php																	}	?>

<?php									if ($_SESSION['usr_droit9']==1) {	?>
			<div class='question gauche'><!--10-->10. Boites en catégorie Réserve</div>
			<input type="submit" name="10" value="ok" class='ok'/>
<?php																	}	?>

<?php									if ($_SESSION['usr_droit9']==1) {	?>
			<div class='question gauche'><!--11-->11. Articles sans numéro BGG</div>
			<input type="submit" name="11" value="ok" class='ok'/>
<?php																	}	?>

<?php									if ($_SESSION['usr_droit9']==1) {	?>
			<div class='question gauche'><!--12-->12. Articles sans image</div>
			<input type="submit" name="12" value="ok" class='ok'/>
<?php																	}	?>

<?php									if ($_SESSION['usr_droit9']==1) {	?>
			<div class='question gauche'><!--13-->13. Boîtes dont catégorie de sortie est différente de celle du carton où elles sont affectées</div>
			<input type="submit" name="13" value="ok" class='ok'/>
<?php																	}	?>


			<h3>Recherche des boites de jeu</h3>
		<?php									if ($_SESSION['usr_droit9']==1) {	?>
			<div class='question gauche'><!--14-->14. Liste de tous les exemplaires</div>
			<input type="submit" name="14" value="ok" class='ok'/>
		<?php																	}	?>

<?php									if ($_SESSION['usr_droit9']==1) {	?>
			<div class='question gauche'><!--15-->15. Lieux où se trouvent des boîtes</div>
			<input type="submit" name="15" value="ok" class='ok'/>
<?php																	}	?>

<?php									if ($_SESSION['usr_droit9']==1) {	?>
			<div class='question gauche'><!--16-->16. Boîtes hors de 
				<select name="lieu">
<?php								$demandlieu=mysql_query("SELECT lie_ID,lie_LIB FROM tx_lieu_lie");
									while(list($lie_ID,$lie_LIB)=mysql_fetch_array($demandlieu))
									{
?>					<option value="<?php echo $lie_ID;?>"><?php echo $lie_LIB;?></option>
<?php								}
?>				</select>
			</div>
			<input type="submit" name="16" value="ok" class='ok'/>
<?php																	}	?>

<?php									if ($_SESSION['usr_droit1']==1) {	?>
			<div class='question gauche'><!--18-->*18. Exemplaires nouveaux depuis
				<select name="mois">
<?php								for($i=1;$i<13;$i++)
									{
?>					<option value="<?php echo $i;?>"><?php echo $i;?></option>
<?php								}
?>				</select> mois
			</div>
			<input type="submit" name="18" value="ok" class='ok'/>
<?php																	}	?>

<?php									if ($_SESSION['usr_droit1']==1) {	?>
			<div class='question gauche'><!--19-->*19. Dernières modifications dans les bases articles, exemplaires, boîtes et cartons</div>
			<input type="submit" name="19" value="ok" class='ok'/>
<?php																	}	?>

<?php									if ($_SESSION['usr_droit1']==1) {	?>
			<div class='question gauche'><!--20-->*20. Différences d'inventaire entre Lieu 1
				<select name="lieu1">
<?php									$demandlieu1=mysql_query("SELECT lie_ID,lie_LIB FROM tx_lieu_lie");
										while(list($lie_ID,$lie_LIB)=mysql_fetch_array($demandlieu1))
										{
?>					<option value="<?php echo $lie_ID;?>"><?php echo $lie_LIB;?></option>
<?php									}
?>				</select>
				&nbsp;&nbsp; et Lieu 2 
				<select name="lieu2">
<?php									$demandlieu2=mysql_query("SELECT lie_ID,lie_LIB FROM tx_lieu_lie");
										while(list($lie_ID,$lie_LIB)=mysql_fetch_array($demandlieu2))
										{
?>					<option value="<?php echo $lie_ID;?>"><?php echo $lie_LIB;?></option>
<?php								}
?>				</select>
			</div>
			<input type="submit" name="20" value="ok" class='ok'/>
<?php																	}	?>


	</form>
	<h3>&nbsp;</h3><!-- fin du formulaire général -->

</div>
</div>
</body>
</html>
<?php
								} // fin if ($_SESSION['connexion'] != 4)
} // fin test connexion
?>