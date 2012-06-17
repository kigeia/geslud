<?php
// On défini ici l'ensemble des constantes qui seront utilisées dans le projet.
// On les retrouve ainsi très facilement 
// et cela permet de paramétrer tout le programme à partir d'un seul fichier
define('LOGIN_VALIDE', 'dom');
define ('MDP_VALIDE', 'dom');

//connecteurs BDD
define("URL_BDD","localhost");
define("NOM_BDD","geslud");
define("LOGIN_BDD","philippe");
define("MDP_BDD","ludo");

// type utilisateurs du LOGICIEL
define ("TYPE_ADMIN", 1);
define ("TYPE_CA", 2);
define ("TYPE_RESPCREATIONARTICLE", 3);
define ("TYPE_RESPIVENTAIRE", 4);
define ("TYPE_RESPMANQUE", 5);
define("TYPE_VISITEUR", 9);

?>