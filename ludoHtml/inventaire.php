<?php					session_start();
						if (!isset($_SESSION['connexion']))
						{	echo "vous n'etes pas (ou plus) connecté : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
						else
						{	if ($_SESSION['usr_droit4']!=1)
							{	echo "vous n'avez pas les privilèges pour cette page : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
							else
							{	$_SESSION['page'] = 'inventaire';	// mise en cache du num de page pour onglet coloré
								include_once("include/connexion1.php");
								mysql_query("SET NAMES 'utf8'");
								include_once("include/htmlhead.inc.php");
								headhtml("inventaire","inventaire"); // envoi 'titre page pour affichage onglet et 'page css' pour application des styles

								$utilisateur_ID=$_SESSION['utilisateur_ID'];
								$logingeslud=$_SESSION['logingeslud'];
?>
<body>
<div class="bodystyle"><br/>
<!------------------- MENU ------------------------>
<?php							include "include/menu.inc.php";
								include "include/fonctions.inc.php";
?><!----- TITRE DU DOCUMENT -->
		<div class='titre'>
			<h5>Inventaire - 
				<span><a href='inventaire.php' class='orange titrelien'> Boite->Lieu </a></span> - 
				<span><a href='creation_boite.php' class='titrelien'><span> Exemplaire->Boite </a></span> - 
				<span><a href='creation_carton.php' class='titrelien'><span> Boite->Carton </a></span>
			</h5>
		</div><!-- FIN DU TITRE DU DOCUMENT -->

<!------DEBUT NOTICE DROITE------------------>
		<div class='notice'>
			<h6>Notice simplifiée</h6>
				<h7>Déplacement d'une boite</h7>
			<ul><li>1. choix lieu destination,</li>
				<li>2. clic sur sélectionner,</li>
				<li>3. clic sur boite choisie,</li>
				<li>4. clic sur déplacer,</li>
				<li>5. constater résultat.</li>
			</ul></br>
		</div><!-- ---------FIN NOTICE DROITE--------------------------------->
<!------DEBUT DU TEXTE DROITE------------------>
		<div class='paragraphe'>
			<h6>Objectif de la page</h6>
				<h7>permettre au responsable du stock de jeux de l'association REEL de :</h7>
			<ul><li>déplacer des boites de jeux (ou des cartons) vers un lieu,</li>
				<li>créer un lieu,</li>
			</ul></br></br>
		</div><!-- ---------FIN DU TEXTE DROITE--------------------------------->
<!-----DEBUT DU CORPS DE LA PAGE----------------------	-->

<div class="zoneCorpsDoc">
<?php				
						/* recuparation ID du lieu sélectionné*/	

						//si on reçoit le formulaire
								if(isset($_POST['premier']))
								{	$jo=date("d");
									$mo=date("m");
									$an=date("Y");
									$he=date("H");
									$min=date("i");
									$sec=date("s");
									$date=''.$jo.'/'.$mo.'/'.$an.'';
									$dateinsert=''.$an.'-'.$mo.'-'.$jo.'';
									$heur=''.$he.'h'.$min.'';
									$heureinsert=''.$he.':'.$min.':'.$sec.'';
									$dateheureinsert=''.$an.'-'.$mo.'-'.$jo.' '.$he.':'.$min.':'.$sec.'';
									$lieu1=$_POST['lieu1'];
									$carton=$_POST['carton'];
									//		$idd=$_POST['idd'];
						//si l'on reçoit une ou plusieurs checkbox cochée (s)

									if (isset($_POST['checky']) && !empty($_POST['checky']))
									{	foreach ($_POST['checky'] as $checky) 
										{	
/**/											if (!isset($lieu1))
/**/											{	$lieu1='aucun';
													//	echo $lieu1;
												} // fin if (!isset($lieu1))
												if ($lieu1!='aucun')
												{
													$rechercheIdLieu=mysql_query("SELECT lie_ID FROM tx_lieu_lie WHERE lie_LIB = '$lieu1'");
													//	echo 'req : '.$rechercheIdLieu;
													list($lieu1_ID)=mysql_fetch_array($rechercheIdLieu);
/**/												// echo "<div class = 'paragraphe'>Lieu1_ID : ".$lieu1_ID.'</div></br/>';
													//	echo 'dateinsert : '.$dateinsert.'<br/>';
													echo 'checky : '.$checky.'<br/>';
													
													
													
													
													
													
/**/												mysql_query("INSERT INTO th_mouvement_mvt VALUES('','$checky','$lieu1_ID','1','mvt',CURRENT_TIMESTAMP,'','$utilisateur_ID')");
//														$res=mysql_query("UPDATE te_boite2_bte SET lie_ID='$lieu1_ID'");
													$res=mysql_query("UPDATE te_boite2_bte SET lie_ID='$lieu1_ID',bte_mvt_DAA=CURRENT_TIMESTAMP,bte_mvt_UAA='$utilisateur_ID' WHERE bte_ID='$checky'");
												} // fin else ($lieu1=='aucun')
										} // fin foreach ($_POST['checky'] as $checky) 
									} // fin if $_POST['checky']) : (=au moins une boite sélectionnée) existe et non vide 
									else
									{	//sinon, sous-entendu mouvement par carton (checky vide)
										if(($carton=='') && ($_POST['radio']='mvtcarton'))
										{
?>			<script type="text/javascript">
				alert('veuillez sélectionner un carton');
			</script>
<?php									} // fin if($carton=='') && ($_POST['radio']='mvtcarton'))
										else
										{	if($lieu1!='aucun' && $_POST['radio']=='mvtcarton' && $carton!='')
											{		//si lieu et carton ne sont pas vides
													//on sélectionne bte_ID dans la table te_boite2_bte...
												$numcrt=mysql_query("SELECT bte_ID FROM te_boite2_bte WHERE crt_LIB='$carton'");
												while(list($bte_ID)=mysql_fetch_array($numcrt))
/**/											{	$res=mysql_query("INSERT INTO th_mouvement_mvt VALUES('','$bte_ID','$lieu1','1','mvt',CURRENT_TIMESTAMP,'','$utilisateur_ID')") or die('erreur'); // modifiée par pbo r/ BDD
/**/													// echo $res; // pour tester validité requete
												} // fin while
											} // fin else lieu et carton non vides
										} // fin else carton non vide
									} // fin else 
								}
?><!-- début colonne gauche --------------------------------------------------------------------->
		<form action="inventaire.php" method="post">
<div class='colonnegauche'>

	<!-- debut choix type de mouvement gauche -------------------------------------------------->
	<div class='audessusentetetableau'><br/>
				<input type='radio' name='radio' value='mvtcarton'/> Mouvement par carton :
				<select name='carton'>
					<option value='' selected='selected'>aucun</option>
<?php											$liste1=mysql_query("SELECT crt_LIB FROM te_carton_crt ORDER BY crt_LIB");
												while(list($crt_LIB)=mysql_fetch_array($liste1))
												{
?>					<option value="<?php echo $crt_LIB;?>"><?php echo $crt_LIB;?></option>
<?php											}
?>				</select><br/>
				<input type="radio" name="radio" value='mvtboite' checked='checked'/> Mouvement par boite 
				<input type="submit" name="premier" value="déplacer" onClick="if(!confirm('êtes-vous sûr ?'))return false;"/><br/>
	</div> <!-- fin choix mvt par carton ou par boite du tableau de gauche -->

	<!-- debut titre du tableau de gauche ---------------------------------------------------------->
	<div class='entetetableau'> 
		<div class='entete10 numcarton10'>n° carton</div>
		<div  class='entete10 selection10'></div>
		<div  class='entete10 libelle10'>libellé</div>
		<div  class='entete10 place10'>place actuelle</div>
		<div  class='entete10 histo10'>hist</div>
	</div><!-- fin titre du tableau de gauche -->

	<!-- debut corps tableau de gauche -->
	<div class='corpstableau'><!-- debut corps du tableau de gauche -->
<?php						$i=0; //on définit la variable $i
						//sélection des articles dans la table
							if (isset($_POST['lieu1']))
							{$lieu1=$_POST['lieu1'];}
							else
							{$lieu1='aucun';}
							//$lieu1 est la variable qui est envoyée par la sélection du lieu dont le bouton se trouve plus bas à la ligne 330. Donc si elle n'est pas vide...
//								echo "philippe15 : lieu1 : $lieu1<br/>";
								$boiteshorslieu=mysql_query("SELECT bte_ID,crt_LIB,bte_LIB1,bte_mvt_DAA,bte_mvt_UAA,lie_LIB FROM te_boite2_bte, tx_lieu_lie WHERE ((te_boite2_bte.lie_ID = tx_lieu_lie.lie_ID) AND (tx_lieu_lie.lie_LIB !='$lieu1') AND (bte_LIB1<>'')) ORDER BY bte_LIB1");
//								// echo 'req : '.$boiteshorslieu;
							while(list($bte_ID,$crt_LIB,$bte_LIB1,$bte_mvt_DAA,$bte_mvt_UAA,$lie_LIB)=mysql_fetch_array($boiteshorslieu))
								{
echo		"<table id='".$i."'>";
?>				<tr>
					<td class='cellule20 numcarton20'>
						<span style='color:blue'><?php echo $crt_LIB;?></span>
					</td>
					<td class='cellule20 selection20'>
						<input type='checkbox' name='checky[]' value="<?php echo $bte_ID;?>" onClick="color=this.checked?'#DEFBC5':'';document.getElementById('<?php echo $i;?>').style.backgroundColor=color;">
					</td>
<?php	echo "		<td class='cellule20 libelle20'>".$bte_LIB1.'</td>';
		echo "		<td class='cellule20 place20'>".$lie_LIB.'</td>';
		echo "		<td class='cellule20 histo20'>";
		echo "			<a href='historique_boite.php?idd=".$bte_ID."'><span style='color:purple'><i>H</i></span></span></a>";
?>					</td>
				</tr>
<?php								$i=$i+1;
								} // fin while(list($bte_ID,$crt_LIB,$bte_LIB1,
?>			</table><!-- fin corpstableau -->
	</div><!-- fin corps du tableau de gauche -->
</div><!-- fin colonne gauche -->

<!-- debut colonne droite -------------------------------------------------------------->
<div class='colonnedroite'>
	<!-- debut choix lieu droit ------------------------------------------------->
	<div class='audessusentetetableau'>
		<b>Création du lieu</b>
		<input type="text" name="crealieu" size='17' maxlength='20'/>
		<input type="submit" value="créer"/><br/>
<?php							if(isset($_POST['crealieu']) AND $_POST['crealieu']!='')
								{	$crealieu=fsecure($_POST['crealieu']);
									mysql_query("INSERT INTO tx_lieu_lie VALUES('','$crealieu','','1','lie',CURRENT_TIMESTAMP,'$utilisateur_ID')");
								}
?>			Choix du lieu : 
			<select name='lieu1' id='lieu1'>
<?php										if($lieu1=='aucun')
											{
echo			"<option value='aucun' selected='selected'>aucun</option>";
											}
											else
											{
?>				<option value='aucun'>aucun</option>
<?php										}
											if(isset($_POST['lieu1']))
											{	$lieu1=$_POST['lieu1'];
											}
											else
											{	$lieu1='aucun';
											}
											// si $lieu1 n'est pas vide ('aucun')
											if($lieu1!='aucun')
											{	
												$liste1=mysql_query("SELECT lie_LIB FROM tx_lieu_lie ORDER BY lie_LIB");
												while(list($lie_LIB)=mysql_fetch_array($liste1))
												{		//là encore, rebelote
													if($lieu1==$lie_LIB)
													{
echo			"<option value='".$lie_LIB."' selected='selected'>".$lie_LIB."</option>";
													}
													else
													{
?>				<option value="<?php echo $lie_LIB;?>"><?php echo $lie_LIB;?></option>
<?php												}
												}
											}
											else
											{		//si $lieu1 est vide
?>				<option value="aucun" selected="selected">Aucun</option>
<?php											$liste1=mysql_query("SELECT lie_LIB FROM tx_lieu_lie ORDER BY lie_LIB");
												while(list($lie_LIB)=mysql_fetch_array($liste1))
												{
?>				<option value="<?php echo $lie_LIB;?>"><?php echo $lie_LIB;?></option>
<?php											}
											}
?>			</select>
			<input type="submit" name="second" value="sélectionner"/>
<?php	//		echo '<br/>'.$resLieu.'<br/>';
?>
<?php										//affichage du lieu en rouge
echo "		sélectionné : <span style='color:green;font-weight:bold'>".$lieu1."</span>";
?>
	</div><!-- fin choix lieu droit -->

	<!-- debut titre du tableau de droite -->
	<div class='entetetableau'>
		<div class='entete10 numcarton10'>n° carton</div>
		<div  class='entete10 libelle11'>libellé</div>
		<div  class='entete10 datemvt10'>date mvt</div>
		<div  class='entete10 auteurmvt10'>auteur mvt</div>

	</div><!-- fin titre du tableau de droite -->

	<!-- debut corps du tableau de droite -->
	<div class='corpstableau'>
<?php							$i=0; //on définit la variable $i
									//sélection des boites dans la table (jointure avec table lieu)
										$boitesdulieu=mysql_query("SELECT crt_LIB,bte_LIB1,bte_mvt_DAA,bte_mvt_UAA FROM te_boite2_bte, tx_lieu_lie WHERE (te_boite2_bte.lie_ID = tx_lieu_lie.lie_ID) AND tx_lieu_lie.lie_LIB ='$lieu1'");
											// echo 'req : '.$boitesdulieu;
										while(list($crt_LIB,$bte_LIB1,$bte_mvt_DAA,$bte_mvt_UAA)=mysql_fetch_array($boitesdulieu))
											{
	echo	"<table id='".$i."'>
				<tr><td class='cellule20 numcarton20'>
						<span style='color:blue'>";
							echo $crt_LIB;
	echo				"</span>
					</td>";
	echo			"<td class='cellule20 libelle21'>".$bte_LIB1."</td>";
/*//												echo $date->format('Y-m-d H:i:s'); */
	echo			"<td class='cellule20 datemvt20'>".$bte_mvt_DAA."</td>";
												$rechercheLibUser=mysql_query("SELECT usr_LIB FROM te_utilisateur_usr WHERE usr_ID = '$bte_mvt_UAA'");
												//	echo 'req : '.$rechercheIdLieu;
												list($modificateurLib)=mysql_fetch_array($rechercheLibUser);
	echo			"<td class='cellule20 auteurmvt20'>".$modificateurLib."</td>";
	echo		'</tr>';
	echo	'</table>';
												$i=$i+1;
											} // fin while(list($crt_LIB,$bte_LIB1,$bte_mvt_DAA
?>	</div> <!-- fin corps du tableau de droite -->
</div><!-- fin colonne de droite -->
		</form>
</div><!-- fin div "zoneCorpsDoc"  -->
</div> <!-- fin div "bodystyle" -->
</body>
</html>
<?php
							} // fin if ($_SESSION['connexion'] != 4)
						} // fin test connexion
?>