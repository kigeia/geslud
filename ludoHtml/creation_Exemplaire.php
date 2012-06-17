<?php					session_start();
						if (!isset($_SESSION['connexion']))
/* ajout du 01/06/2012*/ {	echo "vous n'etes pas (ou plus) connecté : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
						else
/* ajout du 02/06/2012*/ {	if ($_SESSION['usr_droit2']!=1)
							{	echo "vous n'avez pas les privilèges pour cette page : veuillez passer par la page d'accueil <a href='../index.php'> ici </a>"; }
							else
							{
								$_SESSION['page'] = 'maj';	// mise en cache du num de page pour onglet coloré
								include_once("include/connexion1.php");
								include_once("include/htmlhead.inc.php");
								mysql_query("SET NAMES 'utf8'");
								headhtml("creation_Exemplaire","creation_Exemplaire");
?><body>
<?php							$Design =$_POST['Design'] ;
								include("include/menu.inc.php");
?>
	<div class="zoneCorpsDoc">
<?php							$result=mysql_query("SELECT * FROM te_exemplaire2_exp WHERE exp_LIB LIKE '$Design'");
								$nombre_rows = mysql_num_rows($result);
								while ($row = mysql_fetch_row($result))
								{
?>		<table border=2 CELLPADDING=5 BORDERCOLOR="green">
			<tr>
				<td><?php echo "exp_Id : ".$row[0]."";?></td>
				<td><?php echo "exp_LIB : ".$row[1]."";?></td>
				<td><?php echo "exp_num : ".$row[2]."<br>";?></td>
				<td><?php echo "exp_LIB1 : ".$row[3]."<br>";?></td>
				<td><?php echo "art_ID : ".$row[8]."<br>";?></td>
			</tr></br>
		</table> 
<?php							} // fin while
								$exemple=$nombre_rows+1;
								echo "</br>Cela sera le ".$exemple."e exemplaire de cet article.</br></br>";
								echo "Il portera l'intitulé ".$Design."_E".$exemple.'.</br></br>';
								$exemplaire=$Design."_E".$exemple;
								$num=$exemple;

								// recherche de art_ID correspondant au $Design
								$rechercheArtID=mysql_query("SELECT art_ID FROM te_article_art WHERE art_LIB='$Design'");
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