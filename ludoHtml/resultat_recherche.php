<?php			//	utilise	lien	
				//			INC		include	include/connexion1.php
				//					include/fonctions.inc.php : fsecure()
				//					include/htmlhead.inc.php : headhtml()
				//					include/menu.inc.php
				//			CSS		css/resultat_recherche.css
				//		->	SESSION	connexion,usr_droit9
				//		<-	SESSION	page, 
				//			POST	
				//			BDD		te_article_art, te_exemplaire2_exp, te_boite2_bte, te_carton_crt,
				//			class	

								session_start();
								if (!isset($_SESSION['connexion']))
								/* ajout du 01/06/2012*/		{	echo "vous n'etes pas (ou plus) connecté : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
								else
								/* ajout du 02/06/2012*/		{	if ($_SESSION['usr_droit9']!=1)
									{	echo "vous n'avez pas les privilèges pour cette page : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
									else
									{	
		$_SESSION['page'] = 'ludotheque';	// mise en cache du num de page pour onglet coloré
										$dossier ='images/';
										include_once("include/connexion1.php");
										include_once("include/htmlhead.inc.php");
										mysql_query("SET NAMES 'utf8'");
										include_once("include/fonctions.inc.php");
										headhtml("resultat","resultat_recherche");
?><body>
	<div class="bodystyle">
<?php									include("include/menu.inc.php");
?>		<!-- TITRE DU DOCUMENT -->
		<br/><div class='titre'><h5>Gestion Ludo - Recherches multiples</h5></div>
		<!-- FIN DU TITRE DU DOCUMENT -->

		<div class="zoneCorpsDoc">
			<div align="center">
				<br/><a href="ludotheque.php">Retour à la page recherche</a><br/><br/>
			</div>
<?php
										if(isset($_POST['X']))
										{
/**/	echo "<h3>X. Recherche rapide des caractéristiques et du lieu où se trouve<br/>&nbsp;&nbsp;&nbsp; le jeu contenant le mot <span style='color:red'>".fsecure($_POST['jeu'])."</span> : </h3>";
											//recherche d'un jeu
											$req00="SELECT art_LIB,art_ID,jtp_ID,art_nbJoueursMini_DN,jmx_ID,dur_ID,thm_ID,art_image_IMG FROM te_article_art WHERE (art_materielType_DA='jeu') AND art_LIB like '%".fsecure($_POST['jeu'])."%' ORDER BY art_LIB";
											$res00=mysql_query($req00);
											while(list($art_LIB,$art_ID,$jtp_ID,$art_nbJoueursMini_DN,$jmx_ID,$dur_ID,$thm_ID,$art_image_IMG)=mysql_fetch_array($res00))
											{	$req02="SELECT jtp_LIB FROM tx_jeutype_jtp WHERE jtp_ID='$jtp_ID'";
												$res02=mysql_query($req02);
												$jtp_LIB=mysql_fetch_row($res02);
												
												$req03="SELECT thm_LIB FROM tx_jeutheme_thm WHERE thm_ID='$thm_ID'";
												$res03=mysql_query($req03);
												$thm_LIB=mysql_fetch_row($res03);
		echo "<div class='jeu'>
				<table class='tableau4'><tr>
					<td class='td6'><h3 style='color:blue'>".$art_LIB."</h3></td>
					<td> <img src='images/".$art_image_IMG."' width='80'/></td>"
					."<td class='td6'>".$jtp_LIB[0]."<br/>"
							."de ".$art_nbJoueursMini_DN." à ".$jmx_ID." joueurs<br/>"
							."durée ".$dur_ID." min env.<br/>"
							."thème ".$thm_LIB[0]
					."</td></tr>
				</table>";
												$req01="SELECT exp_LIB1,bte_LIB1,crt_LIB,lie_LIB "
													."FROM te_exemplaire2_exp, te_boite2_bte, tx_lieu_lie "
													."WHERE (te_exemplaire2_exp.bte_ID = te_boite2_bte.bte_ID) "
													."AND (tx_lieu_lie.lie_ID = te_boite2_bte.lie_ID) "
													."AND te_exemplaire2_exp.art_ID='".$art_ID."' "
													."ORDER BY bte_LIB1";
											$res01=mysql_query($req01);											
											
	echo	"<table class='tableau4'><th>exemplaires</th><th>boites</th><th>cartons</th><th>lieux</th></tr>";
												while(list($exp_LIB1,$bte_LIB1,$crt_LIB,$lie_LIB)=mysql_fetch_array($res01))
												{	
	echo		'<tr><td>'.$exp_LIB1.'</td><td>'.$bte_LIB1."</td><td class='td6'>".$crt_LIB."</td><td class='td6'>".$lie_LIB.'</td></tr>';
												}// fin while
	echo	'</table></div>';
											}
											if (mysql_num_rows($res00)==0)
											{ 
	echo						"<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Il n'y a pas de résultat valide pour votre demande.";
											} // fin if
										} // fin else


										else if(isset($_POST['A']))
										{
	echo '<h3>A. Principales statistiques sur la Base de données</h3>';
											//Principales statistiques sur la Base de données
												//
	echo				'<h4>La base de donnée est composée de :</h4>';
											// nb d'articles
											$req="SELECT art_id FROM te_article_art";
											$res=mysql_query($req);
											$nbarticle=mysql_num_rows($res);
	echo				'- '.$nbarticle.' articles (dont ';
											// nb d'articles qui ne sont pas des jeux
											$req2="SELECT art_id FROM te_article_art WHERE art_materieltype<>'jeu'";
											$res2=mysql_query($req2);
											$nbdivers=mysql_num_rows($res2);
	echo				$nbdivers.' qui ne sont pas des jeux),<br/>';
											// nb d'exemplaires
											$req3="SELECT exp_id FROM te_exemplaire2_exp";
											$res3=mysql_query($req3);
											$nbexemplaire=mysql_num_rows($res3);
	echo				'- '.$nbexemplaire.' exemplaires (liés à ';
											// nb d'exemplaires d'articles différents
											$req4="SELECT DISTINCT exp_LIB FROM te_exemplaire2_exp";
											$res4=mysql_query($req4);
											$nbexemplairediff=mysql_num_rows($res4);
	echo				$nbexemplairediff.' articles différents),<br/>';
											// nb de boites
											$req5="SELECT bte_LIB1 FROM te_boite2_bte WHERE bte_LIB<>'NULL'";
											$res5=mysql_query($req5);
											$nbboite=mysql_num_rows($res5);
	echo				'- '.$nbboite.' boites (dont ';
											// nb de boites vides
											$req5="SELECT bte_LIB1 FROM te_boite2_bte WHERE bte_LIB<>'NULL' AND te_boite2_bte.bte_ID NOT IN ( SELECT DISTINCT bte_ID FROM te_exemplaire2_exp where bte_ID<>'NULL')";
											$res5=mysql_query($req5);
											$nbboitevide=mysql_num_rows($res5);
	echo				$nbboitevide.' boites vides),<br/>';
											// nb de cartons
											$req06="SELECT crt_LIB FROM te_carton_crt";
											$res06=mysql_query($req06);
											$nbcarton=mysql_num_rows($res06);
	echo				'- '.$nbcarton.' cartons (dont ';
											// nb de cartons vides
											//      SELECT crt_LIB FROM te_carton_crt WHERE te_carton_crt.crt_LIB NOT IN ( SELECT DISTINCT crt_LIB FROM te_boite2_bte)
											$req07="SELECT crt_LIB FROM te_carton_crt WHERE te_carton_crt.crt_LIB NOT IN ( SELECT DISTINCT crt_LIB FROM te_boite2_bte where crt_LIB<>'NULL')";
											$res07=mysql_query($req07);
											$nbcartonvide=mysql_num_rows($res07);
											echo				$nbcartonvide.' cartons vides),<br/>';
											// nb de lieux
											$req08="SELECT lie_ID FROM tx_lieu_lie";
											$res08=mysql_query($req08);
											$nblieu=mysql_num_rows($res08);
	echo				'- '.$nblieu.' lieux différents de stockage.';

/**/


										} // fin if(isset($_POST['99']))
										else if(isset($_POST['1']))
										{
	echo '<h3>1. Articles sans exemplaire</h3>';
									//articles sans exemplaires
											// $req=mysql_query("SELECT art_ID,art_LIB FROM te_article_art");
											// 
											$req10="SELECT art_ID,art_LIB FROM te_article_art";
											$res10=mysql_query($req10);
											while(list($art_ID,$art_LIB)=mysql_fetch_array($res10))
											{	$select=mysql_query("SELECT COUNT(*) AS nbre FROM te_exemplaire2_exp WHERE art_ID='$art_ID'");
												$select1=mysql_fetch_array($select);
												if($select1['nbre']==0)
												{
	echo			''.$art_LIB.'<br/>';
												} // fin if
											} // fin while
//	echo		"<input type='image' src='images/imprimer.png' onClick='javascript:window.print();'>"; // essai impression avec eddie
											if (mysql_num_rows($select)==0)
											{ 
											} // fin if
										} // fin if(isset($_POST['1']))
										else if(isset($_POST['2']))
										{
	echo '<h3>2. Exemplaires sans boîte</h3>';
											//exemplaires sans boite
											// $sql = "SELECT exp_LIB FROM te_exemplaire2_exp WHERE (bte_ID IS NULL OR bte_ID=0)";
											$req=mysql_query("SELECT exp_LIB1 FROM te_exemplaire2_exp WHERE (bte_ID IS NULL OR bte_ID=0) ORDER BY exp_LIB1");
											// $req=mysql_query("SELECT exp_LIB FROM te_exemplaire2_exp WHERE bte_ID='' OR bte_ID='0'");
											while(list($exp_LIB1)=mysql_fetch_array($req))
											{	echo ''.$exp_LIB1.'<br/>';
											} // fin while
												if (mysql_num_rows($req)==0)
												{ 
echo						"<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Il n'y a pas de résultat valide pour votre demande.";
												}
										} // fin else
										else if(isset($_POST['3']))
										{
	echo '<h3>3. Boîtes sans exemplaire</h3>';
											//boites sans exemplaire
/* erreur */								// $sql = "SELECT bte_LIB FROM te_boite2_bte WHERE (bte_ID NOT LIKE \'%_B%\' LIMIT 0, 30 ";
											// $sql = "SELECT bte_LIB1, bte_ID FROM te_boite2_bte WHERE te_boite2_bte.bte_ID NOT IN ( SELECT DISTINCT bte_ID FROM te_exemplaire2_exp where bte_ID<>0)";
											$req=mysql_query("SELECT bte_LIB1 FROM te_boite2_bte WHERE bte_LIB<>'NULL' AND te_boite2_bte.bte_ID NOT IN ( SELECT DISTINCT bte_ID FROM te_exemplaire2_exp where bte_ID<>'NULL')");
											while(list($bte_LIB1)=mysql_fetch_array($req))
											{	
	echo	''.$bte_LIB1.'<br/>';
											}// fin while
												if (mysql_num_rows($req)==0)
												{ 
echo						"<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Il n'y a pas de résultat valide pour votre demande.";
												}
											} // fin else
										else if(isset($_POST['4']))
										{
	echo '<h3>4. Boîtes sans carton</h3>';
											//----boites sans carton---------------
											// $sql = "SELECT bte_LIB FROM `te_boite2_bte` WHERE `crt_LIB` = \"\"";
											$req=mysql_query("SELECT bte_LIB1 FROM te_boite2_bte WHERE (crt_LIB = \"\" OR crt_LIB IS NULL OR crt_LIB='INCO') ORDER BY bte_LIB");
											while(list($bte_LIB1)=mysql_fetch_array($req))
											{	
	echo			''.$bte_LIB1.'<br/>';
											} // fin while
												if (mysql_num_rows($req)==0)
												{ 
echo						"<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Il n'y a pas de résultat valide pour votre demande.";
												}
											} // fin else
										else if(isset($_POST['5']))
										{
	echo '<h3>5. Cartons vides</h3>';
											//cartons vides
											// SELECT bte_LIB1 FROM te_boite2_bte WHERE te_boite2_bte.bte_ID NOT IN ( SELECT DISTINCT bte_ID FROM te_exemplaire2_exp where bte_ID<>0)
/* erreur */								// SELECT crt_LIB FROM te_carton_crt WHERE te_carton_crt.crt_LIB NOT IN ( SELECT DISTINCT crt_LIB FROM te_boite2_bte)
											$req=mysql_query("SELECT crt_LIB FROM te_carton_crt WHERE te_carton_crt.crt_LIB NOT IN ( SELECT DISTINCT crt_LIB FROM te_boite2_bte)");
											while(list($crt_LIB)=mysql_fetch_array($req))
											{
	echo			''.$crt_LIB.'<br/>';
											}
												if (mysql_num_rows($req)==0)
												{ 
echo						"<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Il n'y a pas de résultat valide pour votre demande.";
												}

										} // fin else if(isset($_POST['5']))
										else if(isset($_POST['6']))
										{
											$carton=$_POST['carton'];
	echo "<h3>6. Exemplaires du carton n° <span style='color:red'>".$carton.' </span>(avec images)</h3>';
	echo	"<table class='tableau3'><tr><th class='entete10'>Image</th>
										<th class='entete10'>Exemplaire</th>
										<th class='entete10'>Boite</th>
									</tr>";
											//exemplaires contenus dans un carton
											// $sql = "SELECT exp_LIB1, te_exemplaire2_exp.bte_ID,art_image_IMG FROM te_exemplaire2_exp,te_article_art,te_boite2_bte WHERE te_exemplaire2_exp.art_ID= te_article_art.art_ID AND te_exemplaire2_exp.bte_ID=te_boite2_bte.bte_ID AND crt_LIB='$carton'"
											$affich_boit=mysql_query("SELECT art_image_IMG,exp_LIB1,bte_LIB1, te_exemplaire2_exp.bte_ID FROM te_exemplaire2_exp,te_article_art,te_boite2_bte WHERE te_exemplaire2_exp.art_ID= te_article_art.art_ID AND te_exemplaire2_exp.bte_ID=te_boite2_bte.bte_ID AND crt_LIB='$carton'");
											while(list($art_image_IMG,$exp_LIB1,$bte_LIB1,$bte_ID)=mysql_fetch_array($affich_boit))
											{
		echo			"<tr><td align='center'><img src='".$dossier.$art_image_IMG."' style='width:90px'><br/></td>";
		echo				 "<td align='center'>".$exp_LIB1.'<br/></td>';
		echo				 "<td class='celluleCentree'>".$bte_LIB1.' <br/>(n°'.$bte_ID.')<br/></td>';
		echo			'</tr>';
											}
	echo	'</table>';
												if (mysql_num_rows($affich_boit)==0)
												{ 
echo						"<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Il n'y a pas de résultat valide pour votre demande.";
												}
										} // fin else if
										else if(isset($_POST['7']))
										{	$boite=$_POST['boite'];
	echo "<h3>7. Exemplaires de la boîte n° <span style='color:red'>".$boite." </span></h3>";
						//exemplaires contenus dans une boite
											// $affich_cont=mysql_query("SELECT exp_LIB1 FROM te_exemplaire2_exp WHERE bte_ID='$boite'");
											$affich_cont=mysql_query("SELECT exp_LIB1 FROM te_exemplaire2_exp,te_boite2_bte WHERE te_exemplaire2_exp.bte_ID = te_boite2_bte.bte_ID AND bte_LIB1='$boite'");
											while(list($exp_LIB1)=mysql_fetch_array($affich_cont))
											{
	echo			''.$exp_LIB1.'<br/>';
											}
												if (mysql_num_rows($affich_cont)==0)
												{ 
echo						"<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Il n'y a pas de résultat valide pour votre demande.";
												}
											}
										else if(isset($_POST['8']))
										{	$article=$_POST['article'];
	echo "<h3>8. Lieu des exemplaires liés au jeu de base <span style='color:red'>".$article." </span></h3>";
echo	"<table class='tableau3'><tr><th class='entete10'>Exemplaire</th>
									<th class='entete10'>Carton</th>
									<th class='entete10'>Lieu</th>
								</tr>
								<tr>";
											
	//cartons qui contiennent les différents exemplaires de l'article x
											$req = "Select exp_LIB1,crt_LIB,lie_LIB FROM te_exemplaire2_exp,te_boite2_bte,te_article_art,tx_lieu_lie WHERE tx_lieu_lie.lie_ID=te_boite2_bte.lie_ID AND te_exemplaire2_exp.bte_ID=te_boite2_bte.bte_ID AND te_exemplaire2_exp.exp_LIB=te_article_art.art_LIB\n"
											. "AND jba_ID =( SELECT jba_ID FROM te_article_art WHERE art_LIB='".$article."' ORDER BY art_ID LIMIT 0,1)";
											$affich_boit1=mysql_query($req);
											while(list($exp_LIB1,$crt_LIB,$lie_LIB)=mysql_fetch_array($affich_boit1))
											{	
echo			"<tr><td align='center'>".$exp_LIB1."</td>";
echo				 "<td align='center'>".$crt_LIB.'</td>';
echo				 "<td class='celluleCentree'>".$lie_LIB.'</td>';
echo			'</tr>';
											} // fin du while
	echo	'</table>';
												if (mysql_num_rows($affich_boit1)==0)
												{ 
	echo						"<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Il n'y a pas de résultat valide pour votre demande.";
												}
										}
										else if(isset($_POST['9']))
										{	$exemp=$_POST['exemp'];
	echo "<h3>9. Exemplaires liés à l'article <span style='color:red'>".$exemp." </span></h3>";
											//exemplaires de l'article x
											$affich_exemp=mysql_query("SELECT exp_LIB1 FROM te_exemplaire2_exp WHERE exp_LIB='$exemp'");
											while(list($exp_LIB1)=mysql_fetch_array($affich_exemp))
											{
	echo			''.$exp_LIB1.'<br/>';
											} // fin while
											if (mysql_num_rows($affich_exemp)==0)
											{ 
echo						"<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Il n'y a pas de résultat valide pour votre demande.";
											}
										} // fin else
										else if(isset($_POST['10']))
										{
	echo '<h3>10. Boites en catégorie Réserve uniquement</h3><br/>';
											//Boites en catégorie Réserve
											$affich_exemp=mysql_query("SELECT bte_LIB1 FROM te_boite2_bte WHERE sor_GUID='R'");
											while(list($exp_LIB1)=mysql_fetch_array($affich_exemp))
											{
												echo			''.$exp_LIB1.'<br/>';
											} // fin while
											if (mysql_num_rows($affich_exemp)==0)
											{ 
echo						"<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Il n'y a pas de résultat valide pour votre demande.";
											}
										}
										else if(isset($_POST['11']))
										{
	echo '<h3>11. Articles sans numéro BGG</h3>';
											//article sans numéro BGG
											// $sql = "SELECT art_LIB FROM `te_article_art` WHERE `art_bgg_ID` = \"\"";
											$affich_art=mysql_query("SELECT art_LIB FROM te_article_art WHERE art_bgg_ID = \"\"");
											while(list($art_LIB)=mysql_fetch_array($affich_art))
											{
					echo ''.$art_LIB.'<br/>';
											}
											if (mysql_num_rows($affich_art)==0)
											{ 
echo						"<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Il n'y a pas de résultat valide pour votre demande.";
											}
										}
										else if(isset($_POST['12']))
										{
	echo '<h3>12. Articles sans image</h3>';
											//article sans image
											$affich_img=mysql_query("SELECT art_LIB FROM te_article_art WHERE art_image_IMG=''");
											while(list($art_LIB)=mysql_fetch_array($affich_img))
											{
					echo ''.$art_LIB.'<br/>';
											}
											if (mysql_num_rows($affich_img)==0)
											{ 
echo						"<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Il n'y a pas de résultat valide pour votre demande.";
											}
										}
										else if(isset($_POST['13']))
										{
	echo '<h3>13. Boîtes dont catégorie de sortie est différente de celle du carton où elles sont affectées</h3>';
											//boites dont la catégorie de sortie est différente de celle du carton où elles sont affectées
											// $affich_box=mysql_query("SELECT bte_LIB1,sor_GUID,crt_LIB FROM te_boite2_bte");
	echo	"<table class='tableau3'>
				<tr class='entete10'>
						<th>Boite</th>
						<th>Cat. Boite</th>
						<th>Carton</th>
					</tr>
					<tr>";
											// $sql = "SELECT bte_LIB1,sor_GUID,crt_LIB FROM te_boite2_bte WHERE sor_GUID<>LEFT(crt_LIB,1)";
											$affich_box=mysql_query("SELECT bte_LIB1,sor_GUID,crt_LIB FROM te_boite2_bte WHERE bte_LIB1<>'' AND sor_GUID<>LEFT(crt_LIB,1) ORDER BY bte_LIB1");
											while(list($bte_LIB1,$sor_GUID,$crt_LIB)=mysql_fetch_array($affich_box))
											{
	echo				 '<td>'.$bte_LIB1.'<br/></td>';
	echo				 "<td class='celluleCentree'>".$sor_GUID.'<br/></td>';
	echo				 "<td class='celluleCentree'>".$crt_LIB.'<br/></td>';
	echo			'</tr>';
											}
	echo	'</table>';
											if (mysql_num_rows($affich_box)==0)
											{ 
echo						"<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Il n'y a pas de résultat valide pour votre demande.";
											}
										}
										else if(isset($_POST['14']))
										{	
	echo '<h3>14.Liste de tous les exemplaires</h3>';
											// Liste de tous les exemplaires
											// $sql = "SELECT exp_LIB1,bte_LIB1,crt_LIB FROM te_exemplaire2_exp,te_boite2_bte WHERE te_exemplaire2_exp.bte_ID= te_boite2_bte. bte_ID ORDER BY exp_LIB1"
	echo	"<table class='tableau3'>
					<tr class='entete10'><th>Exemplaire</th>
						<th>Boite</th>
						<th>Carton</th>
					</tr>
					<tr>";
											$affich_cont=mysql_query("SELECT exp_LIB1,bte_LIB1,crt_LIB FROM te_exemplaire2_exp,te_boite2_bte WHERE te_exemplaire2_exp.bte_ID= te_boite2_bte. bte_ID ORDER BY exp_LIB1");
											while(list($exp_LIB1,$bte_LIB1,$crt_LIB)=mysql_fetch_array($affich_cont))
											{
	echo				 '<td>'.$exp_LIB1.'<br/></td>';
	echo				 "<td>".$bte_LIB1.'<br/></td>';
	echo				 "<td class='celluleCentree'>".$crt_LIB.'<br/></td>';
	echo			'</tr>';
											}
	echo	'</table>';
											if (mysql_num_rows($affich_cont)==0)
											{ 
echo						"<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Il n'y a pas de résultat valide pour votre demande.";
											}
											
										}

										else if(isset($_POST['15']))
										{	
	echo '<h3>15.Lieux où se trouvent des boîtes</h3>';
											//lieux où sont présentes des boites
	echo		"<table class='tableau4'><tr>";
											$lieux=mysql_query("SELECT lie_ID,lie_LIB FROM tx_lieu_lie");
											while(list($lie_ID,$lie_LIB)=mysql_fetch_array($lieux))
											{
	echo				"<td class='td4'><b>".$lie_LIB."</b><br/></td><td class='td5'>";
												$select_boite_lieu=mysql_query("SELECT bte_LIB1,bte_ID FROM te_boite2_bte WHERE bte_LIB<>'NULL' AND lie_ID='$lie_ID' ORDER BY lie_ID");
												while(list($bte_LIB1,$bte_ID)=mysql_fetch_array($select_boite_lieu))
												{	
	echo				"<span style='color:blue'>".$bte_LIB1.'</span> [contenant : ';
													$select_explaire_boite=mysql_query("SELECT exp_LIB1 FROM te_exemplaire2_exp WHERE exp_LIB<>'NULL' AND bte_ID='$bte_ID'");
													while(list($exp_LIB1)=mysql_fetch_array($select_explaire_boite))
													{
	echo				' * '.$exp_LIB1;
													}
	echo				' ] <br/>';
												} // fin while
												echo '<br/>';
	echo							'</td></tr>';
											}// fin while 
	echo		'</table>';				} // fin else





										else if(isset($_POST['16']))
										{	$lieu=$_POST['lieu'];
											$demand_nom=mysql_query("SELECT lie_LIB FROM tx_lieu_lie WHERE lie_ID='$lieu'");
											while(list($lie_LIB)=mysql_fetch_array($demand_nom))
											{
												$lieu0=$lie_LIB;
											}
	echo '<h3>16.Boîtes en dehors de '.$lieu0.'</h3>';
											//boites en dehors d'un lieu
											$veriflieu_boite=mysql_query("SELECT bte_LIB1 FROM te_boite2_bte WHERE lie_ID!='$lieu'");
											while(list($bte_LIB1)=mysql_fetch_array($veriflieu_boite))
											{
	echo				''.$bte_LIB1.'<br/>';
											} // fin while
										} // fin else
											else if(isset($_POST['18']))
										{
											$mois=$_POST['mois'];
	echo '<h3>18.Exemplaires créés depuis '.$mois.' mois</h3>';
											//articles créés depuis telle date
											$selection_mois=mysql_query("SELECT art_LIB FROM te_article_art WHERE art_crea_DAA=''");
											while(list($art_LIB)=mysql_query($selection_mois))
											{
	echo 				''.$art_LIB.'<br/>';
											}
										}
										else if(isset($_POST['19']))
										{	
	echo '<h3>19.Dernières modifications dans les bases articles, exemplaires, boîtes et cartons</h3>';
						//liste des dernières modifications champs TAA
										}
										else if(isset($_POST['20']))
										{
		echo "<h3>20. Différences d\'inventaire entre ".$_POST['lieu1']." et ".$_POST['lieu2']."</h3>";
		//différences de boites entre lieu1 et lieu2
											$lieu1=$_POST['lieu1'];
											$lieu2=$_POST['lieu2'];
		//	echo			''.$lieu1.' - '.$lieu2.'';
	echo				'<b>Lieu1</b><br/><br/>';
											$affich_lieubox=mysql_query("SELECT bte_LIB1 FROM te_boite2_bte WHERE lieu='$lieu1'");
											while(list($bte_LIB1)=mysql_fetch_array($affich_lieubox))
											{
			echo				''.$bte_LIB1.'<br/>';
											}
		echo				 '<br/><br/><b>Lieu2</b><br/><br/>';
		$affich_lieubox2=mysql_query("SELECT bte_LIB1 FROM te_boite2_bte WHERE lieu='$lieu2'");
		while(list($bte_LIB1)=mysql_fetch_array($affich_lieubox2))
		{
			echo				 ''.$bte_LIB1.'<br/>';
		}

	}
?>
<br/><br/><br/>
<input type='image' src='images/imprimer.png' onClick='javascript:window.print();'>
(Pour impression sous Internet Explorer ou Firefox uniquement)
			
	</div><!--	-------FIN DU CORPS DE LA PAGE------------	-->
</div><!--	----- FIN BODYSTYLE -->
</body>
</html>
<?php
				} // fin if ($_SESSION['connexion'] != 4)
} // fin test connexion
?>