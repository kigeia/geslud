<?php		//	utilise	include	include/connexion1.php
			//					include/htmlhead.inc.php : headhtml()
			//					include/menu.inc.php
			//			CSS		css/maj.css
			//		->	SESSION	connexion, usr_droit4, logingeslud
			//		<-	SESSION	page, 
			//			POST	envoi,verif,reset, Design,DesignVO,BGGID,Descript,art_LIB1,BaseEx,An,Editeur,
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
					{	$Design = '';
						$DesignVO = '';
						$BGGID = '';
						$Descript = '';
						$BaseEx = '';
						$An = '';
						$Editeur = '';
						$conseil = '';
						$theme = '';
						$type = '';
						$min = '';
						$max = '';
						$duree = '';
						$agemin = '';
						$regles = '';
						$reglesPJ = '';
						$monfichier = '';
						// $art=$_POST['art'];  présent uniquement dans fichier modif article
					}
					else if(isset($_POST['envoi']))
					{	$Design = fsecure($_POST['Design']);
						$DesignVO = fsecure($_POST['DesignVO']);
						$BGGID = (int) fsecure($_POST['BGGID']);
						$Descript = fsecure($_POST['Descript']);
						$BaseEx = $_POST['BaseEx'];
						$An = (int) fsecure($_POST['An']);
						$Editeur = fsecure($_POST['Editeur']);
						$conseil = $_POST['conseil'];
						$theme = $_POST['theme'];
						$type = $_POST['type'];
						$min = (int) fsecure($_POST['min']);
						$max = (int) fsecure($_POST['max']);
						$duree = $_POST['duree'];
						$agemin = $_POST['agemin'];
						$regles = fsecure($_POST['regles']);
						$reglesPJ = fsecure($_POST['reglesPJ']);
						$monfichier = $_POST['monfichier'];
						$jo=date("d");
						$mo=date("m");
						$an=date("Y");
						$date=''.$jo.'/'.$mo.'/'.$an.'';
						$he=date("H");
						$min=date("i");
						$heure=''.$he.'h'.$min.'';

						$req01="INSERT INTO te_article_art VALUES('','$Design','','$Descript','1','art','','$BaseEx','','','','','','','','$BGGID','$DesignVO','$monfichier','$An','$Editeur','$min','$regles','$reglesPJ','jeu','',CURRENT_TIMESTAMP,'$heure','$utilisateur_ID','','','','','','')";
						mysql_query($req01);
						$req04="SELECT art_ID FROM te_article_art WHERE art_LIB='$Design'";
						$calq=mysql_query($req04);
						while(list($art_ID)=mysql_fetch_array($calq))
						{	$Design0=$Design.'_E1';
/**/							mysql_query("INSERT INTO te_exemplaire2_exp VALUES('','$Design','1','$Design0','','','1','exp','$art_ID','0','','','',CURRENT_TIMESTAMP,'$utilisateur_ID','','')");
						}
					}
					else
					{	if (isset($_POST['Design']))
						{	$Design = fsecure($_POST['Design']);
							if  (isset($_POST['BaseEx']))
							{	$DesignVO = fsecure($_POST['DesignVO']);
								$BGGID = (int) fsecure($_POST['BGGID']);
								$Descript = fsecure($_POST['Descript']);
								$BaseEx = $_POST['BaseEx'];
								$An = (int) fsecure($_POST['An']);
								$Editeur = fsecure($_POST['Editeur']);
								$conseil = $_POST['conseil'];
								$theme = $_POST['theme'];
								$type = $_POST['type'];
								$min = (int) fsecure($_POST['min']);
								$max = (int) fsecure($_POST['max']);
								$duree = $_POST['duree'];
								$agemin = $_POST['agemin'];
								$regles = fsecure($_POST['regles']);
								$reglesPJ = fsecure($_POST['reglesPJ']);	
								if  (isset($_POST['monfichier'])) $monfichier = $_POST['monfichier'];
								$log_UAA=$_SESSION['logingeslud'];
							}
						}
					}
