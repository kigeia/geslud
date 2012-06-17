<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
    <?php
	include("./include/connexion1.php");	
mysql_query("SET NAMES 'utf8'");
?>
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<style type="text/css" media="screen, print">
			@import url("../ludoCss/stylesAccueil2.css");
			@import url("../ludoCss/creaJeu.css");
		</style>
		<title>REEL - Gestion de la ludothèque</title>
		<meta name="Robots" content="noindex, nofollow">
		<meta name="description" lang="fr" content="gestion de la ludothèque de Reel">
		<meta name="keywords" lang="fr" content="Reel,Ludothèque">
	</head>
    <body>
<?php
include("connexion1.php");
mysql_query("SET NAMES 'utf8'");
	if (isset($_GET['idd']))
	{	$idd=$_GET['idd'];}
	else {$idd='';}
	if (isset($_GET['login']))
	{	$login=$_GET['login'];
		$clef=$_GET['clef'];
	}
	else	{	$clef='';
				$clef='';}

$nom=mysql_query("SELECT bte_LIB FROM te_boite_bte WHERE bte_ID='$idd'");
while(list($bte_LIB)=mysql_fetch_array($nom))
{
	?>
    <table>
			<tr>
				<td colspan=3>
                	<h3><?php echo $bte_LIB;?></h3>
                    
				</td>
                <td>
                	<a href="indexprojet.php?login=<?php echo $login;?>&clef=<?php echo $clef;?>">retour à la liste</a>
                </td>
			</tr>
            <tr>
            	<td colspan=4>
                	<hr/>
                </td>
            </tr>
            <tr>
            	<td width="200">
                	mouvement
                </td>
                <td width="100">
                	date
                </td>
                <td width="100">
                	heure
                </td>
                <td width="150">
                	auteur
                </td>
            </tr>
            <tr>
            	<td colspan=4>
                	<hr/>
                </td>
            </tr>
            <?php
	$affich=mysql_query("SELECT * FROM th_mouvement_mvt WHERE bte_ID='$idd' ORDER BY mvt_ID");
	while(list($mvt_ID,$lie_ID,$bte_ID,$mvt_DAA,$mvt_UAA,$mvy_TAA)=mysql_fetch_array($affich))
	{
		?>
		
            
            <tr>
            	<td>
                	<?php echo $lie_ID;?>
                </td>
                <td>
                	<?php echo $mvt_DAA;?>
                </td>
                <td>
                	<?php echo $mvy_TAA;?>
                </td>
                <td>
                	<?php echo $mvt_UAA;?>
                </td>
		
		<?php
	}
	?>
    </tr>
    </table>
    <?php
}
?>
</body>
</html>