<?php
function look($repère)
{	
						$fichierespion=$repère.'.html';
echo "<a style='background-color:yellow' href='".$fichierespion."' target='_blank'>".$fichierespion."</a><br/>";

// -------------creation des variables à écrire dans le fichier espion ------------------------------
$doctype='
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
	<html><head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"  /> 
	<title>'.$repère.'</title>
	<meta http-equiv="pragma" content="no-cache"/>
	</head><body>';

$creatableau="<div>
		<table border='4' cellspacing='0'>
			<tr>	<th>origine</th>
					<th>type de variable</th>
					<th>col4</th>
					<th>col5</th>
			</tr>";
$crealigne='
<tr><td>';
$creacolonne='
</td><td>';
$fermetureligne='
</td></tr>';
$fermeturetableau='
</table></div>';
$finbody='
</body>';

$fic=fopen($fichierespion,"w+");
fputs($fic, $doctype);
// -------------code d'affichage des variables ------------------------------
fputs($fic, 'fichier : '.__FILE__);
fputs($fic, $creatableau);
						foreach($GLOBALS as $variable => $valeur)
						{	if($variable!='GLOBALS')
							{
fputs($fic, $crealigne);
							$a='';
							if(gettype($valeur)!='array'){$a='var. locale';fputs($fic, $a);}else{$a=$variable;fputs($fic, $a);}
fputs($fic, $creacolonne);
							$b='';
							$b=gettype($valeur);fputs($fic, $b);
fputs($fic, $creacolonne);
							$c='';
							if(gettype($valeur)!='array'){$c=$variable;fputs($fic, $c);} else
							{foreach($valeur as $variables => $valeurs){$c=$variables.'<br/>';fputs($fic, $c);}}
fputs($fic, $creacolonne);
							$d='';
							if (gettype($valeur)!='array'){if($valeur!=''){$d=$valeur.'<br/>';fputs($fic, $d);} else {$d='[vide]';fputs($fic, $d);}} else
							foreach($valeur as $variables => $valeurs){$d=$valeurs.'<br/>';fputs($fic, $d);}
fputs($fic, $fermetureligne);
							} // fin if(!$variable=='GLOBALS')
						}
fputs($fic, $fermeturetableau);
fputs($fic, $finbody);
fclose($fic);



}
?>