// 	------------------------DEBUT DU CORPS DE LA PAGE-----------------------------------------------------------	-->	
				if(isset($_POST['envoi']))
				{	echo 'L\'article <b>'.$Design.'</b> a été créé.<br/>
					L\'exemplaire <b>'.$Design0.'</b> a été créé.';
				}
					if (isset ($_POST['Design']))
					{	$Design=fsecure($_POST['Design']);}
					else
					{	$Design='';}
?>
<!----------DEBUT BLOC NOMARTICLE--	-->
			<table>
				<tr>
					<td>
<?php												if(!isset($_POST['envoi']))
													{
?>						<form action="maj.php" method="post" enctype="multipart/form-data"  >
								<strong>Désignation</strong> <input name="Design" id="Design" type="text" value="<?php echo $Design;?>" size="40" maxlength="60"/>
								<input type="submit" value="Existe-il ?"/>
						</form>
<?php												}
								if (isset ($_POST['DesignVO']))	// ajout suite à pb declaration variable esign_VO
								{$DesignVO=fsecure($_POST['DesignVO']);	}
								else
								{	$DesignVO='';
									$BGGID='';
									$Descript='';
									$BaseEx='';
									$An='';
									$Editeur='';
									$conseil='';
									$type='';
									$theme='';
									$agemin='';
									$duree='';
									$min='';
									$max='';
									$regles='';
									$reglesPJ='';
								}
								$Des=trim($Design); // suppression des espaces avant et après
								if($Des!='' AND !isset($_POST['monFichier']))
								{	$result=mysql_query("SELECT * FROM te_article_art WHERE art_LIB LIKE '%$Design%'") or die(mysql_error()); 
									if(mysql_numrows($result)==0) //Récupère le nombre de lignes d'un jeu de résultat
									{	echo "Aucun article ne correspond à la recherche <b>".$Design."</b><br/><br/>";
?>
		<fieldset>
			<form action="maj.php" method="post" enctype="multipart/form-data"  >
				<input name="Design" type="hidden" id="Design" value="<?php echo $Design;?>"/>
				<strong>Désignation VO</strong> <input name="DesignVO" type="text" value="<?php echo $DesignVO;?>"size="24" maxlength="20"/>
				<strong>BGG ID</strong> <input type="text" name="BGGID" value="<?php echo $BGGID;?>"size="6" maxlength="6"/><br/>
					<!--	----------------------------FIN BLOC NOM ARTICLE--	-->
<!--	---------DEBUT BLOC DESCRIPTIFLONG----------------------------------------------------------------------------->
				<strong>Descriptif détaillé</strong></br><textarea name="Descript" value="<?php echo $Descript;?>" cols="50" rows="4"><?php echo $Descript;?></textarea><br/>

<!----------DEBUT BLOC BASE OU EXTENSION----------------------------------------------------------------------------------->
				<strong>Base ou Extension</strong> 
				<select name="BaseEx">				
<?php											$sql = mysql_query("SELECT * FROM tx_jeuextbase_ext ORDER BY ext_RG ASC");
												while(list($ext_ID,$ext_LIB)=mysql_fetch_array($sql))
												{	if(isset($_POST['BaseEx']) AND $ext_ID==$_POST['BaseEx'])
													{
	echo'			<option value="'.$_POST['BaseEx'].'" selected="selected">'.$ext_LIB.'</option>';
													}
													else
													{
	echo"			<option value='".$ext_ID."'>".$ext_LIB.'</option>';
													}
												}
	echo		'</select>';
?>
		<br/><strong>Année de la 1e édition</strong> <input name="An" type="text" id="An" value="<?php echo $An;?>" size="5" maxlength="4" />
		<strong>Editeur</strong> <input name="Editeur" type="text" id="Editeur" value="<?php echo $Editeur;?>"size="15" maxlength="30" /><br/>

<!----------DEBUT BLOC CONSEIL--------------------------------------------------------------------------------------------->
		<strong>Conseil</strong> 
				<select name='conseil'>				
<?php											$sql = mysql_query("SELECT * FROM tx_jeuconseil_csl ORDER BY csl_RG ASC");
												while(list($csl_ID,$csl_LIB)=mysql_fetch_array($sql))
												{	if($csl_LIB==$csl_LIB1)
													{
	echo'			<option value="'.$csl_LIB.'" selected="selected">'.$csl_LIB.'</option>';
													}
	echo'			<option value="'.$csl_LIB.'">'.$csl_LIB.'</option>';
												}
	echo		'</select>';
// <!--------------SELECTION DU TYPE DE JEU ------------------------------------------------------------------------------------->
	echo 		'<strong>Type de Jeu</strong> 
				<select name="type">';
												$sql = mysql_query("SELECT * FROM tx_jeutype_jtp ORDER BY jtp_ID ASC");
												while(list($jtp_ID,$jtp_LIB)=mysql_fetch_array($sql))
												{	if($jtp_LIB==$jtp_LIB1)
													{
	echo			'<option value="'.$jtp_LIB.'" selected="selected">'.$jtp_LIB.'</option>';
													}
	echo			'<option value="'.$jtp_LIB.'">'.$jtp_LIB.'</option>';
												}
?>			'</select>

<!-------SELECTION DU Thème ---------------------------------------------------------------------------------------------------->
				<br/><strong>Thème </strong>
				<select name="theme">';
<?php											$sql = mysql_query("SELECT * FROM tx_jeutheme_thm ORDER BY thm_ID DESC");
												while(list($thm_ID,$thm_LIB)=mysql_fetch_array($sql))
												{	if($thm_LIB==$thm_LIB1)
													{
	echo			'<option value="'.$thm_LIB.'" selected="selected">'.$thm_LIB.'</option>';
													}
													
	echo			'<option value="'.$thm_LIB.'">'.$thm_LIB.'</option>';
												}
?>				</select><br/>

<!----DEBUT BLOC nb de joueurs--------------------------------------------------------------------------------------------------->
				<strong>Nombre de joueurs mini</strong> <input name="min" type="text" id="min" value="<?php echo $min;?>" size="2" maxlength="2" />
				<strong>Nombre maxi</strong> <input name="max" type="text" id="max" value="<?php echo $max;?>" size="4" maxlength="4" /> 

<!--------------début BLOC Age mini---------------------------------------------------------------------------------------------->
				<strong>Age_min</strong>
				<select name="agemin">
<?php												
												$sql = mysql_query("SELECT gmi_ID,gmi_LIB FROM tx_joueuragemin_gmi ORDER BY gmi_LIB ASC");
												
												while(list($gmi_ID,$gmi_LIB)=mysql_fetch_array($sql))
												{	if($gmi_LIB==$agemin)
													{
	echo			'<option value="'.$gmi_LIB.'" selected="selected" size="2">'.$gmi_LIB.'</option>';
													}
													
	echo			'<option value="'.$gmi_LIB.'">'.$gmi_LIB.'</option>';
												}
?>
				</select><!--Fin de branchement base de donnée pour la valeur Age mini	-->
<!--------------début de branchement base de donnée pour la valeur Durée	-->
				<br/><strong>Durée (en min):</strong> 
				<select name="duree">
<?php											$sql = mysql_query("SELECT dur_ID,dur_LIB FROM tx_jeuduree_dur ORDER BY dur_LIB ASC");
												while(list($dur_ID,$dur_LIB)=mysql_fetch_array($sql))
												{	if($dur_LIB==$duree)
													{
	echo			'<option value="'.$dur_LIB.'" selected="selected">'.$dur_LIB.'</option>';
													}
	echo			'<option value="'.$dur_LIB.'">'.$dur_LIB.'</option>';
												}
	echo		"</select><br/>";	//Fin de branchement base de donn�e pour la valeur Dur�e	
												if (isset ($_POST['regles']))	// ajout suite à pb declaration variable design_VO
												{	$regles=fsecure($_POST['regles']);}
												else
												{	$regles='';
													$_POST['regles']='';
													$reglesPJ='';
												}
?>
				<strong>Règles</strong> <input name="regles" type="text" id="art_RG" value="<?php echo $regles;?>" size="20" maxlength="20" />
				<strong>N_regle (en_PJ)</strong> <input name="reglesPJ" type="text" id="regles_PJ" value="<?php echo $reglesPJ;?>" size="6" maxlength="6" /><br/><br/>
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
											{	echo"[".$Design."] existe dans la chaine de caractères de  ".$row[1].".</br>";
												$ch1="$Design";
												$ch2="$row[1]";
												$resultb = preg_match("/^.*$ch1.*$/", "/^.*$ch2.*$/"); // on teste si la valeur de result 0 ou 1 (correcte)
												//echo " = ".$resultb." ";
												if ($resultb == 1)
												{
echo		 "---> <u>".$ch1. "</u> existe déjà.<br/>";?>

			<form action="creation_Exemplaire.php" method="post" >
				<input type="hidden" name="Design" value="<?php echo($Design);?>" />	
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
				<input type="hidden" name="Design" value="<?php echo($Design);?>" />	
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
									echo"<b>Désignation :</b> ".$Design."</br>";
									echo"<b>Désignation VO :</b> ".$DesignVO."</br>";
									echo"<b>Description :</b> ".$Descript."<br/>";
									echo"<b>BGG ID :</b> ".$BGGID."</br>";
									echo"<b>Conseils :</b> ".$conseil."</br>";
									echo"<b>Thème :</b> ".$theme."</br>";
									echo"<b>Type :</b> ".$type."</br>";
											$req02="SELECT ext_LIB FROM tx_jeuextbase_ext WHERE ext_ID='$BaseEx'";
											$res02=mysql_query($req02);
											$ext_LIB=mysql_fetch_row($res02);
									echo"<b>Base ou extension :</b> ".$ext_LIB[0]."</br>";
									echo"<b>Année :</b> ".$An."</br>";
									echo"<b>Editeur :</b> ".$Editeur."</br>";
									echo"<b>Nombre mini :</b> ".$min."</br>";
									echo"<b>Nombre maxi :</b> ".$max."</br>";
									echo"<b>Age mini :</b> ".$agemin."</br>";
									echo"<b>Durée moy. :</b> ".$duree." minutes</br>";
									echo"<b>Règles :</b> ".$regles."</br>";
									echo"<b>Règles PJ :</b> ".$reglesPJ."</br>";
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
				<input type="hidden" name="Design" value="<?php echo $Design;?>" />
				<input type="hidden" name="DesignVO" value="<?php echo $DesignVO;?>" />
				<input type="hidden" name="BGGID" value="<?php echo $BGGID;?>" />
				<input type="hidden" name="Descript" value="<?php echo $Descript;?>" />
				<input type="hidden" name="BaseEx" value="<?php echo $BaseEx;?>" />
				<input type="hidden" name="An" value="<?php echo $An;?>" />
				<input type="hidden" name="Editeur" value="<?php echo $Editeur;?>" />
				<input type="hidden" name="conseil" value="<?php echo $conseil;?>" />
				<input type="hidden" name="type" value="<?php echo $type;?>" />
				<input type="hidden" name="theme" value="<?php echo $theme;?>" />
				<input type="hidden" name="min" value="<?php echo $min;?>" />
				<input type="hidden" name="max" value="<?php echo $max;?>" />
				<input type="hidden" name="duree" value="<?php echo($duree);?>" />
				<input type="hidden" name="agemin" value="<?php echo($agemin);?>" />
				<input type="hidden" name="regles" value="<?php echo($Regles);?>" />
				<input type="hidden" name="reglesPJ" value="<?php echo($reglesPJ);?>" />
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