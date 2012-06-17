<?php							include_once("ludoHtml/include/connexion1.php"); // connexion à la BDD
								include_once("ludoHtml/include/fonctions.inc.php");
								$connexion=0;
								if(!isset($_POST['verif']))
								{	$connexion=0; // au chargement de la page (formulaire non reçu
	echo 'Veuillez vous identifier :<br/>';
?>
	<form name='formulaireconnexion' method='post' action='index.php'>
		login 	<input name='logingeslud' type='text' class='texte' value='visiteur' size='24' maxlength='20' selected><br/><br/>
		mdp 		<input name='mdpgeslud' type='password' class='texte' value='visiteur' size='15' maxlength='10'><br/>
		<br/><br/><input name='Corriger' type='reset' class='boutondroite' value='Effacer'>
		<input name='envoyer' type='submit' class='boutondroite' value='Se connecter'>
		<input name='verif' type='hidden'><br/><br/>
	</form>
<?php							} // fin if formulaire non reçu
								else
								{	if(!isset($_POST['logingeslud']) OR !isset($_POST['mdpgeslud']))
									{	$connexion=2;  // si login et/ou mdp absent
?>
	<form name='formulaireconnexion' method='post' action='index.php'>
		login 	<input name='logingeslud' type='text' class='texte' value='visiteur' size='24' maxlength='20'  selected><br/><br/>
		mdp 	<input name='mdpgeslud' type='text' class='texte' value='visiteur' size='15'maxlength='10'><br/>
		<br/><br/><input name='Corriger' type='reset' class='boutondroite' value='Effacer'>
		<input name='envoyer' type='submit' class='boutondroite' value='Se connecter'>
		<input name='verif' type='hidden'><br/><br/>
	</form>
	<span class='erreurlogin'>
		Vous avez du faire une erreur<br/> 
		dans le login ou le mot de passe.</span><br/>
		Vous pouvez réessayer ci-dessus<br/><br/>
<?php								} // fin if login ou mdp absent
									else
									{	$login=fsecure($_POST['logingeslud']); // si login et mot de passe présents
										$mdp=fsecure($_POST['mdpgeslud']);
										$requete=mysql_query("SELECT COUNT(*) AS nbre FROM te_utilisateur_usr WHERE usr_LIB='$login' AND usr_mdp='$mdp'");
											// echo $requete.' : requete test1';
										$res = mysql_fetch_array($requete);
											 // echo $res.' : requete test';
										if ($res['nbre']!=1) 
										{	$connexion=2; // couple (login / mot de passe) erronné


?>			<form name='formulaireconnexion' method='post' action='index.php'>
				login 	<input name='logingeslud' type='text' class='texte' value='visiteur' size='24' maxlength='20'  selected><br/><br/>
				mdp 	<input name='mdpgeslud' type='password' class='texte' value='visiteur' size='15'maxlength='10'><br/>
				<br/><br/><input name='Corriger' type='reset' class='boutondroite' value='Effacer'>
				<input name='envoyer' type='submit' class='boutondroite' value='Se connecter'>
				<input name='verif' type='hidden'><br/><br/>
			</form>
				<span class='erreurlogin'>Vous avez du faire une erreur<br/> dans le login ou le mot de passe.</span><br/>
				Vous pouvez réessayer ci-dessus<br/><br/>
<?php										
										}
										else
										{	$connexion=4; // login et mdp OK
											$requete1=mysql_query("SELECT usr_ID,usr_type,usr_droit1,usr_droit2,usr_droit3,usr_droit4,usr_droit5,usr_droit6,usr_droit7,usr_droit8,usr_droit9 FROM te_utilisateur_usr WHERE usr_LIB ='$login'"); // recherche identifiant dans la BDD
											while(list($usr_ID,$usr_type,$usr_droit1,$usr_droit2,$usr_droit3,$usr_droit4,$usr_droit5,$usr_droit6,$usr_droit7,$usr_droit8,$usr_droit9)=mysql_fetch_array($requete1))
											{	$_SESSION['logingeslud']=$login;
												$_SESSION['type_utilisateur']=$usr_type;
												$_SESSION['utilisateur_ID']=$usr_ID;
												$_SESSION['usr_droit1']=$usr_droit1; // administrateur
												$_SESSION['usr_droit2']=$usr_droit2; // insert et update dans BDD
												$_SESSION['usr_droit3']=$usr_droit3;
												$_SESSION['usr_droit4']=$usr_droit4; // fonctions liées à l'inventaire
												$_SESSION['usr_droit5']=$usr_droit5;
												$_SESSION['usr_droit6']=$usr_droit6;
												$_SESSION['usr_droit7']=$usr_droit7;
												$_SESSION['usr_droit8']=$usr_droit8;
												$_SESSION['usr_droit9']=$usr_droit9; // visiteur
												$_SESSION['connexion']=4;
												// echo $_SESSION['connexion'].': connexion';
											}
	echo "<br/>Vous êtes connecté en tant que : <span style='color:blue'>".$login."</span> . <br/><br/>";
	echo " Pour vous déconnecter, cliquez <a href='./ludoHtml/include/finSession.php'>ICI</a>.";
										require('ludoHtml/include/menu.inc.php');
										} // fin else connexion OK
									} // fin else login et mot de passe présents
								} // fin else formulaire reçu
?>