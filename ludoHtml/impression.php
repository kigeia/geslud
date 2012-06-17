<html>
<head>
<?php
function edition()
    {
    options = "Width=700,Height=700" ;
    window.open( "edition.php", "edition", options ) ;
    }

?>
</head>
<body>
<a href="edition.php" onclick="edition();return false;">Edition</a>
<script type="text/javascript">
  window.print() ;
 </script>
</body>
</html>