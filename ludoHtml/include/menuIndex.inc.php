	<div class="hautPage">
																		
			<div class="zoneLogoHautGauche">
				<p><img src="./ludoImages/gesludLogo.gif" width="80" height="80" alt="reelLogo" position="middle"></p>
			</div>
			<div class="zoneBanniere">
<!--				<img src="./ludoImages/reelBanniereSansLogo.jpg" width="100%" height="50" alt="reelBanniere">	-->
			</div>
			<div class="zoneTitreDoc"><h1>REEL - Gestion de la ludothèque</h1>
			</div>
<?php									if (isset($_SESSION['connexion']))
										{	if ($_SESSION['connexion'] == 4)
											{
?>
			<div class="zoneMenuHaut">

<?php
//					if ($_SESSION['page']=='index')
//					{	$selection1='menuActuel';}
//					else
//					{	$selection1='menuActuel'; }
//					echo "$selection1";
//					echo"<span class='texteZoneMenuHaut".$selection1."'><a href='./index.php'>Accueil</a></span>";
?>
				<span class='texteZoneMenuHaut menuActuel'><a href='./index.php'>Accueil</a></span>
				<span class='texteZoneMenuHaut'><a href='./ludoHtml/ludotheque.php'>Ludothèque</a></span>
				<span class='texteZoneMenuHaut'><a href='./ludoHtml/inventaire.php'>Inventaire</a></span>
				<span class='texteZoneMenuHaut'><a href='./ludoHtml/maj.php'>Mise à jour</a></span>
				<span class='texteZoneMenuHaut'><a href='./ludoHtml/manques.php'>Manques</a></span>
				<span class='texteZoneMenuHaut'><a href='./ludoHtml/suiviProjet.php'>Suivi Projet</a></span>
				<span class='texteZoneMenuHaut'><a href='./ludoHtml/liens.php'>Liens</a></span>
			</div>
			<div class="zoneLogin">
<?php									if($_SESSION['connexion'] == 4)
											{	
											//					echo 'connexion test 5 : ',$_SESSION['connexion'],'<br/><br/>';
											echo " vous êtes connecté en tant que : <span style='color:blue'>",$_SESSION['logingeslud'],"</span>";
											//						echo $_SESSION['type_utilisateur'];
											echo " Pour vous déconnecter, cliquez <a href='./ludoHtml/include/finSession.php'>ICI</a>."; // On n'oublie pas cette fonctionnalité primordiale !
											}
	echo '	</div>';
				}
			}
?>
	</div>
