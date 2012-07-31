<html>

<head>
	<title>Cardiff Physx Simple Poll System</title>
	<link rel="stylesheet" type="text/css" href="css/poll.css"/>
</head>

<body>
<?php
require_once("header.php");
?>
	<table id="tblResultsMain" align="center">
	     <tr>
		<td class="header"></td>
	     </tr>
	     <tr>
		<td>
		     <?php
			include "savevote.php";
		     ?>
		</td>
	     </tr>
	     <tr>
			<td class="footer"></a></td>
	     </tr>
	</table>
</body>

</html>