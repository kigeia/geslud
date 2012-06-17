<?php									$selection1=''; $selection2=''; $selection3=''; $selection4=''; 
										$selection5=''; $selection6=''; $selection7=''; $point1='';
										if (isset ($_SESSION['page']))
										{	switch ($_SESSION['page'])
											{	case 'index':			$selection1='menuActuel';	$point1='';	$point2='./ludoHtml/';	break;
												case 'ludotheque':		$selection2='menuActuel';	$point1='../';	$point2='';	break;
												case 'inventaire':		$selection3='menuActuel';	$point1='../';	$point2='';	break;
												case 'creation_boite':	$selection3='menuActuel';	$point1='../';	$point2='';	break;
												case 'creation_carton':	$selection3='menuActuel';	$point1='../';	$point2='';	break;
												case 'maj':				$selection4='menuActuel';	$point1='../';	$point2='';	break;
												case 'manques':			$selection5='menuActuel';	$point1='../';	$point2='';	break;
												case 'suiviProjet':		$selection6='menuActuel';	$point1='../';	$point2='';	break;
												case 'liens':			$selection7='menuActuel';	$point1='../';	$point2='';	break;
												default:				$selection1='';
											}
										}

	echo	"<div class='hautPage'>
				<div class='zoneLogoHautGauche'>";
	echo		"<p><img src='".$point1."ludoImages/gesludLogo.gif' width='80' height='80' alt='reelLogo' position='middle'></p>";
?>
				</div>
				<div class="zoneBanniere">
					<!--	<img src="./ludoImages/reelBanniereSansLogo.jpg" width="100%" height="50" alt="reelBanniere">	-->
				</div>
				<div class="zoneTitreDoc"><h1>REEL - Gestion de la ludothèque</h1>
				</div>

<?php							if (isset($_SESSION['connexion']))
								{	if($_SESSION['connexion'] == 4)
									{
	echo		"<div class='zoneMenuHaut'>";
	echo				"<span class='texteZoneMenuHaut ".$selection1."'><a href='".$point1."index.php'>Accueil</a></span>";
										if ($_SESSION['usr_droit9']==1) {
	echo				"<span class='texteZoneMenuHaut ".$selection2."'><a href='".$point2."ludotheque.php'>Ludothèque</a></span>";}
										if ($_SESSION['usr_droit4']==1) {
	echo				"<span class='texteZoneMenuHaut ".$selection3."'><a href='".$point2."inventaire.php'>Inventaire</a></span>";}
										if ($_SESSION['usr_droit2']==1) {
	echo				"<span class='texteZoneMenuHaut ".$selection4."'><a href='".$point2."maj.php'>Mise à jour</a></span>"; }
										if ($_SESSION['usr_droit2']==1) {
	echo				"<span class='texteZoneMenuHaut ".$selection5."'><a href='".$point2."manques.php'>Manques</a></span>"; }
										if ($_SESSION['usr_droit9']==1) {
	echo				"<span class='texteZoneMenuHaut ".$selection6."'><a href='".$point2."suiviProjet.php'>Suivi du Projet</a></span>"; }
										if ($_SESSION['usr_droit9']==1) {
	echo				"<span class='texteZoneMenuHaut ".$selection7."'><a href='".$point2."liens.php'>Liens</a></span>";}
	echo		"</div>
				<div class='zoneLogin'>";
	echo				 " Vous êtes connecté en tant que : <span style='color:blue'>",$_SESSION['logingeslud'],". </span>";
	echo				 " Pour vous déconnecter, cliquez <a href='".$point2."include/finSession.php'>ici</a>."; // On n'oublie pas cette fonctionnalité primordiale !
	echo		'</div>';
									}
								} // fin test existance variable connexion
?>
			</div>
