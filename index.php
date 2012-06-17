<?php									session_start();
										$_SESSION['page'] = 'index';	// mise en cache du num de page pour onglet coloré
?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
		"http://www.w3.org/TR/html4/loose.dtd">
	<!-- Start cu3ox.com HEAD section -->
		<script language="JavaScript" src="engine/swfobject.js" type="text/javascript"></script>
	<!-- End cu3ox.com HEAD section -->

	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"  /> 
		<Style Type="text/css">
			@import url(ludoCss/stylesAccueil2.css);
			@import url(ludoCss/index.css);
		</style>
		<title>REEL - Gestion de la ludothèque</title>
		<meta name="Robots" content="noindex, nofollow">
		<meta name="description" lang="fr" content="gestion de la ludothèque de Reel">
		<meta name="keywords" lang="fr" content="Reel,Ludothèque">
		<meta http-equiv="pragma" content="no-cache";>
	</head>
	<body>
	<div class="bodystyle">
<?php							include_once("ludoHtml/include/menu.inc.php");
								include_once("ludoHtml/include/varGlob.inc.php");
 ?>
				<br/><div class='titre'><h5>Gestion Ludo - Accueil</h5></div>
<!--	------------------------DEBUT DU CORPS DE LA PAGE-----------------------------------------------------------	-->	
		<div class="zoneCorpsDoc">
			<div class='texteGauche'>
				<p>Voici un petit site sans prétention dont l'objet est :<br/>
					"L'informatisation de la gestion de la ludothèque de l'association REEL".
					<br/><br/>
					Pour les membres de la commission "informatisation ludothèque", ce site permet de suivre les mises à jour des documents liés au projet.
					<br/>
					Pour le webmaster, ce site permet de s'initier à la mise en ligne d'un site internet.
					<br/>
					Le site permet également de satisfaire la curiosité des autres éventuels visiteurs.</p>
			</div>

	<!-- Start cu3ox.com BODY section id=cu3ox1 -->
		<div id="cu3ox1" style="width:279px;height:168px" class='droite'>
			<script language="JavaScript" type="text/javascript">
				var cu3oxId = ("cu3ox" + Math.random()).replace(".","");
				document.write('<div id ="' + cu3oxId + '" style="text-align:center;"><img src="data/images1/geslud.jpg"/></div>');
				if (swfobject.getFlashPlayerVersion().major)
					swfobject.createSWF(
					  {data:"engine/cu3ox.swf", width:"100%", height:"100%" },
					  {FlashVars:"images=data/images1&cfgsuffix=1",menu:true, allowFullScreen:false, allowScriptAccess:'sameDomain', wmode:"transparent", bgcolor:'#FFFFFF', 
					   devicefont:false, scale:'noscale', loop:true, play:true, quality:'high'}, cu3oxId);
			</script>
				<a style="display:none" href="http://cu3ox.com">Flash Thumb Slider by cu3ox.com v1.8</a><noscript>
				<!--[if !IE]> -->
				<object type="application/x-shockwave-flash" data="engine/cu3ox.swf" width="100%" height="100%"  align="middle">
					<!-- <![endif]-->
					<!--[if IE]>
					<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0"
						width="100%" height="100%"  align="middle">
						<param name="movie" value="engine/cu3ox.swf" />
					<!-->
					<param name="FlashVars" value="images=data/images1&cfgsuffix=1" />
					<param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="false" />
					<param name="quality" value="high"/><param name="scale" value="noscale"/>
					<param name="wmode" value="transparent" />
					<param name="bgcolor" value="#ffffff" />
					<img src="data/images1/geslud.jpg"/>
				</object>
				<!-- <![endif]-->
			</noscript>
		</div>
	<!-- End cu3ox.com BODY section -->
<!--		<div class='droite'>
				<p align="center"><img src="./ludoImages/gesludLogo.gif" width="250px" ></p>
			</div>
-->
			<div class='gauche'>
				<p align="center"><img src="ludoImages/ludoParthenay.jpg"></p>
			</div>
			<div class='texteDroite'>
<?php
								if(!isset($_SESSION['logingeslud']))
								{	include_once("ludoHtml/include/login.inc.php");
								}
								if(isset($_POST['logingeslud']))
								{	
	// recherche rapide d'un jeu
	echo	"<form action='ludoHtml/resultat_recherche.php' method='post'>";
	echo 		"<br/><br/><p style='color:darkblue'>Pour une recherche rapide sur le jeu "
				."<input type='texte' name='jeu' id='jeu' size='22' maxlength='20' placeholder='Ex : Himalaya'/>";
	echo 		"<input type='submit' name='X' value='go' class='ok'/></p>
			</form>";
								}

echo '		</div>';
echo '	</div>';
echo '</div>';
								require("ludoHtml/include/piedpage.inc.php");
?>
	</body></html>
