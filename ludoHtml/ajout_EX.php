<?php		//	utilise	include	include/connexion1.php
			//					include/htmlhead.inc.php : headhtml()
			//					include/menu.inc.php
			//			CSS		css/creation_Exemplaire.css
			//		->	SESSION	connexion, usr_droit4, utilisateur_ID
			//		<-	SESSION	page, 
			//			POST	Design,exemple,article,
			//			BDD		te_exemplaire2_exp

						session_start();

						if (!isset($_SESSION['connexion']))
/* ajout du 01/06/2012*/ {	echo "vous n'etes pas (ou plus) connecté : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
							else
/* ajout du 02/06/2012*/	{	if ($_SESSION['usr_droit4']!=1)
	echo "vous n'avez pas les privilèges pour cette page : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>";
								else
								{	$_SESSION['page'] = 'creation_boite';	// mise en cache du num de page pour onglet coloré
										$utilisateur_ID=$_SESSION['utilisateur_ID'];
									include_once("include/connexion1.php");
										mysql_query("SET NAMES 'utf8'");
									include_once("include/htmlhead.inc.php");
										headhtml("ajout_EX","creation_Exemplaire");
?><body class="bodystyle">
<?php								include("include/menu.inc.php");
									$Design= $_POST['Design'];		
									$exemple = $_POST['exemple'];		
									$exemplaire = $_POST['exemplaire'];
									$article = $_POST['article'];
									// $sql= "INSERT INTO te_exemplaire2_exp (exp_ID,exp_LIB,exp_num,exp_LIB1,exp_RG,exp_TXT,exp_MOD,art_ID,exp_acquisitionAnnee_DN,bte_ID,exp_provenance_DA,exp_proprietaire_DA)
									// VALUES (NULL , '$Design' , '$exemple', '$exemplaire', NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL)";

									// $sql = "INSERT INTO `geslud`.`te_exemplaire2_exp` (`exp_ID`, `exp_LIB`, `exp_num`, `exp_LIB1`, `exp_RG`, `exp_TXT`, `exp_MOD`, `exp_TRI`, `art_ID`, `exp_acquisitionAnnee_DN`, `bte_ID`, `exp_provenance_DA`, `exp_proprietaire`, `exp_crea_DAA`, `exp_crea_UAA`)
									// VALUES (NULL, \'Dune_5\', NULL, NULL, NULL, NULL, \'1\', \'exp\', NULL, NULL, NULL, NULL, NULL, CURRENT_TIMESTAMP, NULL);";
									$exp_annee = date("Y");
									$exp_crea_DAA = date("Y-m-d H:i:s");
									$req01="INSERT INTO te_exemplaire2_exp (exp_LIB,exp_num,exp_LIB1,art_ID,exp_annee,exp_crea_DAA,exp_crea_UAA)"
										."VALUES ('$Design','$exemple','$exemplaire','$article','$exp_annee','$exp_crea_DAA','$utilisateur_ID')";
									$res01= mysql_query($req01);
?>		<div class="zoneCorpsDoc">
<?php
/*									if (mysql_insert_id() === 0) 
									{	// printf("Dans la base le id est %d\n", mysql_insert_id(),"</br></br>");
										// echo"</br> Enregistrement non valide</br>Recommencez</br>";
									} 
									elseif (mysql_errno() > 0) 
									{	print ("Erreur n° ".mysql_errno()."<br>");
										print ("Description de votre erreur : ".mysql_error()."</br>");
										print ('<img src="error.png" border="0" />');
										print ('</br><font face="arial" size="4" color="blue"> Description de votre erreur : vous ne pouvez pas dupliquer le même nom</font>');
									} // fin elseif
									else
									{	printf("Le dernier ID inséré dans la base est le id %d\n", mysql_insert_id(),"</br></br>");
									}
*/
	echo			"</br>Le dernier ID inséré dans la base est le id ", mysql_insert_id(),"</br>";
	echo			"</br>Il s'agit d'un nouvel exemplaire de l'article ".$Design.".</br></br>";
	echo			$exemplaire." a bien été ajouté dans la base de données.</br><br/><br/>";
?>
				<form action="maj.php" method="post" >
					<input type="submit" value="Retourner au menu création article" />
				</form><br/><br/>
		</div>
<?php								mysql_close();  
?>
<!--		<br/><br/>
		<a href="maj.php">retour au formulaire de création d'article</a>
	</div>
-->
</body>
</html>
<?php
							} // fin if ($_SESSION['connexion'] != 4)
						} // fin test connexion
?>