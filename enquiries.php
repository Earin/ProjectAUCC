<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
$search_output='';
$filter!="";
$sqlCommand!="";

if (isset ($_POST['searchquery']) && $_POST['searchquery'] !=""){
	
	$searchquery = preg_replace("#[^0-9a-z]#i","", $_POST['searchquery']);
	
	if ($_POST['filter']== "whole_data"){
		$sqlCommand = "SELECT FirstName, OtherNames, LastName, Mobile, Email, Grad_yr, Town_City FROM members WHERE Firstname OR LastName OR OtherNames LIKE '%$searchquery%'";
	}else if($_POST['filter'] == "spec_region"){
		$sqlCommand = "SELECT FirstName, OtherNames, LastName, Mobile, Email, Grad_yr, Town_City FROM members WHERE Region LIKE '%$searchquery%'";
	} else if($_POST['filter'] == "year_group"){
		$sqlCommand = "SELECT FirstName, OtherNames, LastName, Mobile, Email, Region FROM members WHERE Grad_yr LIKE '%$searchquery%'";
	}
require_once('Connections/signup.php'); 
$query = mysql_query($sqlCommand) or die(mysql_error());
$count = mysql_num_rows($query);
if ($count >1){
	$search_output .="<hr /> $count results for <strong>$searchquery</strong><hr />$sqlCommand<hr />";
		while ($row = mysql_fetch_array($query)){
			$Member_ID = $row["Member_ID"];
			$FirstName= $row["FirstName"];
			$search_output .= "Item ID: $Member_ID - $FirstName <br />";
		}
}else {$search_output ="<hr /> 0 results for <strong>$searchquery</strong><hr />$sqlCommand";}

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
			  <ul class="navul">
              <li><a href="home.php">HOME</a></li>
			    <li><a href="genr.php">General Report</a></li>
				  <li><a href="conreport.php">Contact Report</a></li>
					<li><a href="regreport.php">Region Report</a></li>
			        <li><a href="birthdayalerts.php">Birthday Alert</a></li>
                    <li><a href="<?php echo $logoutAction ?>">SIGN OUT</a></li>
			 </ul>
		        
		        
			</nav>
			</div>
			<div id="rightside">
            <div id="srchform">
			  <form action="enquiries.php" method="post">
              <input type="text" name="searchquery" id="search" placeholder="Search for members..." size="50">
              <input type="submit" value=">>" />
				</form> <br /><br />
             Find Members in:
              <select name="filter">
              	<option value="whole_data">All Members</option>
                <option value="spec_region">Specific Region</option>
                <option value="year_group">Year group</option>
				</select> 
              </br>
			  <div> <?php echo $search_output;	?> </div>
			</div>
			</div>
			<div id="footerh">
				<h5>KMS Copyright @ 2017  All Rights Reserved</h5>
			   </div>
		</div>
	</div>
</body>
</html>