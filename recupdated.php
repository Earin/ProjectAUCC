<?php require_once('Connections/signup.php'); ?>
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
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "updatemember")) {
  $updateSQL = sprintf("UPDATE members SET `FirstName`=%s, `OtherNames`=%s, `LastName`=%s, Gender=%s, DOB=%s, Town_City=%s, Region=%s, Email=%s, Mobile=%s, Address=%s, Picture=%s, Program_Read=%s, College=%s, Faculty=%s, Department=%s, Admin_yr=%s, Grad_yr=%s WHERE Member_ID=%s",
                       GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['o_names'], "text"),
                       GetSQLValueString($_POST['lname'], "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['dob'], "date"),
                       GetSQLValueString($_POST['town_city'], "text"),
                       GetSQLValueString($_POST['region'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['mobile'], "int"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['image'], "text"),
                       GetSQLValueString($_POST['prog_read'], "text"),
                       GetSQLValueString($_POST['college'], "text"),
                       GetSQLValueString($_POST['faculty'], "text"),
                       GetSQLValueString($_POST['dept'], "text"),
                       GetSQLValueString($_POST['adm_yr'], "date"),
                       GetSQLValueString($_POST['grad_yr'], "date"),
                       GetSQLValueString($_POST['mID'], "int"));

  mysql_select_db($database_signup, $signup);
  $Result1 = mysql_query($updateSQL, $signup) or die(mysql_error());

  $updateGoTo = "home.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_signup, $signup);
$query_updaterec = "SELECT * FROM members WHERE `FirstName` = 'First Name'";
$updaterec = mysql_query($query_updaterec, $signup) or die(mysql_error());
$row_updaterec = mysql_fetch_assoc($updaterec);
$totalRows_updaterec = mysql_num_rows($updaterec);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>UCC Connect</title>
<link href="css/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="container">
		<div id="wrapper">
			<div id="header"><img class="logo" src="images/logouc.png" width="376" height="164" alt=""/>	
			</div>
			<div id="content">
			<nav id="sub">
			<li><a href="home.php"> Home</a></li>
			<li><a href="<?php echo $logoutAction ?>" button> Sign out</a></li>
			</nav>
			  <h2>Record Updated Successfully</h2>				
		  </div>
			<div id="footer">
           		<h5>KMS Copyright @ 2017  All Rights Reserved</h5>
			</div>
		</div>
	</div>
	</body>
</html>
<?php
mysql_free_result($updaterec);
?>
