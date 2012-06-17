<?php 
function headhtml($titre,$fichier2css)
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
		"http://www.w3.org/TR/html4/loose.dtd">
	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"  /> 
		<Style Type="text/css">
			@import url("../ludoCss/stylesAccueil2.css");
			@import url("../ludoCss/<?php echo $fichier2css;?>.css");
			<!-- avant toute autre règle -->
		</style>
		<title><?php echo $titre;?></title>
		<meta name="Robots" content="noindex, nofollow"/>
		<meta name="description" lang="fr" content="gestion de la ludothèque de Reel"/>
		<meta name="keywords" lang="fr" content="Reel,Ludothèque"/>
		<meta http-equiv="pragma" content="no-cache"/>
	</head>
<?php
}
?>