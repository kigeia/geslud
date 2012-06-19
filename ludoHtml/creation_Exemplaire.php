<?php					session_start();
						if (!isset($_SESSION['connexion']))
						{	echo "vous n'etes pas (ou plus) connecté : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
						else
						{	if ($_SESSION['usr_droit2']!=1)
							{	echo "vous n'avez pas les privilèges pour cette page : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
							else
							{
								$_SESSION['page'] = 'maj';	// mise en cache du num de page pour onglet coloré
								include_once("include/connexion1.php");
									mysql_query("SET NAMES 'utf8'");
								include_once("include/htmlhead.inc.php");
									headhtml("creation_Exemplaire","creation_Exemplaire");
								include("include/menu.inc.php");
?><body>
<?php							$Design =$_POST['Design'] ;
?>	<div class="zoneCorpsDoc">
<?php							$req01="SELECT exp_ID,exp_LIB,exp_num,exp_LIB1,art_ID"
									." FROM te_exemplaire2_exp WHERE exp_LIB ='$Design'";
								$res01=mysql_query($req01);
								while(list($exp_ID0,$exp_LIB0,$exp_num0,$exp_LIB10,$art_ID0)=mysql_fetch_array($res01))
								{
?>		<table border=2 CELLPADDING=5 BORDERCOLOR="green">
			<tr>
				<td><?php echo "exp_Id : ".$exp_ID0."";?></td>
				<td><?php echo "exp_LIB : ".$exp_LIB0."";?></td>
				<td><?php echo "exp_num : ".$exp_num0."<br>";?></td>
				<td><?php echo "exp_LIB1 : ".$exp_LIB10."<br>";?></td>
				<td><?php echo "art_ID : ".$art_ID0."<br>";?></td>
			</tr></br>
		</table> 
<?php							} // fin while
								$req02="SELECT MAX(exp_num) FROM te_exemplaire2_exp WHERE exp_LIB ='$Design'";
								$res02==mysql_query($req02);
								$num_max = mysql_result($res02,0);
								$exemple=$num_max+1;
								echo "</br>Cela sera le ".$exemple."e exemplaire de cet article.</br></br>";
								echo "Il portera l'intitulé ".$Design."_E".$exemple.'.</br></br>';
								$exemplaire=$Design."_E".$exemple;
								$num=$exemple;

								// recherche de art_ID correspondant au $Design
								$req03="SELECT art_ID FROM te_article_art WHERE art_LIB='$Design'";
								$rechercheArtID=mysql_query($req03);
								$art_ID=mysql_fetch_array($rechercheArtID);
								// echo 'art_ID req : '.$art_ID[0].'<br/>';
								mysql_close();
?>
	<table class='tableau1'>
		<tr><td>
				<form action="ajout_EX.php" method="post" >
					<input type="hidden" name="Design" value="<?php echo($Design);?>" />
					<input type="hidden" name="exemple" value="<?php echo($exemple);?>" />
					<input type="hidden" name="exemplaire" value="<?php echo($exemplaire);?>" />
					<input type="hidden" name="article" value="<?php echo($art_ID[0]);?>" />
					<input type="submit" value="Ajouter votre exemplaire" />
				</form>
			</td>
			<td>ou</td>
			<td>
				<form action="maj.php" method="post" >
					<input type="submit" value="Annuler" />
				</form>
			</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
	</table>
	</div>
</body> 
</html>
<?php
				} // fin if ($_SESSION['connexion'] != 4)
			} // fin test connexion
?>