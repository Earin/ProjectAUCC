<?php 
mysql_connect ('localhost','root','');

mysql_select_db('ucc_alumni');

$sql="SELECT Mobile, FirstName FROM members ORDER BY Mobile ASC";

$conreport=mysql_query($sql);

?>
  

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>UCCC Birthday</title>
<link href="css/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
		<a title="print screen" alt="print screen" onclick="window.print();"target="_blank" "style=cursor:pointer;>Print</a>
<div id="containerb">
		<table id="bday" width="150px" border="1" cellpadding="1" cellspacing="1">
<tr>
				
				<th>Mobile</th>
				<th>First Name</th>
				</tr>
<?php
				
				while ($members=mysql_fetch_assoc($conreport)) {
					
					echo "<tr>";
					
					echo "<td>".$members['Mobile']."</td>";
					echo "<td>".$members['FirstName']."</td>";
									
					echo "</tr>";
					
					
				}//end while
				
				
				?>
</body>
</html>