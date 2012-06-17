<?php
function connectMaBase()
{	// echo "echo 2<br/>";
	$serveur = "localhost";
	$base = "geslud";
	$login = "philippe";
	$motdepasse = "ludo";
	$con = mysql_connect ($serveur, $login, $motdepasse) or die ("erreur de connexion"); 
	$sel = mysql_select_db($base, $con) or die ("erreur de selection de BDD");
	$con2 ="".$con;
	$nbcar = strlen($con2);
//	echo '<br/>'.$nbcar.'<br/>';
	if ($nbcar == 14)
	{$erreurs = $con;}
	else {$erreurs = $con2."-".$sel;}
	return $erreurs;
}
function testpresence($variable)
{	// echo "echo 2";
	$nomvariable=$variable;
	if(isset($_POST["$variable"]))	{	$variable=$_POST["$variable"]; } // fin if
	else	{	$variable=''; } // fin else
		
	if(isset($_GET["$variable"]))	{	$variable=$_GET["$variable"]; } // fin if							//
	else	{	$variable==''; }; // fin else

	return "$variable";
}
function boitelogin($fichierrenvoi)
{	$fichierrenvoi=testpresence("fichierrenvoi");
	$login=testpresence("login");
	echo $login.'<br/>';
	echo $fichierrenvoi;
		if($login == '')
		{		echo "
			<form action='".$fichierrenvoi.".php' name='formulairelogin'>
				Login : <input type='text' name='login' id='login'/>
				mdp : <input type='password' name='clef' id='clef'/>
				<input type='submit' value='connexion' id='connect'/>
				<input type='reset' value='effacer' id='effacer'/>
			</form>";
		}
		else
		{	echo "vous etes connecté en tant que : ".$login;	}
	return "OK";
}
function crerlisteBDD()
{	$con=connectMaBase();
//	echo '<br/>echoB<br/>';
	$nom_table="tx_lieu_lie";
	$req = "select lie_LIB from $nom_table;" ;
//	echo 'req : '.$req.'<br/>';
	$res = mysql_query($req,$con) or die("erreur dans requete");
//	echo 'res : '.$res.'<br/>';
	$nbligne=mysql_num_rows($res);
	$i=0;
//	echo 'i :'.$i.' à '.$nbligne.'<br/>';
	echo "<select name='lieu1'>";
	for($i;$i<$nbligne;$i++)
	{	$row = mysql_fetch_row($res);
		echo '<option>'.$row[0].'</option>';
	};
	echo '</select>';
}
function fsecure($fsaisi)
	{	$fsaisi1=strip_tags($fsaisi); // enleve les balises
		return $fsaisi1;
	}
?>