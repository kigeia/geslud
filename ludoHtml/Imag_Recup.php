<html>
<head></head>
<body>
<h1>Inventaire</h1>
<?php

$id = mysql_connect('localhost', 'philippe', 'ludo');
$id_db = mysql_select_db('geslud');

$result=mysql_query("SELECT * FROM te_article_art ORDER BY art_ID ASC");


while ($row = mysql_fetch_row($result))
{
?>
<table border=2 CELLPADDING=5 BORDERCOLOR="green">

	<tr>
		<td><?php
			echo "Id : ".$row[0]."";?>
		</td>
		<td ALIGN="center"><?php 
			echo "Désignation: ".$row[1].""; ?>
		</td>
	</tr>
	<tr>
		<td width = 50%>
		<?php 
			echo "BGG : ".$row[15]."<br>";
			
		?>
		</td>	
		
	</tr>
	
	<tr>
		<td>
		<?php 
			echo "VO : ".$row[16]."<br>";
			echo "Année: ".$row[18]."<br>";
			echo "Editeur: ".$row[19]."<br>";
		?>
		</td>	
		<td ALIGN="center">
		<?php 
		$dossier = '../images/';
			echo ('<img src="'.$dossier.''.$row[17].'" width="110" height="110" border=1 />');		
		?>
		</td>
	</tr>
	<br><br>
	
</table> 
<?php

}
mysql_close($id);


?>

</body> 
</html> 