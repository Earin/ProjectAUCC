<?php

$output='';

if (isset ($_POST['searchquery']) && $_POST['searchquery'] !=""){
	
	$searchquery = preg_replace("#[^0-9a-z]#i","", $_POST['searchquery']);
	
	if ($_POST['filter']== "Specific Region"){
		$sqlCommand = "SELECT First Name, Other Names, Last Name, Town_City FROM members WHERE Region LIKE '%$searchquery%'";
	}else if($_POST['filter'] == "Year Group")
		$sqlCommand = "SELECT First Name, Other Names, Last Name, FROM members WHERE Grad_yr LIKE '%$searchquery%'";
}

mysql_connect("localhost", "root", "") or die("Error connecting to database: ".mysql_error());
mysql_select_db("ucc_alumni") or die(mysql_error());
$query = mysql_query($sqlCommand) or die(mysql_error());
$count = mysql_num_rows($query);
if ($count >1){
	$search_output .="<hr /> $count results for <strong>$searchquery</strong><hr />$sqlCommand<hr />";
		while ($row_fetch_array($query)){
			$id = $row["id"];
			$title= $row["title"];
			$search_output .="Item ID: $id - $title <br />";
		}
}else {$search_output ="<hr /> 0 results for <strong>$searchquery</strong><hr />$sqlCommand";}
	

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>UCC Connect</title>
<link href="css/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="containerh">
	  <div id="wrapperh">
			<div id="headerh">
			<h1>ALUMNI CONNECT</h1>	
			<img class="logo" src="images/logouc.png" width="325" height="155" alt=""/></div>
			<div id="sidenav">
		    <nav class="leftnav">
			  <ul class="navul">
			    <li><a href="home.html">General Report</a></li>
				  <li><a href="#">Contact Report</a></li>
					<li><a href="addmember.php">Region Report</a></li>
			        <li><a href="updatemember.php">Birthday Alert</a></li>
			 </ul>
		        
		        
			</nav>
			</div>
			<div id="rightside">
			  <form action="enquiries.php" method="post">
              <input type="text" name="search" id="search" placeholder="Search for members..." size="50">
              <input type="submit" value=">>" />
				</form> </br></br>
             Find Members in:
              <select name="filter">
                <option value="spec_region">Specific Region</option>
                <option value="year_group">Year group</option>
				</select> </br>
              
			<?php echo $search_output;	?>
				
			</div>
			<div id="footerh">
				<h5>Vinesoft Copyright @ 2017</h5></br>
				<h5>All Rights Reserved</h5>
			</div>
		</div>
	</div>
</body>
</html>