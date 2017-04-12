<?php 
mysql_connect ('localhost','root','');

mysql_select_db('ucc_alumni');

$sql="SELECT FirstName, LastName, OtherNames, Town_City, Region FROM members ORDER BY Region ASC";

$regreport=mysql_query($sql);

?>
  


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>UCC Connect</title>
<link href="css/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="containerb">
	<a title="print screen" alt="print screen" onclick="window.print();"target="_blank" "style=cursor:pointer;>Print</a>
		
				<table width="100%" border="1" cellpadding="1" cellspacing="1">
				<tr>
				
				<th>First Name</th>
				<th>Last Name</th>
				<th>Other Names</th>
				<th>Town/City</th>
				<th>Region</th>
				
				</tr>
				
				<?php
				while ($members=mysql_fetch_assoc($regreport)) {
					
					echo "<tr>";
					
					echo "<td>".$members['FirstName']."</td>";
					echo "<td>".$members['LastName']."</td>";
					echo "<td>".$members['OtherNames']."</td>";
					echo "<td>".$members['Town_City']."</td>";
					echo "<td>".$members['Region']."</td>";
										
					echo "</tr>";
					
					
				}//end while
				
				
				?>
			</div>
			
	</body>
    <div id="footerh">
				<h5>KMS Copyright @ 2017  All Rights Reserved</h5>
			</div>
</html>


