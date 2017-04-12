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
			    <li><a href="home.html">Home</a></li>
			    <li><a href="#">Membership<span class="sub-arrow"></span></a>
					
  				  <ul>
	  				<li><a href="addmember.php">New Member</a></li>
			        <li><a href="displayrecords.php">Update Record</a></li>
					<li><a href="enquiries.php">Enquiries</a></li>
				  </ul>
		        
		        </li>
			     <li><a href="https://isms.wigalsolutions.com/ismsweb/#tologin" target="new">Send SMS</a></li>
                 <li><a href="<?php echo $logoutAction ?>">SIGN OUT</a></li>
			    </ul>
			</nav>
			</div>
			
			<div id="footerh">
				<h5>KMS Copyright @ 2017  All Rights Reserved</h5></br>
			</div>
		</div>
	</div>
	</body>
</html>