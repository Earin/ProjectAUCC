<?php 
mysql_connect ('localhost','root','');

mysql_select_db('ucc_alumni');

$sql="SELECT * FROM members ORDER BY Member_ID ASC";

$genreport=mysql_query($sql);

?>
  


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>UCC Connect</title>
<link href="css/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
		<a title="print screen" alt="print screen" onclick="window.print();"target="_blank" "style=cursor:pointer;>Print</a>
	<div id="containerb">
				<table width="100%" border="1" cellpadding="1" cellspacing="1">
				<tr>
				<th>Member_ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Other Names</th>
				<th>Gender</th>
				<th>Date of Birth</th>
				<th>Town/City</th>
				<th>Region</th>
				<th>Email</th>
				<th>Mobile</th>
				<th>Address</th>
				<th>Image</th>
				<th>Program Read</th>
				<th>College</th>
				<th>Faculty</th>
				<th>Department</th>
				<th>Admission Year</th>
				<th>Graduation Year</th>
				</tr>
				<p>
				  <?php
				while ($members=mysql_fetch_assoc($genreport)) {
					
					echo "<tr>";
					echo "<td>".$members['Member_ID']."</td>";
					echo "<td>".$members['FirstName']."</td>";
					echo "<td>".$members['LastName']."</td>";
					echo "<td>".$members['OtherNames']."</td>";
					echo "<td>".$members['Gender']."</td>";
					echo "<td>".$members['DOB']."</td>";
					echo "<td>".$members['Town_City']."</td>";
					echo "<td>".$members['Region']."</td>";
					echo "<td>".$members['Email']."</td>";
					echo "<td>".$members['Mobile']."</td>";
					echo "<td>".$members['Address']."</td>";
					echo "<td>".$members['Picture']."</td>";
					echo "<td>".$members['Program_Read']."</td>";
					echo "<td>".$members['College']."</td>";
					echo "<td>".$members['Faculty']."</td>";
					echo "<td>".$members['Department']."</td>";
					echo "<td>".$members['Admin_yr']."</td>";
					echo "<td>".$members['Grad_yr']."</td>";
					echo "</tr>";
				
					
					
				}//end while
				
?>
                </p>
        <div id="footerh">
		  <h5>KMS Copyright @ 2017  All Rights Reserved</h5>
</div>		
	</body>
    
</html>


