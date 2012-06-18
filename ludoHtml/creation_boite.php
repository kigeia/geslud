<?php			//	utilise	lien	inventaire.php, creation_boite.php, creation_carton.php
				//			INC		include	include/connexion1.php
				//					include/htmlhead.inc.php : headhtml()
				//					include/menu.inc.php
				//			CSS		css/inventaire.css
				//		->	SESSION	utilisateur_ID
				//		<-	SESSION	page, 
				//			POST	second, affich, boite, checky, numer, nom, ok, creation
				//			BDD		te_exemplaire2_exp, te_boite2_bte, te_article_art
				//		class	bodystyle, titrelien, vert, notice, paragraphe, zoneCorpsDoc
								session_start();
								$_SESSION['page'] = 'creation_boite';	// mise en cache du num de page pour onglet coloré
								$utilisateur_ID=$_SESSION['utilisateur_ID'];
								include_once("include/connexion1.php");
								mysql_query("SET NAMES 'utf8'");
								include_once("include/htmlhead.inc.php");
									headhtml("creation_boite","inventaire");
								include "include/menu.inc.php";
?><body class="bodystyle"><br/>
<!----- TITRE DU DOCUMENT ---------------------------------------------------------->
		<br/><div class='titre'>
		<h5>Inventaire - 
			<span><a href='inventaire.php' class='titrelien'> Boite->Lieu </a></span> - 
			<span><a href='creation_boite.php' class='vert titrelien'><span> Exemplaire->Boite </a></span> - 
			<span><a href='creation_carton.php' class='titrelien'><span> Boite->Carton </a></span>
		</h5></div>

<!------DEBUT NOTICE DROITE------------------>
		<div class='notice'>
			<h6>Notice simplifiée</h6>
			<h7>Déplacement d'un exemplaire</h7>
			<ul><li>1. choix boite destination,</li>
				<li>2. clic afficher contenu,</li>
				<li>3. clic sur exemplaire choisi,</li>
				<li>4. clic sur déplacer,</li>
				<li>5. constater résultat.</li>
			</ul></br>
</div>

<!------------DEBUT DU TEXTE DROITE------------------------------------------------>
		<div class='paragraphe'><h6>Objectif de la page</h6>
			<h7>permettre au responsable du stock de jeux de l'association REEL de :</h7>
			<ul>
				<li>créer une boite</li>
				<li>imprimer le code-barre d'une boite,</li>
				<li>déplacer une boite de jeux vers un lieu,</li>
				<li>déplacer un exemplaire dans une boite.</li>
			<ul></br></br>
		</div>

<!----DEBUT DU CORPS DE LA PAGE-----------------------------------------------------------	-->	
<div class="zoneCorpsDoc">
<?php							if(isset($_POST['second']) OR isset($_POST['affich']))
								{
										//sinon si on reçoit le formulaire de mouvement de boites
									$boite=$_POST['boite'];
									if (isset($_POST['checky']) && !empty($_POST['checky'])) 
									{	$exp_mod_DAA = date("Y-m-d H:i:s");
										foreach ($_POST['checky'] as $checky) 
										{	$req01="UPDATE te_exemplaire2_exp SET bte_ID='$boite' exp_mod_DAA='$exp_mod_DAA' exp_mod_UAA='$utilisateur_ID' WHERE exp_ID='$checky'";
											mysql_query($req01);
										}
									} // fin if (isset($_POST['checky'])
								} // fin if(isset($_POST['second'])
//table qui contient les formulaires de recherche et de sélection
echo '<table>	
		<tr><td style="height:80px">';
								if(isset($_POST['oui']))
								{	if(isset($_POST['numer']))
									{	$numer=$_POST['numer'];
										$art_LIB=$_POST['nom'];
										$art_LIB0=$art_LIB.'_B'.$numer.'';
										$exp_crea_DAA = date("Y-m-d H:i:s");
										$req02="INSERT INTO te_boite2_bte (bte_LIB,bte_num,bte_LIB0,bte_crea_DAA,bte_crea_UAA)"
										."VALUES('$art_LIB','1','$art_LIB0','$exp_crea_DAA','$utilisateur_ID')";
										mysql_query($req02);
		echo 'La boite '.$art_LIB.'_B'.$numer.' vient d\'être créée';
									} // fin if(isset($_POST['numer']))
									else
									{	$exp_crea_DAA = date("Y-m-d H:i:s");
										$art_LIB=$_POST['nom'];
										$art_LIB0=$art_LIB.'_B1';
										$req03="INSERT INTO te_boite2_bte (bte_LIB,bte_num,bte_LIB0,bte_crea_DAA,bte_crea_UAA)"
										."VALUES('$art_LIB','1','$art_LIB0','$exp_crea_DAA',''$utilisateur_ID')";
										mysql_query($req03);
		echo 'La boite '.$art_LIB."_B1 vient d'être créée";
									} // fin else (isset($_POST['numer']))
								} // fin if(isset($_POST['oui']))
								else if(isset($_POST['ok']))
								{	$nom=$_POST['nom'];
									$art_LIB0=$nom.'_B1';
									mysql_query("INSERT INTO te_boite2_bte VALUES('','$nom','1','$art_LIB0','','','','','','','','$date','','$heure')");
		echo 'La boite '.$nom.'_B1 vient d\'être créée';
								}
								else if(isset($_POST['non']))
								{
?>					<form action="creation_boite.php" method="post">
						<b>Choix du nom</b><br/>
						<input type="text" name="nom" size="20" />
						<input type="submit" name="ok" value="ok" size="2" />
					</form>
<?php							} // fin else
								else
								{	if(isset($_POST['creation']))
									{	$derart=mysql_query("SELECT art_LIB FROM te_article_art ORDER BY art_ID DESC LIMIT 0,1");
										while(list($art_LIB)=mysql_fetch_array($derart))
										{	$verif_bte=mysql_query("SELECT COUNT(*) AS nbre FROM te_boite2_bte WHERE bte_LIB='$art_LIB'");
											$verif_bte_res=mysql_fetch_array($verif_bte);
											if($verif_bte_res['nbre']==0)
											{
						echo 'Le dernier article créé est <b>'.$art_LIB.'</b><br/>
							Voulez-vous créer la boite '.$art_LIB.'_B1 ?';
?>					<form action="creation_boite.php" method="post">
						<input type="hidden" name="nom" value="<?php echo $art_LIB;?>" />
						<input type="submit" name="oui" value="oui" size="2" />
						<input type="submit" name="non" value="non" size="2" />
					</form>
<?php										} // fin if
											else
											{	$numer=$verif_bte_res['nbre']+1;
								echo 'Le dernier article créé est <b>'.$art_LIB.'</b><br/>
								Voulez-vous créer la boite '.$art_LIB.'_B'.$numer.' ?';
	?>				<form action="creation_boite.php" method="post">
						<input type="hidden" name="numer" value="<?php echo $numer;?>" />
						<input type="hidden" name="nom" value="<?php echo $art_LIB;?>" />
						<input type="submit" name="oui" value="oui" size="2" />
						<input type="submit" name="non" value="non" size="2" />
					</form>
<?php										} // fin else
										} // fin while
									} // fin if
								} // fin else
