<?php		//	utilise	include	include/connexion1.php
			//					include/fonctions.inc.php : fsecure()
			//					include/htmlhead.inc.php : headhtml()
			//					varlook3.php : analyse du contenu des variables cde : /*-*-*/look('toto22');
			//					include/menu.inc.php
			//			LINK	maj.php
			//			CSS		css/maj.css : class(bodystyle,titrelien, marron, notice,paragraphe, zonecorpsdoc)
			//		->	SESSION	connexion, usr_droit2, utilisateur_ID
			//		<-	SESSION	page, 
			//			POST	envoi,verif,reset, design,designvo,bggid,descript,art_LIB1,baseext,an,editeur,
			//			POST(suite) conseil,theme,type,min,max,duree,agemin,regles,numregles,nomfichier,
			//			BDD		te_article_art,tx_jeuextbase_ext,tx_jeuconseil_csl,tx_jeutype_jtp,
			//			BDD(suite) tx_jeutheme_thm,tx_joueuragemin_gmi,tx_jeuduree_dur
								session_start();
								include_once('varlook3.php'); 								
								if (!isset($_SESSION['connexion']))
								{	echo "vous n'etes pas (ou plus) connecté : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
								else
								{	if ($_SESSION['usr_droit2']!=1)
									{	echo "vous n'avez pas les privilèges pour cette page : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
									else
									{
										$_SESSION['page'] = 'maj';	// mise en cache du num de page pour onglet coloré
										$utilisateur_ID=$_SESSION['utilisateur_ID'];
										$dossier ='images/';
										include_once("include/connexion1.php");
											mysql_query("SET NAMES 'utf8'");
										include_once("include/fonctions.inc.php");
										include_once("include/htmlhead.inc.php");
											headhtml("modif_article","maj");
										include ("include/menu.inc.php");
?><body>
<div class="bodystyle"><br/>
<!-- TITRE DU DOCUMENT -------------------------------------------------------------------------------->
		<div class='titre'>
			<h5>Mise à jour -
				<span><a href='maj.php' class='titrelien'> Création article </a></span> - 
				<span><a href='modification_article.php' class='marron titrelien'><span> Modification article </a></span>
			</h5>
		</div>

<!------DEBUT NOTICE DROITE------------------------------------------------------------------------------>
		<div class='notice'>
			<h6>Notice simplifiée</h6>
			<h7>Modification d'un article</h7>
			<ul><li>1. choix article,</li>
				<li>2. clic sur choisir,</li>
				<li>3. modifier champs choisi,</li>
				<li>4. clic sur modifier.</li>
			</ul></br>
		</div>

<!------DEBUT DU TEXTE DROITE--------------------------------------------------------------------------->
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
	</div>

<!-----DEBUT DU CORPS DE LA PAGE------------------------------------------------------------------------->	
	<div class="zoneCorpsDoc">
<?php 	//	echo '<pre>', print_r($GLOBALS), '</pre>';  // pour test variables du programme

					if(isset($_POST['art']))
/**/					$art=fsecure($_POST['art']); // fin if
					if(isset($_POST['verif']))
					{	$designvo = fsecure($_POST['designvo']);
						$bggid = (int) fsecure($_POST['bggid']);
						$descript = fsecure($_POST['descript']);
						$baseext = $_POST['baseext'];
						if($baseext==1 OR $baseext==4) $jeubaseid= $art; // fin if
							else $jeubaseid= (int) $_POST['jeubaseid']; // fin else
/**/					$public = (int) fsecure($_POST['public']);
						$an = (int) fsecure($_POST['an']);
						$editeur = fsecure($_POST['editeur']);
						$conseil = $_POST['conseil'];
						$theme = $_POST['theme'];
						$jeutype = $_POST['jeutype'];
						$min = (int) fsecure($_POST['min']);
						$max = (int) fsecure($_POST['max']);
						$duree = $_POST['duree'];
						if(!isset($_POST['agemin'])){$agemin='';}	else {$agemin = $_POST['agemin'];}
						$regles = fsecure($_POST['regles']);
						$numregles = fsecure($_POST['numregles']);
						if(!isset($_POST['nomfichier'])){$nomfichier='';}
							else {$nomfichier = $_POST['nomfichier'];}
						$art_mod_DAA = date("Y-m-d H:i:s");


						if($nomfichier!='') // si réception d'une image
						{		//test_valeurs();
							$fichier = basename($_FILES['nomfichier']['name']);
							$taille_maxi = 100000;
							$taille = filesize($_FILES['nomfichier']['tmp_name']);
							$elementsChemin = pathinfo($fichier);
							$extensionFichier = $elementsChemin['extension'];
							$extensions = array('png', 'gif', 'jpg', 'jpeg', 'PNG', 'GIF', 'JPG', 'JPEG');
							$design = $_POST['design'];

//-----Début des vérifications de sécurité pour insertion du fichier image------------------------------------------
							if(!in_array($extensionFichier, $extensions)) //Si l'extension n'est pas dans le tableau
							{	 $erreur = "<br/><br/><br/><b>Le fichier n'a pas la bonne extension...</b>"; }
							if($taille>$taille_maxi)
							{	$erreur = '<br/><br/><br/><b>Le fichier est trop gros...</b>';
							} // fin if($taille>$taille_maxi)
							if(!isset($erreur)) //S'il n'y a pas d'erreur, on enregistre
							{		//On formate le nom du fichier ici...
								$req01="SELECT art_ID FROM te_article_art WHERE art_LIB='$design'";
								$res_ID=mysql_query($req01);
								while(list($art_ID0)=mysql_fetch_array($res_ID))
								{	$nomdestination = $art_ID0.".".$extensionFichier;
								} // fin while
								if(move_uploaded_file($_FILES['nomfichier']['tmp_name'], $dossier.$nomdestination)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
								{	$nom_image=$dossier.$nomdestination;
									$req02="UPDATE te_article_art "
										."SET art_TXT='$descript',jba_ID='$jeubaseid',ext_ID='$baseext',pbl_ID='$public',jmx_ID='$max',thm_ID='$theme',jtp_ID='$jeutype',"
										."csl_ID='$conseil',gmi_ID='$agemin',dur_ID='$duree',art_bgg_ID='$bggid',art_designationVO='$designvo',art_image_IMG='$nom_image',"
										."art_editionannee='$an',art_editeur='$editeur',art_nbjoueurmin='$min',art_regles='$regles',art_reglenum='$numregles',"
										."art_mod_DAA='$art_mod_DAA',art_mod_UAA='$utilisateur_ID' WHERE art_ID='$art'";
									mysql_query($req02);
								} // fin if
								else //Sinon (la fonction renvoie FALSE).
									echo '<br/><br/><br/><br/><br/><br/>Echec de l\'enregistrement !';	// fin else
							}// fin if(move_uploaded_file($_FILES['nomfichier']['tmp_name'],
						}// fin if($nomfichier!='')

// -----DEBUT mise à jour si pas de transmission de fichier -------------------------------------------------------------------------------------------
						else
						{	
							$req03="UPDATE te_article_art "
								."SET art_TXT='$descript',jba_ID='$jeubaseid',ext_ID='$baseext',pbl_ID='$public',jmx_ID='$max',thm_ID='$theme',jtp_ID='$jeutype',"
								."csl_ID='$conseil',gmi_ID='$agemin',dur_ID='$duree',art_bgg_ID='$bggid',art_designationVO='$designvo',"
								."art_editionannee='$an',art_editeur='$editeur',art_nbjoueurmin='$min',art_regles='$regles',art_reglenum='$numregles',"
								."art_mod_DAA='$art_mod_DAA',art_mod_UAA='$utilisateur_ID' WHERE art_ID='$art'";
							$res03=mysql_query($req03);
						} // fin else
					} // fin if(isset($_POST['verif']))
// 	--------DEBUT DU CORPS DE LA PAGE-----------------------------------------------------------	-->	
											if(isset($_POST['verif']))
	echo "<span style='color:red'>L'article <b>".$art.'</b> a été modifié le '.$art_mod_DAA.' </span><br/>'; // fin du if
?>
<!--	----DEBUT BLOC NOMARTICLE------------------------------------------------------------->
<form action="modification_article.php" method="post" enctype="multipart/form-data"  >
		<table>
			<tr>
				<td>
						<select name="art">
<?php								$req04="SELECT art_ID,art_LIB FROM te_article_art ORDER BY art_LIB";
									$res04=mysql_query($req04);
									while(list($art_ID0,$art_LIB0)=mysql_fetch_array($res04))
/**/								{	
										if($art_ID0==$art) // mettre la bonne variable
										{
	echo					"<option value='".$art_ID0."' selected='selected'>".$art_LIB0.'</option>';
										}
										else
										{
	echo					"<option value='".$art_ID0."'>".$art_LIB0.'</option>';
										}
									} // fin while
	echo				"<input type='hidden' name='choixarticle' value='".$art."'>";
?>						</select>
						<input type="submit" name='choisir' value='choisir'/>
<!---- BLOC affichage de l'article choisi ------------------------------------------------------------------------------------->
<?php							if(isset($_POST['art']))
								{	$req05="SELECT art_ID,art_LIB,art_TXT,jba_ID,ext_ID,pbl_ID,jmx_ID,thm_ID,jtp_ID,csl_ID,gmi_ID,dur_ID,art_bgg_ID,art_designationVO,art_image_IMG,art_editionannee,art_editeur,art_nbjoueurmin,art_regles,art_reglenum,art_materieltype,art_trictrac_LNK,art_crea_DAA,art_crea_UAA,art_mod_DAA,art_mod_UAA,art_sup_DAA,art_sup_UAA FROM te_article_art WHERE art_ID='$art'";
									$result=mysql_query($req05) or die(mysql_error()); 
									while(list($art_ID,$art_LIB,$art_TXT,$jba_ID,$ext_ID,$pbl_ID,$jmx_ID,$thm_ID,$jtp_ID,$csl_ID,$gmi_ID,$dur_ID,$art_bgg_ID,$art_designationVO,$art_image_IMG,$art_editionannee,$art_editeur,$art_nbjoueurmin,$art_regles,$art_reglenum,$art_materieltype,$art_trictrac_LNK,$art_crea_DAA,$art_crea_UAA,$art_mod_DAA,$art_mod_UAA,$art_sup_DAA,$art_sup_UAA)=mysql_fetch_array($result))
									{
?>			<fieldset>

<!-------DEBUT BLOC désignation --------------------------------------------------------------------------------------------->
<!--
					<strong>Désignation</strong> <input name='design'  id="design" type='text' value="<?php echo $art_LIB;?>" size='24' maxlength='20' disabled='disabled'/> 
												<!-- disabled='disabled' pour empecher modification du lib de l'article r/ aux exemplaires deja créés -->
					<strong>Désignation VO</strong> <input type="text" name="designvo" value="<?php echo $art_designationVO;?>"size="24" maxlength="20"/>
					<strong>BGG ID</strong> <input type="text" name="bggid" value="<?php echo $art_bgg_ID;?>"size="6" maxlength="6"/><br/>
					<strong>Descriptif détaillé</strong></br><textarea name="descript" value="<?php echo $art_TXT;?>" cols="50" rows="4"><?php echo $art_TXT;?></textarea><br/>

<!-----DEBUT BLOC Base ou Extension--------------------------------------------------------------------------------->
<?php		//							$ext_ID0=$ext_ID; // supprimé le 16/06/2012
?>				<strong>Base ou Extension</strong> 
				<select name="baseext" id="baseext" >
<?php									$req08="SELECT ext_ID,ext_LIB FROM tx_jeuextbase_ext ORDER BY ext_RG ASC";
										$demand_ext=mysql_query($req08);
										while(list($ext_ID0,$ext_LIB0)=mysql_fetch_array($demand_ext))
										{	if($ext_ID0==$ext_ID)
											{
	echo			"<option value='".$ext_ID0."' selected='selected'>".$ext_LIB0."</option>";
											} // fin if
											else
											{
	echo			"<option value='".$ext_ID0."'>".$ext_LIB0."</option>";
											}
										} // fin while
?>				</select> 


<!-------DEBUT BLOC jeubase --------------------------------------------------------------------------------------------->
<?php									if($ext_ID==1 OR $ext_ID==4)
										{
	echo		"<input type='hidden' name='jeubaseid' value='".$art_ID."'/>";
										} // fin if
										else
										{
?>			<br/><strong>JeuBase</strong>
			<select name='jeubaseid'>
<?php										$req06="SELECT art_ID,art_LIB FROM te_article_art ORDER BY art_LIB ASC";
											$res06 = mysql_query($req06);
											while(list($art_ID0,$art_LIB0)=mysql_fetch_array($res06))
											{	if($art_ID0==$jba_ID)
												{
	echo			"<option value='".$art_ID0."' selected='selected'>".$art_LIB0.'</option>';
												} // fin if
												else
												{
	echo			"<option value='".$art_ID0."'>".$art_LIB0.'</option>';
												}
											} // fin while
										} // fin else($ext_ID==1)
?>				</select><br/>

<!---------DEBUT BLOC Edition---------------------------------------------------------------------------------------------->
				<strong>Année de la 1e édition </strong><input name='an' type='text' id='an' value="<?php echo $art_editionannee;?>" size='4' maxlength='4' />
				<strong>Editeur </strong><input name='editeur' type='text' id='editeur' value="<?php echo $art_editeur;?>" size='15' maxlength='30' /><br/>

<!---------DEBUT BLOC CONSEIL----------------------------------------------------------------------------------------------->
				<strong>Conseil</strong>
<?php		//						$csl_ID0=$csl_ID;
?>				<select name="conseil" >
<?php								$req09="SELECT csl_ID,csl_LIB FROM tx_jeuconseil_csl";
									$demand_csl=mysql_query($req09);
									while(list($csl_ID0,$csl_LIB0)=mysql_fetch_array($demand_csl))
									{	if($csl_ID0==$csl_ID)
										{
	echo			"<option value='".$csl_ID0."' selected='selected'>".$csl_LIB0.'</option>';
										} // fin if
										else
										{
	echo			"<option value='".$csl_ID0."'>".$csl_LIB0.'</option>';
									}
								} // fin while
?>				</select> 

<!---------DEBUT BLOC Thèmes-------------------------------------------------------------------------------------------->
			<strong>Thèmes :</strong>
<?php								$thm_ID0=$thm_ID;
?>				<select name="theme">
<?php								$req11="SELECT thm_ID,thm_LIB FROM tx_jeutheme_thm ORDER BY thm_ID DESC";
									$res11 = mysql_query($req11);
									while(list($thm_ID0,$thm_LIB0)=mysql_fetch_array($res11))
									{	if($thm_ID0==$thm_ID)
	echo			'<option value="'.$thm_ID0.'" selected="selected">'.$thm_LIB0.'</option>';	// fin if
										else
	echo			'<option value="'.$thm_ID0.'">'.$thm_LIB0.'</option>';	// fin else
									} // fin while
?>				</select><br/>

<!---------DEBUT BLOC Type de Jeu-------------------------------------------------------------------------------------------->
				<strong>Type de Jeu</strong>
<?php		//						$jtp_ID0=$jtp_ID;
?>				<select name="jeutype">
<?php								$req10="SELECT jtp_ID,jtp_LIB FROM tx_jeutype_jtp ORDER BY jtp_RG ASC";
									$demand_typ = mysql_query($req10);
									while(list($jtp_ID0,$jtp_LIB0)=mysql_fetch_array($demand_typ))
									{	if($jtp_ID0==$jtp_ID)
	echo			"<option value='".$jtp_ID0."' selected='selected'>".$jtp_LIB0.'</option>';	// fin if
										else
	echo			"<option value='".$jtp_ID0."'>".$jtp_LIB0.'</option>';	// fin else
									} // fin while
?>				</select>

<!---------DEBUT BLOC Public-------------------------------------------------------------------------------------------->
				<strong>Public :</strong>
<?php	//							$thm_ID0=$thm_ID;
?>				<select name="public">
<?php								$req15="SELECT * FROM tx_public_pbl ORDER BY pbl_RG ASC";
									$res15 = mysql_query($req15);
									while(list($pbl_ID0,$pbl_LIB0)=mysql_fetch_array($res15))
									{	if($pbl_ID0==$pbl_ID)
										{
	echo			"<option value='".$pbl_ID0."' selected='selected'>".$pbl_LIB0.'</option>';
										} // fin if
										else
										{
	echo			"<option value='".$pbl_ID0."'>".$pbl_LIB0.'</option>';
										}
									} // fin while
?>				</select>

<!---------DEBUT BLOC nb joueurs-------------------------------------------------------------------------------------------->
				<br/><strong>Nombre de joueurs mini</strong> <input name="min" type="text" id="min" value="<?php echo $art_nbjoueurmin;?>" size="2" maxlength="2" />
<?php											if (!isset($max))	// ajout suite pb declaration
												$max=""; // fin du if
?>				<strong>Nombre maxi</strong> <input name="max" type="text" id="max" value="<?php echo $max;?>" size="4" maxlength="4" /> 

<!--------DEBUT BLOC  Age mini---------------------------------------------------------------------------------------------->
	 			<br/><strong>Age_min</strong>
<?php									$gmi_ID0=$gmi_ID;
?>				<select name="agemin">
<?php								$req12="SELECT gmi_ID,gmi_LIB FROM tx_joueuragemin_gmi ORDER BY gmi_LIB ASC";
									$demand_agm = mysql_query($req12);
									while(list($gmi_ID0,$gmi_LIB0)=mysql_fetch_array($demand_agm))
									{	if($gmi_ID==$gmi_ID0)
										{
	echo			'<option value="'.$gmi_ID0.'" selected="selected" size="2">'.$gmi_LIB0.'</option>';
										} // fin if
	echo			'<option value="'.$gmi_ID0.'">'.$gmi_LIB0.'</option>';
									} // fin while
?>				</select>

<!--------DEBUT BLOC  Durée---------------------------------------------------------------------------------------------->
			<strong>Durée (en min):</strong>
<?php									$dur_ID0=$dur_ID;
?>				<select name="duree">
<?php								$req13="SELECT dur_ID,dur_LIB FROM tx_jeuduree_dur ORDER BY dur_LIB ASC";
									$demand_dur = mysql_query($req13);
									while(list($dur_ID0,$dur_LIB0)=mysql_fetch_array($demand_dur))
									{	if($dur_ID==$dur_ID0)
										{
	echo			'<option value="'.$dur_ID0.'" selected="selected">'.$dur_LIB0.'</option>';
										} // fin if
	echo			'<option value="'.$dur_ID0.'">'.$dur_LIB0.'</option>';
									} // fin while
?>				</select><br/>

<!--------début bloc règles ------------------------------------------------------------------------------------------>
				<strong>Règles</strong> <input name='regles' type='text' value="<?php echo $art_regles;?>" size='20' maxlength='20' />
<?php											if (!isset($numregles))	// ajout suite pb declaration
												$numregles=''; // fin du if
?>				<strong>N_regle (en_PJ)</strong> <input name="numregles" type="text" value="<?php echo $numregles;?>" size="6" maxlength="6" /><br/>

<!--------DEBUT BLOC IMAGE------------------------------------------------------------------------------------------------>
<?php				$image=$dossier.$art_image_IMG;
	echo		"<strong>Image actuelle : <img src='".$dossier.$art_image_IMG."' width='60'/><br/>";
	// http://localhost/justeunsite/ludotest/ludoHtml/images/
?>				<strong>Modifier Image</strong>(format de type png, gif, jpg, jpeg...) :</br>
				<input type='file' name='nomfichier' id='image'/><br/>
				<input type='submit' name='verif' value='modifier' />
			</form>
		</fieldset>
<!------FIN BLOC ENREGISTRER---------------------------------------------------------------------------------------------->
<?php									}
									}
?>				</td>
			</tr>
		</table>
	</div><!--	-------------------------FIN DU CORPS DE LA PAGE-----------------------------------------------------------	-->
</div><!--	FIN BODYSTYLE -->
</body>
</html>
<?php
					} // fin if ($_SESSION['connexion'] != 4)
	} // fin test connexion
?>