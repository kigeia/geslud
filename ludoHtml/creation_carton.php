<?php					session_start();
						if (!isset($_SESSION['connexion']))
/* ajout du 01/06/2012*/ {	echo "vous n'etes pas (ou plus) connecté : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
						else
						{	if ($_SESSION['usr_droit4']!=1)
							{	echo "vous n'avez pas les privilèges pour cette page : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
								else
								{
									$_SESSION['page'] = 'creation_carton';	// mise en cache du num de page pour onglet coloré
									$utilisateur_ID=$_SESSION['utilisateur_ID'];
									include_once("include/connexion1.php");
									include_once("include/htmlhead.inc.php");
									include_once("include/fonctions.inc.php");
									mysql_query("SET NAMES 'utf8'");
									headhtml("creation_carton","creation_carton");
									include("include/menu.inc.php");
?>	<body class="bodystyle">
<!-- TITRE DU DOCUMENT -->
		<br/><div class='titre'>
		<h5>Inventaire - 
			<span><a href='inventaire.php' class='titrelien'> Boite->Lieu </a></span> - 
			<span><a href='creation_boite.php' class='titrelien'><span> Exemplaire->Boite </a></span> - 
			<span><a href='creation_carton.php' class='marron titrelien'><span> Boite->Carton </a></span>
		</h5></div><!-- FIN DU TITRE DU DOCUMENT -->
<!------DEBUT NOTICE DROITE------------------>
		<div class='notice'>
			<h6>Notice simplifiée</h6>
			<h7>Déplacement d'une boite</h7>
			<ul><li>1. choix carton destination,</li>
				<li>2. clic afficher,</li>
				<li>3. clic sur l'exemplaire choisi,</li>
				<li>4. clic sur déplacer,</li>
				<li>5. constater résultat.</li>
			</ul></br>
		</div><!-- ---------FIN NOTICE DROITE--------------------------------->
<!------------DEBUT DU TEXTE DROITE------------------------------------------------>
		<div class='paragraphe'><h6>Objectif de la page</h6>
			<h7>permettre au responsable du stock de jeux de l'association REEL de :</h7>
			<ul>
				<li>créer un carton</li>
				<li>imprimer le code-barre d'un carton,</li>
				<li>déplacer une carton de jeux vers un lieu,</li>
				<li>déplacer une boite de jeux vers un lieu,</li>
				<li>déplacer une boite de jeux dans un carton,</li>
				<li>imprimer le code-barre d'une boite,</li>
				<li>déplacer un exemplaire dans une boite.</li>
			<ul></br></br>
		</div>

<!-- ---------DEBUT DU CORPS DE LA PAGE---------------------------------------------------->
	<div class="zoneCorpsDoc">&nbsp;&nbsp;&nbsp; <br/>
<?php	//si on reçoit le formulaire de création de carton
/**/	//		echo 'toto :<pre>', print_r($GLOBALS), '</pre>';
/**/			echo '<br/><br/>';
								$carton1='';
								$carton2='';
								$carton3='INCO';
								$cartonAffichage='INCO';
								if(isset($_POST['premier']))
								{	$categsor=$_POST['categsor'];
									$carton1=(int) fsecure($_POST['carton1']);
									if($categsor=='')
									{
?>			<script type="text/javascript">
				alert('veuillez sélectionner une catégorie de sortie');
			</script>
<?php								$_POST['premier']='';
								}
									elseif($carton1==0)
									{
?>			<script type="text/javascript">
				alert('veuillez saisir un numéro de carton valide');
			</script>
<?php								$_POST['premier']='';
									}
									else // $categsor!='' et $carton1!=0
									{
									$carton1=sprintf("%03d", $carton1);
									$carton1=''.$categsor.$carton1;
									$carton2='';
									$carton3=$carton1;
									$cartonAffichage=$carton1;
/**/										$req01="INSERT INTO te_carton_crt (crt_LIB   ,sor_GUID,   crt_DAA,           crt_UAA)"
																	."VALUES('$carton1','$categsor',CURRENT_TIMESTAMP,'$utilisateur_ID')";
											$res01=mysql_query($req01);
									}
								} // fin isset premier
								elseif(isset($_POST['second']))
								{
									//sinon si on reçoit le formulaire de mouvement de boites
/**/								$carton1='';
									$carton2=$_POST['carton2'];
									$carton3=$_POST['carton2'];
									$cartonAffichage=$carton2;
									if (isset($_POST['checky']) && !empty($_POST['checky'])) 
									{	foreach ($_POST['checky'] as $checky)
										{	$req02="UPDATE te_boite2_bte SET crt_LIB='$carton2',bte_mvt_DAA=CURRENT_TIMESTAMP,bte_mvt_UAA='$utilisateur_ID' WHERE bte_ID='$checky'";
											$res02=mysql_query($req02);
										}
									}
								}
								else
								{
									//sinon si on reçoit rien ou si on reçoit le formulaire d'affichage du contenu d'un carton
/**/								$carton1='';
									$carton2='';
									if (!isset($_POST['carton3']))
									{	$carton3='INCO';
										$cartonAffichage='INCO';
									}
									else
									{	$carton3=$_POST['carton3'];
										$cartonAffichage=$_POST['carton3'];
									}
								}
//table qui contient les formulaires de mouvement, de création et de sélection
echo	"<form action='creation_carton.php' method='post'>";
echo '<table>
		<tr>
			<td valign="top" rowspan=2>';
// <!-----DEBUT colonne gauche ----------------------------------------------------------------------------->
	echo		'<table>
					<tr>
						<td colspan=5>';
// <!---------colonne gauche - Debut CREATION CARTON --------------------------------------------------------->
	echo					'<h3>CREATION CARTON</h3>';
?>
							<br/><b>Catégorie de sortie :</b> 
								<select name="categsor">
									<option value="" selected="selected">aucun</option>
<?php										$req03="SELECT sor_GUID,sor_LIB FROM tx_categoriesortie_sor";
											$res03=mysql_query($req03);
											while(list($sor_GUID,$sor_LIB)=mysql_fetch_array($res03))
											{
?>									<option value="<?php echo $sor_GUID;?>"><?php echo $sor_LIB;?></option>
<?php										}
?>								</select>

							<br/><b><br/>N° du carton :</b><br/>
								<input type="text" name="carton1" size='4' maxlength='3' placeholder='Ex : 082' /><br/>
<?php							if (!empty($_POST['premier']))
?>								<input type="submit" name="premier" value="créer le carton" onclick="if(!confirm('êtes-vous sûr de vouloir créer ce carton ?'))return false;"/><br/>
<?php							if(!empty($_POST['premier']))
								echo "<span style='color:red'>le carton ".$carton1." vient d'être créé.</span><br/>";
?>							<hr/>
						</td>
					</tr>
				</table>
			</td>
<!---------colonne de séparation---------------------------------------------------------->
			<td width="5" style="border-right:1px solid" rowspan=2>
			</td>
<!---------colonne du milieu - Debut entete tableau --------------------------------------------------------->
		   <td width="400" valign="top" rowspan=2>
				<table class='entete10'>
					<tr><th width="20">&nbsp;</th>
						<th width="300">Boite</th>
						<th width="50" class='entete10'>Cat. sortie</th>
						<th width="25" class='entete10'>Carton</th>
					</tr>
				</table>
<!--- colonne du milieu - début corps du tableau----------------------------------------------------------------->
<?php										$i=0;
												$req04="SELECT bte_ID,bte_LIB1,crt_LIB,sor_GUID FROM te_boite2_bte WHERE crt_LIB<>'$carton3' AND bte_LIB1<>'' ORDER BY bte_LIB1";
												$affich=mysql_query($req04);
												while(list($bte_ID,$bte_LIB1,$crt_LIB,$sor_GUID)=mysql_fetch_array($affich))
												{
	echo				 "<table id='".$i."'>";
?>							<tr>
								<td width="20">
				<input type="checkbox" name="checky[]" value="<?php echo $bte_ID;?>" onclick="color=this.checked?'#DEFBC5':'';document.getElementById('<?php echo $i;?>').style.backgroundColor=color;">
								</td>
								<td class='cellule10'><?php echo$bte_LIB1; ?></td>
								<td width='80' align='center'><?php echo $sor_GUID; ?></td>
								<td width="25" align="right"><?php echo $crt_LIB; ?></td>
							</tr>
						</table>
<?php 												$i=$i+1;
												} // fin while
?>			</td>
<!-----------colonne de séparation ------------------------------------>
			<td width="5" style="border-right:1px solid" rowspan=2></td>

<!----------début colonne droite - bloc choix ------------------------------->
			<td width="250" valign="top" height="100">
				<table>
					<tr>
						<td>
							<input type="submit" name="troisieme" value="afficher les boites du" />

<!-----------colonne droite - choix du carton------------------------------------------------->
							<div>Carton n°
								<select name='carton3'>
									<option value='INCO' selected='selected'>INCO</option>
<?php										$req05="SELECT crt_LIB FROM te_carton_crt";
											$res05=mysql_query($req05);
											while(list($crt_LIB)=mysql_fetch_array($res05))
											{	if($crt_LIB!='INCO')
												{
?>									<option value="<?php echo $crt_LIB;?>"><?php echo $crt_LIB;?></option>
<?php											}
										} // fin while
?>								</select>
							</div><br/>

<!----------colonne droite -  bouton déplacer les boites------------------------------------------------------->
							<input type="submit" name="second" value="Déplacer les boites vers le"/>&nbsp;&nbsp;

<?php //----------colonne droite - affichage du lieu en VERT------------------------------------------------------------------
/**/										
	echo					'<span style="color:green;font-weight:bold">Carton '.$cartonAffichage.'</span>';
	echo					"<input type='hidden' name='carton2' value='".$carton3."'/>";
?>							<hr/>
					 </td>
				</tr>
<!-- -------colonne droite - début corps du tableau------------------------------------------------------------------------>
				<tr>
					<td valign="top">
<?php	//colonne droite - affichage des boites contenues dans le carton sélectionné
							$req06="SELECT bte_LIB1 FROM te_boite2_bte WHERE crt_LIB='$carton3' ORDER BY bte_LIB1";
							$res06=mysql_query($req06);
							while(list($bte_LIB1)=mysql_fetch_array($res06))
							{
?>						<span style="color:blue"><?php echo $bte_LIB1;?></span><br/>
<?php						}
?>					</td>
				</tr>
			</table>
		</td>
	</table>

		</form>
</div>
</body>
</html>
<?php
						} // fin if ($_SESSION['connexion'] != 4)
					} // fin test connexion
?>