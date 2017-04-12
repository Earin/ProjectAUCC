<?php require_once('Connections/signup.php'); ?>
<?php error_reporting(E_ALL);
ini_set('display_errors', '1');
$search_output = "";
if(isset($_POST['searchquery']) && $_POST['searchquery'] != ""){
	$searchquery = preg_replace('#[^a-z 0-9?!]#i', '', $_POST['searchquery']);
	if($_POST['filter'] == "whole_data"){
		$sqlCommand = "SELECT FirstName, OtherNames, LastName, Mobile, Email, Grad_yr, Town_City FROM members WHERE Region LIKE '%$searchquery%'";
	} else if($_POST['filter'] == "spec_region"){
		$sqlCommand = "SELECT FirstName, OtherNames, LastName, Mobile, Email, Grad_yr, Town_City FROM members WHERE Region LIKE '%$searchquery%'";
	} else if($_POST['filter'] == "year_group"){
		$sqlCommand = "SELECT FirstName, OtherNames, LastName, Mobile, Email, Grad_yr, Town_City FROM members WHERE Region LIKE '%$searchquery%'";

	}
        include_once('Connections/signup.php');
        $query = mysql_query($sqlCommand) or die(mysql_error());
	$count = mysql_num_rows($query);
	if($count > 1){
		$search_output .= "<hr />$count results for <strong>$searchquery</strong><hr />$sqlCommand<hr />";
		while($row = mysql_fetch_array($query)){
	            $Member_ID = $row["Member_ID"];
		    $email = $row["email"];
		    $search_output .= "$Member_ID - $FirstName<br />";
                } // close while loop
	} else {
		$search_output = "<hr />0 results for <strong>$searchquery</strong><hr />$sqlCommand";
	}
}
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
<div id="rightside">
			  <form action="search.php" method="post">
              <input type="text" name="searchquery" id="search" placeholder="Search for members..." size="50">
              <input type="submit" value=">>" />
				</form> </br></br>
             Find Members in:
              <select name="filter">
                <option value="spec_region">Specific Region</option>
                <option value="year_group">Year group</option>
				</select> </br>
              
			<?php //echo $search_output;	?>
				
			</div>
            <div id="footerh">
				<h5>KMS Copyright @ 2017  All Rights Reserved</h5>
				</div>
		</div>
	</div>
</body>
</html>