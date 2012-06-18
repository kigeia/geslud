<?php		//	utilise	include	include/connexion1.php
			//					include/fonctions.inc.php : fsecure()
			//					include/htmlhead.inc.php : headhtml()
			//					include/menu.inc.php
			//			CSS		css/maj.css
			//		->	SESSION	connexion, usr_droit4, logingeslud, utilisateur_ID
			//		<-	SESSION	page, 
			//			POST	envoi,verif,reset, design,designvo,bggid,descript,art_LIB1,baseext,an,editeur,
			//			POST(suite) conseil,theme,type,min,max,duree,agemin,regles,reglesPJ,monfichier,
			//			BDD		te_article_art,te_exemplaire2_exp,tx_jeuconseil_csl,tx_jeutype_jtp,
			//			BDD(suite) tx_jeutheme_thm,tx_joueuragemin_gmi,tx_jeuduree_dur
								session_start();
								if (!isset($_SESSION['connexion']))
								{	echo "vous n'etes pas (ou plus) connecté : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
								else
								{	if ($_SESSION['usr_droit4']!=1)
									{	echo "vous n'avez pas les privilèges pour cette page : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
									else
									{	
		
		$_SESSION['page'] = 'maj';	// mise en cache du num de page pour onglet coloré
										include_once("include/connexion1.php");
										mysql_query("SET NAMES 'utf8'");
										include_once("include/fonctions.inc.php");
										include_once("include/htmlhead.inc.php");
											headhtml("maj","maj");
										$logingeslud=$_SESSION['logingeslud'];
										$utilisateur_ID=$_SESSION['utilisateur_ID'];
?>
<body>
<div class="bodystyle"><br/>
<!--  ------------- MENU --------------------------->
<?php									include "include/menu.inc.php";
?>
<!-- TITRE DU DOCUMENT -->
	<div class='titre'>
		<h5>Mise à jour -
			<span><a href='maj.php' class='vert titrelien'> Création article </a></span> - 
			<span><a href='modification_article.php' class='titrelien'><span> Modification article </a></span>
		</h5>
	</div><!-- FIN DU TITRE DU DOCUMENT -->
		
<!------DEBUT NOTICE DROITE------------------>
	<div class='notice'>
		<h6>Notice simplifiée</h6>
		<h7>Création d'un article</h7>
		<ul><li>1. saisir un intitulé,</li>
			<li>2. clic sur existe-il,</li>
			<li>3. remplir les champs connus,</li>
			<li>4. clic sur vérifier,</li>
			<li>5. vérifier,</li>
			<li>6. clic sur ajouter à la base.</li>
		</ul></br>
	</div><!-- ---------FIN NOTICE DROITE--------------------------------->
<!--DEBUT DU TEXTE DROITE---------------------------------------->
	<div class='paragraphe'><h6>Objectif de la page</h6>
		<h7>permettre au responsable des Jeux de l'association REEL de :</h7>
			<ul>
				<li>créer un nouvel article (jeu),</li>
				<li>compléter sa fiche,</li>
				<li>lui associer une image,</li>
				<li>lui associer un numéro d'aide de jeu,</li>
				<li>créer un nouvel exemplaire du jeu,</li>
				<li>permettre de différencier<br/>
					les multiples exemplaires d'un jeu.</li>
			<ul><br/><br/>
	</div><!-- ------------------------------ FIN DU TEXTE DROITE---->
<!--	------------------------DEBUT DU CORPS DE LA PAGE-----------------------------------------------------------	-->	
	<div class="zoneCorpsDoc">
<?php
					if(isset($_POST['reset']))
					{	$design = '';
						$designvo = '';
						$bggid = '';
						$descript = '';
						$baseext = '';
						$an = '';
						$editeur = '';
						$conseil = '';
						$theme = '';
						$jeutype = '';
						$public='';
						$min = '';
						$max = '';
						$duree = '';
						$agemin = '';
						$regles = '';
						$numregles = '';
						$monfichier = '';
						// $art=$_POST['art'];  présent uniquement dans fichier modif article
					}
					else if(isset($_POST['envoi']))
					{	$design = fsecure($_POST['design']);
						$designvo = fsecure($_POST['designvo']);
						$bggid = (int) fsecure($_POST['bggid']);
						$descript = fsecure($_POST['descript']);
						$baseext = $_POST['baseext'];
						$an = (int) fsecure($_POST['an']);
						$editeur = fsecure($_POST['editeur']);
						$conseil = $_POST['conseil'];
						$theme = $_POST['theme'];
						$jeutype = $_POST['jeutype'];
						$public = (int) $_POST['public'];
	//					$public = $_POST['public'];
						$min = (int) fsecure($_POST['min']);
						$max = (int) fsecure($_POST['max']);
						$duree = $_POST['duree'];
						$agemin = $_POST['agemin'];
						$regles = fsecure($_POST['regles']);
						$numregles = fsecure($_POST['numregles']);
						$monfichier = $_POST['monfichier'];
						$art_crea_DAA = date("Y-m-d-H:i:s");

							$req01="INSERT INTO te_article_art (art_LIB,art_TXT,art_MOD,art_TRI,ext_ID,pbl_ID,jmx_ID,thm_ID,jtp_ID,csl_ID,gmi_ID,dur_ID,art_bgg_ID,art_designationVO,art_image_IMG,art_editionannee,art_editeur,art_nbjoueurmin,art_regles,art_reglenum,art_materieltype,art_crea_DAA,art_crea_UAA)"
									."VALUES('$design','$descript','1','art','$baseext','$public','$max','$theme','$jeutype','$conseil','$agemin','$duree','$bggid','$designvo','$monfichier','$an','$editeur','$min','$regles','$numregles','jeu',CURRENT_TIMESTAMP(14),'$utilisateur_ID')";
	//								."VALUES('','$design','','$descript','1','art','','$BaseEx','','','','','','','','$bggid','$designvo','$monfichier','$an','$editeur','$min','$regles','$reglesPJ','jeu','',CURRENT_TIMESTAMP,'$heure','$utilisateur_ID','','','','','','')";
							$res01=mysql_query($req01); // creation d'un nouvel article
						$req04="SELECT art_ID FROM te_article_art WHERE art_LIB='$design'";
						$calq=mysql_query($req04);
						while(list($art_ID)=mysql_fetch_array($calq))
						{	$Design0=$design.'_E1';
							$exp_crea_DAA = date("Y-m-d-H:i:s");
							$annee = date("Y");
							$req13="INSERT INTO te_exemplaire2_exp (exp_LIB,exp_num,exp_LIB1,exp_MOD,exp_TRI,art_ID,exp_annee,exp_crea_DAA,exp_crea_UAA)"
									."VALUES('$design','1','$Design0','1','exp','$art_ID','$annee','$exp_crea_DAA','$utilisateur_ID')";
	//								."VALUES('','$design','1','$Design0','','','1','exp','$art_ID','0','','','',CURRENT_TIMESTAMP,'$utilisateur_ID','','')");
							$res13=mysql_query($req13);
						} // fin while
					} // fin else if(isset($_POST['envoi']))
					else
					{	if (isset($_POST['design']))
						{	$design = fsecure($_POST['design']);
							if  (isset($_POST['baseext']))
							{	$designvo = fsecure($_POST['designvo']);
								$bggid = (int) fsecure($_POST['bggid']);
								$descript = fsecure($_POST['descript']);
								$baseext = $_POST['baseext'];
								$an = (int) fsecure($_POST['an']);
								$editeur = fsecure($_POST['editeur']);
								$conseil = $_POST['conseil'];
								$theme = $_POST['theme'];
								$jeutype = $_POST['jeutype'];
								$public = fsecure($_POST['public']);
								$min = (int) fsecure($_POST['min']);
								$max = (int) fsecure($_POST['max']);
								$duree = $_POST['duree'];
								$agemin = $_POST['agemin'];
								$regles = fsecure($_POST['regles']);
								$numregles = fsecure($_POST['numregles']);	
								if  (isset($_POST['monfichier'])) $monfichier = $_POST['monfichier'];
								$log_UAA=$_SESSION['logingeslud'];
							}
						}
					}
// 	------------------------DEBUT DU CORPS DE LA PAGE-----------------------------------------------------------	-->	
				if(isset($_POST['envoi'])) // réception formulaire validé
				{	if($res01)	// requete de mise à jour OK
					{	echo $art_crea_DAA;
						echo 'L\'article <b>'.$design.'</b> a été créé.<br/>';
						echo "L\'exemplaire <b>".$Design0.'</b> a été créé.';
					}
					else
					{	echo $res01."Echec lors de la création de l'article";	}
				}
					if (isset ($_POST['design']))
					{	$design=fsecure($_POST['design']);}
					else
					{	$design='';}
?>
<!----------DEBUT BLOC NOMARTICLE--	-->
			<table>
				<tr>
					<td>
<?php												if(!isset($_POST['envoi']))
													{
?>						<form action="maj.php" method="post" enctype="multipart/form-data"  >
								<strong>Désignation</strong> <input name="design" id="design" type="text" value="<?php echo $design;?>" size="40" maxlength="60"/>
								<input type="submit" value="Existe-il ?"/>
						</form>
<?php												}
								if (isset ($_POST['designvo']))	// ajout suite à pb declaration variable esign_VO
								{$designvo=fsecure($_POST['designvo']);	}
								else
								{	$designvo='';
									$bggid='';
									$descript='';
									$baseext='';
									$an='';
									$editeur='';
									$conseil='';
									$jeutype='';
									$public='';
									$theme='';
									$agemin='';
									$duree='';
									$min='';
									$max='';
									$regles='';
									$numregles='';
								}
								$Des=trim($design); // suppression des espaces avant et après
								if($Des!='' AND !isset($_POST['monFichier']))
								{	$result=mysql_query("SELECT * FROM te_article_art WHERE art_LIB LIKE '%$design%'") or die(mysql_error()); 
									if(mysql_numrows($result)==0) //Récupère le nombre de lignes d'un jeu de résultat
									{	echo "Aucun article ne correspond à la recherche <b>".$design."</b><br/><br/>";
?>
		<fieldset>
			<form action="maj.php" method="post" enctype="multipart/form-data"  >
				<input name="design" type="hidden" id="design" value="<?php echo $design;?>"/>
				<strong>Désignation VO</strong> <input type="text" name="designvo" value="<?php echo $designvo;?>"size="24" maxlength="20"/>
				<strong>BGG ID</strong> <input type="text" name="bggid" value="<?php echo $bggid;?>"size="6" maxlength="6"/><br/>
					<!--	----------------------------FIN BLOC NOM ARTICLE--	-->
<!--	---------DEBUT BLOC DESCRIPTIFLONG----------------------------------------------------------------------------->
				<strong>Descriptif détaillé</strong></br><textarea name="descript" value="<?php echo $descript;?>" cols="50" rows="4"><?php echo $descript;?></textarea><br/>

<!----------DEBUT BLOC BASE OU EXTENSION----------------------------------------------------------------------------------->
				<strong>Base ou Extension</strong> 
				<select name="baseext"  id="baseext">				
<?php											$req08="SELECT * FROM tx_jeuextbase_ext ORDER BY ext_RG ASC";
												$demand_ext = mysql_query($req08);
												while(list($ext_ID,$ext_LIB)=mysql_fetch_array($demand_ext))
												{	if(isset($_POST['baseext']) AND $ext_ID==$_POST['baseext'])
													{
	echo'			<option value="'.$_POST['baseext'].'" selected="selected">'.$ext_LIB.'</option>';
													}
													else
													{
	echo"			<option value='".$ext_ID."'>".$ext_LIB.'</option>';
													}
												} // fin while
	echo		'</select>';
?>
<!---------DEBUT BLOC Edition---------------------------------------------------------------------------------------------->
		<br/><strong>Année de la 1e édition</strong> <input name="an" type="text" id="an" value="<?php echo $an;?>" size="4" maxlength="4" />
		<strong>Editeur</strong> <input name="editeur" type="text" id="editeur" value="<?php echo $editeur;?>"size="15" maxlength="30" /><br/>

<!----------DEBUT BLOC CONSEIL--------------------------------------------------------------------------------------------->
		<strong>Conseil</strong> 
				<select name='conseil'>				
<?php											$req08="SELECT * FROM tx_jeuconseil_csl ORDER BY csl_RG ASC";
												$res08 = mysql_query($req08);
												while(list($csl_ID,$csl_LIB)=mysql_fetch_array($res08))
												{	if($csl_ID==$conseil)
													{
	echo'			<option value="'.$csl_ID.'" selected="selected">'.$csl_LIB.'</option>';
													}
													else
													{
	echo'			<option value="'.$csl_ID.'">'.$csl_LIB.'</option>';
													}
												}
?>			</select>
<!-------SELECTION DU Thème ---------------------------------------------------------------------------------------------------->
				<strong>Thème </strong>
				<select name="theme">';
<?php											$sql = mysql_query("SELECT * FROM tx_jeutheme_thm ORDER BY thm_ID DESC");
												while(list($thm_ID,$thm_LIB)=mysql_fetch_array($sql))
												{	if($thm_ID==$theme)
													{
	echo			'<option value="'.$thm_ID.'" selected="selected">'.$thm_LIB.'</option>';
													}
													else
													{
	echo			'<option value="'.$thm_ID.'">'.$thm_LIB.'</option>';
													}
												}
?>				</select>

<!--------------SELECTION DU TYPE DE JEU ------------------------------------------------------------------------------------->
			<br/><strong>Type de Jeu</strong> 
				<select name="jeutype">
<?php											$req05="SELECT * FROM tx_jeutype_jtp ORDER BY jtp_RG ASC";
												$res05 = mysql_query($req05);
												while(list($jtp_ID,$jtp_LIB)=mysql_fetch_array($res05))
												{	if($jtp_ID==$jeutype)
													{
	echo			'<option value="'.$jtp_ID.'" selected="selected">'.$jtp_LIB.'</option>';
													}
													else
													{
	echo			'<option value="'.$jtp_ID.'">'.$jtp_LIB.'</option>';
													}
												}
?>				'</select>

<!--------------SELECTION DU TYPE DE PUBLIC ------------------------------------------------------------------------------------->
			<strong>Public</strong> 
				<select name="public">
<?php											$req06="SELECT * FROM tx_public_pbl ORDER BY pbl_RG ASC";
												$res06 = mysql_query($req06);
							while(list($pbl_ID,$pbl_LIB)=mysql_fetch_array($res06))
							{	if($pbl_ID==$public)
								{
	echo			'<option value="'.$pbl_ID.'" selected="selected">'.$pbl_LIB.'</option>';
								}
								else
								{
	echo			'<option value="'.$pbl_ID.'">'.$pbl_LIB.'</option>';
								}
							}
?>				'</select>

<!----DEBUT BLOC nb de joueurs--------------------------------------------------------------------------------------------------->
				<br/><strong>Nombre de joueurs mini</strong> <input name="min" type="text" id="min" value="<?php echo $min;?>" size="2" maxlength="2" />
				<strong>Nombre maxi</strong> <input name="max" type="text" id="max" value="<?php echo $max;?>" size="4" maxlength="4" /> 

<!--------------début BLOC Age mini---------------------------------------------------------------------------------------------->
				<br/><strong>Age_min</strong>
				<select name="agemin">
<?php												
												$sql = mysql_query("SELECT gmi_ID,gmi_LIB,gmi_TXT FROM tx_joueuragemin_gmi ORDER BY gmi_RG ASC");
												while(list($gmi_ID,$gmi_LIB,$gmi_TXT)=mysql_fetch_array($sql))
												{	if($gmi_ID==$agemin)
													{
	echo			'<option value="'.$gmi_ID.'" selected="selected">'.$gmi_LIB.'</option>';
													}
													else
													{
	echo			'<option value="'.$gmi_ID.'">'.$gmi_LIB.'</option>';
													}
												}
?>
				</select><!--Fin de branchement base de donnée pour la valeur Age mini	-->

<!-------début BLOC Durée--------------------------------------------------------------------------------------------------------------------->
				<strong>Durée (en min):</strong> 
				<select name="duree">
<?php											$sql = mysql_query("SELECT dur_ID,dur_LIB FROM tx_jeuduree_dur ORDER BY dur_RG ASC");
												while(list($dur_ID,$dur_LIB)=mysql_fetch_array($sql))
												{	if($dur_ID==$duree)
													{
	echo			'<option value="'.$dur_ID.'" selected="selected">'.$dur_LIB.'</option>';
													}
													else
													{
	echo			'<option value="'.$dur_ID.'">'.$dur_LIB.'</option>';
													}
												}
	echo		"</select><br/>";	//Fin de branchement base de donn�e pour la valeur Dur�e	
												if (isset ($_POST['regles']))	// ajout suite à pb declaration variable design_VO
												{	$regles=fsecure($_POST['regles']);}
												else
												{	$regles='';
													$numregles='';
												}
?>
				<strong>Règles</strong> <input name="regles" type="text" id="art_RG" value="<?php echo $regles;?>" size="20" maxlength="20" />
				<strong>N_regle (en_PJ)</strong> <input name="numregles" type="text" id="numregles" value="<?php echo $numregles;?>" size="6" maxlength="6" /><br/><br/>
				<!--	----------------------------------FIN BLOC CONSEIL--	-->
											
<!------------------DEBUT BLOC IMAGE------------------------------------------------------------------------------------>
											
				<strong>Choisir Image</strong>(format de type png, gif, jpg, jpeg...) :</br>
				<input type="file" name="monfichier" id="image"/><br />
				<input type="submit" name="verif" value="Vérification de l'article avant ajout" />
			</form>
		</fieldset><!------------FIN BLOC ENREGISTRER--	-->
<?php								} // fin
									else
									{	while ($row = mysql_fetch_row($result))
										{	if(!isset($_POST['envoi']))
											{	echo"[".$design."] existe dans la chaine de caractères de  ".$row[1].".</br>";
												$ch1="$design";
												$ch2="$row[1]";
												$resultb = preg_match("/^.*$ch1.*$/", "/^.*$ch2.*$/"); // on teste si la valeur de result 0 ou 1 (correcte)
												//echo " = ".$resultb." ";
												if ($resultb == 1)
												{
echo		 "---> <u>".$ch1. "</u> existe déjà.<br/>";?>

			<form action="creation_Exemplaire.php" method="post" >
				<input type="hidden" name="design" value="<?php echo($design);?>" />	
				<input type="submit" value="Créer un exemplaire" />
			</form> OU 
			<form action="maj.php" method="post" >
				<input type="submit" value="Retourner au menu création article" />
			</form><br/><br/>
<?php												}
												else 
												{
	echo		$ch1." & ".$ch2 ." se ressemblent, mais ne sont pas identiques.";
												}
											}
											else 
											{
?>			<form action="creation_Exemplaire.php" method="post" >
				<input type="hidden" name="design" value="<?php echo($design);?>" />	
				<input type="submit" value="Créer un autre exemplaire" />
			</form> OU 
			<form action="maj.php" method="post" >
				<input type="submit" value="Retourner au menu création article" />
			</form><br/><br/>
<?php										}
										} // fin while
									} // fin else
								}
?>			</td> <!-- FIN BLOC NOM ARTICLE-------------------------------------------------------------------------------->

<?php							if(isset($_POST['verif']))
								{	echo '<td><br/><br/>';
									echo"<b>Désignation :</b> ".$design."<br/>";
									echo"<b>Désignation VO :</b> ".$designvo."<br/>";
									echo"<b>BGG ID :</b> ".$bggid."<br/>";
									echo"<b>Description :</b> ".$descript."<br/>";
											$req02="SELECT ext_LIB FROM tx_jeuextbase_ext WHERE ext_ID='$baseext'";
											$res02=mysql_query($req02);
											$ext_LIB=mysql_fetch_row($res02);
									echo"<b>Base ou extension :</b> ".$ext_LIB[0]."<br/>";
									echo"<b>Année :</b> ".$an."<br/>";
									echo"<b>Editeur :</b> ".$editeur."<br/>";
											$req07="SELECT csl_LIB FROM tx_jeuconseil_csl WHERE csl_ID='$conseil'";
											$res07=mysql_query($req07);
											$csl_LIB=mysql_fetch_row($res07);
									echo"<b>Conseil :</b> ".$csl_LIB[0]."<br/>";
											$req09="SELECT thm_LIB FROM tx_jeutheme_thm WHERE thm_ID='$theme'";
											$res09=mysql_query($req09);
											$thm_LIB=mysql_fetch_row($res09);
									echo"<b>Thème :</b> ".$thm_LIB[0]."<br/>";
											$req10="SELECT jtp_LIB FROM tx_jeutype_jtp WHERE jtp_ID='$jeutype'";
											$res10=mysql_query($req10);
											$jtp_LIB=mysql_fetch_row($res10);
									echo"<b>Type :</b> ".$jtp_LIB[0]."<br/>";
											$req03="SELECT pbl_LIB FROM tx_public_pbl WHERE pbl_ID='$public'";
											$res03=mysql_query($req03);
											$pbl_LIB=mysql_fetch_row($res03);
									echo"<b>Public :</b> ".$pbl_LIB[0]."</br>";
									echo"<b>Nombre mini :</b> ".$min."</br>";
									echo"<b>Nombre maxi :</b> ".$max."</br>";
										$req11="SELECT gmi_LIB FROM tx_joueuragemin_gmi WHERE gmi_ID='$agemin'";
										$res11=mysql_query($req11);
										$gmi_LIB=mysql_fetch_row($res11);
									echo"<b>Age mini :</b> ".$gmi_LIB[0]."</br>";
										$req12="SELECT dur_LIB FROM tx_jeuduree_dur WHERE dur_ID='$duree'";
										$res12=mysql_query($req12);
										$dur_LIB=mysql_fetch_row($res12);
									echo"<b>Durée moy. :</b> ".$dur_LIB[0]." minutes</br>";
									echo"<b>Règles :</b> ".$regles."</br>";
									echo"<b>Règles PJ :</b> ".$numregles."</br>";
									if (!isset($_POST['monfichier'])) {	$monfichier =''; }
									else
									{	$monfichier = $_POST['monfichier'];

// début bloc traitement upload images--------------------------------------------------------------------------------------------------
										echo"<b>Image :</b> ".$monfichier."</br>";
											//test_valeurs();
										$dossier = 'images/';	// modif suite emplacement repertoire
										$fichier = basename($_FILES['monfichier']['name']);
										$taille_maxi = 100000;
										$taille = filesize($_FILES['monfichier']['tmp_name']);
										$elementsChemin = pathinfo($fichier);
										$extensionFichier = $elementsChemin['extension'];
										$extensions = array('png', 'gif', 'jpg', 'jpeg', 'PNG', 'GIF', 'JPG', 'JPEG');
										$req_ID=mysql_query("SELECT art_ID FROM te_article_art ORDER BY art_ID DESC LIMIT 0,1");
										while(list($art_ID)=mysql_fetch_array($req_ID))
										{	$art_act=$art_ID+1;
										}
										//Début des vérifications de sécurité...
										if(!in_array($extensionFichier, $extensions)) //Si l'extension n'est pas dans le tableau
										{	$erreur = '';
										}
										if($taille>$taille_maxi)
										{	$erreur = '<br/><br/><br/><b>Le fichier est trop gros...</b>';
										}
										if(!isset($erreur)) //S'il n'y a pas d'erreur, on enregistre
										{	//On formate le nom du fichier ici...
											$nomDestination = $art_act.".".$extensionFichier;
	//										$fichier = strtr($fichier, 
	//										'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
	//										'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
	//										$fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
											if(move_uploaded_file($_FILES['monfichier']['tmp_name'], $dossier . $nomDestination)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
											{	echo"<b>Image :</b> ".$_FILES['monfichier']['name']."</br>";
												echo'L\'image sera nommée '.$art_act.".".$extensionFichier;
											}
											else //Sinon (la fonction renvoie FALSE).
											{	echo '<br/><br/><br/><br/><br/><br/>Echec de l\'enregistrement !';
											}
										}
										else
										{	echo $erreur;
										}
										$nomfichier=$dossier.$nomDestination;
									} // fin else (isset($_POST['monfichier'])
?>
			<form action="maj.php" method="post" >
				<input type="hidden" name="design" value="<?php echo $design;?>" />
				<input type="hidden" name="designvo" value="<?php echo $designvo;?>" />
				<input type="hidden" name="bggid" value="<?php echo $bggid;?>" />
				<input type="hidden" name="descript" value="<?php echo $descript;?>" />
				<input type="hidden" name="baseext" value="<?php echo $baseext;?>" />
				<input type="hidden" name="an" value="<?php echo $an;?>" />
				<input type="hidden" name="editeur" value="<?php echo $editeur;?>" />
				<input type="hidden" name="conseil" value="<?php echo $conseil;?>" />
				<input type="hidden" name="jeutype" value="<?php echo $jeutype;?>" />
				<input type="hidden" name="public" value="<?php echo $public;?>" />
				<input type="hidden" name="theme" value="<?php echo $theme;?>" />
				<input type="hidden" name="min" value="<?php echo $min;?>" />
				<input type="hidden" name="max" value="<?php echo $max;?>" />
				<input type="hidden" name="duree" value="<?php echo($duree);?>" />
				<input type="hidden" name="agemin" value="<?php echo($agemin);?>" />
				<input type="hidden" name="regles" value="<?php echo($regles);?>" />
				<input type="hidden" name="numregles" value="<?php echo($numregles);?>" />
				<input type="hidden" name="monfichier" value="<?php echo $nomfichier;?>" />
				<input type="submit" name="envoi" value="Ajouter l'article à la base" /><br/>
			</form>
			ou
			<form action="maj.php" method="post" >
				<input type="submit" name="reset" value="annuler">
			</form>
		</td></tr>
<?php					} // fin if(isset($_POST['verif']))
?>
		</table>
	</div><!--	-------FIN DU CORPS DE LA PAGE------------	-->
</div><!--	----- FIN BODYSTYLE -->
</body>
</html>
<?php
			} // fin if ($_SESSION['connexion'] != 4)
	} // fin test connexion
?>