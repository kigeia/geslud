<?php

function Testloginetmdp($logingeslud,$mdpgeslud)
{	include("connexion1.php"); // connexion à la BDD
	mysql_query("SET NAMES 'utf8'");
	$requete="SELECT usr_LIB,usr_type,usr_ID FROM te_utilisateur_usr WHERE usr_LIB ='".$logingeslud."' and usr_mdp='".$mdpgeslud."'";
	$res = mysql_query($requete) or die(mysql_error()); 
	if (mysql_num_rows($res)==0)
	{	$utilisateurs[0]='';
		$utilisateurs[1]='';
		$utilisateurs[2]='';
		return $utilisateurs;
	}
	else
	{	$fields = mysql_fetch_array($res,MYSQL_ASSOC);
		mysql_data_seek($res,0);
		while ( $fields = mysql_fetch_array($res, MYSQL_ASSOC))
		{	foreach ( $fields as $field )
			{	$utilisateurs[]=$field;
			}
		}
	return $utilisateurs;
	}
}
?>