<?php					session_start();
						if (!isset($_SESSION['connexion']))
/* ajout du 01/06/2012*/ {	echo "vous n'etes pas (ou plus) connecté : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
						else
/* ajout du 02/06/2012*/ {	if ($_SESSION['usr_droit4']!=1)
							{	echo "vous n'avez pas les privilèges pour cette page : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
							else
							{	$_SESSION['page'] = 'inventaire';	// mise en cache du num de page pour onglet coloré
								include_once("include/connexion1.php");
								include_once("include/htmlhead.inc.php");
								mysql_query("SET NAMES 'utf8'");
								headhtml("historique_boite","maj");
?>
<body>
<div class="bodystyle"><br/>
<!------------------- MENU ------------------------>
<?php							include "include/menu.inc.php";
								include "include/fonctions.inc.php";
?>
<!-- TITRE DU DOCUMENT -->
<br/><div class='titre'><h5>Gestion Ludo - Historique du déplacement des boites</h5>
</div><!-- FIN DU TITRE DU DOCUMENT -->
	<!--DEBUT DU TEXTE DROITE------------------------------------------------>
	<div class='paragraphe'><h6>Objectif de la page</h6>
		<h7>permettre au responsable du stock des jeux de :</h7>
			<ul>
				<li>voir les différentes modifications de lieu d'une boite de jeu.</li>
			</ul></br></br>
	</div><!-- ---------FIN DU TEXTE DROITE------------------------->

<!--DEBUT DU CORPS DE LA PAGE-----------------------------------------------------------	-->	
	<div class="zoneCorpsDoc">
<?php							if (isset($_GET['idd']))
								{	$idd=$_GET['idd'];}
								else {$idd='';}
/**/								// echo 'idd : '.$idd.'<br/>';
								if (isset($_GET['login']))
								{	$login=$_GET['login'];
									$clef=$_GET['clef'];
								}
								else	{	$clef='';
											$clef='';}
								$num=mysql_query("SELECT COUNT(*) AS nbre FROM th_mouvement_mvt WHERE bte_ID='$idd'");
								$num1=mysql_fetch_array($num);
								if($num1['nbre']==0)
								{	echo 'Aucun mouvement trouvé';
								}
								else
								{	
									$nom=mysql_query("SELECT bte_LIB1 FROM te_boite2_bte WHERE bte_ID='$idd'");
									while(list($bte_LIB1)=mysql_fetch_array($nom))
									{
?>		<table width="150">
			<tr><td colspan=3><h3><?php echo $bte_LIB1;?></h3></td></tr>
			<tr><td colspan=3><hr/></td></tr>
			<tr><td width="50">déplacé vers</td>
				<td width="50">le</td>
				<td width="50">par</td>
			</tr>
			<tr><td colspan=3><hr/></td>
			</tr>
<?php									$affich=mysql_query("SELECT * FROM th_mouvement_mvt WHERE bte_ID='$idd' ORDER BY mvt_ID DESC");
										while(list($mvt_ID,$bte_ID,$lie_ID,$mvt_MOD,$mvt_TRI,$mvt_DAA,$mvt_TAA,$mvt_UAA)=mysql_fetch_array($affich))
										{
	echo	'<tr><td>';
											$lieuEnClair=mysql_query("SELECT lie_LIB FROM tx_lieu_lie WHERE lie_ID='$lie_ID'");
											while(list($lie_LIB)=mysql_fetch_array($lieuEnClair))
											{	
	echo			$lie_LIB;
											}
?>				</td>
				<td><?php echo $mvt_DAA;?></td>
				<td>
					<?php					$auteurEnClair=mysql_query("SELECT usr_LIB FROM te_utilisateur_usr WHERE usr_ID='$mvt_UAA'");
											while(list($usr_LIB)=mysql_fetch_array($auteurEnClair))
											{	
	echo			$usr_LIB;
											}
?>
				</td>
<?php									}
?>			</tr>
		</table>
<?php								}
								}
?>		<br/><a href='inventaire.php'>Revenir à la page inventaire</a>
	</div><!---------FIN DU CORPS DE LA PAGE------------	-->
</div><!------- FIN BODYSTYLE -->
</body>
</html>
<?php
/* ajout pbo 01/06/2012 */		} // fin if ($_SESSION['connexion'] != 4)
						} // fin test connexion
?>