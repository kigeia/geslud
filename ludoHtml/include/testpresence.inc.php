<?php
function testpresence($variable)
{	if(isset($_POST['$variable']))
		{	$variable=$_POST['$variable']; } // fin if
	else { $variable=''; } // fin else

	if(isset($_GET['$variable']))
	{	$login=$_GET['$variable']; } // fin if							//
	else { $variable==''; }; // fin else

	return $variable;
?>