?>				<form action="creation_boite.php" method="post">
					<input type="submit" name="creation" value="créer une boite"/>
				</form><hr/>
			</td>
		</tr>
		<tr>
			<td width="350" valign="top" rowspan=2>
<!--DEBUT entete tableau colonne gauche------------------------------------------------->
	<form action="creation_boite.php" method="post">
				<table bgcolor="lightgray">
					<tr><td width="170">Exemplaire</td>
						<td width="100">
								<input type="submit" name="second" value="déplacer les exemplaires"/>
						</td>
					</tr>
					<tr><td colspan=2><hr/></td></tr>
				</table>
<!--DEBUT corps tableau colonne gauche-------------------------------------------------->
<?php							$i=0;
								$affich=mysql_query("SELECT exp_ID,exp_LIB1 FROM te_exemplaire2_exp ORDER BY exp_LIB1");
								while(list($exp_ID,$exp_LIB1)=mysql_fetch_array($affich))
								{
	echo		'<table id="'.$i.'">
					<tr><td width="20">';
?>
							<input type="checkbox" name="checky[]" value="<?php echo $exp_ID;?>" onclick="color=this.checked?'#DEFBC5':'';document.getElementById('<?php echo $i;?>').style.backgroundColor=color;">
<?php	echo 			"</td>
						<td width='250'>".$exp_LIB1.'</td>
					</tr>
				</table>';
									$i=$i+1;
								} // fin while
?>		</td>
<!--DEBUT colonne verticale de séparation-------------------------------------------------->
		<td width="5" style="border-right:1px solid" rowspan=2>
		</td>
<!--DEBUT colonne 2 - choix boite --------------------------------------------------------->
		<td width="50" valign="top" height="100">
				<input type="submit" name="affich" value="afficher le contenu de la boite "/>
				Boite n°
				<select name="boite">
					<option value="" selected="selected">Aucun</option>
<?php							$liste1=mysql_query("SELECT bte_ID,bte_LIB1 FROM te_boite2_bte WHERE bte_LIB1<>'' ORDER BY bte_LIB1");
								while(list($bte_ID,$bte_LIB1)=mysql_fetch_array($liste1))
								{
?>					<option value="<?php echo $bte_ID;?>"><?php echo $bte_LIB1;?></option>
<?php							} // fin while
?>				</select><br/><br/>
	</form><br/>
<!--DEBUT colonne 2 - entete du tableau -------------------------------------------------->
<?php							if (empty($boite))
								{$boite='';
								echo "<p><b>Liste des exemplaires <span style='color:green'>sans boite</span></b><p/><hr/><br/>";
								}
								$boit=mysql_query("SELECT bte_LIB1 FROM te_boite2_bte WHERE bte_ID='$boite'ORDER BY bte_LIB1");
								while(list($bte_LIB1)=mysql_fetch_array($boit))
								{
				echo "<b>Boite <span style='color:green'>".$bte_LIB1.'</span></b><br/>
				<hr/><br/><br/>';
								} // fin while
// <!--DEBUT colonne 2 - corps du tableau -------------------------------------------------->
								$select2=mysql_query("SELECT exp_LIB1 FROM te_exemplaire2_exp WHERE bte_ID='$boite' ORDER BY exp_LIB1");
								while(list($exp_LIB1)=mysql_fetch_array($select2))
								{
?>				<span style="color:blue"><?php echo $exp_LIB1;?></span><br/>
<?php							} // fin while
								mysql_close();
?>			</td>
		</tr>
	</table>

</div><!-- fin div "zoneCorpsDoc"  -->
</div> <!-- fin div "bodystyle" -->

</body>
</html>