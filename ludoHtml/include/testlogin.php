<?php

function Testloginetmdp($logingeslud,$mdpgeslud)
{	include("connexion1.php"); // connexion à la BDD
	mysql_query("SET NAMES 'utf8'");
	$requete=mysql_query("SELECT count(*) as nombre FROM te_utilisateur_usr WHERE usr_LIB ='".$logingeslud."' and usr_mdp='".$mdpgeslud."'"); // recherche identifiant dans la BDD
	$res = mysql_fetch_array($requete);
	if ($res['nombre'] <>1)
	{	$deconnecte=2;
		return $deconnecte;
	}
	else
	{	$deconnecte=4;
	return $deconnecte;
	}
}
?>