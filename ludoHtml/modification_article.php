<?php							session_start();
								if (!isset($_SESSION['connexion']))
/* ajout du 01/06/2012*/ 		{	echo "vous n'etes pas (ou plus) connecté : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
								else
/* ajout du 02/06/2012*/		 {	if ($_SESSION['usr_droit2']!=1)
									{	echo "vous n'avez pas les privilèges pour cette page : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
									else
									{
										$_SESSION['page'] = 'maj';	// mise en cache du num de page pour onglet coloré
										$utilisateur_ID=$_SESSION['utilisateur_ID'];
										$dossier ='images/';
										include_once("include/connexion1.php");
										mysql_query("SET NAMES 'utf8'");
										include_once("include/htmlhead.inc.php");
										headhtml("modif_article","maj");
?>
<body>
<div class="bodystyle"><br/>
	<!--  ------------- MENU --------------------------->
<?php									include "./include/menu.inc.php";
										include "./include/fonctions.inc.php";
?>
<!-- TITRE DU DOCUMENT -->
		<div class='titre'>
			<h5>Mise à jour -
				<span><a href='maj.php' class='titrelien'> Création article </a></span> - 
				<span><a href='modification_article.php' class='marron titrelien'><span> Modification article </a></span>
			</h5>
	</div><!-- FIN DU TITRE DU DOCUMENT -->
<!------DEBUT NOTICE DROITE------------------>
		<div class='notice'>
			<h6>Notice simplifiée</h6>
			<h7>Modification d'un article</h7>
			<ul><li>1. choix article,</li>
				<li>2. clic sur choisir,</li>
				<li>3. modifier champs choisi,</li>
				<li>4. clic sur modifier.</li>
			</ul></br>
		</div><!-- ---------FIN NOTICE DROITE--------------------------------->
<!------DEBUT DU TEXTE DROITE---------------------------------------->
	<div class='paragraphe'><h6>Objectif de la page</h6>
		<h7>permettre au responsable des Jeux de l'association REEL de :</h7>
			<ul>
				<li><a href='../ludoHtml/creaJeu.html'>créer un nouvel article (jeu)),</a></li>
				<li>compléter la fiche de l'article manuellement,</li>
				<li>préremplir la fiche d'un jeu avec BGG,</li>
				<li>associer une image à  un article,</li>
				<li>ajouter, modifier, supprimer des commentaires sur un jeu,</li>
				<li>associer un ou plusieurs fichier d'aide de jeu,</li>
				<li>créer un nouvel exemplaire du jeu,</li>
				<li>différentier les multiples exemplaires d'un jeu,</li>
				<li>affecter un exemplaire à  une boite</li>
			<ul><br/><br/>
	</div><!-- ------------------------------ FIN DU TEXTE DROITE---->

<!--	------------------------DEBUT DU CORPS DE LA PAGE-----------------------------------------------------------	-->	
	<div class="zoneCorpsDoc">
<?php
					if(isset($_POST['verif']))
					{	$Design = fsecure($_POST['Design']);
						$DesignVO = fsecure($_POST['DesignVO']);
						$BGGID = (int) fsecure($_POST['BGGID']);
						$Descript = fsecure($_POST['Descript']);
						$art_LIB1 = fsecure($_POST['art_LIB1']);
						if(!isset($_POST['BaseEx'])){$BaseEx='';}	else {$BaseEx = $_POST['BaseEx'];}
						$An = (int) fsecure($_POST['An']);
						$Editeur = fsecure($_POST['Editeur']);
						$conseil = $_POST['conseil'];
						$theme = $_POST['theme'];
						$type = $_POST['type'];
						$min = (int) fsecure($_POST['min']);
						$max = (int) fsecure($_POST['max']);
						$duree = $_POST['duree'];
						if(!isset($_POST['agemin'])){$agemin='';}	else {$agemin = $_POST['agemin'];}
						$regles = fsecure($_POST['regles']);
						if(!isset($_POST['reglesPJ'])){$reglesPJ='';}	else {$reglesPJ = fsecure($_POST['reglesPJ']);}
						if(!isset($_POST['monfichier'])){$monfichier='';}	else {$monfichier = $_POST['monfichier'];}
						$art=fsecure($_POST['art']);
						
						if($monfichier!='')
						{		//test_valeurs();
							
							$fichier = basename($_FILES['monfichier']['name']);
							$taille_maxi = 100000;
							$taille = filesize($_FILES['monfichier']['tmp_name']);
							$elementsChemin = pathinfo($fichier);
							$extensionFichier = $elementsChemin['extension'];
							$extensions = array('png', 'gif', 'jpg', 'jpeg', 'PNG', 'GIF', 'JPG', 'JPEG');
							
							//$Design = $_POST['Design'];
							//Début des vérifications de sécurité...
							if(!in_array($extensionFichier, $extensions)) //Si l'extension n'est pas dans le tableau
							{	 $erreur = "<br/><br/><br/><b>Le fichier n'a pas la bonne extension...</b>"; }
							if($taille>$taille_maxi)
							{	$erreur = '<br/><br/><br/><b>Le fichier est trop gros...</b>';
							} // fin if($taille>$taille_maxi)
							if(!isset($erreur)) //S'il n'y a pas d'erreur, on enregistre
							{		//On formate le nom du fichier ici...
								$req_ID=mysql_query("SELECT art_ID FROM te_article_art WHERE art_LIB='$Design'");
								while(list($art_ID)=mysql_fetch_array($req_ID))
								{	$nomDestination = $art_ID.".".$extensionFichier;
								} // fin while
								if(move_uploaded_file($_FILES['monfichier']['tmp_name'], $dossier . $nomDestination)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
								{	$nom_image=$dossier.$nomDestination;
									mysql_query("UPDATE te_article_art SET art_LIB='$Design',art_TXT='$Descript',jba_ID='$art_LIB1',ext_ID='$BaseEx',jmx_ID='$max',thm_ID='$theme',jtp_ID='$type',csl_ID='$conseil',gmi_ID='$agemin',dur_ID='$duree',art_bgg_ID='$BGGID',art_designationVO_DA='$DesignVO',art_image_IMG='$nom_image',art_editionAnnee_DN='$An',art_editeur_DA='$Editeur',art_nbJoueursMini_DN='$min',art_regles_DA='$regles',art_regleNum_DA='$reglesPJ',art_mod_DAA=CURRENT_TIMESTAMP,art_mod_UAA='$utilisateur_ID' WHERE art_ID='$art'");
								} // fin if
								else //Sinon (la fonction renvoie FALSE).
								{	echo '<br/><br/><br/><br/><br/><br/>Echec de l\'enregistrement !';
								} // fin else
							}// fin if(move_uploaded_file($_FILES['monfichier']['tmp_name'],
						}// fin if($monfichier!='')
						else
						{	mysql_query("UPDATE te_article_art SET art_LIB='$Design',art_TXT='$Descript',jba_ID='$art_LIB1',ext_ID='$BaseEx',jmx_ID='$max',thm_ID='$theme',jtp_ID='$type',csl_ID='$conseil',gmi_ID='$agemin',dur_ID='$duree',art_bgg_ID='$BGGID',art_designationVO_DA='$DesignVO',art_editionAnnee_DN='$An',art_editeur_DA='$Editeur',art_nbJoueursMini_DN='$min',art_regles_DA='$regles',art_regleNum_DA='$reglesPJ',art_mod_DAA=CURRENT_TIMESTAMP,art_mod_UAA='$utilisateur_ID' WHERE art_ID='$art'");
						} // fin else
					} // fin if(isset($_POST['verif']))
// 	--------DEBUT DU CORPS DE LA PAGE-----------------------------------------------------------	-->	
											if(isset($_POST['verif']))
											{	
	echo 'L\'article <b>'.$Design.'</b> a été modifié.<br/>';
											} // fin if
?>
<!--	----DEBUT BLOC NOMARTICLE--	-->
		<table>
			<tr>
				<td>
					<form action="modification_article.php" method="post" enctype="multipart/form-data"  >
						<select name="art">
<?php
									$req_art=mysql_query("SELECT art_ID,art_LIB FROM te_article_art ORDER BY art_LIB");
									while(list($art_ID,$art_LIB)=mysql_fetch_array($req_art))
									{
?>							<option value="<?php echo $art_ID;?>"><?php echo $art_LIB;?></option>
<?php								} // fin while
?>						</select>
						<input type="submit" value="choisir"/>
					</form>
<?php							if(isset($_POST['art']))
								{	$art=$_POST['art'];	// ajouté par philippe suite pb declaration
									$result=mysql_query("SELECT * FROM te_article_art WHERE art_ID='$art'") or die(mysql_error()); 
									while(list($art_ID,$art_LIB,$art_RG,$art_TXT,$art_MOD,$art_TRI,$jba_ID,$ext_ID,$pbl_ID,$jmx_ID,$thm_ID,$jtp_ID,$csl_ID,$gmi_ID,$dur_ID,$art_bgg_ID,$art_designationVO_DA,$art_image_IMG,$art_editionAnnee_DN,$art_editeur_DA,$art_nbJoueursMini_DN,$art_regles_DA,$art_regleNum_DA,$art_materielType_DA,$art_trictrac_LNK,$art_crea_DAA,$art_crea_TAA,$art_crea_UAA,$art_mod_DAA,$art_mod_TAA,$art_mod_UAA,$art_sup_DAA,$art_sup_TAA,$art_sup_UAA)=mysql_fetch_array($result))
									{
?>
		<fieldset>
			<form action="modification_article.php" method="post" enctype="multipart/form-data"  >
				<strong>Désignation</strong> <input name='Design' type='text' value="<?php echo $art_LIB;?>" size='24' maxlength='20' /> 
												<!-- ???   disabled="disabled" pour empechr modification du lib de l'article ? -->
				<strong>Désignation VO</strong> <input type="text" name="DesignVO" value="<?php echo $art_designationVO_DA;?>"size="24" maxlength="20"/>
				<strong>BGG ID</strong> <input type="text" name="BGGID" value="<?php echo $art_bgg_ID;?>"size="6" maxlength="6"/><br/>
				<strong>Descriptif détaillé</strong></br><textarea name="Descript" value="<?php echo $art_TXT;?>" cols="50" rows="4"><?php echo $art_TXT;?></textarea><br/><br/>
				<strong>JeuBase</strong><br/>
			<select name="art_LIB1">
<!-- branchement base de donnée pour la valeur article -->
<?php									if($ext_ID==1)
										{	$sql = mysql_query("SELECT art_ID,art_LIB FROM te_article_art ORDER BY art_LIB ASC");
											while(list($art_ID,$art_LIB)=mysql_fetch_array($sql))
											{	if($art_ID==$art)
												{
	echo		'<option value="'.$art_LIB.'" selected="selected">'.$art_LIB.'</option>';
												} // fin if
	echo		'<option value="'.$art_LIB.'">'.$art_LIB.'</option>';
											} // fin while
										} // fin if($ext_ID==1)
										else
										{	$sql = mysql_query("SELECT art_ID,art_LIB FROM te_article_art ORDER BY art_LIB ASC");
											while(list($art_ID,$art_LIB)=mysql_fetch_array($sql))
											{	if($art_ID==$jba_ID)
												{
	echo		'<option value="'.$art_LIB.'" selected="selected">'.$art_LIB.'</option>';
												} // fin if
	echo			'<option value="'.$art_LIB.'">'.$art_LIB.'</option>';
											} // fin while
										} // fin else ($ext_ID==1)
	echo'		</select><br/><br/>'; // <!-- Fin de branchement base de donnée pour la valeur article -->
									$ext_ID0=$ext_ID;
?>				<strong>Base ou Extension</strong> 
				<select name="BaseEx" id="BaseEx" >
<?php									$demand_ext=mysql_query("SELECT ext_ID,ext_LIB FROM tx_jeuextbase_ext") or die ('erreur requete extbase');
										while(list($ext_ID,$ext_LIB)=mysql_fetch_array($demand_ext))
										{	if($ext_ID==$ext_ID0)
											{
?>					<option value="<?php echo $ext_ID;?>" selected="selected"><?php echo $ext_LIB;?></option>
<?php										} // fin if
?>					<option value="<?php echo $ext_ID;?>"><?php echo $ext_LIB;?></option>
<?php									} // fin while
?>				</select> 
				<strong>Année de la 1e édition</strong> <input name="An" type="text" id="An" value="<?php echo $art_editionAnnee_DN;?>" size="3" maxlength="4" />
				<strong>Editeur</strong> <input name="Editeur" type="text" id="Editeur" value="<?php echo $art_editeur_DA;?>"size="15" maxlength="30" /><br/><br/>
		<!--	----------------FIN BLOC EDITION--	-->

<!--	--------DEBUT BLOC CONSEIL--	-->
				<strong>Conseil</strong>
<?php								$csl_ID0=$csl_ID;
?>				<select name="conseil" >
<?php								$demand_csl=mysql_query("SELECT csl_ID,csl_LIB FROM tx_jeuconseil_csl");
									while(list($csl_ID,$csl_LIB)=mysql_fetch_array($demand_csl))
									{	if($csl_ID==$csl_ID0)
										{
?>					<option value="<?php echo $csl_ID;?>" selected="selected"><?php echo $csl_LIB;?></option>
<?php									} // fin if
?>					<option value="<?php echo $csl_ID;?>"><?php echo $csl_LIB;?></option>
<?php								} // fin while
?>				</select> 
				<strong>Type de Jeu</strong>
<?php								$jtp_ID0=$jtp_ID;
?>				<select name="type">
<?php								$demand_typ = mysql_query("SELECT jtp_ID,jtp_LIB FROM tx_jeutype_jtp ORDER BY jtp_ID ASC");
									while(list($jtp_ID,$jtp_LIB)=mysql_fetch_array($demand_typ))
									{	if($jtp_ID==$jtp_ID0)
										{
	echo			'<option value="'.$jtp_ID.'" selected="selected">'.$jtp_LIB.'</option>';
										} // fin if
	echo			'<option value="'.$jtp_ID.'">'.$jtp_LIB.'</option>';
									} // fin while
?>				</select><!-- Fin de branchement base de donnée pour la valeur Conseil-->

<?php			//Début de branchement base de donnée pour la valeur Thème								
	echo 		'<strong>Thèmes :</strong>';
									$thm_ID0=$thm_ID;
?>				<select name="theme">
<?php								$demand_the = mysql_query("SELECT thm_ID,thm_LIB FROM tx_jeutheme_thm ORDER BY thm_ID DESC");
									while(list($thm_ID,$thm_LIB)=mysql_fetch_array($demand_the))
									{	if($thm_ID==$thm_ID0)
										{
	echo			'<option value="'.$thm_ID.'" selected="selected">'.$thm_LIB.'</option>';
										} // fin if
	echo			'<option value="'.$thm_ID.'">'.$thm_LIB.'</option>';
									} // fin while
?>				</select><br/><br/><!-- Fin de branchement base de donnée pour la valeur Thème-->
				<strong>Nombre de joueurs mini</strong> <input name="min" type="text" id="min" value="<?php echo $art_nbJoueursMini_DN;?>" size="2" maxlength="2" />
<?php											if (!isset($max))	// ajout suite pb declaration
												{$max="";}
?>				<strong>Nombre maxi</strong> <input name="max" type="text" id="max" value="<?php echo $max;?>" size="4" maxlength="4" /> 
<!--------------début de branchement base de donnée pour la valeur Age mini-->
	 			<strong>Age_min</strong>
<?php									$gmi_ID0=$gmi_ID;
?>				<select name="agemin">
<?php								$demand_agm = mysql_query("SELECT gmi_ID,gmi_LIB FROM tx_joueuragemin_gmi ORDER BY gmi_LIB ASC");
									while(list($gmi_ID,$gmi_LIB)=mysql_fetch_array($demand_agm))
									{	if($gmi_ID==$gmi_ID0)
										{
	echo			'<option value="'.$gmi_ID.'" selected="selected" size="2">'.$gmi_LIB.'</option>';
										} // fin if
	echo			'<option value="'.$gmi_ID.'">'.$gmi_LIB.'</option>';
									} // fin while
?>				</select><!-- Fin de branchement base de donnée pour la valeur Age mini -->

<?php				//début de branchement base de donnée pour la valeur Durée
	echo		'<strong>Durée (en min):</strong> ';
									$dur_ID0=$dur_ID;
?>				<select name="duree">
<?php								$demand_dur = mysql_query("SELECT dur_ID,dur_LIB FROM tx_jeuduree_dur ORDER BY dur_LIB ASC");
									while(list($dur_ID,$dur_LIB)=mysql_fetch_array($demand_dur))
									{	if($dur_ID==$dur_ID0)
										{
	echo			'<option value="'.$dur_LIB.'" selected="selected">'.$dur_LIB.'</option>';
										} // fin if
	echo			'<option value="'.$dur_LIB.'">'.$dur_LIB.'</option>';
									} // fin while
?>				</select><br/><br/> <!-- Fin de branchement base de donnée pour la valeur Durée-->

<!--------------début bloc règles -->
				<strong>Règles</strong> <input name="regles" type="text" value="<?php echo $art_RG;?>" size="20" maxlength="20" />
<?php											if (!isset($reglesPJ))	// ajout suite pb declaration
												{$reglesPJ="";}
?>				<strong>N_regle (en_PJ)</strong> <input name="reglesPJ" type="text" value="<?php echo $reglesPJ;?>" size="6" maxlength="6" /><br/><br/>
				<!--	----------------------------------FIN BLOC règles--	-->

				<!--	----------------DEBUT BLOC IMAGE--	-->
				<strong>Image actuelle : <img src="<?php echo $dossier.$art_image_IMG;?>" style="width:40px"><br/>
				<strong>Modifier Image</strong>(format de type png, gif, jpg, jpeg...) :</br>
				<input type="file" name="monfichier" id="image"/><br />
				<input type="hidden" name="art" value="<?php echo $art;?>">
				<input type="submit" name="verif" value="modifier" />
			</form>
		</fieldset><!--	----------------------------------------FIN BLOC ENREGISTRER--	-->
<?php									}
									}
?>				</td>
			</tr>
		</table>
	</div><!--	-------------------------FIN DU CORPS DE LA PAGE-----------------------------------------------------------	-->
</div> <!--	FIN BODYSTYLE -->
</body>
</html>
<?php
					} // fin if ($_SESSION['connexion'] != 4)
	} // fin test connexion
?>